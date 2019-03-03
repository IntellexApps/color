<?php namespace Intellex\Color;

/**
 * Interface Color
 *
 * @package Intellex\Color
 */
interface Color {

	/**
	 * Get the color in RGBA color space.
	 *
	 * @return RGBA The RGBA representation of this color.
	 */
	public function getRGBA();

	/**
	 * Get the color in CMYK color space.
	 *
	 * @return CMYK The CMYK representation of this color.
	 */
	public function getCMYK();

}