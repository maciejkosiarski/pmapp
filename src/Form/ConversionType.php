<?php

namespace App\Form;

use App\Entity\Conversion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConversionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('capitalCity', TextType::class, [
				'required' => true,
			])
            ->add('money', IntegerType::class, [
				'required' => true,
            	'label' => 'Money PLN',
			])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Conversion::class,
			'validation_groups' => ['form'],
        ]);
    }
}
