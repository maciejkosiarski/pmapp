<?php

namespace App\EventListener;

use App\Event\MoneyConvertedEvent;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class MoneyConvertedListener
 * @package App\EventListener
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class MoneyConvertedListener
{
	/**
	 * @var EntityManagerInterface
	 */
	private $em;

	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}

	/**
	 * @param MoneyConvertedEvent $event
	 */
	public function onMoneyConverted(MoneyConvertedEvent $event): void
	{
		$this->em->persist($event->getConversion());

		$this->em->flush();
	}
}