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
 * Descripcion del codigo de ejemploPDF
 * 
 * @file ejemploPDF.php
 * @author Javier Lopez Martinez
 * @date 7/11/2016
 * @brief Contiene ...
 */

require_once('../../libreria/tcpdf/config/lang/spa.php');
require_once('../../libreria/tcpdf/tcpdf.php');

class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file ='imagenes/encabezado-sic-todos_pais.jpg';
        $this->Image($image_file, 5, -5, 200,27, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        
        $image_file ='imagenes/MarcaAgua.jpg';
        $this->Image($image_file, 40, 80, 130,140, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        
        // Set font
        //$this->SetFont('helvetica', 'B', 20);
        // Title
        //$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
       // $this->SetY(100);
        
        $image_file ='imagenes/pie-sic-minCIT.jpg';
        $this->Image($image_file,0, 277, 210, 20, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    }
    /*
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }*/
}
$pdf = new MYPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
//$pdf->setLanguageArray($l);
$pdf->SetFont('helvetica', '', 9);
$pdf->AddPage();

 $html='<table>
  <tr>
  <td><h3>SUPERINTENDENCIA DE INDUSTRIA Y COMERCIO</h3></td>
  </tr>

  <tr>
  <td>
  RADICACI&Oacute;N: <b>11-53083  </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
  Que esta Superintendencia profiri&oacute; <b></b> No. <b>1887</b> de <b>01/02/2017</b>. Que el contenido de la parte resolutiva es como sigue:

  .<br><br>
  </td></tr>
  <tr><td>

  <center><b>RESUELVE</b></center>
  </td></tr>
  <tr><td>
  <center><br /></center>

  <br>
  </td></tr>
  <tr><td>
  Que el presente edicto se publica hoy <b>02/09/2015</b> en el sitio de atenci&oacute;n al p&uacute;blico (Piso 3) y en la p&aacute;gina web de la superintendencia de industria y comercio por el termino de
  diez d&iacute;as h&aacute;biles, esto es hasta el <b>02/08/2016</b> <br>
  </td></tr>


  </table>




  '; 
$pdf->writeHTML($html);
//$pdf->lastPage();
$mktime=time();
//$pdf->Output('/tmp/'.$mktime.'.pdf', 'F');
$pdf->Output('/tmp/'.$mktime.'.pdf', 'I');
?>