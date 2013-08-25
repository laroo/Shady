# Shady

A set of shady Slim Framework middlewares that can solve some annoyances...

[![Build Status](https://travis-ci.org/laroo/Shady.png?branch=master)](https://travis-ci.org/laroo/Shady)

## What does it contain?

Available middlewares:
- ApacheVirtualHostFix
- UrlPrefix
- UrlPostfix

## ApacheVirtualHostFix

Fixes the resolving of URL's when using Apache VirtualHost in combination with VirtualDocumentRoot: 'VirtualDocumentRoot /www/hosts/%0/www'

Example:

    <?php
    $oApp = new \Slim\Slim();
    $oApp->add(new \Slim\Shady\Middleware\ApacheVirtualHostFix());
    $oApp->get('/my/name/is', function () { echo "Slim Shady!"; });
    $oApp->run();

Callable URL: /my/name/is

## UrlPrefix

Allow to use a generic URL-prefix without having to define it every time:

Example 1: simple

    <?php
    $oApp = new \Slim\Slim();
    $oApp->add(new \Slim\Shady\Middleware\UrlPrefix('/api'));
    $oApp->get('/login', function () { echo "Slim Shady!"; });
    $oApp->run();

Callable URL: /api/login

Example 2: advanced using regex-pattern

    <?php
     $oApp = new \Slim\Slim();
    $oRoutePrefix = new \Slim\Shady\Middleware\UrlPrefix('/api/:version');
    $oRoutePrefix->setConditions(array(
        'version' => 'v[0-9]+'
    ));
    $oApp->add($oRoutePrefix);
    $oApp->get('/login', function () use ($oApp) {
        echo "API-version: ".$oApp->urlprefix_params['version'];
    });
    $oApp->run();

Callable URL: /api/v2/login

## UrlPostfix

**todo**

Allow to use a generic URL-postfix without having to define it every time:

Example:

    <?php
    $oApp = new \Slim\Slim();
    $oApp->add(new \Slim\Shady\Middleware\UrlPostfix('.json'));
    $oApp->get('/login', function () { echo "Slim Shady!"; });
    $oApp->run();

Callable URL: /api/v2/login.json

## How to install?

Use Composer to install Shady and it's dependencies (Slim + PHP)

## License

Shady is released under the MIT public license.


[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/laroo/shady/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

