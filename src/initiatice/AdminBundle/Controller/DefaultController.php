<?php

namespace initiatice\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Class DefaultController
 * @package initiatice\AdminBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * Show the default page on the backoffice
     * @return mixed
     */
    public function indexAction()
    {
        return $this->render('initiaticeAdminBundle:Default:index.html.twig');
    }
}
