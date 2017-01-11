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
 * Description of InformacionLote
 *
 * @author javeeto
 */
class InformacionLote {

    /**
     * Activacion del debug
     *
     * @var Bool
     */
    private $debug;

    /**
     *  Objeto de conexion base de datos
     *
     * @var BaseGeneral
     */
    private $objbase;

    /**
     * Objeto de control de imagen
     *
     * @var ControlImagenIndexa
     */
    private $objimagenindexa;

    /**
     * Objeto de datos de documento
     *
     * @var GestionDocumento
     */
    private $objgestiondocumento;

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
     * @brief Inicializacion de variables de conexion
     * 
     * Iniciacion de variables y cadenas de conexion BD
     * 
     * @param[in] objbase recurso de base de datos.
     * @return Nada
     */
    public function __construct($objbase) {

        $this->debug = 0;
        $this->datosgrupoimagen = array();
        $this->idocumento = 0;
        $this->objbase = $objbase;
    }

    /**
     * @brief Define identificador de lote
     * 
     * Define identificador de lote
     * 
     * @return Nada
     */
    function setIdLoteImagen($idloteimagen) {
        $this->idloteimagen = limpiaCadena($idloteimagen);
    }

    /**
     * @brief Define objeto de manego de lote
     * 
     * Objeto con logica de manejo de lote, agrupacion de 
     * documentos
     * 
     * @return Nada
     */
    function setObjImagenIndexa($objimagenindexa) {
        $this->objimagenindexa = $objimagenindexa;
    }

    /**
     * @brief Define datos de repositorio
     * 
     * Define datos de repositorio
     * 
     * @param GestionDocumento $objgestiondocumento datos repositorio
     * @return Nada
     */
    function setObjGestionDocumento($objgestiondocumento) {
        $this->objgestiondocumento = $objgestiondocumento;
    }

    /**
     * @brief Consulta informacion de imagenes,documentos
     * relacionados al lote
     * 
     * @param Integer $idloteimagen identificador de lote
     * @return Nada
     */
    function consultaInfoLoteDocumento($idloteimagen) {
        $objmetadato = new GestionMetadato($this->objbase);
        $objgestionimagen = new GestionImagen($this->objbase);
        $objmetadato->setIdFormulario(1);
        if ($this->debug) {
            echo "<pre>idloteimagen=" . $idloteimagen . "</pre>";
            $this->objimagenindexa->debug();
        }

        $this->objimagenindexa->setObjMetadato($objmetadato);
        $this->objimagenindexa->setObjGestionImagen($objgestionimagen);
        $this->objimagenindexa->setIdLoteImagen($idloteimagen);
        $grupoimagendocumento = $this->objimagenindexa->separaDocumentoImagen();
        foreach ($grupoimagendocumento as $congrupo => $grupoimagen) {

            if (trim($grupoimagen[0]["iddetalledocumento"]) != "1") {
                $objmetadato->setIdDetalleDocumento($grupoimagen[0]["iddetalledocumento"]);
                $datosmetadato = $objmetadato->consultaRegistroDocumento();

                $this->objgestiondocumento->setIddetalledocumento($grupoimagen[0]["iddetalledocumento"]);
                $datosdocumento = $this->objgestiondocumento->consultaDocumentoDetalle();
                $rutadocumento = $datosdocumento[0]["rutarepositorio"] . "/" . $datosdocumento[0]["rutadocumento"] . "/" . $datosdocumento[0]["rutadetalledocumento"];
                $datosindices[$congrupo] = $this->infoSistemaRutaPDF($rutadocumento);

                foreach ($datosmetadato as $idcampo => $datoscampo) {
                    $datosindices[$congrupo]["indice"].=$datoscampo["nombremetadato"] . ":" . $datoscampo["valordefinitivoregistro"] . "\n";
                }
            } else {
                $datosindices[$congrupo]["indice"] = "No indexado";
            }
            $datosindices[$congrupo]["secuencia"] = "Documento " . ($congrupo + 1);
        }
        return $datosindices;
    }

    /**
     * @brief Consulta informacion del sistema imagenes,documentos
     * relacionados al lote
     * 
     * @param String $rutadocumento url documento
     * @return Nada
     */
    function infoSistemaRutaPDF($rutadocumento) {

        $ejecutainfoimagenes = "pdfimages -list -q " . $rutadocumento . "|awk '{print $4 \",\" $5 \",\" $6 \",\" $13 \",\" $14 \",\" $15}'";
        $respuesta = exec($ejecutainfoimagenes, $salida, $retorno);

        if ($this->debug) {
            echo "<br>" . $ejecutainfoimagenes;
            echo "<pre>";
            echo "<br>respuesta<br>";
            print_r($respuesta);
            echo "<br>salida<br>";
            print_r($salida);
            echo "<br>retorno<br>";
            print_r($retorno);
            echo "</pre>";
        }

        $pdfimagedata = explode(",", $salida[2]);

        $pdfinfo["width"] = $pdfimagedata[0];
        $pdfinfo["height"] = $pdfimagedata[1];
        $pdfinfo["color"] = $pdfimagedata[2];
        $pdfinfo["resx"] = $pdfimagedata[3];
        $pdfinfo["resy"] = $pdfimagedata[4];
        $pdfinfo["sizepage"] = $pdfimagedata[5];


        $ejecutainfopdf = "pdfinfo " . $rutadocumento;
        $respuesta = exec($ejecutainfopdf, $salida, $retorno);

        if ($this->debug) {
            echo "<br>" . $ejecutainfopdf;
            echo "<pre>";
            echo "<br>respuesta<br>";
            print_r($respuesta);
            echo "<br>salida<br>";
            print_r($salida);
            echo "<br>retorno<br>";
            print_r($retorno);
            echo "</pre>";
        }

        if ($this->debug) {
            echo "pdfinfo<pre>";
            print_r($pdfinfo);
            echo "</pre>";
        }
        for ($i = 0; $i < count($salida); $i++) {

            $infodata = explode(":", $salida[$i]);
            if (trim($infodata[0]) == "File size") {
                $pdfinfo["sizefile"] = trim($infodata[1]);
            }
            if (trim($infodata[0]) == "Pages") {
                $pdfinfo["pages"] = trim($infodata[1]);
            }
            if (trim($infodata[0]) == "Page size") {
                $pdfinfo["pagesize2"] = trim($infodata[1]);
            }
        }
        return $pdfinfo;
    }

}
