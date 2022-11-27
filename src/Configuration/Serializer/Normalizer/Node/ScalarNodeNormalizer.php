<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node;

use Symfony\Component\Config\Definition\ScalarNode;

class ScalarNodeNormalizer extends BaseNodeNormalizer
{
    /**
     * @param \Symfony\Component\Config\Definition\ScalarNode $node
     */
    public function normalize($node, string $format = null, array $context = [])
    {
        $schema = parent::normalize($node, $format, $context);
        $schema['$ref'] = '#/definitions/scalar_or_parameter';

        if ($node->hasDefaultValue()) {
            $schema['default'] = $node->getDefaultValue();
        }

        return $schema;
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof ScalarNode;
    }
}
