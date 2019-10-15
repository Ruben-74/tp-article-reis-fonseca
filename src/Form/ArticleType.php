<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class ArticleType extends AbstractType
{

    public function getConfiguration($label, $placeholder, $options = []){
        return array_merge(['label' => $label,
            'attr' =>[
                'placeholder' => $placeholder
            ]
        ], $options);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle',TextType::class, $this->getConfiguration("libelle" ,"Tapez un super titre pour votre article"))
            ->add('prix', MoneyType::class, $this->getConfiguration("Prix","Indiquez le prix que vous voulez pour votre article"))
            ->add('description',TextType::class, $this->getConfiguration("Description" , "Donnez une description global de l'article"))
            ->add('image', TextType::class, $this->getConfiguration("Image" , "Une image pour representer votre article"));
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
