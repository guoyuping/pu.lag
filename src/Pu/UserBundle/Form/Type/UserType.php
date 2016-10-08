<?php 
namespace Pu\UserBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Doctrine\Bundle\MongoDBBundle\Form\Type\DocumentType;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("username",TextType::class)
        	->add("password",RepeatedType::class,array(
        		'first_name'=>"password",
        		'second_name'=>'confirm',
        		'type'=>PasswordType::class
        	))
    	// ->add('roles', DocumentType::class,[
         //        'class'=>'PuUserBundle:Role',
         //        'choice_label'=>'name',
         //        'expanded'=>true,
         //        'multiple'=>true,
         //        'required'=>false
              
         //    ])
        	;

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pu\UserBundle\Document\User',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user';
    }
}