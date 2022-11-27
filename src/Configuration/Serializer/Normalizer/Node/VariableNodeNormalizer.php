<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node;

use Symfony\Component\Config\Definition\VariableNode;

final class VariableNodeNormalizer extends BaseNodeNormalizer
{
    public function normalize($node, string $format = null, array $context = [])
    {
        $schema = parent::normalize($node, $format, $context);
        $schema['$ref'] = '#/definitions/variable_or_parameter';

        return $schema;
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof VariableNode;
    }
}
