<?php
use Tester\Assert;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/functions.php';

\Tester\Environment::setup();


on(
	'event', function () {
		return 'working';
	}
);

Assert::same('working', filter('event'));

on(
	'event2', function () {
		return 'output';
	}
);

Assert::same('output', filter('event2'));

on(
	'event3', function ($data, $x = 2) {
		return $data * $x;
	}
);

Assert::same(0, filter('event3')); // null * 2
Assert::same(2 * 1, filter('event3', 1, 2)); // 1 * 2
Assert::same(3 * 2, filter('event3', 3)); // 3 * 2

on(
	'event3', function ($data, $x = 2) {
		return $data * $x; // multiple again
	}
);

Assert::same(0, filter('event3')); // null * 2
Assert::same(1 * 2 * 2, filter('event3', 1)); // 1 * 2 * 2
Assert::same(3 * 2 * 2, filter('event3', 3)); // 3 * 2 * 2


// use two params
Assert::same(5 * 3 * 5, filter('event3', 3, 5)); // 5 * 3 * 5

// multiple params on input

class TestTrigger {
	public $value;

	public function eventListener() {
		$this->value = array_sum(func_get_args());
	}
}

on('event4', [$t = new TestTrigger, 'eventListener']);

trigger('event4', 1, 1, 1, 1, 1, 1);

Assert::same(6, $t->value);
