<?php

namespace Arhitector;

use Arhitector\Validation\MessageInterface;
use Arhitector\Validation\ValidatorInterface;

/**
 * Interface for the Phalcon\Validation component
 *
 * @package Arhitector\Validator
 */
interface ValidationInterface
{
	
	/**
	 * Validate a set of data according to a set of rules
	 *
	 * @param array|object data
	 * @param object entity
	 *
	 * @return \Arhitector\Validation\Message\Group
	 */
	public function validate($data = null, $entity = null);
	
	/**
	 * Adds a validator to a field
	 *
	 * @param string             $field
	 * @param ValidatorInterface $validator
	 *
	 * @return Validation
	 */
	public function add($field, ValidatorInterface $validator);
	
	/**
	 * Alias of `add` method
	 *
	 * @param string             $field
	 * @param ValidatorInterface $validator
	 *
	 * @return Validation
	 */
	public function rule($field, ValidatorInterface $validator);
	
	/**
	 * Adds the validators to a field
	 *
	 * @param string $field
	 * @param array  $validators
	 *
	 * @return Validation
	 */
	public function rules($field, array $validators);
	
	/**
	 * Adds filters to the field
	 *
	 * @param string       $field
	 * @param array|string $filters
	 *
	 * @return \Arhitector\Validation
	 */
	public function setFilters($field, $filters);
	
	/**
	 * Returns all the filters or a specific one
	 *
	 * @param string $field
	 *
	 * @return mixed
	 */
	public function getFilters($field = null);
	
	/**
	 * Returns the validators added to the validation
	 */
	public function getValidators();
	
	/**
	 * Returns the bound entity
	 *
	 * @return object
	 */
	public function getEntity();
	
	/**
	 * Adds default messages to validators
	 *
	 * @param array $messages
	 * @return
	 */
	public function setDefaultMessages(array $messages = []);
	
	/**
	 * Get default message for validator type
	 *
	 * @param string type
	 */
	public function getDefaultMessage($type);
	
	/**
	 * Returns the registered validators
	 *
	 * @return \Arhitector\Validation\Message\Group
	 */
	public function getMessages();
	
	/**
	 * Adds labels for fields
	 *
	 * @param array $labels
	 */
	public function setLabels(array $labels);
	
	/**
	 * Get label for field
	 *
	 * @param string field
	 *
	 * @return string
	 */
	public function getLabel($field);
	
	/**
	 * Appends a message to the messages list
	 *
	 * @param MessageInterface $message
	 */
	public function appendMessage(MessageInterface $message);
	
	/**
	 * Assigns the data to an entity
	 * The entity is used to obtain the validation values
	 *
	 * @param object entity
	 * @param array|object data
	 *
	 * @return \Arhitector\Validation
	 */
	public function bind($entity, $data);
	
	/**
	 * Gets the a value to validate in the array/object data source
	 *
	 * @param string field
	 *
	 * @return mixed
	 */
	public function getValue($field);
	
}