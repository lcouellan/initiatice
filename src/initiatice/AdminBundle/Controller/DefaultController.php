<?php

namespace initiatice\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use initiatice\AdminBundle\Entity\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $securityContext = $this->container->get('security.authorization_checker');
        var_dump($securityContext->isGranted('IS_AUTHENTIFICATED_FULLY'));
        if ( $this->get('security.token_storage')->getToken()->getUser() ) {
            return $this->render('initiaticeAdminBundle:Default:index.html.twig');
        }
        return $this->redirect($this->generateUrl('fos_user_security_login'));
    }
}
