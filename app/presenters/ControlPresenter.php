<?php

use Nette\Application\Responses\JsonResponse;
use Misak\Model\NetModel;
use Nette\Application\AbortException;
use Misak\Application\BasePresenter;

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
		$pcName = $this->getParameter('name', NULL);
		$payload = $this->payload;
		if (!isset($this->context->parameters['computers'][$pcName])) {
			$payload->status = 'error';
			$payload->message = 'Bad computer name.';
			$response = new JsonResponse($payload);
			$this->sendResponse($response);
		}
		$pc = $this->context->parameters['computers'][$pcName];
		$payload->status = 'ok';
		$payload->turnedOn = $this->netModel->isTurnedOn($pc['ip']);

		$response = new JsonResponse($payload);
		$this->sendResponse($response);
	}

	public function renderWakeOn() {
		$pcName = $this->getParameter('name', NULL);
		$payload = $this->payload;
		if (!isset($this->context->parameters['computers'][$pcName])) {
			$payload->status = 'error';
			$payload->message = 'Bad computer name.';
			$response = new JsonResponse($payload);
			$this->sendResponse($response);
		}
		$pc = $this->context->parameters['computers'][$pcName];
		
		// Port number where the computer is listening. Usually, any number between 1-50000 will do. Normally people choose 7 or 9.
		$socket_number = "7";
		// MAC Address of the listening computer's network device
		$mac_addy = $pc['mac'];
		// IP address of the listening computer. Input the domain name if you are using a hostname (like when under Dynamic DNS/IP)
		$ip_addy = "192.168.1.255";

		$payload = $this->payload;
		try {
			$this->netModel->wakeOnLan($ip_addy, $mac_addy, $socket_number);
			$payload->status = 'ok';
			$payload->message = 'Wake on success';
		} catch (AbortException $e) {
			$payload->status = 'error';
			$payload->message = $e->getMessage();
		}

		$response = new JsonResponse($payload);

		$this->sendResponse($response);
	}

}