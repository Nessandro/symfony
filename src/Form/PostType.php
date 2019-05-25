<?php
/**
 * Class PostType
 * User: Nessandro
 * Date: 2019-05-25
 * Time: 11:47
 * @package App\Form
 */

namespace App\Form;


use App\Entity\Comment;
use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['attr' => ['placeholder' => 'Title']])
            ->add('content', TextareaType::class, ['attr' => ['placeholder' => 'Provide your text here']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}