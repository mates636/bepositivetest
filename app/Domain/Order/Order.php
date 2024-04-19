<?php declare(strict_types = 1);

namespace App\Domain\Order;

use App\Model\Database\Entity\AbstractEntity;
use App\Model\Database\Entity\TCreatedAt;
use App\Model\Database\Entity\TId;
use App\Model\Database\Entity\TUpdatedAt;
use App\Model\Exception\Logic\InvalidArgumentException;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\User\User;
use App\Domain\Product\Product;
use App\Domain\Order\OrderRepository;


#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: "`order`")]
class Order extends AbstractEntity
{
	use TCreatedAt;
	use TUpdatedAt;

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private int $id;


	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\User\User", inversedBy="order")
	 */
	private $user;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Product\Product", mappedBy="order")
	 */
	private $products;

}
