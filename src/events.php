<?php
/**
 * @author Roman Ožana <ozana@omdesign.cz>
 */

/**
 * Return events object
 *
 * @return stdClass
 */
function events() {
	static $events;
	return $events ?: $events = new stdClass();
}

/**
 * Return listeners
 *
 * @param $event
 * @return mixed
 */
function listeners($event) {
	if (isset(events()->$event)) {
		ksort(events()->$event);
		return call_user_func_array('array_merge', events()->$event);
	}
}

/**
 * Add event listener
 *
 * @param $event
 * @param callable $listener
 * @param int $priority
 */
function on($event, callable $listener = null, $priority = 10) {
	events()->{$event}[$priority][] = $listener;
}

/**
 * Trigger only once.
 *
 * @param $event
 * @param callable $listener
 * @param int $priority
 */
function one($event, callable $listener, $priority = 10) {
	$once = function () use (&$once, $event, $listener) {
		off($event, $once);
		return call_user_func_array($listener, func_get_args());
	};

	on($event, $once, $priority);
}

/**
 * Remove one or all listeners from event.
 *
 * @param $event
 * @param callable $listener
 * @return bool
 */
function off($event, callable $listener = null) {
	if (!isset(events()->$event)) return;

	if ($listener === null) {
		unset(events()->$event);
	} else {
		foreach (events()->$event as $priority => $listeners) {
			if (false !== ($index = array_search($listener, $listeners, true))) {
				unset(events()->{$event}[$priority][$index]);
			}
		}
	}

	return true;
}

/**
 * Trigger events
 *
 * @param string|array $events
 * @param array $args
 * @return array
 */
function trigger($events, ...$args) {
	$out = [];
	foreach ((array)$events as $event) {
		foreach ((array)listeners($event) as $listener) {
			if (($out[] = call_user_func_array($listener, $args)) === false) break; // return false ==> stop propagation
		}
	}

	return $out;
}

/**
 * Pass variable with all filters.
 *
 * @param string|array $events
 * @param null $value
 * @param array $args
 * @return mixed|null
 * @internal param null $value
 */
function filter($events, $value = null, ...$args) {
	array_unshift($args, $value);
	foreach ((array)$events as $event) {
		foreach ((array)listeners($event) as $listener) {
			$args[0] = $value = call_user_func_array($listener, $args);
		}
	}
	return $value;
}

/**
 * @param $event
 * @param callable $listener
 * @param int $priority
 */
function add_filter($event, callable $listener, $priority = 10) {
	on($event, $listener, $priority);
}

/**
 * Ensure that something will be handled
 *
 * @param string $event
 * @param callable $listener
 * @return mixed
 */
function ensure($event, callable $listener = null) {
	if ($listener) on($event, $listener, 0); // register default listener

	if ($listeners = listeners($event)) {
		return call_user_func_array(end($listeners), array_slice(func_get_args(), 2));
	}
}