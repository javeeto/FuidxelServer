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
 * Descripcion del codigo de controlGestionDigitaliza
 * 
 * @file controlGestionDigitaliza.php
 * @author Javier Lopez Martinez
 * @date 28/09/2016
 * @brief Contiene ...
 */
require_once '../../conexion/idioma/entrada.php';
require_once '../../conexion/constantes.php';
require_once '../../conexion/constanteerror.php';
require_once '../../conexion/conexiondb.php';
require_once '../../administracion/modelo/GestionEscaner.php';
require_once '../../libreria/general/controlador/FuncionesCadena.php';
require_once '../../libreria/general/modelo/BaseGeneral.php';
require_once '../../administracion/modelo/GestionUsuario.php';

$conexionmysql = connectionMysqlPDO();
$objbase = new BaseGeneral($conexionmysql);
$objescaner = new GestionEscaner($objbase);
$objusuario = new GestionUsuario($_SESSION["s_nombreusuario"], $objbase);
$datosusuario = $objusuario->consultaDatosUsuario();
$objescaner->setIdEscaner($datosusuario["idescaner"]);
$datosescaner = $objescaner->consultarRegistrosEscaner();
$opcionesescaner = $objescaner->consultaOpcionesEscaner();

if (isset($_GET["idlote"]) &&
        trim($_GET["idlote"]) != '') {
    $urlremota = "http://" . $datosescaner[0]["ipescaner"] . URLREMOTAESCANER . "?idlote=" . $_GET["idlote"] . "&usuario=" . $_SESSION["s_nombreusuario"] . "&idescaner=" . $datosescaner[0]["idescaner"];
} else {
    $urlremota = "http://" . $datosescaner[0]["ipescaner"] . URLREMOTAESCANER . "?usuario=" . $_SESSION["s_nombreusuario"] . "&idescaner=" . $datosescaner[0]["idescaner"];
}
//$urlremota="../../clientedigitaliza/vista/redireccionaMarco.php?idescaner=".$datosusuario["idescaner"];
?>
