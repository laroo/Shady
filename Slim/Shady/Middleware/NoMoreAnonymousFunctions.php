<?php

namespace Slim\Shady\Middleware;

class NoMoreAnonymousFunctions extends \Slim\Middleware
{
	function call(){
		// TODO
		return $this->app->call();
	}
}
