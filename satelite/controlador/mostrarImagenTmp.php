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
 * Descripcion del codigo de mostrarImagenTmp
 * 
 * @file mostrarImagenTmp.php
 * @author Javier Lopez Martinez
 * @date 26/10/2016
 * @brief Contiene ...
 */
session_start();
//exec(" echo '\n".$_SESSION["s_datosimagenes"]["contadorejecucion"]."- Entro 21 ".date("H:i:s")."' >> /tmp/logejecuta.txt &");
require_once '../../conexion/constantesatelite.php';
require_once '../../conexion/constanteerror.php';
header("Expires: Thu, 27 Mar 1980 23:59:00 GMT"); //la pagina expira en una fecha pasada
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora
header("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header("Pragma: no-cache");
session_start();
/*echo "s_datosimagenes<pre>";
print_r($_SESSION["s_datosimagenes"]);
echo "</pre>";*/
 //exec(" echo '\n".$_SESSION["s_datosimagenes"]["contadorejecucion"]."- Entro 15 ".date("H:i:s")."' >> /tmp/logejecuta.txt &");

//echo RUTATEMPORALIMAGEN;



$contenidoimagen = file_get_contents(RUTATEMPORALIMAGEN);
echo $contenidoimagen;