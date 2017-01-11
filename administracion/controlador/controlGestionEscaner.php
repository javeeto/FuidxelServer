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
 * Descripcion del codigo de controlGestionEscaner
 * 
 * @file controlGestionEscaner.php
 * @author Javier Lopez Martinez
 * @date 20/09/2016
 * @brief Contiene ...
 */
require_once '../../conexion/idioma/entrada.php';
require_once '../../conexion/constantes.php';
require_once '../../conexion/constanteerror.php';
require_once '../../conexion/conexiondb.php';
require_once '../../administracion/modelo/GestionEscaner.php';
require_once '../../administracion/modelo/GestionConfiguracion.php';
require_once '../../administracion/controlador/FormaGestionEscaner.php';
require_once '../../libreria/general/controlador/FuncionesCadena.php';
require_once '../../libreria/general/modelo/BaseGeneral.php';
require_once '../../libreria/general/vista/FormularioBase.php';
require_once '../../libreria/general/modelo/FuncionesSeguridad.php';

$error = false;



if (isset($_SESSION["s_nombreusuario"])) {
    session_start();
    /* echo "_POST<pre>";
      print_r($_POST);
      echo "</pre>"; */
    $conexionmysql = connectionMysqlPDO();
    $objbase = new BaseGeneral($conexionmysql);
    $objseguridad = new FuncionesSeguridad($_SESSION["s_nombreusuario"], $objbase);
    if ($objseguridad->validaOpcionUsuario("gestionescaner")) {


        $objformulario = new FormularioBase();
        $objgestionescaner = new GestionEscaner($objbase);
        $objgestionconfiguracion = new GestionConfiguracion($objbase);

        $objforma = new FormaGestionEscaner($objbase, $objformulario, $objgestionescaner);

        $objforma->setGestionConfiguracion($objgestionconfiguracion);

        if (isset($_POST["Enviar"])) {

            $datosmostrar = $_POST;
            if (isset($_GET["idescaner"])) {

                $objgestionescaner->setIdEscaner($_GET["idescaner"]);
            }
        } else {

            if (isset($_GET["idescaner"])) {
                $objgestionescaner->setIdEscaner($_GET["idescaner"]);
                $datosescaner = $objgestionescaner->consultarRegistrosEscaner();
                //$datosopciones = $objgestionescaner->consultaOpcionesEscaner();
                $datosmostrar = $datosescaner[0];
                /* for ($i = 0; $i < count($datosopciones); $i++) {
                  $datosmostrar["nombreopcion_" . ($i + 1)] = $datosopciones[$i]["nombreopcion"];
                  $datosmostrar["nombrecortoopcion_" . ($i + 1)] = $datosopciones[$i]["nombrecortoopcion"];
                  $datosmostrar["valoropcion_" . ($i + 1)] = $datosopciones[$i]["valoropcion"];
                  } */
                //$objgestionescaner->debug();
                $datosconfiguracion = $objgestionescaner->consultaConfiguracionEscaner();

                for ($i = 0; $i < count($datosconfiguracion); $i++) {
                    $datosmostrar["idconfiguracion" . $i] = $datosconfiguracion[$i]["idconfiguracion"];
                }
            }
        }

        if (isset($datosmostrar) &&
                trim($datosmostrar["nombreescaner"]) != "") {
            $objforma->setDatosEscaner($datosmostrar);
        }
        $panelGeneral = $objforma->panelGeneral();
        $panelConfiguracion = $objforma->panelConfiguracion();
        //$panelOpcion = $objforma->panelOpciones();



        if ($objforma->getError()) {
            $error = 1;
            $mensajerror = ERR0003;
        } else {
            //echo "<h1>Entro 2?</h1>";
            if (isset($_POST["Enviar"])) {
                //echo "<h1>Entro 1?</h1>";
                // $objgestionescaner->debug();
                $objgestionescaner->setDatosEscaner($_POST);
                $objgestionescaner->registroDatosEscaner();
                // $objgestionescaner->registroOpcionesEscaner();
                $objgestionescaner->registrarDatosConfiguracion();
                $exitoso = 1;
                $mensajerror = ERR0201;
            }
        }
    } else {

        echo "<META HTTP-EQUIV='refresh' CONTENT='0;URL=../../entrada/vista/cerrar.php'/>";
    }
} else {

    echo "<META HTTP-EQUIV='refresh' CONTENT='0;URL=../../entrada/vista/cerrar.php'/>";
}