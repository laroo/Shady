# Shady

A set of shady Slim Framework middlewares that can solve some annoyances...

## What does it contain?

Available middlewares:
- ApacheVirtualHostFix
- UrlPrefix
- UrlPostfix
- NoMoreAnonymousFunctions

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

**todo**

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
     $oPrefix = new \Slim\Shady\Middleware\UrlPrefix('/api/:version');
     $oPrefix->setConditions(array(
        'version' => 'v[0-9]+'
     ));
     $oApp->add($oPrefix);
     $oApp->get('/login', function () { echo "Slim Shady!"; });
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

## NoMoreAnonymousFunctions

**todo**
Slim disallows the use of non-anonymous functions for routing. This makes reusing your code impossible.

## How to install?

Use Composer to install Shady and it's dependencies (Slim + PHP)

## License

Shady is released under the MIT public license.
