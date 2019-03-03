<?php namespace Intellex\Color\Parser;

use Intellex\Color\Color;
use Intellex\Color\Exception\ColorCannotBeParsedException;
use Intellex\Color\RGBA;

/**
 * Class StringRGBPlugin parses an RGB string into a color.
 * Supports the following formats, where each letter is represented with a hexadecimal number, case
 * insensitive:
 *  - RGB
 *  - ARGB
 *  - RRGGBB
 *  - AARRGGBB
 *  - #RGB
 *  - #ARGB
 *  - #RRGGBB
 *  - #AARRGGBB
 *
 * @package Intellex\Color\Plugin
 */
class RGBStringParser implements ColorParsing {

	/**
	 * Parse the supplied input as a color.
	 *
	 * @param string $input The input to try to parse.
	 *
	 * @return Color The parsed color.
	 * @throws ColorCannotBeParsedException If the supplied input cannot be parsed into a color.
	 */
	public function parse($input) {
		try {

			// Assert the supplied input is a string
			if (!is_string($input)) {
				throw new \Exception('Input is not a string');
			}

			// Clean up the input
			$input = ltrim(trim($input), '# ');

			// Define common regexp elements
			$len = strlen($input) > 4 ? 2 : 1;
			$hex = "[0-9A-F]{{$len}}";

			// Match
			if (preg_match("~^(?'alpha'{$hex})?(?'red'{$hex})(?'green'{$hex})(?'blue'{$hex})$~ i", $input, $color)) {

				/**
				 * @var string $alpha
				 * @var string $red
				 * @var string $green
				 * @var string $blue
				 */
				extract($color);

				// Handle optional alpha value
				if ($alpha === '') {
					$alpha = str_repeat('0', $len);
				}

				// Handle the digit number per number
				if (strlen($alpha) + strlen($red) + strlen($green) + strlen($blue) !== $len * 4) {
					throw new \Exception('Wrong lengths');
				}

				// Return the color
				return new RGBA(
					static::hexToDec($red),
					static::hexToDec($green),
					static::hexToDec($blue),
					static::hexToDec($alpha) / 255
				);

			} else {
				throw new \Exception('Unable to extract the values');
			}

		} catch (\Exception $ex) {
			throw new ColorCannotBeParsedException($input, $this, $ex);
		}
	}

	/**
	 * Convert the hexadecimal number to decimal, but apply the minimal length of 2 (ie. 'F' becomes
	 * 'FF').
	 *
	 * @param string $hex The hexadecimal number to convert to decimal.
	 *
	 * @return int The decimal value of the supplied hexadecimal number.
	 */
	private static function hexToDec($hex) {

		// Handle minimal length
		if (strlen($hex) === 1) {
			$hex .= $hex;
		}

		// Convert to decimal
		return hexdec($hex);
	}

}