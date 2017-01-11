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
 * Descripcion del codigo de controlMenuOpcion
 * 
 * @file controlMenuOpcion.php
 * @author Javier Lopez Martinez
 * @date 15/09/2016
 * @brief Contiene ...
 */
session_start();

require_once '../../conexion/constantes.php';
require_once '../../conexion/conexiondb.php';
require_once '../../libreria/general/modelo/BaseGeneral.php';
require_once '../../administracion/modelo/GestionUsuario.php';
require_once '../../administracion/modelo/GestionMenuOpcion.php';
require_once '../../entrada/controlador/SesionUsuario.php';


$error = false;


if (isset($_SESSION["s_nombreusuario"])) {

    $conexionmysql = connectionMysqlPDO();
    $objbase = new BaseGeneral($conexionmysql);

    $objcontrolmenu = new SesionUsuario($objbase);
    $_SESSION["s_datosusuario"] = $objcontrolmenu->datosSesionUsuario($_SESSION["s_nombreusuario"]);
    $objmenuopcion = new GestionMenuOpcion($_SESSION["s_datosusuario"], $objbase);
    //$objmenuopcion->debug();
    $_SESSION["s_menuopciones"] = $objmenuopcion->consultaMenuOpcion();
   /*echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";*/
} else {

    echo "<META HTTP-EQUIV='refresh' CONTENT='0;URL=cerrar.php'/>";
}