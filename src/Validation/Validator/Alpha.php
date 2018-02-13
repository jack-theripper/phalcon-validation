<?php

namespace Arhitector\Validation\Validator;

use Arhitector\Validation;
use Arhitector\Validation\Message;
use Arhitector\Validation\Validator;

/**
 * Phalcon\Validation\Validator\Alpha
 *
 * Check for alphabetic character(s)
 *
 * <code>
 * use Phalcon\Validation;
 * use Phalcon\Validation\Validator\Alpha as AlphaValidator;
 *
 * $validator = new Validation();
 *
 * $validator->add(
 *     "username",
 *     new AlphaValidator(
 *         [
 *             "message" => ":field must contain only letters",
 *         ]
 *     )
 * );
 *
 * $validator->add(
 *     [
 *         "username",
 *         "name",
 *     ],
 *     new AlphaValidator(
 *         [
 *             "message" => [
 *                 "username" => "username must contain only letters",
 *                 "name"     => "name must contain only letters",
 *             ],
 *         ]
 *     )
 * );
 * </code>
 *
 * @package Arhitector\Validation\Validator
 */
class Alpha extends Validator
{
	
	/**
	 * Executes the validation
	 *
	 * @param Validation $validation
	 * @param string     $attribute
	 *
	 * @return  bool
	 * @throws Validation\Exception
	 */
	public function validate(Validation $validation, $attribute)
	{
		$value = $validation->getValue($attribute);
		
		if (preg_match("/[^[:alpha:]]/imu", $value))
		{
			$label = $this->prepareLabel($validation, $attribute);
			$message = $this->prepareMessage($validation, $attribute, "Alpha");
			$code = $this->prepareCode($attribute);
			
			$replacePairs = [":field" => $label];
			
			$validation->appendMessage(new Message(strtr($message, $replacePairs), $attribute, "Alpha", $code));
			
			return false;
		}
		
		return true;
	}
	
}