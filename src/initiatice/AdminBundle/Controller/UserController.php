<?php

namespace initiatice\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use initiatice\AdminBundle\Entity\User;
use initiatice\AdminBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('fos_user_security_login'));
    }

    // Créer un compte, non utilisé
    /*public function loginAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->getSession()->getFlashBag()->add('notice', 'Utilisateur connecté !');
            return $this->redirectToRoute('');
        }
        return $this->render('', [
            'form' => $form->createView()
        ]);
    }*/
}
