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
 * Descripcion del codigo de listaRegistroConfiguracion
 * 
 * @file listaRegistroConfiguracion.php
 * @author Javier Lopez Martinez
 * @date 25/10/2016
 * @brief Contiene ...
 */
require_once '../../conexion/idioma/entrada.php';
require_once '../../conexion/constantes.php';
require_once '../../conexion/constanteerror.php';
require_once '../../conexion/conexiondb.php';
require_once '../../administracion/modelo/GestionConfiguracion.php';
require_once '../../libreria/general/controlador/FuncionesCadena.php';
require_once '../../libreria/general/modelo/BaseGeneral.php';
$conexionmysql = connectionMysqlPDO();
$objbase = new BaseGeneral($conexionmysql);
//$objformulario = new FormularioBase();
$objgestionconfiguracion = new GestionConfiguracion($objbase);

$listaConfiguracion = $objgestionconfiguracion->consultarRegistrosConfiguracion();
$cadenaDatos = "{\n";
$cadenaDatos.='"data": ['."\n";
for ($i = 0; $i < count($listaConfiguracion); $i++) {
    
    $cadenaDatos.='['."\n";
    $cadenaDatos.='"<a href=\'../../administracion/vista/gestionconfiguracion.php?idconfiguracion=' . $listaConfiguracion[$i]["idconfiguracion"] . '\' >' . $listaConfiguracion[$i]["idconfiguracion"] . '</a>",'."\n";
    $cadenaDatos.='"' . $listaConfiguracion[$i]["nombreconfiguracion"] . '",'."\n";
    $cadenaDatos.='"' . $listaConfiguracion[$i]["nombrecortoconfiguracion"] . '",'."\n";
    $cadenaDatos.='"' . $listaConfiguracion[$i]["fechaconfiguracion"] . '",'."\n";
    $cadenaDatos.='"' . $listaConfiguracion[$i]["nombreestado"] . '"'."\n";
    
    if ($i == (count($listaConfiguracion) - 1)) {
        $cadenaDatos.=']'."\n";
    } else {
        $cadenaDatos.='],'."\n";
    }
    
}
$cadenaDatos.=']'."\n";
$cadenaDatos.='}';

echo $cadenaDatos;