<?php

use Nette\Application\UI;
use Nette\Security as NS;
use Misak\Application\BasePresenter;


/**
 * Sign in/out presenters.
 *
 * @author     John Doe
 * @package    MyApplication
 */
class SignPresenter extends BasePresenter
{


	/**
	 * Sign in form component factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = new UI\Form;
		$form->addText('username', 'Uživatelské jméno:')
			->setRequired('Prosím zadejte uživatelské jméno.');

		$form->addPassword('password', 'Heslo:')
			->setRequired('Prosím zadejte heslo.');

		$form->addCheckbox('remember', 'Zapamatovat na tomto počítači');

		$form->addSubmit('send', 'Přihlásit');

		$form->onSuccess[] = callback($this, 'signInFormSubmitted');
		return $form;
	}



	public function signInFormSubmitted($form)
	{
		try {
			$values = $form->getValues();
			if ($values->remember) {
				$this->getUser()->setExpiration('+ 3 hours', FALSE);
			} else {
				$this->getUser()->setExpiration('+ 20 minutes', TRUE);
			}
			$this->getUser()->login($values->username, $values->password);
			$this->redirect('Site:');

		} catch (NS\AuthenticationException $e) {
			$form->addError($e->getMessage());
		}
	}



	public function actionOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('You have been signed out.');
		$this->redirect('in');
	}

}
