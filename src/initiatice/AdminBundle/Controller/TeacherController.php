<?php

namespace initiatice\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use initiatice\AdminBundle\Entity\Teacher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TeacherController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('initiaticeAdminBundle:Teacher');
        $teachers = $repository->findAll();
        return $this->render('initiaticeAdminBundle:Teacher:index.html.twig', array('teachers' => $teachers));
    }

    public function addAction(Request $request)
    {
        $teacher = new Teacher();

        $form = $this->createFormBuilder($teacher)
            ->add('firstname', TextType::class, array('label' => 'Prénom'))
            ->add('lastname', TextType::class, array('label' => 'Nom'))
            ->add('email', TextType::class, array('label' => 'Email'))
            ->add('plainPassword', TextType::class, array('label' => 'Email'))
            ->add('enabled', CheckboxType::class, array('label' => 'Enabled'))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $teacher = $form->getData();
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
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('initiaticeAdminBundle:Teacher')
        ;
        // On récupère l'entité correspondante à l'id $id
        $teacher = $repository->find($id);

        $form = $this->createFormBuilder($teacher)
            ->add('firstname', TextType::class, array('label' => 'Prénom'))
            ->add('lastname', TextType::class, array('label' => 'Nom'))
            ->add('email', TextType::class, array('label' => 'Email'))
            ->add('plainPassword', TextType::class, array('label' => 'Email'))
            ->add('enabled', CheckboxType::class, array('label' => 'Enabled'))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $teacher = $form->getData();
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
