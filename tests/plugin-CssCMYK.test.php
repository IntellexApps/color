<?php

use Intellex\Color\Exception\ColorCannotBeParsedException;
use Intellex\Color\Parser\CSS\CMYKParser;

// Valid
$valid = [
	[ 'cmyk(0%, 75%, 74%, 18%);', [ 0.0, 0.75, 0.74, 0.18 ] ],
	[ 'cmyk(10%, 38%, 0%, 20%)', [ 0.1, 0.38, 0.0, 0.2 ] ],
	[ 'cmyk ( 15% , 9% , 0% , 54% ) ;', [ 0.15, 0.09, 0.0, 0.54 ] ],
	[ ' CMyK ( 0%, 0%, 0%, 0% )', [ 0.0, 0.0, 0.0, 0.0 ] ]
];
foreach ($valid as $rule) {
	$color = (new CMYKParser())->parse($rule[0]);
	if ($color === null || $rule[1][0] != $color->getCMYK()->getCyan() || $rule[1][1] != $color->getCMYK()->getMagenta() || $rule[1][2] != $color->getCMYK()->getYellow() || $rule[1][3] != $color->getCMYK()->getBlack()) {
		fail('Color mismatch', $rule[0], $rule[1], $color ? [ $color->getCMYK()->getCyan(), $color->getCMYK()->getMagenta(), $color->getCMYK()->getYellow(), $color->getCMYK()->getBlack() ] : 'null');
	}
}

// Invalid
$invalid = [
	'',
	'cmyk(ff,00,11)',
	'cmyk(123)'
];
foreach ($invalid as $input) {
	try {
		$color = (new CMYKParser())->parse($input);
		fail('Invalid CMYKParser', $input, '-', [ $color->getCMYK()->getCyan(), $color->getCMYK()->getMagenta(), $color->getCMYK()->getYellow(), $color->getCMYK()->getBlack() ]);
	} catch (ColorCannotBeParsedException $ex) {
	}
}
