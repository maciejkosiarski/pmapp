<?php

namespace App\Exception;

/**
 * Class CountryApiException
 * @package App\Exception
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class CountryApiException extends \Exception
{
	public function __construct(string $city)
	{
		$message = sprintf(
			'We do not have access to current details of %s city. Please try again later or check the correctness of the capital city name.',
			$city
		);

		parent::__construct($message);
	}
}