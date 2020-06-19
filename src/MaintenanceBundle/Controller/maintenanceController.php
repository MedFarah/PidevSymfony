<?php

namespace MaintenanceBundle\Controller;

use MaintenanceBundle\Entity\maintenance;
use MaintenanceBundle\Form\maintenanceadminType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

 /**
 * Maintenance controller.
 *
 */
class maintenanceController extends Controller
{
    /**
     * Lists all maintenance entities.
     *
     */
    public function indexAction(string $critere)
    {
        $em = $this->getDoctrine()->getManager();
        $etat = ['en attente','confirmé'];
        $req = 'SELECT m FROM MaintenanceBundle:maintenance m WHERE m.id_user= :id and m.etat in (:etat)';
        if ($critere != "none"){
            $req = $req.' ORDER BY m.'.$critere;
        }
        $maintenances = $em->createQuery($req)
            ->setParameter('id', $this->getUser()->getid())
            ->setParameter('etat', $etat)
            ->getResult();


        $etat = "en cours";
        $RDVaconfirmer = $em->createQuery(
            'SELECT m FROM MaintenanceBundle:maintenance m WHERE m.etat = :etat and m.id_user= :id'
        )->setParameter('etat', $etat)->setParameter('id', $this->getUser()->getid())->getResult();

        $userid = $this->getUser()->getId();

        return $this->render('@Maintenance/maintenance/index.html.twig', array(
            'maintenances' => $maintenances,
            'RDVaconfirmer' => $RDVaconfirmer,
            'userid' => $userid,
        ));
    }

    /**
     * Creates a new maintenance entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $etat = "en cours";
        $RDVaconfirmer = $em->createQuery(
            'SELECT m FROM MaintenanceBundle:maintenance m WHERE m.etat = :etat and m.id_user= :id'
        )->setParameter('etat', $etat)->setParameter('id', $this->getUser()->getid())->getResult();

        $maintenance = new Maintenance();
        $form = $this->createForm('MaintenanceBundle\Form\maintenanceType', $maintenance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $maintenance->setEtat("en attente");
            $user = $em->getRepository("MaintenanceBundle:User")->find($this->getUser()->getId());
            $maintenance->setIdUser($user);
            $em->persist($maintenance);
            $em->flush();

            return $this->redirectToRoute('maintenance_client_index');
        }

        return $this->render('@Maintenance/maintenance/new.html.twig', array(
            'maintenance' => $maintenance,
            'form' => $form->createView(),
            'RDVaconfirmer' => $RDVaconfirmer,
        ));
    }

    /**
     * Displays a form to edit an existing maintenance entity.
     *
     */
    public function editAction(Request $request, maintenance $maintenance)
    {
        $deleteForm = $this->createDeleteForm($maintenance);
        $editForm = $this->createForm('MaintenanceBundle\Form\maintenanceType', $maintenance);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('maintenance_client_index', array('id' => $maintenance->getId()));
        }

        $etat = "en cours";
        $RDVaconfirmer = $this->getDoctrine()->getManager()->createQuery(
            'SELECT m FROM MaintenanceBundle:maintenance m WHERE m.etat = :etat and m.id_user= :id'
        )->setParameter('etat', $etat)->setParameter('id', $this->getUser()->getid())->getResult();

