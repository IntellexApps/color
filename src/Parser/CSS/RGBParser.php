<?php namespace Intellex\Color\Parser\CSS;

use Intellex\Color\RGBA;

class RGBParser extends AbstractParser {

	/** @inheritdoc */
	protected function definePrefix() {
		return 'rgb';
	}

	/** @inheritdoc */
	protected function defineParameterCount() {
		return 3;
	}

	/** @inheritdoc */
	protected function parseParameters(array $parameters) {
		return new RGBA($parameters[0], $parameters[1], $parameters[2]);
	}
}