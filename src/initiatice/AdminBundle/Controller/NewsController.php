<?php

namespace initiatice\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewsController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('initiaticeAdminBundle:News');
        $news = $repository->findAll();
        return $this->render('initiaticeAdminBundle:News:index.html.twig', array('news' => $news));
    }

    public function addAction()
    {
        return $this->render('initiaticeAdminBundle:News:add.html.twig');
    }
    
    public function editAction()
    {
        return $this->render('initiaticeAdminBundle:News:edit.html.twig');
    }
    
    public function removeAction($id)
    {
        echo $id;
        //TODO: Redirect to index
    }
}
