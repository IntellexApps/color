<?php namespace Intellex\Color\Exception;

/**
 * Class Exception
 * Color base exception.
 *
 * @package Intellex\Color\Exception
 */
class Exception extends \Exception {

	/**
	 * Throw an exception.
	 *
	 * @param Exception $exception The exception to throw.
	 *
	 * @throws Exception Always.
	 */
	public static function fire(Exception $exception) {
		throw $exception;
	}

}
