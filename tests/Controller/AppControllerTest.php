<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AppControllerTest
 * @package App\Tests\Controller
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class AppControllerTest extends WebTestCase
{
	/**
	 * PHPUnit's data providers allow to execute the same tests repeated times
	 * using a different set of data each time.
	 * See https://symfony.com/doc/current/cookbook/form/unit_testing.html#testing-against-different-sets-of-data.
	 *
	 * @dataProvider getPublicUrls
	 */
	public function testPublicUrls($url)
	{
		$client = static::createClient();
		$client->request('GET', $url);

		$this->assertSame(
			Response::HTTP_OK,
			$client->getResponse()->getStatusCode(),
			sprintf('The %s public URL loads correctly.', $url)
		);
	}

	public function getPublicUrls()
	{
		yield ['/'];
		yield ['/new'];
	}
}