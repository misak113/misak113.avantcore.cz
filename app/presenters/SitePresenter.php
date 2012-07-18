<?php

use Misak\Model\NetModel;

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
		
	}

	

}
