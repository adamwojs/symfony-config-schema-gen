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
    public function normalize($object, string $format = null, array $context = [])
    {
        return $this->normalizer->normalize(
            $object->getConfigTreeBuilder()->buildTree(),
            $format,
            $context
        );
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof ConfigurationInterface;
    }
}
