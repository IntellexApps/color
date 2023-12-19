<?php declare(strict_types = 1);

namespace Intellex\Color\Colors;

use Intellex\Color\Exception\ValueNotAcceptable;

/**
 * Color defined by: Cyan Magenta Yellow Black.
 */
class CMYK implements Color {

	/** @var float The amount of cyan, as float ranging from 0.0 to 1.0. */
	private float $cyan;

	/** @var float The amount of magenta, as float ranging from 0.0 to 1.0. */
	private float $magenta;

	/** @var float The amount of yellow, as float ranging from 0.0 to 1.0. */
	private float $yellow;

	/** @var float The amount of black, as float ranging from 0.0 to 1.0. */
	private float $black;

	/** @var RGBA|null The cached RGBA representation of this color. */
	private ?RGBA $rgba = null;

	/**
	 * CMYK constructor.
	 *
	 * @param float $cyan    The amount of cyan, as float ranging from 0.0 to 1.0.
	 * @param float $magenta The amount of magenta, as float ranging from 0.0 to 1.0.
	 * @param float $yellow  The amount of yellow, as float ranging from 0.0 to 1.0.
	 * @param float $black   The amount of black, as float ranging from 0.0 to 1.0.
	 *
	 * @throws ValueNotAcceptable If any of the supplied parameters is invalid or out of
	 *                                     range.
	 */
	public function __construct(float $cyan, float $magenta, float $yellow, float $black) {
		$this->setCyan($cyan);
		$this->setMagenta($magenta);
		$this->setYellow($yellow);
		$this->setBlack($black);
	}

	/** @return float The amount of cyan, as float ranging from 0.0 to 1.0. */
	public function getCyan(): float {
		return $this->cyan;
	}

	/** @return float The amount of magenta, as float ranging from 0.0 to 1.0. */
	public function getMagenta(): float {
		return $this->magenta;
	}

	/** @return float The amount of yellow, as float ranging from 0.0 to 1.0. */
	public function getYellow(): float {
		return $this->yellow;
	}

	/** @return float The amount of black, as float ranging from 0.0 to 1.0. */
	public function getBlack(): float {
		return $this->black;
	}

	/**
	 * @param float $cyan The amount of cyan, as float ranging from 0.0 to 1.0.
	 *
	 * @throws ValueNotAcceptable If value is not between 0.0 and 1.0 (inclusive).
	 */
	public function setCyan(float $cyan): self {

		// Assert value range
		if ($cyan < 0 || $cyan > 1) {
			throw new ValueNotAcceptable('CMYK.cyan', $cyan, 'Allowed range: [0.0, 1.0]');
		}

		$this->cyan = round($cyan, 3);
		return $this;
	}

	/**
	 * @param float $magenta The amount of magenta, as float ranging from 0.0 to 1.0.
	 *
	 * @throws ValueNotAcceptable If value is not between 0.0 and 1.0 (inclusive).
	 */
	public function setMagenta(float $magenta): self {

		// Assert value range
		if ($magenta < 0 || $magenta > 1) {
			throw new ValueNotAcceptable('CMYK.magenta', $magenta, 'Allowed range: [0.0, 1.0]');
		}

		$this->magenta = round($magenta, 3);
		return $this;
	}

	/**
	 * @param float $yellow The amount of yellow, as float ranging from 0.0 to 1.0.
	 *
	 * @throws ValueNotAcceptable If value is not between 0.0 and 1.0 (inclusive).
	 */
	public function setYellow(float $yellow): self {

		// Assert value range
		if ($yellow < 0 || $yellow > 1) {
			throw new ValueNotAcceptable('CMYK.yellow', $yellow, 'Allowed range: [0.0, 1.0]');
		}

		$this->yellow = round($yellow, 3);
		return $this;
	}

	/**
	 * @param float $black The amount of black, as float ranging from 0.0 to 1.0.
	 *
	 * @throws ValueNotAcceptable If value is not between 0.0 and 1.0 (inclusive).22
	 */
	public function setBlack(float $black): self {

		// Assert value range
		if ($black < 0 || $black > 1) {
			throw new ValueNotAcceptable('CMYK.black', $black, 'Allowed range: [0.0, 1.0]');
		}

		$this->black = round($black, 3);
		return $this;
	}

	/**
	 * Output a color to a CSS string.
	 *
	 * @return string The CMYK CSS representation of this color: 'cmyk(c%, m%, y%, b%);'.
	 */
	public function toCSS(): string {
		$values = [
			self::asPercent($this->getCyan(), true),
			self::asPercent($this->getMagenta(), true),
			self::asPercent($this->getYellow(), true),
			self::asPercent($this->getBlack(), true)
		];

		return 'cmyk(' . implode(', ', $values) . ');';
	}

	/**
	 * Convert float value to a percent.
	 *
	 * @param float $value           The float representation of percent (0 = 0%, 1 = 100%, etc...).
	 * @param bool  $withPercentSign True to append the percent sign (%), false to skip.
	 *
	 * @return string The value as a percentage.
	 */
	private static function asPercent(float $value, bool $withPercentSign = false): string {
		return round($value * 100) . ($withPercentSign ? '%' : null);
	}

	/**
	 * Get the color in RGBA color space.
	 *
	 * @return RGBA The RGBA representation of this color.
	 *
	 * @throws ValueNotAcceptable
	 */
	public function getRGBA(): RGBA {

		// Handle cache
		if ($this->rgba === null) {
			$coefficient = 255 * (1 - $this->black);
			$this->rgba = new RGBA(
				(int) round((1 - $this->cyan) * $coefficient),
				(int) round((1 - $this->magenta) * $coefficient),
				(int) round((1 - $this->yellow) * $coefficient)
			);
		}

		return $this->rgba;
	}

	/**
	 * Get the color in CMYK color space.
	 *
	 * @return CMYK The CMYK representation of this color.
	 */
	public function getCMYK(): CMYK {
		return $this;
	}
}
