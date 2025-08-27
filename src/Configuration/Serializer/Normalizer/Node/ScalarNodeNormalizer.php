<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node;

use Symfony\Component\Config\Definition\ScalarNode;

class ScalarNodeNormalizer extends BaseNodeNormalizer
{
    /**
     * @param \Symfony\Component\Config\Definition\ScalarNode $data
     */
    public function normalize(mixed $data, string $format = null, array $context = []): float|int|bool|\ArrayObject|array|string|null
    {
        $schema = parent::normalize($data, $format, $context);
        $schema['$ref'] = '#/definitions/scalar_or_parameter';

        if ($data->hasDefaultValue()) {
            $schema['default'] = $data->getDefaultValue();
        }

        return $schema;
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof ScalarNode;
    }
}
