<?php

namespace App\Form;

use App\Entity\Groupe;
use App\Entity\Illustration;
use App\Entity\Trick;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\File;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'nom',
                TextType::class,
                [
                    'label' => 'Nom du trick'
                ]
            )
            ->add('description')
            ->add(
                'imagePrincipale',
                FileType::class,
                [
                    'label' => 'Image principale'
                ]
            )
            ->add(
                'videoPrincipale',
                TextType::class,
                [
                    'label' => 'Vidéo principale'
                ]
            )
            ->add(
                'illustrations',
                CollectionType::class,
                [
                    'entry_type' => IllustrationType::class,
                    'allow_add' => true,
                    'entry_options' => ['label' => false]
                ]
            )
            ->add(
                'videos',
                CollectionType::class,
                [
                    'entry_type' => VideoType::class,
                    'allow_add' => true,
                    'entry_options' => ['label' => false]
                ]
            )
            ->add('groupe', EntityType::class, [
                'class' => Groupe::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('g')
                        ->orderBy('g.nom', 'ASC');
                },
                'choice_label' => 'nom',
            ])
            ->add('Ajouter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
