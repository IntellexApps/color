<?php declare(strict_types = 1);

namespace Intellex\Color\Tests\Parsers\CSS;

use Generator;
use Intellex\Color\Colors\RGBA;
use Intellex\Color\Exception\ColorCannotBeParsed;
use Intellex\Color\Exception\ValueNotAcceptable;
use Intellex\Color\Parsers\AbstractColorParser;
use Intellex\Color\Parsers\CSS\RGBCssParser;
use Intellex\Color\Tests\ColorTestCase;

/** @see RGBCssParser */
class RGBCssParserTest extends ColorTestCase {

	/** @var AbstractColorParser The parser to test. */
	private AbstractColorParser $parser;

	/** @inheritDoc */
	protected function setUp(): void {
		$this->parser = new RGBCssParser();
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
		yield [ 'rgb (40,22,244)', new RGBA(40, 22, 244) ];
		yield [ 'rgb ( 200 , 100 , 0);', new RGBA(200, 100, 0) ];
		yield [ 'RGB    ( 212    , 32 , 11  )  ;  ', new RGBA(212, 32, 11) ];
	}

	/** @dataProvider provideException */
	public function testException($input): void {
		$this->expectException(ColorCannotBeParsed::class);
		$this->parser->parse($input);
	}

	/** @see testException */
	public function provideException(): Generator {
		yield [ '' ];
		yield [ 'rgb( 50, 50)' ];
		yield [ 'rgb( -1,  0,  0)' ];
		yield [ 'rgb(  0, -1,  0)' ];
		yield [ 'rgb(  0,  0, -1)' ];
		yield [ 'rgb(300,  0,  0)' ];
		yield [ 'rgb(  0,256,  0)' ];
		yield [ 'rgb(  0,  0,1000)' ];
	}
}
