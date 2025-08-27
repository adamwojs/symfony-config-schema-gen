<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node;

use Symfony\Component\Config\Definition\BaseNode;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class BaseNodeNormalizer implements NormalizerInterface
{
    /**
     * @param \Symfony\Component\Config\Definition\BaseNode $data
     */
    public function normalize(mixed $data, string $format = null, array $context = []): float|int|bool|\ArrayObject|array|string|null
    {
        $schema = [];

        if ($data->getInfo() !== null) {
            $schema['description'] = $data->getInfo();
        }

        if ($data->getExample() !== null) {
            $schema['examples'] = [$data->getExample()];
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
