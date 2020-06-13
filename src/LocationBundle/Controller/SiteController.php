<?php

namespace LocationBundle\Controller;

use LocationBundle\Entity\Site;
use LocationBundle\Form\SiteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

class SiteController extends Controller
{
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function ajoutSiteAction(Request $request)
    {
        $site = new Site();
        $form = $this->createForm(SiteType::class, $site);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($site);
            $em->flush();
            return $this->redirectToRoute("location_site_affichage");
        }
        return $this->render("@Location/Site/ajoutSite.html.twig",array('form'=>$form->createView()));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function afficherSiteAction()
    {
        $em = $this->getDoctrine()->getManager();
        $site = $em->getRepository("LocationBundle:Site")->findAll();
        return $this->render("@Location/Site/affichageSite.html.twig",array('site'=>$site));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function suppSiteAction(Site $site, Request $request){
        $id = $site->getId();
        $em = $this->getDoctrine()->getManager();
        $site = $em->getRepository('LocationBundle:Site')->find($id);
        $em->remove($site);
        $em->flush();
        return $this->redirectToRoute('location_site_affichage');
    }
}
