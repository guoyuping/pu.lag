<?php 
namespace Pu\UserBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Pu\UserBundle\Form\Type\UserType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class RegistrationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('user',UserType::class)
        		->add('terms',CheckboxType::class,array(
        			'property_path' => 'termsAccepted',
        			'required'=>false
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