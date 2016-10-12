<?php 
namespace AppBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
class TplType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("name",TextType::class,
            [
                'label'=>'模板名',
                'attr'=>array('class'=>'form-200')
            ])
            ->add("description",TextareaType::class,[
                'label'=>'说明',
                'allow_extra_fields'=>true
            ])
            ->add("type",TextType::class,
            [
                'label'=>'类型',
                'attr'=>array('class'=>'form-200')
            ])
            ->add("param",TextareaType::class,
            [
                'label'=>false,
                'attr'=>array('class'=>'hide'),
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
            'data_class' => 'AppBundle\Document\Tpl',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'tpl';
    }
}