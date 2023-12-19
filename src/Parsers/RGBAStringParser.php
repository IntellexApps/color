<?php declare(strict_types = 1);

namespace Intellex\Color\Parsers;

use Exception;
use Intellex\Color\Colors\Color;
use Intellex\Color\Colors\RGBA;
use Intellex\Color\Exception\ColorCannotBeParsed;
use RuntimeException;

/**
 * Parses an RGB string into a color.
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
 */
class RGBAStringParser implements AbstractColorParser {

	/**
	 * Parse the supplied input as a color.
	 *
	 * @param string $input The input to try to parse.
	 *
	 * @return Color The parsed color.
	 * @throws ColorCannotBeParsed If the supplied input cannot be parsed into a color.
	 */
	public function parse($input): Color {
		try {

			// Clean up the input
			$input = ltrim(trim((string) $input), '# ');

			// Define common regexp elements
			$len = strlen($input) > 4 ? 2 : 1;
			$hex = "[0-9A-F]{{$len}}";

			// Match
			if (preg_match("~^(?'alpha'{$hex})?(?'red'{$hex})(?'green'{$hex})(?'blue'{$hex})$~ i", $input, $color)) {

				// Extract values
				$red = $color['red'];
				$green = $color['green'];
				$blue = $color['blue'];
				$alpha = $color['alpha'] ?: str_repeat('F', $len);

				// Handle the digit number per number
				if (strlen($alpha) + strlen($red) + strlen($green) + strlen($blue) !== $len * 4) {
					throw new RuntimeException('Wrong length');
				}

				// Return the color
				return new RGBA(
					static::hexToDec($red),
					static::hexToDec($green),
					static::hexToDec($blue),
					static::hexToDec($alpha) / 255
				);
			}

			throw new RuntimeException('Unable to extract the values');

		} catch (Exception $ex) {
			throw new ColorCannotBeParsed($input, $this, $ex);
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
	public static function hexToDec(string $hex): int {

		// Handle minimal length
		if (strlen($hex) === 1) {
			$hex .= $hex;
		}

		// Convert to decimal
		return (int) hexdec($hex);
	}
}
