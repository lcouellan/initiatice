<?php

namespace initiatice\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use initiatice\AdminBundle\Entity\ForumComment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ForumCommentController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('initiaticeAdminBundle:ForumComment');
        $comments = $repository->findAll();
        return $this->render('initiaticeAdminBundle:ForumComment:index.html.twig', array('comments' => $comments));
    }

    public function addAction(Request $request)
    {
        $comment = new ForumComment();

        $form = $this->createFormBuilder($comment)
            ->add('pseudo', TextType::class, array('label' => 'Pseudo'))
            ->add('questionId', TextType::class, array('label' => 'Question'))
            ->add('content', TextareaType::class, array('label' => 'Contenu'))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setDateAdd(new \DateTime());
            $comment->setDateUpdate(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('initiatice_admin_forum_comment_index');
        }
        return $this->render('initiaticeAdminBundle:ForumComment:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function editAction($id, Request $request)
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('initiaticeAdminBundle:ForumComment')
        ;
        // On récupère l'entité correspondante à l'id $id
        $comment = $repository->find($id);

        $form = $this->createFormBuilder($comment)
            ->add('pseudo', TextType::class, array('label' => 'Pseudo'))
            ->add('questionId', TextType::class, array('label' => 'Question'))
            ->add('content', TextareaType::class, array('label' => 'Contenu'))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setDateUpdate(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('initiatice_admin_forum_comment_index');
        }
        return $this->render('initiaticeAdminBundle:ForumComment:edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        // On récupère le repository
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('initiaticeAdminBundle:ForumComment');

        // On récupère l'entité correspondante à l'id $id
        $comment = $repository->find($id);
        $em->remove($comment);
        $em->flush();

        return $this->redirectToRoute('initiatice_admin_forum_comment_index');
    }
}
