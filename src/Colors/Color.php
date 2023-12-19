<?php declare(strict_types = 1);

namespace Intellex\Color\Colors;

/**
 * Describes how a color can be manipulated.
 */
interface Color {

	/** @return RGBA The RGBA representation of this color. */
	public function getRGBA(): RGBA;

	/** @return CMYK The CMYK representation of this color. */
	public function getCMYK(): CMYK;

	/**  @return string The valid CSS representation of this/'. */
	public function toCSS(): string;
}
