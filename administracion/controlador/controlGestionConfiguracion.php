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
 * Descripcion del codigo de controlGestionConfiguracion
 * 
 * @file controlGestionConfiguracion.php
 * @author Javier Lopez Martinez
 * @date 25/10/2016
 * @brief Contiene ...
 */
require_once '../../conexion/idioma/entrada.php';
require_once '../../conexion/constantes.php';
require_once '../../conexion/constanteerror.php';
require_once '../../conexion/conexiondb.php';
require_once '../../administracion/modelo/GestionConfiguracion.php';
require_once '../../administracion/controlador/FormaGestionConfiguracion.php';
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
    if ($objseguridad->validaOpcionUsuario("gestionconfiguracion")) {


        $objformulario = new FormularioBase();
        $objgestionconfiguracion = new GestionConfiguracion($objbase);
        $objforma = new FormaGestionConfiguracion($objbase, $objformulario, $objgestionconfiguracion);
        if (isset($_POST["Enviar"])) {

            $datosmostrar = $_POST;
            if (isset($_GET["idconfiguracion"])) {

                $objgestionconfiguracion->setIdConfiguracion($_GET["idconfiguracion"]);
            }
        } else {

            if (isset($_GET["idconfiguracion"])) {
                $objgestionconfiguracion->setIdConfiguracion($_GET["idconfiguracion"]);
                $datosconfiguracion = $objgestionconfiguracion->consultarRegistrosConfiguracion();
                $datosopciones = $objgestionconfiguracion->consultaOpcionesEscaner();
                $datosmostrar = $datosconfiguracion[0];
                for ($i = 0; $i < count($datosopciones); $i++) {
                    $datosmostrar["nombreopcion_" . ($i + 1)] = $datosopciones[$i]["nombreopcion"];
                    $datosmostrar["nombrecortoopcion_" . ($i + 1)] = $datosopciones[$i]["nombrecortoopcion"];
                    $datosmostrar["valoropcion_" . ($i + 1)] = $datosopciones[$i]["valoropcion"];
                }
            }
        }

        if (isset($datosmostrar) &&
                trim($datosmostrar["nombreconfiguracion"]) != "") {
            $objforma->setDatosConfiguracion($datosmostrar);
        }
        $panelGeneral = $objforma->panelGeneral();
        $panelOpcion = $objforma->panelOpciones();



        if ($objforma->getError()) {
            $error = 1;
            $mensajerror = ERR0003;
        } else {
            //echo "<h1>Entro 2?</h1>";
            if (isset($_POST["Enviar"])) {
                //echo "<h1>Entro 1?</h1>";
                // $objgestionconfiguracion->debug();
                $objgestionconfiguracion->setDatosConfiguracion($_POST);
                $objgestionconfiguracion->registroDatosConfiguracion();
                $objgestionconfiguracion->registroOpcionesEscaner();
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