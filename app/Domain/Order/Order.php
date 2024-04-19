<?php declare(strict_types = 1);

namespace App\Domain\Order;

use App\Model\Database\Entity\AbstractEntity;
use App\Model\Database\Entity\TCreatedAt;
use App\Model\Database\Entity\TId;
use App\Model\Database\Entity\TUpdatedAt;
use App\Model\Exception\Logic\InvalidArgumentException;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\User\User;
use App\Domain\Product\Product;
use App\Domain\Order\OrderRepository;


/**
 * @ORM\Entity(repositoryClass="App\Domain\Order\OrderRepository")
 * @ORM\Table(name="`order`")
 * @ORM\HasLifecycleCallbacks
 */
class Order extends AbstractEntity
{
	use TCreatedAt;
	use TUpdatedAt;
	use TId;


	/**
	 * @ORM\ManyToOne(targetEntity="App\Domain\User\User", inversedBy="order")
	 */
	private int $users;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Domain\Product\Product", inversedBy="orders")
	 * @ORM\JoinTable(name="orders_products")
	 */
	private Collection $products;

	public function getUsers(): int
	{
		return $this->users;
	}

	public function setUsers(int $users): void
	{
		$this->users = $users;
	}







	public function getProducts(): Collection
	{
		return $this->products;
	}

	public function setProducts(Collection $products): void
	{
		$this->products = $products;
	}

	public function __construct()

	{
		$this->products = new ArrayCollection();
	}

}
