<?php

use Intellex\Color\Parser\RGBArrayParser;

// Valid
$valid = [
	[ [ 80, 92, 11 ], [ 80, 92, 11, 0.0 ] ],
	[ [ 34, 92, 22, 0.78 ], [ 34, 92, 22, 0.78 ] ]
];
foreach ($valid as $rule) {
	assertEqual($rule[0], $rule[1], (new RGBArrayParser())->parse($rule[0]));
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
		$color = (new RGBArrayParser())->parse($input);
		fail('Invalid ArrayRGBA', $input, '-', [ $color->getRed(), $color->getGreen(), $color->getBlue(), $color->getAlpha() ]);
	} catch (\Intellex\Color\Exception\ColorCannotBeParsedException $ex) {
	}
}
