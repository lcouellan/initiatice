<?php

namespace initiatice\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use initiatice\AdminBundle\Entity\ForumQuestion;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ForumQuestionController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('initiaticeAdminBundle:ForumQuestion');
        $questions = $repository->findAll();
        return $this->render('initiaticeAdminBundle:ForumQuestion:index.html.twig', array('questions' => $questions));
    }

    public function addAction(Request $request)
    {
        $question = new ForumQuestion();

        $form = $this->createFormBuilder($question)
            ->add('pseudo', TextType::class, array('label' => 'Pseudo'))
            ->add('title', TextType::class, array('label' => 'Title'))
            ->add('content', TextareaType::class, array('label' => 'Contenu'))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $question = $form->getData();
            $question->setDateAdd(new \DateTime());
            $question->setDateUpdate(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();
            return $this->redirectToRoute('initiatice_admin_forum_question_index');
        }
        return $this->render('initiaticeAdminBundle:ForumQuestion:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function editAction($id, Request $request)
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('initiaticeAdminBundle:ForumQuestion')
        ;
        // On récupère l'entité correspondante à l'id $id
        $question = $repository->find($id);

        $form = $this->createFormBuilder($question)
            ->add('pseudo', TextType::class, array('label' => 'Pseudo'))
            ->add('title', TextType::class, array('label' => 'Titre'))
            ->add('content', TextareaType::class, array('label' => 'Contenu'))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $question = $form->getData();
            $question->setDateUpdate(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();
            return $this->redirectToRoute('initiatice_admin_forum_question_index');
        }
        return $this->render('initiaticeAdminBundle:ForumQuestion:edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        // On récupère le repository
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('initiaticeAdminBundle:ForumQuestion');

        // On récupère l'entité correspondante à l'id $id
        $question = $repository->find($id);
        $em->remove($question);
        $em->flush();

        return $this->redirectToRoute('initiatice_admin_forum_question_index');
    }
}
