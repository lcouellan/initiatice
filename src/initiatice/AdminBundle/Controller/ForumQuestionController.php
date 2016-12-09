<?php

namespace initiatice\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use initiatice\AdminBundle\Entity\ForumQuestion;
use initiatice\AdminBundle\Form\ForumQuestionType;
use Symfony\Component\HttpFoundation\Request;

class ForumQuestionController extends Controller
{
    private function getBd() { return $this->getDoctrine()->getManager(); }

    public function indexAction()
    {
        $questions = $this->getBd()->getRepository('initiaticeAdminBundle:ForumQuestion')->findAll();
        return $this->render('initiaticeAdminBundle:ForumQuestion:index.html.twig', ['questions' => $questions]);
    }

    public function addAction(Request $request)
    {
        $question = new ForumQuestion();
        $form = $this->createForm(ForumQuestionType::class, $question);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $question = $form->getData();
            $question->setDateAdd(new \DateTime());
            $question->setDateUpdate(new \DateTime());
            $this->getBd()->persist($question);
            $this->getBd()->flush();
            return $this->redirectToRoute('initiatice_admin_forum_question_index');
        }
        return $this->render('initiaticeAdminBundle:ForumQuestion:add.html.twig', ['form' => $form->createView()]);
    }

    public function editAction($id, Request $request)
    {
        $question = $this->getBd()->getRepository('initiaticeAdminBundle:ForumQuestion')->find($id);
        $form = $this->createForm(ForumQuestionType::class, $question);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $question = $form->getData();
            $question->setDateUpdate(new \DateTime());
            $this->getBd()->persist($question);
            $this->getBd()->flush();
            return $this->redirectToRoute('initiatice_admin_forum_question_index');
        }
        return $this->render('initiaticeAdminBundle:ForumQuestion:edit.html.twig', ['form' => $form->createView()]);
    }

    public function removeAction($id)
    {
        $question = $this->getBd()->getRepository('initiaticeAdminBundle:ForumQuestion')->find($id);
        $this->getBd()->remove($question);
        $this->getBd()->flush();
        return $this->redirectToRoute('initiatice_admin_forum_question_index');
    }
}
