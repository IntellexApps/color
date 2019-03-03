<?php namespace Intellex\Color\Parser\CSS;

use Intellex\Color\RGBA;

class RGBAParser extends AbstractParser {

	/** @inheritdoc */
	protected function definePrefix() {
		return 'rgba';
	}

	/** @inheritdoc */
	protected function defineParameterCount() {
		return 4;
	}

	/** @inheritdoc */
	protected function parseParameters(array $parameters) {
		return new RGBA($parameters[0], $parameters[1], $parameters[2], $parameters[3]);
	}
}