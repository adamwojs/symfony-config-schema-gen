<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node;

use ReflectionObject;
use Symfony\Component\Config\Definition\NumericNode;

class NumericNodeNormalizer extends BaseNodeNormalizer
{
    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof NumericNode;
    }

    public function normalize($node, string $format = null, array $context = [])
    {
        $schema = parent::normalize($node, $format, $context);

        [$minValue, $maxValue] = $this->getMinMaxValue($node);

        if ($minValue === null && $maxValue === null) {
            $schema['$ref'] = $this->getValueDefaultDefinitionRef();
        } else {
            $schema['anyOf'] = [
                $this->getValueSchema($minValue, $maxValue),
                [
                    '$ref' => '#/definitions/parameter',
                ],
            ];
        }

        if ($node->hasDefaultValue()) {
            $schema['default'] = $node->getDefaultValue();
        }

        return $schema;
    }

    protected function getValueDefaultDefinitionRef(): string
    {
        return '#/definitions/numeric_or_parameter';
    }

    protected function getValueBaseType(): string
    {
        return 'number';
    }

    private function getValueSchema($minValue, $maxValue): array
    {
        $schema = [
            'type' => $this->getValueBaseType(),
        ];

        if ($minValue !== null) {
            $schema['minimum'] = $minValue;
        }

        if ($maxValue !== null) {
            $schema['maximum'] = $maxValue;
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
