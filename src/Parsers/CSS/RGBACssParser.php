<?php declare(strict_types = 1);

namespace Intellex\Color\Parsers\CSS;

use Intellex\Color\Colors\Color;
use Intellex\Color\Colors\RGBA;

/**
 * Parses the CSS representation of 'rgba(r, g, b, a)'.
 */
class RGBACssParser extends AbstractCssColorParser {

	/** @inheritdoc */
	protected function definePrefix(): string {
		return 'rgba';
	}

	/** @inheritdoc */
	protected function defineParameterCount(): int {
		return 4;
	}

	/** @inheritdoc */
	protected function parseParameters(array $parameters): Color {
		return new RGBA((int) $parameters[0], (int) $parameters[1], (int) $parameters[2], (float) $parameters[3]);
	}
}
