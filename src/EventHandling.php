<?php
namespace om;

/**
 * @author Roman Ozana <ozana@omdesign.cz>
 */
trait EventHandling {

	/** @var array */
	protected $listeners = [];

	/**
	 * Add listener to some event
	 *
	 * @param string $event
	 * @param callable $listener
	 * @param int $priority
	 */
	public function on($event, callable $listener, $priority = 10) {
		$this->listeners[$event][$priority][] = $listener;
	}

	/**
	 * Add listener that can run only once
	 *
	 * @param string $event
	 * @param callable $listener
	 * @param int $priority
	 */
	public function once($event, callable $listener, $priority = 10) {
		$onceListener = function () use (&$onceListener, $event, $listener) {
			$this->removeListeners($event, $onceListener);
			call_user_func_array($listener, func_get_args());
		};

		$this->on($event, $onceListener, $priority);
	}

	/**
	 * List all registered events
	 *
	 * @return array
	 */
	public function events() {
		return array_keys($this->listeners);
	}

	/**
	 * Remove one or all listeners from event
	 *
	 * @param string $event
	 * @param callable $listener
	 * @return bool
	 */
	public function removeListeners($event, callable $listener = null) {
		if (!isset($this->listeners[$event])) return;

		if ($listener === null) {
			unset($this->listeners[$event]);
		} else {
			foreach ($this->listeners[$event] as $priority => $listeners) {
				if (false !== ($index = array_search($listener, $listeners, true))) {
					unset($this->listeners[$event][$priority][$index]);
				}
			}
		}

		return true;
	}

	/**
	 * @param string $event
	 * @return array
	 */
	public function listeners($event) {
		if (isset($this->listeners[$event])) {
			ksort($this->listeners[$event]);
			return call_user_func_array('array_merge', $this->listeners[$event]);
		}
	}

	/**
	 * @param string $event
	 */
	public function trigger($event) {
		$args = func_get_args();
		$event = array_shift($args);

		foreach ($this->listeners($event) as $listener) {
			call_user_func_array($listener, $args);
		}
	}

	/**
	 * @param $event
	 * @return bool
	 */
	public function exists($event) {
		return isset($this->listeners[$event]);
	}

	/**
	 * @param string $event
	 * @param mixed $value
	 * @return mixed
	 */
	public function filter($event, $value = null) {
		$args = func_get_args();
		$event = array_shift($args);

		foreach ((array)$this->listeners($event) as $listener) {
			$args[0] = $value;
			$value = call_user_func_array($listener, $args);
		}

		return $value;
	}
}