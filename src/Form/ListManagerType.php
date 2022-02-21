<?php

namespace App\Form;

use App\Entity\ListManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListManagerType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add("name", TextType::class, ["label"=>"Nom de la liste"])
        ->add("color", ColorType::class, ["label"=>"Couleur de la liste"]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class"=> ListManager::class
        ]);
    }

}