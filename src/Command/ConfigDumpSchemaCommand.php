<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Command;

use AdamWojs\SymfonyConfigGenBundle\Configuration\ConfigurationCollection;
use AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\SerializerFactory;
use Symfony\Bundle\FrameworkBundle\Command\AbstractConfigCommand;
use Symfony\Component\Config\Definition\ArrayNode;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Serializer;

#[AsCommand('config:dump-schema', 'Dumps the configuration schema for enabled extensions')]
final class ConfigDumpSchemaCommand extends AbstractConfigCommand
{
    public function __construct(
        private readonly SerializerFactory $serializerFactory,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->addArgument(
            'extensions',
            InputArgument::IS_ARRAY,
            'Extensions whitelist',
            []
        );

        $this->addOption(
            'schema-id',
            null,
            InputOption::VALUE_REQUIRED,
            'Unique identifier for the schema',
            'http://symfony.com/schema/config.schema.json'
        );

        $this->addOption(
            'format',
            null,
            InputOption::VALUE_REQUIRED,
            'Output format',
            'json'
        );

        $this->addOption(
            'pretty-print',
            null,
            InputOption::VALUE_NONE,
            'Prettify schema output'
        );

        $this->addOption(
            'strict',
            null,
            InputOption::VALUE_NONE,
            'Generate strict schema'
        );

        $this->addOption(
            'skip-empty',
            null,
            InputOption::VALUE_NONE,
            'Skip schema generation for extensions with empty configuration'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $format = $input->getOption('format');

        $context = [
            'schema_id' => $input->getOption('schema-id'),
            'strict' => $input->getOption('strict'),
        ];

        if ($input->getOption('pretty-print') && $format === 'json') {
            $context['json_encode_options'] = JSON_PRETTY_PRINT;
        }

        $schema = $this->createSerializer()->serialize(
            $this->getConfigurationCollection(
                $input->getArgument('extensions'),
                $input->getOption('skip-empty')
            ),
            $format,
            $context
        );

        $output->writeln($schema);

        return self::SUCCESS;
    }

    private function getConfigurationCollection(array $allowedExtensions, bool $skipEmpty = true): ConfigurationCollection
    {
        $configurations = [];

        $kernel = $this->getApplication()->getKernel();
        /** @var \Symfony\Component\HttpKernel\Bundle\Bundle[] $bundles */
        $bundles = $kernel->getBundles();

        $container = $this->getContainerBuilder($kernel);
        foreach ($bundles as $bundle) {
            if ($extension = $bundle->getContainerExtension()) {
                $container->registerExtension($extension);
            }
        }

        foreach ($bundles as $bundle) {
            $bundle->build($container);
        }

        foreach ($bundles as $bundle) {
            $extension = $bundle->getContainerExtension();
            if ($extension === null) {
                continue;
            }

            $alias = $extension->getAlias();
            if (!empty($allowedExtensions) && !in_array($alias, $allowedExtensions)) {
                continue;
            }

            if ($extension instanceof ConfigurationInterface) {
                $configuration = $extension;
            } else {
                $configuration = $extension->getConfiguration([], $container);
            }

            if ($configuration instanceof ConfigurationInterface) {
                if (!$skipEmpty || !$this->isEmptyConfiguration($configuration)) {
                    $configurations[$alias] = $configuration;
                }
            }
        }

        return new ConfigurationCollection($configurations);
    }

    private function createSerializer(): Serializer
    {
        return $this->serializerFactory->createSerializer();
    }

    private function isEmptyConfiguration(ConfigurationInterface $configuration): bool
    {
        $tree = $configuration->getConfigTreeBuilder()->buildTree();
        if ($tree instanceof ArrayNode) {
            return empty($tree->getChildren());
        }

        return false;
    }
}
