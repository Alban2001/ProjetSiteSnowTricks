<?php

namespace App\Form;

use App\Entity\Groupe;
use App\Entity\Trick;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickType extends AbstractType
{
    // Création d'un formulaire pour l'ajout d'un trick
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
            ->add(
                'slug',
                HiddenType::class,
                [
                    'error_bubbling' => false
                ]
            )
            ->add('description')
            ->add(
                'imagePrincipale',
                FileType::class,
                [
                    'label' => 'Image principale',
                    'required' => !$options['update']
                ]
            )
            ->add(
                'videoPrincipale',
                TextType::class,
                [
                    'label' => 'Vidéo principale',
                    'required' => !$options['update']
                ]
            )
            ->add(
                'illustrations',
                CollectionType::class,
                [
                    'entry_type' => IllustrationType::class,
                    'allow_add' => true,
                    'entry_options' => [
                        'label' => false,
                        'mapped' => !$options['update']
                    ]
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
            ->add('Ajouter', SubmitType::class, ['label' => $options['submitLabel'], 'attr' => ['class' => 'btn btn-primary mb-5 w-100']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
            'update' => false,
            'submitLabel' => 'Ajouter',
            'validation_groups' => function (FormInterface $form) {
                $data = $form->getData();

                if ($data->getImagePrincipale() == '' && $form->getConfig()->getOption('update')) {
                    return ['Default'];
                }

                return ['Default', 'Update'];
            },
        ]);
    }
}
