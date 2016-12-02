<?php

namespace initiatice\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EventController extends Controller
{
    public function indexAction()
    {
        //TODO: List
        return $this->render('initiaticeAdminBundle:Event:index.html.twig');
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
        echo $id;
        //TODO: Redirect to index
    }
}
