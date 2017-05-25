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
            ->add('text',null, array('label' => 'Вміст повідомлення'))
            ->add('endDate',  'choice', array(
                'choices' => array(
                    1 => 'Один день',
                    7 => 'Тиждень',
                    30 => 'Місяць',
                    null => 'Після перегляду',
                ),
                'label' => 'Записка самознищиться',
                'attr' => array('class' => 'endDate') ))

            ->add('password','repeated', array(
    'type' => 'password',
    'invalid_message' => 'Паролі не співпадають',
    'options' => array('attr' => array('class' => 'password')),
    'required' => false,
    'first_options'  => array('label' => 'Пароль'),
    'second_options' => array('label' => 'Повторити пароль', 'attr' => array('onchange' => 'checkPass ()'))))

            ->add('email','email',array('label' => 'Отримати сповіщення про прочитування записки по e-mail', 'attr' => array('class'=>'email'),'required' => false))
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
