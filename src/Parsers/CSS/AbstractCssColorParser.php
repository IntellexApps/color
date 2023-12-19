<?php declare(strict_types = 1);

namespace Intellex\Color\Parsers\CSS;

use Exception;
use Intellex\Color\Colors\Color;
use Intellex\Color\Exception\ColorCannotBeParsed;
use Intellex\Color\Parsers\AbstractColorParser;
use RuntimeException;

/**
 * The base parser for all CSS-specific color formats.
 */
abstract class AbstractCssColorParser implements AbstractColorParser {

	/** @inheritdoc */
	public function parse($input): Color {
		try {

			// Clean up the input
			$input = trim((string) $input);

			// Prepare parameters regexp, which matches everything but delimiters
			$parameters = array_fill(0, $this->defineParameterCount(), '([^, ]+?)%?') ?: [];

			// Build regexp
			$regexp = [
				$this->definePrefix(),
				'\(',
				implode('\s*,\s*', $parameters),
				'\)',
				';?'
			];

			// Match
			if (preg_match('~^' . implode('\s*', $regexp) . '~ i', $input, $match)) {
				$values = array_slice($match, 1);

				// Make sure the parameters are acceptable
				foreach ($values as $value) {
					if (!is_numeric($value)) {
						throw new RuntimeException("Non-numeric value encountered: '{$value}'");
					}
				}

				return $this->parseParameters($values);
			}

			throw new RuntimeException('Unable to extract values');

		} catch (Exception $ex) {
			throw new ColorCannotBeParsed($input, $this, $ex);
		}
	}

	/**
	 * Convert a percentage to a float, ranging from 0.0 to 1.0.
	 *
	 * @param string $input The input to convert, with an ending percentage.
	 *
	 * @return float The value, as float ranging from 0.0 to 1.0 (both inclusive).
	 */
	protected static function fromPercentage(string $input): float {
		return (float) trim($input, '% ') / 100;
	}

	/**
	 * Define the name used before the brackets.
	 *
	 * @return string The prefix to use as the name before the brackets.
	 */
	abstract protected function definePrefix(): string;

	/**
	 * Define the number of parameters in the expression.
	 *
	 * @return int The number of parameters to expect in the expression.
	 */
	abstract protected function defineParameterCount(): int;

	/**
	 * Parse the parameters to color.
	 *
	 * @param string[] $parameters The retrieved parameters.
	 *
	 * @return Color The parsed color, or null if color could be parsed.
	 * @throws Exception
	 */
	abstract protected function parseParameters(array $parameters): Color;
}
