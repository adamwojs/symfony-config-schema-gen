<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node;

use Symfony\Component\Config\Definition\BooleanNode;

class BooleanNodeNormalizer extends ScalarNodeNormalizer
{
    /**
     * @param \Symfony\Component\Config\Definition\BooleanNode $object
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $schema = parent::normalize($object, $format, $context);
        $schema['type'] = 'boolean';

        unset($schema['$ref']);

        return $schema;
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof BooleanNode;
    }
}
