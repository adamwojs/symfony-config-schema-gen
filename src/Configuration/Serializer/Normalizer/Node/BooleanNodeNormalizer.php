<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node;

use Symfony\Component\Config\Definition\BooleanNode;
use Symfony\Component\Config\Definition\ScalarNode;

class BooleanNodeNormalizer extends ScalarNodeNormalizer
{
    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof BooleanNode;
    }

    /**
     * @param \Symfony\Component\Config\Definition\BooleanNode $object
     */
    protected function getValueSchema(ScalarNode $node, string $format = null, array $context = []): array
    {
        return [
            'type' => 'boolean',
        ];
    }
}
