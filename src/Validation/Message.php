<?php

namespace Arhitector\Validation;

/**
 * Class Message
 *
 * @package Arhitector\Validation
 */
class Message implements MessageInterface
{
	
	protected $type;
	
	protected $message;
	
	protected $field;
	
	protected $code;
	
	/**
	 * Message constructor
	 *
	 * @param string  $message
	 * @param mixed   $field
	 * @param string  $type
	 * @param integer $code
	 */
	public function __construct($message, $field = null, $type = null, $code = null)
	{
		$this->message = $message;
		$this->field = $field;
		$this->type = $type;
		$this->code = $code;
	}
	
	/**
	 * Sets message type
	 *
	 * @param string $type
	 *
	 * @return Message
	 */
	public function setType($type)
	{
		$this->type = $type;
		
		return $this;
	}
	
	/**
	 * Returns message type
	 *
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}
	
	/**
	 * Sets verbose message
	 *
	 * @param string $message
	 *
	 * @return Message
	 */
	public function setMessage($message)
	{
		$this->message = $message;
		
		return $this;
	}
	
	/**
	 * Returns verbose message
	 *
	 * @return string
	 */
	public function getMessage()
	{
		return $this->message;
	}
	
	/**
	 * Sets field name related to message
	 *
	 * @param string $field
	 *
	 * @return Message
	 */
	public function setField($field)
	{
		$this->field = $field;
		
		return $this;
	}
	
	/**
	 * Returns field name related to message
	 *
	 * @return string
	 */
	public function getField()
	{
		return $this->field;
	}
	
	/**
	 * Sets code for the message
	 *
	 * @param int $code
	 *
	 * @return Message
	 */
	public function setCode($code)
	{
		$this->code = $code;
		
		return $this;
	}
	
	/**
	 * Returns the message code
	 *
	 * @return int
	 */
	public function getCode()
	{
		return $this->code;
	}
	
	/**
	 * Magic __toString method returns verbose message
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->message;
	}
	
	/**
	 * Magic __set_state helps to recover messages from serialization
	 *
	 * @param array $message
	 *
	 * @return MessageInterface
	 */
	public static function __set_state(array $message)
	{
		return new self($message["_message"], $message["_field"], $message["_type"]);
	}
	
}