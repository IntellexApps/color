<?php declare(strict_types = 1);

namespace Intellex\Color\Tests;

use Generator;
use Intellex\Color\Colors\CMYK;
use Intellex\Color\Colors\RGBA;
use Intellex\Color\Exception\ValueNotAcceptable;

/** @see CMYK */
class CMYKTest extends ColorTestCase {

	/**
	 * @dataProvider provideToCSS
	 * @throws ValueNotAcceptable
	 */
	public function testToCSS(float $cyan, float $magenta, float $yellow, float $black, string $css): void {
		$cmyk = new CMYK($cyan, $magenta, $yellow, $black);
		$this->assertEquals($css, $cmyk->toCSS());
	}

	/** @see testToCSS */
	public function provideToCSS(): Generator {
		yield [ 0, 0, 0, 0, 'cmyk(0%, 0%, 0%, 0%);' ];
		yield [ 1, .75, .5, .25, 'cmyk(100%, 75%, 50%, 25%);' ];
		yield [ .01, .02, .03, .81, 'cmyk(1%, 2%, 3%, 81%);' ];
	}

	/**
	 * @dataProvider provideGetRGBA
	 * @throws ValueNotAcceptable
	 */
	public function testGetRGBA(float $cyan, float $magenta, float $yellow, float $black, RGBA $rgba): void {
		$cmyk = new CMYK($cyan, $magenta, $yellow, $black);
		$this->assertEquals($rgba, $cmyk->getRGBA());
	}

	/**
	 * @throws ValueNotAcceptable
	 * @see testGetRGBA
	 */
	public function provideGetRGBA(): Generator {
		yield [ 0, 0, 0, 0, new RGBA(255, 255, 255) ];
		yield [ 0, 0, 0, 1, new RGBA(0, 0, 0) ];
		yield [ .75, .50, .25, .17, new RGBA(53, 106, 159) ];
		yield [ .11, .57, .01, .27, new RGBA(166, 80, 184) ];
	}

	/** @dataProvider provideValueException */
	public function testValueException(float $cyan, float $magenta, float $yellow, float $black): void {
		$this->expectException(ValueNotAcceptable::class);
		new CMYK($cyan, $magenta, $yellow, $black);
	}

	/** @see testValueException */
	public function provideValueException(): Generator {
		yield [ 2, 0, 0, 0 ];
		yield [ 0, -1, 0, 0 ];
		yield [ 0, 0, 255, 0 ];
		yield [ 0, 0, 0, 12 ];
	}
}
