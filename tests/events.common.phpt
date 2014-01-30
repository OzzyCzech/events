<?php
/**
 * @author Roman Ozana <ozana@omdesign.cz>
 */
namespace om;

use Tester\Assert;

require __DIR__ . '/../vendor/autoload.php';
\Tester\Environment::setup();


class TestTrigger {
	public $value;

	public function eventListener() {
		$this->value = array_sum(func_get_args());
	}
}

Trigger::on('eventName', [$t = new TestTrigger, 'eventListener']);
Trigger::eventName(1, 1, 1, 1);

Assert::same(4, $t->value);


Filter::register(
	'data', function ($data, $x = 2) {
		return $data * $x;
	}
);

Assert::same(0, Filter::data());
Assert::same(0, Filter::data(2, 0));
Assert::same(4, Filter::data(2));
Assert::same(8, Filter::data(2, 4));

Assert::same(null, Filter::nothing());
Assert::same(1, Filter::just_return(1));

