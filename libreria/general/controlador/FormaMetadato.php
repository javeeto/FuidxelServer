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
 * Descripcion del codigo de FormaMetadato
 * 
 * @file FormaMetadato.php
 * @author Javier Lopez Martinez
 * @date 13/11/2016
 * @brief Contiene ...
 */
class FormaMetadato {

    /**
     *  Objeto de base de datos
     *
     * @var BaseGeneral
     */
    private $objbase;

    /**
     *  Objeto de formulario
     *
     * @var FormularioBase
     */
    private $objformulario;

    /**
     * Activacion del debug
     *
     * @var Bool
     */
    private $debug;

    /**
     * Arreglo de datos de grupo de metadatos
     *
     * @var Array
     */
    private $datosgrupometadato;

    /**
     * Arreglo de datos de metadatos
     *
     * @var Array
     */
    private $datosmetadato;

    /**
     * Arreglo de datos de campo
     *
     * @var Array
     */
    private $datoscampo;

    /**
     * Arreglo de valores de campo
     *
     * @var Array
     */
    private $valorcampos;

    /**
     * Objeto Gestion metadato
     *
     * @var GestionMetadato
     */
    private $objmetadato;

    /**
     * @brief Inicializacion de de objeto base y formulario
     * 
     * Iniciacion de objeto de base de datos y
     * objeto de formulario
     * 
     * @param BaseGeneral $objbase Objeto de base de datos
     * @param FormularioBase $objformulario Objeto de formulario
     * @return Nada
     */
    public function __construct($objbase, $objformulario) {
        $this->objbase = $objbase;
        $this->objformulario = $objformulario;
        $this->datosmetadato = array();
    }

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

    function getObjformulario() {
        return $this->objformulario;
    }

    /**
     * @brief Define arreglo de grupo metadato
     * 
     * Define arreglo de grupo metadato correspondientes 
     * a paneles en el formulario
     * 
     * @param Array $datosgrupometadato arreglo que agrupacion
     * @return Nada
     */
    function setDatosGrupoMetadato($datosgrupometadato) {
        $this->datosgrupometadato = $datosgrupometadato;
    }

    /**
     * @brief Define arreglo de metadatos
     * 
     * Define arreglo de metadatos correspondientes 
     * titulos de campo en el formulario
     * 
     * @param Array $datosmetadato arreglo que metadatos
     * @return Nada
     */
    function setDatosMetadato($datosmetadato) {
        $this->datosmetadato = $datosmetadato;
    }

    /**
     * @brief Define arreglo de campos metadatos
     * 
     * Define arreglo de campos de metadatos correspondientes 
     * a campos y valores en el formulario
     * 
     * @param Array $datosmetadato arreglo que metadatos
     * @return Nada
     */
    function setDatosCampo(Array $datoscampo) {
        $this->datoscampo = $datoscampo;
    }

    /**
     * @brief Define arreglo de valores de campos metadatos
     * 
     * Define arreglo de valores de campos de metadatos correspondientes 
     * a  valores resultantes de un registro recuperado 
     * en el formulario
     * 
     * @param Array $datosmetadato arreglo que metadatos
     * @return Nada
     */
    function setValorCampos($valorcampos) {
        $this->valorcampos = $valorcampos;
    }

    /**
     * @brief Define objeto de gestion metadato
     * 
     * Define objeto de datos de gestión metadato 
     * 
     * @param GestionMetadato $objmetadato Objeto de gestion metadato
     * @return Nada
     */
    function setObjMetadato($objmetadato) {
        $this->objmetadato = $objmetadato;
    }

