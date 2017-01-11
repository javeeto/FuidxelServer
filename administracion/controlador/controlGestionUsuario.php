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
 * Descripcion del codigo de controlGestionUsuario
 * 
 * @file controlGestionUsuario.php
 * @author Javier Lopez Martinez
 * @date 4/10/2016
 * @brief Contiene ...
 */
require_once '../../conexion/idioma/entrada.php';
require_once '../../conexion/constantes.php';
require_once '../../conexion/constanteerror.php';
require_once '../../conexion/conexiondb.php';

require_once '../../libreria/general/controlador/FuncionesCadena.php';
require_once '../../libreria/general/modelo/BaseGeneral.php';
require_once '../../libreria/general/vista/FormularioBase.php';
require_once '../../libreria/general/modelo/FuncionesSeguridad.php';

require_once '../../administracion/modelo/GestionUsuario.php';
require_once '../../administracion/controlador/FormaGestionUsuario.php';
require_once '../../entrada/modelo/AutenticacionLdap.php';

$error = false;



if (isset($_SESSION["s_nombreusuario"])) {
    session_start();
    /* echo "_POST<pre>";
      print_r($_POST);
      echo "</pre>"; */
    $conexionmysql = connectionMysqlPDO();
    $objbase = new BaseGeneral($conexionmysql);
    $objseguridad = new FuncionesSeguridad($_SESSION["s_nombreusuario"], $objbase);
    if ($objseguridad->validaOpcionUsuario("gestionusuarios")) {

        $objformulario = new FormularioBase();
        $objgestionusuario = new GestionUsuario("", $objbase);
        $objforma = new FormaGestionUsuario($objbase, $objformulario, $objgestionusuario);
        $objldap = new AutenticacionLdap("", "");

        if (isset($_POST["Enviar"])) {

            $datosmostrar = $_POST;
            if (isset($_GET["idusuario"])) {

                $objgestionusuario->setIdUsuario($_GET["idusuario"]);
                $datosusuario = $objgestionusuario->consultaDatosUsuario();
                $objgestionusuario->setIdPersona($datosusuario["idpersona"]);
            }
        } else {
            if (isset($_GET["idusuario"])) {
                $objgestionusuario->setIdUsuario($_GET["idusuario"]);
                $datosusuario = $objgestionusuario->consultaDatosUsuario();
                $datosmostrar = $datosusuario;
            }
        }

        if (isset($datosmostrar) &&
                trim($datosmostrar["nombreusuario"]) != "") {
            $objforma->setDatosUsuario($datosmostrar);
        }

        $panelGeneral = $objforma->panelGeneral();
        $panelUsuario = $objforma->panelUsuario();

        if ($objforma->getError()) {
            $error = 1;
            $mensajerror = ERR0003;
        } else {
//echo "<h1>Entro 2?</h1>";
            if (isset($_POST["Enviar"])) {
                //  $objgestionusuario->debug();
                $datostmp = $objgestionusuario->consultaUsuario($datosmostrar["nombreusuario"]);
                $idusuariotmp = $objgestionusuario->getIdUsuario();
                if (isset($datostmp["nombreusuario"]) &&
                        trim($datostmp["nombreusuario"]) != '' &&
                        (!isset($idusuariotmp) ||
                        trim($idusuariotmp) == '' )) {
                    $error = 1;
                    $mensajerror = ERR0020;
                } else {
                    $objgestionusuario->setDatosUsuario($_POST);
                    $objgestionusuario->registrarDatosPersona();
                    $objgestionusuario->registrarDatosUsuario();
                    $datostmp = $objgestionusuario->consultaDatosUsuario();
                    $datosmostrar["nombreentidad"]=$datostmp["nombreentidad"];
                    
                    $objldap->ConexionAdmin();

                    if (!$objldap->modificarUsuario($datosmostrar, $datosmostrar["nombreusuario"])) {
                        $objldap->crearUsuario($datosmostrar);
                    }


                    $exitoso = 1;
                    $mensajerror = ERR0201;
                }
            }
        }
    } else {

        echo "<META HTTP-EQUIV='refresh' CONTENT='0;URL=../../entrada/vista/cerrar.php'/>";
    }
} else {

    echo "<META HTTP-EQUIV='refresh' CONTENT='0;URL=../../entrada/vista/cerrar.php'/>";
}