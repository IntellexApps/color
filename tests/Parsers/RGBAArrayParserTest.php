<?php declare(strict_types = 1);

namespace Intellex\Color\Tests\Parsers;

use Generator;
use Intellex\Color\Colors\RGBA;
use Intellex\Color\Exception\ColorCannotBeParsed;
use Intellex\Color\Exception\ValueNotAcceptable;
use Intellex\Color\Parsers\AbstractColorParser;
use Intellex\Color\Parsers\RGBAParser;
use Intellex\Color\Tests\ColorTestCase;

/** @see RGBAParser */
class RGBAArrayParserTest extends ColorTestCase {

	/** @var AbstractColorParser The parser to test. */
	private AbstractColorParser $parser;

	/** @inheritDoc */
	protected function setUp(): void {
		$this->parser = new RGBAParser();
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
		yield [ [ 0, 0, 0, 0 ], new RGBA(0, 0, 0, 0) ];
		yield [ [ 128, 64, 23, 0 ], new RGBA(128, 64, 23, 0) ];
		yield [ [ 255, 255, 255, 1 ], new RGBA(255, 255, 255, 1) ];
		yield [ [ 10, 20, 30, 0.78 ], new RGBA(10, 20, 30, 0.78) ];
		yield [ [ 100, 1, 62, 0.99 ], new RGBA(100, 1, 62, 0.99) ];
		yield [ [ "50", "22", "111", "0.7" ], new RGBA(50, 22, 111, 0.7) ];
	}

	/** @dataProvider provideException */
	public function testException($input): void {
		$this->expectException(ColorCannotBeParsed::class);
		$this->parser->parse($input);
	}

	/** @see testException */
	public function provideException(): Generator {
		yield [ [] ];
		yield [ [ 101 ] ];
		yield [ [ 1, 2 ] ];
		yield [ [ 'c90', 23, 255, 1 ] ];
		yield [ [ 80, 92, 11, 1, 2 ] ];
		yield [ [ 79, 22, 145, '4c' ] ];
		yield [ [ 0, 77, 'a77', 0.77 ] ];
		yield [ [ '23', '45', 'FF' ] ];
		yield [ [ 200, '5f', 90, 0.5 ] ];
	}
}
