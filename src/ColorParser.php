<?php declare(strict_types = 1);

namespace Intellex\Color;

use Intellex\Color\Colors\Color;
use Intellex\Color\Exception\ColorCannotBeParsed;
use Intellex\Color\Parsers\CMYKParser;
use Intellex\Color\Parsers\AbstractColorParser;
use Intellex\Color\Parsers\CSS\CMYKCssParser;
use Intellex\Color\Parsers\CSS\RGBACssParser;
use Intellex\Color\Parsers\CSS\RGBCssParser;
use Intellex\Color\Parsers\RGBAParser;
use Intellex\Color\Parsers\RGBAStringParser;

/**
 * Parses a color from an input.
 */
class ColorParser {

	/** @var AbstractColorParser[] The ordered list of all plugins that will try to parse the input. */
	private static array $plugins = [];

	/**
	 * Parse an input as a color.
	 *
	 * @param mixed $input   The input to parse.
	 * @param mixed $default The default color if the input cannot be parsed.
	 *
	 * @return Color The parsed color.
	 * @throws ColorCannotBeParsed If the supplied input cannot be parsed.
	 */
	public static function parse($input, $default = null): Color {
		static::init();

		// Allow direct parsing
		if ($input instanceof Color) {
			return $input;
		}

		// Try each plugin in order
		foreach (self::$plugins as $plugin) {
			try {
				return $plugin->parse($input);

				// phpcs:ignore Generic.CodeAnalysis.EmptyStatement.DetectedCatch
			} catch (ColorCannotBeParsed $ex) {
				// Safely ignore
			}
		}

		// There must be a default value
		if ($default === null) {
			throw new ColorCannotBeParsed($input);
		}

		return $default instanceof Color
			? $default
			: self::parse($default);
	}

	/**
	 * Add a parser to the end of the list of current ones.
	 *
	 * @param AbstractColorParser $plugin The plugin to add.
	 */
	public static function registerParser(AbstractColorParser $plugin): void {
		self::$plugins[] = $plugin;
	}

	/**
	 * Make sure that the default parsers are included.
	 */
	public static function init(): void {
		if (count(self::$plugins) === 0) {
			self::registerParser(new RGBAStringParser());
			self::registerParser(new CMYKCssParser());
			self::registerParser(new RGBCssParser());
			self::registerParser(new RGBACssParser());
			self::registerParser(new CMYKParser());
			self::registerParser(new RGBAParser());
		}
	}
}
