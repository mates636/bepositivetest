<?php declare(strict_types = 1);

namespace App\Domain\Product;

use App\Model\Database\Entity\AbstractEntity;
use App\Model\Database\Entity\TCreatedAt;
use App\Model\Database\Entity\TId;
use App\Model\Database\Entity\TUpdatedAt;
use App\Model\Exception\Logic\InvalidArgumentException;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Domain\Product\ProductRepository")
 * @ORM\Table(name="`product`")
 * @ORM\HasLifecycleCallbacks
 */
class Product extends AbstractEntity
{
	use TCreatedAt;
	use TUpdatedAt;
	use TId;


	/** @ORM\Column(type="string", length=255, nullable=FALSE, unique=false) */
	private string $name;

	/** @ORM\Column(type="integer", length=255, nullable=FALSE, unique=false) */
	private int $price;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Domain\Order\Order", mappedBy="products")
	 */
	private Collection $orders;


	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): void
	{
		$this->name = $name;
	}

	public function getPrice(): int
	{
		return $this->price;
	}

	public function setPrice(int $price): void
	{
		$this->price = $price;
	}

	public function getOrders(): Collection
	{
		return $this->orders;
	}

	public function setOrders(Collection $orders): void
	{
		$this->orders = $orders;
	}


	public function __construct()
	{
		$this->orders = new ArrayCollection();
	}

}
