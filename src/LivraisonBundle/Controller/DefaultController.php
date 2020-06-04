<?php

namespace LivraisonBundle\Controller;

use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use LivraisonBundle\Entity\Livraison;
use LivraisonBundle\Entity\Notification;
use LivraisonBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Dompdf\Dompdf;
use Dompdf\Options;
use LivraisonBundle\LivraisonBundle;

class DefaultController extends Controller
{


    public function displaysAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repoLivraison = $em->getRepository(Notification::class);
        $query = $em->createQuery(
            'SELECT p
            FROM LivraisonBundle:Notification p
            ORDER BY p.id DESC  '
        );
        $notificationsa = $query->setMaxResults(3)->getResult();
        // 3. Query how many rows are there in the Articles table
        $nb = $repoLivraison->createQueryBuilder('a')
            // Filter by some parameter if you want
            // ->where('a.published = 1')
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();
        return $this->render('@Livraison/Default/notification.html.twig', array('notificationss' => $notificationsa, 'length' => $nb));
    }


    public function seeAllAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repoLivraison = $em->getRepository(Notification::class);
        $query = $em->createQuery(
            'SELECT p
            FROM LivraisonBundle:Notification p
            ORDER BY p.id DESC  '
        );
        $notificationsa = $query->getResult();
        // 3. Query how many rows are there in the Articles table

        return $this->render('@Livraison/Default/notifications.html.twig', array('notificationss' => $notificationsa));
    }


    public function generate_pdfAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('LivraisonBundle:User')->findAll();
        $tache = $em->getRepository('LivraisonBundle:Livraison')->findAll();
        $options = new Options();
        $options->set('defaultFont', 'Roboto');
        $filename = sprintf('test-%s.pdf', date('Y-m-d'));
        $dompdf = new Dompdf($options);
        $data = array(
            'headline' => 'my headline'
        );
        $html = $this->renderView('@Livraison/Default/layout-pdf.html.twig', array(
            'tache' => $tache,
            'agent' => $user
        ));
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream($filename, [
            "Attachment" => true
        ]);
    }

    public function generate_pdfaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('LivraisonBundle:User')->findAll();
        $tache = $em->getRepository('LivraisonBundle:Livraison')->findAll();
        $options = new Options();
        $options->set('defaultFont', 'Roboto');
        $filename = sprintf('test-%s.pdf', date('Y-m-d'));
        $dompdf = new Dompdf($options);
        $data = array(
            'headline' => 'my headline'
        );
        $html = $this->renderView('@Livraison/Default/layout-pdf-agent.html.twig', array(
            'tache' => $tache,
            'agent' => $user
        ));
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream($filename, [
            "Attachment" => true
        ]);
    }


    public function generate_pdfsAction(Request $request, $id)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $tache = $em->getRepository('LivraisonBundle:Livraison')->find($id);
        $options = new Options();
        $options->set('defaultFont', 'Roboto');
        $filename = sprintf('test-%s.pdf', date('Y-m-d'));
        $dompdf = new Dompdf($options);
        $data = array(
            'headline' => 'my headline'
        );
        $html = $this->renderView('@Livraison/Default/livraison.view.html.twig', array(
            'tache' => $tache
        ));
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("testspdf.pdf", [
            "Attachment" => true
        ]);
    }


    public function indexAction()
    {
        return $this->render('@Livraison/Default/index.html.twig');
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function adminlistAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('LivraisonBundle:User')->findAll();
        $tache = $em->getRepository('LivraisonBundle:Livraison')->findAll();
        return $this->render('@Livraison/Default/livraison.admin.html.twig', array(
            'tache' => $tache,
            'agent' => $user
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function admindashboardAction()
    {
        
   
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
            ->getQuery()
            ->getSingleScalarResult();

        $queryCours = $repoLivraison->createQueryBuilder('c')
            // Filter by some parameter if you want
            ->andWhere('c.etat = :etats')
            ->setParameter('etats', $etat)
            ->select('count(c.id)')
            ->getQuery()
            ->getSingleScalarResult();
        $percentagecours = 0;
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
        $role = "ROLE_AGENT";
        $queryagent = $repoUser->createQueryBuilder('e')
            // Filter by some parameter if you want
            ->where('e.roles LIKE :roles')
            ->setParameter('roles', '%"' . $role . '"%')
            ->select('count(e.id)')
            ->getQuery()
            ->getSingleScalarResult();
        $roles = "a:0:{}";
        $queryclient = $repoUser->createQueryBuilder('d')
            // Filter by some parameter if you want
            ->andwhere('d.roles  LIKE :roles ')
            ->setParameter('roles', $roles)
            ->select('count(d.id)')
            ->getQuery()
            ->getSingleScalarResult();
            $ob = new Highchart();
            $ob->chart->renderTo('piechart');
            $ob->title->text('Gestion de Livraison Chart');
            $ob->plotOptions->pie(array(
                'allowPointSelect'  => true,
                'cursor'    => 'pointer',
                'dataLabels'    => array('enabled' => false),
                'showInLegend'  => true
            ));
            $percentageCourss  = number_format($percentageCours,1);
            $percentagelivs =  number_format($percentageliv,1);
            $data = array(
                array('Livrées', $percentageCours),
                array('En Cours', $percentageliv)
            );
            $ob->series(array(array('type' => 'pie','name' => 'Pourcentage', 'data' => $data)));

        return $this->render('@Livraison/Default/statistiques.html.twig', array('numTot' => $totalLivraison, 'numCours' => $queryCours, 'numLiv' => $queryLiv, 'numAgt' => $queryagent, 'numCl' => $queryclient, 'percliv' => $percentageliv, 'perccours' => $percentageCours, 'chart' => $ob));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function livraisoneditAction(Request $request, Livraison $livraison)
    {
        $em = $this->getDoctrine()->getManager();
        $editForm = $this->createForm('LivraisonBundle\Form\LivraisonType', $livraison);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $tacheid = $livraison->getId();
            $tache = $em->getRepository('LivraisonBundle:Livraison')->find($tacheid);
            $agent = $tache->getAgent();
            $idagent = $agent->getId();
            $email = $agent->getEmail();
            $message = \Swift_Message::newInstance()
                ->setSubject('Une  tache a été modifiée')
                ->setFrom(array('easyride@gmail.com' => 'Easy Ride'))
                ->setTo($email)
                ->setBody("<h1>Bonjour ,<br/> Agent $idagent : </h1><br><p>Votre tache $tacheid a été modifiée</p>", 'text/html');
            $this->get('mailer')->send($message);
            $this->getDoctrine()->getManager()->flush();
            $request->getSession()->getFlashBag()->add('info', 'Tache bien editée.');
            $notification = new Notification();
            $notification
                ->setTitle('Nouvelle Confirmation Livraison')
                ->setDescription('Nouvelle Confirmation Livraison a été ajoutée ')
                ->setRoute('livraison_agent') // I suppose you have a show route for your entity
                ->setParameters(array('id' => $this->id));
            $em->persist($notification);
            $em->flush();
            $pusher = $this->get('mrad.pusher.notificaitons');
            $pusher->trigger($notification);
            return $this->redirectToRoute('livraison_view', array('id' => $livraison->getId()));
        }
        return $this->render('@Livraison/Default/livraison.edit.html.twig', array(
            'livraison' => $livraison,
            'edit_form' => $editForm->createView()
        ));
    }
    /**
     * @Security("has_role('ROLE_AGENT')")
     */
    public function agenttachesAction()
    {
        $user = $this->getUser();
        $user->getId();
        $em = $this->getDoctrine()->getManager();
        $tache = $em->getRepository('LivraisonBundle:Livraison')->findBy(array('agent' => $user->getId()));
        return $this->render('@Livraison/Default/livraison.agent.html.twig', array('tache' => $tache));
    }
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function livraisondeleteAction(Livraison $livraison, Request $request)
    {
        $id = $livraison->getId();
        $em = $this->getDoctrine()->getManager();
        $tache = $em->getRepository('LivraisonBundle:Livraison')->find($id);
        $idagent = $tache->getAgent();
        $email = $em->getRepository('LivraisonBundle:User')->find($idagent);
        $i = $tache->getId();
        $message = \Swift_Message::newInstance()
            ->setSubject('Vous avez une nouvelle tache')
            ->setFrom(array('easyride@gmail.com' => 'Easy Ride'))
            ->setTo($email->getEmail())
            ->setBody("<h1>Bonjour ,<br/> Agent $idagent : </h1><br><p>Votre tache $i a été supprimée</p>", 'text/html');
        $this->get('mailer')->send($message);
        $em->remove($tache);
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', 'Tache bien supprimée.');
        return $this->redirectToRoute('livraison_admin');
    }
    /**
     * @Security("has_role('ROLE_AGENT')")
     */
    public function validerAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tache = $em->getRepository('LivraisonBundle:Livraison')->find($id);
        $tache->setEtat("Livrée");
        $tache->setDateLivraisonn(new \DateTime());
        $agent = $tache->getClient();
        $idagent = $agent->getId();
        $email = $em->getRepository('LivraisonBundle:User')->find($idagent);
        $message = \Swift_Message::newInstance()
            ->setSubject('Commande Reçue')
            ->setFrom(array('easyride@gmail.com' => 'Easy Ride'))
            ->setTo($email->getEmail())
            ->setBody("<h1>Bonjour ,<br/> Client $idagent : </h1><br><p>Votre commande delivraison numéro $id a été Livrée </p>", 'text/html');
        $this->get('mailer')->send($message);
        $notification = new Notification();
        $notification
            ->setTitle('Nouvelle Confirmation Livraison')
            ->setDescription('Nouvelle Confirmation Livraison a été ajoutée ')
            ->setRoute('livraison_agent') // I suppose you have a show route for your entity
            ->setParameters(array('id' => $idagent));
        $em->persist($notification);
        $em->flush();
        $pusher = $this->get('mrad.pusher.notificaitons');
        $pusher->trigger($notification);
        $em->persist($tache);
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', 'Etat Tache bien modifiée.');
        return $this->redirectToRoute('livraison_agent');
    }
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function addAction(Request $request)
    {
        $tache = new Livraison();
        $form = $this->createForm('LivraisonBundle\Form\LivraisonType', $tache);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tache);
            $em->flush();
            $notification = new Notification();
            $notification
                ->setTitle('Nouvelle Livraison')
                ->setDescription('Nouvelle Livraison a été ajoutée ')
                ->setRoute('livraison_view') // I suppose you have a show route for your entity
                ->setParameters(array('id' => $tache->getId()));
            $idagent = $tache->getAgent();
            $email = $em->getRepository('LivraisonBundle:User')->find($idagent);
            $i = $tache->getId();
            $message = \Swift_Message::newInstance()
                ->setSubject('Vous avez une nouvelle tache')
                ->setFrom(array('easyride@gmail.com' => 'Easy Ride'))
                ->setTo($email->getEmail())
                ->setBody("<h1>Bonjour ,<br/> Agent $idagent : </h1><br><p>Vous avez reçu une nouvelle tache $i</p>", 'text/html');
            $this->get('mailer')->send($message);
            $request->getSession()->getFlashBag()->add('success', 'Tache bien affecée.');
            $em->persist($notification);
            $em->flush();
            $pusher = $this->get('mrad.pusher.notificaitons');
            $pusher->trigger($notification);

            return $this->redirectToRoute('livraison_view', array('id' => $tache->getId()));
        }

        return $this->render('@Livraison/Default/livraison.add.html.twig', array(
            'tache' => $tache,
            'form' => $form->createView()
        ));
    }
    /**
     * @Security("has_role('ROLE_ADMIN' and 'ROLE_AGENT')")
     */
    public function viewAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $tache = $em->getRepository('LivraisonBundle:Livraison')->find($id);
        return $this->render('@Livraison/Default/livraison.view.html.twig', array('tache' => $tache));
    }
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function agentaddAction(Request $request)
    {
        return $this->render('@Livraison/Default/agent.add.html.twig');
    }
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function agentdeleteAction(User $user, Request $request)
    {
        $id = $user->getId();
        $em = $this->getDoctrine()->getManager();
        $agent = $em->getRepository('LivraisonBundle:User')->find($id);
        $email = $agent->getEmail();
        $email = trim($email);
        $message = \Swift_Message::newInstance()
            ->setSubject('Vous etes supprimé')
            ->setFrom(array('easyride@gmail.com' => 'Easy Ride'))
            ->setTo($email)
            ->setCharset('utf-8')
            ->setBody("<h1>Bonjour ,<br/> Agent numéro $id : </h1><br><p>Votre Administrateur a décidé de vous supprimer . </p>", 'text/html');
        $this->get('mailer')->send($message);
        $em->remove($user);
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', 'Agent bien suprimée.');
        return $this->redirectToRoute('agent_list');
    }
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function agentlistAction()
    {
        $em = $this->getDoctrine();
        $agents = new User();
        $repository = $this->getDoctrine()->getRepository('LivraisonBundle:User');
        $query = $repository->findByRole('ROLE_AGENT');

        return $this->render('@Livraison/Default/agent.list.html.twig', array('agents' => $query));
    }
    /**
     * @Security("has_role('ROLE_ADMIN' and 'ROLE_AGENT')")
     */
    public function agentviewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $agent = $em->getRepository('LivraisonBundle:User')->find($id);
        return $this->render('@Livraison/Default/agent.view.html.twig', array('item' => $agent));
    }

    public function clientviewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('LivraisonBundle:User')->find($id);
        return $this->render('@Livraison/Default/client.view.html.twig', array('item' => $client));
    }
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function agenteditAction(Request $request)
    {
        return $this->render('@Livraison/Default/agent.edit.html.twig');
    }
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function admineditAction(Request $request)
    {
        return $this->render('@Livraison/Default/admin.edit.html.twig');
    }
}
