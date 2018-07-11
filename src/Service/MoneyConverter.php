<?php

namespace App\Service;

use App\Exception\CurrenciesQuotesException;

/**
 * Class MoneyConverter
 * @package App\Service
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class MoneyConverter
{
	/**
	 * @var string
	 */
	private $from;

	/**
	 * @var string
	 */
	private $to;

	/**
	 * @var string
	 */
	private $base;

	public function __construct(string $to, string $from = 'PLN', string $base = 'USD')
	{
		$this->from = $from;
		$this->to   = $to;
		$this->base = $base;
	}

	/**
	 * @param array $currenciesQuotes
	 * @param int   $money
	 * @return float
	 * @throws CurrenciesQuotesException
	 */
	public function convert(array $currenciesQuotes, int $money): float
	{
		$this->validCurrenciesQuotes($currenciesQuotes);

		$convertedToBase = $money / $currenciesQuotes[$this->base . $this->from];

		return $convertedToBase * $currenciesQuotes[$this->base . $this->to];
	}

	/**
	 * @param array $currenciesQuotes
	 * @throws CurrenciesQuotesException
	 */
	private function validCurrenciesQuotes(array $currenciesQuotes): void
	{
		if (!isset($currenciesQuotes[$this->base . $this->from])) {
			throw new CurrenciesQuotesException();
		}

		if (!isset($currenciesQuotes[$this->base . $this->to])) {
			throw new CurrenciesQuotesException();
		}

		if (!is_numeric($currenciesQuotes[$this->base . $this->from])) {
			throw new CurrenciesQuotesException();
		}

		if (!is_numeric($currenciesQuotes[$this->base . $this->to])) {
			throw new CurrenciesQuotesException();
		}
	}
}