<?php
/**
 * @author Roman Ozana <ozana@omdesign.cz>
 */
use Tester\Assert;

require __DIR__ . '/../vendor/autoload.php';
\Tester\Environment::setup();

{ // some listeners
	$a = function () {
		return 'a';
	};
	$b = function () {
		return 'b';
	};
	$c = function () {
		return 'c';
	};
	$false = function () {
		return false;
	};
}

{ // check event order

	on('event', $a, 30);
	on('event', $c, 10);
	on('event', $b, 20);

	$listeners = listeners('event');

	Assert::same('c', $listeners[0]());
	Assert::same('b', $listeners[1]());
	Assert::same('a', $listeners[2]());

	Assert::same(['c', 'b', 'a'], trigger('event'));
}

{ // event params
	on(
		'event2', function ($a, $b, $c) {
		Assert::same('1', $a);
		Assert::same('2', $b);
		Assert::same('3', $c);
		return func_get_args();
	}
	);

	Assert::same([['1', '2', '3']], trigger('event2', '1', '2', '3'));
}

{ // remove all listeners
	Assert::same(['event', 'event2'], array_keys((array)events()));
	off('event2');

	Assert::same(['event'], array_keys((array)events()));
}

{ // trigger output
	Assert::same([], trigger('what ever you want'));

	on('output', $a);
	on('output', $b);
	on('output', $false);
	on('output', $c);
	Assert::same(['a', 'b', false], trigger('output'));
}

