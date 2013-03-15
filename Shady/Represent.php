<?php
namespace Slim;

/**
 * 
 * @see I am who I am and I say what I think. I’m not putting a face on for the record.
 */
class Represent extends Slim 
{
	private $sRepresentFormat;
	private $mOutputData;
	private $sOutputDataFormat;

	private $bResponseSucces  =  FALSE; // @todo: implement
	private $sResponseStatus  =  'fail'; // @todo: implement

	private $sOutputDatacontainer;

	private $sDebugCall;
	private $sDebugMethod;
	private $sDebugMessage;

	public function setRepresentFormat($psRepresentFormat)
	{
		$aAlowedRepresentFormats  =  array(
			'json'
		);
		if(!in_array($psRepresentFormat, $aAlowedRepresentFormats))
		{
			throw new \InvalidArgumentException('Illegal $psRepresentFormat');
		}

		$this->sRepresentFormat  =  $psRepresentFormat;
	}

	public function setOutputDataFormat($psOutputDataFormat)
	{
		if(!is_string($psOutputDataFormat))
		{
			ob_start();
			
			print_r($psOutputDataFormat);
			
			$ob  =  ob_end_clean();
			throw new \InvalidArgumentException('Illegal datatype for $psOutputDataFormat :' . $ob);
		}
		$aAlowedOutputDataFormats  =  array(
			  'int'      => 'int'
			, 'integer'  => 'integer'
			, 'str'      => 'str'
			, 'string'   => 'string'
			, 'array'    => 'array'
		);
		if(!in_array($psOutputDataFormat, $aAlowedOutputDataFormats))
		{
			throw new \InvalidArgumentException('Illegal $psOutputDataFormat :' . $psOutputDataFormat);
		}
		$this->sOutputDataFormat  =  $psOutputDataFormat;
	}

	public function setOutputDataContainer($psOutputDataContainer)
	{
		$aAlowedOutputDataContainers  =  array(
			  'model'
			, 'collection'
		);
		if(!in_array($psOutputDataContainer, $aAlowedOutputDataContainers))
		{
			throw new \InvalidArgumentException('Illegal $psOutputDataContainer');
		}
		$this->sOutputDatacontainer  =  $psOutputDataContainer;
	}

	public function setOutputData($pmOutPutData)
	{
		switch($this->sOutputDataFormat)
		{
			case 'int':
			case 'integer':
				if(!ctype_digit((string)$pmOutPutData))
				{
					throw new \InvalidArgumentException('$pmOutPutData no integer, though specified');
				}
				break;
			case 'str':
			case 'string':
				if(!is_string($pmOutPutData))
				{
					throw new \InvalidArgumentException('$pmOutPutData no string, though specified');
				}
				break;
			case 'array':
				if(!is_array($pmOutPutData))
				{
					throw new \InvalidArgumentException('$pmOutPutData no array, though specified');
				}
				break;
			case NULL:
			default:
				throw new \UnexpectedValueException('sOutputDataFormat has no valid value');
				break;
		}
		$this->mOutputData  =  $pmOutPutData;
	}

	public function setResponseStatus($psResponseStatus)
	{
		if(!is_string($psResponseStatus))
		{
			throw new \InvalidArgumentException('$psResponseStatus no string');
		}
		$this->sResponseStatus  =  $psResponseStatus;
	}
	public function setResponseSuccess($pbResponseSuccess)
	{
		if(!is_bool($pbResponseSuccess))
		{
			throw new \UnexpectedValueException('$pbResponseSuccess should have a boolean value');
		}
		$this->bResponseSuccess  =  $pbResponseSuccess;
	}

	public function setDebugCall($psDebugCall)
	{
		$this->sDebugCall  =  $psDebugCall;
	}
	public function setDebugMethod($psDebugMethod)
	{
		$this->sDebugMethod  =  $psDebugMethod;
	}
	public function setDebugMessage($psDebugMessage)
	{
		$this->sDebugMessage  =  $psDebugMessage;
	}

	public function renderOutput()
	{
		switch($this->sRepresentFormat)
		{
			case 'json':
				$this->renderJson();
				return;
			default:
				throw new \Exception('No output format specified.');
		}
	}

	public function renderJson()
	{
		self::http_addnocacheheaders();
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($this->_toArray());
	}

	public function _toArray()
	{
		$aReturn  =  array(
			  'status' => $this->sResponseStatus
			, 'response' => array(
				  'success'  =>  $this->bResponseSuccess
				, $this->sOutputDatacontainer  =>  $this->mOutputData
			)	
		);
		
		if(defined('API_DEBUG_MODE') && API_DEBUG_MODE)
		{
			if(!is_null($this->sDebugCall))
			$aReturn['debug']['call'   ]  =  $this->sDebugCall;
			if(!is_null($this->sDebugMethod))
			$aReturn['debug']['method' ]  =  $this->sDebugMethod;
			if(!is_null($this->sDebugMessage))
			$aReturn['debug']['message']  =  $this->sDebugMessage;
		}
		return $aReturn;
	}

	/**
	 * Stel headers in die het cachen van de browser uitzetten.
	 */
	public static function http_addnocacheheaders()
	{
		if( isset($_SERVER["HTTP_USER_AGENT"]) && strstr($_SERVER["HTTP_USER_AGENT"],"MSIE") !== false) 
		{
			// Internet Explorer!
			header("Cache-Control: no-cache");
			header("Expires: -1"); 
		} 
		else 
		{
			// Overige browsers
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");	
		}
	}
}
