<?php

require 'bootstrap.php';

try {

	// Color: RGBA
	require 'color-RGBA.test.php';

	// Color: CMYK
	require 'color-CMYK.test.php';

	// Plugin: StringRGB
	require 'plugin-StringRGB.test.php';

	// Plugin: ArrayRGBA
	require 'plugin-ArrayRGBA.test.php';

	// Plugin: ArrayCMYK
	require 'plugin-ArrayCMYK.test.php';

	// Plugin: CSS RGB
	require 'plugin-CssRGB.test.php';

	// Plugin: CSS RGB
	require 'plugin-CssRGBA.test.php';

	// Plugin: CSS CMYK
	require 'plugin-CssCMYK.test.php';

	// Complete parser
	require 'parser.test.php';

	// Examples
	require 'css.test.php';

} catch (TestFailException $ex) {
	echo $ex->getMessage() . PHP_EOL;
	exit(1);
}

echo 'All tests passed' . PHP_EOL;
exit(0);