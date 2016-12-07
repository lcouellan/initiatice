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
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('initiaticeAdminBundle:User');
        $users = $repository->findAll();
        return $this->render('initiaticeAdminBundle:User:index.html.twig', array('users' => $users));
    }

    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('initiaticeAdminBundle:User');

        $user = $repository->find($id);
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('initiatichomepageer_index');
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
