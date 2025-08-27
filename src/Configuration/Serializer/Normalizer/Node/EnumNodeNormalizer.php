<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node;

use Symfony\Component\Config\Definition\EnumNode;

class EnumNodeNormalizer extends BaseNodeNormalizer
{
    public function normalize(mixed $data, string $format = null, array $context = []): float|int|bool|\ArrayObject|array|string|null
    {
        $schema = parent::normalize($data, $format, $context);
        $schema['anyOf'] = [
            [
                'enum' => $data->getValues(),
            ],
            [
                '$ref' => '#/definitions/parameter',
            ],
        ];

        if ($data->hasDefaultValue()) {
            $schema['default'] = $data->getDefaultValue();
        }

        return $schema;
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof EnumNode;
    }
}
