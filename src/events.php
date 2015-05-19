<?php
/**
 * @author Roman Ozana <ozana@omdesign.cz>
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
function once($event, callable $listener, $priority = 10) {
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
 * @param $event
 * @return array
 */
function fire($event) {
	$args = func_get_args();
	$event = array_shift($args);

	$out = [];
	foreach ((array)listeners($event) as $listener) {
		if (($out[] = call_user_func_array($listener, $args)) === false) break; // return false ==> stop propagation
	}

	return $out;
}

/**
 * Care about something by default event listener.
 *
 * @param string $event
 * @param callable $listener
 * @return mixed
 */
function care($event, callable $listener = null) {
	if ($listener) on($event, $listener, 0); // register default listener

	if ($listeners = listeners($event)) {
		return call_user_func_array(end($listeners), array_slice(func_get_args(), 2));
	}
}

/**
 * Pass variable with all filters.
 *
 * @param $event
 * @param null $value
 * @return mixed|null
 */
function filter($event, $value = null) {
	$args = func_get_args();
	$event = array_shift($args);

	foreach ((array)listeners($event) as $listener) {
		$args[0] = $value;
		$value = call_user_func_array($listener, $args);
	}

	return $value;
}

// ---------------------------------------------------- aliases ---------------------------------------------------- //

/**
 * Trigger an action.
 *
 * @param $event
 * @return mixed
 */
function action($event) {
	return call_user_func_array('\fire', func_get_args());
}

/**
 * Trigger an action.
 *
 * @param $event
 * @return mixed
 */
function trigger($event) {
	return call_user_func_array('\fire', func_get_args());
}

/**
 * @param $event
 * @param callable $listener
 * @param int $priority
 */
function add_action($event, callable $listener, $priority = 10) {
	on($event, $listener, $priority);
}

/**
 * @param $event
 * @param callable $listener
 * @param int $priority
 */
function add_listener($event, callable $listener, $priority = 10) {
	on($event, $listener, $priority);
}

/**
 * @param $event
 * @param callable $listener
 * @param int $priority
 */
function add_filter($event, callable $listener, $priority = 10) {
	on($event, $listener, $priority);
}