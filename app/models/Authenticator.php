<?php

namespace Misak\Model;

use Nette\Security as NS;
use Framework\BaseModel;


/**
 * Users authenticator.
 *
 * @author     Michael Žabka
 */
class Authenticator extends BaseModel implements NS\IAuthenticator
{
	/** @var Nette\Database\Table\Selection */
	private $users;



	public function setContext() {
		$users = $this->context->parameters['users'];
		$this->users = $users;
	}



	/**
	 * Performs an authentication
	 * @param  array
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;
		if (!isset($this->users[$username])) {
			throw new NS\AuthenticationException("User '$username' not found.", self::IDENTITY_NOT_FOUND);
		}
		$user = $this->users[$username];

		if ($user['password'] !== $this->calculateHash($password)) {
			throw new NS\AuthenticationException("Invalid password.", self::INVALID_CREDENTIAL);
		}

		unset($user['password']);
		return new NS\Identity($user['id'], $user['role'], $user);
	}



	/**
	 * Computes salted password hash.
	 * @param  string
	 * @return string
	 */
	public function calculateHash($password)
	{
		return sha1($password);
	}

}
