<?php

namespace App\Tests\Service;

use App\Exception\CurrenciesQuotesException;
use App\Utils\MoneyConverter;
use PHPUnit\Framework\TestCase;

/**
 * Class MoneyConverterTest
 * @package App\Tests\Service
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class MoneyConverterTest extends TestCase
{
	/**
	 * @throws \App\Exception\CurrenciesQuotesException
	 */
	public function testConvert()
	{
		foreach ($this->getTestCurrenciesQuotesData() as $testData) {
			$converter = new MoneyConverter('GBP');

			$result = $converter->convert($testData, 1000);

			$this->assertEquals($testData['expected'], $result);
		}

		foreach ($this->getTestCurrenciesQuotesInvalidData() as $testData) {
			$this->expectException(CurrenciesQuotesException::class);

			$converter = new MoneyConverter('GBP');

			$converter->convert($testData, 1000);
		}
	}


	/**
	 * @return array
	 */
	public function getTestCurrenciesQuotesData(): array
	{
		return [
			[
				'USDPLN'   => 3.5,
				'USDGBP'   => 0.7,
				'expected' => 200,
			],
			[
				'USDPLN'   => 4,
				'USDGBP'   => 2,
				'expected' => 500,
			],
			[
				'USDPLN'   => 5,
				'USDGBP'   => 1.5,
				'expected' => 300,
			],
		];
	}

	/**
	 * @return array
	 */
	public function getTestCurrenciesQuotesInvalidData(): array
	{
		return [
			[
				'USD'    => 3.5,
				'USDGBP' => 0.7,
			],
			[
				'USDPLN' => 4,
				'USD'    => 2,
			],
			[
				'USDPLN' => 'abc',
				'USDGBP' => 1.5,
			],
			[
				'USDPLN' => 2,
				'USDGBP' => 'abc',
			],
		];
	}


}