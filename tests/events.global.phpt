<?php
namespace om;

use Tester\Assert;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/functions.php';

\Tester\Environment::setup();

GlobalEvents::on(
	'event', function () {
		return 'working';
	}
);

Assert::same('working', GlobalEvents::filter('event'));

on(
	'event2', function () {
		return 'output';
	}
);

Assert::same('output', filter('event2'));

on(
	'event3', function ($data) {
		return $data * 2;
	}
);

Assert::same(2, filter('event3'));
Assert::same(6, filter('event3', 3));


var_dump(getEventListeners('event3'));