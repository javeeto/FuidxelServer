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
 * Descripcion del codigo de controlLoteImagenes
 * 
 * @file controlLoteImagenes.php
 * @author Javier Lopez Martinez
 * @date 30/09/2016
 * @brief Contiene ...
 */
session_start();
require_once '../../conexion/constantesatelite.php';
require_once '../../conexion/constanteerror.php';
require_once '../../libreria/general/controlador/FuncionesCadena.php';
require_once '../../satelite/controlador/ControladorCurlRest.php';
require_once '../../satelite/controlador/ControlEjecucionEscaneo.php';
require_once '../../satelite/controlador/EdicionImagen.php';

$urlsesion = PROTOCOLOSERVIDOR . "://" . IPSERVIDORPRINCIPAL . "/fuixel/" . RUTASERVICIOS . "/controlador/controlGestionLote.php";
$objcurlrest = new ControladorCurlRest($urlsesion);

$objescaneo = new ControlEjecucionEscaneo($objcurlrest);

if (isset($_SESSION["s_sesionremota"]->usuarioconexion) &&
        trim($_SESSION["s_sesionremota"]->usuarioconexion) != '') {



    switch ($_GET["accion"]) {

        case "transferirlote":

            $datosescaner = $_SESSION["s_datosimagenes"]["datosescaner"];
            $idlote = limpiaCadena($_GET["idloteimagen"]);
            $datosimagenes = $_SESSION["s_datosimagenes"];

            /* echo "<pre>";
              print_r($_SESSION["s_datosimagenes"]);
              echo "</pre>"; */



            $objescaneo->setIdLote($idlote);
            $salida = $objescaneo->transferirLote($datosimagenes);

            $stringsalida = json_encode($salida);
            echo $salida;

            break;

        case "ejecutaescaneo":
            unset($_SESSION["s_datosimagenes"]["thumbnail"]);
            $configuracion = limpiaCadena($_GET["configura"]);
            $objescaneo->setConfiguracion($configuracion);
            $salida = $objescaneo->ejecutaEscaneo();

            echo $salida;


            break;

        case "nuevolote":

            unset($_SESSION["s_datosimagenes"]);
            touch(ARCHIVOEJECUTAESCANER);
            file_put_contents(ARCHIVOEJECUTAESCANER, "0:10000");
            $configuracion = limpiaCadena($_GET["configura"]);
            $objescaneo->setConfiguracion($configuracion);
            $datosescaner = $objescaneo->consultaEscaneo();
            $datoslote = $objescaneo->crearLote();
            $_SESSION["s_datosimagenes"]["datoslote"] = $datoslote;
            $_SESSION["s_datosimagenes"]["datosescaner"] = $datosescaner;
            $opconf = $objescaneo->getConfiguracion();
            $idconfiguracion = $datosescaner->configuracion[$opconf]->idconfiguracion;
            $salida["idlote"] = $_SESSION["s_datosimagenes"]["datoslote"]->idlote;
            $salida["idconfiguracion"] = $idconfiguracion;
            $salida["servidor"] = IPSERVIDORPRINCIPAL;
            $salida["resultado"] = "Ok";
            $stringsalida = json_encode($salida);
            echo $stringsalida;

            break;

        case "consultaescaner":
            
            $configuracion = limpiaCadena($_GET["configura"]);
            $objescaneo->setConfiguracion($configuracion);
            //$objescaneo->debug();
            $salida = $objescaneo->moverImagenesLocal();

            $_SESSION["s_datosimagenes"]["idlote"] = $salida["idlote"];
            if (is_array($_SESSION["s_datosimagenes"]["thumbnail"])) {
                $imagenInicial = count($_SESSION["s_datosimagenes"]["thumbnail"]);
                $totalImagen = count($salida["imagen"]) + $imagenInicial;
                $j = 0;
                for ($i = $imagenInicial; $i < $totalImagen; $i++) {
                    $_SESSION["s_datosimagenes"]["thumbnail"][$i] = $salida["thumbnail"][$j];
                    $_SESSION["s_datosimagenes"]["imagen"][$i] = $salida["imagen"][$j];
                    $j++;
                }
            } else {
                $_SESSION["s_datosimagenes"]["thumbnail"] = $salida["thumbnail"];
                $_SESSION["s_datosimagenes"]["imagen"] = $salida["imagen"];
            }
            $stringsalida = json_encode($salida);
            echo $stringsalida;



            break;
    }
}
?>