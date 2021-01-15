<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node;

use Symfony\Component\Config\Definition\EnumNode;

class EnumNodeNormalizer extends ScalarNodeNormalizer
{
    /**
     * @param \Symfony\Component\Config\Definition\EnumNode $node
     */
    public function normalize($node, string $format = null, array $context = [])
    {
        $schema = parent::normalize($node, $format, $context);
        $schema['enum'] = $node->getValues();

        unset($schema['$ref']);

        return $schema;
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof EnumNode;
    }
}
