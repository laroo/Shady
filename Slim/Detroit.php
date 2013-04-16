<?php

namespace Slim\Shady;

class Detroit extends \Slim\Router
{
    /**
     * Map a route object to a callback function
     * @param  string     $pattern      The URL pattern (ie. "/books/:id")
     * @param  mixed      $callable     Anything that returns TRUE for is_callable()
     * @return \Slim\Route
     */
    public function map($pattern, $callable)
    {
    	if(isset($callable[2])) // callable2 contains constructorparams.
    	{
    		$constructorparams  =  $callable[2];
    		unset($callable[2]);
    	}

    	$route = new \Slim\Shady\Eightmile($pattern, $callable);

        if(isset($constructorparams))
        {
        	$route->setConstructorParams($constructorparams);
        }
        $this->routes[] = $route;

        return $route;
    }

    /**
     * Dispatch route
     *
     * This method invokes the route object's callable. If middleware is
     * registered for the route, each callable middleware is invoked in
     * the order specified.
     *
     * @param  \Slim\Route                  $route  The route object
     * @return bool                         Was route callable invoked successfully?
     */
    public function dispatch(\Slim\Route $route)
    {
        $this->currentRoute = $route;

        //Invoke middleware
        foreach ($route->getMiddleware() as $mw) {
            call_user_func_array($mw, array($route));
        }
        
    	if (is_array($route->getCallable())) {
    		$aFunct = $route->getCallable();
    		if (is_string($aFunct[0])) {
    			if($route instanceof \Slim\Shady\Eightmile && $route->getHasConstructorParams())
    			{
    				$params  =  $route->getConstructorParams();
	        		$aFunct[0] = new $aFunct[0]($params);
	        		unset($aFunct[2]);
    			}
    			else 
    			{
    				$aFunct[0] = new $aFunct[0];
    			}
	        	$route->setCallable($aFunct);
    		}
        }

        //Invoke callable
        $mResult  =  call_user_func_array($route->getCallable(), array_values($route->getParams()));
		if($mResult instanceof \Slim\Represent)
		{
			$mResult->renderOutput();
			exit;
		}

        return true;
    }
    
}
