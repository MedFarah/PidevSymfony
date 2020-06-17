<?php

namespace CommandeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class commandeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('refCmd', TextType::class,[
            'attr' => ['class' => 'form-control']
        ])

            ->add('etatCmd', ChoiceType::class, array(
                    'attr' => ['class' => 'form-control'],
                    'choices'  => array(
                        'En cours' => 'En cours',
                        'Valider' => 'Valider',
                        'Annuler' => 'Annuler',
                    ),

                )
            )
            ->add('prixCmd', IntegerType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->
            add('idUser',EntityType::class,array(
                'label' => 'User ',
                'attr' => ['class' => 'form-control'],
                'class'=>'CommandeBundle\Entity\User',
                'choice_label'=>'username',


            ));
    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CommandeBundle\Entity\commande'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'commandebundle_commande';
    }


}