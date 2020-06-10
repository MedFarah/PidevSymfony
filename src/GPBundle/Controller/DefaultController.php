<?php

namespace GPBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{


    public function modifierAction(){
        return $this->render('@GP/produit/modifier.html.twig')  ;
    }

    public function deleteAction(){
        return $this->render('@GP/produit/delete.html.twig')  ;
    }

    public function editAction(){
        return $this->render('@GP/produit/edit.html.twig')  ;
    }

    public function newAction(){
        return $this->render('@GP/produit/new.html.twig')  ;
    }

    public function baseAction(){
        return $this->render('@GP/Default/index.html.twig')  ;
    }

    public function indexAction()
    {
        return $this->render('@GP/Default/index.html.twig');
    }
}
