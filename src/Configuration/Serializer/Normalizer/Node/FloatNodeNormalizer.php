<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node;

use Symfony\Component\Config\Definition\FloatNode;

class FloatNodeNormalizer extends NumericNodeNormalizer
{
    /**
     * @param \Symfony\Component\Config\Definition\FloatNode $object
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        return parent::normalize($object, $format, $context);
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof FloatNode;
    }
}
