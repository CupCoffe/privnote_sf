<?php

namespace PrivlinkBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class privlinkType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text',TextareaType::class,array('label' => 'Вміст повідомлення', 'attr' => array('class' => 'text_area')))
            ->add('endDate',  'choice', array(
                'choices' => array(
                    1 => 'Один день',
                    7 => 'Тиждень',
                    30 => 'Місяць',
                    null => 'Після перегляду',
                ),
                'label' => 'Записка самознищиться',
                'attr' => array('class' => 'endDate') ))
            ->add('password',null,array('label' => 'Пароль', 'attr' => array('class' => 'password')))
            ->add('email',null,array('label' => 'Отримати сповіщення про прочитування записки по e-mail', 'attr' => array('class'=>'email')))
            ->add('checkbox',null,array('label' => 'Не питати про підтверждення перш ніж показати та знищити повідомлення.'));
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
