# Events

Super simple event dispatching library for PHP with filters, prioritizing, removing handlers and stop propagation.

[![Build Status](https://travis-ci.org/OzzyCzech/events.png?branch=master)](https://travis-ci.org/OzzyCzech/events) [![Latest Stable Version](https://poser.pugx.org/om/events/v/stable.png)](https://packagist.org/packages/om/events) [![Total Downloads](https://poser.pugx.org/om/events/downloads.png)](https://packagist.org/packages/om/events) [![Latest Unstable Version](https://poser.pugx.org/om/events/v/unstable.png)](https://packagist.org/packages/om/events) [![License](https://poser.pugx.org/om/events/license.png)](https://packagist.org/packages/om/events)

## Examples

Use function.php shortcut functions:

    on('event', function () {
      echo "wow it's work";
    });

    trigger('event'); // print wow it's work

Filter value example: 
 
    add_filter('price', function($price) {
      return (int)$price . ' USD';
    });
    
    echo filter('price', 100); // print 100 USD
        
    add_filter('price', function($price) {
      return 'The price is: ' . $price ;
		});
		
		echo filter('price', 100); // print The price is: 100 USD


Static Class from anywhere in code:

    Trigger::on('event', function() {
      echo "wow it's work";
    });

    Trigger::event(); // print wow it's work

    Filter::register('price', function($price) {
      return (int)$price . ' USD';
    });
    echo Filter::price(100); // print 100 USD

Use EventHandling on your class: 

    class Wtf {
      use EventHandling; // trait way
    }

    $wtf = new Wtf();
    $wtf->on('something', function() {});

Prioritizing events handlers:

    on('title', function ($title) {
      return '<h1>' . $title . '</h1>';
    }, 20);

    echo filter('title', 'text'); // <h1>text</h1>

    on('title', function ($title) {
      return '<a href="#title">' . $title . '</a>';
    });

    echo filter('title', 'text'); // <h1><a href="#title">text</a></h1>

**Please notice that default event priority is 10!**

## Advanced examples

Add and remove listener:

    $handler = function() { };
    on('event', $handler);
    off('event', $handler);

Add and remove all listeners:

    $handler = function() { };
    on('event', $handler);
    on('event', $handler);
    on('event', $handler);
    off('event');

Stop propagation:

    on('event', function () { echo 'a'; });
    on('event', function () { echo 'b'; });
    on('event', function () { echo 'c'; return false; }); // stop propagation
    on('event', function () { echo 'd'; });
		
		trigger('event'); // print abc
		
Get all events:

    $events = events();
    $listeners = listeners('event');
