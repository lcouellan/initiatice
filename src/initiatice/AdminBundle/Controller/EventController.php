<?php

namespace initiatice\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use initiatice\AdminBundle\Entity\Event;
use initiatice\AdminBundle\Form\EventType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EventController
 * @package initiatice\AdminBundle\Controller
 */
class EventController extends Controller
{
    private function getBd() { return $this->getDoctrine()->getManager(); }

    /**
     * List all events on the backoffice
     * @return mixed
     */
    public function indexAction()
    {
        $events = $this->getBd()->getRepository('initiaticeAdminBundle:Event')->findAll();
        return $this->render('initiaticeAdminBundle:Event:index.html.twig', ['events' => $events]);
    }

    /**
     * Add an event on the backoffice
     * @param Request $request
     * @return mixed
     */
    public function addAction(Request $request)
    {
        $event = new Event();
        $event->setLatitude(-1);
        $event->setLongitude(-1);
        $event->setProfile(1);
        $event->setDateAdd(new \DateTime());
        
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
			
            $event = $form->getData();
            $event->setDateAdd(new \DateTime());
            $event->setDateUpdate(new \DateTime());
            $this->getBd()->persist($event);
            $this->getBd()->flush();
            return $this->redirectToRoute('initiatice_admin_event_index');
        }
        return $this->render('initiaticeAdminBundle:Event:add.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Modify an event by ID on the backoffice
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function editAction($id, Request $request)
    {
        $event =  $this->getBd()->getRepository('initiaticeAdminBundle:Event')->find($id);
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();
            $event->setDateUpdate(new \DateTime());
            $this->getBd()->persist($event);
            $this->getBd()->flush();
            return $this->redirectToRoute('initiatice_admin_event_index');
        }
        return $this->render('initiaticeAdminBundle:Event:edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Remove an event by ID on the backoffice
     * @param $id
     * @return mixed
     */
    public function removeAction($id)
    {
        $event = $this->getBd()->getRepository('initiaticeAdminBundle:Event')->find($id);
        $this->getBd()->remove($event);
        $this->getBd()->flush();
        return $this->redirectToRoute('initiatice_admin_event_index');
    }
}
