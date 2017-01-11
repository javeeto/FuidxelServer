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
 * Descripcion del codigo de FormularioBase
 * 
 * @file FormularioBase.php
 * @author Javier Lopez Martinez
 * @date 20/09/2016
 * @brief Contiene ...
 */
class FormularioBase {

    /**
     *  Arreglo de campos de validacion
     *  el indice es el nombre del campo
     *
     * @var Array
     */
    private $arregloValida;

    /**
     *  Error de campo en validacion
     *
     * @var String
     */
    private $errorValida;

    /**
     * Nombre campo de envio de formulario
     *
     * @var String
     */
    private $requestenviar;

    /**
     * Define si la validación del formulario es valida o no
     *
     * @var Arreglo
     */
    private $validoCampo;

    /**
     * Define si la validación del formulario es valida o no
     *
     * @var Bool
     */
    private $errorFormulario;

    /**
     * Contador que diferencia los calendarios
     *
     * @var int
     */
    private $contcalendario;

    public function __construct() {
        $this->valido = array();
        $this->contcalendario = 0;
        $this->errorFormulario = 0;
        $this->requestenviar = "Enviar";
    }

    /**
     * @brief Define nombre de campo de envio
     * 
     * Campo de envipo de formulario para saber cuando
     * se ejecuta submit de formulario y poder validar
     * @param String $requestenviar Envio de request
     */
    function setRequestenviar($requestenviar) {
        $this->requestenviar = $requestenviar;
    }

    /**
     * @brief Obtiene validacion 
     * 
     * Cadena de error de validacion
     *
     * @return String cadena de error de validacion
     */
    function getErrorValida() {
        return $this->errorValida;
    }

