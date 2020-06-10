<?php

namespace GPBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use GPBundle\Entity\Entreprise;


class ProduitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
        ->add('description')
        ->add('couleur')
        ->add('prix')
        ->add('prixt')
        ->add('remise')
        ->add('prixr')
        ->add('entreprise', EntityType::class , [
            'class' => Entreprise::class,
            'choice_label' => 'marque'
        ])
        ->add('imageFile', VichImageType::class, [
            'required' => false,
        ]) ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GPBundle\Entity\Produit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gpbundle_produit';
    }


}
