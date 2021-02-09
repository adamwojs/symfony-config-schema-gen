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
    public function testSerialize(ConfigurationCollection $collection, $expectedSchema, array $context = []): void
    {
        $serializer = $this->createSerializer();

        $actualSchema = $serializer->normalize($collection, 'json', [
            'schema_id' => 'http://symfony.com/schema/config.schema.json',
        ] + $context);

        if (getenv('ENABLE_RECORD')) {
            var_export($actualSchema);
        }

        $this->assertEquals($expectedSchema, $actualSchema);
    }

    public function dataProviderForTestSerializer(): iterable
    {
        yield 'strict' => [
            new ConfigurationCollection([
                'acme_root' => new ExampleConfiguration(),
            ]),
            require_once __DIR__ . '/../Fixtures/ExampleConfiguration.strict.php',
            [
                'strict' => true,
            ],
        ];

        yield 'relaxed' => [
            new ConfigurationCollection([
                'acme_root' => new ExampleConfiguration(),
            ]),
            require_once __DIR__ . '/../Fixtures/ExampleConfiguration.relaxed.php',
            [
                'strict' => false,
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
