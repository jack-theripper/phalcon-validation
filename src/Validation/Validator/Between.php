<?php

namespace Arhitector\Validation\Validator;

use Arhitector\Validation;
use Arhitector\Validation\Message;
use Arhitector\Validation\Validator;

/**
 * Phalcon\Validation\Validator\Between
 *
 * Validates that a value is between an inclusive range of two values.
 * For a value x, the test is passed if minimum<=x<=maximum.
 *
 * <code>
 * use Phalcon\Validation;
 * use Phalcon\Validation\Validator\Between;
 *
 * $validator = new Validation();
 *
 * $validator->add(
 *     "price",
 *     new Between(
 *         [
 *             "minimum" => 0,
 *             "maximum" => 100,
 *             "message" => "The price must be between 0 and 100",
 *         ]
 *     )
 * );
 *
 * $validator->add(
 *     [
 *         "price",
 *         "amount",
 *     ],
 *     new Between(
 *         [
 *             "minimum" => [
 *                 "price"  => 0,
 *                 "amount" => 0,
 *             ],
 *             "maximum" => [
 *                 "price"  => 100,
 *                 "amount" => 50,
 *             ],
 *             "message" => [
 *                 "price"  => "The price must be between 0 and 100",
 *                 "amount" => "The amount must be between 0 and 50",
 *             ],
 *         ]
 *     )
 * );
 * </code>
 *
 * @package Arhitector\Validation\Validator
 */
class Between extends Validator
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
		$minimum = $this->getOption("minimum");
		$maximum = $this->getOption("maximum");
		
		if (is_array($minimum))
		{
			$minimum = $minimum[$attribute];
		}
		
		if (is_array($maximum))
		{
			$maximum = $maximum[$attribute];
		}
		
		if ($value < $minimum || $value > $maximum)
		{
			$label = $this->prepareLabel($validation, $attribute);
			$message = $this->prepareMessage($validation, $attribute, "Between");
			$code = $this->prepareCode($attribute);
			
			$replacePairs = [":field" => $label, ":min" => $minimum, ":max" => $maximum];
			
			$validation->appendMessage(new Message(strtr($message, $replacePairs), $attribute, "Between", $code));
			
			return false;
		}
		
		return true;
	}
	
}