<?php

namespace CommandeBundle\Controller;

use CommandeBundle\Entity\Mail;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends Controller
{

    public function sendMailAction(Request $request)
    {
        $mail=new Mail();
        $form = $this->createForm('CommandeBundle\Form\MailType', $mail);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid() ) {
            $subject=$mail->getSubject();
            $mail=$mail->getMail();
            $objet=$request->get('form')['objet'];
            $username='chadisassi@gmail.com';
            $message =  \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($username)
                ->setTo($mail)
                ->setBody($objet);

            $this->get('mailer')->send($message);
            $this->addFlash('success', 'success');
            $this->getDoctrine()->getManager()->flush();

        }







        return $this->render('@Commande/Commande/send_mail.html.twig', array(

            'f' => $form->createView()
        ));
    }





}

