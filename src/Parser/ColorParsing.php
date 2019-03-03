<?php namespace Intellex\Color\Parser;

use Intellex\Color\Color;
use Intellex\Color\Exception\ColorCannotBeParsedException;

/**
 * Interface ColorParsing declares the API for all mixed to Color parsers to follow.
 */
interface ColorParsing {

	/**
	 * Parse the supplied input as a color.
	 *
	 * @param mixed $input The input to try to parse.
	 *
	 * @return Color The parsed color.
	 * @throws ColorCannotBeParsedException If the supplied input cannot be parsed into a color.
	 */
	public function parse($input);

}
