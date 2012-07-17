<?php

use Nette\Application\Responses\JsonResponse;
use Misak\Model\NetModel;

/**
 * Description of ControlPresenter
 *
 * @author misak113
 */
class ControlPresenter extends BasePresenter {

	/** @var NetModel */
	protected $netModel;

	public function setContext(NetModel $netModel) {
		$this->netModel = $netModel;
	}




	public function renderTurnedOn() {
		$payload = $this->payload;
		$payload->turnedOn = $this->netModel->isTurnedOn();
		$response = new JsonResponse($payload);

		$this->sendResponse($response);
	}

}