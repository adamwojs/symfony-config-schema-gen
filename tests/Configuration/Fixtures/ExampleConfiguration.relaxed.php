<?php

return [
    '$schema' => 'http://json-schema.org/draft-07/schema#',
    '$id' => 'http://symfony.com/schema/config.schema.json',
    'type' => 'object',
    'properties' => [
        'acme_root' => [
            'type' => 'object',
            'properties' => [
                'boolean' => [
                    'anyOf' => [
                        0 => [
                            'type' => 'boolean',
                        ],
                        1 => [
                            '$ref' => '#/definitions/parameter',
                        ],
                    ],
                    'default' => true,
                ],
                'scalar_empty' => [
                    'anyOf' => [
                        0 => [
                            '$ref' => '#/definitions/scalar',
                        ],
                        1 => [
                            '$ref' => '#/definitions/parameter',
                        ],
                    ],
                ],
                'scalar_null' => [
                    'anyOf' => [
                        0 => [
                            '$ref' => '#/definitions/scalar',
                        ],
                        1 => [
                            '$ref' => '#/definitions/parameter',
                        ],
                    ],
                    'default' => null,
                ],
                'scalar_true' => [
                    'anyOf' => [
                        0 => [
                            '$ref' => '#/definitions/scalar',
                        ],
                        1 => [
                            '$ref' => '#/definitions/parameter',
                        ],
                    ],
                    'default' => true,
                ],
                'scalar_false' => [
                    'anyOf' => [
                        0 => [
                            '$ref' => '#/definitions/scalar',
                        ],
                        1 => [
                            '$ref' => '#/definitions/parameter',
                        ],
                    ],
                    'default' => false,
                ],
                'scalar_default' => [
                    'anyOf' => [
                        0 => [
                            '$ref' => '#/definitions/scalar',
                        ],
                        1 => [
                            '$ref' => '#/definitions/parameter',
                        ],
                    ],
                    'default' => 'default',
                ],
                'scalar_array_empty' => [
                    'anyOf' => [
                        0 => [
                            '$ref' => '#/definitions/scalar',
                        ],
                        1 => [
                            '$ref' => '#/definitions/parameter',
                        ],
                    ],
                    'default' => [],
                ],
                'scalar_array_defaults' => [
                    'anyOf' => [
                        0 => [
                            '$ref' => '#/definitions/scalar',
                        ],
                        1 => [
                            '$ref' => '#/definitions/parameter',
                        ],
                    ],
                    'default' => [
                        0 => 'elem1',
                        1 => 'elem2',
                    ],
                ],
                'scalar_required' => [
                    'anyOf' => [
                        0 => [
                            '$ref' => '#/definitions/scalar',
                        ],
                        1 => [
                            '$ref' => '#/definitions/parameter',
                        ],
                    ],
                ],
                'enum_with_default' => [
                    'anyOf' => [
                        0 => [
                            'enum' => [
                                0 => 'this',
                                1 => 'that',
                            ],
                        ],
                        1 => [
                            '$ref' => '#/definitions/parameter',
                        ],
                    ],
                    'default' => 'this',
                ],
                'enum' => [
                    'anyOf' => [
                        0 => [
                            'enum' => [
                                0 => 'this',
                                1 => 'that',
                            ],
                        ],
                        1 => [
                            '$ref' => '#/definitions/parameter',
                        ],
                    ],
                ],
                'array' => [
                    'description' => 'some info',
                    'type' => 'object',
                    'properties' => [
                        'child1' => [
                            'anyOf' => [
                                0 => [
                                    '$ref' => '#/definitions/scalar',
                                ],
                                1 => [
                                    '$ref' => '#/definitions/parameter',
                                ],
                            ],
                        ],
                        'child2' => [
                            'anyOf' => [
                                0 => [
                                    '$ref' => '#/definitions/scalar',
                                ],
                                1 => [
                                    '$ref' => '#/definitions/parameter',
                                ],
                            ],
                        ],
                        'child3' => [
                            'description' => 'this is a long
multi-line info text
which should be indented',
                            'examples' => [
                                0 => 'example setting',
                            ],
                            'anyOf' => [
                                0 => [
                                    '$ref' => '#/definitions/scalar',
                                ],
                                1 => [
                                    '$ref' => '#/definitions/parameter',
                                ],
                            ],
                        ],
                    ],
                    'additionalProperties' => true,
                ],
                'scalar_prototyped' => [
                    'examples' => [
                        0 => [
                            0 => 'foo',
                            1 => 'bar',
                            2 => 'baz',
                        ],
                    ],
                    'oneOf' => [
                        0 => [
                            'type' => 'array',
                            'items' => [
                                'anyOf' => [
                                    0 => [
                                        '$ref' => '#/definitions/scalar',
                                    ],
                                    1 => [
                                        '$ref' => '#/definitions/parameter',
                                    ],
                                ],
                            ],
                        ],
                        1 => [
                            'type' => 'object',
                            'additionalProperties' => [
                                'anyOf' => [
                                    0 => [
                                        '$ref' => '#/definitions/scalar',
                                    ],
                                    1 => [
                                        '$ref' => '#/definitions/parameter',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'parameters' => [
                    'oneOf' => [
                        0 => [
                            'type' => 'array',
                            'items' => [
                                'description' => 'Parameter name',
                                'anyOf' => [
                                    0 => [
                                        '$ref' => '#/definitions/scalar',
                                    ],
                                    1 => [
                                        '$ref' => '#/definitions/parameter',
                                    ],
                                ],
                            ],
                        ],
                        1 => [
                            'type' => 'object',
                            'additionalProperties' => [
                                'description' => 'Parameter name',
                                'anyOf' => [
                                    0 => [
                                        '$ref' => '#/definitions/scalar',
                                    ],
                                    1 => [
                                        '$ref' => '#/definitions/parameter',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'connections' => [
                    'oneOf' => [
                        0 => [
                            'type' => 'array',
                            'items' => [
                                'type' => 'object',
                                'properties' => [
                                    'user' => [
                                        'anyOf' => [
                                            0 => [
                                                '$ref' => '#/definitions/scalar',
                                            ],
                                            1 => [
                                                '$ref' => '#/definitions/parameter',
                                            ],
                                        ],
                                    ],
                                    'pass' => [
                                        'anyOf' => [
                                            0 => [
                                                '$ref' => '#/definitions/scalar',
                                            ],
                                            1 => [
                                                '$ref' => '#/definitions/parameter',
                                            ],
                                        ],
                                    ],
                                ],
                                'additionalProperties' => true,
                            ],
                        ],
                        1 => [
                            'type' => 'object',
                            'additionalProperties' => [
                                'type' => 'object',
                                'properties' => [
                                    'user' => [
                                        'anyOf' => [
                                            0 => [
                                                '$ref' => '#/definitions/scalar',
                                            ],
                                            1 => [
                                                '$ref' => '#/definitions/parameter',
                                            ],
                                        ],
                                    ],
                                    'pass' => [
                                        'anyOf' => [
                                            0 => [
                                                '$ref' => '#/definitions/scalar',
                                            ],
                                            1 => [
                                                '$ref' => '#/definitions/parameter',
                                            ],
                                        ],
                                    ],
                                ],
                                'additionalProperties' => true,
                            ],
                        ],
                    ],
                ],
                'cms_pages' => [
                    'oneOf' => [
                        0 => [
                            'type' => 'array',
                            'items' => [
                                'oneOf' => [
                                    0 => [
                                        'type' => 'array',
                                        'items' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'title' => [
                                                    'anyOf' => [
                                                        0 => [
                                                            '$ref' => '#/definitions/scalar',
                                                        ],
                                                        1 => [
                                                            '$ref' => '#/definitions/parameter',
                                                        ],
                                                    ],
                                                ],
                                                'path' => [
                                                    'anyOf' => [
                                                        0 => [
                                                            '$ref' => '#/definitions/scalar',
                                                        ],
                                                        1 => [
                                                            '$ref' => '#/definitions/parameter',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                            'additionalProperties' => true,
                                        ],
                                    ],
                                    1 => [
                                        'type' => 'object',
                                        'additionalProperties' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'title' => [
                                                    'anyOf' => [
                                                        0 => [
                                                            '$ref' => '#/definitions/scalar',
                                                        ],
                                                        1 => [
                                                            '$ref' => '#/definitions/parameter',
                                                        ],
                                                    ],
                                                ],
                                                'path' => [
                                                    'anyOf' => [
                                                        0 => [
                                                            '$ref' => '#/definitions/scalar',
                                                        ],
                                                        1 => [
                                                            '$ref' => '#/definitions/parameter',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                            'additionalProperties' => true,
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        1 => [
                            'type' => 'object',
                            'additionalProperties' => [
                                'oneOf' => [
                                    0 => [
                                        'type' => 'array',
                                        'items' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'title' => [
                                                    'anyOf' => [
                                                        0 => [
                                                            '$ref' => '#/definitions/scalar',
                                                        ],
                                                        1 => [
                                                            '$ref' => '#/definitions/parameter',
                                                        ],
                                                    ],
                                                ],
                                                'path' => [
                                                    'anyOf' => [
                                                        0 => [
                                                            '$ref' => '#/definitions/scalar',
                                                        ],
                                                        1 => [
                                                            '$ref' => '#/definitions/parameter',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                            'additionalProperties' => true,
                                        ],
                                    ],
                                    1 => [
                                        'type' => 'object',
                                        'additionalProperties' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'title' => [
                                                    'anyOf' => [
                                                        0 => [
                                                            '$ref' => '#/definitions/scalar',
                                                        ],
                                                        1 => [
                                                            '$ref' => '#/definitions/parameter',
                                                        ],
                                                    ],
                                                ],
                                                'path' => [
                                                    'anyOf' => [
                                                        0 => [
                                                            '$ref' => '#/definitions/scalar',
                                                        ],
                                                        1 => [
                                                            '$ref' => '#/definitions/parameter',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                            'additionalProperties' => true,
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'pipou' => [
                    'oneOf' => [
                        0 => [
                            'type' => 'array',
                            'items' => [
                                'oneOf' => [
                                    0 => [
                                        'type' => 'array',
                                        'items' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'didou' => [
                                                    'anyOf' => [
                                                        0 => [
                                                            '$ref' => '#/definitions/scalar',
                                                        ],
                                                        1 => [
                                                            '$ref' => '#/definitions/parameter',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                            'additionalProperties' => true,
                                        ],
                                    ],
                                    1 => [
                                        'type' => 'object',
                                        'additionalProperties' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'didou' => [
                                                    'anyOf' => [
                                                        0 => [
                                                            '$ref' => '#/definitions/scalar',
                                                        ],
                                                        1 => [
                                                            '$ref' => '#/definitions/parameter',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                            'additionalProperties' => true,
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        1 => [
                            'type' => 'object',
                            'additionalProperties' => [
                                'oneOf' => [
                                    0 => [
                                        'type' => 'array',
                                        'items' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'didou' => [
                                                    'anyOf' => [
                                                        0 => [
                                                            '$ref' => '#/definitions/scalar',
                                                        ],
                                                        1 => [
                                                            '$ref' => '#/definitions/parameter',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                            'additionalProperties' => true,
                                        ],
                                    ],
                                    1 => [
                                        'type' => 'object',
                                        'additionalProperties' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'didou' => [
                                                    'anyOf' => [
                                                        0 => [
                                                            '$ref' => '#/definitions/scalar',
                                                        ],
                                                        1 => [
                                                            '$ref' => '#/definitions/parameter',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                            'additionalProperties' => true,
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'additionalProperties' => true,
        ],
    ],
    'definitions' => [
        'scalar' => [
            'anyOf' => [
                0 => [
                    'type' => 'null',
                ],
                1 => [
                    'type' => 'string',
                ],
                2 => [
                    'type' => 'number',
                ],
                3 => [
                    'type' => 'boolean',
                ],
            ],
        ],
        'variable' => [
            'anyOf' => [
                0 => [
                    '$ref' => '#/definitions/scalar',
                ],
                1 => [
                    'type' => 'array',
                    'items' => [
                        '$ref' => '#/definitions/variable',
                    ],
                ],
                2 => [
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
    ],
];
