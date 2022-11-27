<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node;

use Symfony\Component\Config\Definition\IntegerNode;

class IntegerNodeNormalizer extends NumericNodeNormalizer
{
    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof IntegerNode;
    }

    protected function getValueBaseType(): string
    {
        return 'integer';
    }

    protected function getValueDefaultDefinitionRef(): string
    {
        return '#/definitions/integer_or_parameter';
    }
}
