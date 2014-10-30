# Events

Events is simple pure functional **event dispatching library** for PHP 5.4+ and have nice and clear interface with function `on()`, `off()`, `fire()`, `filter()`, `handle()`, `once()`, `listeners()`, `events()` - that's all.

With events can:

- prioritizing listeners
- add/remove listeners
- filter values by functions
- stop propagation in function chain
- and have default handler

[![Build Status](https://travis-ci.org/OzzyCzech/events.png?branch=master)](https://travis-ci.org/OzzyCzech/events) [![Latest Stable Version](https://poser.pugx.org/om/events/v/stable.png)](https://packagist.org/packages/om/events) [![Total Downloads](https://poser.pugx.org/om/events/downloads.png)](https://packagist.org/packages/om/events) [![Latest Unstable Version](https://poser.pugx.org/om/events/v/unstable.png)](https://packagist.org/packages/om/events) [![License](https://poser.pugx.org/om/events/license.png)](https://packagist.org/packages/om/events)


## Fire event

    on('event', function () {
      echo "wow it's works yeah!";
    });

    fire('event'); // print wow it's works yeah!

Function `fire()` return array of all callback listeners results.

## Prioritizing listeners

    on(
    	'event', function () {
    		echo " stay hungry";
    	}, 200
    );

    on(
    	'event', function () {
    		echo "stay foolish";
    	}, 100
    );

    fire('event'); // print stay foolish stay hungry

**Please notice that default event priority is 10!**

## Filter - change value by listeners

Function `filter()` return result of all callback function hook to event. Filtred value it's transmitted from one function to another.
 
    add_filter('price', function($price) {
      return (int)$price . ' USD';
    });
    
    echo filter('price', 100); // print 100 USD
        
    add_filter('price', function($price) {
      return 'The price is: ' . $price ;
    });
    
    echo filter('price', 100); // print The price is: 100 USD

This function it's basically copy of Wordpress [add_filter](http://codex.wordpress.org/Function_Reference/add_filter) and [apply_filters](http://codex.wordpress.org/Function_Reference/apply_filters) functions.

## Handle - overide default listeners

Return result of last hang callback function to event. Can be useful if you need have some default handler there which can be possible overridden by something else.

    on(
      'render', function () {
        return 'my custom renderer';
      }
    );
    
    echo handle(
      'render', function () {
        return 'default renderer';
      }
    ); // print my custom renderer
    
    
## Remove listener from event
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

## Stop propagation example

    on('event', function () { echo 'a'; });
    on('event', function () { echo 'b'; });
    on('event', function () { echo 'c'; return false; }); // stop propagation
    on('event', function () { echo 'd'; });
    
    fire('event'); // print abc
    
## Getting events or listeners

Getting events static `stdClass`:

    events(); // return all events
    events()->hook; // return selected hook

Getting listeners array:

    listeners('hook'); // return hook listeners
    
For more examples [visit tests](https://github.com/OzzyCzech/events/tree/master/tests). 
