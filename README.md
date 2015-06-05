# Sphido / Events

[![Build Status](https://travis-ci.org/sphido/events.svg?branch=master)](https://travis-ci.org/sphido/events) [![Latest Stable Version](https://poser.pugx.org/sphido/events/v/stable.svg)](https://packagist.org/packages/sphido/events) [![Total Downloads](https://poser.pugx.org/sphido/events/downloads.svg)](https://packagist.org/packages/sphido/events) [![Latest Unstable Version](https://poser.pugx.org/sphido/events/v/unstable.svg)](https://packagist.org/packages/sphido/events) [![License](https://poser.pugx.org/sphido/events/license.svg)](https://packagist.org/packages/sphido/events)

Events is simple pure functional **event dispatching library** for PHP 5.5+ and have nice and clear interface with function `on()`, `off()`, `fire()`, `filter()`, `ensure()`, `once()`, `listeners()`, `events()` - that's all!

With events can:

- listeners prioritization
- add/remove listeners
- filter values by functions
- stop propagation in function chain
- and have default handler

## Fire event

```php
on('event', function () {
  echo "wow it's works yeah!";
});

fire('event'); // print wow it's works yeah!
```

Function `fire()` return array of all callback listeners results.

## Listeners prioritization

```php
on(	'event', function () { echo " stay hungry"; }, 200);
on(	'event', function () { echo "stay foolish"; }, 100);

fire('event'); // print "stay foolish stay hungry"
```

> Notice: **default event priority is 10!**

## Filter - change value by listeners

Function `filter()` return result of all callback function hook to event. Filtred value it's transmitted from one function to another.
 
```php
add_filter('price', function($price) {
  return (int)$price . ' USD';
});

echo filter('price', 100); // print 100 USD
    
add_filter('price', function($price) {
  return 'The price is: ' . $price ;
});

echo filter('price', 100); // print The price is: 100 USD
```

This function it's basically copy of Wordpress [add_filter](http://codex.wordpress.org/Function_Reference/add_filter) and [apply_filters](http://codex.wordpress.org/Function_Reference/apply_filters) functions.

## Ensure handler

Sometimes you need *ensure* that something will be handled by default function, but need allow overridden that function by something else.
 
```php
on('render', function () { echo 'my custom renderer'; });

echo ensure('render', function () {
  return 'default renderer';
});
// print "my custom renderer"

```    
    
## Remove listener from event

Add and remove listener:

```php
$handler = function() { };
on('event', $handler); // add
off('event', $handler); // remove
```

Add and remove all listeners:

```php
$handler = function() { };
on('event', $handler);
on('event', $handler);
on('event', $handler);
off('event'); // remove all listeners
```

## Call listener just once
 
 ```php
once('event', function(){ echo "called me once"; });
 
fire('event'); // will print "called me once" 
fire('event'); // will print nothing
```


## Stop propagation example

```php
on('event', function () { echo 'a'; });
on('event', function () { echo 'b'; });
on('event', function () { echo 'c'; return false; }); // stop propagation
on('event', function () { echo 'd'; });

fire('event'); // print abc
```

## Getting listeners array

Getting events static `stdClass`:

```php
events(); // return all events
events()->hook; // return selected hook
```

Getting listeners array:

```php
listeners('hook'); // return hook listeners
```
    
For more examples [visit tests](https://github.com/sphido/events/tree/master/tests).