        return $this->render('@Maintenance/maintenance/edit.html.twig', array(
            'RDVaconfirmer'=>$RDVaconfirmer,
            'maintenance' => $maintenance,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a maintenance entity.
     *
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $maintenance = $em->getRepository('MaintenanceBundle:maintenance')->find($id);
        $em->remove($maintenance);
        $em->flush();
        return $this->redirectToRoute('maintenance_client_index');
    }

    /**
     * Creates a form to delete a maintenance entity.
     *
     * @param maintenance $maintenance The maintenance entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(maintenance $maintenance)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('maintenance_client_delete', array('id' => $maintenance->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function validerRDVAction(){
        $em = $this->getDoctrine()->getManager();
        $validation = true;

        $etat = "en cours";
        $RDVaconfirmer = $em->createQuery(
            'SELECT m FROM MaintenanceBundle:maintenance m WHERE m.etat = :etat and m.id_user= :id'
        )->setParameter('etat', $etat)
            ->setParameter('id', $this->getUser()->getid())
            ->getResult();

        $req = 'SELECT m FROM MaintenanceBundle:maintenance m WHERE m.id_user= :id and m.etat = :etat';
        $maintenances = $em->createQuery($req)
            ->setParameter('id', $this->getUser()->getid())
            ->setParameter('etat', "en cours")
            ->getResult();

        return $this->render('@Maintenance/maintenance/index.html.twig', array(
            'maintenances' => $maintenances,
            'RDVaconfirmer' => $RDVaconfirmer,
            'validation' => $validation
        ));
    }
    public function acceptRDVAction($id)
    {
        $maintenance = $this->getDoctrine()->getManager()->getRepository('MaintenanceBundle:maintenance')->find($id);
        $maintenance->setEtat('confirmé');
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('maintenance_client_index');
    }

    public function refuseRDVAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $maintenance = $em->getRepository('MaintenanceBundle:maintenance')->find($id);
        $em->remove($maintenance);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('maintenance_client_index');
    }

    public function indexadminAction(string $critere)
    {
        $em = $this->getDoctrine()->getManager();

        $req = 'SELECT m.id, m.titre, m.description, m.dateRDV, m.etat, u.nom FROM MaintenanceBundle:maintenance m join MaintenanceBundle:User u WITH m.id_user = u.id ';
        if ($critere != "none") {
            switch ($critere) {
                case "date":
                    $req = $req . ' ORDER BY m.dateRDV';
                    break;
                case "date_desc":
                    $req = $req . ' ORDER BY m.dateRDV DESC';
                    break;
                case "titre":
                    $req = $req . ' ORDER BY m.titre';
                    break;
                case "etat":
                    $req = $req . ' ORDER BY m.etat';
                    break;
            }
        }
        $maintenances = $em->createQuery($req)->getResult();

        return $this->render('@Maintenance/admin/index.html.twig', array(
            'maintenances' => $maintenances,
        ));
    }

    public function validerRDVadminAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $etat = "en attente";
        $maintenances = $this->getDoctrine()->getManager()
            ->createQuery(
                'SELECT m.id,m.titre, m.description, m.dateRDV, u.nom FROM MaintenanceBundle:maintenance m join MaintenanceBundle:User u WITH m.id_user = u.id WHERE m.etat =:etat order by m.dateRDV '
            )->setParameter('etat', $etat)
            ->getResult();

        $maintenance = new maintenance();
        $form = $this->createForm(maintenanceadminType::class, $maintenance);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()){
            $maintenance = $em->getRepository('MaintenanceBundle:maintenance')->find($form['id']->getData());
            $daterdv = $maintenance->getDateRDV()->format('d/m/Y');
            $heurerdv = $maintenance->getDateRDV()->format('H:m');
            $maintenance->setEtat("en cours");
            $maintenance->setDateRDV($form["date"]->getData());
            $this->getDoctrine()->getManager()->flush();

            $iduser = $maintenance->getIdUser();
            $user = $em->getRepository('MaintenanceBundle:User')->find($iduser);
            $nomuser = $user->getNom();

            $nomadmin = $this->getUser()->getNomComplet();
            $signature = "<hr>  $nomadmin <br> Admin Easy Ride";
            $message = \Swift_Message::newInstance()
                ->setSubject('Rendez-vous à revalider')
                ->setFrom(array('easyride@gmail.com' => 'Easy Ride'))
                ->setTo($user->getEmail())
                ->setBody("<h4>Bonjour $nomuser ,</h4><br><p>Le rendez vous à la date $daterdv à $heurerdv n'est pas disponible, une autre proposition vous a été envoyé, merci de vous rendre sur votre compte vous la valider</p>".$signature, 'text/html');
            $this->get('mailer')->send($message);


            return $this->redirectToRoute("maintenance_admin_index");
        }
        return $this->render('@Maintenance/admin/valider.html.twig', array(
            'maintenances' => $maintenances,
            'formObject' => $form
        ));
    }
    public function acceptRDVadminAction(maintenance $maintenance)
    {
        $em = $this->getDoctrine()->getManager();
        $maintenance->setEtat('confirmé');
        $em->flush();

        $daterdv = $maintenance->getDateRDV()->format('d/m/Y');
        $heurerdv = $maintenance->getDateRDV()->format('H:m');
        $iduser = $maintenance->getIdUser();
        $user = $em->getRepository('MaintenanceBundle:User')->find($iduser);
        $nomuser = $user->getNom();
        $nomadmin = $this->getUser()->getNomComplet();
        $signature = "<hr>  $nomadmin <br> Admin Easy Ride";
        $message = \Swift_Message::newInstance()
            ->setSubject('Rendez-vous confirmé')
            ->setFrom(array('easyride@gmail.com' => 'Easy Ride'))
            ->setTo($user->getEmail())
            ->setBody("<h4>Bonjour $nomuser ,</h4><br><p>Le rendez vous à la date $daterdv à $heurerdv a été confirmé avec succes</p>".$signature, 'text/html');
        $this->get('mailer')->send($message);

        return $this->redirectToRoute('maintenance_admin_index');
    }

//    public function refuseRDVadminAction($id)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $maintenance = $em->getRepository('MaintenanceBundle:maintenance')->find($id);
//        $em->remove($maintenance);
//        $this->getDoctrine()->getManager()->flush();
//        return $this->redirectToRoute('maintenance_client_index');
//    }

    private function getinfo(maintenance $maintenance){
        $output = array();


    }
}
