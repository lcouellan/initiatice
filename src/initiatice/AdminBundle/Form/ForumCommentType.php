<?php

namespace initiatice\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Forum comment type for form
 * Class ForumCommentType
 * @package initiatice\AdminBundle\Form
 */
class ForumCommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userId', IntegerType::class, ['label' => 'ID Utilisateur'])
            ->add('questionId', IntegerType::class, ['label' => 'ID Question'])
            ->add('content', TextareaType::class, ['label' => 'Contenu', 'attr' => ['class' => 'materialize-textarea']])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Initiatice\AdminBundle\Entity\ForumComment'
        ));
    }
}