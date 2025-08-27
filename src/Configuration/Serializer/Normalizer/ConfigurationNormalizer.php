<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class ConfigurationNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * @param \Symfony\Component\Config\Definition\ConfigurationInterface $object
     */
    public function normalize(mixed $object, string $format = null, array $context = []): float|int|bool|\ArrayObject|array|string|null
    {
        return $this->normalizer->normalize(
            $object->getConfigTreeBuilder()->buildTree(),
            $format,
            $context
        );
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof ConfigurationInterface;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            ConfigurationInterface::class => false,
        ];
    }
}
