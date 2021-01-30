<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node;

use Symfony\Component\Config\Definition\EnumNode;
use Symfony\Component\Config\Definition\ScalarNode;

class EnumNodeNormalizer extends ScalarNodeNormalizer
{
    /**
     * @param \Symfony\Component\Config\Definition\EnumNode $node
     */
    protected function getValueSchema(ScalarNode $node, string $format = null, array $context = []): array
    {
        return [
            'enum' => $node->getValues(),
        ];
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof EnumNode;
    }
}
