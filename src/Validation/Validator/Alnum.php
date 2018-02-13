<?php

namespace Arhitector\Validation\Validator;


use Arhitector\Validation;
use Arhitector\Validation\Message;
use Arhitector\Validation\Validator;

/**
 * Phalcon\Validation\Validator\Alnum
 *
 * Check for alphanumeric character(s)
 *
 * <code>
 * use Phalcon\Validation;
 * use Phalcon\Validation\Validator\Alnum as AlnumValidator;
 *
 * $validator = new Validation();
 *
 * $validator->add(
 *     "username",
 *     new AlnumValidator(
 *         [
 *             "message" => ":field must contain only alphanumeric characters",
 *         ]
 *     )
 * );
 *
 * $validator->add(
 *     [
 *         "username",
 *         "name",
 *     ],
 *     new AlnumValidator(
 *         [
 *             "message" => [
 *                 "username" => "username must contain only alphanumeric characters",
 *                 "name"     => "name must contain only alphanumeric characters",
 *             ],
 *         ]
 *     )
 * );
 * </code>
 *
 * @package Arhitector\Validation\Validator
 */
class Alnum extends Validator
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
		
		if ( ! ctype_alnum($value))
		{
			$label = $this->prepareLabel($validation, $attribute);
			$message = $this->prepareMessage($validation, $attribute, "Alnum");
			$code = $this->prepareCode($attribute);
			
			$replacePairs = [":field" => $label];
			
			$validation->appendMessage(new Message(strtr($message, $replacePairs), $attribute, "Alnum", $code));
			
			return false;
		}
		
		return true;
	}
	
}