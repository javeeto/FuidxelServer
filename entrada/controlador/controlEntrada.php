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
 * Descripcion del codigo de controlEntrada
 * 
 * @file controlEntrada.php
 * @author Javier Lopez Martinez
 * @date 15/09/2016
 * @brief Contiene ...
 */
date_default_timezone_set('America/Bogota');
require_once '../../conexion/constantes.php';
require_once '../../conexion/constanteerror.php';
require_once '../modelo/AutenticacionLdap.php';
require_once "../../libreria/general/controlador/FuncionesCadena.php";


$error = false;


if (isset($_POST["usuario"]) &&
        isset($_POST["clave"])) {
    
    //Restriccion de ejecución de ingreso solo de 
    if (($_SERVER["HTTP_REFERER"] == "http://localhost/fuixel/entrada/vista/index.php") ||
            ($_SERVER["HTTP_REFERER"] == "https://localhost/fuixel/entrada/vista/index.php")||
            ($_SERVER["HTTP_REFERER"] == "http://192.168.0.3/fuixel/entrada/vista/index.php")||
            ($_SERVER["HTTP_REFERER"] == "http://192.168.0.11/fuixel/entrada/vista/index.php")||
            ($_SERVER["HTTP_REFERER"] == "http://10.20.0.5/fuixel/entrada/vista/index.php")){

        $usuario = limpiaCadena($_POST["usuario"]);
        $clave = limpiaCadena($_POST["clave"]);

        if (TIPOAUTENTICACION == "ldap") {

            $objautentica = new AutenticacionLdap($usuario, $clave);
            $ingreso = false;
            if ($objautentica->Autentificar()) {
                $ingreso = true;
                session_start();
                $_SESSION["s_nombreusuario"]=$usuario;
            }
        } else {

            $error = true;
            $mensajerror = ERR0001;
        }

        if ($ingreso) {
            echo "<META HTTP-EQUIV='refresh' CONTENT='0;URL=menuprincipal.php'/>";
        } else {
            $error = true;
            $mensajerror .= ERR0001;
        }
    } else {

        $error = true;
        $mensajerror .= ERR0002;
    }
}


$TITULOPAGINA = "FuidXel-LOGIN";
$CONTENIDOPIE = "FuidXel-" . date("Y-m-d");
