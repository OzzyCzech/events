<?php
/**
 * @author Roman Ozana <ozana@omdesign.cz>
 */
use Tester\Assert;

require __DIR__ . '/../vendor/autoload.php';
\Tester\Environment::setup();


{

	$onceFunction = function () {
		return 'just once';
	};

	once('once event', $onceFunction);

	Assert::equal(['just once'], fire('once event'));
	Assert::equal([], fire('once event'));

}