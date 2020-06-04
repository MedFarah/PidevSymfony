<?php

namespace LivraisonBundle\Controller;

use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use LivraisonBundle\Entity\Livraison;
use LivraisonBundle\Entity\Notification;
use LivraisonBundle\Entity\User;
use LivraisonBundle\Entity\reclamation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Serializer;
use LivraisonBundle\LivraisonBundle;
use DateTime;
use LivraisonBundle\Entity\evenements;
use LivraisonBundle\Entity\participants;


class ApiController extends Controller
{

    public function allAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $tache = $em->getRepository('LivraisonBundle:Livraison')->findBy(array('agent'=>$id));
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = array(new DateTimeNormalizer(), new ObjectNormalizer());
        $serializer = new Serializer($normalizer, $encoders);
        $response = new Response($serializer->serialize($tache, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

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
        // return array('name' => $bool);
    }

    public function viewAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $tache = $em->getRepository('LivraisonBundle:Livraison')->find($id);
        $t = new Livraison();
        $t->setId($tache->getId());
        $t->setTitre($tache->getTitre());
        $t->setEtat($tache->getEtat());
        $t->setAdresse($tache->getAdresse());
        $t->setPrix($tache->getPrix());
        $t->setTel($tache->getTel());
        $t->setPrix($tache->getPrix());
        $client = $em->getRepository('LivraisonBundle:User')->find($tache->getAgent()->getId());
        $agent = $em->getRepository('LivraisonBundle:User')->find($tache->getAgent()->getId());
        $t->setAgent($agent);
        $t->setClient($client);
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = array(new DateTimeNormalizer(), new ObjectNormalizer());
        $serializer = new Serializer($normalizer, $encoders);
        $response = new Response($serializer->serialize($t, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function ReclamationviewAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $tache = $em->getRepository('LivraisonBundle:reclamation')->find($id);
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = array(new DateTimeNormalizer(), new ObjectNormalizer());
        $serializer = new Serializer($normalizer, $encoders);
        $response = new Response($serializer->serialize($tache, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $titre = $request->get('titre');
        $sujet = $request->get('sujet');
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $taches = $em->getRepository('LivraisonBundle:Reclamation')->find($id);
        $taches->setTitre($titre);
        $taches->setSujet($sujet);
        $em->persist($taches);
        $em->flush();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = array(new DateTimeNormalizer(), new ObjectNormalizer());
        $serializer = new Serializer($normalizer, $encoders);
        $response = new Response($serializer->serialize($taches, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function validerAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $taches = $em->getRepository('LivraisonBundle:Livraison')->find($id);
        $taches->setEtat("Livrée");
        $taches->setDateLivraisonn(new \DateTime());
        $em->persist($taches);
        $em->flush();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = array(new DateTimeNormalizer(), new ObjectNormalizer());
        $serializer = new Serializer($normalizer, $encoders);
        $response = new Response($serializer->serialize($taches, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function deleteAction(Livraison $livraison, Request $request)
    {
        $id = $livraison->getId();
        $em = $this->getDoctrine()->getManager();
        $tache = $em->getRepository('LivraisonBundle:Livraison')->find($id);
        $em->remove($tache);
        $em->flush();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
    $normalizer = array(new DateTimeNormalizer(), new ObjectNormalizer());
    $serializer = new Serializer($normalizer, $encoders);
    $response = new Response($serializer->serialize($tache, 'json'));
    $response->headers->set('Content-Type', 'application/json');
    return $response;
    }

    public function deleteRecAction(reclamation $livraison, Request $request)
    {
        $id = $livraison->getId();
        $em = $this->getDoctrine()->getManager();
        $tache = $em->getRepository('LivraisonBundle:reclamation')->find($id);
        $em->remove($tache);
        $em->flush();

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = array(new DateTimeNormalizer(), new ObjectNormalizer());
        $serializer = new Serializer($normalizer, $encoders);
        $response = new Response($serializer->serialize($tache, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $titre = $request->get('titre');
        $sujet = $request->get('sujet');
        $ag = $request->get('agent');
        $livr = $request->get('livraisonId');
        $livraison = $em->getRepository('LivraisonBundle:Livraison')->find($livr);
        $agent = $em->getRepository('LivraisonBundle:User')->find($ag);
        $reclamation = new reclamation();
        $reclamation->setTitre($titre);
        $reclamation->setSujet($sujet);
        $reclamation->setLivraison($livraison);
        $reclamation->setAgent($agent);
        $em->persist($reclamation);
        $em->flush();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = array(new DateTimeNormalizer(), new ObjectNormalizer());
        $serializer = new Serializer($normalizer, $encoders);
        $response = new Response($serializer->serialize($reclamation, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function listAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $rec = $em->getRepository('LivraisonBundle:reclamation')->findBy(array('agent'=>$id));
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = array(new DateTimeNormalizer(), new ObjectNormalizer());
        $serializer = new Serializer($normalizer, $encoders);
        $response = new Response($serializer->serialize($rec, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    public function StatsAction(Request $request)
    {
        $id = $request->get('id');
        $etat = "en cours";
        $etats = "Livrée";
        $em = $this->getDoctrine()->getManager();
        // 2. Setup repository of some entity
        $repoLivraison = $em->getRepository(Livraison::class);
        $repoUser = $em->getRepository(User::class);
        // 3. Query how many rows are there in the Articles table
        $totalLivraison = $repoLivraison->createQueryBuilder('a')
            // Filter by some parameter if you want
            // ->where('a.published = 1')
            ->select('count(a.id)')
            ->andWhere('a.agent = :agent and a.etat = :etats ')
            ->setParameters(array('agent'=>$id,'etats'=>$etats))
            ->getQuery()
            ->getSingleScalarResult();

        $queryCours = $repoLivraison->createQueryBuilder('c')
            // Filter by some parameter if you want
            ->andWhere('c.etat = :etats and c.agent = :agent')
            ->setParameters(array('etats'=> $etat,'agent'=>$id))
            ->select('count(c.id)')
            ->getQuery()
            ->getSingleScalarResult();
        $percentageCours = 0;
        $totalSize = $totalLivraison;
        if ($totalSize > 0) {
            $completedSizeCours = $queryCours;
            $percentageCours =  $completedSizeCours / $totalSize * 100;
        }
        $queryLiv = $repoLivraison->createQueryBuilder('d')
            // Filter by some parameter if you want
            ->andWhere('d.etat = :etats')
            ->setParameter('etats', $etats)
            ->select('count(d.id)')
            ->getQuery()
            ->getSingleScalarResult();
        $percentageliv = 0;
        $totalSize = $totalLivraison;
        if ($totalSize > 0) {
            $completedSize = $queryLiv;
            $percentageliv =  $completedSize / $totalSize * 100;
        }
         
            $data = array(
               
          array('Livr'=>  $percentageliv,'cours'=> $percentageCours),
              
            );
          
            $encoders = array(new XmlEncoder(), new JsonEncoder());
            $normalizer = array(new DateTimeNormalizer(), new ObjectNormalizer());
            $serializer = new Serializer($normalizer, $encoders);
            $response = new Response($serializer->serialize($data, 'json'));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
    }

    //Achref
    
/**
     * @Route("/hi")
     */
    public function indexAction()
    {
        return $this->render('LivraisonBundle:Default:index.html.twig');
    }
    /**
     *
     * @Route("/api/affiche")
     * @Method("GET")
     */
    public function afficheAction()
    {
        $em = $this->getDoctrine()->getManager();

        $evenements = $em->getRepository('LivraisonBundle:evenements')->findAll();

        $res=new Serializer([new ObjectNormalizer()]);
        $formatted =$res->normalize($evenements);
        return new JsonResponse($formatted);
    }

    /**
     * Creates a new evenement entity.
     *
     * @Route("/api/new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {

            $em = $this->getDoctrine()->getManager();
        $evenement = new evenements();
        dump($request);
        $datedeb=new DateTime();
        $datefin=new DateTime();
        $dateeve=new DateTime();

        $format = 'm/d/y';
        $date = DateTime::createFromFormat($format, ($request->get('dateve')));
        $evenement->setNomEvenements($request->get('nomEvenements'));
        $evenement->setNombre($request->get('nombre'));

        $evenement->setLieuxeve($request->get('lieuxeve'));
        $evenement->setDescreptioneve($request->get('descreptioneve'));
        $evenement->setDateeve($date);
        $datedeb->modify($request->get('datedebut'));
        $evenement->setDatedebut($datedeb);
        $datefin->modify($request->get('datefin'));
        $evenement->setDatefin($datefin);
        $evenement->setImage($request->get('image'));


        $em->persist($evenement);
            $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($evenement);
        return new JsonResponse($formatted);


    }

    /**
     * Finds and displays a evenement entity.
     *
     * @Route("/show/{id}")
     * @Method("GET")
     */
    public function showAction(Evenements $evenement)
    {

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($evenement);
        return new JsonResponse($formatted);

    }

    /**
     * Displays a form to edit an existing evenement entity.
     *
     * @Route("/edit/")
     * @Method({"GET", "POST"})
     */
    public function editsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

//        $now = new\DateTime('now');
        $evenement = $this->getDoctrine()
            ->getRepository('LivraisonBundle:evenements')
            ->find($request->get('id'));

        if ($request->isMethod("post")) {
            $evenement->setNomEvenements($request->get('nomEvenements'));
            $evenement->setNombre($request->get('nombre'));
            $format = 'Y-m-d';
            $date = DateTime::createFromFormat($format, $request->get('dateeve'));
            $evenement->setDateeve($date);
            $evenement->setLieuxeve($request->get('lieuxeve'));
            $evenement->setDescreptioneve($request->get('descreptioneve'));

            if ($request->files->get('image')) {
                /** @var UploadedFile $file */
                $file = $request->files->get('image');
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move(
                    $this->getParameter('image_directory'),
                    $fileName
                );
                $evenement->setImage($fileName);

            }


            $evenement->setDateDebut(new\DateTime($request->get('dateDebut')));
            $evenement->setDateFin(new\DateTime($request->get('dateFin')));
            $em->flush();
           }
        return new JsonResponse("Updated");
    }

    /**
     * Deletes a evenement entity.
     *
     * @Route("/delete/{id}")
     * @Method("DELETE")
     */
    public function deletesAction(Request $request, Evenements $evenement)
    {
        $sn = $this->getDoctrine()->getManager();
        $event = $sn->getRepository('LivraisonBundle:evenements')->find($request->get('id'));
        $sn->remove($event);
        $sn->flush();
        return new JsonResponse('ok');
    }
    /**
     * Creates a form to delete a evenement entity.
     *
     * @Route("/Addpart/{id}/{idUser}")
     * @Method({"GET", "POST"})
     */
    public function AddEventAction($id,$idUser)
    {
        $part=new participants();
        $em=$this->getDoctrine()->getManager();
        $evenement=$em->getRepository(evenements::class)->findOneBy(['id' => $id]);
        $user=$em->getRepository(User::class)->findOneBy(['id' => $idUser]);// recuperation du evenements
        $part->setIdEvenements($evenement);
        $part->setIduser($user->getId());

        //die($user);
        $em->persist($part);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($part);
        return new JsonResponse("ok");
    }
    public function deleteEventMobileAction(Request $request){
        $id = $request->query->get('id');
        $evenement = $this->getDoctrine()->getRepository(evenements::class)->find($id);
        if($evenement){
            $em = $this->getDoctrine()->getManager();
            $em->remove($evenement);
            $em->flush();
            $response = array("body"=> "Event deleted");
        }else{
            $response = array("body"=>"Error");
        }
        return new JsonResponse($response);
    }


    public function  EditEventMobileAction(Request $request){


        $id = $request->query->get('id');
        $em=$this->getDoctrine()->getManager();

        $evenement=$em->getRepository(evenements::class)->find($id);


        $datedeb=new DateTime();
        $datefin=new DateTime();
        $dateeve=new DateTime();

//        $format = 'm/d/y';
//        $date = DateTime::createFromFormat($format, ($request->get('dateve')));


        $nom_evenements = $request->query->get('nom_evenements');
        $nombre = $request->query->get('nombre');
        $lieuxeve = $request->query->get('lieuxeve');
        $descreptioneve = $request->query->get('descreptioneve');
        $evenement->setNomEvenements($nom_evenements);
        $evenement->setNombre($nombre);
        $evenement->setLieuxeve($lieuxeve);
        $evenement->setDescreptioneve($descreptioneve);
        //http://127.0.0.1:8000/EditEventMobile/?descreptioneve=azaaza&id=3&lieuxeve=bejaaaaa&nom_evenements=aaaaaaa&nombre=2222
        //27/01/2019
////        $evenement->setDateeve($date);
//        $datedeb->modify($request->get('datedebut'));
//        $evenement->setDatedebut($datedeb);
//        $datefin->modify($request->get('datefin'));
//        $evenement->setDatefin($datefin);


        try {

            $em->flush();
        }
        catch(\Exception $ex)
        {
            $data = [
                'title' => 'validation error',
                'message' => 'Some thing went Wrong',
                'errors' => $ex->getMessage()
            ];
            $response = new JsonResponse($data,400);
            return $response;
        }
        return $this->json(array('title'=>'successful','message'=> "Event Edited successfully"),200);
    }



}
