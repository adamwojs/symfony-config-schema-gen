<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node;

use ReflectionObject;
use Symfony\Component\Config\Definition\NumericNode;
use Symfony\Component\Config\Definition\ScalarNode;

class NumericNodeNormalizer extends ScalarNodeNormalizer
{
    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof NumericNode;
    }

    protected function getValueSchema(ScalarNode $node, string $format = null, array $context = []): array
    {
        $schema = [
            'type' => 'number',
        ];

        [$minValue, $maxValue] = $this->getMinMaxValue($node);

        if ($minValue !== null) {
            $schema['exclusiveMinimum'] = $minValue;
        }

        if ($maxValue !== null) {
            $schema['exclusiveMaximum'] = $maxValue;
        }

        return $schema;
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
