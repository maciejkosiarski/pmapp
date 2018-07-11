<?php

namespace App\Event;

use App\Entity\Conversion;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class MoneyConvertedEvent
 * @package App\Event
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class MoneyConvertedEvent extends Event
{
	const NAME = 'money.converted';

	/**
	 * @var Conversion
	 */
	protected $conversion;

	public function __construct(Conversion $conversion)
	{
		$this->conversion = $conversion;
	}

	public function getConversion(): Conversion
	{
		return $this->conversion;
	}
}