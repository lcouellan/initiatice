<?php

namespace initiatice\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    private function getBd() { return $this->getDoctrine()->getManager(); }

    public function indexAction()
    {
        $admins = $this->getBd()->getRepository('initiaticeAdminBundle:Admin')->findAll();
        return $this->render('initiaticeAdminBundle:Admin:index.html.twig', ['admins' => $admins]);
    }

    public function removeAction($id)
    {
        $admin = $this->getBd()->getRepository('initiaticeAdminBundle:Admin')->find($id);
        $this->getBd()->remove($admin);
        $this->getBd()->flush();
        return $this->redirectToRoute('initiatice_admin_homepage');
    }
}
