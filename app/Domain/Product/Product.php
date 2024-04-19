<?php declare(strict_types = 1);

namespace App\Domain\Product;

use App\Model\Database\Entity\AbstractEntity;
use App\Model\Database\Entity\TCreatedAt;
use App\Model\Database\Entity\TId;
use App\Model\Database\Entity\TUpdatedAt;
use App\Model\Exception\Logic\InvalidArgumentException;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: "`product`")]
class Product extends AbstractEntity
{
	use TCreatedAt;
	use TUpdatedAt;

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private int $id;


	#[ORM\Column(type: "string", length: 10, nullable: false)]
	private string $name;


	#[ORM\Column(type: "integer", length: 10, nullable: false)]
	private int $price;


}
