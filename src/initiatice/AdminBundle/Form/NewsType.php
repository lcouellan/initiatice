<?php

namespace initiatice\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $options['entity_manager'];

        $profiles = $em->getRepository('initiaticeAdminBundle:Profile')->findAll();
        $choices = [];
        foreach($profiles as $profile)
            $choices[$profile->getName()] = $profile->getId();

        $builder
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('type', TextType::class, ['label' => 'Type'])
            ->add('profile', ChoiceType::class, [
                'choices' => $choices, 'label' => 'Profile'
            ])
            ->add('abstract', TextType::class, ['label' => 'Résumé'])
            ->add('content', TextareaType::class, ['label' => 'Contenu', 'attr' => ['class' => 'wysiwyg']])
            ->add('externalLink', TextType::class, ['label' => 'Lien externe'])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('entity_manager');
        $resolver->setDefaults(array(
            'data_class' => 'Initiatice\AdminBundle\Entity\News'
        ));
    }
}