<?php

namespace App\Exception;

/**
 * Class InputDataToConvertException
 * @package App\Exception
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class InputDataToConvertException extends \Exception
{
	public function __construct(string $message = 'Data to convert was invalid.', int $code = 400)
	{
		parent::__construct($message, $code);
	}
}