<?php
namespace Bitrix\Seo\Engine;

use Bitrix\Main\Web;

class YandexException
	extends \Exception
{
	protected $code;
	protected $message;
	
	protected $result;
	protected $status;
	
	public function __construct($queryResult, \Exception $previous = NULL)
	{
//		exception use two classes - new and old. Define them
		if ($queryResult)
		{
			if ($queryResult instanceof \CHTTP)
			{
				$this->result = $queryResult->result;
				$this->status = $queryResult->status;
			}
			elseif ($queryResult instanceof Web\HttpClient)
			{
				$this->result = $queryResult->getResult();
				$this->status = $queryResult->getStatus();
			}
		}
		
		if (!$queryResult)
		{
			parent::__construct('no result', 0, $previous);
		}
		elseif ($this->parseError())
		{
			parent::__construct($this->code . ': ' . $this->message, $this->status, $previous);
		}
		else
		{
			parent::__construct($this->result, $this->status, $previous);
		}
	}
	
	public function getStatus()
	{
		return $this->status;
	}
	
	protected function parseError()
	{
		$matches = array();
		if (preg_match("/<error code=\"([^\"]+)\"><message>([^<]+)<\/message><\/error>/", $this->result, $matches))
		{
			$this->code = $matches[1];
			$this->message = $matches[2];
			
			return true;
		}
		
		return false;
	}
}
