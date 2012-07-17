<?php

namespace Misak\Model;

use Framework\BaseModel;
use Nette\Database\Connection;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NetModel
 *
 * @author misak113
 */
class NetModel extends BaseModel {
	

	public function setContext(Connection $connection) {

	}

	public function wakeOnLan($addr, $mac, $socket_number) {
		$return = array();

		$addr_byte = explode(':', $mac);
		$hw_addr = '';
		for ($a = 0; $a < 6; $a++) {
			$hw_addr .= chr(hexdec($addr_byte[$a]));
		}
		$msg = chr(255) . chr(255) . chr(255) . chr(255) . chr(255) . chr(255);
		for ($a = 1; $a <= 16; $a++) {
			$msg .= $hw_addr;
		}
		$return['msg'] = $msg;
		$return['lenght'] = strlen($msg);

		// send it to the broadcast address using UDP
		// SQL_BROADCAST option isn't help!!
		$s = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		if ($s == false) {
			throw new AbortException("Error code is '" . socket_last_error($s) . "' - " . socket_strerror(socket_last_error($s)));
		} else {
			// setting a broadcast option to socket:
			$opt_ret = socket_set_option($s, SOL_SOCKET, SO_BROADCAST, TRUE);
			if ($opt_ret < 0) {
				throw new AbortException("setsockopt() failed, error: " . strerror($opt_ret));
			}
			if (socket_sendto($s, $msg, strlen($msg), 0, $addr, $socket_number)) {
				socket_close($s);
				return $return;
			} else {
				throw new AbortException("Magic packet failed!");
			}
		}
	}

}