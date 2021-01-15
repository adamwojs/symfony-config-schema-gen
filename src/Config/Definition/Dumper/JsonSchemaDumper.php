<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace AdamWojs\ConfigJsonSchemaGenBundle\Config\Definition\Dumper;

use Symfony\Component\Config\Definition\ArrayNode;
use Symfony\Component\Config\Definition\BaseNode;
use Symfony\Component\Config\Definition\BooleanNode;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\EnumNode;
use Symfony\Component\Config\Definition\FloatNode;
use Symfony\Component\Config\Definition\IntegerNode;
use Symfony\Component\Config\Definition\NodeInterface;
use Symfony\Component\Config\Definition\PrototypedArrayNode;
use Symfony\Component\Config\Definition\ScalarNode;
use Symfony\Component\Config\Definition\VariableNode;

final class JsonSchemaDumper
{
    public function dump(ConfigurationInterface $configuration): array
    {
        return $this->dumpNode($configuration->getConfigTreeBuilder()->buildTree());
    }

    public function dumpNode(NodeInterface $node, string $namespace = null): array
    {
        $schema = [];

        if ($node instanceof BaseNode) {
            if (($info = $node->getInfo()) !== null) {
                $schema['description'] = $info;
            }

            if (($example = $node->getExample()) !== null) {
                $schema['examples'] = [$example];
            }
        }

        if ($node instanceof ScalarNode) {
            // Fallback ->scalarNode('foo') to string
            $schema['type'] = 'string';

            if ($node->hasDefaultValue()) {
                $schema['default'] = $node->getDefaultValue();
            }
        }

        if ($node instanceof IntegerNode) {
            $schema['type'] = 'integer';
        } elseif ($node instanceof FloatNode) {
            $schema['type'] = 'float';
        } elseif ($node instanceof BooleanNode) {
            $schema['type'] = 'boolean';
        } elseif ($node instanceof EnumNode) {
            $schema['enum'] = $node->getValues();
        } elseif ($node instanceof ArrayNode) {
            $schema['type'] = 'object';
            if ($node instanceof PrototypedArrayNode) {
                $prototype = $node->getPrototype();
                if ($prototype instanceof ArrayNode) {
                    $schema['additionalProperties'] = $this->dumpNode($prototype);
                } else {
                    $schema['type'] = 'array';
                    $schema['items'] = $this->dumpNode($prototype);
                }
            } else {
                $schema['additionalProperties'] = false;
                $schema['properties'] = [];
                $schema['required'] =[];

                foreach ($node->getChildren() as $child) {
                    /* @var \Symfony\Component\Config\Definition\NodeInterface $child */
                    $schema['properties'][$child->getName()] = $this->dumpNode($child, $namespace);

                    if ($child->isRequired()) {
                        $schema['required'][] = $child->getName();
                    }
                }

                if (empty($schema['required'])) {
                    unset($schema['required']);
                }
            }
        } elseif ($node instanceof VariableNode) {
            $schema['type'] = 'object';
            $schema['additionalProperties'] = true;
        }

        return $schema;
    }
}
