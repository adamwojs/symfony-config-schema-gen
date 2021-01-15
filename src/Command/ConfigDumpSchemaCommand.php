<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Command;

use AdamWojs\SymfonyConfigGenBundle\Configuration\ConfigurationCollection;
use AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\SerializerFactory;
use Symfony\Bundle\FrameworkBundle\Command\AbstractConfigCommand;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class ConfigDumpSchemaCommand extends AbstractConfigCommand
{
    protected static $defaultName = 'config:dump-schema';

    /** @var \AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer\SerializerFactory */
    private $serializerFactory;

    public function __construct(SerializerFactory $serializerFactory, ?string $name = null)
    {
        parent::__construct($name);

        $this->serializerFactory = $serializerFactory;
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
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $serializer = $this->serializerFactory->createSerializer();

        $schema = $serializer->serialize(
            $this->getConfigurationCollection(
                $input->getArgument('extensions')
            ),
            $input->getOption('format'),
            [
                'json_encode_options' => JSON_PRETTY_PRINT
            ]
        );

        $output->writeln($schema);

        return self::SUCCESS;
    }

    private function getConfigurationCollection(array $allowedExtensions): ConfigurationCollection
    {
        $configurations = [];

        /** @var \Symfony\Component\HttpKernel\Bundle\Bundle[] $bundles */
        $bundles = $this->getApplication()->getKernel()->getBundles();
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
                $configuration = $extension->getConfiguration([], $this->getContainerBuilder());
            }

            if ($configuration instanceof ConfigurationInterface) {
                $configurations[$alias] = $configuration;
            }
        }

        return new ConfigurationCollection($configurations);
    }
}
