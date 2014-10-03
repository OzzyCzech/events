<?php
/**
 * @author Roman Ozana <ozana@omdesign.cz>
 */
use Tester\Assert;

require __DIR__ . '/../vendor/autoload.php';
\Tester\Environment::setup();

$events = new Events();


// do not stop propagation after string
{
	$calls = 0;
	$events->on(
		'nonstop', function () {
			global $calls;
			$calls++;
			return '0'; // return something else then false
		}
	);
	$events->on(
		'nonstop', function () {
			global $calls;
			$calls++;
		}
	);
	$events->trigger('nonstop');
	Assert::same(2, $calls);
}


// stop propagation after false
{
	$calls = 0;
	$events->on(
		'stop', function () {
			global $calls;
			$calls++;
			return false; // stop propagation
		}
	);
	$events->on(
		'stop', function () {
			global $calls;
			$calls++;
		}
	);
	$events->trigger('stop');
	Assert::same(1, $calls);
}
