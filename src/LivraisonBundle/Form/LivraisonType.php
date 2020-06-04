<?php

namespace LivraisonBundle\Form;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivraisonType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')->add('adresse')->add('prix', MoneyType::class)->add('tel', TelType::class)->add('Agent', EntityType::class,
         array(
            'class'        => 'LivraisonBundle:User',
            'query_builder' => function (EntityRepository $er) {
             return $er->createQueryBuilder('us')->select('u')
             ->from('LivraisonBundle:User', 'u')
             ->where('u.roles LIKE :roles')
             ->setParameter('roles', '%ROLE_AGENT%');
            }
           , 'choice_label' => 'id',
          )
        )->add('Client', EntityType::class,
        array(
           'class'        => 'LivraisonBundle:User',
           'query_builder' => function (EntityRepository $er) {
            return $er->createQueryBuilder('us')->select('u')
            ->from('LivraisonBundle:User', 'u')
            ->where('u.roles  NOT LIKE :roles AND u.roles  NOT LIKE :role ')
            ->setParameters(array('roles'=> '%ROLE_ADMIN%','role'=>'%ROLE_AGENT%'));
           }
          , 'choice_label' => 'id',
         )
       );
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LivraisonBundle\Entity\Livraison'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'livraisonbundle_livraison';
    }


}
