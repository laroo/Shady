<?php

namespace Slim\Shady;

class Eightmile extends \Slim\Route
{
	protected $constructorParams;
	
	protected $hasConstructorParams  =  false;
	
	public function setConstructorParams($constructorParams)
	{
		$this->sethasConstructorParams(true);
		$this->constructorParams  =  $constructorParams;
	}
	
	public function getConstructorParams()
	{
		return $this->constructorParams;
	}

	public function setHasConstructorParams($hasConstructorParams)
	{
		$this->hasConstructorParams  =  ($hasConstructorParams !== false);
	}

	public function getHasConstructorParams()
	{
		return $this->hasConstructorParams;
	}
}
