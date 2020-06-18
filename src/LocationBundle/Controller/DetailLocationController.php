<?php

namespace LocationBundle\Controller;


use LocationBundle\Entity\DetailLocation;
use LocationBundle\Form\DetailLocationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Overlay\Marker;
//
use Ivory\GoogleMap\Overlay\InfoWindow;
use Ivory\GoogleMap\Overlay\InfoWindowType;
use Ivory\GoogleMap\Overlay\Animation;
use Ivory\GoogleMap\Overlay\Symbol;
use Ivory\GoogleMap\Overlay\SymbolPath;
use Ivory\GoogleMap\Overlay\MarkerShape;
use Ivory\GoogleMap\Overlay\MarkerShapeType;
use Ivory\GoogleMap\Helper\Builder\MapHelperBuilder;
use Ivory\GoogleMap\Helper\Builder\ApiHelperBuilder;
use Ivory\GoogleMap\Control\FullscreenControl;
use Ivory\GoogleMap\Control\ControlPosition;

class DetailLocationController extends Controller
{
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function louerVeloAction (Request $request){

        $testLocation = $this->getDoctrine()->getManager()
            ->createQuery(
                'Select dl FROM LocationBundle:DetailLocation dl where dl.id_user = :iduser and dl.status = :status'
            )->setParameter('status', 'en cours')->setParameter('iduser', $this->getUser()->getid())
            ->getResult();
        if (count($testLocation)>0){
            return $this->redirectToRoute("location_homepage");
        }

        $location = new DetailLocation();
        $form = $this->createForm(DetailLocationType::class, $location);

//        $map = new map();
//        $positions = $blue = $this->getDoctrine()->getManager()
//            ->createQuery(
//                'SELECT s.emplacement, s.longitude, s.latitude FROM LocationBundle:Site s')->getResult();
//        foreach ($positions as $site){
//            $marker = new Marker(new Coordinate($site["latitude"], $site["longitude"]));
//            $marker->setOption('label', $site["emplacement"]);
//            $map->getOverlayManager()
//                ->addMarker($marker);
//        }

//        $map->setCenter(new Coordinate('34.8706344', '9.5554123'));
//        $map->setMapOption('zoom', 6);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $user = $this->getDoctrine()->getManager()->getRepository("LocationBundle:User")->find($this->getUser()->getId());
            $location->setIdUser($user);
            $location->setStatus("en cours");
            $em = $this->getDoctrine()->getManager();

            $em->persist($location);
            $em->flush();

            return $this->redirectToRoute("location_homepage");
        }
        return $this->render("@Location/location/louerVelo.html.twig",
            array('form'=>$form->createView(),
//                'map'=>$map,
//                'positions'=>$positions
            ));
    }

    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function suppLocationAction(){

        $testLocation = $this->getDoctrine()->getManager()
            ->createQuery(
                'Select dl FROM LocationBundle:DetailLocation dl where dl.id_user = :iduser and dl.status = :status'
            )->setParameter('status', 'en cours')->setParameter('iduser', $this->getUser()->getid())
            ->getResult();
        if (count($testLocation) == 0){
            return $this->redirectToRoute("location_homepage");
        }

        $em = $this->getDoctrine()->getManager();
        $id = $this->getUser()->getid();
        $location = $em->getRepository(DetailLocation::class)->findOneBy([
            'id_user' => $id,
            'status' => 'en cours',
        ]);
        $em->remove($location);
        $em->flush();
        return $this->redirectToRoute('location_homepage');
    }

    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function updateLocationAction(Request $request){

        $testLocation = $this->getDoctrine()->getManager()
            ->createQuery(
                'Select dl FROM LocationBundle:DetailLocation dl where dl.id_user = :iduser and dl.status = :status'
            )->setParameter('status', 'en cours')->setParameter('iduser', $this->getUser()->getid())
            ->getResult();
        if (count($testLocation) == 0){
            return $this->redirectToRoute("location_homepage");
        }

        $update = true;
        $em = $this->getDoctrine()->getManager();
        $id = $this->getUser()->getid();
        $location = $em->getRepository(DetailLocation::class)->findOneBy([
            'id_user' => $id,
            'status' => 'en cours',
        ]);
        $form = $this->createForm(DetailLocationType::class, $location);
//        $map = new map();
//        $positions = $blue = $this->getDoctrine()->getManager()
//            ->createQuery(
//                'SELECT s.emplacement, s.longitude, s.latitude FROM LocationBundle:Site s')->getResult();
//        foreach ($positions as $site){
//            $marker = new Marker(new Coordinate($site["latitude"], $site["longitude"]));
//            $marker->setOption('label', $site["emplacement"]);
//            $map->getOverlayManager()
//                ->addMarker($marker);
//        }
//        $map->setCenter(new Coordinate('34.8706344', '9.5554123'));
//        $map->setMapOption('zoom', 6);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $location->setDateDebut($form['dateDebut']->getData());
            $location->setDateFin($form['dateFin']->getData());
            $location->setIdSite($form['id_Site']->getData());
            $location->setIdType($form['id_Type']->getData());
            $em->flush();
            return $this->redirectToRoute("location_homepage");
        }
        return $this->render("@Location/location/louerVelo.html.twig",
            array('form'=>$form->createView(),
//                'map'=>$map,
//                'positions'=>$positions,
                'update'=>$update));

    }
}
