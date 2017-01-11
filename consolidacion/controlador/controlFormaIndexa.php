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
 * Descripcion del codigo de controlFormaIndexa
 * 
 * @file controlFormaIndexa.php
 * @author Javier Lopez Martinez
 * @date 11/11/2016
 * @brief Contiene ...
 */
require_once '../../conexion/constanteerror.php';
require_once '../../conexion/constantes.php';
require_once '../../conexion/conexiondb.php';
require_once '../../libreria/general/controlador/FuncionesCadena.php';
require_once '../../libreria/general/modelo/FuncionesSeguridad.php';
require_once '../../libreria/general/modelo/BaseGeneral.php';
require_once '../../libreria/general/vista/FormularioBase.php';
require_once '../../administracion/modelo/GestionUsuario.php';
require_once '../../clientedigitaliza/modelo/GestionLoteImagen.php';
require_once '../../consolidacion/modelo/GestionImagen.php';
require_once '../../consolidacion/controlador/ControlImagenIndexa.php';
require_once '../../libreria/general/vista/FormularioBase.php';
require_once '../../consolidacion/controlador/ConformaDocumento.php';
require_once '../../consolidacion/modelo/GestionDocumento.php';
require_once '../../libreria/general/modelo/GestionMetadato.php';
require_once '../../consolidacion/controlador/ConformaXmlCMIS.php';
require_once '../../consolidacion/controlador/CargaXMLDocumento.php';
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
        $objformulario = new FormularioBase();
        unset($_SESSION["s_datosimagenes"]);
        $objimagen = new GestionImagen($objbase);
        $objcontimagen = new ControlImagenIndexa();
        $objconformadoc = new ConformaDocumento();
        $objgestiondoc = new GestionDocumento($objbase);
        $objgestionusuario = new GestionUsuario($_SESSION["s_nombreusuario"], $objbase);
        $objgestionlote = new GestionLoteImagen($objbase);
        $objmetadatoVal = new GestionMetadato($objbase);
         $objmetadatoVal = new GestionMetadato($objbase);
         $objcargacmis = new CargaXMLDocumento();
        $datosusuario = $objgestionusuario->consultaDatosUsuario();
        $objcargacmis->setIdUsuario($datosusuario["idusuario"]);
        //$objgestionlote->debug();
        $objgestionlote->consultaRepoActivo("3");
        $datosrepoactivo = $objgestionlote->getDatosRepoActivo();

        $idloteimagen = limpiaCadena($_GET["idloteimagen"]);
        $idocumento = limpiaCadena($_GET["idocumento"]);
        $objcontimagen->setIdLoteImagen($idloteimagen);
        $objcontimagen->setObjGestionImagen($objimagen);
        $objcontimagen->setIdocumento($idocumento);
        $objcontimagen->setObjMetadato($objmetadatoVal);
      // $objcontimagen->debug();
        $objcontimagen->separaDocumentoImagen();
        //$objcontimagen->setDatosGrupoImagen($_SESSION["s_datosgrupoimagen"]);
        $objcontimagen->setObjFormulario($objformulario);
        $_SESSION["s_datosimagenes"] = $objcontimagen->arregloImagenGrupo();
        $htmlMenu = $objcontimagen->listaImagenForma();
        $htmlDoc = $objcontimagen->listaDocumentoForma();

        /*  echo "s_datosimagenes<pre>";
          print_r($_SESSION["s_datosimagenes"]);
          echo "</pre>"; */

        $totalimagen = count($_SESSION["s_datosimagenes"]["imagen"]);



        //Conforma documento
        $s_idformulario = 1;
        $s_iddetalledocumento=$objcontimagen->getIdDetalleDocumento();
        if(trim($s_iddetalledocumento)=="1"){
            unset($s_iddetalledocumento);
        }
        //Define arreglo de campos avlidar unicidad
        $s_validaunicidad = 1;
        $objmetadatoVal->setIdFormulario($s_idformulario);
        $objmetadatoVal->consultaCampoMetadato();
        $s_datoscampoVal = $objmetadatoVal->getDatosCampo();
        



        if ($_POST["enviar_f" . $s_idformulario]) {
            if ($objmetadatoVal->validaUnicidadRegistro($s_datoscampoVal)) {



                $objconformadoc->setDatosRepoActivo($datosrepoactivo);
                $objconformadoc->setIdUsuario($datosusuario["idusuario"]);

                //$objgestiondoc->debug();

                $objconformadoc->setObjGestionDocumento($objgestiondoc);
                $objconformadoc->setObjImagenIndexa($objcontimagen);
               // $objconformadoc->debug();
                $objconformadoc->setObjloteimagen($objgestionlote);
                if ($objconformadoc->agrupaImagen()) {
                    $s_exitoso = 1;
                    $s_mensajerror = ERR0201 . " " . $objconformadoc->getMensajeExito();
                    $s_iddetalledocumento = $objconformadoc->getIdDetalleDocumento();
                } else {
                    $s_error2 = 1;
                    $s_mensajerror2 = ERR0003 . " " . $objconformadoc->getMensajeError();
                }
            }else{
                $s_error2 = 1;
                $s_mensajerror2 = ERR0109 . "/" . $mensajerror;
            }
        }
    }
}