<?php

use Misak\Model\NetModel;
use Misak\Application\BasePresenter;

/**
 * Homepage presenter.
 *
 * @author     Michael Žabka
 */
class SitePresenter extends BasePresenter {

	/** @var NetModel */
	protected $netModel;

	public function beforeRender() {
		if (!$this->getUser()->isInRole('admin')) {
			$this->redirect('Sign:in');
		}
	}

	public function setContext(NetModel $netModel) {
		$this->netModel = $netModel;
	}

	public function renderDefault() {

		$computers = $this->netModel->getComputers();
		$this->template->computers = $computers;
	}

	

}
