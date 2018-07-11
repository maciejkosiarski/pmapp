<?php

namespace App\Tests\Service;

use App\Entity\Conversion;
use App\Service\ConversionService;
use App\Service\Api\CountryApiService;
use App\Service\Api\CurrencyApiService;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class ConversionServiceTest
 * @package App\Tests\Service
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class ConversionServiceTest extends TestCase
{

	public function testConvert()
	{
		$conversionToCompare = new Conversion();
		$conversionToCompare->setCapitalCity('London');
		$conversionToCompare->setMoney(1000	);
		$conversionToCompare->setCurrency('GBP');
		$conversionToCompare->setConverted(200);

		$conversionService = new ConversionService(
			$this->getCountryApiMock(),
			$this->getCurrencyApiMock(),
			$this->getDispatcherMock()
		);

		$result = $conversionService->convert(['capitalCity' => 'London', 'money' => 1000]);

		$this->assertInstanceOf(Conversion::class, $result);
		$this->assertEquals($conversionToCompare, $result);
		$this->assertEquals('London', $result->getCapitalCity());
		$this->assertEquals(1000, $result->getMoney());
		$this->assertEquals('GBP', $result->getCurrency());
		$this->assertEquals(200, $result->getConverted());
	}

	/**
	 * @return \PHPUnit\Framework\MockObject\MockObject
	 */
	private function getDispatcherMock(): MockObject
	{
		return $this->getMockBuilder(EventDispatcher::class)
			->disableOriginalConstructor()
			->getMock();
	}

	/**
	 * @return MockObject
	 */
	private function getCountryApiMock(): MockObject
	{
		$countryApiMock = $this->getMockBuilder(CountryApiService::class)
			->disableOriginalConstructor()
			->setMethods(['findAll', 'findCountryDetailsByCapital'])
			->getMock();

		$countryApiMock->method('findAll')
			->will($this->returnValue([['capital' => 'London']]));

		$countryApiMock->method('findCountryDetailsByCapital')
			->will($this->returnValue([['currencies' => [['code' => 'GBP']]]]));

		return $countryApiMock;
	}

	/**
	 * @return MockObject
	 */
	private function getCurrencyApiMock(): MockObject
	{
		$currencyApiMock = $this->getMockBuilder(CurrencyApiService::class)
			->disableOriginalConstructor()
			->setMethods(['getUSDRates'])
			->getMock();

		$currencyApiMock
			->method('getUSDRates')
			->with(['PLN', 'GBP'])
			->willReturn(['success' => true, 'quotes' => ['USDPLN' => 3.5, 'USDGBP' => 0.7]]);

		return $currencyApiMock;
	}
}