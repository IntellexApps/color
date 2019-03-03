<?php namespace Intellex\Color\Parser;

use Intellex\Color\Exception\ColorCannotBeParsedException;
use Intellex\Color\RGBA;

/**
 * Class RGBArrayParser parses an array of decimals values.
 *
 * @package Intellex\Color\Plugin
 */
class RGBArrayParser implements ColorParsing {

	/**
	 * Parse the supplied input as a color.
	 *
	 * @param int[] $input Decimal values of a color:
	 *                     index 0 - value for red
	 *                     index 1 - value for green
	 *                     index 2 - value for blue
	 *                     index 3 - value for alpha (defaults to 0 (full opacity) if length is 3)
	 *
	 * @return RGBA The parsed color.
	 * @throws ColorCannotBeParsedException
	 */
	public function parse($input) {
		try {

			// Assert the supplied input is an array
			if (!is_array($input)) {
				throw new \Exception('Input not an array');
			}

			// Get the length, and append alpha if not supplied
			if (sizeof($input) === 3) {
				$input[] = 0;
			}

			// Assert the array length
			if (sizeof($input) !== 4) {
				throw new \Exception('Input must have exactly 3 or 4 elements');
			}

			// Assert the values
			if (!is_numeric($input[0]) || !is_numeric($input[1]) || !is_numeric($input[2]) || !is_numeric($input[3])) {
				throw new \Exception('Non-numeric value in input');
			}

			return new RGBA($input[0], $input[1], $input[2], $input[3]);

		} catch (\Exception $ex) {
			throw new ColorCannotBeParsedException($input, $this, $ex);
		}
	}

}