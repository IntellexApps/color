<?php namespace Intellex\Color\Exception;

/**
 * Class ValueNotAcceptableException indicates that a supplied value is not suitable for a specific
 * usage.
 *
 * @package Intellex\Color\Exception
 */
class ValueNotAcceptableException extends Exception {

	/** @var string The name of the target which did not accept the value. */
	private $target;

	/** @var mixed The value that was not accepted. */
	private $input;

	/** @var string|null An optional requirement to append to exception message. */
	private $requirement;

	/**
	 * ValueNotAcceptableException constructor.
	 *
	 * @param string $target The name of the target which did not accept the value.
	 * @param mixed  $input  The value that was not accepted.
	 * @param string|null An optional requirement to append to exception message.
	 */
	public function __construct($target, $input, $requirement = null) {
		$this->target = $target;
		$this->input = $input;
		$this->requirement = $requirement;

		// Additional message
		$suffix = null;
		if ($this->requirement) {
			$suffix = " {$requirement}.";
		}

		// Create the message
		ob_start();
		var_dump($this->input);
		$value = ob_get_clean();
		$message = "Target {$this->target} cannot accept the supplied value: {$value}.{$suffix}";

		parent::__construct($message);
	}

	/** @return string The name of the target which did not accept the value. */
	public function getTarget() {
		return $this->target;
	}

	/** @return mixed The value that was not accepted. */
	public function getInput() {
		return $this->input;
	}

	/** @return string|null string|null An optional requirement to append to exception message. */
	public function getRequirement() {
		return $this->requirement;
	}

}