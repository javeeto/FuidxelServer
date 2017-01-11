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
 * Descripcion del codigo de controlGrupoIndexa
 * 
 * @file controlGrupoIndexa.php
 * @author Javier Lopez Martinez
 * @date 8/11/2016
 * @brief Contiene ...
 */
require_once '../../conexion/idioma/entrada.php';
require_once '../../conexion/constantes.php';
require_once '../../conexion/constanteerror.php';
require_once '../../conexion/conexiondb.php';
require_once '../../libreria/general/controlador/FuncionesCadena.php';
require_once '../../libreria/general/modelo/FuncionesSeguridad.php';
require_once '../../libreria/general/modelo/BaseGeneral.php';
require_once '../../libreria/general/modelo/GestionMetadato.php';
require_once '../../libreria/general/vista/FormularioBase.php';
require_once '../../administracion/modelo/GestionUsuario.php';
require_once '../../clientedigitaliza/modelo/GestionLoteImagen.php';
require_once '../../consolidacion/modelo/GestionImagen.php';
require_once '../../consolidacion/controlador/ControlImagenIndexa.php';

if (isset($_SESSION["s_nombreusuario"])) {
    session_start();
    /* echo "_POST<pre>";
      print_r($_POST);
      echo "</pre>"; */
    $conexionmysql = connectionMysqlPDO();
    $objbase = new BaseGeneral($conexionmysql);
    $objseguridad = new FuncionesSeguridad($_SESSION["s_nombreusuario"], $objbase);
    if ($objseguridad->validaOpcionUsuario("gestiondigitaliza")) {
        $objloteimagen = new GestionLoteImagen($objbase);
        $objimagen = new GestionImagen($objbase);
        $objcontimagen = new ControlImagenIndexa();
        $objmetadato= new GestionMetadato($objbase);
        $objmetadato->setIdFormulario("1");
      //   $objmetadato->debug();
        $objmetadato->setIdFormulario("1");

        $idloteimagen = limpiaCadena($_GET["idloteimagen"]) ;
        $objcontimagen->setIdLoteImagen($idloteimagen);
        $objcontimagen->setObjGestionImagen($objimagen);
        $objcontimagen->setObjMetadato($objmetadato);
       // $objmetadato->debug();
       // $objcontimagen->debug();
        $datosimagenes = $objcontimagen->separaDocumentoImagen();
        $_SESSION["s_datosgrupoimagen"]=$datosimagenes;
        $rutasminiatura = $objcontimagen->miniaturaGrupoImagen();
        //$objcontimagen->debug();
        $titulosgrupo=$objcontimagen->tituloGrupoImagen();
        $_SESSION["s_imagenindexa"]["thumbnail"]=$rutasminiatura;
        
      /*echo "titulosgrupo<pre>";
        print_r($titulosgrupo);
        echo "</pre>";*/
       /* echo "datosimagenes<pre>";
        print_r($datosimagenes);
        echo "</pre>";*/
    }
}
?>