<?php

namespace App\Form;

use App\Entity\BannerProfilo;
use App\Entity\Immagine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BannerProfiloType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var BannerProfilo $bannerProfilo */
        $bannerProfilo = $options['data'];

        $builder->add('idImmagine', ImmagineFormType::class, [
            'data' => is_object($bannerProfilo) ? $bannerProfilo->getIdImmagine() : new Immagine()
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BannerProfilo::class,
        ]);
    }
}
