<?php 

namespace Pu\UserBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RoleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name',TextType::class,[
                'label'=>'名称',
                'attr'=>array(
                    'class'=>'form-400'
                    )
            ])
    		->add('role',TextType::class,[
                'label'=>'权限',
                'attr'=>array(
                    'class'=>'form-400'
                    )

            ])
    		;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pu\UserBundle\Document\Role',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'role';
    }
}