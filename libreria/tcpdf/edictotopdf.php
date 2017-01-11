<?php

//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
//============================================================+
// File name   : example_021.php
// Begin       : 2008-03-04
// Last Update : 2010-08-08
//
// Description : Example 021 for TCPDF class
//               WriteHTML text flow
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               Manor Coach House, Church Hill
//               Aldershot, Hants, GU12 4RQ
//               UK
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: WriteHTML text flow.
 * @author Nicola Asuni
 * @since 2008-03-04
 */
 /*ini_set('error_reporting', ~E_NOTICE);
  ini_set('display_errors', 1);*/
  session_start();
require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');
require_once('../../conexion/connAdodb.php');
require_once('../../funciones/adodb/adodb.inc.php');
require_once('../../funciones/adodb/adodb-active-record.inc.php');
require_once("../../funciones/clasebasesdedatosgeneral.php");
require_once("../../funciones/FuncionesFecha.php");
require_once("../../funciones/FuncionesCadena.php");
require_once("../../libreria/nuSoap/nusoap.php");
require_once("../../libreria/DocManager.php");
require_once("../../libreria/OficioSIC.php");
require_once('../../libreria/TramiteEdicto.php');
require_once("../../libreria/AdministraIndexacion.php");
require_once("../../libreria/AdministradorDigitalizacion.php");
require_once("../../libreria/ActoAdministrativoIFX.php");
require_once("../../libreria/ActoAdministrativoPsql.php");
require_once("../../libreria/DigitalizacionRadicacion.php");



$conexionifx = connectionIfxADODB();
$objetobase = new BaseDeDatosGeneral($conexionifx);
$objindexa = new AdministraIndexacion($objetobase);
$idpe_cles = $_SESSION["usuariosesion"]["idpe_cles"];
$objindexa = new AdministraIndexacion($objetobase);
$lote = $idppecles . mktime(0, 0, 0, date("m"), date("d"), date("Y"));
$objindexa->setIdLote($lote);
/*
$objindexa->setDatosImagenes($_SESSION["sesiondatosimagenes"]);
$objindexa->setImagenes($_SESSION["sesionimagenes"]);
$objindexa->setImagenesPrevia($_SESSION["sesionimagenesprevia"]);
$objindexa->setImagenesSeparador($_SESSION["sesionimagenesseparador"]);
$objindexa->setIndiceSeparador($_GET["indiceseparador"]);*/
$objindexa->setIdUsuarioCliente($idpe_cles);


$numeacto = $_GET["numeacto"];
$tipoacto = $_GET["tipoacto"];
$fechacto = $_GET["fechacto"];

$objTramiteEdicto = new TramiteEdicto($objetobase);
$objTramiteEdicto->setNumeroActo($tipoacto, $numeacto, $fechacto);
$_SESSION["notificadosesion"] = $objTramiteEdicto->consultaNotificado();

// create new PDF document
$pdf = new TCPDF();

// set document information
//$pdf->SetCreator(PDF_CREATOR);
// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 021', PDF_HEADER_STRING);
// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//set auto page breaks
$pdf->SetAutoPageBreak(TRUE);

//set image scale factor
//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------
// set font
$pdf->SetFont('helvetica', '', 9);

// add a page
$pdf->AddPage();