    /**
     * @brief Campo de entrada basico
     * 
     * Retorna html con campo de entrada basico forma bootstrap
     * @param titulocampo titulo de label del campo.
     * @param nombre nombre de variable de dom y request.
     * @param valor nombre de variable de dom y request.
     * @param validacion nombre de validacion a implementar
     * @param tamano tamaño limite de cadena en el valor 
     * @param mensaje mensaje descriptivo del campo
     * @param mensaje2 mensaje complementario del campo
     * @param ayuda si se desea agregar ayuda descriptiva de diligenciamiento
     * @return Cadena Html del campo de entrada.
     */
    public function campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2, $ayuda = "", $tipo = "text") {
        $entradaHTML = "";
        $this->arregloValida[$nombre] = $validacion;
        $this->valido[$nombre] = 1;

        if (isset($_REQUEST[$this->requestenviar])) {
            if (!$this->validaCampo($nombre)) {
//$this->mensajeValidar($nombre, $titulocampo);
// $entradaHTML .= "<div class=' has-error has-feedback '>";
                $this->valido[$nombre] = 0;
            }
        }

        $patron = $this->patronValidacion($validacion);
        if (isset($patron) &&
                trim($patron) != "") {
            if ($validacion == "requerido") {
                $patronCadena = "required";
            } else {
                $patronCadena = "pattern='" . $patron . "' required";
            }
        }
        if ($validacion == "readonly") {
            $patronCadena = "readonly='yes'";
        }

        $entradaHTML .="<label class='col-sm-2' for = '" . $nombre . "'>" . $titulocampo . ":</label>\n";

        $entradaHTML .= $this->entradaIndividual($tipo, $nombre, $valor, 10, $tamano, $mensaje, $mensaje2, 1, $patronCadena);


        if (isset($ayuda) &&
                trim($ayuda) != '') {
            $entradaHTML .="<span class='help-block'>" . $ayuda . "</span>";
        }


        return $entradaHTML;
    }

    /**
     * @brief Campo de entrada basico
     * 
     * Retorna html con campo de entrada basico forma bootstrap
     * @param titulocampo titulo de label del campo.
     * @param nombre nombre de variable de dom y request.
     * @param valor nombre de variable de dom y request.
     * @param validacion nombre de validacion a implementar
     * @param tamano tamaño limite de cadena en el valor 
     * @param mensaje mensaje descriptivo del campo
     * @param mensaje2 mensaje complementario del campo
     * @param ayuda si se desea agregar ayuda descriptiva de diligenciamiento
     * @return Cadena Html del campo de entrada.
     */
    public function campoCombinado($titulocampo, $nombre, $entradas, $ayuda = "") {
        $entradaHTML = "";

        if (isset($ayuda) &&
                trim($ayuda) != '') {
            $entradaHTML .="<div class='col-sm-3'></div><div class='col-sm-9'><span class='help-block'>" . $ayuda . "</span></div>";
        }

        $entradaHTML .="<label class='col-sm-3' for = '" . $nombre . "'>" . $titulocampo . ":</label>\n";

        foreach ($entradas as $ientrada => $rowentrada) {

            $entradaHTML.=$this->seleccionCampo($rowentrada);
        }




        return $entradaHTML;
    }

    /**
     * @brief Selecciona de un array el tipo de campo a retornar
     * 
     * Retorna html con campo seelccionado en el array de entrada
     * @param ayuda si se desea agregar ayuda descriptiva de diligenciamiento
     * @return Cadena Html del campo de entrada.
     */
    public function seleccionCampo($rowentrada) {
        

        $entradaHTML = "";

        $this->arregloValida[$rowentrada["nombre"]] = $rowentrada["validacion"];
        $this->valido[$rowentrada["nombre"]] = 1;

        if (isset($_REQUEST[$this->requestenviar])) {
            if (!$this->validaCampo($rowentrada["nombre"])) {

                $this->valido[$rowentrada["nombre"]] = 0;
            }
        }

        $patron = $this->patronValidacion($rowentrada["validacion"]);
        //echo "<br>Validacion=".$rowentrada["validacion"].", Patron=$patron";
        $requerido = 0;
        if ($rowentrada["validacion"] == "requerido") {
            $patronCadena = " required ";
            $requerido = 1;
        }
        if (isset($patron) &&
                trim($patron) != "" &&
                !$requerido) {

            $patronCadena .= " pattern='" . $patron . "' ";

            if ($validacion == "readonly") {
                $patronCadena .= "readonly='yes'";
            }
        } else {
            if (isset($rowentrada["patronCadena"]) &&
                    trim($rowentrada["patronCadena"]) != "") {
                $patronCadena = "pattern='" . $rowentrada["patronCadena"] . "'";
            }
        }

        switch ($rowentrada["tipo"]) {
            case "texto":
                $entradaHTML .= $this->entradaIndividual("text", $rowentrada["nombre"], $rowentrada["valor"], $rowentrada["division"], $rowentrada["tamano"], $rowentrada["mensaje"], $rowentrada["mensaje2"], 1, $patronCadena);

                break;
            case "observacion":
                $entradaHTML .= $this->observacion("text", $rowentrada["nombre"], $rowentrada["valor"], $rowentrada["division"], $rowentrada["tamano"], $rowentrada["mensaje"], $rowentrada["mensaje2"], 1, $patronCadena);
                break;
            case "menu":
                $entradaHTML.="<div class='col-sm-" . $rowentrada["division"] . "'>\n";
                $entradaHTML .= $this->menuIndividual($rowentrada["nombre"], $rowentrada["opciones"], $rowentrada["division"], $rowentrada["selecciona"], $rowentrada["formatoValida"], 1, $patronCadena);
                $entradaHTML.="</div>";
                break;
            case "fecha":
                //echo "Campo fecha=".$rowentrada["nombre"];
                $entradaHTML .= $this->campoFecha($rowentrada["nombre"], $rowentrada["valor"], $rowentrada["division"], $rowentrada["tamano"], $rowentrada["mensaje"], $rowentrada["mensaje2"], 1, $patronCadena);
                break;
        }
        return $entradaHTML;
    }

    /**
     * @brief Campo de entrada individual
     * 
     * Retorna html con campo de entrada basico forma bootstrap
     * @param titulocampo titulo de label del campo.
     * @param nombre nombre de variable de dom y request.
     * @param valor de la opcion que se selecciona por defecto
     * @param division numero de columnas ocupadas por el campo
     * @param mensaje mensaje descriptivo del campo
     * @param mensaje2 mensaje complementario del campo
     * @param formatoValida si se desea agregar formato de validacion
     * @param patronCadena cadena de validacion HTML5
     * @return Cadena Html del campo de entrada.
     */
    public function observacion($tipo, $nombre, $valor, $division, $tamano, $mensaje, $mensaje2, $formatoValida = 1, $patronCadena = "") {
        $entradaHTML = "<div class='col-sm-" . $division . "'>\n";
        $entradaHTML .= "<textarea  rows='4' " . $patronCadena . "  title='" . $mensaje . "' maxlength='" . $tamano . "' class='form-control' id='" . $nombre . "' name='" . $nombre . "' placeholder='" . $mensaje2 . "'>\n";
        $entradaHTML .= $valor;
        $entradaHTML .= "</textarea>";
        if (isset($_REQUEST[$this->requestenviar]) &&
                $formatoValida) {
            if (!$this->valido[$nombre]) {
                $entradaHTML .="<span class='glyphicon glyphicon-remove form-control-feedback'></span>";
// $entradaHTML .=" </div>";
            } else {
                $entradaHTML .="<span class='glyphicon glyphicon-ok form-control-feedback'></span>";
            }
        }
        $entradaHTML .= "</div>";
        return $entradaHTML;
    }

    /**
     * @brief Campo de entrada individual
     * 
     * Retorna html con campo de entrada basico forma bootstrap
     * @param titulocampo titulo de label del campo.
     * @param nombre nombre de variable de dom y request.
     * @param valor de la opcion que se selecciona por defecto
     * @param division numero de columnas ocupadas por el campo
     * @param mensaje mensaje descriptivo del campo
     * @param mensaje2 mensaje complementario del campo
     * @param formatoValida si se desea agregar formato de validacion
     * @param patronCadena cadena de validacion HTML5
     * @return Cadena Html del campo de entrada.
     */
    public function entradaIndividual($tipo, $nombre, $valor, $division, $tamano, $mensaje, $mensaje2, $formatoValida = 1, $patronCadena = "") {
        $entradaHTML = "<div class='col-sm-" . $division . "'>\n";
        $entradaHTML .= "<input type='" . $tipo . "' " . $patronCadena . " value='" . $valor . "' title='" . $mensaje . "' maxlength='" . $tamano . "' class='form-control' id='" . $nombre . "' name='" . $nombre . "' placeholder='" . $mensaje2 . "'>\n";
        if (isset($_REQUEST[$this->requestenviar]) &&
                $formatoValida) {
            if (!$this->valido[$nombre]) {
                $entradaHTML .="<span class='glyphicon glyphicon-remove form-control-feedback'></span>";
// $entradaHTML .=" </div>";
            } else {
                $entradaHTML .="<span class='glyphicon glyphicon-ok form-control-feedback'></span>";
            }
        }
        $entradaHTML .= "</div>";
        return $entradaHTML;
    }

    /**
     * @brief Campo de menu basico
     * 
     * Retorna html con campo de menu de seleccion basico forma bootstrap
     * @param titulocampo titulo de label del campo.
     * @param nombre nombre de variable de dom y request.
     * @param validacion nombre de validacion a implementar
     * @param selecciona valor de la opcion que se selecciona por defecto
     * @param[in] Arreglo de opciones del menu
     * @param mensaje mensaje descriptivo del campo
     * @param mensaje2 mensaje complementario del campo
     * @param ayuda si se desea agregar ayuda descriptiva de diligenciamiento
     * @return Cadena Html del campo de entrada.
     */
    public function campoMenu($titulocampo, $nombre, $validacion, $selecciona, $opciones, $mensaje, $mensaje2, $ayuda = "") {

        $this->valido[$nombre] = 1;
        $this->arregloValida[$nombre] = $validacion;
        if (isset($_REQUEST[$this->requestenviar])) {
            if (!$this->validaCampo($nombre)) {
                $this->valido[$nombre] = 0;
            }
        }

        $patron = $this->patronValidacion($validacion);


        if (isset($patron) &&
                trim($patron) != "") {
            if ($validacion == "requerido") {
                $patronCadena = "required";
            } else {
                $patronCadena = "pattern='" . $patron . "' required";
            }
        }
        if ($validacion == "readonly") {
            $patronCadena = "readonly='yes'";
        }

        $html = "<label class='col-sm-2' for='" . $nombre . "'>" . $titulocampo . "</label>";
        $html.="<div class='col-sm-10'>\n";
        $html .=$this->menuIndividual($nombre, $opciones, "10", $selecciona, 1, $patronCadena);
        $html.="</div>\n";


        if (isset($ayuda) &&
                trim($ayuda) != '') {
            $html .="<span class='help-block'>_" . $ayuda . "</span>";
        }
        return $html;
    }

    /**
     * @brief Campo de menu basico
     * 
     * Retorna html con campo de menu de seleccion basico forma bootstrap
     * @param nombre nombre de variable de dom y request.
     * @param[in] Arreglo de opciones del menu
     * @param division numero de columnas ocupadas por el campo
     * @param selecciona valor de la opcion que se selecciona por defecto
     * @param mensaje mensaje descriptivo del campo
     * @param mensaje2 mensaje complementario del campo
     * @param formatoValida si se desea agregar formato de validacion
     * @param patronCadena cadena de validacion HTML5
     * @return Cadena Html del campo de entrada.
     */
    public function menuIndividual($nombre, $opciones, $division, $selecciona, $formatoValida = 1, $patronCadena = "") {
        //$html.="<div class='col-sm-" . $division . "'>\n";
        $html.= "\n<select class='form-control' name='$nombre' id='$nombre' $patronCadena>";
        foreach ($opciones as $clave => $val) {
            if ($selecciona == $clave)
                $html.= "\n<option value='$clave' selected>$val</option>";
            else
                $html.= "\n<option value='$clave'>$val</option>";
        }
        $html.= "\n</select>";

        if (isset($_REQUEST[$this->requestenviar]) &&
                $formatoValida) {
            if (!$this->valido[$nombre]) {
                $html .="<span class='glyphicon glyphicon-remove form-control-feedback'></span>";
// $entradaHTML .=" </div>";
            } else {
                $html .="<span class='glyphicon glyphicon-ok form-control-feedback'></span>";
            }
        }
        //$html .= "</div>";

        return $html;
    }

    /**
     * @brief Retorna validacion de campo
     * 
     * Retorna html con campo de entrada basico forma bootstrap
     * @param titulocampo titulo de label del campo.
     * @return valido Retorna validacion de campo
     */
    public function getCampoValido($nombre) {
        return $this->valido[$nombre];
    }

    /**
     * @brief Retorna validacion de campo
     * 
     * Retorna html con campo de entrada basico forma bootstrap
     * @param titulocampo titulo de label del campo.
     * @return valido Retorna validacion de campo
     */
    public function getError() {
        return $this->errorFormulario;
    }

    /**
     * @brief Retorna validacion de campo
     * 
     * Retorna html con campo de entrada basico forma bootstrap
     * @param titulocampo titulo de label del campo.
     * @return valido Retorna validacion de campo
     */
    public function getEstiloError($nombre) {
        if (isset($_REQUEST[$this->requestenviar])) {
            if (!$this->getCampoValido($nombre)) {
                $errorHtml = " has-error has-feedback ";
                if (!$this->errorFormulario) {
                    $this->errorFormulario = 1;
                }
            } else {
                $errorHtml = " has-success has-feedback ";
            }
        }
        return $errorHtml;
    }

    /**
     * @brief Campo de menu basico
     * 
     * Retorna html con campo de menu de seleccion basico forma bootstrap
     * @param titulocampo titulo de label del campo.
     * @param nombre nombre de variable de dom y request.
     * @param validacion nombre de validacion a implementar
     * @param selecciona valor de la opcion que se selecciona por defecto
     * @param[in] Arreglo de opciones del menu
     * @param mensaje mensaje descriptivo del campo
     * @param mensaje2 mensaje complementario del campo
     * @param ayuda si se desea agregar ayuda descriptiva de diligenciamiento
     * @return Cadena Html del campo de entrada.
     */
    public function campoFecha($nombre, $valor, $division, $tamano, $mensaje, $mensaje2, $formatoValida = 1, $patronCadena = "") {
        $this->contcalendario++;
        $patron = $this->patronValidacion($validacion);
        //$entradaHTML .="<input type='date' pattern='" . $patron . "' title='" . $mensaje . "' maxlength='" . $tamano . "' class='form-control' id='" . $nombre . "' name='" . $nombre . "' placeholder='" . $mensaje2 . "'>\n";
        //$entradaHTML .=$this->entradaIndividual("date", $nombre, $valor, $division, $tamano, $mensaje, $mensaje2, $formatoValida, $patronCadena);

        $entradaHTML = "<div class='col-sm-" . $division . "'>\n";
        $entradaHTML .= "<input type='" . $tipo . "' " . $patronCadena . " value='" . $valor . "' title='" . $mensaje . "' maxlength='" . $tamano . "' class='form-control' id='" . $nombre . "' name='" . $nombre . "' placeholder='" . $mensaje2 . "'>\n";
        $entradaHTML .= $this->campoBoton("button", "lanzador" . $this->contcalendario, "...", "", 1);
        if (isset($_REQUEST[$this->requestenviar]) &&
                $formatoValida) {
            if (!$this->valido[$nombre]) {
                $entradaHTML .="<span class='glyphicon glyphicon-remove form-control-feedback'></span>";
// $entradaHTML .=" </div>";
            } else {
                $entradaHTML .="<span class='glyphicon glyphicon-ok form-control-feedback'></span>";
            }
        }
        $entradaHTML .= "</div>";



        $entradaHTML .= "\n<script type=\"text/javascript\">
          muestraCalendario(" . $this->contcalendario . "," . $nombre . ");
          </script>
          ";

        return $entradaHTML;
    }

    /**
     * @brief Funcion de validación de formulario
     * 
     * Retorna html con campo de entrada basico forma bootstrap
     * @param titulocampo titulo de label del campo.
     * @return Cadena Html del campo de entrada.
     */
    public function campoBoton($tipo, $nombre, $valor, $mensaje, $retorna = 0) {
        //  echo "BOTON=$tipo, $nombre";
        $html = "<input type='" . $tipo . "' id='" . $nombre . "' name='" . $nombre . "' value='" . $valor . "' class='btn btn-default'/>";
        if (!$retorna) {
            echo $html;
        } else {
            return $html;
        }
    }

    /**
     * @brief Patron de validacion 
     * 
     * Retorna html con campo de entrada basico forma bootstrap
     * @param titulocampo titulo de label del campo.
     * @return Cadena Html del campo de entrada.
     */
    public function patronValidacion($validacion) {

        switch ($validacion) {
            case "requerido":
                $patron = "required";
                break;
            case "alfabetico":
                $patron = "[a-zA-Z]*";
                break;
            case "alfanumerico":
                $patron = iconv('ISO-8859-1', 'UTF-8', "[a-zA-Z\á-\ú\Á-\Ú\ 0-9]*");
                break;
            case "numerico":
                $patron = "^[0-9]{0,20}$*";
                break;
            case "email":
                $patron = "[a-z0-9._%-]*@[a-z0-9.-]*\.[a-z]{2,3}$";
                break;
            case "url":
                $patron = "[a-zA-Z0-9\:\/\\\]*";
                break;
            case "fecha":
                $patron = "^(0[1-9]|[12][0-9]|3[01])[/-.](0[1-9]|1[012])[/-.](19|20)[0-9]{2}$";
                break;
            default :
                $patron = "";
                break;
        }
        return $patron;
    }

    /**
     * @brief Funcion de validación de formulario
     * 
     * Retorna html con campo de entrada basico forma bootstrap
     * @param titulocampo titulo de label del campo.
     * @return Cadena Html del campo de entrada.
     */
    public function mensajeValidar($nombre, $mensaje) {
        if (!$this->validaCampo($nombre)) {
            $entradaHTML = "<div class='alert alert-danger'>\n" .
                    "   <strong>!</strong> " . $this->errorValida . " " . $mensaje . " .\n" .
                    "</div>";
        }
        return $entradaHTML;
    }

    /**
     * @brief Funcion de validación de formulario
     * 
     * Retorna html con campo de entrada basico forma bootstrap
     * @param titulocampo titulo de label del campo.
     * @return Cadena Html del campo de entrada.
     */
    public function validaCampo($nombre) {

        $nombrevar = $_REQUEST[$nombre];
        $validacion = $this->arregloValida[$nombre];

        $valido = 1;
//if(isset($nombrevar)){
        switch ($validacion) {
            case "requerido":
                if (trim($nombrevar) == '') {
                    $valido = 0;
                    $this->errorValida .= ERR0102;
                }
                break;
            case "hora":
                if (!preg_match("^([1]{1}[0-9]{1}|[2]{1}[0-3]{1}|[0]{0,1}[0-9]{1}):[0-5]{1}[0-9]{1}$", $nombrevar)) {
                    $valido = 0;
                    $this->errorValida .= ERR0103;
                }
                break;
            case "numerico":

                if ($nombrevar == '') {
                    $valido = 0;
                    $this->errorValida .= ERR0104;
                } elseif (!preg_match("/^[0-9]{0,20}$/", $nombrevar)) {
                    $valido = 0;
                    $this->errorValida .= ERR0104;
                }
                break;

            case "url":
                if ($nombrevar == '') {
                    $valido = 0;
                    $this->errorValida .= ERR0104;
                } elseif (!preg_match("/[a-zA-Z0-9" . preg_quote("\\") . "\/]*/", $nombrevar)) {
                    $valido = 0;
                    echo "<h1>Invalido preg_match([a-zA-Z0-9" . preg_quote("\\") . "\/]*, $nombrevar)</h1>";
                    $this->errorValida .= ERR0104;
                }
                break;

            case "alfabetico":
                if ($nombrevar == '') {
                    $valido = 0;
                    $this->errorValida .= ERR0106;
                } elseif (!preg_match("/[a-zA-Z]*/", $nombrevar)) {
                    $valido = 0;
                    $this->errorValida .= ERR0106;
                }
                break;
            case "alfanumerico":
                if ($nombrevar == '') {
                    $valido = 0;
                    $this->errorValida .= ERR0106;
                } elseif (!preg_match("/[a-zA-Z" . preg_quote("\á-\?\Á-\?") . "\ 0-9]*/", $nombrevar)) {
                    $valido = 0;
                    $this->errorValida .= ERR0106;
                }
                break;


            case "email":
                $patron = "/[a-z0-9._%]*@[a-z0-9.-]*\.[a-z]{2,3}$/";
                if (trim($nombrevar) == '') {
                    $valido = 0;
                    $this->errorValida .= ERR0107;
                } elseif (!preg_match($patron, $nombrevar)) {
                    $valido = 0;
                    $this->errorValida .= ERR0107;
                }
                break;


            case "fecha":
// Para fechas >= a 2000
//$regs = array();
                if (trim($nombrevar) == '') {
                    $valido = 1;
                } elseif (!validarFecha($nombrevar)) {
                    $valido = 0;
                    $this->errorValida .= ERR0108;
                }
                break;
            case "decimal":
                if (!is_float($nombrevar)) {
                    $valido = 0;
                }
                break;
            case "fecha60": //fechas no mayores a 60 dias
                $fechahoy = date("Y-n-j");
                $fechasinformato = strtotime("+60 day", strtotime($fechahoy));
                $fecha60 = date("Y-n-j", $fechasinformato);
                $fechasinformato2 = strtotime("-60 day", strtotime($fechahoy));
                $fechamenos60 = date("Y-n-j", $fechasinformato2);
//echo $nombrevar,$fechamenos60,fecha60;
                if ($nombrevar == '') {
                    $valido = 0;
                } elseif ($nombrevar < $fechamenos60) {
                    $valido = 0;
                }
                if ($nombrevar > $fecha60) {
                    $valido = 0;
                }
                break;


            case "fechaant":
// Para fechas < a 2000
//$regs = array();
                if ($nombrevar == '') {
                    $valido = 0;
                } elseif (!preg_match("^(1[0-9]{3})-([1-9]{1}|0[1-9]{1}|1[0-2]{1})-([1-9]{1}|[0-2]{1}[1-9]{1}|3[0-1]{1}|10|20)$", $nombrevar, $regs)) {
                    $valido = 0;
                } elseif (!checkdate($regs[2], $regs[3], $regs[1])) {
                    $valido = 0;
                }
                break;
        }



        return $valido;
    }

}
