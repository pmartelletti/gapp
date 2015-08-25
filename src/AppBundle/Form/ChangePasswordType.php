<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Entity\User;

class ChangePasswordType extends AbstractType {

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add(
                    'firstname', 'text', array(
                        'label' => 'Nombre',
                        "mapped" => true,
                        'required' => true,
                        'attr' => array(
                            "class" => "celda3",
                            "maxlength" => 32, //Longitud máxima
                        )
                    )
                )->add(
                    'lastname', 'text', array(
                        'label' => 'Apellido',
                        "mapped" => true,
                        'attr' => array(
                            "class" => "celda3",
                            "maxlength" => 32 //Longitud máxima
                        )
                    )
                )->add('password', 'repeated', array(
                        'type' => 'password',
                        'invalid_message' => 'Los campos de contraseña deben coincidir.',
                        'options' => array('attr' => array('class' => 'password-field')),
                        'required' => FALSE,
                        'first_options'  => array('label' => 'Password'),
                        'second_options' => array('label' => 'Repeat Password'),
                    ));
    }    
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // una clave única para ayudar generar el token
            'intention'       => 'task_item',
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'change_password_appbundle';
    }
}