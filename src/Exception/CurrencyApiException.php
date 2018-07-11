<?php

namespace App\Exception;

/**
 * Class CurrencyApiException
 * @package App\Exception
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class CurrencyApiException extends \Exception
{
	public function __construct(int $code = 0, string $message = 'We do not have access to current currencies. Please try again later.')
	{
		parent::__construct($message, $code);
	}
}