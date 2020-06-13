<?php

namespace LocationBundle\Controller;

use LocationBundle\Entity\Type;
use LocationBundle\Form\TypeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class TypeController extends Controller
{
    /**
     * @Security("has_role('ROLE_CHEF_SITE')")
     */
    public function afficherTypeAction(){
        $em = $this->getDoctrine()->getManager();
        $type = $em->getRepository("LocationBundle:Type")->findAll();
        return $this->render("@Location/Type/affichageType.html.twig",array('type'=>$type));
    }

    /**
     * @Security("has_role('ROLE_CHEF_SITE')")
     */
    public function suppTypeAction($id){
        $em = $this->getDoctrine()->getManager();
        $type = $em->getRepository('LocationBundle:Type')->find($id);

        $image = $type->getImage();
        $path = $this->getParameter('image_directory').$image;
        $fs = new Filesystem();
        $fs->remove(array($path));

        $em->remove($type);
        $em->flush();

        return $this->redirectToRoute('location_type_affichage');
    }

    /**
     * @Security("has_role('ROLE_CHEF_SITE')")
     */
    public function ajoutTypeAction(Request $request){
        $type = new Type();
        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            /**
             * @var UploadedFile $file
             */
            $file = $type->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $file->move(
                $this->getParameter('image_directory'),$fileName
            );

            $type->setImage($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($type);
            $em->flush();
            return $this->redirectToRoute("location_type_affichage");
        }
        return $this->render("@Location/Type/ajoutType.html.twig",array('form'=>$form->createView()));
    }

}
