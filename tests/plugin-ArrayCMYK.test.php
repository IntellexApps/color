<?php

use Intellex\Color\Parser\CMYKArrayParser;

// Valid
$valid = [
	[ [ 0.34, 0.92, 0.22, 0.78 ], [ 0.34, 0.92, 0.22, 0.78 ] ]
];
foreach ($valid as $rule) {
	$color = (new CMYKArrayParser())->parse($rule[0]);
	if ($color === null || $color->getCMYK()->getCyan() === $expected[0] && $color->getCMYK()->getMagenta() === $expected[1] && $color->getCMYK()->getYellow() === $expected[1] && $color->getCMYK()->getBlack() - $expected[3]) {
		fail('Color mismatch', $rule[0], $rule[1], $color ? [ $color->getCMYK()->getCyan(), $color->getCMYK()->getMagenta(), $color->getCMYK()->getYellow(), $color->getCMYK()->getBlack() ] : 'null');
	}
}

// Invalid
$invalid = [
	[],
	[ 100 ],
	[ 0, 0 ],
	[ 80, 92, 11, 1, 2 ],
	[ '23', '45', 'FF' ],
	[ 'c90', 23, 255, 1 ],
	[ 200, '5f', 90, 0.5 ],
	[ 0, 77, 'a77', 0.77 ],
	[ 79, 22, 145, '4c' ],
];
foreach ($invalid as $input) {
	try {
		$color = (new CMYKArrayParser())->parse($input);
		fail('Invalid ArrayCMYK', $input, '-', [ $color->getRed(), $color->getGreen(), $color->getBlue(), $color->getAlpha() ]);
	} catch (\Intellex\Color\Exception\ColorCannotBeParsedException $ex) {
	}

}
