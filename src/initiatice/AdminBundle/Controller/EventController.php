<?php

namespace initiatice\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use initiatice\AdminBundle\Entity\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

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

    public function addAction(Request $request)
    {
        $event = new Event();

        $form = $this->createFormBuilder($event)
            ->add('title', TextType::class, array('label' => 'Titre'))
            ->add('type', TextType::class, array('label' => 'Type'))
            ->add('abstract', TextType::class, array('label' => 'Résumé'))
            ->add('place', TextType::class, array('label' => 'Lieu de l\'événement'))
            ->add('dateStart', TimeType::class, array(
				'input'  => 'timestamp',
				'widget' => 'choice',
			))
			->add('dateEnd', TimeType::class, array(
				'input'  => 'timestamp',
				'widget' => 'choice',
			))
			->add('content', TextareaType::class, array('label' => 'Contenu', 'attr' => array('class' => 'wysiwyg')))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();
            $event->setDateAdd(new \DateTime());
            $event->setDateUpdate(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('initiatice_admin_event_index');
        }

        return $this->render('initiaticeAdminBundle:Event:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function editAction($id, Request $request)
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('initiaticeAdminBundle:Event')
        ;

        // On récupère l'entité correspondante à l'id $id
        $event = $repository->find($id);

        $form = $this->createFormBuilder($event)
            ->add('title', TextType::class, array('label' => 'Titre'))
            ->add('type', TextType::class, array('label' => 'Type'))
            ->add('abstract', TextType::class, array('label' => 'Résumé'))
            ->add('place', TextType::class, array('label' => 'Lieu de l\'événement'))
            ->add('dateStart', TimeType::class, array(
				'input'  => 'timestamp',
				'widget' => 'choice',
			))
			->add('dateEnd', TimeType::class, array(
				'input'  => 'timestamp',
				'widget' => 'choice',
			))
            ->add('content', TextareaType::class, array('label' => 'Contenu', 'attr' => array('class' => 'wysiwyg')))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();
            $event->setDateUpdate(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('initiatice_admin_event_index');
        }

        return $this->render('initiaticeAdminBundle:Event:edit.html.twig', array(
            'form' => $form->createView(),
        ));
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
