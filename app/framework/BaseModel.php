<?php

namespace Framework;

use Nette\DI\Container;
use Nette\Database\Connection;

/**
 * Description of BaseModel
 *
 * @author misak113
 */
class BaseModel {
	
	/** @var Container */
	protected $context;
	/** @var Connection */
	protected $connection;
	/** @var string */
	public static $misakDomain;

	public function __construct(Container $context, Connection $connection) {
		$this->context = $context;
		$this->connection = $connection;
		if (method_exists($this, 'setContext')) {
			$this->context->callMethod(array($this, 'setContext'));
		}
		self::$misakDomain = $this->context->parameters['domain'];
	}



	public function getComputers() {
		$computers = $this->context->parameters['computers'];
		foreach ($computers as &$computer) {
			if ($computer['forwardPort']) {
				$computer['httpUrl'] = 'http://'.self::$misakDomain.':'.$computer['forwardPort'];
			} else {
				$computer['httpUrl'] = 'javascript: ;';
			}
		}
		return $computers;
	}

}