<?php

use Intellex\Color\Parser\RGBStringParser;

// Valid
$valid = [
	'71D'       => [ 119, 17, 221, 0.0 ],
	'3FF0'      => [ 255, 255, 0, 0.2 ],
	'F6cC12'    => [ 246, 204, 18, 0.0 ],
	'43C25140'  => [ 194, 81, 242, 0.26274509803922 ],
	'#62D'      => [ 102, 34, 221, 0 ],
	'#DEDA'     => [ 238, 221, 170, 0.86666666666667 ],
	'#671DcE'   => [ 103, 29, 206, 0.0 ],
	'#1234Abef' => [ 52, 171, 239, 0.070588235294118 ]
];
foreach ($valid as $input => $expected) {
	assertEqual($input, $expected, (new RGBStringParser())->parse($input));
}

// Invalid
$invalid = [
	'',
	'#',
	'1',
	'#2',
	'FF',
	'#00',
	'12345',
	'#90178',
	'#29272FF22',
	'FHG'
];
foreach ($invalid as $input) {
	try {
		$color = (new RGBStringParser())->parse($input);
		fail('Invalid StringRGBPlugin', $input, '-', [ $color->getRGBA()->getRed(), $color->getRGBA()->getGreen(), $color->getRGBA()->getBlue(), $color->getRGBA()->getAlpha() ]);
	} catch (\Intellex\Color\Exception\ColorCannotBeParsedException $ex) {
	}
}
