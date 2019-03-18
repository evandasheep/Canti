<?php

if (!$intracall)
{
	http_response_code(403);
	die();
}

class Message
{
	const MESSAGETYPE = array(
		10 => "Dictionary",
		11 => "WordList",
		12 => "Word",
		50 => "Error",
		91 => "Access Denied",
		98 => "Generic Response",
		99 => "Authorize"
	);
	
	private $Type;
	private $Lines;
	
	function __construct($type,$data)
	{
		if (!array_key_exists($type,Message::MESSAGETYPE))
			throw new Error("Invalid Message Type");
		$this->Type = $type;
		
		if(!is_array($data))
			$this->Lines = array(0 => $data);
		else
			$this->Lines = $data;
	}
	
	function json()
	{
		return json_encode(
			array(
				"TYPE" => $this->Type,
				"DATA" => $this->Lines
				)
			);
	}
	
}