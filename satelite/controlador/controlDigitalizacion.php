<?php

/*
 *  FuidXel is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, version 3 of the License
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
 * Descripcion del codigo de controlDigitalizacion
 * 
 * @file controlDigitalizacion.php
 * @author Javier Lopez Martinez
 * @date 29/09/2016
 * @brief Contiene ...
 */
require_once '../../conexion/constantesatelite.php';
require_once '../../conexion/constanteerror.php';
require_once '../../satelite/controlador/ControladorCurlRest.php';
require_once '../../satelite/controlador/ControlEjecucionEscaneo.php';
require_once '../../libreria/general/vista/FormularioBase.php';
//echo "REFERENCIA=" . $_SERVER["HTTP_REFERER"]."---".substr_count($_SERVER["HTTP_REFERER"],"http://localhost/fuixel/" . RUTALLAMADASERVIDOR);
session_start();
$idlotesesion = 0;


if ((substr_count($_SERVER["HTTP_REFERER"], "http://localhost/fuixel/" . RUTALLAMADASERVIDOR) > 0) ||
        (substr_count($_SERVER["HTTP_REFERER"], "https://localhost/fuixel/" . RUTALLAMADASERVIDOR) > 0) ||
        (substr_count($_SERVER["HTTP_REFERER"], "http://" . IPSERVIDORPRINCIPAL . "/fuixel/" . RUTALLAMADASERVIDOR) > 0) ||
        (substr_count($_SERVER["HTTP_REFERER"], "https://" . IPSERVIDORPRINCIPAL . "/fuixel/" . RUTALLAMADASERVIDOR) > 0)) {



    $sesioncorrecta = 1;

    //unset($_SESSION["s_datosimagenes"]);
    unset($_SESSION["s_datosimagenes"]["thumbnail"]);
    unset($_SESSION["s_datosimagenes"]["imagen"]);

    $_SESSION["s_idescaner"] = $_GET["idescaner"];
    $_SESSION["s_usuario"] = $_GET["usuario"];
    $urlsesion = PROTOCOLOSERVIDOR . "://" . IPSERVIDORPRINCIPAL . "/fuixel/" . RUTASESIONSERVIDOR . "?usuario=" . $_SESSION["s_usuario"];
    //$stringsesion=file_get_contents($urlsesion);
    //echo "<h1>".$urlsesion."</h1>";
    if (!isset($_SESSION["s_cookie"])) {
        $cookie_jar = tempnam('/tmp', 'cookie');
        $_SESSION["s_cookie"] = $cookie_jar;
    }
    $poststring = array("clave" => CLAVESERVICIOREST);
    $objcurlrest = new ControladorCurlRest($urlsesion);
    $salida = $objcurlrest->obtenerRespuesta($poststring);
    $objcurlrest->cerrarConexion();

    $sesionremota = json_decode($salida);
    $_SESSION["s_sesionremota"] = $sesionremota;

    /* echo "$salida<pre>";
      print_r($salida);
      echo "</pre>"; */
    $urlsesion = PROTOCOLOSERVIDOR . "://" . IPSERVIDORPRINCIPAL . "/fuixel/" . RUTASERVICIOS . "/controlador/controlGestionLote.php";
       $objcurlrest3 = new ControladorCurlRest($urlsesion);
        $objescaneo = new ControlEjecucionEscaneo($objcurlrest3);
        $datosescaner2 = $objescaneo->consultaEscaneo();
        
      /*  echo "datosescaner2<pre>";
      print_r($datosescaner2);
      echo "</pre>";*/
        $htmConfiguracion=$objescaneo->menuOpcionEscaner($datosescaner2);
       // echo "<pre>".$htmConfiguracion."</pre>";

    if (isset($_GET["idlote"]) &&
            trim($_GET["idlote"]) != '') {
        // echo "<h1>Entro?3</h1>";
        $urlsesion = PROTOCOLOSERVIDOR . "://" . IPSERVIDORPRINCIPAL . "/fuixel/" . RUTASERVICIOS . "/controlador/controlGestionLote.php";
        $objcurlrest2 = new ControladorCurlRest($urlsesion);
        $objescaneo2 = new ControlEjecucionEscaneo($objcurlrest2);
        
        $objescaneo2->setIdLote($_GET["idlote"]);
        $datosescaner = $objescaneo2->consultaEscaneo();
        $idlotesesion = $_GET["idlote"];

        //echo "datosescaner<pre>";
        //print_r($datosescaner);
        //echo "</pre>";
        $_SESSION["s_datosimagenes"]["datosescaner"] = $datosescaner;
    }






    if (isset($sesionremota->estado)) {
        if (trim($sesionremota->estado) != "OK") {
            $error = 1;
            $mensajerror = $sesionremota->estado . "---" . ERR0130;
        }
    } else {
        $error = 1;
        $mensajerror = "otro-" . ERR0130 . "---" . $sesionremota->estado;
    }
} else {
    /* echo "<h1>Entro?1</h1>";
      echo "datosescaner<pre>";
      print_r($_SESSION["s_sesionremota"]);
      echo "</pre>"; */
    /* if (isset($_SESSION["s_sesionremota"]->usuarioconexion) &&
      trim($_SESSION["s_sesionremota"]->usuarioconexion) != '') {
      // echo "<h1>Entro?2</h1>";
      if (isset($_GET["idlote"]) &&
      trim($_GET["idlote"]) != '') {
      // echo "<h1>Entro?3</h1>";
      $urlsesion = PROTOCOLOSERVIDOR . "://" . IPSERVIDORPRINCIPAL . "/fuixel/" . RUTASERVICIOS . "/controlador/controlGestionLote.php";
      $objcurlrest2 = new ControladorCurlRest($urlsesion);
      $objescaneo2 = new ControlEjecucionEscaneo($objcurlrest2);
      $objescaneo2->setIdLote($_GET["idlote"]);
      $datosescaner = $objescaneo2->consultaEscaneo();
      $idlotesesion = $_GET["idlote"];

      //echo "datosescaner<pre>";
      //print_r($datosescaner);
      //echo "</pre>";
      $_SESSION["s_datosimagenes"]["datosescaner"] = $datosescaner;
      }
      } else { */
    //echo "<h1>Entro?4</h1>";
    exit();
    //}
}
?>
