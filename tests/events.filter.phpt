<?php
/**
 * @author Roman Ozana <ozana@omdesign.cz>
 */
use Tester\Assert;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/events.php';
\Tester\Environment::setup();

Assert::same(filter('not exists event', 'my input will be result'), 'my input will be result');

on(
	'event', function ($input) {
		Assert::same($input, 'some input data');
		return 'filtered result';
	}
);

Assert::same('filtered result', filter('event', 'some input data'));

// multiple filters

on(
	'event', function ($input) {
		return 'override output';
	}
);

Assert::same(2, count(listeners('event')));
Assert::same('override output', filter('event', 'some input data'));

// add and remove event test

on(
	'event', $func = function ($input) {
		return 'last win';
	}
);

Assert::same(3, count(listeners('event')));
Assert::same('last win', filter('event', 'some input data'));
off('event', $func); // remove handler
Assert::same(2, count(listeners('event')));
Assert::same('override output', filter('event', 'some input data'));


on(
	'event2', function ($array) {
		$array[] = 'add';
		return $array;
	}
);

Assert::same(['add'], filter('event2'));
Assert::same(['a', 'b', 'c', 'add'], filter('event2', ['a', 'b', 'c']));
