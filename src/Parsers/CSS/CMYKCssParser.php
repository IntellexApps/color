<?php declare(strict_types = 1);

namespace Intellex\Color\Parsers\CSS;

use Intellex\Color\Colors\CMYK;
use Intellex\Color\Colors\Color;

/**
 * Parses the CSS representation of 'cmyk(c%, m%, y%, k%)'.
 */
class CMYKCssParser extends AbstractCssColorParser {

	/** @inheritdoc */
	protected function definePrefix(): string {
		return 'cmyk';
	}

	/** @inheritdoc */
	protected function defineParameterCount(): int {
		return 4;
	}

	/** @inheritdoc */
	protected function parseParameters(array $parameters): Color {
		return new CMYK(
			static::fromPercentage($parameters[0]),
			static::fromPercentage($parameters[1]),
			static::fromPercentage($parameters[2]),
			static::fromPercentage($parameters[3])
		);
	}
}
