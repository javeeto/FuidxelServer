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
 * Descripcion del codigo de controlSesionDigitaliza
 * 
 * @file controlSesionDigitaliza.php
 * @author Javier Lopez Martinez
 * @date 29/09/2016
 * @brief Contiene ...
 * 
 */
session_start();


$_SESSION["s_nombreusuario"] = $_GET["usuario"];
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
$objusuario = new GestionUsuario($_GET["usuario"], $objbase);
$datosusuario = $objusuario->consultaDatosUsuario();
$objescaner->setIdEscaner($datosusuario["idescaner"]);
$datosescaner = $objescaner->consultarRegistrosEscaner();


if ((($_SERVER["REMOTE_ADDR"] == $datosescaner[0]["ipescaner"]) ||
        ($_SERVER["REMOTE_ADDR"] == "localhost" )||
        ($_SERVER["REMOTE_ADDR"] == "127.0.0.1" ))) {

    if ($_SESSION["s_conexionremota"]["estado"] == "OK") {
        $stringsesion = json_encode($_SESSION["s_conexionremota"]);
    } else {
        $aleatorio = rand(0, 1000000);
        $marcatiempo = time();
        $sesionconexion["claveconexion"] = $marcatiempo . "_" . $aleatorio;
        $sesionconexion["usuarioconexion"] = $datosusuario["nombreusuario"];
        $sesionconexion["idescaner"] = $datosescaner[0]["idescaner"];
        $sesionconexion["estado"] = "OK";
        $_SESSION["s_conexionremota"] = $sesionconexion;
        $stringsesion = json_encode($_SESSION["s_conexionremota"]);
        //echo "<br>".session_id();
         
    }
    echo $stringsesion;
   
    
} else {
    $sesionconexion["estado"] = "ERROR ".$_SERVER["REMOTE_ADDR"];
    //$sesionconexion["referencia"] = $_SERVER;
    $stringsesion = json_encode($sesionconexion);
    echo $stringsesion;
}
unset($_SESSION["s_nombreusuario"]);

