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
 * Descripcion del codigo de controlActaInicioPDF
 * 
 * @file controlActaInicioPDF.php
 * @author Javier Lopez Martinez
 * @date 7/11/2016
 * @brief Contiene ...
 */
require_once '../../conexion/idioma/entrada.php';
require_once '../../conexion/constantes.php';
require_once '../../conexion/constanteerror.php';
require_once '../../conexion/conexiondb.php';
require_once '../../administracion/modelo/GestionEscaner.php';
require_once '../../libreria/general/controlador/FuncionesCadena.php';
require_once '../../libreria/general/modelo/FuncionesSeguridad.php';
require_once '../../libreria/general/modelo/BaseGeneral.php';
require_once '../../libreria/general/vista/FormularioBase.php';
require_once '../../administracion/modelo/GestionUsuario.php';
require_once '../../administracion/modelo/GestionConfiguracion.php';
require_once '../../clientedigitaliza/modelo/GestionLoteImagen.php';
require_once '../../clientedigitaliza/modelo/GestionActaInicio.php';
require_once '../../clientedigitaliza/controlador/FormaActaInicio.php';
require_once '../../clientedigitaliza/controlador/ControlAdjuntoActa.php';

// session_start();
/* echo "_POST<pre>";
  print_r($_POST);
  echo "</pre>"; */
/*    $conexionmysql = connectionMysqlPDO();
  $objbase = new BaseGeneral($conexionmysql);
  $objseguridad = new FuncionesSeguridad($_SESSION["s_nombreusuario"], $objbase);
  if ($objseguridad->validaOpcionUsuario("gestiondigitaliza")) {

 */
$conexionmysql = connectionMysqlPDO();
  $objbase = new BaseGeneral($conexionmysql);

$objacta = new GestionActaInicio($objbase);
$objacta->setIdactacontrol($_GET["idactacontrol"]);
//$objacta->debug();
$tmpdatosacta = $objacta->consultaActaControl();
$datosacta=$tmpdatosacta[0];
$datosacta["fechaimpresion"] = date("Y-m-d H:i:s");


//}