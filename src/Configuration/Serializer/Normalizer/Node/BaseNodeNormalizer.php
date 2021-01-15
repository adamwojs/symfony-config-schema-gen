<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node;

use Symfony\Component\Config\Definition\BaseNode;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class BaseNodeNormalizer implements NormalizerInterface
{
    /**
     * @param \Symfony\Component\Config\Definition\BaseNode $node
     */
    public function normalize($node, string $format = null, array $context = [])
    {
        $schema = [];

        if ($node->getInfo() !== null) {
            $schema['description'] = $node->getInfo();
        }

        if ($node->getExample() !== null) {
            $schema['examples'] = [$node->getExample()];
        }

        return $schema;
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof BaseNode;
    }
}
