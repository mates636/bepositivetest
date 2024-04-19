<?php declare(strict_types = 1);

namespace App\UI\Modules\Admin\Sign;

use App\Model\Security\Authenticator\UserAuthenticator;
use App\Model\Security\SecurityUser;
use App\Domain\User\User;
use App\UI\Modules\Front\BaseFrontPresenter;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;

final class SignPresenter extends BaseFrontPresenter
{
	private UserAuthenticator $userAuthenticator;

	public function __construct(UserAuthenticator $userAuthenticator)
	{
		parent::__construct();
		$this->userAuthenticator = $userAuthenticator;
	}

	protected function createComponentSignForm(): Form
	{
		$form = new Form;
		$form->addText('username', 'Username:');
		$form->addPassword('password', 'Password:');
		$form->addSubmit('send', 'Sign in');
		$form->onSuccess[] = [$this, 'formSucceeded'];
		return $form;
	}


	public function formSucceeded(Form $form, \stdClass $data): void
	{
		try {
			$this->getUser()->login($data->username, $data->password);
		} catch (Nette\Security\AuthenticationException $e) {
			$form->addError('Nesprávné přihlašovací jméno nebo heslo.');
		}
		if ($this->getUser()->isInRole('admin')){
			$this->redirect(':Admin:Home:Default');
		} else {
			$this->redirect(':Front:Home:Default');
		}
	}
}
