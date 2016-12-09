<?php

namespace initiatice\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('type', TextType::class, ['label' => 'Type'])
            ->add('abstract', TextType::class, ['label' => 'Résumé'])
            ->add('place', TextType::class, ['label' => 'Lieu de l\'événement'])
            ->add('dateStart', DateType::class, [
                'widget' => 'single_text',
				// add a class that can be selected in JavaScript
                'label' => 'Date de l\'événement'
            ])
            ->add('content', TextareaType::class, ['label' => 'Contenu', 'attr' => ['class' => 'wysiwyg']])
            ->add('externalLink', TextType::class, ['label' => 'Lien externe'])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Initiatice\AdminBundle\Entity\Event'
        ));
    }
}
