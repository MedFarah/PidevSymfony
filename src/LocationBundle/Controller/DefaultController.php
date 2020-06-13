<?php

namespace LocationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $user = $this->getUser();
        $detaillocation = $testLocation = $red = $green = $turquoise = $blue = null;
        if ($user == null)
            $user = 'HEDHA VISITEUR';
        else{
            if (in_array('ROLE_ADMIN',$user->getRoles())){
                $query = $this->getDoctrine()->getManager()
                    ->createQuery(
                        'SELECT u FROM LocationBundle:DetailLocation u');
                $detaillocation = $query->getResult();

                $blue = $this->getDoctrine()->getManager()
                    ->createQuery(
                        'SELECT count(s) FROM LocationBundle:Site s')->getResult();
                $turquoise = $this->getDoctrine()->getManager()
                    ->createQuery(
                        'SELECT count(u) FROM LocationBundle:DetailLocation u')->getResult();
                $green = $this->getDoctrine()->getManager()
                    ->createQuery(
                        'SELECT count(u) FROM LocationBundle:DetailLocation u where u.status = :status')
                    ->setParameter('status', "terminé")
                    ->getResult();
                $red = $this->getDoctrine()->getManager()
                    ->createQuery(
                        'SELECT count(u) FROM LocationBundle:DetailLocation u where u.status = :status')
                    ->setParameter('status', "en cours")
                    ->getResult();
            }
            elseif (in_array('ROLE_CHEF_SITE',$user->getRoles())){
                $query = $this->getDoctrine()->getManager()
                    ->createQuery(
                        'SELECT dl FROM LocationBundle:DetailLocation dl WHERE dl.id_site = :numsite'
                    )->setParameter('numsite', $user->getnumerosite());
                $detaillocation = $query->getResult();

                $turquoise = $this->getDoctrine()->getManager()
                    ->createQuery(
                        'SELECT count(dl) FROM LocationBundle:DetailLocation dl WHERE dl.id_site = :numsite')
                    ->setParameter('numsite', $user->getnumerosite())
                    ->getResult();

                $green = $this->getDoctrine()->getManager()
                    ->createQuery(
                        'SELECT count(dl) FROM LocationBundle:DetailLocation dl where dl.status = :status and dl.id_site = :numsite')
                    ->setParameter('status', "terminé")
                    ->setParameter('numsite', $user->getnumerosite())
                    ->getResult();
                $red = $this->getDoctrine()->getManager()
                    ->createQuery(
                        'SELECT count(dl) FROM LocationBundle:DetailLocation dl where dl.status = :status and dl.id_site = :numsite')
                    ->setParameter('status', "en cours")
                    ->setParameter('numsite', $user->getnumerosite())
                    ->getResult();
            }
            else{
                $query = $this->getDoctrine()->getManager()
                    ->createQuery(
                        'SELECT dl FROM LocationBundle:DetailLocation dl WHERE dl.id_user = :iduser order by dl.status, dl.dateDebut Desc'
                    )->setParameter('iduser', $user->getid());
                $detaillocation = $query->getResult();

                $testLocation = $this->getDoctrine()->getManager()
                    ->createQuery(
                        'Select dl FROM LocationBundle:DetailLocation dl where dl.id_user = :iduser and dl.status = :status'
                    )->setParameter('status', 'en cours')->setParameter('iduser', $user->getid())
                    ->getResult();
                $testLocation = count($testLocation);

                $turquoise = $this->getDoctrine()->getManager()
                    ->createQuery(
                        'SELECT count(dl) FROM LocationBundle:DetailLocation dl WHERE dl.id_user = :iduser')
                    ->setParameter('iduser', $user->getid())
                    ->getResult();
            }
        }
        return $this->render('@Location/Default/index.html.twig',
            array('detaillocation'=>$detaillocation,
                'testLocation'=>$testLocation,
                'user'=>$user,
                'blue'=>$blue,
                'turquoise'=>$turquoise,
                'green'=>$green,
                'red'=>$red));
    }
}
