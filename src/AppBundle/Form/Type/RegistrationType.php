<?php 
namespace AppBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use AppBundle\Form\Type\UserType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class RegistrationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('user',UserType::class,array(
                'label'=>'用户注册',
                'label_attr'=>array('class'=>'title')
            ))
    		->add('terms',CheckboxType::class,array(
    			'property_path' => 'termsAccepted',
    			'required'=>false,
                'label'=>'同意用户协议',
                'data'=>true
			));
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'registration';
    }
}
