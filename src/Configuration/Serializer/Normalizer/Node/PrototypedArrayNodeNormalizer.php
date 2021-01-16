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
     * @param \Symfony\Component\Config\Definition\PrototypedArrayNode $node
     */
    public function normalize($node, string $format = null, array $context = [])
    {
        $schema = parent::normalize($node, $format, $context);

        $prototypeSchema = $this->normalizer->normalize($node->getPrototype(), $format, $context);

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

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof PrototypedArrayNode;
    }
}
