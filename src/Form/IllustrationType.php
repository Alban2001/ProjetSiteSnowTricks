<?php

namespace App\Form;

use App\Entity\Illustration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class IllustrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'nom',
                FileType::class,
                array(
                    'label' => 'Image',
                    'required' => false,
                    'constraints' => [
                        new File([
                            'mimeTypes' => [
                                'image/jpg',
                                'image/jpeg',
                                'image/png',
                            ],
                            'mimeTypesMessage' => 'Veuillez sélectionner une image valide (png ou jpg)',
                        ])
                    ],
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Illustration::class,
        ]);
    }
}
