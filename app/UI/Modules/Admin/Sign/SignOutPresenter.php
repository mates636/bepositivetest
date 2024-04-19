<?php declare(strict_types = 1);

namespace App\UI\Modules\Admin\Sign;

use App\Model\Security\Authenticator\UserAuthenticator;
use App\Model\Security\SecurityUser;
use App\Domain\User\User;
use App\UI\Modules\Front\BaseFrontPresenter;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;

final class SignOutPresenter extends BaseFrontPresenter
{
	private UserAuthenticator $userAuthenticator;

	public function actionOut(): void
	{
		$this->getUser()->logout();
		$this->redirect(':Front:home:');
	}
}
