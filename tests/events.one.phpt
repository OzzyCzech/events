<?php
/**
 * @author Roman Ozana <roman@ozana.cz>
 */
use Tester\Assert;

require __DIR__ . '/../vendor/autoload.php';
\Tester\Environment::setup();


{

	$onceFunction = function () {
		return 'just once';
	};

	one('once event', $onceFunction);

	Assert::equal(['just once'], trigger('once event'));
	Assert::equal([], trigger('once event'));

}