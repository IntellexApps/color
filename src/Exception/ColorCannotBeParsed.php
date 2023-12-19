<?php declare(strict_types = 1);

namespace Intellex\Color\Exception;

use Intellex\Color\Parsers\AbstractColorParser;
use RuntimeException;
use Throwable;

/**
 * Indicates that an input cannot be parsed to a color.
 */
class ColorCannotBeParsed extends RuntimeException {

	/**
	 * ColorCannotBeParsedException constructor.
	 *
	 * @param mixed                    $input    The input that could not have been parsed to a color.
	 * @param AbstractColorParser|null $parser   Optional parser that failed to parse the input.
	 * @param Throwable|null           $previous The optional previous exception.
	 */
	public function __construct($input, $parser = null, $previous = null) {

		// Which parser failed
		$parserName = null;
		if ($parser) {
			$parserName = ' by ' . get_class($parser);
		}

		// Include the reason
		$reasonMessage = null;
		if ($previous) {
			$reasonMessage = " ({$previous->getMessage()})";
		}

		parent::__construct(
			"The supplied color cannot be parsed{$parserName}: '{$input}'{$reasonMessage}",
			500,
			$previous
		);
	}
}
