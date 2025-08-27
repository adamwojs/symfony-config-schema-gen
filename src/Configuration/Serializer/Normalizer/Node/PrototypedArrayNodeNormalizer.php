<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node;

use Symfony\Component\Config\Definition\PrototypedArrayNode;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;

class PrototypedArrayNodeNormalizer extends BaseNodeNormalizer implements NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * @param \Symfony\Component\Config\Definition\PrototypedArrayNode $data
     */
    public function normalize(mixed $data, string $format = null, array $context = []): float|int|bool|\ArrayObject|array|string|null
    {
        $schema = parent::normalize($data, $format, $context);

        $prototypeSchema = $this->normalizer->normalize($data->getPrototype(), $format, $context);

        $schema['oneOf'] = [
            [
                'type' => 'array',
                'items' => $prototypeSchema,
            ],
            [
                'type' => 'object',
                'additionalProperties' => $prototypeSchema,
            ],
        ];

        return $schema;
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof PrototypedArrayNode;
    }
}