    /**
     * @brief Inicializacion de de objeto base y formulario
     * 
     * Iniciacion de objeto de base de datos y
     * objeto de formulario
     * 
     * @param BaseGeneral $objbase Objeto de base de datos
     * @param FormularioBase $objformulario Objeto de formulario
     * @return Nada
     */
    public function panelNuevo($idgrupometadato) {
        for ($im = 0; $im < count($this->datosmetadato); $im++) {
            if ($this->debug) {
                echo "if (" . $this->datosmetadato[$im]["idgrupometadato"] . " == " . $idgrupometadato . ") {<br>";
            }
            if ($this->datosmetadato[$im]["idgrupometadato"] == $idgrupometadato) {
                $titulocampo = $this->datosmetadato[$im]["nombremetadato"];
                $nombre = $this->datosmetadato[$im]["nombrecortometadato"];
                $ayuda = $this->datosmetadato[$im]["ayudametadato"];
                unset($filacampo);

                $filacampo = $this->datoscampo[$this->datosmetadato[$im]["idmetadato"]];
                $division = (int) (9 / (count($filacampo)));
                unset($entradas);
                for ($ic = 0; $ic < count($filacampo); $ic++) {

                    switch ($filacampo[$ic]["nombrecortotipocampometadato"]) {
                        case "fecha":
                            $entradas[$ic]["tipo"] = $filacampo[$ic]["nombrecortotipocampometadato"];
                            $entradas[$ic]["nombre"] = $filacampo[$ic]["nombrecortocampometadato"];
                            $entradas[$ic]["division"] = $division;
                            $entradas[$ic]["validacion"] = $filacampo[$ic]["validacampometadato"];
                            $entradas[$ic]["valor"] = "";
                            if (isset($this->valorcampos[$filacampo[$ic]["idcampometadato"]])) {
                                $entradas[$ic]["valor"] = formato_fecha_defecto($this->valorcampos[$filacampo[$ic]["idcampometadato"]]);
                            }
                            if (isset($_POST[$filacampo[$ic]["nombrecortocampometadato"]])) {
                                $entradas[$ic]["valor"] = $_POST[$filacampo[$ic]["nombrecortocampometadato"]];
                            }
                            $entradas[$ic]["tamano"] = "50";
                            $entradas[$ic]["mensaje"] = $filacampo[$ic]["nombrecampometadato"];
                            $entradas[$ic]["mensaje2"] = $filacampo[$ic]["nombrecampometadato"];
                            $entradas[$ic]["patronCadena"] = $filacampo[$ic]["patroncampometadato"];



                            break;
                        case "menu":
                            $entradas[$ic]["tipo"] = $filacampo[$ic]["nombrecortotipocampometadato"];
                            $entradas[$ic]["nombre"] = $filacampo[$ic]["nombrecortocampometadato"];
                            $entradas[$ic]["division"] = $division;
                            $entradas[$ic]["validacion"] = $filacampo[$ic]["validacampometadato"];
                            $entradas[$ic]["valor"] = "";
                            if (isset($this->valorcampos[$filacampo[$ic]["idcampometadato"]])) {
                                $entradas[$ic]["valor"] = $this->valorcampos[$filacampo[$ic]["idcampometadato"]];
                            }
                            if (isset($_POST[$filacampo[$ic]["nombrecortocampometadato"]])) {
                                $entradas[$ic]["valor"] = $_POST[$filacampo[$ic]["nombrecortocampometadato"]];
                            }
                            $entradas[$ic]["tamano"] = "50";
                            $entradas[$ic]["mensaje"] = $filacampo[$ic]["nombrecampometadato"];
                            $entradas[$ic]["mensaje2"] = $filacampo[$ic]["nombrecampometadato"];
                            $entradas[$ic]["patronCadena"] = $filacampo[$ic]["patroncampometadato"];

                            unset($opciones);
                            $datosdetalle = $this->objmetadato->consultaDetalleCampo($filacampo[$ic]["idcampometadato"]);
                            for ($i = 0; $i < count($datosdetalle); $i++) {
                                $nombreopcion = $datosdetalle[$i]["nombrecortodetallecampo"];
                                $opciones[$datosdetalle[$i]["valordetallecampo"]] = $nombreopcion;
                            }
                            $entradas[$ic]["opciones"] = $opciones;

                            break;
                        default:
                            $entradas[$ic]["tipo"] = $filacampo[$ic]["nombrecortotipocampometadato"];
                            $entradas[$ic]["nombre"] = $filacampo[$ic]["nombrecortocampometadato"];
                            $entradas[$ic]["division"] = $division;
                            $entradas[$ic]["validacion"] = $filacampo[$ic]["validacampometadato"];
                            $entradas[$ic]["valor"] = "";
                            if (isset($this->valorcampos[$filacampo[$ic]["idcampometadato"]])) {
                                $entradas[$ic]["valor"] = $this->valorcampos[$filacampo[$ic]["idcampometadato"]];
                            }
                            if (isset($_POST[$filacampo[$ic]["nombrecortocampometadato"]])) {
                                $entradas[$ic]["valor"] = $_POST[$filacampo[$ic]["nombrecortocampometadato"]];
                            }
                            $entradas[$ic]["tamano"] = "50";
                            $entradas[$ic]["mensaje"] = $filacampo[$ic]["nombrecampometadato"];
                            $entradas[$ic]["mensaje2"] = $filacampo[$ic]["nombrecampometadato"];
                            $entradas[$ic]["patronCadena"] = $filacampo[$ic]["patroncampometadato"];



                            break;
                    }
                }


                $arraPanel["opcionMetadato"][] = $this->objformulario->campoCombinado($titulocampo, $nombre, $entradas, $ayuda);
                $arraPanel["errormetadato"][] = $this->objformulario->getEstiloError($entradas[0]["nombre"]);
                if ($this->debug) {
                    echo "entradas<pre>";
                    print_r($entradas);
                    //  echo $arraPanel["opcionMetadato"][$im];
                    echo "</pre>";
                }
            }
        }
        return $arraPanel;
    }

