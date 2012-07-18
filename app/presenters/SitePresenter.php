<?php

use Misak\Model\NetModel;
use Misak\Application\BasePresenter;

/**
 * Homepage presenter.
 *
 * @author     John Doe
 * @package    MyApplication
 */
class SitePresenter extends BasePresenter {

	/** @var NetModel */
	protected $netModel;

	public function setContext(NetModel $netModel) {
		$this->netModel = $netModel;
	}

	public function renderDefault() {

		$computers = $this->context->parameters['computers'];
		$this->template->computers = $computers;
	}

	

}
