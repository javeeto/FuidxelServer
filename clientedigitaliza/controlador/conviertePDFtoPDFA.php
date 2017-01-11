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
 * Descripcion del codigo de conviertePDFtoPDFA
 * 
 * @file conviertePDFtoPDFA.php
 * @author Javier Lopez Martinez
 * @date 28/11/2016
 * @brief Contiene ...
 */
require_once('../../libreria/tcpdf/tcpdf.php');
require_once('../../libreria/fpdi/fpdi.php');
require_once('../../libreria/general/controlador/PDFAExtendido.php');
require_once('../../libreria/general/controlador/FuncionesCadena.php');

$ruta = limpiaCadenaUrl($_GET["ruta"]);
$rutafinal = $ruta;
//$ruta="/tmp/conversionocr/2016110023000036/salida.pdf";
//$rutafinal = "/tmp/conversionocr/2016110023000036/salida2.pdf";

$objpdfa = new PDFAExtendido('P', 'mm', 'A4', true, 'UTF-8', false, true);
$objpdfa->debug();
$objpdfa->SetFont('times', '', 12, '', true);
$objpdfa->setRutaOrigen($ruta);
$objpdfa->setRutaDestino($rutafinal);
echo "\n".$objpdfa->generaPDFA();
//$ruta=$_GET["ruta"];
//$rutafinal =$ruta;
//echo convertirPdfa($ruta, $rutafinal);