// create some HTML content
//$html = '<h1>Example of HTML text flow</h1>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. <em>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur?</em> <em>Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</em><br /><br /><b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i><br /><br /><b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u>';
$html = file_get_contents("http://10.20.4.42/jlopezm/GestionDocumentalProd2/Digitalizacion/Edictos/ApEdictos3/edicto.php?numeacto=" . $numeacto . "&tipoacto=" . $tipoacto . "&fechacto=" . $fechacto);
//$html = file_get_contents("http://10.20.100.139/GestionDocumentalProd2/Digitalizacion/Edictos/ApEdictos3/edicto.php?numeacto=" . $numeacto . "&tipoacto=" . $tipoacto . "&fechacto=" . $fechacto);
//$html="Ejemplo1 <br>";
//$html.="<img src='http://10.20.100.139/GestionDocumentalProd2/Digitalizacion/Edictos/ApEdictos3/tmpres/TMPvypiGG.jpg' />";
//$html='<br />Ejemplo2 <br />';
//$html.='<img src="tcpdf/images/image_demo.jpg" width="50" height="50" />';
/* $html=' <table width="795px">
  <tr>
  <td><center><h3>SUPERINTENDENCIA DE INDUSTRIA Y COMERCIO</h3></center></td>
  </tr>

  <tr>
  <td>
  RADICACIÓN: <b>11-53083  </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  EDICTO No. <b>23</b>
  <br><br>
  </td>
  </tr>
  <tr><td>
  NOMBRE DEL NOTIFICADO: <b>JOSE MANUEL CRUZ GARCIA</b><br>
  APODERADO O REPRESENTANTE LEGAL DE: <b>GENOMMA LAB COLOMBIA LTDA.</b> <br>
  <br>
  </td></tr>
  <tr><td>
  <center><b>EL GRUPO DE NOTIFICACIONES Y CERTIFICACIONES</b></center>
  </td></tr>
  <tr><td>
  <center><b>HACE SABER:</b></center>

  <br>
  </td></tr>
  <tr><td>
  Que esta Superintendencia profirió <b></b> No. <b>1887</b> de <b>01/02/2017</b>. Que el contenido de la parte resolutiva es como sigue:

  .<br><br>
  </td></tr>
  <tr><td>

  <center><b>RESUELVE</b></center>
  </td></tr>
  <tr><td>
  <center><img src="http://10.20.100.139/GestionDocumentalProd2/Digitalizacion/Edictos/ApEdictos3/tmpres/TMPKkq3AW.png" width="85" name="ImagActo" /><br /><img src="http://10.20.100.139/GestionDocumentalProd2/Digitalizacion/Edictos/ApEdictos3/tmpres/TMPKuWTe4.png" width="85" name="ImagActo" /><br /></center>

  <br>
  </td></tr>
  <tr><td>
  Que el presente edicto se publica hoy <b>02/09/2015</b> en el sitio de atenci&oacute;n al p&uacute;blico (Piso 3) y en la p&aacute;gina web de la superintendencia de industria y comercio por el termino de
  diez d&iacute;as h&aacute;biles, esto es hasta el <b>02/08/2016</b> <br>
  </td></tr>
  <tr><td>
  <center>
  <b><img src="http://10.20.100.139/GestionDocumentalProd2/Digitalizacion/Edictos/ApEdictos3/tmpres/TMPCxPFge.jpg" width="30" /><br /></b><br>
  <b>ANGELICA MARIA ACUÑA PORRAS                       </b><br>
  <b>SECRETARIA GENERAL                                                                                                                                                                                                                                             </b><br>
  </center>
  </td></tr>

  </table>



  '; */

//echo $html;
//exit();
// output the HTML content
$pdf->writeHTML("Sale?".$html);

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------
//Close and output PDF document
$mktime=mktime();



if ($_GET["Radicar"]) {
    $pdf->Output('/tmp/'.$mktime.'.pdf', 'F');
     chmod('/tmp/'.$mktime.'.pdf', 0777);
    $indicadorRadicado=0;
    if (!$objTramiteEdicto->validaExisteRadicado()) {
        $radicadoArray=$objTramiteEdicto->enviarRadicacion($_SESSION["notificadosesion"]["iden_pers"]); 
        $indicadorRadicado=1;
    }
    $radicadoArray=$objTramiteEdicto->getRadicado();
    
    $datosarchivo['archivo']['name'] = $mktime.'.pdf';
    $datosarchivo['archivo']['type'] = filetype('/tmp/'.$mktime.'.pdf');
    $datosarchivo['archivo']['size'] = filesize('/tmp/'.$mktime.'.pdf');
    $datosarchivo['archivo']['tmp_name'] = '/tmp/'.$mktime.'.pdf';

/*    
    echo "<pre>";
    print_r($radicadoArray);
    echo "</pre>";*/

     if($radicadoArray["ANORADI"]<50){
         $IndxManual["ano_radi"] = "20".agregarceros($radicadoArray["ANORADI"], 2);
    
    }
    else{
        $IndxManual["ano_radi"] = "19".agregarceros($radicadoArray["ANORADI"], 2);
         
    }
    
    
    $IndxManual["nume_radi"] = $radicadoArray["NUMERADI"];
    $IndxManual["cons_radi"] = $radicadoArray["CONSRADI"];
    $IndxManual["cont_radi"] = $radicadoArray["CONTRADI"];
    $IndxManual["numeropaquete"] = 1;
    /* ini_set('error_reporting', E_ALL);
      ini_set('display_errors', 1); */

    $objindexa->objbase->conexion->debug = 1;
    $salida = $objindexa->guardarIndexacionManual("radicacion", $IndxManual, $datosarchivo, 1);
    if(trim($salida)=="Documento indexado correctamente"){
        $indexado=1;
    }else{
        $indexado=0;
    }
       
    //echo "<br>?Salida=<pre>".print_r($salida)."</pre>";
    $indicadorIndexado=0;
    if($salida["exito"]){
        $indicadorIndexado=1;    
    }
    
    echo $IndxManual["ano_radi"].";".$IndxManual["nume_radi"].";".$IndxManual["cont_radi"].";".$IndxManual["cons_radi"].
        ";".$indicadorRadicado.";".$indicadorIndexado.";".$salida["mensaje"].";".$_GET["CodigoChequeo"];
    unlink('/tmp/'.$mktime.'.pdf');
}else{
    
$pdf->Output('/tmp/'.$mktime.'.pdf', 'I');
//chmod('/tmp/'.$mktime.'.pdf', 0777);
}

//============================================================+
// END OF FILE                                                
//============================================================+
