<?php declare(strict_types = 1);

namespace App\UI\Modules\Admin\Order;

use App\Domain\Order\Event\OrderCreated;
use App\Domain\Order\Order;
use App\Domain\Product\Product;
use App\Domain\User\User;
use App\UI\Modules\Admin\BaseAdminPresenter;
use App\UI\Modules\Front\BaseFrontPresenter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Nette\Application\UI\Form;
use Nette\Application\UI\Control;
use Nette\Security\Passwords;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Domain\User\UserRepository;
use App\Domain\Product\ProductRepository;

final class OrderPresenter extends BaseAdminPresenter
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

		$users = $this->em->getRepository(User::class)->findAll();
		$userOptions = [];
		foreach ($users as $user) {
			$userOptions[$user->getId()] = $user->getFullname();
		}

		$products = $this->em->getRepository(Product::class)->findAll();
		$productOptions = [];
		foreach ($products as $product) {
			$productOptions[$product->getId()] = $product->getName();
		}

		$form->addSelect('user', 'User:', $userOptions)
			->setPrompt('Select user');

		$form->addMultiSelect('products', 'Products:', $productOptions)
			->setRequired('Select products');

		$form->addSubmit('send', 'Add');

		$form->onSuccess[] = [$this, 'formSucceeded'];

		return $form;
	}

	public function formSucceeded(Form $form, \stdClass $values): void
	{

		$order = new Order();
		$user = $this->em->getRepository(User::class)->find($values->user);
		$order->setUser($user);
//		$product = $this->em->getRepository(Product::class)->find($values->products);
//		$products = new ArrayCollection([$product]);
//		$order->setProducts($products);
		$productIds = (array) $values->products;
		$products = new ArrayCollection();

		foreach ($productIds as $productId) {
			$product = $this->em->getRepository(Product::class)->find($productId);
			if ($product) {
				$products->add($product);
			}
		}

		$order->setProducts($products);

		$em = $this->em;

		$em->persist($order);
		$em->flush();
		$this->redirect("Order:default");

	}

}
