<?php

namespace PrivlinkBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class privlinkType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('text')->add('password')->add('endDate',  'choice', array(
            'choices' => array(
                1 => 'Один день',
                7 => 'Тиждень',
                30 => 'Місяць',
                null => 'Видалити після перегляду',
            )));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PrivlinkBundle\Entity\privlink'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'privlinkbundle_privlink';
    }


}
