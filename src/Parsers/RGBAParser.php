<?php declare(strict_types = 1);

namespace Intellex\Color\Parsers;

use Exception;
use Intellex\Color\Colors\Color;
use Intellex\Color\Colors\RGBA;
use Intellex\Color\Exception\ColorCannotBeParsed;
use RuntimeException;

/**
 * Parses an array of decimals values.
 */
class RGBAParser implements AbstractColorParser {

	/**
	 * Parse the supplied input as a color.
	 *
	 * @param int[] $input Decimal values of a color:
	 *                     index 0 - value for red
	 *                     index 1 - value for green
	 *                     index 2 - value for blue
	 *                     index 3 - value for alpha, as float ranging from 0.0 (transparent) to 1.0 (opaque).
	 *
	 * @return RGBA The parsed color.
	 * @throws ColorCannotBeParsed
	 */
	public function parse($input): Color {
		try {

			// Assert the supplied input is an array
			if (!is_array($input)) {
				throw new RuntimeException('Input not an array');
			}

			// Get the length, and append alpha if not supplied
			if (sizeof($input) === 3) {
				$input[] = 1;
			}

			// Assert: There must be exactly 4 values
			if (sizeof($input) !== 4) {
				throw new RuntimeException('Input must have exactly 3 or 4 elements');
			}

			// Assert: All values must be numeric
			if (
				!is_numeric($input[0]) ||
				!is_numeric($input[1]) ||
				!is_numeric($input[2]) ||
				!is_numeric($input[3])
			) {
				throw new RuntimeException('Non-numeric value in input');
			}

			// Assert: All values must be between 0 and 255 (inclusive), and between 0.0 and 1.0 for alpha
			if (
				($input[0] < 0 || $input[0] > 255) ||
				($input[1] < 0 || $input[1] > 255) ||
				($input[2] < 0 || $input[2] > 255) ||
				($input[3] < 0 || $input[3] > 1)
			) {
				throw new RuntimeException('Input values must bee between 0.0 and 1.0 (inclusive)');
			}

			return new RGBA((int) $input[0], (int) $input[1], (int) $input[2], (float) $input[3]);

		} catch (Exception $ex) {
			throw new ColorCannotBeParsed($input, $this, $ex);
		}
	}
}
