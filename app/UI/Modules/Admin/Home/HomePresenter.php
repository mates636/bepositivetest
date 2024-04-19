<?php declare(strict_types = 1);

namespace App\UI\Modules\Admin\Home;

use App\Domain\Order\Event\OrderCreated;
use App\Domain\Order\Order;
use App\Domain\Product\Product;
use App\Domain\User\User;
use App\UI\Modules\Admin\BaseAdminPresenter;
use App\UI\Modules\Front\BaseFrontPresenter;
use Doctrine\ORM\EntityManagerInterface;
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

	protected function createComponentOrderForm(): Form
	{
		$form = new Form();

		$form->addText('order', 'Order name')
			->setRequired(true);
		$form->addSubmit('send', 'OK');

		$form->onSuccess[] = function (Form $form): void {
			$this->dispatcher->dispatch(new OrderCreated($form->values->order), OrderCreated::NAME);
		};
		return $form;
	}


//	public function renderDefault(): void
//	{
//		$orderRepository = $this->em->getRepository(Order::class);
//		$orders = $orderRepository->findAll();
//		$this->template->orders = $orders;
//	}

	public function renderDefault(): void
	{
		$productRepository = $this->em->getRepository(Product::class);
		$product = $productRepository->findAll();
		$this->template->product = $product;
	}
//	public function createComponentLogOut(): Control
//	{
//		$this->getUser()->logout();
//	}
//	public function render(): void
//	{
//		$this->template->setFile(__DIR__ . '/logoutButton.latte');
//		$this->template->render();
//	}
//
//	public function handleLogout(): void
//	{
//		$this->presenter->logout();
//	}
//	public function renderDefault(): void
//	{
//		if ($this->getUser()->isLoggedIn()) {
//			dd("das");
//		} else {
//			dd("asfa");
//		}
//	}

}
