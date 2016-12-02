<?php

namespace initiatice\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller
{
    public function indexAction()
    {
        //TODO: List
        return $this->render('initiaticeAdminBundle:Article:index.html.twig');
    }

    public function addAction()
    {
        return $this->render('initiaticeAdminBundle:Article:add.html.twig');
    }
    
    public function editAction()
    {
        return $this->render('initiaticeAdminBundle:Article:edit.html.twig');
    }
    
    public function removeAction($id)
    {
        echo $id;
        //TODO: Redirect to index
    }
}
