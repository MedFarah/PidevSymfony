<?php

namespace LocationBundle\Form;

use LocationBundle\Entity\Site;
use LocationBundle\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


class DetailLocationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateDebut', DateType::class, array(
//                'data' => new \DateTime('now +1 day'),
                'widget' => 'single_text',
                'label' => "data debut location :",
                'constraints' => [
                    new Constraints\NotBlank(),
                    new Constraints\DateTime(),
                    new Constraints\Callback(function($object, ExecutionContextInterface $context) {
                        $start = $context->getRoot()->getData();
                        $start = $start->getDateDebut();
                        $today = new \DateTime();

                        if (is_a($start, \DateTime::class) ) {
                            if ($start->format('U') - $today->format('U') <= 0) {
                                $context
                                    ->buildViolation("la date début doit être superieur à la date d'aujourd'hui")
                                    ->addViolation();
                            }
                        }
                    }),
                ],
            ))
            ->add('dateFin', DateType::class, array(
//                'data' => new \DateTime('now +2 day'),
                'widget' => 'single_text',
                'constraints' => [
                    new Constraints\NotBlank(),
                    new Constraints\DateTime(),
                    new Constraints\Callback(function($object, ExecutionContextInterface $context) {
                        $start = $context->getRoot()->getData();
                        $start = $start->getDateDebut();
                        $stop = $object;

                        if (is_a($start, \DateTime::class) && is_a($stop, \DateTime::class)) {
                            if ($stop->format('U') - $start->format('U') <= 0) {
                                $context
                                    ->buildViolation('La date fin doit être superieure à la date début')
                                    ->addViolation();
                            }
                        }
                    }),
                ],
            ))
            ->add('id_Site', EntityType::class, [
                'class' => Site::class,
                'choice_label' => 'emplacement',
                'choice_value' => 'id'
            ])
            ->add('id_Type',EntityType::class, [
                'class' =>Type::class,
                'choice_label' => 'image',
                'choice_value' => 'id',
                'expanded' => true,
            ])
            ->add('submit',SubmitType::class)
            ->add('reset',ResetType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LocationBundle\Entity\DetailLocation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'locationbundle_detaillocation';
    }


}
