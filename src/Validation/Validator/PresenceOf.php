<?php

namespace Arhitector\Validation\Validation\Validator;

use Arhitector\Validation;
use Arhitector\Validation\Message;
use Arhitector\Validation\Validator;

/**
 * Validates that a value is not null or empty string
 *
 * <code>
 * use Phalcon\Validation;
 * use Phalcon\Validation\Validator\PresenceOf;
 *
 * $validator = new Validation();
 *
 * $validator->add(
 *     "name",
 *     new PresenceOf(
 *         [
 *             "message" => "The name is required",
 *         ]
 *     )
 * );
 *
 * $validator->add(
 *     [
 *         "name",
 *         "email",
 *     ],
 *     new PresenceOf(
 *         [
 *             "message" => [
 *                 "name"  => "The name is required",
 *                 "email" => "The email is required",
 *             ],
 *         ]
 *     )
 * );
 * </code>
 *
 * @package Arhitector\Validation\Validation\Validator
 */
class PresenceOf extends Validator
{
	
	/**
	 * Executes the validation
	 *
	 * @param Validation $validation
	 * @param string     $attribute
	 *
	 * @return  bool
	 */
	public function validate(Validation $validation, $attribute)
	{
		$value = $validation->getValue($attribute);
		
		if ($value === null || $value === "")
		{
			$label = $this->prepareLabel($validation, $attribute);
			$message = $this->prepareMessage($validation, $attribute, "PresenceOf");
			$code = $this->prepareCode($attribute);
			
			$replacePairs = [":field" => $label];
			
			$validation->appendMessage(new Message(strtr($message, $replacePairs), $attribute, "PresenceOf", $code));
			
			return false;
		}
		
		return true;
	}
	
}
