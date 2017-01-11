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
 * Descripcion del codigo de controlGestionGrupoUsuario
 * 
 * @file controlGestionGrupoUsuario.php
 * @author Javier Lopez Martinez
 * @date 10/10/2016
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

require_once '../../administracion/modelo/GestionGrupoUsuario.php';
require_once '../../administracion/modelo/GestionEscaner.php';
require_once '../../administracion/controlador/FormaGestionGrupoUsuario.php';


$error = false;



if (isset($_SESSION["s_nombreusuario"])) {
    session_start();
    /* echo "_POST<pre>";
      print_r($_POST);
      echo "</pre>"; */
    $conexionmysql = connectionMysqlPDO();
    $objbase = new BaseGeneral($conexionmysql);
    $objseguridad = new FuncionesSeguridad($_SESSION["s_nombreusuario"], $objbase);
    if ($objseguridad->validaOpcionUsuario("gestiongrupousuario")) {

        $objformulario = new FormularioBase();
        $objgrupousuario = new GestionGrupoUsuario($objbase);
        $objescaner = new GestionEscaner($objbase);
        $objforma = new FormaGestionGrupoUsuario($objformulario, $objbase);
        $objforma->setEscaner($objescaner);
        //$objgrupousuario->debug();

        if (isset($_POST["Enviar"])) {

            $datosmostrar = $_POST;
            if (isset($_GET["idgrupousuario"])) {

                $objgrupousuario->setIdGrupoUsuario($_GET["idgrupousuario"]);
                $datosgrupousuario = $objgrupousuario->consultaGrupoUsuario();
                $datosasignacion = $objgrupousuario->consultaAsignaGrupoUsuario();
                for ($i = 0; $i < count($datosasignacion); $i++) {
                    $datosgrupousuario["idgrupousuariohijo" . $i] = $datosasignacion[$i]["idgrupousuariohijo"];
                }
            }
        } else {
            if (isset($_GET["idgrupousuario"])) {
                $objgrupousuario->setIdGrupoUsuario($_GET["idgrupousuario"]);
                $datosgrupousuario = $objgrupousuario->consultaGrupoUsuario();

                $datosasignacion = $objgrupousuario->consultaAsignaGrupoUsuario();

                for ($i = 0; $i < count($datosasignacion); $i++) {
                    $datosgrupousuario[0]["idgrupousuariohijo" . $i] = $datosasignacion[$i]["idgrupousuariohijo"];
                }


                $datosmostrar = $datosgrupousuario[0];
            }
        }

        if (isset($datosmostrar) &&
                trim($datosmostrar["nombregrupousuario"]) != "") {

            $objforma->setDatosGrupoUsuario($datosmostrar);
        }

        $panelGeneral = $objforma->panelGeneral();
        $panelAsignacion = $objforma->panelAsignacion();
        if ($objforma->getError()) {
            $error = 1;
            $mensajerror = ERR0003;
        } else {
            if (isset($_POST["Enviar"])) {
                $objgrupousuario->setDatosGrupoUsuario($_POST);
                $objgrupousuario->registrarDatosGrupoUsuario();
                $objgrupousuario->registrarDatosAsignaGrupo();
                //$datostmp = $objgestionusuario->consultaDatosUsuario();
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