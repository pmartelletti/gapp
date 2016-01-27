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
                    'enable', 'checkbox', array(
                        'label' => 'Habilitar',
                        "mapped" => true,
                        'required' => false,
                        'attr' => array(
                            "class" => "celda3",
                            'value'=> 1,
                        )
                    )
                )
                ->add('listado', 'choice', [
                    'choices' => [
                        Document::LISTADO_TECNICA => 'Area Tecnica',
                        Document::LISTADO_COMERCIAL => 'Area Comercial'
                    ],
                    'label' => 'Listado'
                ])
            ;
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