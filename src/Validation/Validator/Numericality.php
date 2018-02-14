<?php

namespace Arhitector\Validation\Validation\Validator;

use Arhitector\Validation;
use Arhitector\Validation\Message;
use Arhitector\Validation\Validator;

/**
 * Check for a valid numeric value
 *
 * <code>
 * use Phalcon\Validation;
 * use Phalcon\Validation\Validator\Numericality;
 *
 * $validator = new Validation();
 *
 * $validator->add(
 *     "price",
 *     new Numericality(
 *         [
 *             "message" => ":field is not numeric",
 *         ]
 *     )
 * );
 *
 * $validator->add(
 *     [
 *         "price",
 *         "amount",
 *     ],
 *     new Numericality(
 *         [
 *             "message" => [
 *                 "price"  => "price is not numeric",
 *                 "amount" => "amount is not numeric",
 *             ]
 *         ]
 *     )
 * );
 * </code>
 *
 * @package Arhitector\Validation\Validation\Validator
 */
class Numericality extends Validator
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
		
		if ( ! preg_match("/^-?\d+\.?\d*$/", $value))
		{
			$label = $this->prepareLabel($validation, $attribute);
			$message = $this->prepareMessage($validation, $attribute, "Numericality");
			$code = $this->prepareCode($attribute);
			
			$replacePairs = [":field" => $label];
			
			$validation->appendMessage(new Message(strtr($message, $replacePairs), $attribute, "Numericality", $code));
			
			return false;
		}
		
		return true;
	}
	
}
