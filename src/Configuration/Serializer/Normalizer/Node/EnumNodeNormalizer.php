<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node;

use Symfony\Component\Config\Definition\EnumNode;

class EnumNodeNormalizer extends BaseNodeNormalizer
{
    public function normalize($node, string $format = null, array $context = [])
    {
        $schema = parent::normalize($node, $format, $context);
        $schema['anyOf'] = [
            [
                'enum' => $node->getValues(),
            ],
            [
                '$ref' => '#/definitions/parameter',
            ],
        ];

        if ($node->hasDefaultValue()) {
            $schema['default'] = $node->getDefaultValue();
        }

        return $schema;
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof EnumNode;
    }
}
