<?php declare(strict_types = 1);

namespace Intellex\Color\Parsers\CSS;

use Intellex\Color\Colors\Color;
use Intellex\Color\Colors\RGBA;

/**
 * Parses the CSS representation of 'rgba(r, g, b)'.
 */
class RGBCssParser extends AbstractCssColorParser {

	/** @inheritdoc */
	protected function definePrefix(): string {
		return 'rgb';
	}

	/** @inheritdoc */
	protected function defineParameterCount(): int {
		return 3;
	}

	/** @inheritdoc */
	protected function parseParameters(array $parameters): Color {
		return new RGBA((int) $parameters[0], (int) $parameters[1], (int) $parameters[2]);
	}
}
