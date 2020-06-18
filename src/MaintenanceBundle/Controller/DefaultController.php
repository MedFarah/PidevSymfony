<?php

namespace MaintenanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $RDVaconfirmer = null;
        if ($this->getUser()){
        $etat = "en cours";
        $RDVaconfirmer = $this->getDoctrine()->getManager()->createQuery(
            'SELECT m FROM MaintenanceBundle:maintenance m WHERE m.etat = :etat and m.id_user= :id'
        )->setParameter('etat', $etat)->setParameter('id', $this->getUser()->getid())->getResult();
        }
        return $this->render('MaintenanceBundle:Default:index.html.twig', array(
            'RDVaconfirmer' => $RDVaconfirmer,
        ));
    }
}
