<?php

namespace App\Service;

use App\Utils\Decodable;

/**
 * Class CurrencyApiService
 * @package App\Service
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class CurrencyApiService extends ApiService
{
	use Decodable;

	/**
	 * @var string
	 */
	private $apiKey;

	public function __construct()
	{
		parent::__construct();
	}

	protected function initialize(): void
	{
		$this->url    = getenv('CURRENCY_API_URL');
		$this->apiKey = getenv('CURRENCY_API_KEY');
	}

	/**
	 * @param array $to
	 * @return array
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getUSDRates(array $to): array
	{
		return $this->decode($this->sendRequest($this->concatUrl($to)));
	}

	/**
	 * @param array       $to
	 * @param string|null $from
	 * @param bool        $json
	 * @return string
	 */
	private function concatUrl(array $to, ?string $from = null, bool $json = true): string
	{
		$concatenatedURL = $this->url . '?access_key=' . $this->apiKey;

		if ($from) $concatenatedURL .= '&source=' . $from;

		$concatenatedURL .= '&currencies=' . implode(',', $to);

		if ($json) $concatenatedURL .= '&format=1';

		return $concatenatedURL;
	}
}