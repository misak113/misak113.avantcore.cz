<?php

namespace Misak\Model;

use Framework\BaseModel;
use Nette\Database\Connection;
use Nette\Application\AbortException;

/**
 * Description of NetModel
 *
 * @author misak113
 */
class NetModel extends BaseModel {

	

	public function wakeOnLan($addr, $mac, $socket_number) {
		$return = array();

		$addr_byte = explode(':', $mac);
		if (count($addr_byte) != 6) {
			throw new AbortException('MAC adresa musí být ve tvaru XX:XX:XX:XX:XX:XX');
		}

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

	public function isTurnedOn($pc) {
		$turnedOn = $this->urlExists('http://'.$this->context->parameters['domain'].':'.$pc['forwardPort']);
		if ($turnedOn) {
			return true;
		}
		$turnedOn = $this->urlExists('http://'.$pc['ip']);
		return $turnedOn;
	}

	protected function urlExists($url) {
		$a_url = parse_url($url);
		if (!isset($a_url['port']))
			$a_url['port'] = 80;
		$errno = 0;
		$errstr = '';
		$timeout = 1;
		if (isset($a_url['host']) && $a_url['host'] != gethostbyname($a_url['host'])) {
			$fid = @fsockopen($a_url['host'], $a_url['port'], $errno, $errstr, $timeout);
			if (!$fid)
				return false;
			$page = isset($a_url['path']) ? $a_url['path'] : '';
			$page = $page ? $page :'/';
			$page .= isset($a_url['query']) ? '?' . $a_url['query'] : '';
			$request = 'HEAD ' . $page . ' HTTP/1.1' . "\r\n" . 'Host: ' . $a_url['host'] . "\r\n\r\n";
			fputs($fid, $request);
			$head = fread($fid, 4096);
			fclose($fid);
			return (boolean)preg_match('#^HTTP/.*\s+[200|302]+\s#i', $head);
		} else {
			return false;
		}
	}

}