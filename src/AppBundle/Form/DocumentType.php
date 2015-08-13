<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Entity\Document;

class DocumentType extends AbstractType {
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add(
                    'name', 'text', array(
                        'label' => 'Título',
                        "mapped" => true,
                        'required' => true,
                        'attr' => array(
                            "class" => "celda3",
                            "maxlength" => 32, //Longitud máxima
                        )
                    )
                )
                ->add(
                    'file', 'file', array(
                        'label' => 'Documento',
                        "mapped" => true,
                        'required' => true,
                        'attr' => array(
                            "class" => "celda3",
                        )
                    )
                );
    }    
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Document',
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
        return 'document_appbundle_document';
    }

}