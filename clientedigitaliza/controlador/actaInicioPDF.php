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
 * Descripcion del codigo de actaInicioPDF
 * 
 * @file actaInicioPDF.php
 * @author Javier Lopez Martinez
 * @date 7/11/2016
 * @brief Contiene ...
 */
header("Expires: Thu, 27 Mar 1980 23:59:00 GMT"); //la pagina expira en una fecha pasada
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora
header("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header("Pragma: no-cache");

require_once '../../conexion/idioma/entrada.php';
require_once '../../conexion/constantes.php';
require_once '../../conexion/constantesatelite.php';
require_once '../../conexion/constanteerror.php';
require_once '../../conexion/conexiondb.php';
require_once '../../libreria/general/modelo/BaseGeneral.php';
require_once '../../libreria/general/modelo/FuncionesSeguridad.php';
require_once '../../libreria/general/controlador/FuncionesCadena.php';
require_once('../../libreria/tcpdf/config/lang/spa.php');
require_once('../../libreria/tcpdf/tcpdf.php');
require_once('../../clientedigitaliza/controlador/PDFExtendido.php');
require_once '../../clientedigitaliza/modelo/GestionActaInicio.php';
require_once '../../clientedigitaliza/modelo/GestionLoteImagen.php';
require_once '../../satelite/controlador/EdicionImagen.php';
require_once '../../clientedigitaliza/controlador/ControlAdjuntoActa.php';

function borrarImagenes($imagenes) {
    for ($i = 0; $i < count($imagenes); $i++) {
        unlink("../../cargue/" . $imagenes[$i]);
    }
}

session_start();
$conexionmysql = connectionMysqlPDO();
$objbase = new BaseGeneral($conexionmysql);
$objseguridad = new FuncionesSeguridad($_SESSION["s_nombreusuario"], $objbase);
if ($objseguridad->validaOpcionUsuario("gestiondigitaliza")) {
    $pdf = new PDFExtendido('P', 'mm', 'A4', true, 'UTF-8', false, true);
    $actaHtml = "http://localhost/fuixel/clientedigitaliza/vista/actainiciocontenido.php";
    $html = file_get_contents($actaHtml);
    $objloteimagen = new GestionLoteImagen($objbase);
    $objadjunto = new ControlAdjuntoActa();
    $objacta = new GestionActaInicio($objbase);

    $objloteimagen->consultaRepoActivo("3");
    $datosRepo = $objloteimagen->getDatosRepoActivo();

    $objacta->setIdactacontrol($_GET["idactacontrol"]);
    $objadjunto->setIdactacontrol($_GET["idactacontrol"]);
    $datosadjunto = $objacta->consultaAdjuntoActa();
    $idactacontrol = limpiaCadena($_GET["idactacontrol"]);
    $objadjunto->setDatosRepo($datosRepo);
    $imagenes = $objadjunto->convertirAdjuntoImagen();
    /* echo "IMAGENES<pre>";
      print_r($imagenes);
      echo "</pre>"; */
    $certificadohtml = '';
    $conimagen = 0;
    //unset($_SESSION["s_datosimagenes"]["thumbnail"]);
    for ($i = 0; $i < count($imagenes["imagenes"]); $i++) {
        if (trim($imagenes["imagenes"][$i]) != '.' &&
                trim($imagenes["imagenes"][$i]) != '..') {

            $_SESSION["s_datosimagenes"]["thumbnail"][$conimagen] = $imagenes["dir"] . "/" . $imagenes["imagenes"][$i];
            $rutaimagen = $imagenes["dir"] . "/" . $imagenes["imagenes"][$i];

            //$certificadohtml.='<img src="../../satelite/controlador/mostrarImagen.php?idimagen=' . $conimagen . '" />';
            $nombrearchivo = time() . "_" . $idactacontrol . "_" . $conimagen . ".jpg";
            $imagenborra[]=$nombrearchivo;
            if (copy($rutaimagen, "../../cargue/" . $nombrearchivo)) {
                $certificadohtml.='<img src="../../cargue/' . $nombrearchivo . '" /><br/>';
            } else {
                
            }
            $conimagen++;
        }
    }
    /*     echo "IMAGENES<pre>";
      print_r($_SESSION["s_datosimagenes"]);
      echo "</pre>"; */

    //$objacta->debug();
    $tmpdatosacta = $objacta->consultaActaControl();
    $datosacta = $tmpdatosacta[0];
    //var_dump($tmpdatosacta);
    $html = str_replace("<varphp>nombreentidad</varphp>", $datosacta["nombreentidad"], $html);
    $html = str_replace("<varphp>idlote</varphp>", $datosacta["idloteimagen"], $html);
    $html = str_replace("<varphp>documentoactacontrol</varphp>", $datosacta["documentoactacontrol"], $html);
    $html = str_replace("<varphp>nombregrupousuario</varphp>", $datosacta["nombregrupousuario"], $html);
    $html = str_replace("<varphp>configuraactacontrol</varphp>", $datosacta["configuraactacontrol"], $html);
    $html = str_replace("<varphp>fechaactacontrol</varphp>", $datosacta["fechaactacontrol"], $html);
    $html = str_replace("<varphp>fechaimpresion</varphp>", date("Y-m-d H:i:s"), $html);
    $nombreusuario = $datosacta["nombrepersona"] . " " . $datosacta["apellidopersona"];
    $html = str_replace("<varphp>nombreusuario</varphp>", $nombreusuario, $html);
    $html = str_replace("<varphp>certificado</varphp>", $certificadohtml, $html);
    // echo $html;
//echo $actaHtml;
    //exit();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
//$pdf->setLanguageArray($l);
    $pdf->SetFont('times', 'B', 9);
    $pdf->AddPage();
    //$html = file_get_contents($actaHtml);
    $pdf->writeHTML($html);
//$pdf->lastPage();
    $mktime = time();
//$pdf->Output('/tmp/'.$mktime.'.pdf', 'F');
    $pdf->Output('/tmp/' . $mktime . '.pdf', 'D');
    borrarImagenes($imagenborra);
    unset($_SESSION["s_datosimagenes"]["thumbnail"]);
}