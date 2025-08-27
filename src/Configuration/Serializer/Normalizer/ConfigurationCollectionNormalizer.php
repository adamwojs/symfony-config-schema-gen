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

    private const string SCHEMA_VERSION_7 = 'http://json-schema.org/draft-07/schema#';

    /**
     * @param \AdamWojs\SymfonyConfigGenBundle\Configuration\ConfigurationCollection $object
     */
    public function normalize(mixed $object, string $format = null, array $context = []): float|int|bool|\ArrayObject|array|string|null
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

    public function supportsNormalization($data, string $format = null, array $context = []): bool
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
            'parameter' => [
                'type' => 'string',
                'pattern' => '^%([a-zA-Z0-9_.])+%$',
            ],
            'boolean_or_parameter' => [
                'anyOf' => [
                    [
                        'type' => 'boolean',
                    ],
                    [
                        '$ref' => '#/definitions/parameter',
                    ],
                ],
            ],
            'integer_or_parameter' => [
                'anyOf' => [
                    [
                        'type' => 'integer',
                    ],
                    [
                        '$ref' => '#/definitions/parameter',
                    ],
                ],
            ],
            'number_or_parameter' => [
                'anyOf' => [
                    [
                        'type' => 'number',
                    ],
                    [
                        '$ref' => '#/definitions/parameter',
                    ],
                ],
            ],
            'scalar_or_parameter' => [
                'anyOf' => [
                    [
                        '$ref' => '#/definitions/scalar',
                    ],
                    [
                        '$ref' => '#/definitions/parameter',
                    ],
                ],
            ],
            'variable_or_parameter' => [
                'anyOf' => [
                    [
                        '$ref' => '#/definitions/variable',
                    ],
                    [
                        '$ref' => '#/definitions/parameter',
                    ],
                ],
            ],
        ];
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            ConfigurationCollection::class => true,
        ];
    }
}
