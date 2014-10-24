<?php
/**
 * @author Roman Ozana <ozana@omdesign.cz>
 */
use Tester\Assert;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/events.php';
\Tester\Environment::setup();


$a = function () {
	return 'a';
};
$b = function () {
	return 'b';
};
$c = function () {
	return 'c';
};

// event order

on('event', $a, 30);
on('event', $c, 10);
on('event', $b, 20);

$listeners = listeners('event');

Assert::same('c', $listeners[0]());
Assert::same('b', $listeners[1]());
Assert::same('a', $listeners[2]());

// check filter order

Assert::same('a', filter('event'));

on(
	'event2', function ($a, $b, $c) {
		Assert::same('a', $a);
		Assert::same('b', $b);
		Assert::same('c', $c);
	}
);

fire('event2', 'a', 'b', 'c');

// remove events
Assert::same(['event', 'event2'], array_keys((array)events()));
off('event2');
Assert::same(['event'], array_keys((array)events()));

fire('what ever you want');