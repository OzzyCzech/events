<?php
/**
 * @author Roman Ozana <roman@ozana.cz>
 */
use Tester\Assert;

require __DIR__ . '/../vendor/autoload.php';
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

{ // sum values in two filters
	add_filter(
		'sum_args_and_values',
		function ($value, $one, $two, $three) {
			return $value + $one + $two;
		}
	);

	add_filter(
		'sum_args_and_values',
		function ($value, $one, $two, $three) {
			return $value + $three;
		}
	);

	Assert::same(1000, filter('sum_args_and_values', 100, 200, 300, 400));

}

{ // multiple times trigger same event on same data
	add_filter(
		'add_100',
		function ($value) {
			return $value + 100;
		}
	);
	Assert::same(400, filter(['add_100', 'add_100', 'add_100'], 100));
}

{

	add_filter('one', function ($array) { return array_sum($array);});
	add_filter('two', function ($value) { return 'Suma is ' . $value;});

	Assert::same('Suma is 100', filter(['one', 'two'], [10, 20, 30, 40]));
}