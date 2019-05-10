<?php namespace Intellex\Color\Exception;

use Intellex\Color\Parser\ColorParsing;

/**
 * Class ColorCannotBeParsedException indicates that a input cannot be parsed to a color.
 *
 * @package Intellex\Color\Exception
 */
class ColorCannotBeParsedException extends \RuntimeException {

	/** @var ColorParsing|null Optional parser that failed to parse the input. */
	private $parser;

	/** @var \Throwable|null The reason why the parsing failed */
	private $reason;

	/**
	 * ColorCannotBeParsedException constructor.
	 *
	 * @param mixed             $input  The input that could not have been parsed to a color.
	 * @param ColorParsing|null $parser Optional parser that failed to parse the input.
	 * @param \Throwable|null   $reason The reason why the parsing failed.
	 */
	public function __construct($input, $parser = null, $reason = null) {

		// Which parser failed
		$parserName = null;
		if ($this->parser = $parser) {
			$parserName = ' by ' . get_class($this->parser);
		}

		// Include the reason
		$reasonMessage = null;
		if ($this->reason = $reason) {
			$reasonMessage = " ({$this->reason->getMessage()})";
		}

		$input = print_r($input, true);
		parent::__construct("The supplied color cannot be parsed{$parserName}: '{$input}'{$reasonMessage}", 500, $this);
	}

	/** @return ColorParsing|null Optional parser that failed to parse the input. */
	public function getParser() {
		return $this->parser;
	}

	/** @return \Throwable|null $reason The reason why the parsing failed. */
	public function getReason() {
		return $this->reason;
	}

}
