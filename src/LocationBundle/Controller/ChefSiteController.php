<?php

namespace LocationBundle\Controller;

use LocationBundle\Entity\Site;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use LocationBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ChefSiteController extends Controller
{
    public function afficherClientAction(Request $request){
        $query = $this->getDoctrine()->getManager()
            ->createQuery(
                'SELECT u FROM LocationBundle:User u WHERE u.roles NOT LIKE :roleadmin AND u.roles NOT LIKE :rolecchefsite'
            )->setParameter('roleadmin', '%"ROLE_ADMIN"%')
            ->setParameter('rolecchefsite', '%"ROLE_CHEF_SITE"%');
        $users = $query->getResult();

        $query1 = $this->getDoctrine()->getManager()
            ->createQuery(
                'SELECT s.id, s.emplacement FROM LocationBundle:Site s');
        $sites = $query1->getResult();

        $form = $this->createFormBuilder()
            ->add('site', EntityType::class, [
                'class' => Site::class,
                'choice_label' => 'emplacement',
                'choice_value' => 'id'
            ])
            ->add('client', null, array(
                'attr'=>array('style'=>'display:none;') ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            $data = $form["site"]->getData()->getid();
            $client = $form["client"]->getData();
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('LocationBundle:User')->find($client);
            $user->addRole("ROLE_CHEF_SITE");
            $user->removeRole("ROLE_USER");
            $user->setNumeroSite($data);
            $em->flush();
            return $this->redirectToRoute("location_Chefsite_affichage");
//            return $this->render("@Location/ChefSite/ajoutChefSite.html.twig",
//                array('clients'=>$users, /*'sites'=>$sites,*/ 'formObject'=>$form));
        }

        return $this->render("@Location/ChefSite/ajoutChefSite.html.twig",
            array('clients'=>$users, /*'sites'=>$sites,*/ 'formObject'=>$form));

    }

    public function UpgradetoChefSiteAction(User $User, Request $request){
        $id = $User->getId();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('LocationBundle:User')->findBy($id);
        $user->addRole("ROLE_CHEF_SITE");
        $em->flush();
        return $this->redirectToRoute("location_Chefsite_affichage");
    }

    public function afficherChefSiteAction(){
        $query = $this->getDoctrine()->getEntityManager()
            ->createQuery(
                'SELECT u FROM LocationBundle:User u WHERE u.roles LIKE :role'
            )->setParameter('role', '%"ROLE_CHEF_SITE"%');
        $users = $query->getResult();

        return $this->render("@Location/ChefSite/affichageChefSite.html.twig",array('Chefsite'=>$users));

    }

    public function DowngradetoClientAction(User $User, Request $request){
        $id = $User->getId();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('LocationBundle:User')->find($id);
        $user->removeRole("ROLE_CHEF_SITE");
        $em->flush();
        return $this->redirectToRoute("location_Chefsite_affichage");
    }
}
