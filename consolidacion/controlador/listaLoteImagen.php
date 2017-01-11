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
 * Descripcion del codigo de listaLoteImagen
 * 
 * @file listaLoteImagen.php
 * @author Javier Lopez Martinez
 * @date 24/10/2016
 * @brief Contiene ...
 */
require_once '../../conexion/idioma/entrada.php';
require_once '../../conexion/constantes.php';
require_once '../../conexion/constanteerror.php';
require_once '../../conexion/conexiondb.php';
require_once '../../administracion/modelo/GestionUsuario.php';
require_once '../../administracion/modelo/GestionGrupoUsuario.php';
require_once '../../clientedigitaliza/modelo/GestionLoteImagen.php';
require_once '../../libreria/general/controlador/FuncionesCadena.php';
require_once '../../libreria/general/modelo/BaseGeneral.php';
$conexionmysql = connectionMysqlPDO();
$objbase = new BaseGeneral($conexionmysql);
//$objformulario = new FormularioBase();
$objgestionusuario = new GestionUsuario($_SESSION["s_nombreusuario"], $objbase);
//$objgestionusuario->debug();
$datosusuario = $objgestionusuario->consultaDatosUsuario();



$objgrupousuario = new GestionGrupoUsuario($objbase);
$objgrupousuario->setIdGrupoUsuario($datosusuario["idgrupousuario"]);
//$objgrupousuario->debug();
$datosgrupousuario = $objgrupousuario->consultaGrupoUsuario();

$objgestionlote = new GestionLoteImagen($objbase);
$objgestionlote->setDatosGrupoUsuario($datosgrupousuario[0]);
//$objgestionlote->debug();
$listalote = $objgestionlote->consultaLotesEscaneo();
/*echo "listalote<pre>";
print_r($listalote);
echo "<pre>";*/
for ($i = 0; $i < count($listalote); $i++) {

    $urlremota="../../consolidacion/vista/documentogrupoindexa.php?idloteimagen=".$listalote[$i]["idloteimagen"];
    $nombrepersona=$listalote[$i]["nombrepersona"]."".$listalote[$i]["apellidopersona"];
    $datoslote["data"][$i][] = '<a href=\''.$urlremota. '\' >' . $listalote[$i]["idloteimagen"] . '</a>';
    $datoslote["data"][$i][] = $listalote[$i]["fechainicioloteimagen"];
    $datoslote["data"][$i][] = $listalote[$i]["totalloteimagen"];
    $datoslote["data"][$i][] = $listalote[$i]["totaldocumentoloteimagen"];
    $datoslote["data"][$i][] = $listalote[$i]["nombreestadoloteimagen"];
    $datoslote["data"][$i][] = $listalote[$i]["nombregrupousuario"];
    $datoslote["data"][$i][] = $nombrepersona;
}
$stringjson = json_encode($datoslote);
echo $stringjson;
