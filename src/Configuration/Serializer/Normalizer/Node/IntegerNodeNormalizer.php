<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node;

use Symfony\Component\Config\Definition\IntegerNode;
use Symfony\Component\Config\Definition\ScalarNode;

class IntegerNodeNormalizer extends NumericNodeNormalizer
{
    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof IntegerNode;
    }

    /**
     * @param \Symfony\Component\Config\Definition\IntegerNode $object
     */
    protected function getValueSchema(ScalarNode $node, string $format = null, array $context = []): array
    {
        $schema = parent::getValueSchema($node, $format, $context);
        $schema['type'] = 'integer';

        return $schema;
    }
}
