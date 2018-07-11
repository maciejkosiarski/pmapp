<?php

namespace App\Tests\Service;

use App\Service\CurrencyApiService;
use PHPUnit\Framework\TestCase;

/**
 * Class CurrencyApiServiceTest
 * @package App\Tests\Service
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class CurrencyApiServiceTest extends TestCase
{
	/**
	 * @var CurrencyApiService
	 */
	private $currencyApi;

	public function __construct(?string $name = null, array $data = [], string $dataName = '')
	{
		parent::__construct($name, $data, $dataName);

		$this->currencyApi = new CurrencyApiService();
	}

	/**
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function testGetUSDRates()
	{
		$result = $this->currencyApi->getUSDRates(['PLN', 'GBP']);

		$this->assertInternalType('array', $result);
		$this->assertArrayHasKey('quotes', $result);
		$this->assertArrayHasKey('success', $result);
	}

	public function testApiFailed()
	{
		$result = $this->currencyApi->getUSDRates(['fakeCurrency']);

		$this->assertArrayHasKey('success', $result);
		$this->assertArrayHasKey('error', $result);
		$this->assertEquals(false, $result['success']);
		$this->assertEquals(202, $result['error']['code']);
	}
}