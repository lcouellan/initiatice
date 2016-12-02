<?php

namespace initiatice\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EventController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('initiaticeAdminBundle:Event');
        $events = $repository->findAll();
        return $this->render('initiaticeAdminBundle:Event:index.html.twig', array('events' => $events));
    }

    public function addAction()
    {
        return $this->render('initiaticeAdminBundle:Event:add.html.twig');
    }
    
    public function editAction()
    {
        return $this->render('initiaticeAdminBundle:Event:edit.html.twig');
    }
    
    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        // On récupère le repository
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('initiaticeAdminBundle:Event');

        // On récupère l'entité correspondante à l'id $id
        $event = $repository->find($id);
        $em->remove($event);
        $em->flush();

        return $this->redirectToRoute('initiatice_admin_event_index');
    }
}
