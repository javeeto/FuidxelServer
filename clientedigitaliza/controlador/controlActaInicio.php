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
        //$objloteimagen->debug();
        $objloteimagen->consultaRepoActivo("3");
        $datosRepo = $objloteimagen->getDatosRepoActivo();


        $objusuario = new GestionUsuario($_SESSION["s_nombreusuario"], $objbase);
        //$objgrupousuario= new GestionGrupoUsuario($objbase);
        $objescaner = new GestionEscaner($objbase);
        $objconfiguracion = new GestionConfiguracion($objbase);
        $objformulario = new FormularioBase();
        $objforma = new FormaActaInicio($objformulario);
        $objacta = new GestionActaInicio($objbase);
        $objadjunto = new ControlAdjuntoActa();
        $datosacta["idtipoactacontrol"] = 1;
        $datosacta["idrepositorio"] = $datosRepo["idrepositorio"];
        //$objlote = new GestionLoteImagen();
        //$objusuario->debug();
        $datosusuario = $objusuario->consultaDatosUsuario();

        if (isset($_POST["Enviar"])) {

            $datosacta = $_POST;
            if (isset($_GET["idactacontrol"])) {
                $objacta->setIdactacontrol($_GET["idactacontrol"]);
            }
        } else {

            if (isset($_GET["idactacontrol"])) {
                
            } else {

                $datosacta["identidad"] = $datosusuario["identidad"];
                if (is_numeric($_GET["idlote"])) {
                    $datosacta["idloteimagen"] = $_GET["idlote"];
                    $objloteimagen->setIdLoteImagen($_GET["idlote"]);
                    $datoslote = $objloteimagen->consultaDatosLote();
                } else {
                    $error = 1;
                    $mensajerror = ERR0305;
                }

                if (is_numeric($_GET["idconfiguracion"])) {
                    //$datosacta["idlote"] = $_GET["idconfiguracion"];
                    $objconfiguracion->setIdConfiguracion($_GET["idconfiguracion"]);
                    $datosconfiguracion = $objconfiguracion->consultarRegistrosConfiguracion();
                    $datosacta["configuracion"] = $datosconfiguracion[0]["nombreconfiguracion"];
                } else {
                    $error = 1;
                    $mensajerror = ERR0306;
                }
                $datosacta["fechalote"] = $datoslote["fechainicioloteimagen"];
            }
        }

        $objforma->setDatosActa($datosacta);
        $objforma->setObjUsuario($objusuario);
        $panelGeneral = $objforma->panelGeneral();

        if ($objforma->getError()) {
            $error = 1;
            $mensajerror = ERR0003;
        } else {
            //echo "<h1>Entro 2?</h1>";
            if (isset($_POST["Enviar"])) {
                //echo "<h1>Entro 1?</h1>";
                // $objgestionescaner->debug();
                $objacta->setDatosActa($_POST);
                $objacta->setDatosUsuario($datosusuario);



                $objacta->registroDatosActa();
                $idactacontrol = $objacta->getIdactacontrol();

                $objadjunto->setDatosActa($datosacta);
                $objadjunto->setDatosRepo($datosRepo);
                $objadjunto->setIdactacontrol($idactacontrol);
                // $objadjunto->debug();
                if ($objadjunto->cargarArchivoAdjunto($_FILES)) {
                    $exitoso = 1;
                    $mensajerror = $objadjunto->getMensajeExito();

                    $datosadjunto["nombredocumento"] = $objadjunto->getNombreDocumento();
                    $datosadjunto["rutadocumento"] = $objadjunto->getRutaDocumento();
                    $objacta->registrarDatosAdjunto($datosadjunto);

                    $mensajerror .= ERR0201;
                    echo "<META HTTP-EQUIV='refresh' CONTENT='0;URL=../../clientedigitaliza/controlador/actaInicioPDF.php?idactacontrol=".$idactacontrol."'/>";
                } else {
                    $error = 1;
                    $mensajerror = $objadjunto->getMensajeError();
                }
                // $exitoso = 1;
            }
        }
    }
}
?>