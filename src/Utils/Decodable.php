<?php

namespace App\Utils;

use Symfony\Component\Serializer\Encoder\JsonDecode;

/**
 * Trait Decodable
 * @package App\Service
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
trait Decodable
{
	/**
	 * @param $json
	 * @return array
	 */
	private function decode($json): array
	{
		return (new JsonDecode())
			->decode($json, 'json', ['json_decode_associative' => true]);
	}
}