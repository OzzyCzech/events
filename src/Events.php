<?php

/**
 * @author Roman Ožana <ozana@omdesign.cz>
 */
class Events {
	use EventHandling; // that's all

	/** @var Events */
	protected static $instance;

	/**
	 * @return Events
	 */
	public static function instance() {
		if (!static::$instance) static::$instance = new Events();
		return static::$instance;
	}
}

/**
 * @author Roman Ožana <ozana@omdesign.cz>
 */
class Trigger {

	/**
	 * Add listener to some event
	 *
	 * @param string $event
	 * @param callable $listener
	 * @param int $priority
	 */
	public static function on($event, callable $listener, $priority = 10) {
		Events::instance()->on($event, $listener, $priority);
	}

	/**
	 * @param $name
	 * @param $arguments
	 * @return mixed
	 */
	public static function __callStatic($name, $arguments) {
		array_unshift($arguments, $name);
		return call_user_func_array([Events::instance(), 'trigger'], $arguments);
	}

}

/**
 * @author Roman Ožana <ozana@omdesign.cz>
 */
class Filter {

	/**
	 * Add listener to some event
	 *
	 * @param $name
	 * @param callable $listener
	 * @param int $priority
	 * @internal param callable $listeners
	 */
	public static function register($name, callable $listener, $priority = 10) {
		Events::instance()->on($name, $listener, $priority);
	}

	/**
	 * @param $name
	 * @param $arguments
	 * @return mixed
	 */
	public static function __callStatic($name, $arguments) {
		array_unshift($arguments, $name);
		return call_user_func_array([Events::instance(), 'filter'], $arguments);
	}
}