<?php

/**
 * Shady UrlPrefix Middleware for the Slim Framework
 *
 * Description:
 *   Allow to use a generic URL-prefix without having to define it every time:
 *
 * Example 1: simple
 *   $oApp = new \Slim\Slim();
 *   $oApp->add(new \Slim\Shady\Middleware\UrlPrefix('/api'));
 *   $oApp->get('/login', function () { echo "Slim Shady!"; });
 *   $oApp->run();
 *
 * Callable URL: /api/login
 *
 * Example 2: advanced using regex-pattern
 *   $oApp = new \Slim\Slim();
 *
 *   $oRoutePrefix = new \Slim\Shady\Middleware\UrlPrefix('/api/:version');
 *   $oRoutePrefix->setConditions(array(
 *       'version' => 'v[0-9]+'
 *   ));
 *   $oApp->add($oRoutePrefix);
 *
 *   $oApp->get('/login', function () use ($oApp) {
 *       echo "API-version: ".$oApp->urlprefix_params['version'];
 *   });
 *   $oApp->run();
 *
 * Callable URL: /api/v2/login
 *
 * @author Jan-Age Laroo <jan-age@minus3.nl>
 * @link https://github.com/laroo/Shady
 *
 */

namespace Slim\Shady\Middleware;

class UrlPrefix extends \Slim\Middleware
{

	protected $sOriginalUri;
	protected $sCleanedUri;

	/**
	 * @var string The route pattern (e.g. "/books/:id")
	 */
	protected $pattern;

	/**
	 * @var array Conditions for this route's URL parameters
	 */
	protected $conditions = array();

	/**
	 * @var array Key-value array of URL parameters
	 */
	protected $params = array();

	/**
	 * @var array value array of URL parameter names
	 */
	protected $paramNames = array();

	/**
	 * @var array key array of URL parameter names with + at the end
	 */
	protected $paramNamesPath = array();

	public function __construct($psPattern)
	{
		if (!is_string($psPattern) || empty($psPattern)) {
			throw new \OutOfBoundsException('Invalid prefix: "' . $psPattern . '"');
		} elseif ( substr($psPattern,0,1) !== '/') {
			throw new \OutOfBoundsException('Prefix must start with a slash: "' . $psPattern . '"');
		}

		$this->pattern = $psPattern;

	}

	function call()
	{
		$_SERVER['SCRIPT_NAME'] = '/';

		$oEnv = $this->app->environment();
		if ( !$oEnv->offsetExists('PATH_INFO') ) {
			throw new \UnexpectedValueException('Variable "PATH_INFO" not set in enviroment!');
		}


		$this->sOriginalUri = $oEnv->offsetGet('PATH_INFO');

		// Match!
		$this->matches($this->sOriginalUri);

		$oEnv->offsetSet('PATH_INFO', $this->sCleanedUri);
		$this->app->urlprefix_params = $this->params;

		\FB::log($this->sOriginalUri, __CLASS__.'::$this->sOriginalUri');
		\FB::log($this->sCleanedUri, __CLASS__.'::$this->sCleanedUri');
		\FB::log($this->app->urlprefix_params, 'Slim::$this->urlprefix_params');

//		\FB::log($this->params,'params');
//		\FB::log($this->paramNames,'paramNames');
//		\FB::log($this->paramNamesPath,'paramNamesPath');
//		\FB::log($this->conditions,'conditions');

		$this->next->call();

	}


	/**
	 * Matches URI?
	 *
	 * Parse this route's pattern, and then compare it to an HTTP resource URI
	 * This method was modeled after the techniques demonstrated by Dan Sosedoff at:
	 *
	 * http://blog.sosedoff.com/2009/09/20/rails-like-php-url-router/
	 *
	 * @param  string $resourceUri A Request URI
	 * @return bool
	 */
	public function matches($resourceUri)
	{
		//Convert URL params into regex patterns, construct a regex for this route, init params
		$patternAsRegex = preg_replace_callback(
			'#:([\w]+)\+?#',
			array($this, 'matchesCallback'),
			str_replace(')', ')?', (string) $this->pattern)
		);
		if (substr($this->pattern, -1) === '/') {
			$patternAsRegex .= '?';
		}

		//
		$patternAsRegex .= '(?P<__shady_posturi__>.*)';

		\FB::log($patternAsRegex,__METHOD__);

		//Cache URL params' names and values if this route matches the current HTTP request
		if (!preg_match('#^' . $patternAsRegex . '$#', $resourceUri, $paramValues)) {
			return false;
		}
		\FB::log($paramValues,__METHOD__);

		foreach ($this->paramNames as $name) {
			if (isset($paramValues[$name])) {
				if (isset($this->paramNamesPath[ $name ])) {
					$this->params[$name] = explode('/', urldecode($paramValues[$name]));
				} else {
					$this->params[$name] = urldecode($paramValues[$name]);
				}
			}
		}

		if (isset($paramValues['__shady_posturi__'])) {
			$this->sCleanedUri = $paramValues['__shady_posturi__'];
		}

		return true;
	}

	/**
	 * Convert a URL parameter (e.g. ":id", ":id+") into a regular expression
	 * @param  array    $m  URL parameters
	 * @return string       Regular expression for URL parameter
	 */
	protected function matchesCallback($m)
	{
		$this->paramNames[] = $m[1];
		if (isset($this->conditions[ $m[1] ])) {
			return '(?P<' . $m[1] . '>' . $this->conditions[ $m[1] ] . ')';
		}
		if (substr($m[0], -1) === '+') {
			$this->paramNamesPath[ $m[1] ] = 1;

			return '(?P<' . $m[1] . '>.+)';
		}

		return '(?P<' . $m[1] . '>[^/]+)';
	}

	/**
	 * Get route conditions
	 * @return array
	 */
	public function getConditions()
	{
		return $this->conditions;
	}

	/**
	 * Set route conditions
	 * @param  array $conditions
	 */
	public function setConditions(array $conditions)
	{
		$this->conditions = $conditions;
	}

}
