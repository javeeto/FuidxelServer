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
 * Descripcion del codigo de listaRegistroGrupoUsuario
 * 
 * @file listaRegistroGrupoUsuario.php
 * @author Javier Lopez Martinez
 * @date 11/10/2016
 * @brief Contiene ...
 */
require_once '../../conexion/idioma/entrada.php';
require_once '../../conexion/constantes.php';
require_once '../../conexion/constanteerror.php';
require_once '../../conexion/conexiondb.php';
require_once '../../administracion/modelo/GestionGrupoUsuario.php';
require_once '../../libreria/general/controlador/FuncionesCadena.php';
require_once '../../libreria/general/modelo/BaseGeneral.php';
$conexionmysql = connectionMysqlPDO();
$objbase = new BaseGeneral($conexionmysql);
//$objformulario = new FormularioBase();
$objgestiongrupo = new GestionGrupoUsuario($objbase);

$listagrupousuario = $objgestiongrupo->consultaGrupoUsuario();
for ($i = 0; $i < count($listagrupousuario); $i++) {
    
    $datosgrupousuario["data"][$i][]='<a href=\'../../administracion/vista/gestiongrupousuario.php?idgrupousuario=' . $listagrupousuario[$i]["idgrupousuario"]. '\' >' . $listagrupousuario[$i]["idgrupousuario"]. '</a>';
    $datosgrupousuario["data"][$i][]=$listagrupousuario[$i]["nombregrupousuario"];
    $datosgrupousuario["data"][$i][]=$listagrupousuario[$i]["nombretipogrupousuario"];
    $datosgrupousuario["data"][$i][]=$listagrupousuario[$i]["nombreescaner"];
    $datosgrupousuario["data"][$i][]=$listagrupousuario[$i]["nombreestado"];
   
        
}
$stringjson=  json_encode($datosgrupousuario);
echo $stringjson;