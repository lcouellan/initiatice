<?php

namespace initiatice\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use initiatice\AdminBundle\Entity\ForumComment;
use initiatice\AdminBundle\Form\ForumCommentType;
use Symfony\Component\HttpFoundation\Request;

class ForumCommentController extends Controller
{
    private function getBd() { return $this->getDoctrine()->getManager(); }

    public function indexAction()
    {
        $comments = $this->getBd()->getRepository('initiaticeAdminBundle:ForumComment')->findAll();
        return $this->render('initiaticeAdminBundle:ForumComment:index.html.twig', ['comments' => $comments]);
    }

    public function addAction(Request $request)
    {
        $comment = new ForumComment();
        $form = $this->createForm(ForumCommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setDateAdd(new \DateTime());
            $comment->setDateUpdate(new \DateTime());
            $this->getBd()->persist($comment);
            $this->getBd()->flush();
            return $this->redirectToRoute('initiatice_admin_forum_comment_index');
        }
        return $this->render('initiaticeAdminBundle:ForumComment:add.html.twig', ['form' => $form->createView()]);
    }

    public function editAction($id, Request $request)
    {
        $comment = $this->getBd()->getRepository('initiaticeAdminBundle:ForumComment')->find($id);
        $form = $this->createForm(ForumCommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setDateUpdate(new \DateTime());
            $this->getBd()->persist($comment);
            $this->getBd()->flush();
            return $this->redirectToRoute('initiatice_admin_forum_comment_index');
        }
        return $this->render('initiaticeAdminBundle:ForumComment:edit.html.twig', ['form' => $form->createView()]);
    }

    public function removeAction($id)
    {
        $comment = $this->getBd()->getRepository('initiaticeAdminBundle:ForumComment')->find($id);
        $this->getBd()->remove($comment);
        $this->getBd()->flush();
        return $this->redirectToRoute('initiatice_admin_forum_comment_index');
    }
}
