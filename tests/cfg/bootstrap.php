<?php declare(strict_types = 1);
// phpcs:disable Squiz.PHP.DiscouragedFunctions.Found

// Quick and dirty debug
if (!function_exists('dd')) {
	function dd(): void {
		$vars = func_get_args();
		foreach ($vars as $var) {
			echo "\n\n============================================================================================\n\n";
			print_r($var);
		}
		echo "\n\n=============================================================================================\n\n";
		die;
	}
}
