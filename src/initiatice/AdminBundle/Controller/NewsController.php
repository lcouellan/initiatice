<?php

namespace initiatice\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use initiatice\AdminBundle\Entity\News;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class NewsController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('initiaticeAdminBundle:News');
        $news = $repository->findAll();
        return $this->render('initiaticeAdminBundle:News:index.html.twig', array('news' => $news));
    }

    public function addAction(Request $request)
    {
        $news = new News();

        $form = $this->createFormBuilder($news)
            ->add('title', TextType::class, array('label' => 'Titre'))
            ->add('type', TextType::class, array('label' => 'Type'))
            ->add('abstract', TextType::class, array('label' => 'Résumé'))
            ->add('content', TextareaType::class, array('label' => 'Contenu', 'attr' => array('class' => 'tinymce')))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $news = $form->getData();
            $news->setDateAdd(new \DateTime());
            $news->setDateUpdate(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();

            return $this->redirectToRoute('initiatice_admin_news_index');
        }

        return $this->render('initiaticeAdminBundle:News:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function editAction($id, Request $request)
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('initiaticeAdminBundle:News')
        ;

        // On récupère l'entité correspondante à l'id $id
        $news = $repository->find($id);

        $form = $this->createFormBuilder($news)
            ->add('title', TextType::class, array('label' => 'Titre'))
            ->add('type', TextType::class, array('label' => 'Type'))
            ->add('abstract', TextType::class, array('label' => 'Résumé'))
            ->add('content', TextareaType::class, array('label' => 'Contenu', 'attr' => array('class' => 'tinymce')))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $news = $form->getData();
            $news->setDateUpdate(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();

            return $this->redirectToRoute('initiatice_admin_news_index');
        }

        return $this->render('initiaticeAdminBundle:News:edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function removeAction($id)
    {
        echo $id;
        //TODO: Redirect to index
    }
}
