<?php
/**
 * @author Roman Ozana <ozana@omdesign.cz>
 */
use Tester\Assert;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/events.php';
\Tester\Environment::setup();


{ // default handler test

	$response = handle(
		'render', function () {
			return 'default renderer';
		}
	);

	Assert::same('default renderer', $response);
}

{ // override handler test
	on(
		'render', function () {
			global $handler;
			return $handler = 'new renderer';
		}
	);

	$response = handle(
		'render', function () {
			return 'default renderer';
		}
	);

	Assert::same('new renderer', $response);
}