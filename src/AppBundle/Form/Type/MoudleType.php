<?php 
namespace AppBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use AppBundle\Form\Type\ModType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MoudleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('mod',ModType::class,array(
                'label'=>false,
            ))
    		->add('params',CollectionType::class,array(
    			'required'=>false,
                'entry_type'=>TextType::class,
                'label'=>false,
                'allow_add'    => true,
                'allow_delete' => true,
			));
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'moudle';
    }
}
