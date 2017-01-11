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
 * Descripcion del codigo de controlMostrarImagenes
 * 
 * @file controlMostrarImagenes.php
 * @author Javier Lopez Martinez
 * @date 19/10/2016
 * @brief Contiene ...
 */
//exec(" echo '\n".$_SESSION["s_datosimagenes"]["contadorejecucion"]."- Entro 20 ".date("H:i:s")."' >> /tmp/logejecuta.txt &");

session_start();
//exec(" echo '\n".$_SESSION["s_datosimagenes"]["contadorejecucion"]."- Entro 21 ".date("H:i:s")."' >> /tmp/logejecuta.txt &");
require_once '../../conexion/constantesatelite.php';
require_once '../../conexion/constanteerror.php';
require_once '../../satelite/controlador/ControladorCurlRest.php';
require_once '../../satelite/controlador/ControlEjecucionEscaneo.php';
require_once '../../satelite/controlador/EdicionImagen.php';
//exec(" echo '\n".$_SESSION["s_datosimagenes"]["contadorejecucion"]."- Entro 22 ".date("H:i:s")."' >> /tmp/logejecuta.txt &");

if (isset($_SESSION["s_usuario"]) &&
        trim($_SESSION["s_usuario"]) != '') {


    if (isset($_GET["idlote"]) &&
            trim($_GET["idlote"]) != '') {
        //  echo "<h1>Entro 1</h1>";
        unset($_SESSION["s_datosimagenes"]["thumbnail"]);
        unset($_SESSION["s_datosimagenes"]["imagen"]);
        // unset($_SESSION["s_datosimagenes"]["separacion"]);
        $objescaneo = new ControlEjecucionEscaneo("");
        $objescaneo->setIdLote($_GET["idlote"]);
        $_SESSION["s_datosimagenes"]["idlote"] = $_GET["idlote"];
        //$_SESSION["s_datosimagenes"]["datoslote"]->idlote= $_GET["idlote"];
        $datosescaner = $_SESSION["s_datosimagenes"]["datosescaner"];
        /* echo "<h1>Entro 2</h1>";
          echo "s_datosimagenes<pre>";
          print_r($_SESSION["s_datosimagenes"]);
          echo "</pre>"; */
        $objescaneo->formatoOpcionesEscaner($datosescaner);
        $pathOrigen = $objescaneo->rutaLoteImagen();
        //$objescaneo->debug();
        $imagenes = $objescaneo->consultaImagenes($pathOrigen);

        /* echo "imagenes<pre>";
          print_r($imagenes);
          echo "</pre>"; */

        // echo "<h1>Entro 3 $pathOrigen</h1>";
        foreach ($imagenes["imagenes"] as $i => $ruta) {
            $_SESSION["s_datosimagenes"]["thumbnail"][] = $imagenes["thumbnail"][$i];
            $_SESSION["s_datosimagenes"]["imagen"][] = $imagenes["imagenes"][$i];
        }
        $_SESSION["s_datosimagenes"]["imagenesMostradas"] = 0;
    }

    /* echo "imagenes<pre>";
      print_r($imagenes);
      echo "</pre>"; */
    // exit();
    $totalImagen = count($_SESSION["s_datosimagenes"]["imagen"]);
    if($_GET["reinicio"]){
         unset($_SESSION["s_datosimagenes"]["separacion"]);
    }

    //unset($_SESSION["s_datosimagenes"]);

    /* echo "s_datosimagenes<pre>";
      print_r($_SESSION["s_datosimagenes"]);
      echo "</pre>"; */
//exec(" echo '\n".$_SESSION["s_datosimagenes"]["contadorejecucion"]."- Entro 23 ".date("H:i:s")."' >> /tmp/logejecuta.txt &");
    $imagenInicial = $_SESSION["s_datosimagenes"]["imagenesMostradas"];


    if (!isset($imagenInicial) ||
            trim($imagenInicial) == '') {
        $imagenInicial = 0;
    }
    //exec(" echo '\n".$_SESSION["s_datosimagenes"]["contadorejecucion"]."- Entro 24 ".date("H:i:s")."' >> /tmp/logejecuta.txt &");
    $imagenesMostradas = 0;
    //  echo $imagenInicial."-".$totalImagen."<br>";
    for ($i = $imagenInicial; $i < $totalImagen; $i++) {
        
        $arregloSrc[$i] = "../../satelite/controlador/mostrarImagen.php?idimagen=" . $i."&".  rand(0, 10000);
        $rutaimagen = $_SESSION["s_datosimagenes"]["thumbnail"][$i];
        $objimagen = new EdicionImagen($rutaimagen);
        $separaImg[$i] = "imagenes/link.png";
        if ($objimagen->esPaginaBlanca()) {
            $_SESSION["s_datosimagenes"]["separacion"][$_SESSION["s_datosimagenes"]["idlote"]][$i] = 1;
        }
        $separacion = $_SESSION["s_datosimagenes"]["separacion"][$_SESSION["s_datosimagenes"]["idlote"]][$i];
        if ($separacion) {
            $separaImg[$i] = "imagenes/link-broken_red.png";
        }
        $imagenesMostradas++;
    }

    if (isset($_GET["reinicio"]) &&
            trim($_GET["reinicio"]) != '') {
        $_SESSION["s_datosimagenes"]["imagenesMostradas"] = $imagenesMostradas;
    } else {
        $_SESSION["s_datosimagenes"]["imagenesMostradas"]+=$imagenesMostradas;
    }
    /* echo "separacion<pre>";
      print_r($_SESSION["s_datosimagenes"]["separacion"]);
      echo "</pre>"; */
    //exec(" echo '\n".$_SESSION["s_datosimagenes"]["contadorejecucion"]."- Entro 25 ".date("H:i:s")."' >> /tmp/logejecuta.txt &");
}
