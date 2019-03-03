<?php namespace Intellex\Color\Parser\CSS;

use Intellex\Color\CMYK;

class CMYKParser extends AbstractParser {

	/** @inheritdoc */
	protected function definePrefix() {
		return 'cmyk';
	}

	/** @inheritdoc */
	protected function defineParameterCount() {
		return 4;
	}

	/** @inheritdoc */
	protected function parseParameters(array $parameters) {
		return new CMYK(
			static::asPercentage($parameters[0]),
			static::asPercentage($parameters[1]),
			static::asPercentage($parameters[2]),
			static::asPercentage($parameters[3])
		);
	}
}