    /**
     * @brief Obtiene descripción de error
     * 
     * Obtiene descripción de error de acuerdo a
     * validación de campo de formulario
     * 
     * @return String error en formulario
     */
    public function getError() {
        return $this->objformulario->getError();
    }

    /**
     * @brief Procesa valores en registros de base
     * 
     * Procesa valores en registros de base
     * de datos y define el arreglo de valores 
     * de campo
     * 
     * @param Array $registros arreglo de registros
     * @return String error en formulario
     */
    public function registrosValores($registros) {
        $tmpcampos = $this->datoscampo;
        foreach ($tmpcampos as $idmetadato => $campos) {
            foreach ($campos as $icampo => $filacampo) {
                switch ($filacampo["nombrecortotipocampometadato"]) {
                    case "valor":
                        $this->valorcampos[$filacampo["idcampometadato"]] = $registros[$filacampo["idcampometadato"]]["valorregistrometadato"];
                        break;
                    case "fecha":
                        $this->valorcampos[$filacampo["idcampometadato"]] = $registros[$filacampo["idcampometadato"]]["valorfecharegistrometadato"];
                        break;
                    default:
                        $this->valorcampos[$filacampo["idcampometadato"]] = $registros[$filacampo["idcampometadato"]]["valortextoregistrometadato"];
                        break;
                }
            }
        }
    }

    /**
     * @brief Procesa valores en registros de base
     * 
     * Procesa valores en registros de base
     * de datos y define el arreglo de valores 
     * de campo
     * 
     * @param Array $registros arreglo de registros
     * @return String error en formulario
     */
    public function recuperaRegistroEnviado($iddetalledocumento) {
        $tmpcampos = $this->datoscampo;
        $ireg = 0;

        foreach ($tmpcampos as $idmetadato => $campos) {
            foreach ($campos as $icampo => $filacampo) {
                $registrosmetadato[$ireg]["idcampometadato"] = $filacampo["idcampometadato"];
                $registrosmetadato[$ireg]["iddetalledocumento"] = $iddetalledocumento;

                switch ($filacampo["nombrecortotipocampometadato"]) {
                    case "valor":
                        $registrosmetadato[$ireg]["valorregistrometadato"] = limpiaCadena($_POST[$filacampo["nombrecortocampometadato"]]);
                        break;
                    case "fecha":
                        if (validarFecha($_POST[$filacampo["nombrecortocampometadato"]])) {
                            $registrosmetadato[$ireg]["valorfecharegistrometadato"] = $_POST[$filacampo["nombrecortocampometadato"]];
                        }
                        break;
                    default:
                        $registrosmetadato[$ireg]["valortextoregistrometadato"] = limpiaCadena($_POST[$filacampo["nombrecortocampometadato"]]);
                        break;
                }

                $ireg++;
            }
        }
        if ($this->debug) {
            echo "POST<pre>";
            print_r($_POST);
            echo "registrosmetadato<pre>";
            print_r($registrosmetadato);
            echo "</pre>";
        }

        return $registrosmetadato;
    }

}
