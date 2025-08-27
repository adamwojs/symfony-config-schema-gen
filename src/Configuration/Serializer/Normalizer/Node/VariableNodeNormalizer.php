<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node;

use Symfony\Component\Config\Definition\VariableNode;

final class VariableNodeNormalizer extends BaseNodeNormalizer
{
    public function normalize(mixed $data, string $format = null, array $context = []): float|int|bool|\ArrayObject|array|string|null
    {
        $schema = parent::normalize($data, $format, $context);
        $schema['$ref'] = '#/definitions/variable_or_parameter';

        return $schema;
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof VariableNode;
    }
}
