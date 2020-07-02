<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Positive;


class ProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'constraints'=>[
                    new NotBlank(['message'=>'Veuillez entrer un nom pour le produit']),
                    new Length(['max'=>100,'maxMessage'=>'Le nom ne doit pas dépasser 100 caractères'])
                ]
            ])
            ->add('description',TextareaType::class,[
                'required'=>false
            ])
            ->add('price',MoneyType::class,[
                'divisor' => 100, //permet de convertir de base entrée en valeur commune car on rentre le prix en centimes à cause de la bdd qui veut des valeurs entières
                'constraints'=>[
                    new NotBlank(['message'=>'Entrez un prix svp']),
                    new Positive(['message'=>'Le prix doit être positif']),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
