<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node;

use Symfony\Component\Config\Definition\IntegerNode;

class IntegerNodeNormalizer extends NumericNodeNormalizer
{
    /**
     * @param \Symfony\Component\Config\Definition\IntegerNode $object
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $schema = parent::normalize($object, $format, $context);
        $schema['type'] = 'integer';

        return $schema;
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof IntegerNode;
    }
}
