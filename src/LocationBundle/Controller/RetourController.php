<?php

namespace LocationBundle\Controller;

use LocationBundle\Entity\DetailLocation;
use LocationBundle\Entity\Retours;
use LocationBundle\Form\RetoursType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RetourController extends Controller
{
    public function affichageRetourAction(Request $request){

        $numsite = $this->getUser()->getnumerosite();
        $query = $this->getDoctrine()->getManager()
            ->createQuery(
                'SELECT dl.id, dl.dateFin, u.nom, u.prenom FROM LocationBundle:DetailLocation dl join LocationBundle:User u WITH dl.id_user = u.id WHERE dl.id_site = :numsite and dl.status = :status '
            )->setParameter('numsite', $numsite)->setParameter('status', "en cours");
        $location = $query->getResult();

        $em = $this->getDoctrine()->getManager();
        $listeRetour = $em->getRepository('LocationBundle:Retours')->findall();

        $retour = new Retours();
        $form = $this->createForm(RetoursType::class, $retour);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $retour = new Retours();
            $retour->setEtat($form["etat"]->getData());
            $retour->setRetard($form["retard"]->getData());
            $location = $em->getRepository('LocationBundle:DetailLocation')->find($form["numlocation"]->getData());
            $retour->setIdLocation($location);
            $em->persist($retour);
            $em->flush();
            $location->setStatus("terminé");
            $em->flush();

            if ($form["etat"]->getData()== false && $form["retard"]->getData()==false )
                $nb = "";
            else{
                $nb = "<p>priere de noter que :</p><ul>";
                if ($form["etat"]->getData()){
                    $nb = $nb."<li>le velo est endomagé</li>";
                }
                if ($form["retard"]->getData()){
                    $nb = $nb."<li>le retour est en retard</li>";
                }
                $nb = $nb."</ul>";
            }

            $nomChefSite =$this->getUser()->getNom();
            $prenomChefSite = $this->getUser()->getPrenom();
            $signature = "<hr> $nomChefSite $prenomChefSite<br> Chef Site Easy Ride";

            $iduser = $location->getIdUser();
            $user = $em->getRepository('LocationBundle:User')->find($iduser);
            $nom = $user->getNom();
            $message = \Swift_Message::newInstance()
                ->setSubject('Retour de vélo confirmé')
                ->setFrom(array('easyride@gmail.com' => 'Easy Ride'))
                ->setTo($user->getEmail())
                ->setBody("<h1>Bonjour $nom,</h1><br><p>Le velo a été retournée avec succes</p>".$nb.$signature, 'text/html');
            $this->get('mailer')->send($message);

            return $this->redirectToRoute("location_retour_affichage");
//            return $this->render("@Location/Retour/affichageRetour.html.twig",array('location'=>$location, 'formObject'=>$form, 'etat'=>$retour));
        }
        return $this->render("@Location/Retour/affichageRetour.html.twig",
            array('location'=>$location, 'formObject'=>$form, 'listeRetour'=>$listeRetour));
    }

}
