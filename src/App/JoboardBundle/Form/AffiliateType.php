<?php

namespace App\JoboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use App\JoboardBundle\Entity\Affiliate;
use App\JoboardBundle\Entity\Category;


// ваще нихера не ясно!!!!!!

class AffiliateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url')
            ->add('email')
            ->add('categories', null, ['expanded' => true])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\JoboardBundle\Entity\Affiliate',
        ]);
    }

    public function getName()
    {
        return 'affiliate';
    }
}