<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer;

use AdamWojs\SymfonyConfigGenBundle\Configuration\ConfigurationCollection;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class ConfigurationCollectionNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const SCHEMA_VERSION_7 = 'http://json-schema.org/draft-07/schema#';

    /**
     * @param \AdamWojs\SymfonyConfigGenBundle\Configuration\ConfigurationCollection $object
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $schema = [
            '$schema' => self::SCHEMA_VERSION_7,
            '$id' => $context['schema_id'] ?? '',
            'type' => 'object',
        ];

        if (!$object->isEmpty()) {
            $schema['properties'] = [];
            foreach ($object as $extension => $configuration) {
                $schema['properties'][$extension] = $this->normalizer->normalize(
                    $configuration,
                    $format,
                    $context
                );
            }
        }

        $schema['definitions'] = $this->getDefinitions();

        return $schema;
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof ConfigurationCollection;
    }

    private function getDefinitions(): array
    {
        return [
            'scalar' => [
                'anyOf' => [
                    ['type' => 'null'],
                    ['type' => 'string'],
                    ['type' => 'number'],
                    ['type' => 'boolean'],
                ],
            ],
            'variable' => [
                'anyOf' => [
                    [
                        '$ref' => '#/definitions/scalar',
                    ],
                    [
                        'type' => 'array',
                        'items' => [
                            '$ref' => '#/definitions/variable',
                        ],
                    ],
                    [
                        'type' => 'object',
                        'additionalProperties' => [
                            '$ref' => '#/definitions/variable',
                        ],
                    ],
                ],
            ],
        ];
    }
}
