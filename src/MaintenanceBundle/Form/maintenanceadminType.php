<?php

namespace MaintenanceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class maintenanceadminType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date',DateTimeType::class, [
            'mapped' => false,
                'date_widget' => 'single_text',
                'time_widget' => 'choice',
                ])
            ->add('id',null, [
                'mapped' => false,
                'attr'=>array('style'=>'display:none;'),
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MaintenanceBundle\Entity\maintenance'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'maintenancebundle_maintenance';
    }


}
