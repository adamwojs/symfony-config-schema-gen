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
     * @param \Symfony\Component\Config\Definition\ArrayNode $data
     */
    public function normalize(mixed $data, string $format = null, array $context = []): float|int|bool|\ArrayObject|array|string|null
    {
        $schema = parent::normalize($data, $format, $context);
        $schema['type'] = 'object';
        $schema['properties'] = [];
        $schema['required'] = [];

        foreach ($data->getChildren() as $child) {
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

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof ArrayNode;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            ArrayNode::class => false,
        ];
    }
}
