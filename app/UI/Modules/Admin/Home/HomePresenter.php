<?php declare(strict_types = 1);

namespace App\UI\Modules\Admin\Home;

use App\Domain\Order\Event\OrderCreated;
use App\Domain\Order\Order;
use App\Domain\Product\Product;
use App\Domain\User\User;
use App\UI\Modules\Admin\BaseAdminPresenter;
use App\UI\Modules\Front\BaseFrontPresenter;
use Doctrine\ORM\EntityManagerInterface;
use Nette\Application\UI\Component;
use Nette\Application\UI\Form;
use Nette\Application\UI\Control;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class HomePresenter extends BaseAdminPresenter
{

	/** @var EventDispatcherInterface @inject */
	public EventDispatcherInterface $dispatcher;
	/** @var EntityManagerInterface @inject */
	public EntityManagerInterface $em;


	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}

	public function createComponentLogOut(): Component
	{
		$this->user->logout();
		$this->redirect('Sign:default');
	}
}

