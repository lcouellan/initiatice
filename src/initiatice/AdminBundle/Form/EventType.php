<?php

namespace initiatice\AdminBundle\Form;

use Doctrine\DBAL\Types\FloatType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Event type for forms
 * Class EventType
 * @package initiatice\AdminBundle\Form
 */
class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('type', TextType::class, ['label' => 'Type'])
            ->add('abstract', TextType::class, ['label' => 'Résumé'])
            ->add('place', TextType::class, ['label' => 'Lieu de l\'événement'])
            ->add('longitude', NumberType::class, ['label' => 'Longitude', 'required' => false ])
            ->add('latitude', NumberType::class, ['label' => 'Latitude', 'required' => false ])
            ->add('contentImage', TextType::class, array('label' => 'Image'))
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
