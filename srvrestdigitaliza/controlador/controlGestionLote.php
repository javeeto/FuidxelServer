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
 * Descripcion del codigo de controlGestionLote
 * 
 * @file controlGestionLote.php
 * @author Javier Lopez Martinez
 * @date 30/09/2016
 * @brief Contiene ...
 */
session_start();

/* echo "_SESSION<pre>";
  print_r($_SESSION);
  echo "</pre>";

  echo "_POST<pre>";
  print_r($_POST);
  echo "</pre>"; */

$_SESSION["s_nombreusuario"] = $_SESSION["s_conexionremota"]["usuarioconexion"];
require_once '../../conexion/idioma/entrada.php';
require_once '../../conexion/constantes.php';
require_once '../../conexion/constanteerror.php';
require_once '../../conexion/conexiondb.php';
require_once '../../administracion/modelo/GestionEscaner.php';
require_once '../../libreria/general/controlador/FuncionesCadena.php';
require_once '../../libreria/general/modelo/BaseGeneral.php';
require_once '../../administracion/modelo/GestionUsuario.php';
require_once '../../administracion/modelo/GestionConfiguracion.php';
require_once '../../clientedigitaliza/modelo/GestionLoteImagen.php';
require_once '../../clientedigitaliza/controlador/ControlLoteImagen.php';

/* echo "postrecibido<pre>";
  print_r($_POST);
  echo "</pre>"; */


if ($_POST["s_claveconexion"] == $_SESSION["s_conexionremota"]["claveconexion"]) {


    $conexionmysql = connectionMysqlPDO();
    $objbase = new BaseGeneral($conexionmysql);
    $objloteimagen = new GestionLoteImagen($objbase);
    $objusuario = new GestionUsuario($_SESSION["s_conexionremota"]["usuarioconexion"], $objbase);
    //$objgrupousuario= new GestionGrupoUsuario($objbase);
    $objescaner = new GestionEscaner($objbase);
    $objconfiguracion = new GestionConfiguracion($objbase);
    $objlote = new ControlLoteImagen();


    $datosusuario = $objusuario->consultaDatosUsuario();
    //$objgrupousuario->setIdGrupoUsuario($datosusuario["idgrupousuario"]);
    //$datosgrupousuario=$objgrupousuario->consultaGrupoUsuario();
    $objloteimagen->setIdusuario($datosusuario["idusuario"]);

    //$objloteimagen->debug();
    $objloteimagen->consultaRepoActivo("3");

    switch ($_POST["accion"]) {
        case "transferirlote":
            $objescaner->setIdEscaner($_POST["s_idescaner"]);
            $datosescaner = $objescaner->consultarRegistrosEscaner();

            $objlote->setIdloteimagen($_POST["s_idlote"]);
            $objlote->setDatosescaner($datosescaner);
            $objlote->setDatosimagenes($_POST["s_datosimagenes"]);
            $objlote->setIdusuario($datosusuario["idusuario"]);
            $objlote->setObjGestioLote($objloteimagen);
            $salida = $objlote->transferir($_POST["s_totalimagenes"]);
            if ($salida["resultado"] == "Ok") {
                $objlote->registraImagenesxLote();
                $objlote->registraLoteTransferido($salida["totalimagenes"]);
            }

            //$_POST["s_totalimagenes"]
            $stringsalida = json_encode($salida);


            break;
        case "nuevolote":
            $idlote = $objloteimagen->nuevoLote();
            $datosusuario = $objusuario->consultaDatosUsuario();
            $objloteimagen->setDatosUsuario($datosusuario);
            $objloteimagen->nuevoGrupoLoteImagen();
            $salidaservicio["estado"] = "OK";
            $salidaservicio["idlote"] = $idlote;
            $stringsalida = json_encode($salidaservicio);

            break;
        case "consultaescaner":
            /* echo "postrecibido<pre>";
              print_r($_POST);
              echo "</pre>"; */
            $objescaner->setIdEscaner($_POST["s_idescaner"]);
            $datosescaner = $objescaner->consultarRegistrosEscaner();
            //$opcionesescaner = $objescaner->consultaOpcionesEscaner();

            $datosconfiguraes = $objescaner->consultaConfiguracionEscaner();



            $salidaservicio["estado"] = "OK";
            $salidaservicio["idescaner"] = $datosescaner[0]["idescaner"];
            $salidaservicio["nombreescaner"] = $datosescaner[0]["nombreescaner"];
            // $salidaservicio["opcionesescaner"] = $opcionesescaner;

            for ($i = 0; $i < count($datosconfiguraes); $i++) {
                $objconfiguracion->setIdConfiguracion($datosconfiguraes[$i]["idconfiguracion"]);
                $datosconfiguracion = $objconfiguracion->consultarRegistrosConfiguracion();
                // $salidaservicio["configuracion"][$i]=$datosconfiguracion[0];
                $salidaservicio["configuracion"][$i]["nombrecorto"] = $datosconfiguracion[0]["nombrecortoconfiguracion"];
                $salidaservicio["configuracion"][$i]["nombre"] = $datosconfiguracion[0]["nombreconfiguracion"];
                $salidaservicio["configuracion"][$i]["principal"] = $datosconfiguracion[0]["principalconfiguracion"];
                $salidaservicio["configuracion"][$i]["idconfiguracion"] = $datosconfiguraes[$i]["idconfiguracion"];
                $salidaservicio["configuracion"][$i]["opciones"] = $objconfiguracion->consultaOpcionesEscaner();
            }
            $stringsalida = json_encode($salidaservicio);
            break;
    }
    echo $stringsalida;
} else {
    $salidaservicio["estado"] = "ERROR";
    $salidaservicio["s_claveconexionpost"] = $_POST["s_claveconexion"];
    $salidaservicio["s_claveconexionsess"] = $_SESSION["s_conexionremota"]["claveconexion"];
    //$sesionconexion["referencia"] = $_SERVER;
    $stringsalida = json_encode($salidaservicio);
    echo $stringsalida;
}
unset($_SESSION["s_nombreusuario"]);
