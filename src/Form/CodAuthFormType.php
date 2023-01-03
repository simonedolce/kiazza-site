<?php

namespace App\Form;

use App\Entity\CodAuth;
use App\Entity\Ruolo;
use App\Repository\RuoloRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class CodAuthFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codice', TextType::class,[
                'attr' => ['class' => 'input']
                ]
    )
            ->add('usernameProvvisorio',TextType::class,[
                'attr' => ['class' => 'input']
            ])
            ->add('ruolo', EntityType::class, [
                'class' => Ruolo::class,
                'choice_label' => 'roleName',
                'choice_value' => 'systemRoleName',
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function (RuoloRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.roleName', 'ASC');
                },
                'attr' => ['class' => 'input'],
            ])
            ->add('aggiungiUtente', SubmitType::class, [
                'attr' => ['class' => 'button is-primary', 'id' => 'add-cod-auth']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CodAuth::class,
        ]);
    }
}
