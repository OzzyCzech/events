<?php
/**
 * @author Roman Ozana <ozana@omdesign.cz>
 */

/**
 * @param string $event
 * @param callable $listener
 * @param int $priority
 */
function on($event, callable $listener, $priority = 10) {
	return Events::instance()->on($event, $listener, $priority);
}

/**
 * @param $event
 * @param callable $listener
 * @param int $priority
 */
function once($event, callable $listener, $priority = 10) {
	return Events::instance()->once($event, $listener, $priority);
}

/**
 * @param string $event
 * @return mixed
 */
function trigger($event) {
	return call_user_func_array([Events::instance(), 'trigger'], func_get_args());
}

/**
 * @param string $event
 * @param null $value
 * @return mixed
 */
function filter($event, $value = null) {
	return call_user_func_array([Events::instance(), 'filter'], func_get_args());
}

/**
 * @return array
 */
function events() {
	return Events::instance()->events();
}

/**
 * @param string $event
 * @param callable $listener
 */
function off($event, callable $listener = null) {
	Events::instance()->off($event, $listener);
}

/**
 * @param $event
 * @return array
 */
function listeners($event) {
	return Events::instance()->listeners($event);
}