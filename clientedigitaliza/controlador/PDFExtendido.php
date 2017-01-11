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
 * Descripcion del codigo de PDFExtendido
 * 
 * @file PDFExtendido.php
 * @author Javier Lopez Martinez
 * @date 7/11/2016
 * @brief Contiene ...
 */
class PDFExtendido extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file ='../../clientedigitaliza/vista/imagenes/encabezado.jpg';
        $this->Image($image_file, 5, -5, 40,27, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        
      //  $image_file ='../../pruebas/vista/imagenes/MarcaAgua.jpg';
       // $this->Image($image_file, 40, 80, 130,140, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        
        // Set font
        //$this->SetFont('helvetica', 'B', 20);
        // Title
        //$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
       // $this->SetY(100);
        
        $image_file ='../../pruebas/vista/imagenes/pie-sic-minCIT.jpg';
       // $this->Image($image_file,0, 277, 210, 20, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
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