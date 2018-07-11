<?php

namespace App\Exception;

/**
 * Class CurrenciesQuotesException
 * @package App\Exception
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class CurrenciesQuotesException extends \Exception
{
	public function __construct(string $message = 'Currencies quotes error ;-(.', int $code = 400)
	{
		parent::__construct($message, $code);
	}
}