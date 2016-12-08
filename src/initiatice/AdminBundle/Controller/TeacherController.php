<?php

namespace initiatice\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use initiatice\AdminBundle\Entity\Teacher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TeacherController extends Controller
{
    public function indexAction()
    {
        $teachers = $this->getDoctrine()
            ->getManager()
            ->getRepository('initiaticeAdminBundle:Teacher')
            ->findAll();
        return $this->render('initiaticeAdminBundle:Teacher:index.html.twig', array('teachers' => $teachers));
    }

    public function addAction(Request $request)
    {
        $profiles = $this->getDoctrine()
            ->getManager()
            ->getRepository('initiaticeAdminBundle:Profile')
            ->findAll();
        $choices = [];
        foreach($profiles as $profile)
            $choices[$profile->getName()] = $profile->getId();

        $teacher = new Teacher();
        $form = $this->createFormBuilder($teacher)
            ->add('firstname', TextType::class, array('label' => 'Prénom'))
            ->add('lastname', TextType::class, array('label' => 'Nom'))
            ->add('email', TextType::class, array('label' => 'Email'))
            ->add('profile', ChoiceType::class, [
                'choices' => $choices, 'label' => 'Profile'
            ])
            ->add('plainPassword', TextType::class, array('label' => 'Mot de passe'))
            ->add('enabled', CheckboxType::class, array('label' => 'Enabled'))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $teacher = $form->getData();

            $encoderFactory = $this->container->get('security.encoder_factory');
            $e = $encoderFactory->getEncoder($teacher);

            $teacher->setPassword($e->encodePassword($teacher->getPlainPassword(), $teacher->getSalt()));
            $teacher->setDateAdd(new \DateTime());
            $teacher->setDateUpdate(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($teacher);
            $em->flush();
            return $this->redirectToRoute('initiatice_admin_teacher_index');
        }
        return $this->render('initiaticeAdminBundle:Teacher:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function editAction($id, Request $request)
    {
        $profiles = $this->getDoctrine()
            ->getManager()
            ->getRepository('initiaticeAdminBundle:Profile')
            ->findAll();
        $choices = [];
        foreach($profiles as $profile)
            $choices[$profile->getName()] = $profile->getId();

        $teacher = $this->getDoctrine()
            ->getManager()
            ->getRepository('initiaticeAdminBundle:Teacher')
            ->find($id);
        $form = $this->createFormBuilder($teacher)
            ->add('firstname', TextType::class, array('label' => 'Prénom'))
            ->add('lastname', TextType::class, array('label' => 'Nom'))
            ->add('email', TextType::class, array('label' => 'Email'))
            ->add('profile', ChoiceType::class, [
                'choices' => $choices, 'label' => 'Profile'
            ])
            ->add('plainPassword', TextType::class, array('label' => 'Mot de passe'))
            ->add('enabled', CheckboxType::class, array('label' => 'Enabled'))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $teacher = $form->getData();

            $encoderFactory = $this->container->get('security.encoder_factory');
            $e = $encoderFactory->getEncoder($teacher);

            $teacher->setPassword($e->encodePassword($teacher->getPlainPassword(), $teacher->getSalt()));
            $teacher->setDateUpdate(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($teacher);
            $em->flush();
            return $this->redirectToRoute('initiatice_admin_teacher_index');
        }
        return $this->render('initiaticeAdminBundle:Teacher:edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        // On récupère le repository
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('initiaticeAdminBundle:Teacher');

        // On récupère l'entité correspondante à l'id $id
        $teacher = $repository->find($id);
        $em->remove($teacher);
        $em->flush();

        return $this->redirectToRoute('initiatice_admin_teacher_index');
    }
}
