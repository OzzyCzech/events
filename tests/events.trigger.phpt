<?php
/**
 * @author Roman Ozana <ozana@omdesign.cz>
 */
use Tester\Assert;

require __DIR__ . '/../vendor/autoload.php';
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

$event = new Events();

// event order

$event->on('event', $a, 30);
$event->on('event', $c, 10);
$event->on('event', $b, 20);

$listeners = $event->listeners('event');

Assert::same('c', $listeners[0]());
Assert::same('b', $listeners[1]());
Assert::same('a', $listeners[2]());

// check filter order

Assert::same('a', $event->filter('event'));

$event->on(
	'event2', function ($a, $b, $c) {
		Assert::same('a', $a);
		Assert::same('b', $b);
		Assert::same('c', $c);
	}
);

$event->trigger('event2', 'a', 'b', 'c');

// remove events
Assert::same(['event', 'event2'], $event->events());
$event->removeListeners('event2');
Assert::same(['event'], $event->events());