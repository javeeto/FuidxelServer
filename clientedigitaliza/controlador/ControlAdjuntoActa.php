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
 * Descripcion del codigo de ControlAdjuntoActa
 * 
 * @file CiontrolAdjuntoActa.php
 * @author Javier Lopez Martinez
 * @date 5/11/2016
 * @brief Contiene ...
 */
class ControlAdjuntoActa {

    /**
     * Arreglo de datos de acta
     *
     * @var Array
     */
    private $datosacta;

    /**
     * Identificador de acta control
     *
     * @var Integer
     */
    private $idactacontrol;

    /**
     * Diferencia adjunto con un consecutivo
     *
     * @var Integer
     */
    private $iadjunto;    

    /**
     * Descripcion de error del proceso de cargue
     *
     * @var String
     */
    private $mensajeError;

    /**
     * Descripcion de exito del proceso de cargue
     *
     * @var String
     */
    private $mensajeExito;

    /**
     * Ruta del documento adjuntado
     *
     * @var String
     */
    private $rutaDocumento;

    /**
     * nombre del documento adjuntado
     *
     * @var String
     */
    private $nombreDocumento;

    /**
     * Arreglo de datos de repositorio activo
     *
     * @var Array
     */
    private $datosRepo;

    /**
     * Indicador si proceso remplaza existente
     *
     * @var Bool
     */
    private $remplazar;

    function __construct() {
        $this->remplazar = 1;
        $this->debug = 0;
        $this->iadjunto=1;
    }

    public function debug() {
        $this->debug = 1;
    }

    /**
     * @brief Define id acta control
     * 
     * Define  identificador de acta control
     * 
     * @param Integer $idactacontrol identificador acta
     */
    function setIdactacontrol($idactacontrol) {
        $this->idactacontrol = $idactacontrol;
    }

    /**
     * @brief Define arreglo de datos acta 
     * 
     * Define  arreglo de datos acta 
     * 
     * @param Array $datosacta datos acta
     */
    function setDatosActa($datosacta) {
        $this->datosacta = $datosacta;
    }
    
    /**
     * @brief Identificador por adjunto
     * 
     * Consecutivo o identificador de 
     * adjunto
     * 
     * @param Integer $iadjunto identificador adjunto
     */    
    function setIAdjunto($iadjunto) {
        $this->iadjunto = $iadjunto;
    }

        /**
     * @brief Obtiene mensaje de error
     * 
     * Obtiene mensaje de error
     * 
     * @return String  mensaje de error
     */
    function getMensajeError() {
        return $this->mensajeError;
    }

    /**
     * @brief Obtiene url ruta documento
     * 
     * Obtiene url ruta documento
     * 
     * @return String  ruta documento
     */
    function getRutaDocumento() {
        return $this->rutaDocumento;
    }

    /**
     * @brief Obtiene nombre documento
     * 
     * Obtiene nombre del documento
     * 
     * @return String  nombre documento
     */
    function getNombreDocumento() {
        return $this->nombreDocumento;
    }

    /**
     * @brief Obtiene mensaje de exito
     * 
     * Obtiene mensaje de exito
     * 
     * @return String de mensaje de exito
     */
    function getMensajeExito() {
        return $this->mensajeExito;
    }

    /**
     * @brief Define arreglo de datos repositorio 
     * 
     * Define  arreglo de datos de repositorio 
     * 
     * @param Array $datosRepo datos repositorio
     */
    function setDatosRepo($datosRepo) {
        $this->datosRepo = $datosRepo;
    }

