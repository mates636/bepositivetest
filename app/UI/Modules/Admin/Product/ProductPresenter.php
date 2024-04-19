<?php declare(strict_types = 1);

namespace App\UI\Modules\Admin\Product;

use App\Domain\Order\Event\OrderCreated;
use App\Domain\Order\Order;
use App\Domain\Product\Product;
use App\Domain\User\User;
use App\UI\Modules\Admin\BaseAdminPresenter;
use App\UI\Modules\Front\BaseFrontPresenter;
use Doctrine\ORM\EntityManagerInterface;
use Nette\Application\UI\Form;
use Nette\Application\UI\Control;
use Nette\Security\Passwords;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class ProductPresenter extends BaseAdminPresenter
{

	/** @var EventDispatcherInterface @inject */
	public EventDispatcherInterface $dispatcher;
	/** @var EntityManagerInterface @inject */
	public EntityManagerInterface $em;


	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}

	protected function createComponentProductForm(): Form
	{
		$form = new Form();
		$form->addText('name', 'name')
			->setRequired(true);
		$form->addInteger('price', 'price');
		$form->addSubmit('send', 'Add');
		$form->onSuccess[] = [$this, 'formSucceeded'];
		return $form;
	}

	public function formSucceeded(Form $form, \stdClass $values): void
	{
		$product = new Product($values->name, $values->price);
		$product->setName($values->name);
		$product->setPrice($values->price);

		$em = $this->em;

		$em->persist($product);
		$em->flush();
		$this->redirect("Product:default");
	}

}
