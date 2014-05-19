# SwagAsyncImageGenerator

## A job queue example plugin for shopware

This plugin is a example job queue worker for shopware.
It depends on [SwagJobQueue](https://github.com/bcremer/SwagJobQueue).

## Installation
Clone this repo into the `Core` namespace in your `Local` plugin directory:

```bash
$ cd /path/to/your/shopware/installation
$ git clone https://github.com/bcremer/SwagAsyncImageGenerator.git engine/Shopware/Plugins/Local/Core/SwagAsyncImageGenerator
```

Install Plugin in the shopware plugin manager or via the shopware console:

```bash
$ ./bin/console sw:plugin:refresh
$ ./bin/console sw:plugin:install SwagAsyncImageGenerator --activate
```
