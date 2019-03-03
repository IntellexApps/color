<?php

use Intellex\Color\Exception\ValueNotAcceptableException;
use Intellex\Color\RGBA;

// Valid
$valid = [
	[ [ 0, 0, 0, 0.0 ], [ 0, 0, 0, 0.0 ] ],
	[ [ 120, 0, 0, 0.0 ], [ 120, 0, 0, 0.0 ] ],
	[ [ 0, 50, 0, 0.5 ], [ 0, 50, 0, 0.5 ] ],
	[ [ 20, 30, 45, 0.66 ], [ 20, 30, 45, 0.66 ] ]
];
foreach ($valid as $rule) {
	$color = new RGBA($rule[0][0], $rule[0][1], $rule[0][2], $rule[0][3]);
	if ($color->getRed() !== $rule[1][0] || $color->getGreen() !== $rule[1][1] || $color->getBlue() !== $rule[1][2] || $color->getAlpha() !== $rule[1][3]) {
		fail('RGBA valid constructor', $rule[0], $rule[1], [ $color->getAlpha(), $color->getRed(), $color->getGreen(), $color->getBlue() ]);
	}
}

// Invalid
$invalid = [
	[ [ -1, 0, 0, 0.0 ], 'RGBA.red' ],
	[ [ 256, 0, 0, 0.0 ], 'RGBA.red' ],
	[ [ 0, -1, 0, 0.0 ], 'RGBA.green' ],
	[ [ 0, 256, 0, 0.0 ], 'RGBA.green' ],
	[ [ 0, 0, -1, 0.0 ], 'RGBA.blue' ],
	[ [ 0, 0, 256, 0.0 ], 'RGBA.blue' ],
	[ [ 0, 0, 0, -1.0 ], 'RGBA.alpha' ],
	[ [ 0, 0, 0, 2 ], 'RGBA.alpha' ],
	[ [ -1, -1, 256, 1000 ], 'RGBA.red' ],
];
foreach ($invalid as $rule) {
	try {
		new RGBA($rule[0][0], $rule[0][1], $rule[0][2], $rule[0][3]);
	} catch (Exception $ex) {
		if ($ex instanceof ValueNotAcceptableException && $ex->getTarget() === $rule[1]) {
			continue;
		}
	}

	fail('RGBA invalid constructor', $rule[0], $rule[1], '-');
}

// Conversions
$conversion = [
	'371cfb'    => (new RGBA(55, 28, 251, 0.5))->toHexString(false, false, false),
	'FF57B0'    => (new RGBA(255, 87, 176, 1))->toHexString(false, false, true),
	'#0b165f'   => (new RGBA(11, 22, 95, 0))->toHexString(false, true, false),
	'#00DE65'   => (new RGBA(0, 222, 101, 0))->toHexString(false, true, true),
	'c28f62a5'  => (new RGBA(143, 98, 165, 0.763))->toHexString(true, false, false),
	'A52B7386'  => (new RGBA(43, 115, 134, 11 / 17))->toHexString(true, false, true),
	'#1234abef' => (new RGBA(52, 171, 239, 0.070588235294118))->toHexString(true, true, false),
	'#DD7BC857' => (new RGBA(123, 200, 87, 0.87))->toHexString(true, true, true)
];
foreach ($conversion as $expected => $result) {
	if ($expected !== $result) {
		fail('Conversion of RGBA to hexadecimal string failed', '-', $expected, $result);
	}
}