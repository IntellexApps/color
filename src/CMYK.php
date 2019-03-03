<?php namespace Intellex\Color;

use Intellex\Color\Exception\ValueNotAcceptableException;

/**
 * Class CMYK
 *
 * @package Intellex\Color
 */
class CMYK implements Color {

	/** @var float The amount of cyan, as float ranging from 0.0 to 1.0. */
	private $cyan;

	/** @var float The amount of magenta, as float ranging from 0.0 to 1.0. */
	private $magenta;

	/** @var int The amount of yellow, as float ranging from 0.0 to 1.0. */
	private $yellow;

	/** @var int The amount of black, as float ranging from 0.0 to 1.0. */
	private $black;

	/** @var RGBA|null The cached RGBA representation of this color. */
	private $rgba = null;

	/**
	 * CMYK constructor.
	 *
	 * @param float $cyan    The amount of cyan, as float ranging from 0.0 to 1.0.
	 * @param float $magenta The amount of magenta, as float ranging from 0.0 to 1.0.
	 * @param float $yellow  The amount of yellow, as float ranging from 0.0 to 1.0.
	 * @param float $black   The amount of black, as float ranging from 0.0 to 1.0.
	 *
	 * @throws ValueNotAcceptableException If any of the supplied parameters is invalid or out of
	 *                                     range.
	 */
	public function __construct($cyan, $magenta, $yellow, $black) {
		$this->setCyan($cyan);
		$this->setMagenta($magenta);
		$this->setYellow($yellow);
		$this->setBlack($black);
	}

	/** @return int The amount of cyan, as float ranging from 0.0 to 1.0. */
	public function getCyan() {
		return $this->cyan;
	}

	/** @return int The amount of magenta, as float ranging from 0.0 to 1.0. */
	public function getMagenta() {
		return $this->magenta;
	}

	/** @return int The amount of yellow, as float ranging from 0.0 to 1.0. */
	public function getYellow() {
		return $this->yellow;
	}

	/** @return int The amount of black, as float ranging from 0.0 to 1.0. */
	public function getBlack() {
		return $this->black;
	}

	/**
	 * @param float $cyan The amount of cyan, as float ranging from 0.0 to 1.0.
	 *
	 * @throws ValueNotAcceptableException
	 */
	public function setCyan($cyan) {

		// Assert value range
		if ($cyan < 0 || $cyan > 1) {
			throw new ValueNotAcceptableException('CMYK.cyan', $cyan);
		}

		$this->cyan = $cyan * 1.0;
	}

	/**
	 * @param float $magenta The amount of magenta, as float ranging from 0.0 to 1.0.
	 *
	 * @throws ValueNotAcceptableException
	 */
	public function setMagenta($magenta) {

		// Assert value range
		if ($magenta < 0 || $magenta > 1) {
			throw new ValueNotAcceptableException('CMYK.magenta', $magenta);
		}

		$this->magenta = $magenta * 1.0;
	}

	/**
	 * @param int $yellow The amount of yellow, as float ranging from 0.0 to 1.0.
	 *
	 * @throws ValueNotAcceptableException
	 */
	public function setYellow($yellow) {

		// Assert value range
		if ($yellow < 0 || $yellow > 1) {
			throw new ValueNotAcceptableException('CMYK.yellow', $yellow);
		}

		$this->yellow = $yellow * 1.0;
	}

	/**
	 * @param int $black The amount of black, as float ranging from 0.0 to 1.0.
	 *
	 * @throws ValueNotAcceptableException
	 */
	public function setBlack($black) {

		// Assert value range
		if ($black < 0 || $black > 1) {
			throw new ValueNotAcceptableException('CMYK.black', $black);
		}

		$this->black = $black * 1.0;
	}

	/**
	 * Output a color to a CSS string.
	 *
	 * @return string The CSS representation of this color.
	 */
	public function toCSS() {
		$values = [
			static::asPercent($this->getCyan(), true),
			static::asPercent($this->getMagenta(), true),
			static::asPercent($this->getYellow(), true),
			static::asPercent($this->getBlack(), true)
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
	private static function asPercent($value, $withPercentSign = false) {
		return round($value * 100) . ($withPercentSign ? '%' : null);
	}

	/**
	 * Get the color in RGBA color space.
	 *
	 * @return RGBA The RGBA representation of this color.
	 */
	public function getRGBA() {
		try {

			// Handle cache
			if ($this->rgba === null) {
				$coefficient = 255 * (1 - $this->black);
				$this->rgba = new RGBA(
					(1 - $this->cyan) * $coefficient,
					(1 - $this->magenta) * $coefficient,
					(1 - $this->yellow) * $coefficient
				);
			}

			return $this->rgba;

		} catch (ValueNotAcceptableException $ex) {
			return null;
		}
	}

	/**
	 * Get the color in CMYK color space.
	 *
	 * @return CMYK The CMYK representation of this color.
	 */
	public function getCMYK() {
		return $this;
	}

}