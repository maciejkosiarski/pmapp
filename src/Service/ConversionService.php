<?php

namespace App\Service;

use App\Entity\Conversion;
use App\Exception\CountryApiException;
use App\Exception\CurrencyApiException;
use App\Exception\InputDataToConvertException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class ConversionService
 * @package App\Service
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class ConversionService
{
	/**
	 * @var CountryApiService
	 */
	private $countryApi;

	/**
	 * @var CurrencyApiService
	 */
	private $currencyApi;

	/**
	 * @var EntityManager
	 */
	private $em;

	public function __construct(
		CountryApiService $countryApi,
		CurrencyApiService $currencyApi,
		EntityManagerInterface $em
	){
		$this->countryApi  = $countryApi;
		$this->currencyApi = $currencyApi;
		$this->em          = $em;
	}

	/**
	 * @param array $data
	 * @return Conversion
	 * @throws CountryApiException
	 * @throws CurrencyApiException
	 * @throws GuzzleException
	 * @throws InputDataToConvertException
	 * @throws \App\Exception\CurrenciesQuotesException
	 * @throws \Doctrine\ORM\ORMException
	 * @throws \Doctrine\ORM\OptimisticLockException
	 */
	public function convert(array $data): Conversion
	{
		if (!isset($data['capitalCity']) || !isset($data['money'])) {
			throw new InputDataToConvertException();
		}

		if (!$this->cityIsValid($data['capitalCity'])) {
			throw new CountryApiException($data['capitalCity']);
		};

		foreach ($this->getCountryCurrenciesByCity($data['capitalCity']) as $currency) {
			$currenciesRates = $this->currencyApi->getUSDRates([
				Conversion::BASE_CURRENCY,
				$currency['code'],
			]);

			if(!$currenciesRates['success']) {
				throw new CurrencyApiException($currenciesRates['code']);
			}

			$conversion = $this->setConversionEntity(
				$data['capitalCity'],
				$data['money'],
				$currency['code'],
				$this->convertMoney($currenciesRates['quotes'], $data['money'], $currency['code'])
			);

			$this->em->persist($conversion);
			$this->em->flush();

			return $conversion;
		}

		throw new CountryApiException($data['capitalCity']);
	}

	/**
	 * @param array  $currenciesQuotes
	 * @param int    $money
	 * @param string $convertTo
	 * @return float
	 * @throws \App\Exception\CurrenciesQuotesException
	 */
	private function convertMoney(array $currenciesQuotes, int $money, string $convertTo): float
	{
		$converter = new MoneyConverter($convertTo);

		return	$converter->convert($currenciesQuotes, $money);
	}

	/**
	 * @param string $capitalCity
	 * @param int    $money
	 * @param string $currency
	 * @param float  $converted
	 * @return Conversion
	 */
	private function setConversionEntity(string $capitalCity, int $money, string $currency, float $converted): Conversion
	{
		$conversion = new Conversion();
		$conversion->setCapitalCity($capitalCity);
		$conversion->setMoney($money);
		$conversion->setCurrency($currency);
		$conversion->setConverted($converted);

		return $conversion;
	}

	/**
	 * @param string $city
	 * @return bool
	 * @throws GuzzleException
	 */
	private function cityIsValid(string $city): bool
	{
		return in_array($city, array_filter(array_map(function($country) {
			return $country['capital'];
		},$this->countryApi->findAll())));
	}

	/**
	 * @param string $city
	 * @return array
	 * @throws CountryApiException
	 */
	private function getCountryCurrenciesByCity(string $city): array
	{
		try {
			$details = $this->countryApi->findCountryDetailsByCapital($city);

			if (empty($details)) throw new CountryApiException($city);

			$details = current($details);

			return $details['currencies'];
		} catch (GuzzleException $e) {
			throw new CountryApiException($city);
		}
	}
}