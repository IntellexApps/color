<?php

use Intellex\Color\CMYK;

// Valid
$valid = [
	[ [ 0, 0, 0, 0 ], [ 0.0, 0.0, 0.0, 0.0 ] ],
	[ [ 0.12, 0, 0, 0 ], [ 0.12, 0.0, 0.0, 0.0 ] ],
	[ [ 0, 0.50, 0, 0.50 ], [ 0.0, 0.50, 0.0, 0.50 ] ],
	[ [ 0.20, 0.30, 0.45, 0.66 ], [ 0.20, 0.30, 0.45, 0.66 ] ]
];
foreach ($valid as $rule) {
	$color = new CMYK($rule[0][0], $rule[0][1], $rule[0][2], $rule[0][3]);
	if ($color->getCyan() !== $rule[1][0] || $color->getMagenta() !== $rule[1][1] || $color->getYellow() !== $rule[1][2] || $color->getBlack() !== $rule[1][3]) {
		fail('CMYK valid constructor', $rule[0], $rule[1], [ $color->getCyan(), $color->getMagenta(), $color->getYellow(), $color->getBlack() ]);
	}
}

// Invalid
$invalid = [
	[ [ 0. - 1, 0, 0, 0 ], 'CMYK.cyan' ],
	[ [ 1.44, 0, 0, 0 ], 'CMYK.cyan' ],
	[ [ 0, 0. - 1, 0, 0 ], 'CMYK.magenta' ],
	[ [ 0, 1.01, 0, 0 ], 'CMYK.magenta' ],
	[ [ 0, 0, -1, 0 ], 'CMYK.yellow' ],
	[ [ 0, 0, 1.1, 0 ], 'CMYK.yellow' ],
	[ [ 0, 0, 0, -1 ], 'CMYK.black' ],
	[ [ 0, 0, 0, 3 ], 'CMYK.black' ],
	[ [ -1, -1, 101, 0 ], 'CMYK.cyan' ],
];
foreach ($invalid as $rule) {
	try {
		new CMYK($rule[0][0], $rule[0][1], $rule[0][2], $rule[0][3]);

	} catch (Exception $ex) {
		if ($ex instanceof \Intellex\Color\Exception\ValueNotAcceptableException && $ex->getTarget() === $rule[1]) {
			continue;
		}
	}

	fail('CMYK invalid constructor', $rule[0], $rule[1], '-');
}
