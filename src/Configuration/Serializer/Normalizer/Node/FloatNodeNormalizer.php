<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node;

use Symfony\Component\Config\Definition\FloatNode;

class FloatNodeNormalizer extends NumericNodeNormalizer
{
    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof FloatNode;
    }
}
