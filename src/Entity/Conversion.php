<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Conversion
 * @package App\Entity
 * @ORM\Table(name="conversions")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class Conversion extends BaseEntity
{
	const BASE_CURRENCY = 'PLN';

	/**
	 * @var string
	 * @ORM\Column(name="capital_city", type="string", nullable=false)
	 * @Assert\NotBlank(groups={"form", "all"})
	 * @Assert\Type("string", groups={"form", "all"})
	 */
	private $capitalCity;

	/**
	 * @var string
	 * @ORM\Column(name="currency", type="string", nullable=false)
	 * @Assert\NotBlank(groups={"all"})
	 * @Assert\Type("string", groups={"all"})
	 * @Assert\Currency()
	 */
	private $currency;

	/**
	 * @var int
	 * @ORM\Column(name="money", type="integer", nullable=false)
	 * @Assert\NotBlank(groups={"form", "all"})
	 * @Assert\Type("numeric", groups={"form", "all"})
	 * @Assert\GreaterThan(0, groups={"form", "all"})
	 */
	private $money;

	/**
	 * @var float
	 * @ORM\Column(name="converted", type="float", nullable=false)
	 * @Assert\NotBlank(groups={"all"})
	 * @Assert\Type("float", groups={"all"})
	 * @Assert\GreaterThan(0, groups={"all"})
	 */
	private $converted;

	/**
	 * @return string
	 */
	public function getCapitalCity(): ?string
	{
		return $this->capitalCity;
	}

	/**
	 * @param string $capitalCity
	 */
	public function setCapitalCity(string $capitalCity): void
	{
		$this->capitalCity = $capitalCity;
	}

	/**
	 * @return string
	 */
	public function getCurrency(): string
	{
		return $this->currency;
	}

	/**
	 * @param string $currency
	 */
	public function setCurrency(string $currency): void
	{
		$this->currency = $currency;
	}

	/**
	 * @return int
	 */
	public function getMoney(): ?int
	{
		return $this->money;
	}

	/**
	 * @param int $money
	 */
	public function setMoney(int $money): void
	{
		$this->money = $money;
	}

	/**
	 * @return float
	 */
	public function getConverted(): float
	{
		return $this->converted;
	}

	/**
	 * @param float $converted
	 */
	public function setConverted(float $converted): void
	{
		$this->converted = $converted;
	}
}