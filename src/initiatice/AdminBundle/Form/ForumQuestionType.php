<?php

namespace initiatice\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Forum question type for form
 * Class ForumQuestionType
 * @package initiatice\AdminBundle\Form
 */
class ForumQuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userId', IntegerType::class, ['label' => 'ID Utilisateur'])
            ->add('title', TextType::class, ['label' => 'Title'])
            ->add('content', TextareaType::class, ['label' => 'Contenu', 'attr' => ['class' => 'materialize-textarea']])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Initiatice\AdminBundle\Entity\ForumQuestion'
        ));
    }
}