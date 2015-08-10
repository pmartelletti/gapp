<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Entity\User;
use AppBundle\Utils\Commons;

class UserType extends AbstractType {

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add(
                    'firstname', 'text', array(
                        'label' => 'Nombre',
                        "mapped" => true,
                        'required' => true,
                        'attr' => array(
                            "class" => "celda3",
                            "maxlength" => 32, //Longitud máxima
                        )
                    )
                )
                ->add(
                    'lastname', 'text', array(
                        'label' => 'Apellido',
                        "mapped" => true,
                        'attr' => array(
                            "class" => "celda3",
                            "maxlength" => 32 //Longitud máxima
                        )
                    )
                )
                ->add(
                    'company', 'text', array(
                        'label' => 'Empresa',
                        "mapped" => true,
                        'attr' => array(
                            "class" => "celda3",
                            "maxlength" => 32 //Longitud máxima
                        )
                    )
                )
                ->add(
                    'address', 'text', array(
                        'label' => 'Domicilio',
                        "mapped" => true,
                        'attr' => array(
                            "class" => "celda3",
                            "maxlength" => 32 //Longitud máxima
                        )
                    )
                )
                ->add(
                    'locality', 'text', array(
                        'label' => 'Localidad',
                        "mapped" => true,
                        'attr' => array(
                            "class" => "celda3",
                            "maxlength" => 32 //Longitud máxima
                        )
                    )
                )
                ->add(
                    'province', 'choice', array(
                        'label' => 'Provincia',
                        'choices'   => Commons::getArrayProvince(),
                        "mapped" => true,
                        'attr' => array(
                            "class" => "celda3",
                            "maxlength" => 32 //Longitud máxima
                        )
                    )
                )
                ->add(
                    'zona', 'choice', array(
                        'label' => 'Zona',
                        'choices'   => Commons::getArrayZona(),
                        "mapped" => true,
                        'attr' => array(
                            "class" => "celda3",
                            "maxlength" => 32 //Longitud máxima
                        )
                    )
                )
                ->add(
                    'phone', 'text', array(
                        'label' => 'Teléfono',
                        'attr' => array(
                            "class" => "celda3 phoneNumber",
                            "maxlength" => 32, //Longitud máxima
                            "onkeypress" => "return isNumericInteger(event)"
                        )
                    )
                )
                ->add(
                    'email', 'email', array(
                        'label' => 'E-mail',
                        'attr' => array(
                            "class" => "celda3 login-input wv-tooltip unique-field",
                            "id" => "signupEmail"
                        )
                    )
                )
                ->add(
                    'web', 'text', array(
                        'label' => 'Web',
                        "mapped" => true,
                        'attr' => array(
                            "class" => "celda3 UrlType",
                            "maxlength" => 32 //Longitud máxima
                        )
                    )
                )
                ->add(
                    'types', 'choice', array(
                        'label' => 'Tipo',
                        'choices'   => Commons::getArrayType(),
                        "mapped" => true,
                        'attr' => array(
                            "class" => "celda3",
                            "maxlength" => 32 //Longitud máxima
                        )
                    )
                )
                ->add(
                    'activity', 'text', array(
                        'label' => 'Actividad',
                        "mapped" => true,
                        'attr' => array(
                            "class" => "celda3",
                            "maxlength" => 32 //Longitud máxima
                        )
                    )
                );
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
        return 'user_appbundle_user';
    }

}
