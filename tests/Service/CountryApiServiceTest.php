<?php

namespace App\Tests\Service;

use App\Service\Api\CountryApiService;
use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\TestCase;

/**
 * Class CountryApiServiceTest
 * @package App\Tests\Service
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class CountryApiServiceTest extends TestCase
{
	/**
	 * @var CountryApiService
	 */
	private $countryApi;

	public function __construct(?string $name = null, array $data = [], string $dataName = '')
	{
		parent::__construct($name, $data, $dataName);

		$this->countryApi = new CountryApiService();
	}

	public function testFindCountryDetailsByCapital()
	{
		$result = $this->countryApi->findCountryDetailsByCapital('London');

		$this->assertInternalType('array', $result);
		$this->assertArrayHasKey(0, $result);
		$this->assertArrayHasKey('capital', $result[0]);
		$this->assertEquals('London', $result[0]['capital']);
	}

	public function testFindAll()
	{
		$countryApi = new CountryApiService();

		$result = $countryApi->findAll();

		$this->assertInternalType('array', $result);
	}

	public function testApiException()
	{
		$this->expectException(ClientException::class);

		$this->countryApi->findCountryDetailsByCapital('FakeCity');
	}
}