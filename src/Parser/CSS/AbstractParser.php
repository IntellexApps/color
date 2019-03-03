<?php namespace Intellex\Color\Parser\CSS;

use Intellex\Color\Color;
use Intellex\Color\Exception\ColorCannotBeParsedException;
use Intellex\Color\Parser\ColorParsing;

/**
 * Class AbstractParser is the base parser for all CSS-specific color formats.
 *
 * @package Intellex\Color\Parser\CSS
 */
abstract class AbstractParser implements ColorParsing {

	/** @inheritdoc */
	public function parse($input) {
		try {

			// Clean up the input
			$input = trim($input);

			// Prepare parameters regexp, which matches everything but delimiters
			$parameters = array_fill(0, $this->defineParameterCount(), '([^, ]+?)%?');

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
				foreach ($values as $i => $value) {
					if (!is_numeric($values[$i])) {
						throw new \Exception("Non-numeric value encountered: '{$value}'");
					}
				}

				return $this->parseParameters($values);

			} else {
				throw new \Exception('Unable to extract values');
			}

		} catch (\Exception $ex) {
			if ($ex instanceof ColorCannotBeParsedException) {
				throw $ex;
			} else {
				throw new ColorCannotBeParsedException($input, $this, $ex);
			}
		}
	}

	/**
	 * Convert a percentage to a float, ranging from 0.0 to 1.0.
	 *
	 * @param string $input The input to convert, with an ending percentage.
	 *
	 * @return float The value, as float ranging from 0.0 to 1.0 (both inclusive).
	 */
	protected static function asPercentage($input) {
		return trim($input, '% ') / 100;
	}

	/**
	 * Define the name used before the brackets.
	 *
	 * @return string The prefix to use as the name before the brackets.
	 */
	abstract protected function definePrefix();

	/**
	 * Define the number of parameters in the expression.
	 *
	 * @return int The number of parameters to expect in the expression.
	 */
	abstract protected function defineParameterCount();

	/**
	 * Parse the parameters to color.
	 *
	 * @param string[] $parameters The retrieved parameters.
	 *
	 * @return Color|null The parsed color, or null if color could be parsed.
	 * @throws \Exception
	 */
	abstract protected function parseParameters(array $parameters);

}