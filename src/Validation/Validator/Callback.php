<?php

namespace Arhitector\Validation\Validation\Validator;

use Arhitector\Validation;
use Arhitector\Validation\Message;
use Arhitector\Validation\Validator;
use Exception;

/**
 * Calls user function for validation
 *
 * <code>
 * use Phalcon\Validation;
 * use Phalcon\Validation\Validator\Callback as CallbackValidator;
 * use Phalcon\Validation\Validator\Numericality as NumericalityValidator;
 *
 * $validator = new Validation();
 *
 * $validator->add(
 *     ["user", "admin"],
 *     new CallbackValidator(
 *         [
 *             "message" => "There must be only an user or admin set",
 *             "callback" => function($data) {
 *                 if (!empty($data->getUser()) && !empty($data->getAdmin())) {
 *                     return false;
 *                 }
 *
 *                 return true;
 *             }
 *         ]
 *     )
 * );
 *
 * $validator->add(
 *     "amount",
 *     new CallbackValidator(
 *         [
 *             "callback" => function($data) {
 *                 if (!empty($data->getProduct())) {
 *                     return new NumericalityValidator(
 *                         [
 *                             "message" => "Amount must be a number."
 *                         ]
 *                     );
 *                 }
 *             }
 *         ]
 *     )
 * );
 * </code>
 *
 * @package Arhitector\Validation\Validation\Validator
 */
class Callback extends Validator
{
	
	/**
	 * Executes the validation
	 *
	 * @param Validation $validation
	 * @param string     $attribute
	 *
	 * @return  bool
	 * @throws Exception
	 */
	public function validate(Validation $validation, $attribute)
	{
		$callback = $this->getOption("callback");
		
		if (is_callable($callback))
		{
			$data = $validation->getEntity();
			
			if (empty($data))
			{
				$data = $validation->getData();
			}
			
			$returnedValue = call_user_func($callback, $data);
			
			if (is_bool($returnedValue))
			{
				if ( ! $returnedValue)
				{
					$label = $this->prepareLabel($validation, $attribute);
					$message = $this->prepareMessage($validation, $attribute, "Callback");
					$code = $this->prepareCode($attribute);
					$replacePairs = [":field" => $label];
					
					$validation->appendMessage(new Message(strtr($message, $replacePairs), $attribute, 'Callback', $code));
					
					return false;
				}
				
				return true;
			}
			else if (is_object($returnedValue) && $returnedValue instanceof Validator)
			{
				return $returnedValue->validate($validation, $attribute);
			}
			
			throw new Exception("Callback must return boolean or Phalcon\\Validation\\Validator object");
		}
		
		return true;
	}
	
}
