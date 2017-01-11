<?php

/**
 * Servidor de Webservices para la aplicación del estandar pdf/a a un documento pdf
 *
 * Este servidor de webservices proporciona los metodos necesarios para la aplicación del estandar pdf/a que
 * es requisito para la firma digital
 *
 * @package    Firma Digital
 * @author     Ing. Juan Manuel Rivera Cabezas <c.jmrivera@correo.sic.gov.co>
 * @copyright  2012 SuperIntendencia de Industria y Comercio
 * @license    
 * @version    v 1.0 2012/08/01 15:18:13

 */
ini_set('error_reporting', ~E_NOTICE);
ini_set('display_errors', 1);
date_default_timezone_set('America/Bogota');

/**
 * Aplicacion del estandar pdf/a al pdf que se indique 
 * @param string - Ruta absoluta del pdf
 * @return integer - Confirmación de modificación ( 1 - Exito, 0 - Fallo )  
 */
function convertirPdfa($ruta, $rutafinal) {

    //return dirname(__FILE__);

    require_once('../../libreria/tcpdf/tcpdf.php');
    require_once('../../libreria/fpdi/fpdi.php');

    class PDF extends FPDI {

        var $_tplIdx;

    }

    //Si el archivo de la ruta enviada no se puede modificar se debe realizar todo el proceso de 
    //cambio y escritura en la nueva ruta, actualizando las respectivas tablas y demas
    if (!is_writable($ruta)) {

        return 2;
    } else {
        // Inicializar el pdf
        /*$instruccionescaneo = "pdfinfo " . $ruta;

        $respuesta = exec($instruccionescaneo, $salida, $retorno);

        for ($i = 0; $i < count($salida); $i++) {
            $infoarray = explode(":", $salida[$i]);
            if (trim($infoarray[0]) == "Page size") {
                $infosize = str_replace("x", ",", $infoarray[1]);
                $infosize = str_replace("pts", "", $infosize);
                $pagesizes = explode(",", $infosize);
            }
        }*/


        $_SESSION["pagesizes"] = array(trim($pagesizes[0]), trim($pagesizes[1]));
        $pagesizes = array(trim($pagesizes[0]), trim($pagesizes[1]));
        echo "pagesizes<pre>";
        print_r($_SESSION["pagesizes"]);
        echo "</pre>";
        //$pdf->setPageSize($pagesizes);

        echo $instruccionescaneo = "pdfimages -list " . $ruta . "|awk '{print $4 \":\" $5}'";
        $respuesta = exec($instruccionescaneo, $salida, $retorno);

                echo "salida<pre>";
        print_r($salida);
        echo "<pre>";
        
        $siga = 0;
        for ($i = 0; $i < count($salida); $i++) {
            $salidanum = explode(":", $salida[$i]);
            if ($siga==1 &&
                    trim($salidanum[1]) != '') {
                $infoarray[] = explode(":", $salida[$i]);
            }
            if ($salida[$i] == "width:height") {
                $siga = 1;
            }

        }

        echo "infoarray<pre>";
        print_r($infoarray);
        echo "<pre>";
        $pdf = new PDF('P', 'mm', 'A4', true, 'UTF-8', false, true);


        $pdf->SetAutoPageBreak(true, 0);
        $pdf->setFontSubsetting(false);



        if (is_numeric($totapagi = $pdf->setSourceFile($ruta))) {

            for ($i = 1; $i <= $totapagi; $i++) {
                
                //$pdf->AddPage();
                $infoarray[($i - 1)][0]=$infoarray[($i - 1)][0]*0.246806039;
                $infoarray[($i - 1)][1]=$infoarray[($i - 1)][1]*0.225779967;
                $pdf->setPageSize($infoarray[($i - 1)]);
                
                if($infoarray[($i - 1)][0]>$infoarray[($i - 1)][1]){
                $pdf->AddPage('L', 'A4');
                }else{
                    $pdf->AddPage('P', 'A4');
                }
                $pdf->_tplIdx = $pdf->importPage($i);
                $pdf->useTemplate($pdf->_tplIdx);
            }

            $pdf->Output($rutafinal, 'F');
            return 1;
        }
        else
            return 3;
    }
}

session_start();
//$ruta = "/media/sf_digitalizacion/conversion/out/14282029--0000000001.PDF";
//$rutafinal = "/media/sf_digitalizacion/conversion/out/14282029--0000000001PDFA.PDF";
$ruta="/tmp/conversionocr/2016110023000036/salida.pdf";
$rutafinal="/tmp/conversionocr/2016110023000036/salida2.pdf";

//$ruta=$_GET["ruta"];
//$rutafinal =$ruta;
echo convertirPdfa($ruta, $rutafinal);
?>
