<?php
namespace om;

/**
 * @method static on($event, callable $listener, $priority = 10)
 * @method static once($event, callable $listener, $priority = 10)
 * @method static events()
 * @method static remove($event, callable $listener)
 * @method static removeAll($event = null)
 * @method static listeners($event)
 * @method static trigger($event)
 * @method static filter($event, $value = null)
 *
 * @author Roman Ožana <ozana@omdesign.cz>
 */
class GlobalEvents {

	/** @var Events */
	protected static $instance;

	/**
	 * @param $name
	 * @param $arguments
	 * @return mixed
	 */
	public static function __callStatic($name, $arguments) {
		return call_user_func_array([static::instance(), $name], $arguments);
	}

	/**
	 * @return Events
	 */
	public static function instance() {
		if (!static::$instance) static::$instance = new Events();
		return static::$instance;
	}
}
