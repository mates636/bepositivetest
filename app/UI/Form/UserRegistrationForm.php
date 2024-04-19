<?php declare(strict_types = 1);

namespace App\UI\Form;

use Nette\Application\UI\Form;
use App\Domain\User\User;
use Doctrine\ORM\EntityManagerInterface;

class UserRegistrationForm extends BaseForm
{
	/** @var EntityManagerInterface */
	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		parent::__construct();
		$this->entityManager = $entityManager;
	}

	public function createComponentRegistrationForm(): Form
	{
		$form = new Form();

		$form->addText('username', 'Username:')
			->setRequired('Please enter your username.');

		$form->addEmail('email', 'Email:')
			->setRequired('Please enter your email.');

		$form->addPassword('password', 'Password:')
			->setRequired('Please enter your password.');

		$form->addPassword('password_confirm', 'Confirm Password:')
			->setRequired('Please confirm your password.')
			->addRule(Form::EQUAL, 'Passwords do not match.', $form['password']);

		$form->addSubmit('submit', 'Register');

		$form->onSuccess[] = [$this, 'processRegistration'];

		return $form;
	}

	public function processRegistration(Form $form, \stdClass $values): void
	{
		$user = new User();
		$user->setUsername($values->username);
		$user->setEmail($values->email);
		$user->setPassword($values->password);

		$this->entityManager->persist($user);
		$this->entityManager->flush();
	}

}
