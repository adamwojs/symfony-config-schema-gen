<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Tests\Configuration\Serializer;

use AdamWojs\SymfonyConfigGenBundle\Configuration\ConfigurationCollection;
use AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\ConfigurationCollectionNormalizer;
use AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\ConfigurationNormalizer;
use AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node\ArrayNodeNormalizer;
use AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node\BaseNodeNormalizer;
use AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node\BooleanNodeNormalizer;
use AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node\EnumNodeNormalizer;
use AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node\FloatNodeNormalizer;
use AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node\IntegerNodeNormalizer;
use AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node\NumericNodeNormalizer;
use AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node\PrototypedArrayNodeNormalizer;
use AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node\ScalarNodeNormalizer;
use AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\Normalizer\Node\VariableNodeNormalizer;
use AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\SerializerFactory;
use AdamWojs\SymfonyConfigGenBundle\Tests\Configuration\Fixtures\ExampleConfiguration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Serializer;

final class SerializationTest extends TestCase
{
    /**
     * @dataProvider dataProviderForTestSerializer
     */
    public function testSerialize(ConfigurationCollection $collection, $expectedSchema): void
    {
        $serializer = $this->createSerializer();

        $this->assertEquals(
            $expectedSchema,
            $serializer->normalize($collection, 'json', [
                'schema_id' => 'http://symfony.com/schema/config.schema.json',
            ])
        );
    }

