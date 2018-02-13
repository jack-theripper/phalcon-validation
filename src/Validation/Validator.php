<?php

namespace Arhitector\Validation;

use Arhitector\Validation;

/**
 * This is a base class for validators
 *
 * @package Arhitector\Validation
 */
abstract class Validator implements ValidatorInterface
{
	
	protected $_options;
	
	/**
	 * Phalcon\Validation\Validator constructor
	 *
	 * @param array $options
	 */
	public function __construct(array $options = null)
	{
		$this->_options = $options;
	}
	
	/**
	 * Checks if an option has been defined
	 *
	 * @deprecated since 2.1.0
	 * @see        \Phalcon\Validation\Validator::hasOption()
	 *
	 * @param string $key
	 * @return bool
	 */
	public function isSetOption($key)
	{
		return isset($this->_options[$key]);
	}
	
	/**
	 * Checks if an option is defined
	 *
	 * @param string $key
	 * @return bool
	 */
	public function hasOption($key)
	{
		return isset ($this->_options[$key]);
	}
	
	/**
	 * Returns an option in the validator's options
	 * Returns null if the option hasn't set
	 *
	 * @param string $key
	 * @param mixed  $defaultValue
	 * @return mixed
	 */
	public function getOption($key, $defaultValue = null)
	{
		$options = $this->_options;
		
		if (is_array($options))
		{
			if (isset($options[$key]))
			{
				$value = $options[$key];
				
				/*
				 * If we have attribute it means it's Uniqueness validator, we
				 * can have here multiple fields, so we need to check it
				 */
				if ($key == "attribute" && is_array($value))
				{
					if (isset($value[$key]))
					{
						return $value[$key];
					}
				}
				return $value;
			}
		}
		
		return $defaultValue;
	}
	
	/**
	 * Sets an option in the validator
	 *
	 * @param string $key
	 * @param mixed  $value
	 *
	 * @return void
	 */
	public function setOption($key, $value)
	{
		$this->_options[$key] = $value;
	}
	
	/**
	 * Executes the validation
	 *
	 * @param Validation $validation
	 * @param string     $attribute
	 *
	 * @return  bool
	 */
	abstract public function validate(Validation $validation, $attribute);
	
	/**
	 * Prepares a label for the field.
	 *
	 * @param Validation $validation
	 * @param string     $field
	 *
	 * @return mixed
	 */
	protected function prepareLabel(Validation $validation, $field)
	{
		$label = $this->getOption("label");
		
		if (is_array($label))
		{
			$label = $label[$field];
		}
		
		if (empty ($label))
		{
			$label = $validation->getLabel($field);
		}
		
		return $label;
	}
	
	/**
	 * Prepares a validation message.
	 *
	 * @param Validation $validation
	 * @param string     $field
	 * @param string     $type
	 * @param string     $option
	 *
	 * @return mixed
	 */
	protected function prepareMessage(Validation $validation, $field, $type, $option = "message")
	{
		$message = $this->getOption($option);
		
		if (is_array($message))
		{
			$message = $message[$field];
		}
		
		if (empty ($message))
		{
			$message = $validation->getDefaultMessage($type);
		}
		
		return $message;
	}
	
	/**
	 * Prepares a validation code.
	 *
	 * @param string $field
	 *
	 * @return int|null
	 */
	protected function prepareCode($field)
	{
		$code = $this->getOption("code");
		
		if (is_array($code))
		{
			$code = $code[$field];
		}
		
		return $code;
	}
	
}