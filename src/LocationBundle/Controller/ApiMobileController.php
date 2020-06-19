<?php

namespace LocationBundle\Controller;

use LocationBundle\Entity\DetailLocation;
use LocationBundle\Entity\Retours;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use DateTime;

class ApiMobileController extends Controller
{
    public function loginMobileAction($username, $password)
    {
        $user_manager = $this->get('fos_user.user_manager');
        $factory = $this->get('security.encoder_factory');
        $data = [
            'type' => 'validation error',
            'title' => 'There was a validation error',
            'errors' => 'username or password invalide'
        ];
        $response = new JsonResponse($data, 400);
        $user = $user_manager->findUserByUsername($username);
        if (!$user)
            return $response;
        $encoder = $factory->getEncoder($user);

        $bool = ($encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())) ? "true" : "false";
        if ($bool == "true") {
            $role = $user->getRoles();

            $data = array(
                'type' => 'Login succeed',
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'role' => $user->getRoles()
            );
            $response = new JsonResponse($data, 200);
            return $response;
        } else {
            return $response;
        }
    }

    public function getTypeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tache = $em->getRepository('LocationBundle:Type')->findAll();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = array(new DateTimeNormalizer(), new ObjectNormalizer());
        $serializer = new Serializer($normalizer, $encoders);
        $response = new Response($serializer->serialize($tache, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getSitesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $site = $em->getRepository('LocationBundle:Site')->findAll();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = array(new DateTimeNormalizer(), new ObjectNormalizer());
        $serializer = new Serializer($normalizer, $encoders);
        $response = new Response($serializer->serialize($site, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getlocationsAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $locations = $em->createQuery(
            'SELECT dl FROM LocationBundle:DetailLocation dl where dl.id_user = :iduser')
            ->setParameter('iduser', $id)->getResult();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = array(new DateTimeNormalizer(), new ObjectNormalizer());
        $serializer = new Serializer($normalizer, $encoders);
        $response = new Response($serializer->serialize($locations, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getlocationsparsiteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $chefsite = $em->createQuery(
            'SELECT u FROM LocationBundle:User u where u.id = :iduser')
            ->setParameter('iduser', $id)->getResult();

//        $site = $em->createQuery(
//            'SELECT u FROM LocationBundle:Site u where u.id = :iduser')
//            ->setParameter('iduser', $id)->getResult();
        $locations = $em->createQuery(
            'SELECT dl FROM LocationBundle:DetailLocation dl where dl.id_site = :numero_site and dl.status = :status')
            ->setParameter('numero_site', $chefsite[0]->getNumeroSite())
            ->setParameter('status', "en cours")
            ->getResult();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = array(new DateTimeNormalizer(), new ObjectNormalizer());
        $serializer = new Serializer($normalizer, $encoders);
        $response = new Response($serializer->serialize($locations, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function deletelocationAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $location = $em->getRepository("LocationBundle:DetailLocation")->find($id);
        $em->remove($location);
        $em->flush();
        return new JsonResponse("ok");
    }

    public function validerlocationAction($id,$etat,$retard)
    {
        $em = $this->getDoctrine()->getManager();
        $location = $em->getRepository("LocationBundle:DetailLocation")->find($id);
        $location->setStatus("terminé");

        $retour = new Retours();
        $retour->setIdLocation($location);
        $etatretour = 0;
        $retardretour = 0;
        if ($etat == "oui")
            $etatretour = 1;
        if ($retard == "oui")
            $retardretour = 1;
        $retour->setRetard($etatretour);
        $retour->setEtat($retardretour);
        $em->persist($retour);

        $em->flush();

        //$site = $em->getRepository("LocationBundle:Site")->find($location->getIdSite());
        $chefsite = $em->createQuery(
            'SELECT u FROM LocationBundle:User u where u.numero_site = :idsite')
            ->setParameter('idsite', $location->getIdSite())->getResult();
        //$chefsite = $em->getRepository("LocationBundle:User")->find($location->getIdSite());
        $nomchefsite = $chefsite[0]->getNom();
        $signature = "<hr> $nomchefsite <br> Chef Site Easy Ride";

        $user = $em->getRepository("LocationBundle:User")->find($location->getIdUser());
        $nom = $user->getNom();

        $message = \Swift_Message::newInstance()
            ->setSubject('Retour de vélo confirmé')
            ->setFrom(array('easyride@gmail.com' => 'Easy Ride'))
            ->setTo($user->getEmail())
            ->setBody("<h1>Bonjour $nom ,</h1><br><p>Le velo a été retournée avec succes</p>".$signature, 'text/html');
        $this->get('mailer')->send($message);


        return new JsonResponse("ok");
    }

    public function addlocationAction($id, $datedebut, $datefin, $typeid, $site)
    {
        $em = $this->getDoctrine()->getManager();
        $location = new DetailLocation();
        $user = $em->getRepository("LocationBundle:User")->find($id);
        $location->setIdUser($user);
        $location->setStatus("en cours");

        $seconds = $datedebut / 1000;
        $date = date("Y-m-d",$seconds);
        $date = new DateTime($date);
        $location->setDateDebut($date);

        $seconds = $datefin / 1000;
        $date = date("Y-m-d",$seconds);
        $date = new DateTime($date);
        $location->setDateFin($date);

        $type = $em->getRepository("LocationBundle:Type")->find($typeid);
        $location->setIdType($type);

        $type = $em->createQuery(
            'SELECT s FROM LocationBundle:Site s where s.emplacement = :site')
            ->setParameter('site', $site)->getResult();
        $location->setIdSite($type[0]);

        $em->persist($location);
        $em->flush();
        return new JsonResponse("ok");
    }

}
