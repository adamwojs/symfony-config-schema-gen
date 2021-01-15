<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node;

use ReflectionObject;
use Symfony\Component\Config\Definition\NumericNode;

class NumericNodeNormalizer extends ScalarNodeNormalizer
{
    /**
     * @param \Symfony\Component\Config\Definition\NumericNode $node
     */
    public function normalize($node, string $format = null, array $context = [])
    {
        $schema = parent::normalize($node, $format, $context);
        $schema['type'] = 'number';

        [$minValue, $maxValue] = $this->getMinMaxValue($node);

        if ($minValue !== null) {
            $schema['exclusiveMinimum'] = $minValue;
        }

        if ($maxValue !== null) {
            $schema['exclusiveMaximum'] = $maxValue;
        }

        unset($schema['$ref']);

        return $schema;
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof NumericNode;
    }

    private function getMinMaxValue(NumericNode $node): array
    {
        $reflection = new ReflectionObject($node);

        $minProperty = $reflection->getProperty('min');
        $minProperty->setAccessible(true);

        $maxProperty = $reflection->getProperty('max');
        $maxProperty->setAccessible(true);

        $minValue = $minProperty->getValue($node);
        $maxValue = $maxProperty->getValue($node);

        return [$minValue, $maxValue];
    }
}
