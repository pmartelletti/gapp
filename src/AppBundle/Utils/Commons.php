<?php

namespace AppBundle\Utils;

/**
 * Common funtions
 */
class Commons
{
    /*
     * 
     */
    public static function getArrayProvince()
    {
        $province = [''=>'Seleccionar Provincia',
            'buenos-aires'=>'Buenos Aires',
            'catamarca'=>'Catamarca',
            'chaco'=>'Chaco',
            'chubut'=>'Chubut',
            'cordoba'=>'Córdoba',
            'corrientes'=>'Corrientes',
            'entre-rios'=>'Entre Ríos',
            'formosa'=>'Formosa',
            'jujuy'=>'Jujuy',
            'la-pampa'=>'La Pampa',
            'la-rioja'=>'La Rioja',
            'mendoza'=>'Mendoza',
            'misiones'=>'Misiones',
            'neuquen'=>'Neuquén',
            'rio-negro'=>'Río Negro',
            'salta'=>'Salta',
            'san-juan'=>'San Juan',
            'san-luis'=>'San Luis',
            'santa-cruz'=>'Santa Cruz',
            'santa-fe'=>'Santa Fe',
            'santiago-del-estero'=>'Santiago del Estero',
            'tierra-del-fuego'=>'Tierra del Fuego',
            'tucuman'=>'Tucumán',];
        
        return $province;
    }

    /*
     * 
     */
    public static function getArrayZona()
    {
        $zona = [''=>'Seleccionar Zona',
                 'x'=>'x',];
        
        return $zona;
    }      
    
    /*
     * 
     */
    public static function getArrayType()
    {
        $type = ['cliente'=>'Cliente',
                 'distribuidor'=>'Distribuidor',
                 'redistribuidor'=>'Redistribuidor',
                 'otro'=>'Otro'];
        
        return $type;
    }
}
