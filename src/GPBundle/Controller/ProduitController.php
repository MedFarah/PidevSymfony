<?php

namespace GPBundle\Controller;

use GPBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GPBundle\Data\SearchData;
use GPBundle\Form\SearchForm;
use GPBundle\Repository\ProduitRepository;


class ProduitController extends Controller
{

    public function indexAction( Request $request)
    {
        //Je vais t'écrire un mail pour t'expliquer
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('GPBundle:Produit')->findAll();
   /**
     *@var $pagiator \Knp\Component\Pager\Paginator
     */
    $paginator = $this->get('knp_paginator');
    $pagination = $paginator->paginate(
       $produits, /* query NOT result */
       $request->query->getInt('page', 1), /*page number*/
       4 /*limit per page*/
   );
       return $this->render('@GP/produit/index.html.twig',
       ['produits' => $pagination]
       );
    }

    public function newAction(Request $request)
    {
        $produit = new Produit();
        $form = $this->createForm('GPBundle\Form\ProduitType', $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            //die($produit->getNom());
            $prix = $produit->getPrix();
            $produit->setPrixt( ((float)$prix*1.35) );
            $p = $produit->getPrixt();
            $remise = $produit->getRemise();
            $produit->setPrixr( ((float)$p)-(((float)$p)*($remise/100)));
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('produit_index', array('id' => $produit->getId()));
        }

        return $this->render('@GP/produit/new.html.twig', array(
            'produit' => $produit,
            'form' => $form->createView(),
        ));
    }
    public function showAction(Produit $produit, $id)
    {

        /*
         *
         * for produit in produits // non suppose jointure produit w user
         * produit.user.email
         */
        return $this->render('@GP/produit/show.html.twig', array(
            'produit' => $produit,

        ));
    }

    public function editAction()
    {
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('GPBundle:Produit')->findAll();

        return $this->render('@GP/produit/edit.html.twig', array(
            'produits' => $produits,
        ));


    }
    public function modifierAction(Request $request,Produit $produit, $id)
    {
       
        $editForm = $this->createForm('GPBundle\Form\ProduitType', $produit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $prix = $produit->getPrix();
            $produit->setPrixt( ((float)$prix*1.35) );
            $p = $produit->getPrixt();
            $remise = $produit->getRemise();
            $produit->setPrixr( ((float)$p)-(((float)$p)*($remise/100)));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produit_index');
        }

        return $this->render('@GP/produit/new.html.twig', array(
            'produit' => $produit,
            'form' => $editForm->createView(),

        ));
    }


    public function deleteAction( Request $request, $id)
    {
        //$produit = new Produit();
        
      //  $form = $this->createForm('GPBundle\Form\ProduitType', $produit);
       // $form->handleRequest($request);

       /* if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($produit);
            $em->flush();
        }*/

        $em = $this->getDoctrine()->getManager();

        $produit = $em->getRepository('GPBundle:Produit')->findOneBy(['id' => $id]);
        if($produit){
            $em->remove($produit);
            $em->flush();
        }
        return $this->redirectToRoute('produit_index');

       /* return $this->render('@GP/produit/delete.html.twig', array(
            'produit' => $produit,
            'form' => $form->createView(),

        ));*/
    }

  



    public function clientAction( Request $request )
    {
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('GPBundle:Produit')->findAll();
      
        
    /**
     *@var $pagiator \Knp\Component\Pager\Paginator
     */
     $paginator = $this->get('knp_paginator');
     $pagination = $paginator->paginate(
        $produits, /* query NOT result */
        $request->query->getInt('page', 1), /*page number*/
        9 /*limit per page*/
    );
        return $this->render('@GP/produit/client.html.twig',
        ['produits' => $pagination]
        );
    }


    public function rechercheAction( Request $request  )
    {
       
         
        //Je vais t'écrire un mail pour t'expliquer
        $em = $this->getDoctrine()->getManager();
        $motcle=$request->get('motcle');

        $produits = $em->getRepository('GPBundle:Produit')->findProductBynom($motcle);
      
        
   /**
     *@var $pagiator \Knp\Component\Pager\Paginator
     */
    $paginator = $this->get('knp_paginator');
    $pagination = $paginator->paginate(
       $produits, /* query NOT result */
       $request->query->getInt('page', 1), /*page number*/
       4 /*limit per page*/
   );
       return $this->render('@GP/produit/client.html.twig',
       ['produits' => $pagination ]
       );
    }
 
    public function triAction( Request $request  )
    {
       
         
        //Je vais t'écrire un mail pour t'expliquer
        $em = $this->getDoctrine()->getManager();
        $search=$request->get('search');

        $produits = $em->getRepository('GPBundle:Produit')->findSearch($search);
      
        
   /**
     *@var $pagiator \Knp\Component\Pager\Paginator
     */
    $paginator = $this->get('knp_paginator');
    $pagination = $paginator->paginate(
       $produits, /* query NOT result */
       $request->query->getInt('page', 1), /*page number*/
       15/*limit per page*/
   );
       return $this->render('@GP/produit/client.html.twig',
       ['produits' => $pagination ]
       );
    }


}
