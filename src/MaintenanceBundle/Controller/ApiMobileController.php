<?php

namespace MaintenanceBundle\Controller;

use DateTime;
use MaintenanceBundle\Entity\maintenance;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
                'nom' => $user->getNom(),
                'prenom' => $user->getPrenom(),
                'email' => $user->getEmail(),
                'role' => $user->getRoles()
            );
            $response = new JsonResponse($data, 200);
            return $response;
        } else {
            return $response;
        }
    }
    public function getrdvAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $etat = ['en attente','confirmé'];
        $rdv = $em->createQuery(
            'SELECT m FROM MaintenanceBundle:maintenance m WHERE m.etat in (:etat) and m.id_user= :id'
        )->setParameter('etat', $etat)
            ->setParameter('id', $id)
            ->getResult();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = array(new DateTimeNormalizer(), new ObjectNormalizer());
        $serializer = new Serializer($normalizer, $encoders);
        $response = new Response($serializer->serialize($rdv, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function addAction($id, $titre, $description, $date)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('MaintenanceBundle:User')->find($id);

        $maintenance = new maintenance();
        $maintenance->setTitre($titre);
        $maintenance->setDescription($description);

        $seconds = $date / 1000;
        $date = date("Y-m-d H:i:s", $seconds);
        $timestampp = new DateTime($date);

        $maintenance->setDateRDV($timestampp);
        $maintenance->setEtat("en attente");
        $maintenance->setIdUser($user);

        $em->persist($maintenance);
        $em->flush();
        return new JsonResponse('ok');
    }

    public function deletesAction(Request $request)
    {
        $sn = $this->getDoctrine()->getManager();
        $event = $sn->getRepository('MaintenanceBundle:maintenance')->find($request->get('id'));
        $sn->remove($event);
        $sn->flush();
        return new JsonResponse('ok');
    }

    public function getrdvencoursAction($id){
        $em = $this->getDoctrine()->getManager();
        $etat = 'en cours';
        $rdv = $em->createQuery(
            'SELECT m FROM MaintenanceBundle:maintenance m WHERE m.etat = :etat and m.id_user= :id'
        )->setParameter('etat', $etat)
            ->setParameter('id', $id)
            ->getResult();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = array(new DateTimeNormalizer(), new ObjectNormalizer());
        $serializer = new Serializer($normalizer, $encoders);
        $response = new Response($serializer->serialize($rdv, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $rdv = $em->getRepository('MaintenanceBundle:maintenance')->find($id);
        $em->remove($rdv);
        $em->flush();
        return new JsonResponse('ok');
    }

    public function acceptAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $rdv = $em->getRepository('MaintenanceBundle:maintenance')->find($id);
        $rdv->setEtat('confirmé');
        $em->flush();
        return new JsonResponse('ok');
    }


}
