<?php

namespace App\Form;

use App\Entity\Avatar;
use App\Entity\Immagine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AvatarFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var Avatar $avatar */
        $avatar = $options['data'];

        $builder->add('idImmagine', ImmagineFormType::class, [
                'data' => $avatar ? $avatar->getIdImmagine() : new Immagine()
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Avatar::class,
        ]);
    }
}
