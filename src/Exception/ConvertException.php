<?php


namespace App\Exception;

use Throwable;

/**
 * Class ConvertException
 * @package App\Exception
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class ConvertException extends \Exception
{
	public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}