<?php

namespace App\Service;

use App\Utils\Decodable;

/**
 * Class CountryApiService
 * @package App\Service
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class CountryApiService extends ApiService
{
	use Decodable;

	public function __construct()
	{
		parent::__construct();
	}


	protected function initialize(): void
	{
		$this->url = getenv('COUNTRIES_API_URL');
	}

	/**
	 * @param $capital
	 * @return array
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function findCountryDetailsByCapital($capital): array
	{
		return $this->decode($this->sendRequest($this->url . '/capital/' . strtolower($capital)));
	}

	/**
	 * @return array
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function findAll(): array
	{
		return $this->decode($this->sendRequest($this->url . '/all'));
	}
}