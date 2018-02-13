<?php

namespace Arhitector\Validation\Message;

use Arhitector\Validation\Exception;
use Arhitector\Validation\Message;
use Arhitector\Validation\MessageInterface;

/**
 * Represents a group of validation messages
 *
 * @package Arhitector\Validation\Message
 */
class Group implements \Countable, \ArrayAccess, \Iterator
{
	
	protected $_position = 0;
	
	protected $_messages = [];
	
	/**
	 * Phalcon\Validation\Message\Group constructor
	 *
	 * @param array messages
	 */
	public function __construct($messages = null)
	{
		if (is_array($messages))
		{
			$this->_messages = $messages;
		}
	}
	
	/**
	 * Gets an attribute a message using the array syntax
	 *
	 *<code>
	 * print_r(
	 *     $messages[0]
	 * );
	 *</code>
	 *
	 * @param int $index
	 *
	 * @return Message|bool
	 */
	public function offsetGet($index)
	{
		if (isset($this->_messages[$index]))
		{
			return $this->_messages[$index];
		}
		
		return false;
	}
	
	/**
	 * Sets an attribute using the array-syntax
	 *
	 *<code>
	 * $messages[0] = new \Phalcon\Validation\Message("This is a message");
	 *</code>
	 *
	 * @param int   $index
	 * @param mixed $message
	 *
	 * @param Message
	 * @throws Exception
	 */
	public function offsetSet($index, $message)
	{
		if ( ! is_object($message))
		{
			throw new Exception("The message must be an object");
		}
		$this->_messages[$index] = $message;
	}
	
	/**
	 * Checks if an index exists
	 *
	 *<code>
	 * var_dump(
	 *     isset($message["database"])
	 * );
	 *</code>
	 *
	 * @param int $index
	 * @return boolean
	 */
	public function offsetExists($index)
	{
		return isset ($this->_messages[$index]);
	}
	
	/**
	 * Removes a message from the list
	 *
	 *<code>
	 * unset($message["database"]);
	 *</code>
	 *
	 * @param int $index
	 *
	 * @return void
	 */
	public function offsetUnset($index)
	{
		if (isset($this->_messages[$index]))
		{
			array_splice($this->_messages, $index, 1);
		}
	}
	
	/**
	 * Appends a message to the group
	 *
	 *<code>
	 * $messages->appendMessage(
	 *     new \Phalcon\Validation\Message("This is a message")
	 * );
	 *</code>
	 *
	 * @param MessageInterface $message
	 */
	public function appendMessage(MessageInterface $message)
	{
		$this->_messages[] = $message;
	}
	
	/**
	 * Appends an array of messages to the group
	 *
	 *<code>
	 * $messages->appendMessages($messagesArray);
	 *</code>
	 *
	 * @param  MessageInterface[] messages
	 * @throws Exception
	 */
	public function appendMessages($messages)
	{
		if ( ! is_array($messages) && ! is_object($messages))
		{
			throw new Exception("The messages must be array or object");
		}
		
		$currentMessages = $this->_messages;
		
		if (is_array($messages))
		{
			// An array of messages is simply merged into the current one
			if (is_array($currentMessages))
			{
				$finalMessages = array_merge($currentMessages, $messages);
			}
			else
			{
				$finalMessages = $messages;
			}
			
			$this->_messages = $finalMessages;
		}
		else
		{
			// A group of messages is iterated and appended one-by-one to the current list
			foreach ($messages as $message)
			{
				$this->appendMessage($message);
			}
		}
	}
	
	/**
	 * Filters the message group by field name
	 *
	 * @param string $fieldName
	 * @return array
	 */
	public function filter($fieldName)
	{
		$filtered = [];
		$messages = $this->_messages;
		
		if (is_array($messages))
		{
			// A group of messages is iterated and appended one-by-one to the current list
			foreach ($messages as $message)
			{
				if (method_exists($message, "getField")) // Get the field name
				{
					if ($fieldName == $message->getField())
					{
						$filtered[] = $message;
					}
				}
			}
		}
		
		return $filtered;
	}
	
	/**
	 * Returns the number of messages in the list
	 *
	 * @return int
	 */
	public function count()
	{
		return count($this->_messages);
	}
	
	/**
	 * Rewinds the internal iterator
	 *
	 * @return void
	 */
	public function rewind()
	{
		$this->_position = 0;
	}
	
	/**
	 * Returns the current message in the iterator
	 *
	 * @return Message
	 */
	public function current()
	{
		return $this->_messages[$this->_position];
	}
	
	/**
	 * Returns the current position/key in the iterator
	 *
	 * @return int
	 */
	public function key()
	{
		return $this->_position;
	}
	
	/**
	 * Moves the internal iteration pointer to the next position
	 *
	 * @return void
	 */
	public function next()
	{
		$this->_position++;
	}
	
	/**
	 * Check if the current message in the iterator is valid
	 *
	 * @return bool
	 */
	public function valid()
	{
		return isset ($this->_messages[$this->_position]);
	}
	
	/**
	 * Magic __set_state helps to re-build messages variable when exporting
	 *
	 * @param array group
	 * @return Group
	 */
	public static function __set_state($group)
	{
		return new self($group["_messages"]);
	}
	
}