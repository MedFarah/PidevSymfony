<?php

namespace MaintenanceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints;


class maintenanceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')
            ->add('description', TextareaType::class, array(
                'attr' => array('cols' => '5', 'rows' => '5'),
            ))
            ->add('dateRDV', DateTimeType::class, array(
                'data' => new \DateTime('now +1 day'),
                'date_widget' => 'single_text',
                'time_widget' => 'text',
                'attr'=>array('style'=>'date'),
                'constraints' => [
                    new Constraints\NotBlank(),
                    new Constraints\DateTime(),
                    new Constraints\Callback(function($object, ExecutionContextInterface $context) {
                        $start = $context->getRoot()->getData();
                        $start = $start->getDateRDV();
                        $today = new \DateTime();

                        if (is_a($start, \DateTime::class) ) {
                            if ($start->format('U') - $today->format('U') <= 0) {
                                $context
                                    ->buildViolation("la date du rendez vous doit être superieur à la date d'aujourd'hui")
                                    ->addViolation();
                            }
                        }
                    }),
                ])
            );
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
