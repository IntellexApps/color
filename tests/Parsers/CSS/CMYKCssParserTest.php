<?php declare(strict_types = 1);

namespace Intellex\Color\Tests\Parsers\CSS;

use Generator;
use Intellex\Color\Colors\CMYK;
use Intellex\Color\Exception\ColorCannotBeParsed;
use Intellex\Color\Exception\ValueNotAcceptable;
use Intellex\Color\Parsers\AbstractColorParser;
use Intellex\Color\Parsers\CSS\CMYKCssParser;
use Intellex\Color\Tests\ColorTestCase;

/** @see CMYKCssParser */
class CMYKCssParserTest extends ColorTestCase {

	/** @var AbstractColorParser The parser to test. */
	private AbstractColorParser $parser;

	/** @inheritDoc */
	protected function setUp(): void {
		$this->parser = new CMYKCssParser();
	}

	/** @dataProvider provideParse */
	public function testParse($input, CMYK $color): void {
		$this->assertEquals($color, $this->parser->parse($input));
	}

	/**
	 * @throws ValueNotAcceptable
	 * @see testParse
	 */
	public function provideParse(): Generator {
		yield [ 'cmyk(0%, 75%, 74%, 18%);', new CMYK(0.0, 0.75, 0.74, 0.18) ];
		yield [ 'cmyk(10%, 38%, 0%, 20%)', new CMYK(0.1, 0.38, 0.0, 0.2) ];
		yield [ 'cmyk ( 15% , 9% , 0% , 54% ) ;', new CMYK(0.15, 0.09, 0.0, 0.54) ];
		yield [ ' CMyK ( 0%, 0%, 0%, 0% )', new CMYK(0.0, 0.0, 0.0, 0.0) ];
	}

	/** @dataProvider provideException */
	public function testException($input): void {
		$this->expectException(ColorCannotBeParsed::class);
		$this->parser->parse($input);
	}

	/** @see testException */
	public function provideException(): Generator {
		yield [ '' ];
		yield [ 'cmyk(  1%)' ];
		yield [ 'cmyk(  1%,  2%)' ];
		yield [ 'cmyk(  1%,  2%,  3%)' ];
		yield [ 'cmk (  1%,  2%,  3%,  4%)' ];
		yield [ 'cmyk( -1%,  2%,  3%,  4%)' ];
		yield [ 'cmyk(  1%, -2%,  3%,  4%)' ];
		yield [ 'cmyk(  1%,  2%, -3%, -4%)' ];
		yield [ 'cmyk(101%,  2%,  3%,  4%)' ];
		yield [ 'cmyk(  1%,102%,  3%,  4%)' ];
		yield [ 'cmyk(  1%,  2%,103%,  4%)' ];
		yield [ 'cmyk(  1%,  2%,  3%,104%)' ];
	}
}
