<?php

require_once 'Detroit.php';
require_once 'Eightmile.php';

namespace Slim;

/**
 * 
 * @see I'm very much a creature of habit.
 */
class Shady extends Slim {
	
	/**
     * Constructor
     * 
     * @see (w)Rap was my drug.
     * 
     * @param  array $userSettings Associative array of application settings
     */
    public function __construct($userSettings = array())
    {
    	// Make it as shady as possible!
    	$_SERVER['SCRIPT_NAME'] = '/';
    	parent::__construct();
    	$this->router = new \Slim\Shady\Detroit();
    	
    }
    
}
