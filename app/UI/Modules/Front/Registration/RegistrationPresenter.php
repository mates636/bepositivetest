<?php declare(strict_types = 1);

namespace App\UI\Modules\Front\Registration;

use App\Domain\User\User;
use App\UI\Modules\Front\BaseFrontPresenter;
use Doctrine\ORM\EntityManagerInterface;
use App\Model\Security\SecurityUser;
use Nette\Application\UI\Form;
use Nette\Security\Passwords;

final class RegistrationPresenter extends BaseFrontPresenter
{

	/** @var EntityManagerInterface @inject */
	public EntityManagerInterface $em;

	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}

	protected function createComponentRegistrationForm(): Form
	{
		$form = new Form;
		$form->addText('name', 'Name:');
		$form->addText('surname', 'Surname:');
		$form->addText('email', 'Email:');
		$form->addText('username', 'Username:');
		$form->addPassword('password', 'Password:');
		$form->addSubmit('send', 'Register');
		$form->onSuccess[] = [$this, 'formSucceeded'];
		return $form;
	}

	public function formSucceeded(Form $form, \stdClass $values): void
	{
		$passwords = new Passwords();
		$hashedPassword = $passwords->hash($values->password);

		$user = new User($values->name, $values->surname, $values->email, $values->username, $values->password);
		$user->setName($values->name);
		$user->setSurname($values->surname);
		$user->setEmail($values->email);
		$user->setUsername($values->username);
		$user->setPassword($hashedPassword);
//		$user->setRole($values->role);
		$user->setRole(User::ROLE_ADMIN);
		$user->activate();

		$em = $this->em;

		$em->persist($user);
		$em->flush();
	}

	public function renderDefault(): void
	{
		$userRepository = $this->em->getRepository(User::class);
		$users = $userRepository->findAll();
		$this->template->users = $users;
	}
}





