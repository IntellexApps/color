<?php namespace Intellex\Color\Parser;

use Intellex\Color\CMYK;
use Intellex\Color\Exception\ColorCannotBeParsedException;

/**
 * Class IntegerArrayPlugin.
 *
 * @package Intellex\Color\Plugin
 */
class CMYKArrayParser implements ColorParsing {

	/**
	 * Parse the supplied input as a color.
	 *
	 * @param int[] $input Decimal values of a color:
	 *                     index 0 - value for cyan
	 *                     index 1 - value for magenta
	 *                     index 2 - value for yellow
	 *                     index 3 - value for K (defaults to 0 if length is 3)
	 *
	 * @return CMYK The parsed color.
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

			return new CMYK($input[0], $input[1], $input[2], $input[3]);

		} catch (\Exception $ex) {
			throw new ColorCannotBeParsedException($input, $this, $ex);
		}
	}

}