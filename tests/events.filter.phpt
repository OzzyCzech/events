<?php
/**
 * @author Roman Ozana <ozana@omdesign.cz>
 */

namespace om;

use Tester\Assert;

require __DIR__ . '/../vendor/autoload.php';
\Tester\Environment::setup();

$event = new Events();

Assert::same($event->filter('not exists event', 'my input will be result'), 'my input will be result');

$event->on(
	'event', function ($input) {
		Assert::same($input, 'some input data');
		return 'filtered result';
	}
);

Assert::same('filtered result', $event->filter('event', 'some input data'));

// multiple filters

$event->on(
	'event', function ($input) {
		return 'override output';
	}
);

Assert::same(2, count($event->listeners('event')));
Assert::same('override output', $event->filter('event', 'some input data'));

// add and remove event test

$event->on(
	'event', $func = function ($input) {
		       return 'last win';
	       }
);

Assert::same(3, count($event->listeners('event')));
Assert::same('last win', $event->filter('event', 'some input data'));
$event->remove('event', $func); // remove handler
Assert::same(2, count($event->listeners('event')));
Assert::same('override output', $event->filter('event', 'some input data'));


$event->on(
	'event2', function ($array) {
		$array[] = 'add';
		return $array;
	}
);

Assert::same(['add'], $event->filter('event2'));
Assert::same(['a', 'b', 'c', 'add'], $event->filter('event2', ['a', 'b', 'c']));
