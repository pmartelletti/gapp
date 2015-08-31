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
    public static function getArrayProvince($value_null = 'Seleccionar Provincia')
    {
        $province = ['' => $value_null,
            'buenos-aires' => 'Buenos Aires',
            'catamarca' => 'Catamarca',
            'chaco' => 'Chaco',
            'chubut' => 'Chubut',
            'cordoba' => 'Córdoba',
            'corrientes' => 'Corrientes',
            'entre-rios' => 'Entre Ríos',
            'formosa' => 'Formosa',
            'jujuy' => 'Jujuy',
            'la-pampa' => 'La Pampa',
            'la-rioja' => 'La Rioja',
            'mendoza' => 'Mendoza',
            'misiones' => 'Misiones',
            'neuquen' => 'Neuquén',
            'rio-negro' => 'Río Negro',
            'salta' => 'Salta',
            'san-juan' => 'San Juan',
            'san-luis' => 'San Luis',
            'santa-cruz' => 'Santa Cruz',
            'santa-fe' => 'Santa Fe',
            'santiago-del-estero' => 'Santiago del Estero',
            'tierra-del-fuego' => 'Tierra del Fuego',
            'tucuman' => 'Tucumán',];

        return $province;
    }

    /*
     * 
     */
    public static function getArrayZona($value_null = 'Seleccionar Zona')
    {
        $zona = [
            '' => $value_null,
            'Cuyo' => 'Cuyo',
            'Patagonia' => 'Patagonia',
            'Noroeste' => 'Noroeste',
            'Litoral' => 'Litoral'
        ];

        return $zona;
    }

    /*
     * 
     */
    public static function getArrayType($value_null = '')
    {
        $type = [];

        if ($value_null != '') {
            $type[''] = $value_null;
        }

        $type += ['cliente' => 'Cliente',
            'distribuidor' => 'Distribuidor',
            'redistribuidor' => 'Redistribuidor',
            'otro' => 'Otro'];

        return $type;
    }

    /**
     *
     * @param string $type_doc
     * @return string
     */
    public static function getImgByTypeDoc($type_doc)
    {
        switch ($type_doc) {
            case 'pdf':
                $imag = 'ico-pdf.gif';
                break;
            case 'doc':
                $imag = 'ico-word.gif';
                break;
            case 'docx':
                $imag = 'ico-word.gif';
                break;
            case 'jpeg':
                $imag = 'ico-ima.gif';
                break;
            case 'jpg':
                $imag = 'ico-ima.gif';
                break;
            case 'png':
                $imag = 'ico-ima.gif';
                break;
            case 'xls':
                $imag = 'ico-excel.gif';
                break;
            case 'xlsx':
                $imag = 'ico-excel.gif';
                break;
            default:
                $imag = 'ico-txt.gif';
                break;
        }

        return $imag;
    }
}
