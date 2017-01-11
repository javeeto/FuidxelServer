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
 * Descripcion del codigo de PDFAExtendido
 * 
 * @file PDFAExtendido.php
 * @author Javier Lopez Martinez
 * @date 28/11/2016
 * @brief Contiene ...
 */
class PDFAExtendido extends FPDI {
    /* Plantilla tpl
     *
     * @var Bool
     */

    var $_tplIdx;

    /**
     * Activacion del debug
     *
     * @var Bool
     */
    private $debug;

    /**
     * Ruta de archivo origen
     *
     * @var String
     */
    private $rutaorigen;

    /**
     * Ruta de archivo destino
     *
     * @var String
     */
    private $rutadestino;

    /**
     * @brief Impresion debug
     * 
     * Activa Impresion de seguimiento debug 
     * 
     * @return Nada
     */
    public function debug() {
        $this->debug = 1;
    }

    /**
     * @brief Define ruta de origen
     * 
     * Define ruta de origen
     * 
     * @param String $rutaorigen Ruta de archivo origen 
     */
    function setRutaOrigen($rutaorigen) {
        $this->rutaorigen = $rutaorigen;
    }

    /**
     * @brief Define ruta de destino
     * 
     * Define ruta de destino
     * 
     * @param String $rutaorigen Ruta de archivo destino
     */
    function setRutaDestino($rutadestino) {
        $this->rutadestino = $rutadestino;
    }

    /**
     * @brief Extrae dimensiones de imagenes de pdf
     * 
     * Extrae dimenciones de imagenes de pdf
     * 
     * @return Array arreglo de par ancho alto imagen
     */
    public function tamanoImagenPDF() {
        $instruccionescaneo = "pdfimages -list " . $this->rutaorigen . "|awk '{print $4 \":\" $5}'";
        $respuesta = exec($instruccionescaneo, $salida, $retorno);

        if ($this->debug) {
            echo "salida<pre>";
            echo $instruccionescaneo;
            print_r($salida);
            echo "<pre>";
        }
        $siga = 0;
        for ($i = 0; $i < count($salida); $i++) {
            $salidanum = explode(":", $salida[$i]);
            if ($siga == 1 &&
                    trim($salidanum[1]) != '') {
                $infoarray[] = explode(":", $salida[$i]);
            }
            if ($salida[$i] == "width:height") {
                $siga = 1;
            }
        }
        return $infoarray;
    }

    /**
     * @brief Genera pdfa con ayuda de FPDI
     * 
     *  Genera pdfa con ayuda importanto archivo pdf 
     * de ruta de origen, recorre y genera cada pagina con 
     * formato correspondiente
     * 
     * @return Integer retorna codigo de error
     */
    public function generaPDFA() {



        $infoarray = $this->tamanoImagenPDF();

        $this->SetAutoPageBreak(true, 0);
        $this->setFontSubsetting(false);
        
        if ($this->debug) {
            echo "rutaorigen=".$this->rutaorigen;
        }


        if (!is_writable($this->rutaorigen)) {

            return 2;
        } elseif (is_numeric($totapagi = $this->setSourceFile($this->rutaorigen))) {

            for ($i = 1; $i <= $totapagi; $i++) {

                $infoarray[($i - 1)][0] = $infoarray[($i - 1)][0] * 0.246806039;
                $infoarray[($i - 1)][1] = $infoarray[($i - 1)][1] * 0.225779967;
                $this->setPageSize($infoarray[($i - 1)]);

                if ($infoarray[($i - 1)][0] > $infoarray[($i - 1)][1]) {
                    $this->AddPage('L', 'A4');
                } else {
                    $this->AddPage('P', 'A4');
                }
                $this->_tplIdx = $this->importPage($i);
                $this->useTemplate($this->_tplIdx);
            }

            $this->Output($this->rutadestino, 'F');
            return 1;
        } else {
            return 3;
        }
    }

}
