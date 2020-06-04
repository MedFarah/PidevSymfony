<?php

namespace LivraisonBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('adresse')->add('tel', TelType::class)->add('nomComplet');
        $builder->add('roles', ChoiceType::class, array(
            'attr'  =>  array('class' => 'form-control',
                'style' => 'margin:5px 0;'),
            'choices' =>
                array
                (
                        'ROLE_ADMIN' => 'ROLE_ADMIN',
                        'ROLE_CLIENT' => 'ROLE_CLIENT',
                        'ROLE_AGENT' => 'ROLE_AGENT'
                ) ,
            'multiple' => true,
            'required' => true,
        )
    );
  
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LivraisonBundle\Entity\User'
        ));
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'livraisonbundle_user';
    }
}
