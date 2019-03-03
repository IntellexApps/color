<?php

use Intellex\Color\CMYK;
use Intellex\Color\RGBA;

// Tests
$tests = [
	'CMYK' => [
		'cmyk(60%, 40%, 10%, 12%);'  => new CMYK(0.6, 0.4, 0.1, 0.12),
		'cmyk(100%, 25%, 15%, 35%);' => new CMYK(1, 0.25, 0.15, 0.35), ],
	'RGBA' => [
		'rgba(100, 167, 200, 0.2);' => new RGBA(100, 167, 200, 0.8),
		'rgba(55, 255, 59, 0);'     => new RGBA(55, 255, 59, 1.0), ]
];
foreach ($tests as $name => $items) {
	$method = 'get' . $name;
	foreach ($items as $expected => $result) {
		$css = $result->$method()->toCSS();
		if ($expected !== $css) {
			fail("{$name} CSS", '', $expected, $css);
		}
	}
}

$cmyk = new CMYK(0.33, 0.98, 0.12, 0.42);
