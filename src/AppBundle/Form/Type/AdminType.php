<?php 
namespace AppBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Doctrine\Bundle\MongoDBBundle\Form\Type\DocumentType;


class AdminType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("username",TextType::class,[
                'label'=>false,
                'attr'=>array('placeholder'=>"用户名/邮箱",'class'=>'form-400')

            ])
            ->add("password",RepeatedType::class,array(
                'first_name'=>"password",
                'second_name'=>'confirm',
                'options'=>array('label'=>false),
                'first_options'=>array('attr'=>array('placeholder'=>"请输入密码",'class'=>'form-400')),
                'second_options'=>array('attr'=>array('placeholder'=>"再次输入密码",'class'=>'form-400')),
                'type'=>PasswordType::class
            ))
            ->add('roles', DocumentType::class,[
                'label'=>'权限',

                'class'=>'AppBundle:Role',
                'choice_label'=>'name',
                'expanded'=>true,
                'multiple'=>true,
                'required'=>false
              
            ])
            ;

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Document\User',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'admin';
    }
}