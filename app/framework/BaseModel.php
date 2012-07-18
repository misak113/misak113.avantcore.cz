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

	public function __construct(Container $context, Connection $connection) {
		$this->context = $context;
		$this->connection = $connection;
		if (method_exists($this, 'setContext')) {
			$this->context->callMethod(array($this, 'setContext'));
		}
	}
}