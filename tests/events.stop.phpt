<?php
/**
 * @author Roman Ozana <ozana@omdesign.cz>
 */
use Tester\Assert;

require __DIR__ . '/../vendor/autoload.php';

\Tester\Environment::setup();


// do not stop propagation after string
{
	$calls = 0;
	on(
		'nonstop', function () {
		global $calls;
		$calls++;
		return '0'; // return something else then false
	}
	);
	on(
		'nonstop', function () {
		global $calls;
		$calls++;
	}
	);
	trigger('nonstop');
	Assert::same(2, $calls);
}


// stop propagation after false
{
	$calls = 0;
	on(
		'stop', function () {
		global $calls;
		$calls++;
		return false; // stop propagation
	}
	);
	on(
		'stop', function () {
		global $calls;
		$calls++;
	}
	);
	trigger('stop');
	Assert::same(1, $calls);
}
