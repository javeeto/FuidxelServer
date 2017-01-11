<?php

/*
 *  FuidXel is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *  
 *  FuidXel is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  
 *  You should have received a copy of the GNU General Public License
 *  along with FuidXel.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Descripcion del codigo de listaRegistroEscaner
 * 
 * @file listaRegistroEscaner.php
 * @author Javier Lopez Martinez
 * @date 23/09/2016
 * @brief Contiene ...
 */
require_once '../../conexion/idioma/entrada.php';
require_once '../../conexion/constantes.php';
require_once '../../conexion/constanteerror.php';
require_once '../../conexion/conexiondb.php';
require_once '../../administracion/modelo/GestionEscaner.php';
require_once '../../libreria/general/controlador/FuncionesCadena.php';
require_once '../../libreria/general/modelo/BaseGeneral.php';
$conexionmysql = connectionMysqlPDO();
$objbase = new BaseGeneral($conexionmysql);
//$objformulario = new FormularioBase();
$objgestionescaner = new GestionEscaner($objbase);

$listaEscaner = $objgestionescaner->consultarRegistrosEscaner();
$cadenaDatos = "{\n";
$cadenaDatos.='"data": ['."\n";
for ($i = 0; $i < count($listaEscaner); $i++) {
    
    $cadenaDatos.='['."\n";
    $cadenaDatos.='"<a href=\'../../administracion/vista/gestionescaner.php?idescaner=' . $listaEscaner[$i]["idescaner"] . '\' >' . $listaEscaner[$i]["idescaner"] . '</a>",'."\n";
    $cadenaDatos.='"' . $listaEscaner[$i]["nombreescaner"] . '",'."\n";
    $cadenaDatos.='"' . $listaEscaner[$i]["dispositivoescaner"] . '",'."\n";
    $cadenaDatos.='"' . $listaEscaner[$i]["ipescaner"] . '",'."\n";
    $cadenaDatos.='"' . $listaEscaner[$i]["directorioescaner"] . '",'."\n";
    $cadenaDatos.='"' . $listaEscaner[$i]["nombretipoescaner"] . '"'."\n";
    
    if ($i == (count($listaEscaner) - 1)) {
        $cadenaDatos.=']'."\n";
    } else {
        $cadenaDatos.='],'."\n";
    }
    
}
$cadenaDatos.=']'."\n";
$cadenaDatos.='}';

echo $cadenaDatos;