<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node;

use Symfony\Component\Config\Definition\ArrayNode;
use Symfony\Component\Config\Definition\PrototypedArrayNode;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;

class PrototypedArrayNodeNormalizer extends BaseNodeNormalizer implements NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    public function normalize($node, string $format = null, array $context = [])
    {
        $schema = parent::normalize($node, $format, $context);

        $prototype = $node->getPrototype();

        if ($prototype instanceof ArrayNode) {
            $schema['type'] = 'object';
            $schema['additionalProperties'] = $this->normalizer->normalize($prototype, $format, $context);
        } else {
            $schema['type'] = 'array';
            $schema['items'] = $this->normalizer->normalize($prototype, $format, $context);
        }

        return $schema;
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof PrototypedArrayNode;
    }
}
