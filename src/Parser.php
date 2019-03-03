<?php namespace Intellex\Color;

use Intellex\Color\Exception\ColorCannotBeParsedException;
use Intellex\Color\Parser\ColorParsing;
use Intellex\Color\Parser\CSS\RGBAParser;
use Intellex\Color\Parser\CSS\RGBParser;
use Intellex\Color\Parser\RGBArrayParser;
use Intellex\Color\Parser\RGBStringParser;

/**
 * Class Parser parses a color from an input.
 *
 * @package Intellex\Manicure
 */
class Parser {

	/** @var ColorParsing[] The ordered list of all plugins that will try to parse the input. */
	private static $plugins = null;

	/**
	 * Parse an input as a color.
	 *
	 * @param mixed $input The input to parse.
	 *
	 * @return Color The parsed color.
	 * @throws ColorCannotBeParsedException If the supplied input cannot be parsed.
	 */
	public static function parse($input) {
		static::init();
		$exception = null;
		try {

			// Allow direct parsing
			if ($input instanceof Color) {
				return $input;
			}

			// Try each plugin in order
			foreach (static::$plugins as $plugin) {
				try {
					return $plugin->parse($input);
				} catch (ColorCannotBeParsedException $ex) {
				}
			}

		} catch (\Exception $ex) {
			$exception = $ex;
		}

		throw new ColorCannotBeParsedException($input, null, $exception);
	}

	/**
	 * Add a parser to the end of the list of current ones.
	 *
	 * @param ColorParsing $plugin The plugin to add.
	 */
	public static function registerParser(ColorParsing $plugin) {
		static::init();
		static::$plugins[] = $plugin;
	}

	/**
	 * Make sure that the default parsers are included.
	 */
	public static function init() {
		if (static::$plugins === null) {
			static::$plugins = [
				new RGBStringParser(),
				new RGBArrayParser(),
				new RGBParser(),
				new RGBAParser()
			];
		}
	}

}
