<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node;

use Symfony\Component\Config\Definition\ArrayNode;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;

class ArrayNodeNormalizer extends BaseNodeNormalizer implements NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * @param \Symfony\Component\Config\Definition\ArrayNode $node
     */
    public function normalize($node, string $format = null, array $context = [])
    {
        $schema = parent::normalize($node, $format, $context);
        $schema['type'] = 'object';
        $schema['properties'] = [];
        $schema['required'] = [];

        foreach ($node->getChildren() as $child) {
            $schema['properties'][$child->getName()] = $this->normalizer->normalize($child, $format, $context);

            if ($child->isRequired() && $context['strict'] === true) {
                $schema['required'][] = $child->getName();
            }
        }

        if (empty($schema['properties'])) {
            unset($schema['properties']);
        }

        if (empty($schema['required'])) {
            unset($schema['required']);
        }

        $schema['additionalProperties'] = !$context['strict'];

        return $schema;
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof ArrayNode;
    }
}
