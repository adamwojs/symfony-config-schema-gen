# adamwojs/symfony-config-schema-gen

A utility bundle to generates JSON Schema from Symfony configuration.

## Installation

### Applications that use Symfony Flex

Open a command console, enter your project directory and execute:

### Applications that don't use Symfony Flex

#### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the  
following command to download the latest stable version of this bundle:

```console
$ composer require adamwojs/symfony-config-schema-gen
```

This command requires you to have Composer installed globally, as explained  
in the [installation chapter](https://getcomposer.org/doc/00-intro.md) of the Composer documentation.

#### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles  
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    AdamWojs\SymfonyConfigGenBundle\SymfonyConfigSchemaGenBundle::class => ['dev' => true],
];
```

## Usage

### Basic usage

```console
$ php bin/console config:dump-schema > config.schema.json
```

### Synopsis

```
Usage:
  config:dump-schema [options] [--] [<extensions>...]

Arguments:
  extensions                     Extensions whitelist

Options:
      --schema-id=SCHEMA-ID      Unique identifier for the schema [default: "http://symfony.com/schema/config.schema.json"]
      --format=FORMAT            Output format [default: "json"]
      --pretty-print             Prettify schema output
      --strict                   Generates strict schema
  -h, --help                     Display this help message
  -q, --quiet                    Do not output any message
  -V, --version                  Display this application version
      --ansi                     Force ANSI output
      --no-ansi                  Disable ANSI output
  -n, --no-interaction           Do not ask any interactive question
  -e, --env=ENV                  The Environment name. [default: "dev"]
      --no-debug                 Switches off debug mode.
  -v|vv|vvv, --verbose           Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
```
