<?php declare(strict_types = 1);

namespace Intellex\Color\Tests\Parsers;

use Generator;
use Intellex\Color\Colors\RGBA;
use Intellex\Color\Exception\ColorCannotBeParsed;
use Intellex\Color\Exception\ValueNotAcceptable;
use Intellex\Color\Parsers\AbstractColorParser;
use Intellex\Color\Parsers\RGBAStringParser;
use Intellex\Color\Tests\ColorTestCase;

/** @see RGBAStringParser */
class RGBAStringParserTest extends ColorTestCase {

	/** @var AbstractColorParser The parser to test. */
	private AbstractColorParser $parser;

	/** @inheritDoc */
	protected function setUp(): void {
		$this->parser = new RGBAStringParser();
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
		yield [ '71D', new RGBA(119, 17, 221, 1) ];
		yield [ '3FF0', new RGBA(255, 255, 0, 0.2) ];
		yield [ 'F6cC12', new RGBA(246, 204, 18, 1) ];
		yield [ '00F6cC12', new RGBA(246, 204, 18, 0) ];
		yield [ '43C25140', new RGBA(194, 81, 64, 0.26274509803922) ];
		yield [ '#62D', new RGBA(102, 34, 221, 1) ];
		yield [ '#DEDA', new RGBA(238, 221, 170, 0.86666666666667) ];
		yield [ '#671DcE', new RGBA(103, 29, 206, 1) ];
		yield [ '#fF671DcE', new RGBA(103, 29, 206, 1) ];
		yield [ '#1234Ab0f', new RGBA(52, 171, 15, 0.070588235294118) ];

	}

	/** @dataProvider provideException */
	public function testException($input): void {
		$this->expectException(ColorCannotBeParsed::class);
		$this->parser->parse($input);
	}

	/** @see testException */
	public function provideException(): Generator {
		yield [ '' ];
		yield [ '#' ];
		yield [ '1' ];
		yield [ '#2' ];
		yield [ 'FF' ];
		yield [ 'FHG' ];
		yield [ '#00' ];
		yield [ '12345' ];
		yield [ '#90178' ];
		yield [ '#29272FF22' ];
	}
}
