<?php

namespace MaintenanceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $permissions = array(
            'Utilisateur'        => 'ROLE_USER',
            'Administrateur'     => 'ROLE_ADMIN'
        );
        $builder->add('nom')->add('prenom')->add('numtel');
        $builder->add('roles', ChoiceType::class, array(
                'attr'  =>  array('class' => 'form-control',
                    'style' => 'margin:5px 0;'),
                'choices' => $permissions,
                'multiple' => true,
                'required' => true
            )
        );
    }
//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults(array(
//            'data_class' => 'LocationBundle\Entity\User'
//        ));
//    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }


}
