<?php
/**
 * @author Roman Ozana <ozana@omdesign.cz>
 */
use om\GlobalEvents;

/**
 * @param string $event
 * @param callable $listener
 * @param int $priority
 */
function on($event, callable $listener, $priority = 10) {
	return GlobalEvents::instance()->on($event, $listener, $priority);
}

/**
 * @param $event
 * @param callable $listener
 * @param int $priority
 */
function once($event, callable $listener, $priority = 10) {
	return GlobalEvents::instance()->once($event, $listener, $priority);
}

/**
 * @param string $event
 */
function trigger($event) {
	return GlobalEvents::instance()->trigger($event);
}

/**
 * @param string $event
 * @param null $value
 * @return mixed
 */
function filter($event, $value = null) {
	return GlobalEvents::instance()->filter($event, $value);
}

/**
 * @return array
 */
function getEvents() {
	return GlobalEvents::instance()->events();
}

/**
 * @param string $event
 * @param callable $listener
 */
function removeEventListener($event, callable $listener) {
	return GlobalEvents::instance()->remove($event, $listener);
}

/**
 * @param null $event
 */
function removeAllEventListeners($event = null) {
	return GlobalEvents::instance()->removeAll($event);
}

/**
 * @param $event
 * @return array
 */
function getEventListeners($event) {
	return GlobalEvents::instance()->listeners($event);
}
