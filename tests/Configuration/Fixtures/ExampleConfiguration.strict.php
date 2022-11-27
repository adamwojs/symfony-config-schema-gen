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
                    '$ref' => '#/definitions/boolean_or_parameter',
                    'default' => true,
                ],
                'scalar_empty' => [
                    '$ref' => '#/definitions/scalar_or_parameter',
                ],
                'scalar_null' => [
                    '$ref' => '#/definitions/scalar_or_parameter',
                    'default' => null,
                ],
                'scalar_true' => [
                    '$ref' => '#/definitions/scalar_or_parameter',
                    'default' => true,
                ],
                'scalar_false' => [
                    '$ref' => '#/definitions/scalar_or_parameter',
                    'default' => false,
                ],
                'scalar_default' => [
                    '$ref' => '#/definitions/scalar_or_parameter',
                    'default' => 'default',
                ],
                'scalar_array_empty' => [
                    '$ref' => '#/definitions/scalar_or_parameter',
                    'default' => [],
                ],
                'scalar_array_defaults' => [
                    '$ref' => '#/definitions/scalar_or_parameter',
                    'default' => [
                        0 => 'elem1',
                        1 => 'elem2',
                    ],
                ],
                'scalar_required' => [
                    '$ref' => '#/definitions/scalar_or_parameter',
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
                            '$ref' => '#/definitions/scalar_or_parameter',
                        ],
                        'child2' => [
                            '$ref' => '#/definitions/scalar_or_parameter',
                        ],
                        'child3' => [
                            'description' => 'this is a long
multi-line info text
which should be indented',
                            'examples' => [
                                0 => 'example setting',
                            ],
                            '$ref' => '#/definitions/scalar_or_parameter',
                        ],
                    ],
                    'additionalProperties' => false,
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
                                '$ref' => '#/definitions/scalar_or_parameter',
                            ],
                        ],
                        1 => [
                            'type' => 'object',
                            'additionalProperties' => [
                                '$ref' => '#/definitions/scalar_or_parameter',
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
                                '$ref' => '#/definitions/scalar_or_parameter',
                            ],
                        ],
                        1 => [
                            'type' => 'object',
                            'additionalProperties' => [
                                'description' => 'Parameter name',
                                '$ref' => '#/definitions/scalar_or_parameter',
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
                                        '$ref' => '#/definitions/scalar_or_parameter',
                                    ],
                                    'pass' => [
                                        '$ref' => '#/definitions/scalar_or_parameter',
                                    ],
                                ],
                                'additionalProperties' => false,
                            ],
                        ],
                        1 => [
                            'type' => 'object',
                            'additionalProperties' => [
                                'type' => 'object',
                                'properties' => [
                                    'user' => [
                                        '$ref' => '#/definitions/scalar_or_parameter',
                                    ],
                                    'pass' => [
                                        '$ref' => '#/definitions/scalar_or_parameter',
                                    ],
                                ],
                                'additionalProperties' => false,
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
                                                    '$ref' => '#/definitions/scalar_or_parameter',
                                                ],
                                                'path' => [
                                                    '$ref' => '#/definitions/scalar_or_parameter',
                                                ],
                                            ],
                                            'required' => [
                                                0 => 'title',
                                                1 => 'path',
                                            ],
                                            'additionalProperties' => false,
                                        ],
                                    ],
                                    1 => [
                                        'type' => 'object',
                                        'additionalProperties' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'title' => [
                                                    '$ref' => '#/definitions/scalar_or_parameter',
                                                ],
                                                'path' => [
                                                    '$ref' => '#/definitions/scalar_or_parameter',
                                                ],
                                            ],
                                            'required' => [
                                                0 => 'title',
                                                1 => 'path',
                                            ],
                                            'additionalProperties' => false,
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
                                                    '$ref' => '#/definitions/scalar_or_parameter',
                                                ],
                                                'path' => [
                                                    '$ref' => '#/definitions/scalar_or_parameter',
                                                ],
                                            ],
                                            'required' => [
                                                0 => 'title',
                                                1 => 'path',
                                            ],
                                            'additionalProperties' => false,
                                        ],
                                    ],
                                    1 => [
                                        'type' => 'object',
                                        'additionalProperties' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'title' => [
                                                    '$ref' => '#/definitions/scalar_or_parameter',
                                                ],
                                                'path' => [
                                                    '$ref' => '#/definitions/scalar_or_parameter',
                                                ],
                                            ],
                                            'required' => [
                                                0 => 'title',
                                                1 => 'path',
                                            ],
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
                                                    '$ref' => '#/definitions/scalar_or_parameter',
                                                ],
                                            ],
                                            'additionalProperties' => false,
                                        ],
                                    ],
                                    1 => [
                                        'type' => 'object',
                                        'additionalProperties' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'didou' => [
                                                    '$ref' => '#/definitions/scalar_or_parameter',
                                                ],
                                            ],
                                            'additionalProperties' => false,
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
                                                    '$ref' => '#/definitions/scalar_or_parameter',
                                                ],
                                            ],
                                            'additionalProperties' => false,
                                        ],
                                    ],
                                    1 => [
                                        'type' => 'object',
                                        'additionalProperties' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'didou' => [
                                                    '$ref' => '#/definitions/scalar_or_parameter',
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
                0 => 'scalar_required',
            ],
            'additionalProperties' => false,
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
        'boolean_or_parameter' => [
            'anyOf' => [
                0 => [
                    'type' => 'boolean',
                ],
                1 => [
                    '$ref' => '#/definitions/parameter',
                ],
            ],
        ],
        'integer_or_parameter' => [
            'anyOf' => [
                0 => [
                    'type' => 'integer',
                ],
                1 => [
                    '$ref' => '#/definitions/parameter',
                ],
            ],
        ],
        'number_or_parameter' => [
            'anyOf' => [
                0 => [
                    'type' => 'number',
                ],
                1 => [
                    '$ref' => '#/definitions/parameter',
                ],
            ],
        ],
        'scalar_or_parameter' => [
            'anyOf' => [
                0 => [
                    '$ref' => '#/definitions/scalar',
                ],
                1 => [
                    '$ref' => '#/definitions/parameter',
                ],
            ],
        ],
        'variable_or_parameter' => [
            'anyOf' => [
                0 => [
                    '$ref' => '#/definitions/variable',
                ],
                1 => [
                    '$ref' => '#/definitions/parameter',
                ],
            ],
        ],
    ],
];
