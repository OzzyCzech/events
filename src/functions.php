<?php
/**
 * @author Roman Ozana <ozana@omdesign.cz>
 */

/**
 * Register listener on event
 *
 * @param string $event
 * @param callable $listener
 * @param int $priority
 */
function on($event, callable $listener, $priority = 10) {
	return Events::instance()->on($event, $listener, $priority);
}

/**
 * Run listener only once
 *
 * @param $event
 * @param callable $listener
 * @param int $priority
 */
function once($event, callable $listener, $priority = 10) {
	return Events::instance()->once($event, $listener, $priority);
}

/**
 * Trigger event
 *
 * @param string $event
 * @return mixed
 */
function trigger($event) {
	return call_user_func_array([Events::instance(), 'trigger'], func_get_args());
}

/**
 * Filter input with event listeners
 *
 * @param string $event
 * @param null $value
 * @return mixed
 */
function filter($event, $value = null) {
	return call_user_func_array([Events::instance(), 'filter'], func_get_args());
}

/**
 * Un-register listener(s) from event
 *
 * @param string $event
 * @param callable $listener
 */
function off($event, callable $listener = null) {
	Events::instance()->off($event, $listener);
}

/**
 * Return all listeners on some event
 *
 * @param $event
 * @return array
 */
function listeners($event) {
	return Events::instance()->listeners($event);
}


/**
 * Return list of events
 *
 * @return array
 */
function events() {
	return Events::instance()->events();
}