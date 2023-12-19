<?php declare(strict_types = 1);

namespace Intellex\Color\Tests\Parsers\CSS;

use Generator;
use Intellex\Color\Colors\RGBA;
use Intellex\Color\Exception\ColorCannotBeParsed;
use Intellex\Color\Exception\ValueNotAcceptable;
use Intellex\Color\Parsers\AbstractColorParser;
use Intellex\Color\Parsers\CSS\RGBACssParser;
use Intellex\Color\Tests\ColorTestCase;

/** @see RGBACssParser */
class RGBACssParserTest extends ColorTestCase {

	/** @var AbstractColorParser The parser to test. */
	private AbstractColorParser $parser;

	/** @inheritDoc */
	protected function setUp(): void {
		$this->parser = new RGBACssParser();
	}

	/** @dataProvider provideParse */
	public function testParse($input, RGBA $color): void {
		$this->assertEquals($color, $this->parser->parse($input));
	}

	/**
	 * @throws ValueNotAcceptable
	 * @see testParse
	 */
	public function provideParse(): Generator {
		yield [ 'rgba (80,88,93,0);', new RGBA(80, 88, 93, 0.0) ];
		yield [ 'rgba ( 55 , 12 , 11, 1);', new RGBA(55, 12, 11, 1) ];
		yield [ 'RgbA    ( 190    , 56 , 10.9  , 0.878)  ;  ', new RGBA(190, 56, 10, 0.878) ];
	}

	/** @dataProvider provideException */
	public function testException($input): void {
		$this->expectException(ColorCannotBeParsed::class);
		$this->parser->parse($input);
	}

	/** @see testException */
	public function provideException(): Generator {
		yield [ '' ];
		yield [ 'rgba(23,00,11)' ];
		yield [ 'rgba(123, 23)' ];
	}
}
