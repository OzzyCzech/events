<?php
/**
 * @author Roman Ozana <ozana@omdesign.cz>
 */
use Tester\Assert;

require __DIR__ . '/../vendor/autoload.php';
\Tester\Environment::setup();


{ // default ensurer test

	$response = ensure(
		'render', function () {
		return 'default renderer';
	}
	);

	Assert::same('default renderer', $response);
}

{ // override default ensurer test
	on(
		'render', function () {
		global $ensurer;
		return $ensurer = 'new renderer';
	}
	);

	$response = ensure(
		'render', function () {
		return 'default renderer';
	}
	);

	Assert::same('new renderer', $response);
}

{ // ensure variables

	$response = ensure(
		'variables', function ($data) {
		return $data;
	}, 'an example data'
	);

	Assert::same('an example data', $response);

	on(
		'variables', function ($data) {
		return $data . ' two';
	}
	);

	$response = ensure(
		'variables', function ($data) {
		return $data;
	}, 'an example data'
	);

	Assert::same('an example data two', $response);
}