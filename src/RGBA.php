<?php namespace Intellex\Color;

use Intellex\Color\Exception\Exception;
use Intellex\Color\Exception\ValueNotAcceptableException;

/**
 * Class RGBA represents a color with values of red, green, blue and alpha channel (transparency).
 *
 * @package Intellex\Color
 */
class RGBA implements Color {

	/** @var int The amount of red, as integer ranging from 0 to 255 (inclusive). */
	private $red;

	/** @var int The amount of green, as integer ranging from 0 to 255 (inclusive). */
	private $green;

	/** @var int The amount of blue, as integer ranging from 0 to 255 (inclusive). */
	private $blue;

	/** @var float The alpha channel, as float ranging from 0.0 to 1.0 (inclusive). */
	private $alpha;

	/** @var CMYK|null The cached CMYK representation of this color. */
	private $cmyk = null;

	/**
	 * Color constructor.
	 *
	 * @param int   $red   The amount of red, as integer ranging from 0 to 255 (inclusive).
	 * @param int   $green The amount of green, as integer ranging from 0 to 255 (inclusive).
	 * @param int   $blue  The amount of blue, as integer ranging from 0 to 255 (inclusive).
	 * @param float $alpha The alpha channel, as float ranging from 0.0 to 1.0 (inclusive).
	 *
	 * @throws ValueNotAcceptableException If any of the supplied parameters is invalid or out of
	 *                                     range.
	 */
	public function __construct($red, $green, $blue, $alpha = 0.0) {

		// Set the parameters
		$this->setRed($red);
		$this->setGreen($green);
		$this->setBlue($blue);
		$this->setAlpha($alpha);
	}

	/**
	 * @param int $red The amount of red, as integer ranging from 0 to 255 (inclusive).
	 *
	 * @throws ValueNotAcceptableException If value is not between 0 and 255 (inclusive).
	 */
	public function setRed($red) {
		if ($red < 0 || $red > 255) {
			throw new ValueNotAcceptableException('RGBA.red', $red);
		}

		$this->red = (int) round($red);
	}

	/**
	 * @param int $green The amount of green, as integer ranging from 0 to 255 (inclusive).
	 *
	 * @throws ValueNotAcceptableException If value is not between 0 and 255 (inclusive).
	 */
	public function setGreen($green) {
		if ($green < 0 || $green > 255) {
			throw new ValueNotAcceptableException('RGBA.green', $green);
		}

		$this->green = (int) round($green);
	}

	/**
	 * @param int $blue The amount of blue, as integer ranging from 0 to 255 (inclusive).
	 *
	 * @throws ValueNotAcceptableException If value is not between 0 and 255 (inclusive).
	 */
	public function setBlue($blue) {
		if ($blue < 0 || $blue > 255) {
			throw new ValueNotAcceptableException('RGBA.blue', $blue);
		}

		$this->blue = (int) round($blue);
	}

	/**
	 * @param float $alpha The alpha channel, as float ranging from 0.0 to 1.0 (inclusive).
	 *
	 * @throws ValueNotAcceptableException If value is not between 0.0 and 1.0 (inclusive).
	 */
	public function setAlpha($alpha) {
		if ($alpha < 0 || $alpha > 1) {
			throw new ValueNotAcceptableException('RGBA.alpha', $alpha);
		}

		$this->alpha = $alpha * 1.0;
	}

	/** @return int The amount of red, as integer ranging from 0 to 255 (inclusive). */
	public function getRed() {
		return $this->red;
	}

	/** @return int The amount of green, as integer ranging from 0 to 255 (inclusive). */
	public function getGreen() {
		return $this->green;
	}

	/** @return int The amount of blue, as integer ranging from 0 to 255 (inclusive). */
	public function getBlue() {
		return $this->blue;
	}

	/** @return float The alpha channel, as float ranging from 0.0 to 1.0 (inclusive). */
	public function getAlpha() {
		return $this->alpha;
	}

	/**
	 * Output a color to a CSS string.
	 *
	 * @return string The CSS representation of this color, which always includes alpha.
	 */
	public function toCSS() {
		$values = [
			$this->getRed(),
			$this->getGreen(),
			$this->getBlue(),
			1 - $this->getAlpha()
		];

		return 'rgba(' . implode(', ', $values) . ');';
	}

	/**
	 * Print the color as hexadecimal string, in format #AARRGGBB (# and AA are optional).
	 *
	 * @param bool $includeAlpha   True to include alpha channel in front.
	 * @param bool $includeHashTag True to include the hash tag in front.
	 * @param bool $uppercase      True to use uppercase, false to user lowercase.
	 *
	 * @return string The resulting hexadecimal string.
	 */
	public function toHexString($includeAlpha = true, $includeHashTag = true, $uppercase = true) {
		return implode('', array_filter([
			$includeHashTag ? '#' : null,
			$includeAlpha ? static::decToHex($this->getAlpha() * 255, $uppercase) : null,
			static::decToHex($this->getRed(), $uppercase),
			static::decToHex($this->getGreen(), $uppercase),
			static::decToHex($this->getBlue(), $uppercase)
		]));
	}

	/**
	 * @noinspection PhpDocMissingThrowsInspection
	 * Allocate a color for an image.
	 *
	 * @param resource $image An image resource, returned by one of the image creation functions,
	 *                        such as imageCreateTrueColor().
	 *
	 * @return resource|boolean A color identifier, or false if the allocation failed.
	 */
	public function toImageColorIdentifier($image) {
		if (function_exists('imageColorAllocateAlpha')) {
			/** @noinspection PhpComposerExtensionStubsInspection */
			return imageColorAllocateAlpha($image, $this->getRed(), $this->getGreen(), $this->getBlue(), $this->getAlpha() * 127);
		}

		/** @noinspection PhpUnhandledExceptionInspection */
		throw new Exception('Extension ext-gd is required for toImageColorIdentifier() method.');
	}

	/**
	 * Convert decimal number to a hexadecimal string.
	 *
	 * @param integer $decimal   The decimal number to convert.
	 * @param bool    $uppercase True to use upper case, false for lowercase.
	 *
	 * @return string The resulting hexadecimal string.
	 */
	public static function decToHex($decimal, $uppercase = true) {
		$result = str_pad(dechex($decimal), '2', '0', STR_PAD_LEFT);

		// Uppercase
		if ($uppercase) {
			$result = strtoupper($result);
		}

		return $result;
	}

	/**
	 * Get the color in RGBA color space.
	 *
	 * @return RGBA The RGBA representation of this color.
	 */
	public function getRGBA() {
		return $this;
	}

	/**
	 * Get the color in CMYK color space.
	 *
	 * @return CMYK The CMYK representation of this color.
	 */
	public function getCMYK() {
		try {

			// Handle cache
			if ($this->cmyk === null) {

				// Prepare
				$red = $this->getRed() / 255;
				$green = $this->getGreen() / 255;
				$blue = $this->getBlue() / 255;

				// Handle black
				$black = 1 - max($red, $green, $blue);
				if ($black === 1) {
					$this->cmyk = new CMYK(0, 0, 0, 1);

				} else {
					$this->cmyk = new CMYK(
						(1 - $red - $black) / (1 - $black),
						(1 - $green - $black) / (1 - $black),
						(1 - $blue - $black) / (1 - $black),
						$black
					);
				}
			}

			return $this->cmyk;

		} catch (ValueNotAcceptableException $ex) {
			return null;
		}
	}

}
