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
 * Descripcion del codigo de recuperarDocumentoOCR
 * 
 * @file recuperarDocumentoOCR.php
 * @author Javier Lopez Martinez
 * @date 28/11/2016
 * @brief Contiene ...
 */
session_start();


$_SESSION["s_nombreusuario"] = $_GET["usuario"];

require_once '../../conexion/constanteerror.php';
require_once '../../conexion/constantes.php';
require_once '../../conexion/conexiondb.php';
require_once '../../libreria/general/controlador/FuncionesCadena.php';
require_once '../../libreria/general/modelo/FuncionesSeguridad.php';
require_once '../../libreria/general/modelo/BaseGeneral.php';
require_once '../../libreria/general/modelo/GestionMetadato.php';
require_once '../../administracion/modelo/GestionUsuario.php';
require_once '../../clientedigitaliza/modelo/GestionLoteImagen.php';
require_once '../../consolidacion/controlador/ConformaDocumento.php';
require_once '../../consolidacion/modelo/GestionDocumento.php';
require_once '../../consolidacion/modelo/GestionImagen.php';
require_once '../../consolidacion/controlador/CargaXMLDocumento.php';
require_once '../../consolidacion/controlador/ControlImagenIndexa.php';
require_once '../../consolidacion/controlador/ConformaXmlCMIS.php';
require_once '../../consolidacion/controlador/InformacionLote.php';
require_once ('../../libreria/opencmis/controlador/cmis_service.php');
require_once ('../../libreria/opencmis/controlador/cmis-lib.php');
require_once ('../../libreria/opencmis/controlador/cmis_repository_wrapper.php');

if (isset($_SESSION["s_nombreusuario"])) {
    session_start();
    /* echo "_POST<pre>";
      print_r($_POST);
      echo "</pre>"; */
    $conexionmysql = connectionMysqlPDO();
    $objbase = new BaseGeneral($conexionmysql);
    $objseguridad = new FuncionesSeguridad($_SESSION["s_nombreusuario"], $objbase);
    if ($objseguridad->validaOpcionUsuario("listadoloteindexa")) {

        $objconformadoc = new ConformaDocumento();
        $objgestiondoc = new GestionDocumento($objbase);
        $objcargacmis = new CargaXMLDocumento();
        $objloteimagen = new GestionLoteImagen($objbase);
        $objgestionusuario = new GestionUsuario($_SESSION["s_nombreusuario"], $objbase);
        $objcontimagen = new ControlImagenIndexa();
        $objimagen = new GestionImagen($objbase);
        $objmetadato= new GestionMetadato($objbase);
        $objinfo=new InformacionLote($objbase);
        
        $objcontimagen->setObjMetadato($objmetadato);
        $objconformadoc->setObjImagenIndexa($objcontimagen);
        $objconformadoc->setObjimagen($objimagen);
        $objconformadoc->setObjloteimagen($objloteimagen);
        $objconformadoc->setObjinfo($objinfo);
        
        $datosusuario = $objgestionusuario->consultaDatosUsuario();
        
        $objcargacmis->debug();
        $objcargacmis->setEstadovalida(7);
        $objcargacmis->setIdUsuario($datosusuario["idusuario"]);
        
        
        //$objgestiondoc->debug();
        $objconformadoc->setObjGestionDocumento($objgestiondoc);
        $objconformadoc->debug();
        $objconformadoc->setIdUsuario($datosusuario["idusuario"]);
        
        $objconformadoc->retornaArchivoConOCR($objcargacmis);
       
        echo  $objconformadoc->getMensajeError();
        echo  $objconformadoc->getMensajeExito();
    }
}