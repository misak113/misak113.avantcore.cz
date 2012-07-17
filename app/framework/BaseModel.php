<?php

namespace Framework;

use Nette\DI\Container;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseModel
 *
 * @author misak113
 */
class BaseModel {
	
	/** @var Container */
	protected $context;

	public function __construct(Container $context) {
		$this->context = $context;
		if (method_exists($this, 'setContext')) {
			$this->context->callMethod(array($this, 'setContext'));
		}
	}
}