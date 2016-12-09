<?php

namespace initiatice\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use initiatice\AdminBundle\Entity\User;
use initiatice\AdminBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;


class UserController extends Controller
{
    private function getBd() { return $this->getDoctrine()->getManager(); }
    private function getEncoderFactory() { return $this->container->get('security.encoder_factory'); }

    public function indexAction()
    {
        $users = $this->getBd()->getRepository('initiaticeAdminBundle:User')->findAll();
        return $this->render('initiaticeAdminBundle:User:index.html.twig', ['users' => $users]);
    }

    public function addAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['entity_manager' => $this->getBd()]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $e = $this->getEncoderFactory()->getEncoder($user);
            $user->setPassword($e->encodePassword($user->getPlainPassword(), $user->getSalt()));
            $user->setDateAdd(new \DateTime());
            $user->setDateUpdate(new \DateTime());
            $this->getBd()->persist($user);
            $this->getBd()->flush();
            return $this->redirectToRoute('initiatice_admin_user_index');
        }
        return $this->render('initiaticeAdminBundle:User:add.html.twig', ['form' => $form->createView()]);
    }

    public function editAction($id, Request $request)
    {
        $user = $this->getBd()->getRepository('initiaticeAdminBundle:User')->find($id);
        $form = $this->createForm(UserType::class, $user, ['entity_manager' => $this->getBd()]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $e = $this->getEncoderFactory()->getEncoder($user);
            $user->setPassword($e->encodePassword($user->getPlainPassword(), $user->getSalt()));
            $user->setDateUpdate(new \DateTime());
            $this->getBd()->persist($user);
            $this->getBd()->flush();
            return $this->redirectToRoute('initiatice_admin_user_index');
        }
        return $this->render('initiaticeAdminBundle:User:edit.html.twig', ['form' => $form->createView()]);
    }

    public function removeAction($id)
    {
        $user = $this->getBd()->getRepository('initiaticeAdminBundle:User')->find($id);
        $this->getBd()->remove($user);
        $this->getBd()->flush();
        return $this->redirectToRoute('initiatice_admin_user_index');
    }
}
