# LiipUrlAutoConverterBundle #

## About ##

This bundle adds a Twig Extension with a filter for automatically converting urls and emails in a string to html links.
In the Format: "<a href="http://liip.ch">liip.ch</a>" for urls or "<a href="mailto:info@liip.ch">info@liip.ch</a>" for emails.

[![Build Status](https://secure.travis-ci.org/liip/LiipUrlAutoConverterBundle.png)](http://travis-ci.org/liip/LiipUrlAutoConverterBundle)

## Installation ##

   1. Add this bundle to your composer.json:

          $ php composer.phar require liip/url-auto-converter-bundle:dev-master

    2. Add the Liip namespace to your autoloader:

        // app/autoload.php
        $loader->registerNamespaces(array(
            'Liip' => __DIR__.'/../vendor/bundles',
            // your other namespaces
        ));

    3. Add this bundle to your application's kernel:

        // application/ApplicationKernel.php
        public function registerBundles()
        {
          return array(
              // ...
              new Liip\UrlAutoConverterBundle\LiipUrlAutoConverterBundle(),
              // ...
          );
        }

## Configuration ##

The supported options for the LiipUrlAutoConverterBundle are: (put in /app/config/config.yml)

    liip_url_auto_converter:
        linkclass:
        target: _blank
        debugmode: false


- "linkClass":  css class thath will be added automatically to converted links. default: "" (empty)
- "target":     browser link target. default: "_blank"
- "debugMode":  if true, links will be colored with a nasty green color - cool for testing. default: false

All settings are optional.

## Usage ##

This library adds a filter for twig templates that can be used like:

    {{ "sometexttofindaurl www.liip.ch inside" | converturls }}

## License ##

See `LICENSE`.
