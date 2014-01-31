# Events

Super simple event dispatching library for PHP

## Examples

Function way

    on(
    	'event', function () {
    		echo "wow it's work";
    	}
    );

    trigger('event'); // print wow it's work

    on('price', function($price) {
       return (int)$price . ' USD';
    });

    echo filter('price', 100); // print 100 USD

Static class way

		Trigger::on('event', function() {
			echo "wow it's work";
		});

		Trigger::event(); // print wow it's work

		Filter::register('price',
			function($price) {
				return (int)$price . ' USD';
		});
		echo Filter::price(100); // print 100 USD


[![Build Status](https://travis-ci.org/OzzyCzech/events.png?branch=master)](https://travis-ci.org/OzzyCzech/events)