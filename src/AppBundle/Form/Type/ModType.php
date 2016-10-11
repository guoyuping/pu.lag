<?php 
namespace AppBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ModType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("name",TextType::class,
            [
                'label'=>'模块名',
                'attr'=>array('class'=>'form-400')
            ])
            // ->add("params",TextType::class,[
            //     'allow_extra_fields'=>true
            //     ])
            
            ->add("type",TextType::class,
            [
                'label'=>'类型',
                'attr'=>array('class'=>'form-400')
            ])
            ->add("uniqueName",TextType::class,
            [
                'label'=>'唯一标识符',
                'attr'=>array('class'=>'form-400')
            ])
            ->add("isDeleted",null,
            [
                'label'=>'删除',
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
            'data_class' => 'AppBundle\Document\Mod',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'mod';
    }
}