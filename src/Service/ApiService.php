<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

/**
 * Class ApiService
 * @package App\Service
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
abstract class ApiService
{
	/**
	 * @var string
	 */
	protected $url;

	/**
	 * @var ClientInterface
	 */
	private $clientHttp;

	public function __construct()
	{
		$this->clientHttp = new Client();
		$this->initialize();
	}

	/**
	 * Initialize Api service,
	 * e.g set attributes
	 * or run necessary processes
	 */
	protected abstract function initialize(): void;

	/**
	 * @param string      $url
	 * @param array       $options
	 * @param null|string $httpMethod
	 * @return string
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	protected function sendRequest(string $url, array $options = [], string $httpMethod = 'GET'): string
	{
		return $this->clientHttp
			->request($httpMethod, $url, $options)
			->getBody()
			->getContents();
	}
}