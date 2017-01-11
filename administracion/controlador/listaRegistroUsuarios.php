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
 * Descripcion del codigo de listaRegistroUsuarios
 * 
 * @file listaRegistroUsuarios.php
 * @author Javier Lopez Martinez
 * @date 6/10/2016
 * @brief Contiene ...
 */
require_once '../../conexion/idioma/entrada.php';
require_once '../../conexion/constantes.php';
require_once '../../conexion/constanteerror.php';
require_once '../../conexion/conexiondb.php';
require_once '../../administracion/modelo/GestionUsuario.php';
require_once '../../libreria/general/controlador/FuncionesCadena.php';
require_once '../../libreria/general/modelo/BaseGeneral.php';
$conexionmysql = connectionMysqlPDO();
$objbase = new BaseGeneral($conexionmysql);
//$objformulario = new FormularioBase();
$objgestionescaner = new GestionUsuario("",$objbase);

$listausuario = $objgestionescaner->consultarRegistrosUsuario();
for ($i = 0; $i < count($listausuario); $i++) {
    
    $datosusuario["data"][$i][]='<a href=\'../../administracion/vista/gestionusuarios.php?idusuario=' . $listausuario[$i]["idusuario"]. '\' >' . $listausuario[$i]["idusuario"]. '</a>';
    $datosusuario["data"][$i][]=$listausuario[$i]["nombreusuario"];
    $datosusuario["data"][$i][]=$listausuario[$i]["nombrepersona"]." ".$listausuario[$i]["apellidopersona"];
    $datosusuario["data"][$i][]=$listausuario[$i]["nombreperfil"];
    $datosusuario["data"][$i][]=$listausuario[$i]["nombregrupousuario"];
    $datosusuario["data"][$i][]=$listausuario[$i]["nombreestado"];
        
}
$stringjson=  json_encode($datosusuario);
echo $stringjson;