<?php

declare(strict_types=1);

namespace AdamWojs\ConfigJsonSchemaGenBundle\Command;

use AdamWojs\ConfigJsonSchemaGenBundle\Config\Definition\Dumper\JsonSchemaDumper;
use Symfony\Bundle\FrameworkBundle\Command\AbstractConfigCommand;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class DumpJsonSchemaCommand extends AbstractConfigCommand
{
    protected static $defaultName = 'config:dump-json-schema';

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
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $dumper = new JsonSchemaDumper();
        $schema = [
            '$schema' => 'http://json-schema.org/draft-07/schema#',
            '$id' => $input->getOption('schema-id'),
            'type' => 'object',
            'properties' => [],
        ];

        /** @var \Symfony\Component\HttpKernel\Bundle\Bundle[] $bundles */
        $bundles = $this->getApplication()->getKernel()->getBundles();

        usort($bundles, function ($bundleA, $bundleB) {
            return strcmp($bundleA->getName(), $bundleB->getName());
        });

        $allowedExtensions = $input->getArgument('extensions');
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
                $schema['properties'][$alias] = $dumper->dump($configuration);
            }
        }

        $output->writeln(json_encode($schema, JSON_PRETTY_PRINT));

        return self::SUCCESS;
    }
}
