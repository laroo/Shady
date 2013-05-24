<?php
namespace Slim;

require_once 'Detroit.php';
require_once 'Eightmile.php';
require_once 'Represent.php';


/**
 * 
 * @see I'm very much a creature of habit.
 */
class Shady extends Slim {
	
	protected $default404;
	
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
    
    public function shady404()
    {
    	if (!is_null($this->default404))
    	{
    		call_user_func_array(array($this->default404[0], $this->default404[1]), array($this->default404[2]));
    	}
    	else
    	{
    		parent::notFound();
    	}
    }
    
    /**
     * 
     * @param array $callable | array(CLASS, FUNCTION, PARAM);
     */
    public function set404($callable)
    {
    	$this->default404 = $callable;
    }
}
