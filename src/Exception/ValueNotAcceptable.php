<?php declare(strict_types = 1);

namespace Intellex\Color\Exception;

use RuntimeException;

/**
 * Indicates that a supplied value is not suitable for a specific
 * usage.
 */
class ValueNotAcceptable extends RuntimeException {

	/** @var string The name of the target which did not accept the value. */
	private string $target;

	/** @var string The value that was not accepted. */
	private string $input;

	/** @var string|null An optional requirement to append to exception message. */
	private ?string $requirement;

	/**
	 * @param string      $target      The name of the target which did not accept the value.
	 * @param mixed       $input       The value that was not accepted.
	 * @param string|null $requirement An optional requirement to append to exception message.
	 */
	public function __construct(string $target, $input, ?string $requirement = null) {
		$this->target = $target;
		$this->input = (string) $input;
		$this->requirement = $requirement;

		// Additional message
		$message = $this->requirement
			? " {$requirement}."
			: null;

		// Create the message
		$message = "Target {$this->target} cannot accept the supplied value: '{$this->input}'.{$message}";

		parent::__construct($message);
	}

	/** @return string The name of the target which did not accept the value. */
	public function getTarget(): string {
		return $this->target;
	}

	/** @return string The string representation of the value that was not accepted. */
	public function getInput(): string {
		return $this->input;
	}

	/** @return string|null An optional requirement to append to exception message. */
	public function getRequirement(): ?string {
		return $this->requirement;
	}
}
