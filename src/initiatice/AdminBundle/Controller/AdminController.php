<?php

namespace initiatice\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * An administrator (moderator) can access to the backoffice for show, edit or remove entities
 * Class AdminController
 * @package initiatice\AdminBundle\Controller
 */
class AdminController extends Controller
{
    private function getBd() { return $this->getDoctrine()->getManager(); }

    /**
     * List all administrators (moderators) on the backoffice
     * @return mixed
     */
    public function indexAction()
    {
        $admins = $this->getBd()->getRepository('initiaticeAdminBundle:Admin')->findAll();
        return $this->render('initiaticeAdminBundle:Admin:index.html.twig', ['admins' => $admins]);
    }

    /**
     * Remove an admistrator (moderator) on the backoffice
     * @param $id
     * @return mixed
     */
    public function removeAction($id)
    {
        $admin = $this->getBd()->getRepository('initiaticeAdminBundle:Admin')->find($id);
        $this->getBd()->remove($admin);
        $this->getBd()->flush();
        return $this->redirectToRoute('initiatice_admin_homepage');
    }
}