    /**
     * @brief Carga adjunto de archivo de adjunto
     * 
     * Carga archivo adjunto de acta
     * 
     * @return String ruta final del archivo adjunto
     */
    function cargarArchivoAdjunto($datosarchivo,$nombreadjunto="nombrecertificado") {

        $nombrearchivo = $datosarchivo[$nombreadjunto]['name'];
        $tipo_archivo = $datosarchivo[$nombreadjunto]['type'];
        $tamano_archivo = $datosarchivo[$nombreadjunto]['size'];
        $temporalarchivo = $datosarchivo[$nombreadjunto]['tmp_name'];

        if ($this->debug) {
            echo "datosarchivo<pre>";
            print_r($datosarchivo);
            echo "</pre>";
            echo "datosrepo<pre>";
            print_r($this->datosRepo);
            echo "</pre>";
        }

        if (!file_exists($temporalarchivo)) {
            $this->mensajeError.=ERR0307;
            return 0;
        }

        $extension = explode(".", $nombrearchivo);

        if ($tamano_archivo > TAMANOPERMITIDOADJUNTO) {
            $this->mensajeError.=ERR0315 . " de " . (TAMANOPERMITIDOADJUNTO / 1024) . " KB";
            return 0;
        }

        if ("PDF" != strtoupper($extension[(count($extension) - 1)])) {
            $this->mensajeError.=ERR0308;
            return 0;
        }
        $this->nombreDocumento = $this->idactacontrol . "_".$this->iadjunto.".pdf";

        if (!is_dir($this->datosRepo["rutarepositorio"] . "/actas")) {
            mkdir($this->datosRepo["rutarepositorio"] . "/actas", 0777, true);
        }
        if ($this->debug) {
            echo "\n<br>mkdir(" . $this->datosRepo["rutarepositorio"] . "/actas";
        }

        $this->rutaDocumento = $this->datosRepo["rutarepositorio"] . "/actas/" . $this->nombreDocumento;
        if (file_exists($this->rutaDocumento)) {
            if ($this->remplazar) {

                if (copy($this->rutaDocumento, "/tmp/" . $this->nombreDocumento)) {
                    $this->mensajeExito.=ERR0310;
                    unlink($this->rutaDocumento);
                } else {
                    $this->mensajeError.=ERR0311;
                    return 0;
                }
            } else {
                $this->mensajeError.=ERR0312;
                return 0;
            }
        }


        if (copy($temporalarchivo, $this->rutaDocumento)) {

            if (!file_exists($this->rutaDocumento)) {
                $this->mensajeError.= ERR0309 . " " . $temporalarchivo . " " . $this->rutaDocumento;
                return 0;
            } else {
                $tamano = round(filesize($this->rutaDocumento) / 1024);
                if (filesize($this->rutaDocumento) <= 1000) {
                    $this->mensajeError.=ERR0313;
                    return 0;
                } else {
                    $this->mensajeExito.=ERR0314;
                    return 1;
                }
            }
        } else {
            $this->mensajeError.= ERR0309 . " " . $temporalarchivo . " " . $filepath;
            return 0;
        }
    }

    /**
     * @brief Convierte pdf adjunto en imagenes
     * 
     * Convierte adjunto pdf en una lista de imagenes
     * 
     * @return String ruta final del archivo adjunto
     */
    function convertirAdjuntoImagen($rutaadjunto) {
        
        //$this->nombreDocumento = $nombreadjunto;
        //$this->rutaDocumento = $this->datosRepo["rutarepositorio"] . "/actas/" . $this->nombreDocumento;
        $this->rutaDocumento = $rutaadjunto;
        $rutaimagenes=$this->datosRepo["rutarepositorio"] . "/actas/" . $this->idactacontrol;
        $imgscreadas = 0;
        if (!is_dir($rutaimagenes)) {
            mkdir($rutaimagenes, 0777, true);
        } else {
            $datosdir = scandir($rutaimagenes);
            //print_r($datosdir);
            if (count($datosdir) > 2) {
                $imgscreadas = 1;
            }
        }

        $rutadestino = $rutaimagenes . "/img_" . $this->idactacontrol.".jpg";
        if (!$imgscreadas) {
            $objimagen = new EdicionImagen($this->rutaDocumento);
            $objimagen->setRutaDestino($rutadestino);
            $objimagen->comprimeJPG();
        }
        $imagenes["imagenes"] = scandir($rutaimagenes);
        $imagenes["dir"] = $rutaimagenes;    
        return $imagenes;
    }

}
