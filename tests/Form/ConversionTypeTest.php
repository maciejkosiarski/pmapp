<?php


namespace App\Tests\Form;

use App\Entity\Conversion;
use App\Form\ConversionType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * Class ConversionTypeTest
 * @package App\Tests\Form
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class ConversionTypeTest extends TypeTestCase
{
	public function testSubmitValidData()
	{
		$formData = array(
			'capitalCity' => 'Cairo',
			'money' => '2500',
		);

		$objectToCompare = new Conversion();

		$form = $this->factory->create(ConversionType::class, $objectToCompare);

		$object = new Conversion();
		$object->setCapitalCity($formData['capitalCity']);
		$object->setMoney($formData['money']);

		$form->submit($formData);

		$this->assertTrue($form->isSynchronized());

		$this->assertEquals($object, $objectToCompare);

		$view = $form->createView();
		$children = $view->children;

		foreach (array_keys($formData) as $key) {
			$this->assertArrayHasKey($key, $children);
		}
	}
}