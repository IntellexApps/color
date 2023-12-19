<?php declare(strict_types = 1);

namespace Intellex\Color\Tests\Parsers;

use Generator;
use Intellex\Color\Colors\CMYK;
use Intellex\Color\Exception\ColorCannotBeParsed;
use Intellex\Color\Exception\ValueNotAcceptable;
use Intellex\Color\Parsers\CMYKParser;
use Intellex\Color\Parsers\AbstractColorParser;
use Intellex\Color\Tests\ColorTestCase;

/** @see CMYKParser */
class CMYKArrayParserTest extends ColorTestCase {

	/** @var AbstractColorParser The parser to test. */
	private AbstractColorParser $parser;

	/** @inheritDoc */
	protected function setUp(): void {
		$this->parser = new CMYKParser();
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
		yield [ [ 0, 0, 0, 0 ], new CMYK(0, 0, 0, 0) ];
		yield [ [ 0, 0, 0, 1 ], new CMYK(0, 0, 0, 1) ];
		yield [ [ 0.34, 0.92, 0.22, 0.78 ], new CMYK(0.34, 0.92, 0.22, 0.78) ];
		yield [ [ 0.111, 0.5555, 0.6666, 0.2345 ], new CMYK(0.111, 0.556, 0.667, 0.235) ];
		yield [ [ "0.1", "0.2", 1 / 3, "0.4" ], new CMYK(0.1, 0.2, 0.333, 0.4) ];
	}

	/** @dataProvider provideException */
	public function testException($input): void {
		$this->expectException(ColorCannotBeParsed::class);
		$this->parser->parse($input);
	}

	/** @see testException */
	public function provideException(): Generator {
		yield [ [] ];
		yield [ [ 100 ] ];
		yield [ [ 0, 0 ] ];
		yield [ [ 80, 92, 11, 1, 2 ] ];
		yield [ [ '23', '45', 'FF' ] ];
		yield [ [ 'c90', 23, 255, 1 ] ];
		yield [ [ 200, '5f', 90, 0.5 ] ];
		yield [ [ 0, 77, 'a77', 0.77 ] ];
		yield [ [ 79, 22, 145, '4c' ] ];
	}
}
