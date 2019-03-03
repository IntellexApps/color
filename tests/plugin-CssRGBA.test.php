<?php

// Valid
use Intellex\Color\Exception\ColorCannotBeParsedException;
use Intellex\Color\Parser\CSS\RGBAParser;

$valid = [
	[ 'rgba (80,88,93,0);', [ 80, 88, 93, 0.0 ] ],
	[ 'rgba ( 55 , 12 , 10, 1);', [ 55, 12, 10, 1 ] ],
	[ 'RgbA    ( 190    , 56 , 10  , 0.878)  ;  ', [ 190, 56, 10, 0.878 ] ],
];
foreach ($valid as $rule) {
	assertEqual($rule[0], $rule[1], (new RGBAParser())->parse($rule[0]));
}

// Invalid
$invalid = [
	'',
	'rgb(ff,00,11)',
	'rgb(123, 23)'
];
foreach ($invalid as $input) {
	try {
		$color = (new RGBAParser())->parse($input);
		fail('Invalid RGBAParser', $input, '-', [ $color->getRed(), $color->getGreen(), $color->getBlue(), $color->getAlpha() ]);
	} catch (ColorCannotBeParsedException $ex) {
	}
}
