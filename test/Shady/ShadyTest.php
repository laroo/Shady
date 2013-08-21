<?php

class ShadyTest extends PHPUnit_Framework_TestCase {

	public function setUp()
	{
		//Remove environment mode if set
		unset($_ENV['SLIM_MODE']);

		//Reset session
		$_SESSION = array();

		//Prepare default environment variables
		\Slim\Environment::mock(array(
			'SCRIPT_NAME' => '/foo', //<-- Physical
			'PATH_INFO' => '/bar', //<-- Virtual
			'QUERY_STRING' => 'one=foo&two=bar',
			'SERVER_NAME' => 'slimframework.com',
		));
	}

	/**
	 * Test default instance properties
	 */
	public function testDefaultInstanceProperties()
	{
		$s = new \Slim\Shady();
		$this->assertInstanceOf('\Slim\Http\Request', $s->request());
		$this->assertInstanceOf('\Slim\Http\Response', $s->response());
		$this->assertInstanceOf('\Slim\Shady\Detroit', $s->router());
		$this->assertInstanceOf('\Slim\View', $s->view());
		$this->assertInstanceOf('\Slim\Log', $s->getLog());
		$this->assertEquals(\Slim\Log::DEBUG, $s->getLog()->getLevel());
		$this->assertTrue($s->getLog()->getEnabled());
		$this->assertInstanceOf('\Slim\Environment', $s->environment());
	}

}
