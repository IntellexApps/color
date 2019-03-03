<?php require __DIR__ . '/../vendor/autoload.php';

use Intellex\Color\Color;

// Initialize
\Intellex\Debugger\IncidentHandler::register();
function debug($data) {
	\Intellex\Debugger\VarDump::from($data, 1);
}

/**
 * Class TestFailException
 */
class TestFailException extends Exception {

	/**
	 * TestFailException constructor.
	 */
	public function __construct($what, $input, $expected, $output) {
		parent::__construct("Test {$what} failed, for input " . print_r($input, true) . '. Expected: ' . print_r($expected, true) . ', received: ' . print_r($output, true));
	}
}

function fail($what, $given, $expected, $output) {
	throw new TestFailException($what, $given, $expected, $output);
}

/**
 * @param array $expected
 * @param Color $color
 *
 * @return bool
 */
function colorEqual(Array $expected, Color $color) {
	return $color->getRGBA()->getRed() === $expected[0] && $color->getRGBA()->getGreen() === $expected[1] && $color->getRGBA()->getGreen() === $expected[1] && (abs($color->getRGBA()->getAlpha() - $expected[3]) < 0.0001);
}

/**
 * @param mixed $input
 * @param array $expected
 * @param Color $color
 */
function assertEqual($input, Array $expected, $color) {
	if ($color === null || !colorEqual($expected, $color)) {
		fail('Color mismatch', $input, $expected, $color ? [ $color->getRGBA()->getRed(), $color->getRGBA()->getGreen(), $color->getRGBA()->getBlue(), $color->getRGBA()->getAlpha() ] : 'null');
	}
}