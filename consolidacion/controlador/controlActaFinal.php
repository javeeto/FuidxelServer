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
require_once '../../libreria/general/modelo/GestionMetadato.php';
require_once '../../libreria/general/vista/FormularioBase.php';
require_once '../../administracion/modelo/GestionUsuario.php';
require_once '../../administracion/modelo/GestionConfiguracion.php';
require_once '../../clientedigitaliza/modelo/GestionLoteImagen.php';
require_once '../../clientedigitaliza/modelo/GestionActaInicio.php';
require_once '../../consolidacion/controlador/FormaActaFinal.php';
require_once '../../consolidacion/controlador/ControlImagenIndexa.php';
require_once '../../consolidacion/modelo/GestionImagen.php';
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
        $objforma = new FormaActaFinal($objformulario);
        $objacta = new GestionActaInicio($objbase);
        $objimagen = new GestionImagen($objbase);
        $objmetadato = new GestionMetadato($objbase);
        $objcontindexa = new ControlImagenIndexa();
        $objadjunto = new ControlAdjuntoActa();
        $objadjunto2 = new ControlAdjuntoActa();
        $objadjunto3 = new ControlAdjuntoActa();
        $objcontindexa->setObjGestionImagen($objimagen);
        $objcontindexa->setObjMetadato($objmetadato);
        $datosacta["idloteimagen"] = limpiaCadena($_GET["idloteimagen"]);
        $objcontindexa->setIdLoteImagen($datosacta["idloteimagen"]);
        $objloteimagen->setIdLoteImagen($datosacta["idloteimagen"]);
//        $objloteimagen->debug();
        $datoslote = $objloteimagen->consultaLotesEscaneo();
        $datosgrupoimagen = $objcontindexa->separaDocumentoImagen();
        $objconfiguracion->consultarRegistrosConfiguracion();
        $datosacta["idtipoactacontrol"] = 2;
        $datosacta["idrepositorio"] = $datosRepo["idrepositorio"];




        //$objlote = new GestionLoteImagen();
        //$objusuario->debug();
        $datosusuario = $objusuario->consultaDatosUsuario();

        if (isset($_POST["Enviar"])) {
            $_POST["idtipoactacontrol"] = 2;
            $_POST["idrepositorio"] = $datosRepo["idrepositorio"];
            $datosacta = $_POST;
            if (isset($_GET["idactacontrol"])) {
                $objacta->setIdactacontrol($_GET["idactacontrol"]);
            }
        } else {

            if (isset($_GET["idactacontrol"])) {
                
            } else {

                $datosacta["identidad"] = $datosusuario["identidad"];
                $datosacta["documentoactacontrol"] = count($datosgrupoimagen);
                $datosacta["imagenacta"] = 0;
                $datosacta["serialmedio"] = $datoslote[0]["nombreescaner"];
                for ($condoc = 0; $condoc < $datosacta["documentoactacontrol"]; $condoc++) {
                    $datosacta["imagenacta"]+=count($datosgrupoimagen[$condoc]);
                }
                if (is_numeric($_GET["idloteimagen"])) {

                    $objloteimagen->setIdLoteImagen($_GET["idloteimagen"]);
                    $datoslote = $objloteimagen->consultaDatosLote();
                } else {
                    $error = 1;
                    $mensajerror = ERR0305;
                }

                /* if (is_numeric($_GET["idconfiguracion"])) {
                  //$datosacta["idlote"] = $_GET["idconfiguracion"];
                  $objconfiguracion->setIdConfiguracion($_GET["idconfiguracion"]);
                  $datosconfiguracion = $objconfiguracion->consultarRegistrosConfiguracion();
                  $datosacta["configuracion"] = $datosconfiguracion[0]["nombreconfiguracion"];
                  } else {
                  $error = 1;
                  $mensajerror = ERR0306;
                  } */
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

              //  $objacta->debug();

                $objacta->registroDatosActa();
                $idactacontrol = $objacta->getIdactacontrol();

                $objadjunto->setDatosActa($datosacta);
                $objadjunto->setDatosRepo($datosRepo);
                $objadjunto->setIdactacontrol($idactacontrol);

                $objadjunto2->setDatosActa($datosacta);
                $objadjunto2->setDatosRepo($datosRepo);
                $objadjunto2->setIdactacontrol($idactacontrol);
                $objadjunto2->setIAdjunto(2);

                $objadjunto3->setDatosActa($datosacta);
                $objadjunto3->setDatosRepo($datosRepo);
                $objadjunto3->setIdactacontrol($idactacontrol);
                $objadjunto3->setIAdjunto(3);

                // $objadjunto->debug();
                if ($objadjunto->cargarArchivoAdjunto($_FILES) &&
                        $objadjunto2->cargarArchivoAdjunto($_FILES, "certificadoprocedencia") &&
                        $objadjunto3->cargarArchivoAdjunto($_FILES, "certificadorevision")) {
                    $exitoso = 1;
                    $mensajerror = $objadjunto->getMensajeExito();

                    $datosadjunto["nombredocumento"] = $objadjunto->getNombreDocumento();
                    $datosadjunto["rutadocumento"] = $objadjunto->getRutaDocumento();
                    $objacta->registrarDatosAdjunto($datosadjunto);

                    $mensajerror2 = $objadjunto2->getMensajeExito();
                    $datosadjunto2["nombredocumento"] = $objadjunto2->getNombreDocumento();
                    $datosadjunto2["rutadocumento"] = $objadjunto2->getRutaDocumento();
                    $objacta->registrarDatosAdjunto($datosadjunto2);

                    $mensajerror3 = $objadjunto3->getMensajeExito();
                    $datosadjunto3["nombredocumento"] = $objadjunto3->getNombreDocumento();
                    $datosadjunto3["rutadocumento"] = $objadjunto3->getRutaDocumento();
                    $objacta->registrarDatosAdjunto($datosadjunto3);

                    $mensajerror .= $mensajerror2 . $mensajerror3 . ERR0201;
                    echo "<META HTTP-EQUIV='refresh' CONTENT='0;URL=../../consolidacion/controlador/actaFinalPDF.php?idactacontrol=" . $idactacontrol . "'/>";
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