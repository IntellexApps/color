<?php

// Valid
$valid = [
	[ '#567232', [ 86, 114, 50, 0 ] ],
	[ [ 90, 100, 120, 0 ], [ 90, 100, 120, 0 ] ],
	[ 'rgba(200, 100, 50, 0.22)', [ 200, 100, 50, 0.22 ] ],
	[ 'rgb ( 67 , 199 , 70);', [ 67, 199, 70, 0 ] ],
	[ new \Intellex\Color\RGBA(231, 0, 45, 0.91), [ 231, 0, 45, 0.91 ] ]
];
foreach ($valid as $rule) {
	assertEqual($rule[0], $rule[1], \Intellex\Color\Parser::parse($rule[0])->getRGBA());
}
