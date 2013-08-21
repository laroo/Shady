<?php

/**
 * Shady ApacheVirtualHostFix Middleware for the Slim Framework
 *
 * Description:
 *   Fixes the resolving of URL's when using Apache VirtualHost in combination with VirtualDocumentRoot:
 *   'VirtualDocumentRoot /www/hosts/%0/www'
 *
 * Example:
 *   $oApp = new \Slim\Slim();
 *   $oApp->add(new \Slim\Shady\Middleware\ApacheVirtualHostFix());
 *   $oApp->get('/my/name/is', function () { echo "Slim Shady!"; });
 *   $oApp->run();
 *
 * @author Jan-Age Laroo <jan-age@minus3.nl>
 * @link https://github.com/laroo/Shady
 *
 */

namespace Slim\Shady\Middleware;

/**
 * Class ApacheVirtualHostFix
 * @package Slim\Shady\Middleware
 */
class ApacheVirtualHostFix extends \Slim\Middleware
{
	function call()
	{
		// Shady fix!
		$_SERVER['SCRIPT_NAME'] = '/';

		return $this->app->call();
	}
}
