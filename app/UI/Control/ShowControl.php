<?php declare(strict_types = 1);
namespace App\UI\Control;

use App\Domain\User\User;
use App\UI\Control\BaseControl;
use Doctrine\ORM\EntityManagerInterface;



class ShowControl extends BaseControl
{
	/** @var EntityManagerInterface @inject */
	private EntityManagerInterface $em;

	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}


	public function renderUsers()
	{
		$userRepository = $this->em->getRepository(User::class);
		return $userRepository->findAll();
	}

	public function renderHello(): void
	{
		echo "Hello";
	}

}
