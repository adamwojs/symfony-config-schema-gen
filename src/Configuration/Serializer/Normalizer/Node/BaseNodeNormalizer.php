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
    public function normalize(mixed $node, string $format = null, array $context = []): float|int|bool|\ArrayObject|array|string|null
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

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof BaseNode;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            BaseNode::class => false,
        ];
    }
}
