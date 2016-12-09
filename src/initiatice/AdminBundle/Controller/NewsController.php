<?php

namespace initiatice\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use initiatice\AdminBundle\Entity\News;
use initiatice\AdminBundle\Form\NewsType;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends Controller
{
    private function getBd() { return $this->getDoctrine()->getManager(); }

    public function indexAction()
    {
        $news = $this->getBd()->getRepository('initiaticeAdminBundle:News')->findAll();
        return $this->render('initiaticeAdminBundle:News:index.html.twig', ['news' => $news]);
    }

    public function addAction(Request $request)
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news, ['entity_manager' => $this->getBd()]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $news = $form->getData();
            $news->setDateAdd(new \DateTime());
            $news->setDateUpdate(new \DateTime());
            $this->getBd()->persist($news);
            $this->getBd()->flush();
            return $this->redirectToRoute('initiatice_admin_news_index');
        }
        return $this->render('initiaticeAdminBundle:News:add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function editAction($id, Request $request)
    {
        $news = $this->getBd()->getRepository('initiaticeAdminBundle:News')->find($id);
        $form = $this->createForm(NewsType::class, $news, ['entity_manager' => $this->getBd()]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $news = $form->getData();
            $news->setDateUpdate(new \DateTime());
            $this->getBd()->persist($news);
            $this->getBd()->flush();
            return $this->redirectToRoute('initiatice_admin_news_index');
        }
        return $this->render('initiaticeAdminBundle:News:edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function removeAction($id)
    {
        $news = $this->getBd()->getRepository('initiaticeAdminBundle:News')->find($id);
        $this->getBd()->remove($news);
        $this->getBd()->flush();
        return $this->redirectToRoute('initiatice_admin_news_index');
    }
}
