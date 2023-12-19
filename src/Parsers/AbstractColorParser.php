<?php declare(strict_types=1);

namespace Intellex\Color\Parsers;

use Intellex\Color\Colors\Color;
use Intellex\Color\Exception\ColorCannotBeParsed;

/**
 * Interface ColorParsing declares the API for all mixed to Color parsers to follow.
 */
interface AbstractColorParser {

	/**
	 * Parse the supplied input as a color.
	 *
	 * @param mixed $input The input to try to parse.
	 *
	 * @return Color The parsed color.
	 * @throws ColorCannotBeParsed If the supplied input cannot be parsed into a color.
	 */
	public function parse($input): Color;
}
