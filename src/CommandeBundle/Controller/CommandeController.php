<?php

namespace CommandeBundle\Controller;

use CommandeBundle\Entity\commande;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CommandeBundle\Form\commandeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use \Datetime;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CommandeController extends Controller
{
    public function afficheCommandeAction(Request $request){


        $em= $this->getDoctrine()->getManager();
        // $c =$em->getRepository('CommandeBundle:commande')->findAll();
        $dql   = "SELECT c FROM CommandeBundle:commande c";
        $query = $em->createQuery($dql);

        if ($request->isMethod("POST"))
        {
            $reference = $request->get('refCmd');
            if ($reference =="")
            {$query =$em->getRepository('CommandeBundle:commande')->findAll();}
            else
            {$query =  $em->getRepository("CommandeBundle:commande")->findBy(array('refCmd' => $reference));}

        }


        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator =$this->get('knp_paginator');
        $result=$paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            $request->query->getInt('limit', 5)

        );

        return $this->render('@Commande/Commande/AfficheCommande.html.twig', array(
            'commande' => $query,
            'commande' => $result
        ));
    }

    public function pdfAction()
    {
        $em= $this->getDoctrine()->getManager();
        $commande =$em->getRepository('CommandeBundle:commande')->findAll();
        $snappy=$this->get('knp_snappy.pdf');

        $html = $this->renderView('@Commande/Commande/listec.html.twig', array(
            'commande' => $commande,
            'title'  => 'Liste Commande'
        ));

        return new PdfResponse(
            $snappy->getOutputFromHtml($html),
            'listeComande.pdf'

        );


    }

    public function ajoutCommandeAction(Request $request)
    {
        $commande = new commande();
        $form = $this->createForm('CommandeBundle\Form\commandeType', $commande);
        $form->handleRequest($request);
        $dt = new DateTime();
        $dt->format('Y-m-d H:i:s');
        if ($form->isSubmitted()&& $form->isValid() ) {
            $commande->setDateCmd($dt);
            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush();
            $this->addFlash('success', 'success');
            return $this->redirectToRoute('commande_afficheCommande');

        }

        return $this->render('@Commande/Commande/AjoutCommande.html.twig', array(

            'commande' => $commande,

            'form' => $form->createView()
        ));
    }

    public function deleteCommandeAction($id)
    {

        $em= $this->getDoctrine()->getManager();
        $commande =$em->getRepository('CommandeBundle:commande')->find($id);
        $em->remove($commande);
        $em->flush();
        $this->addFlash('delete', 'Created Successfully !');

        return $this->redirectToRoute('commande_afficheCommande');


    }






    public function editCommandeAction(Request $request,$id)
    {

        $em=$this->getDoctrine()->getManager();
        $commande= $em->getRepository('CommandeBundle:commande')->find($id);
        $form=$this->createForm('CommandeBundle\Form\commandeType',$commande);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush();
            $this->addFlash('info', 'Created Successfully !');
            return $this->redirectToRoute('commande_afficheCommande');
        }


        return $this->render('@Commande/Commande/EditCommande.html.twig', array(
            'commande' => $commande,
            'form' => $form->createView()

        ));

    }



    public function rechercheByReferenceAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $commande =  $em->getRepository(commande::class)->findAll();

        if ($request->isMethod("POST"))
        {
            $reference = $request->get('refCmd');
            $commande =  $em->getRepository("CommandeBundle:commande")->findBy(array('refCmd' => $reference),array('prixCmd' => 'ASC'));

        }

        return $this->render('@Commande/Commande/Recherche.html.twig', array(
            'commande' => $commande


        ));
    }

    public function deleteByClientAction($id)
    {

        $em= $this->getDoctrine()->getManager();
        $commande =$em->getRepository('CommandeBundle:commande')->find($id);


        $s=$commande->getDateCmd();

        echo $s->format('d-m-Y');
        echo $s->format('d');
        echo date("Y-m-d H:i:s");
        echo date("d");

        $dt = new DateTime();
        echo $dt->format('Y-m-d H:i:s');


        echo $dt->format('d')-$s->format('d');

        if($dt->format('d')-$s->format('d')<4)
        {

            $em->remove($commande);
            $em->flush();
            $this->addFlash('delete', 'Created Successfully !');
        }
        $this->addFlash('contre', 'Created Successfully !');
        return $this->redirectToRoute('commande_affichebyclient');


    }

    public function afficheByClientAction(Request $request){


        $em= $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $commande =$em->getRepository('CommandeBundle:commande')->findBy(['idUser' => $user->getId()]);



        if ($request->isMethod("POST"))
        {
            $reference = $request->get('refCmd');
            if ($reference =="")
            {$commande =$em->getRepository('CommandeBundle:commande')->findAll();}
            else
            {$commande =  $em->getRepository("CommandeBundle:commande")->findBy(array('refCmd' => $reference));}

        }




        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator =$this->get('knp_paginator');
        $result=$paginator->paginate(
            $commande, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            $request->query->getInt('limit', 5)

        );


        return $this->render('@Commande/Commande/AfficheCommande.html.twig',  array(
            'commande' => $commande,
            'commande' => $result
        ));
    }


    public function newAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $dt = new DateTime();
        echo $dt->format('Y-m-d H:i:s');
        $em = $this->getDoctrine()->getManager();
        $task = new Commande();
        $task->setRefCmd($request->get('refCmd'));
        $task->setDateCmd($dt);
        $task->setEtatCmd($request->get('etatCmd'));
        $task->setPrixCmd($request->get('prixCmd'));
        $id = $this->getDoctrine()
            ->getRepository(User::class)
            ->find('3');
        $task->setIdUser($id);
        $em->persist($task);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($task);
        return new JsonResponse($formatted);
    }

    public function allAction()
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('CommandeBundle:commande')
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function findAction($id)
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('CommandeBundle:commande')
            ->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }


    public function editAction(Request $request , commande $commande)
    {
        // $user = $this->get('security.token_storage')->getToken()->getUser();
        $dt = new DateTime();
        echo $dt->format('Y-m-d H:i:s');



        $commande = $this->getDoctrine()->getManager()->getRepository(commande::class)->find($request->get('id'));
        //$commande->setRefCmd($request->get('refCmd'));

        //  $commande->setEtatCmd($request->get('etatCmd'));
        // $commande->setPrixCmd($request->get('prixCmd'));

        // $commande->setRefCmd($request->get('refCmd'));
        // $commande->setDateCmd($dt);
        $commande->setEtatCmd($request->get('etatCmd'));
        $commande->setPrixCmd($request->get('prixCmd'));
        // $id = $this->getDoctrine()
        //   ->getRepository(User::class)
        //      ->find('5');
        //  $commande->setIdUser($id);

        //   $em = $this->getDoctrine()->getManager();
        //  $em->persist($commande);
        //   $em->flush();

        $this->getDoctrine()->getManager()->flush();


        $serial = new Serializer([new ObjectNormalizer()]);
        $formatted = $serial->normalize($commande);
        return new JsonResponse($formatted);
    }

    public function deleteAction(Request $request, commande $commande)
    {

        $commande = $this->getDoctrine()->getManager()->getRepository(commande::class)->find($request->get('id'));
        $em = $this->getDoctrine()->getManager();




        $em->remove($commande);
        $em->flush();


        $serial = new Serializer([new ObjectNormalizer()]);
        $formatted = $serial->normalize($commande);
        return new JsonResponse($formatted);

    }






}

