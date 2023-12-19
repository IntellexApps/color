<?php declare(strict_types = 1);

namespace Intellex\Color\Colors;

use Intellex\Color\Exception\ValueNotAcceptable;
use LogicException;

/**
 * Color defined by: Red Green Blue Alpha.
 */
class RGBA implements Color {

	/** @var int The amount of red, as integer ranging from 0 to 255 (inclusive). */
	private int $red;

	/** @var int The amount of green, as integer ranging from 0 to 255 (inclusive). */
	private int $green;

	/** @var int The amount of blue, as integer ranging from 0 to 255 (inclusive). */
	private int $blue;

	/** @var float The alpha channel, as float ranging from 0.0 (transparent) to 1.0 (opaque). */
	private float $alpha;

	/** @var CMYK|null The cached CMYK representation of this color. */
	private ?CMYK $cmyk = null;

	/**
	 * Color constructor.
	 *
	 * @param int   $red   The amount of red, as integer ranging from 0 to 255 (inclusive).
	 * @param int   $green The amount of green, as integer ranging from 0 to 255 (inclusive).
	 * @param int   $blue  The amount of blue, as integer ranging from 0 to 255 (inclusive).
	 * @param float $alpha The alpha channel, as float ranging from 0.0 (transparent) to 1.0 (opaque).
	 *
	 * @throws ValueNotAcceptable If any of the supplied parameters is invalid or out of
	 *                                     range.
	 */
	public function __construct(int $red, int $green, int $blue, float $alpha = 1.0) {
		$this->setRed($red);
		$this->setGreen($green);
		$this->setBlue($blue);
		$this->setAlpha($alpha);
	}

	/**
	 * @param int $red The amount of red, as integer ranging from 0 to 255 (inclusive).
	 *
	 * @throws ValueNotAcceptable If value is not between 0 and 255 (inclusive).
	 */
	public function setRed(int $red): self {
		if ($red < 0 || $red > 255) {
			throw new ValueNotAcceptable('RGBA.red', $red, 'Allowed range: [0, 255]');
		}

		$this->red = (int) round($red);
		return $this;
	}

	/**
	 * @param int $green The amount of green, as integer ranging from 0 to 255 (inclusive).
	 *
	 * @throws ValueNotAcceptable If value is not between 0 and 255 (inclusive).
	 */
	public function setGreen(int $green): self {
		if ($green < 0 || $green > 255) {
			throw new ValueNotAcceptable('RGBA.green', $green, 'Allowed range: [0, 255]');
		}

		$this->green = (int) round($green);
		return $this;
	}

	/**
	 * @param int $blue The amount of blue, as integer ranging from 0 to 255 (inclusive).
	 *
	 * @throws ValueNotAcceptable If value is not between 0 and 255 (inclusive).
	 */
	public function setBlue(int $blue): self {
		if ($blue < 0 || $blue > 255) {
			throw new ValueNotAcceptable('RGBA.blue', $blue, 'Allowed range: [0, 255]');
		}

		$this->blue = (int) round($blue);
		return $this;
	}

	/**
	 * @param float $alpha The alpha channel, as float ranging from 0.0 (transparent) to 1.0 (opaque).
	 *
	 * @throws ValueNotAcceptable If value is not between 0.0 and 1.0 (inclusive).
	 */
	public function setAlpha(float $alpha): self {
		if ($alpha < 0 || $alpha > 1) {
			throw new ValueNotAcceptable('RGBA.alpha', $alpha, 'Allowed range: [0.0, 1.0]');
		}

		$this->alpha = round($alpha, 3);
		return $this;
	}

	/** @return int The amount of red, as integer ranging from 0 to 255 (inclusive). */
	public function getRed(): int {
		return $this->red;
	}

	/** @return int The amount of green, as integer ranging from 0 to 255 (inclusive). */
	public function getGreen(): int {
		return $this->green;
	}

	/** @return int The amount of blue, as integer ranging from 0 to 255 (inclusive). */
	public function getBlue(): int {
		return $this->blue;
	}

	/** @return float The alpha channel, as float ranging from 0.0 to 1.0 (inclusive). */
	public function getAlpha(): float {
		return $this->alpha;
	}

	/**
	 * Output a color to a CSS string.
	 *
	 * @return string The CSS representation of this color, which always includes alpha.
	 */
	public function toCSS(): string {
		$values = [
			$this->getRed(),
			$this->getGreen(),
			$this->getBlue(),
			$this->getAlpha()
		];
		return $this->getAlpha() === 1.0
			? 'rgb(' . implode(', ', array_slice($values, 0, 3)) . ');'
			: 'rgba(' . implode(', ', $values) . ');';
	}

	/**
	 * Print the color as hexadecimal string, in format #AARRGGBB (# and AA are optional).
	 *
	 * @param bool $incAlpha   True to include alpha channel in front.
	 * @param bool $incHashTag True to include the '#'' in front.
	 * @param bool $uppercase  True to use uppercase, false to user lowercase.
	 *
	 * @return string The resulting hexadecimal string.
	 */
	public function toHexString(bool $incAlpha = true, bool $incHashTag = true, bool $uppercase = true): string {
		return implode('', array_filter([
			$incHashTag ? '#' : null,
			$incAlpha ? static::decToHex((int) round($this->getAlpha() * 255), $uppercase) : null,
			static::decToHex($this->getRed(), $uppercase),
			static::decToHex($this->getGreen(), $uppercase),
			static::decToHex($this->getBlue(), $uppercase)
		]));
	}

	/**
	 * Allocate a color for an image.
	 *
	 * @param resource $image An image resource, returned by one of the image creation functions such as
	 *                        imageCreateTrueColor().
	 *
	 * @return int A color identifier.
	 *
	 * @throws LogicException
	 */
	public function toImageColorIdentifier($image): int {
		if (function_exists('imageColorAllocateAlpha')) {
			$color = imageColorAllocateAlpha(
				$image,
				$this->getRed(),
				$this->getGreen(),
				$this->getBlue(),
				(int) $this->getAlpha() * 127
			);

			// Assert: There were no error
			if ($color === false) {
				throw new LogicException("Unable to allocate color with imageColorAllocateAlpha()");
			}

			return $color;
		}

		throw new LogicException('Extension ext-gd is required for RGBA::toImageColorIdentifier() method.');
	}

	/**
	 * Convert decimal number to a hexadecimal string.
	 *
	 * @param int  $decimal   The decimal number to convert.
	 * @param bool $uppercase True to use upper case, false for lowercase.
	 *
	 * @return string The resulting hexadecimal string.
	 */
	public static function decToHex(int $decimal, bool $uppercase = true): string {
		$result = str_pad(dechex($decimal), 2, '0', STR_PAD_LEFT);

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
	public function getRGBA(): RGBA {
		return $this;
	}

	/**
	 * Get the color in CMYK color space.
	 *
	 * @return CMYK The CMYK representation of this color.
	 *
	 * @throws ValueNotAcceptable
	 */
	public function getCMYK(): CMYK {

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
	}
}
