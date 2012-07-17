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

	public function renderWakeOn() {
		$pc = $this->context->parameters['mainPc'];
		
		// Port number where the computer is listening. Usually, any number between 1-50000 will do. Normally people choose 7 or 9.
		$socket_number = "7";
		// MAC Address of the listening computer's network device
		$mac_addy = $pc['mac'];
		// IP address of the listening computer. Input the domain name if you are using a hostname (like when under Dynamic DNS/IP)
		$ip_addy = "192.168.1.255"; //gethostbyname("myhomeserver.dynamicdns.org");

		$this->netModel->wakeOnLan($ip_addy, $mac_addy, $socket_number);
	}

}