    public function dataProviderForTestSerializer(): iterable
    {
        yield [
            new ConfigurationCollection([
                'acme_root' => new ExampleConfiguration(),
            ]),
            [
                '$schema' => 'http://json-schema.org/draft-07/schema#',
                '$id' => 'http://symfony.com/schema/config.schema.json',
                'type' => 'object',
                'properties' => [
                    'acme_root' => [
                        'type' => 'object',
                        'properties' => [
                            'boolean' => [
                                'default' => true,
                                'type' => 'boolean',
                            ],
                            'scalar_empty' => [
                                '$ref' => '#/definitions/scalar',
                            ],
                            'scalar_null' => [
                                '$ref' => '#/definitions/scalar',
                                'default' => null,
                            ],
                            'scalar_true' => [
                                '$ref' => '#/definitions/scalar',
                                'default' => true,
                            ],
                            'scalar_false' => [
                                '$ref' => '#/definitions/scalar',
                                'default' => false,
                            ],
                            'scalar_default' => [
                                '$ref' => '#/definitions/scalar',
                                'default' => 'default',
                            ],
                            'scalar_array_empty' => [
                                '$ref' => '#/definitions/scalar',
                                'default' => [],
                            ],
                            'scalar_array_defaults' => [
                                '$ref' => '#/definitions/scalar',
                                'default' => [
                                    'elem1',
                                    'elem2',
                                ],
                            ],
                            'scalar_required' => [
                                '$ref' => '#/definitions/scalar',
                            ],
                            'enum_with_default' => [
                                'enum' => ['this', 'that'],
                                'default' => 'this',
                            ],
                            'enum' => [
                                'enum' => ['this', 'that'],
                            ],
                            'array' => [
                                'description' => 'some info',
                                'type' => 'object',
                                'properties' => [
                                    'child1' => [
                                        '$ref' => '#/definitions/scalar',
                                    ],
                                    'child2' => [
                                        '$ref' => '#/definitions/scalar',
                                    ],
                                    'child3' => [
                                        'description' => "this is a long\n" .
                                            "multi-line info text\n" .
                                            'which should be indented',
                                        'examples' => [
                                            'example setting',
                                        ],
                                        '$ref' => '#/definitions/scalar',
                                    ],
                                ],
                                'additionalProperties' => false,
                            ],
                            'scalar_prototyped' => [
                                'examples' => [
                                    [
                                        'foo',
                                        'bar',
                                        'baz',
                                    ],
                                ],
                                'oneOf' => [
                                    [
                                        'type' => 'array',
                                        'items' => [
                                            '$ref' => '#/definitions/scalar',
                                        ],
                                    ],
                                    [
                                        'type' => 'object',
                                        'additionalProperties' => [
                                            '$ref' => '#/definitions/scalar',
                                        ],
                                    ],
                                ],
                            ],
                            'parameters' => [
                                'oneOf' => [
                                    [
                                        'type' => 'array',
                                        'items' => [
                                            'description' => 'Parameter name',
                                            '$ref' => '#/definitions/scalar',
                                        ],
                                    ],
                                    [
                                        'type' => 'object',
                                        'additionalProperties' => [
                                            'description' => 'Parameter name',
                                            '$ref' => '#/definitions/scalar',
                                        ],
                                    ],
                                ],
                            ],
                            'connections' => [
                                'oneOf' => [
                                    [
                                        'type' => 'array',
                                        'items' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'user' => [
                                                    '$ref' => '#/definitions/scalar',
                                                ],
                                                'pass' => [
                                                    '$ref' => '#/definitions/scalar',
                                                ],
                                            ],
                                            'additionalProperties' => false,
                                        ],
                                    ],
                                    [
                                        'type' => 'object',
                                        'additionalProperties' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'user' => [
                                                    '$ref' => '#/definitions/scalar',
                                                ],
                                                'pass' => [
                                                    '$ref' => '#/definitions/scalar',
                                                ],
                                            ],
                                            'additionalProperties' => false,
                                        ],
                                    ],
                                ],
                            ],
                            'cms_pages' => [
                                'oneOf' => [
                                    [
                                        'type' => 'array',
                                        'items' => [
                                            'oneOf' => [
                                                [
                                                    'type' => 'array',
                                                    'items' => [
                                                        'type' => 'object',
                                                        'properties' => [
                                                            'title' => [
                                                                '$ref' => '#/definitions/scalar',
                                                            ],
                                                            'path' => [
                                                                '$ref' => '#/definitions/scalar',
                                                            ],
                                                        ],
                                                        'required' => ['title', 'path'],
                                                        'additionalProperties' => false,
                                                    ],
                                                ],
                                                [
                                                    'type' => 'object',
                                                    'additionalProperties' => [
                                                        'type' => 'object',
                                                        'properties' => [
                                                            'title' => [
                                                                '$ref' => '#/definitions/scalar',
                                                            ],
                                                            'path' => [
                                                                '$ref' => '#/definitions/scalar',
                                                            ],
                                                        ],
                                                        'required' => ['title', 'path'],
                                                        'additionalProperties' => false,
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                    [
                                        'type' => 'object',
                                        'additionalProperties' => [
                                            'oneOf' => [
                                                [
                                                    'type' => 'array',
                                                    'items' => [
                                                        'type' => 'object',
                                                        'properties' => [
                                                            'title' => [
                                                                '$ref' => '#/definitions/scalar',
                                                            ],
                                                            'path' => [
                                                                '$ref' => '#/definitions/scalar',
                                                            ],
                                                        ],
                                                        'required' => ['title', 'path'],
                                                        'additionalProperties' => false,
                                                    ],
                                                ],
                                                [
                                                    'type' => 'object',
                                                    'additionalProperties' => [
                                                        'type' => 'object',
                                                        'properties' => [
                                                            'title' => [
                                                                '$ref' => '#/definitions/scalar',
                                                            ],
                                                            'path' => [
                                                                '$ref' => '#/definitions/scalar',
                                                            ],
                                                        ],
                                                        'required' => ['title', 'path'],
                                                        'additionalProperties' => false,
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                            'pipou' => [
                                'oneOf' => [
                                    [
                                        'type' => 'array',
                                        'items' => [
                                            'oneOf' => [
                                                [
                                                    'type' => 'array',
                                                    'items' => [
                                                        'type' => 'object',
                                                        'properties' => [
                                                            'didou' => [
                                                                '$ref' => '#/definitions/scalar',
                                                            ],
                                                        ],
                                                        'additionalProperties' => false,
                                                    ],
                                                ],
                                                [
                                                    'type' => 'object',
                                                    'additionalProperties' => [
                                                        'type' => 'object',
                                                        'properties' => [
                                                            'didou' => [
                                                                '$ref' => '#/definitions/scalar',
                                                            ],
                                                        ],
                                                        'additionalProperties' => false,
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                    [
                                        'type' => 'object',
                                        'additionalProperties' => [
                                            'oneOf' => [
                                                [
                                                    'type' => 'array',
                                                    'items' => [
                                                        'type' => 'object',
                                                        'properties' => [
                                                            'didou' => [
                                                                '$ref' => '#/definitions/scalar',
                                                            ],
                                                        ],
                                                        'additionalProperties' => false,
                                                    ],
                                                ],
                                                [
                                                    'type' => 'object',
                                                    'additionalProperties' => [
                                                        'type' => 'object',
                                                        'properties' => [
                                                            'didou' => [
                                                                '$ref' => '#/definitions/scalar',
                                                            ],
                                                        ],
                                                        'additionalProperties' => false,
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'required' => [
                            'scalar_required',
                        ],
                        'additionalProperties' => false,
                    ],
                ],
                'definitions' => [
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
                ],
            ],
        ];
    }

    private function createSerializer(): Serializer
    {
        return (new SerializerFactory([
            new ConfigurationCollectionNormalizer(),
            new ConfigurationNormalizer(),
            new PrototypedArrayNodeNormalizer(),
            new ArrayNodeNormalizer(),
            new BooleanNodeNormalizer(),
            new EnumNodeNormalizer(),
            new FloatNodeNormalizer(),
            new IntegerNodeNormalizer(),
            new NumericNodeNormalizer(),
            new ScalarNodeNormalizer(),
            new VariableNodeNormalizer(),
            new BaseNodeNormalizer(),
        ]))->createSerializer();
    }
}
