<?php declare(strict_types = 1);

namespace Intellex\Color\Tests;

use Generator;
use Intellex\Color\Colors\CMYK;
use Intellex\Color\Colors\Color;
use Intellex\Color\Colors\RGBA;
use Intellex\Color\ColorParser;
use Intellex\Color\Exception\ValueNotAcceptable;

/** @see ColorParser */
class ColorParserTest extends ColorTestCase {

	/** @dataProvider provideParse */
	public function testParse(Color $color, $input, $default = null): void {
		$this->assertEquals($color, ColorParser::parse($input, $default));
	}

	/**
	 * @throws ValueNotAcceptable
	 * @see testParse
	 */
	public function provideParse(): Generator {

		// RGB(A) from string
		yield [ new RGBA(17, 136, 153), '189' ];
		yield [ new RGBA(153, 51, 34, 0.333), '5932' ];
		yield [ new RGBA(170, 187, 102), '#AB6' ];
		yield [ new RGBA(136, 238, 187, 0.933), '#E8Eb' ];
		yield [ new RGBA(86, 114, 50), '#567232' ];
		yield [ new RGBA(18, 52, 86, 0.31), '#4f123456' ];

		// RGBA from CSS
		yield [ new RGBA(200, 100, 50, 0.22), 'rgba(200, 100, 50, 0.22)' ];
		yield [ new RGBA(67, 199, 70, 1), 'rgb ( 67 , 199 , 70);' ];
		yield [ new RGBA(231, 0, 45, 0.91), new RGBA(231, 0, 45, 0.91) ];
		yield [ new RGBA(100, 167, 200, 0.8), 'rgba(100, 167, 200, 0.8);' ];
		yield [ new RGBA(55, 255, 59, 0.43), 'rgba(55, 255, 59, .43);' ];

		// CMYK from CSS
		yield [ new CMYK(0.6, 0.4, 0.1, 0.12), 'cmyk(60%, 40%, 10%, 12%);' ];
		yield [ new CMYK(1, 0.25, 0.15, 0.35), 'cmyk(100%, 25%, 15%, 35%);' ];
		yield [ new CMYK(.14, .55, .91, .33), 'cmyk ( 14% , 55% , 91%, 33%);' ];
		yield [ new CMYK(.14, .55, .91, .33), 'cmyk ( 14% , 55% , 91%, 33%);' ];

		// From array values
		yield [ new CMYK(.66, .12, .21, .09), [ .66, .12, .21, .09 ] ];
		yield [ new RGBA(100, 128, 64, .25), [ 200 / 2.0, 128, 64, .25 ] ];
		yield [ new RGBA(90, 100, 120, 0), [ 90, 100, 120, 0 ] ];

		// Default values
		yield [ new RGBA(18, 153, 163), 'not color', '#FF1299A3' ];
		yield [ new RGBA(100, 200, 255), 'not color', new RGBA(100, 200, 255) ];
	}
}
