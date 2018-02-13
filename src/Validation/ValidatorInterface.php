<?php

namespace Arhitector\Validation;

use Arhitector\Validation;

/**
 * Interface for Phalcon\Validation\Validator
 *
 * @package Arhitector\Validation
 */
interface ValidatorInterface
{
	
	/**
	 * Checks if an option is defined
	 *
	 * @param string $key
	 *
	 * @return bool
	 */
	public function hasOption($key);
	
	/**
	 * Returns an option in the validator's options
	 * Returns null if the option hasn't set
	 *
	 * @param string $key
	 * @param mixed  $defaultValue
	 *
	 * @return mixed
	 */
	public function getOption($key, $defaultValue = null);
	
	/**
	 * Executes the validation
	 *
	 * @param Validation $validation
	 * @param string
	 *
	 * @return bool
	 */
	public function validate(Validation $validation, $attribute);
	
}