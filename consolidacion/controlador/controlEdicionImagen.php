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
 * Descripcion del codigo de controlEdicionImagen
 * 
 * @file controlEdicionImagen.php
 * @author Javier Lopez Martinez
 * @date 26/10/2016
 * @brief Contiene ...
 */
session_start();
require_once '../../conexion/constantesatelite.php';
require_once '../../conexion/constanteerror.php';
require_once '../../conexion/conexiondb.php';
require_once '../../libreria/general/controlador/FuncionesCadena.php';
require_once '../../libreria/general/modelo/FuncionesSeguridad.php';
require_once '../../libreria/general/modelo/BaseGeneral.php';
require_once '../../libreria/general/controlador/FuncionesCadena.php';
require_once '../../satelite/controlador/ControladorCurlRest.php';
require_once '../../satelite/controlador/ControlEjecucionEscaneo.php';
require_once '../../satelite/controlador/EdicionImagen.php';

$urlsesion = PROTOCOLOSERVIDOR . "://" . IPSERVIDORPRINCIPAL . "/fuixel/" . RUTASERVICIOS . "/controlador/controlGestionLote.php";
$objcurlrest = new ControladorCurlRest($urlsesion);
$objescaneo = new ControlEjecucionEscaneo($objcurlrest);
    $conexionmysql = connectionMysqlPDO();
    $objbase = new BaseGeneral($conexionmysql);
    $objseguridad = new FuncionesSeguridad($_SESSION["s_nombreusuario"], $objbase);
if (isset($_GET["iimagen"]) &&
        trim($_GET["iimagen"]) != '') {

    $objimagen = new EdicionImagen($_SESSION["s_datosimagenes"]["imagen"][$_GET["iimagen"]]);
    $objimagenthumb = new EdicionImagen($_SESSION["s_datosimagenes"]["thumbnail"][$_GET["iimagen"]]);
}

if ($objseguridad->validaOpcionUsuario("gestiondigitaliza")) {
    switch ($_GET["accion"]) {

        case "rotarimagen":
            $objimagen->rota90Derecha();
            $objimagenthumb->rota90Derecha();

            echo "Ok";
            break;
        case "creartemporal":

            $objimagen->crearJpgTemporal();

            echo "Ok";
            break;
        case "separar":
            $separacion = $_SESSION["s_datosimagenes"]["separacion"][$_SESSION["s_datosimagenes"]["idlote"]][$_GET["iimagen"]];
            if ($separacion) {
                unset($_SESSION["s_datosimagenes"]["separacion"][$_SESSION["s_datosimagenes"]["idlote"]][$_GET["iimagen"]]);
                $salida["resultado"] = "Ok";
                $salida["estado"] = "0";
            } else {
                $_SESSION["s_datosimagenes"]["separacion"][$_SESSION["s_datosimagenes"]["idlote"]][$_GET["iimagen"]] = 1;
                $salida["resultado"] = "Ok";
                $salida["estado"] = "1";
            }
            $stringsalida = json_encode($salida);
            echo $stringsalida;

            break;
        case "separamasivo":
            $listaImagen = $_POST["separador"];
            $salida = $objescaneo->insertarImagenSeparacion($listaImagen);
            $stringsalida = json_encode($salida);
            echo $stringsalida;
            break;
    }
}