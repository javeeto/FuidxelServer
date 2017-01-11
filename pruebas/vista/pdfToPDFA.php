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
 * Descripcion del codigo de pdfToPDFA
 * 
 * @file pdfToPDFA.php
 * @author Javier Lopez Martinez
 * @date 28/11/2016
 * @brief Contiene ...
 */

header("Expires: Thu, 27 Mar 1980 23:59:00 GMT"); //la pagina expira en una fecha pasada
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora
header("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header("Pragma: no-cache");

require_once '../../conexion/idioma/entrada.php';
//require_once '../../conexion/constantes.php';
//require_once '../../conexion/constanteerror.php';
//require_once '../../conexion/conexiondb.php';
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


$ruta="/tmp/conversionocr/2016110023000036/salida.pdf";
$rutafinal="/tmp/conversionocr/2016110023000036/salida2.pdf";
$pdf = new PDFExtendido('P', 'mm', 'A4', true, 'UTF-8', false, true);

$pdf->SetAutoPageBreak(true, 0);

if (is_numeric($totapagi = $pdf->setSourceFile($ruta))) {
    $pdf->Output($rutafinal, 'F');
}