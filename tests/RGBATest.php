<?php declare(strict_types = 1);

namespace Intellex\Color\Tests;

use Generator;
use Intellex\Color\Colors\CMYK;
use Intellex\Color\Colors\RGBA;
use Intellex\Color\Exception\ValueNotAcceptable;

/** @see RGBA */
class RGBATest extends ColorTestCase {

	/**
	 * @dataProvider provideToCSS
	 * @throws ValueNotAcceptable
	 */
	public function testToCSS(int $red, int $green, int $blue, float $alpha, string $css): void {
		$rgba = new RGBA($red, $green, $blue, $alpha);
		$this->assertEquals($css, $rgba->toCSS());
	}

	/** @see testToCSS */
	public function provideToCSS(): Generator {
		yield [ 0, 0, 0, 1.0, 'rgb(0, 0, 0);' ];
		yield [ 1, 1, 1, 1.0, 'rgb(1, 1, 1);' ];
		yield [ 127, 90, 5, 1.0, 'rgb(127, 90, 5);' ];
		yield [ 250, 150, 0, 1.0, 'rgb(250, 150, 0);' ];

		yield [ 1, 2, 3, .4, 'rgba(1, 2, 3, 0.4);' ];
		yield [ 255, 255, 255, .17, 'rgba(255, 255, 255, 0.17);' ];
	}

	/**
	 * @dataProvider provideGetCMYK
	 * @throws ValueNotAcceptable
	 */
	public function testGetCMYK(int $red, int $green, int $blue, CMYK $cmyk): void {
		$rgba = new RGBA($red, $green, $blue);
		$this->assertEquals($cmyk, $rgba->getCMYK());
	}

	/**
	 * @throws ValueNotAcceptable
	 *
	 * @see testGetCMYK
	 */
	public function provideGetCMYK(): Generator {
		yield [ 255, 255, 255, new CMYK(.0, 0, 0, 0) ];
		yield [ 0, 0, 0, new CMYK(0, 0, 0, 1) ];
		yield [ 53, 106, 159, new CMYK(.667, .333, 0, .376) ];
		yield [ 166, 80, 184, new CMYK(.098, .565, 0, .278) ];
	}

	/**
	 * @dataProvider provideToHexString
	 * @throws ValueNotAcceptable
	 */
	public function testToHexString(
		string $expected,
		bool $incAlpha,
		bool $incHashTag,
		bool $uppercase,
		int $red,
		int $green,
		int $blue,
		float $alpha
	): void {
		$rgba = new RGBA($red, $green, $blue, $alpha);
		$this->assertEquals($expected, $rgba->toHexString($incAlpha, $incHashTag, $uppercase));
	}

	/** @see testToHexString */
	public function provideToHexString(): Generator {
		yield [ '371cfb', false, false, false, 55, 28, 251, 0.5 ];
		yield [ 'FF57B0', false, false, true, 255, 87, 176, 1 ];
		yield [ '#0b165f', false, true, false, 11, 22, 95, 0 ];
		yield [ '#00DE65', false, true, true, 0, 222, 101, 0 ];
		yield [ 'c38f62a5', true, false, false, 143, 98, 165, 0.763 ];
		yield [ 'A52B7386', true, false, true, 43, 115, 134, 11 / 17 ];
		yield [ '#1234ab9f', true, true, false, 52, 171, 159, 0.070588235294118 ];
		yield [ '#DE7BC857', true, true, true, 123, 200, 87, 0.87 ];
	}

	/** @dataProvider provideValueException */
	public function testValueException(int $red, int $green, int $blue, float $alpha): void {
		$this->expectException(ValueNotAcceptable::class);
		new RGBA($red, $green, $blue, $alpha);
	}

	/** @see testValueException */
	public function provideValueException(): Generator {
		yield [ -1, 0, 0, 1 ];
		yield [ 0, 256, 0, 1 ];
		yield [ 0, 0, 1000, 1 ];
		yield [ 0, 0, 0, -0.2 ];
		yield [ 0, 0, 0, 2 ];
	}
}
