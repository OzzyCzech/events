<?php
/**
 * @author Roman Ozana <ozana@omdesign.cz>
 */
use Tester\Assert;

require __DIR__ . '/../vendor/autoload.php';
\Tester\Environment::setup();


{ // default carer test

	$response = care(
		'render', function () {
		return 'default renderer';
	}
	);

	Assert::same('default renderer', $response);
}

{ // override default carer test
	on(
		'render', function () {
		global $carer;
		return $carer = 'new renderer';
	}
	);

	$response = care(
		'render', function () {
		return 'default renderer';
	}
	);

	Assert::same('new renderer', $response);
}

{ // carer variables

	$response = care(
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

	$response = care(
		'variables', function ($data) {
		return $data;
	}, 'an example data'
	);

	Assert::same('an example data two', $response);
}