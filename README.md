# Events

Super simple event dispatching library for PHP

[![Build Status](https://travis-ci.org/OzzyCzech/events.png?branch=master)](https://travis-ci.org/OzzyCzech/events) [![Latest Stable Version](https://poser.pugx.org/om/events/v/stable.png)](https://packagist.org/packages/om/events) [![Total Downloads](https://poser.pugx.org/om/events/downloads.png)](https://packagist.org/packages/om/events) [![Latest Unstable Version](https://poser.pugx.org/om/events/v/unstable.png)](https://packagist.org/packages/om/events) [![License](https://poser.pugx.org/om/events/license.png)](https://packagist.org/packages/om/events)

## Examples

function way

    on('event', function () {
      echo "wow it's work";
    });

    trigger('event'); // print wow it's work

    on('price', function($price) {
      return (int)$price . ' USD';
    });

    echo filter('price', 100); // print 100 USD

static class way

    Trigger::on('event', function() {
      echo "wow it's work";
    });

    Trigger::event(); // print wow it's work

    Filter::register('price', function($price) {
      return (int)$price . ' USD';
    });
    echo Filter::price(100); // print 100 USD

own way

    class Wtf {
      use EventHandling; // trait way
    }

    $wtf = new Wtf();
    $wtf->on('something', function() {});

prioritizing events handlers

    on('title', function ($title) {
      return '<h1>' . $title . '</h1>';
    }, 20);

    echo filter('title', 'text'); // <h1>text</h1>

    on('title', function ($title) {
      return '<a href="#title">' . $title . '</a>';
    });

    echo filter('title', 'text'); // <h1><a href="#title">text</a></h1>

> Please notice that default event priority is 10!

## Advanced

Add and remove listener

    $handler = function() { };
    on('event', $handler);
    off('event', $handler);

Add and remove all listeners

    $handler = function() { };
    on('event', $handler);
    on('event', $handler);
    on('event', $handler);
    off('event');

Get all events

    $events = events();
    $listeners = listeners('event');
