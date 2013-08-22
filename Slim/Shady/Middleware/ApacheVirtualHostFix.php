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

		/**
		 * Docs from \Slim\Environment:
		 *
		 * Application paths
		 *
		 * This derives two paths: SCRIPT_NAME and PATH_INFO. The SCRIPT_NAME
		 * is the real, physical path to the application, be it in the root
		 * directory or a subdirectory of the public document root. The PATH_INFO is the
		 * virtual path to the requested resource within the application context.
		 *
		 * With htaccess, the SCRIPT_NAME will be an absolute path (without file name);
		 * if not using htaccess, it will also include the file name. If it is "/",
		 * it is set to an empty string (since it cannot have a trailing slash).
		 *
		 * The PATH_INFO will be an absolute path with a leading slash; this will be
		 * used for application routing.
		 */

		// Shady fix!
		//$_SERVER['SCRIPT_NAME'] = '/';
		$oEnv = $this->app->environment();
		$oEnv->offsetSet('SCRIPT_NAME','/');
		//$oEnv['SCRIPT_NAME'] = '/';


		$this->next->call();
	}
}
