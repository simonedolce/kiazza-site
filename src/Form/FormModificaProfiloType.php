<?php

namespace App\Form;

use App\Entity\Avatar;
use App\Entity\BannerProfilo;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormModificaProfiloType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        /** @var User $user */
        $user = $options['data'];

        $builder
            ->add('bannerProfilo', BannerProfiloType::class, [
                'data' => $user->getBannerProfilo(),
                'required' => false
            ])
            ->add('avatar', AvatarFormType::class, [
                'data' => $user->getAvatar(),
                'required' => false
            ])
            ->add('nomeArtista', TextType::class, [
                'attr' => [
                    'class' => 'input modifica-profilo-input'
                ],
                'data' => $user->getNomeArtista(),
                'label' => 'Nome Artista:'
            ])
            ->add('contattoFacebook', TextType::class, [
                'attr' => [
                    'class' => 'input modifica-profilo-input'
                ],
                'data' => $user->getContattoFacebook(),
                'label' => 'Contatto Facebook'
            ])
            ->add('contattoInstagram', TextType::class, [
                'attr' => [
                    'class' => 'input modifica-profilo-input'
                ],
                'data' => $user->getContattoInstagram(),
                'label' => 'Contatto Instagram:'
            ])
            ->add('contattoEmail', TextType::class, [
                'attr' => [
                    'class' => 'input modifica-profilo-input',
                    'type' => 'email'
                ],
                'data' => $user->getContattoEmail(),
                'label' => 'Email:'
            ])
            ->add('bio', TextareaType::class, [
                'attr' => [
                    'class' => 'textarea' , 'placeholder'
                ],
                'data' => $user->getBio()
            ])
            ->add('videoYoutube', TextType::class, [
                'attr' => [
                    'class' => 'input modifica-profilo-input',
                    'type' => 'text'
                ],
                'data' => $user->getVideoYoutube(),
                'label' => 'Email:'
            ])
            ->add('idSpotify', TextType::class, [
                'attr' => [
                    'class' => 'input modifica-profilo-input',
                    'type' => 'text',
                    'id' => 'id-spotify'
                ],
                'data' => $user->getIdSpotify(),
                'label' => 'Id account Spotify:'
            ])
            ->add('Salva', SubmitType::class, [
                'attr' => ['class' => 'button is-primary']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
