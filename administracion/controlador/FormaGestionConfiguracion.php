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
 * Descripcion del codigo de FormaGestionConfiguracion
 * 
 * @file FormaGestionConfiguracion.php
 * @author Javier Lopez Martinez
 * @date 25/10/2016
 * @brief Contiene ...
 */
class FormaGestionConfiguracion {

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
     *  Objeto de gestion de configuracion
     *
     * @var FormularioBase
     */
    private $objgestionconfiguracion;

    /**
     *  Arreglo de datos de configuracion 
     *
     * @var Array
     */
    private $datosconfiguracion;

    //put your code here
    public function __construct($objbase, $objformulario, $objgestionconfiguracion) {
        $this->objbase = $objbase;
        $this->objformulario = $objformulario;
        $this->objgestionconfiguracion = $objgestionconfiguracion;
        $this->datosconfiguracion = array();
    }

    public function setDatosConfiguracion($datosconfiguracion) {
        $this->datosconfiguracion = $datosconfiguracion;
    }

    public function panelGeneral() {

        $error = 0;
        $titulocampo = "Nombre Configuracion";
        $nombre = "nombreconfiguracion";
        $validacion = "alfanumerico";
        $valor = $this->datosconfiguracion[$nombre];
        $tamano = "100";
        $mensaje = "Nombre Descriptivo de configuracion";
        $mensaje2 = "Nombre del configuracion";
        $arrPanel["nombreConfiguracionHtml"] = $this->objformulario->campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2);
        $arrPanel["errorConfiguracionHtml"] = $this->objformulario->getEstiloError($nombre);

        $titulocampo = "Nombre Corto Configuracion";
        $nombre = "nombrecortoconfiguracion";
        $validacion = "alfanumerico";
        $valor = $this->datosconfiguracion[$nombre];
        $tamano = "100";
        $mensaje = "Nombre Corto de configuracion";
        $mensaje2 = "Nombre corto configuracion";
        $arrPanel["nombreCortoConfiguracionHtml"] = $this->objformulario->campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2);
        $arrPanel["errorCortoConfiguracionHtml"] = $this->objformulario->getEstiloError($nombre);


        $titulocampo = "Estado de configuracion";
        $nombre = "idestado";
        $validacion = "requerido";
        $valor = $this->datosconfiguracion[$nombre];
        $mensaje = "Seleccionar estado de escaner obligatorio";
        $mensaje2 = "Estado de configuracion";
        $datosestadoconfiguracion = $this->objgestionconfiguracion->consultaEstadoConfiguracion();
        //$opciones
        $opciones[""] = "Seleccionar";
        for ($i = 0; $i < count($datosestadoconfiguracion); $i++) {
            $opsestadoconfiguracion[$datosestadoconfiguracion[$i]["idestado"]] = $datosestadoconfiguracion[$i]["nombreestado"];
        }
        $arrPanel["nombreestadoHtml"] = $this->objformulario->campoMenu($titulocampo, $nombre, $validacion, $valor, $opsestadoconfiguracion, $mensaje, $mensaje2, $ayuda);
        $arrPanel["errorestadoHtml"] = $this->objformulario->getEstiloError($nombre);

        return $arrPanel;
    }

    public function panelOpciones() {
        $titulocampo = "Opciones dispositivo";
        $nombre = "dispositivo";
        $ayuda = "Rellenar con las opciones y valores de configuracion Ej device=,-d, dispositivo";

        $entradas[0]["tipo"] = "texto";
        $entradas[0]["nombre"] = "nombreopcion_1";
        $entradas[0]["division"] = "3";
        $entradas[0]["validacion"] = "requerido";
        $entradas[0]["valor"] = $this->datosconfiguracion[$entradas[0]["nombre"]];
        $entradas[0]["tamano"] = "20";
        $entradas[0]["mensaje"] = "Nombre de opcion dispositivo completa";
        $entradas[0]["mensaje2"] = "Dispositivo completo";

        $entradas[1]["tipo"] = "texto";
        $entradas[1]["nombre"] = "nombrecortoopcion_1";
        $entradas[1]["division"] = "3";
        $entradas[1]["validacion"] = "requerido";
        $entradas[1]["valor"] = $this->datosconfiguracion[$entradas[1]["nombre"]];
        $entradas[1]["tamano"] = "20";
        $entradas[1]["mensaje"] = "Nombre de opcion dispositivo corta";
        $entradas[1]["mensaje2"] = "Dispositivo corta";

        $entradas[2]["tipo"] = "texto";
        $entradas[2]["nombre"] = "valoropcion_1";
        $entradas[2]["division"] = "3";
        $entradas[2]["validacion"] = "requerido";
        $entradas[2]["valor"] = $this->datosconfiguracion[$entradas[2]["nombre"]];
        $entradas[2]["tamano"] = "50";
        $entradas[2]["mensaje"] = "Valor de opcion dispositivo corta";
        $entradas[2]["mensaje2"] = "Nombre de Dispositivo ";

        $arraPanel["opcionEscanerHtml"][0] = $this->objformulario->campoCombinado($titulocampo, $nombre, $entradas, $ayuda);
        $arraPanel["erroropcion"][0] = $this->objformulario->getEstiloError($entradas[0]["nombre"]);


        unset($entradas);

        $titulocampo = "Compresi&oacute;n";
        $nombre = "compresion";
        $ayuda = "";

        $entradas[0]["tipo"] = "texto";
        $entradas[0]["nombre"] = "nombreopcion_2";
        $entradas[0]["division"] = "3";
        $entradas[0]["validacion"] = "requerido";
        $entradas[0]["valor"] = $this->datosconfiguracion[$entradas[0]["nombre"]];
        $entradas[0]["tamano"] = "20";
        $entradas[0]["mensaje"] = "Nombre de opcion compresi&oacute;n completa";
        $entradas[0]["mensaje2"] = "Opcion compresi&oacute;n completo";

        $entradas[1]["tipo"] = "texto";
        $entradas[1]["nombre"] = "nombrecortoopcion_2";
        $entradas[1]["division"] = "3";
        $entradas[1]["validacion"] = "requerido";
        $entradas[1]["valor"] = $this->datosconfiguracion[$entradas[1]["nombre"]];
        $entradas[1]["tamano"] = "20";
        $entradas[1]["mensaje"] = "Nombre de opcion compresi&oacute;n corta";
        $entradas[1]["mensaje2"] = "Opcion compresi&oacute;n corta";

        $entradas[2]["tipo"] = "texto";
        $entradas[2]["nombre"] = "valoropcion_2";
        $entradas[2]["division"] = "3";
        $entradas[2]["validacion"] = "requerido";
        $entradas[2]["valor"] = $this->datosconfiguracion[$entradas[2]["nombre"]];
        $entradas[2]["tamano"] = "50";
        $entradas[2]["mensaje"] = "Valor de opcion compresi&oacute;n corta";
        $entradas[2]["mensaje2"] = "Valor de compresi&oacute;n ";

        $arraPanel["opcionEscanerHtml"][1] = $this->objformulario->campoCombinado($titulocampo, $nombre, $entradas, $ayuda);
        $arraPanel["erroropcion"][1] = $this->objformulario->getEstiloError($entradas[0]["nombre"]);

        unset($entradas);

        $titulocampo = "Rotaci&oacute;n autom&aacute;tica";
        $nombre = "rotacion";
        $ayuda = "";

        $entradas[0]["tipo"] = "texto";
        $entradas[0]["nombre"] = "nombreopcion_3";
        $entradas[0]["division"] = "3";
        $entradas[0]["validacion"] = "requerido";
        $entradas[0]["valor"] = $this->datosconfiguracion[$entradas[0]["nombre"]];
        $entradas[0]["tamano"] = "20";
        $entradas[0]["mensaje"] = "Nombre de opcion rotaci&oacute;n autom&aacute;tica";
        $entradas[0]["mensaje2"] = "Opcion rotaci&oacute;n completo";

        $entradas[1]["tipo"] = "texto";
        $entradas[1]["nombre"] = "nombrecortoopcion_3";
        $entradas[1]["division"] = "3";
        $entradas[1]["validacion"] = "requerido";
        $entradas[1]["valor"] = $this->datosconfiguracion[$entradas[1]["nombre"]];
        $entradas[1]["tamano"] = "20";
        $entradas[1]["mensaje"] = "Nombre de opcion rotaci&oacute;n corta";
        $entradas[1]["mensaje2"] = "Opcion rotaci&oacute;n corta";

        $entradas[2]["tipo"] = "texto";
        $entradas[2]["nombre"] = "valoropcion_3";
        $entradas[2]["division"] = "3";
        $entradas[2]["validacion"] = "requerido";
        $entradas[2]["valor"] = $this->datosconfiguracion[$entradas[2]["nombre"]];
        $entradas[2]["tamano"] = "50";
        $entradas[2]["mensaje"] = "Valor de opcion rotaci&oacute;n corta";
        $entradas[2]["mensaje2"] = "Valor de rotaci&oacute;n ";

        $arraPanel["opcionEscanerHtml"][2] = $this->objformulario->campoCombinado($titulocampo, $nombre, $entradas, $ayuda);
        $arraPanel["erroropcion"][2] = $this->objformulario->getEstiloError($entradas[0]["nombre"]);

        unset($entradas);

        $titulocampo = " Escaneo doble cara (Duplex)";
        $nombre = "rotacion";
        $ayuda = "";

        $entradas[0]["tipo"] = "texto";
        $entradas[0]["nombre"] = "nombreopcion_4";
        $entradas[0]["division"] = "3";
        $entradas[0]["validacion"] = "requerido";
        $entradas[0]["valor"] = $this->datosconfiguracion[$entradas[0]["nombre"]];
        $entradas[0]["tamano"] = "20";
        $entradas[0]["mensaje"] = "Nombre de opcion duplex";
        $entradas[0]["mensaje2"] = "Opcion duplex completo";

        $entradas[1]["tipo"] = "texto";
        $entradas[1]["nombre"] = "nombrecortoopcion_4";
        $entradas[1]["division"] = "3";
        $entradas[1]["validacion"] = "requerido";
        $entradas[1]["valor"] = $this->datosconfiguracion[$entradas[1]["nombre"]];
        $entradas[1]["tamano"] = "20";
        $entradas[1]["mensaje"] = "Nombre de opcion duplex corta";
        $entradas[1]["mensaje2"] = "Opcion duplex corta";

        $entradas[2]["tipo"] = "texto";
        $entradas[2]["nombre"] = "valoropcion_4";
        $entradas[2]["division"] = "3";
        $entradas[2]["validacion"] = "requerido";
        $entradas[2]["valor"] = $this->datosconfiguracion[$entradas[2]["nombre"]];
        $entradas[2]["tamano"] = "50";
        $entradas[2]["mensaje"] = "Valor de opcion duplex corta";
        $entradas[2]["mensaje2"] = "Valor de duplex ";

        $arraPanel["opcionEscanerHtml"][3] = $this->objformulario->campoCombinado($titulocampo, $nombre, $entradas, $ayuda);
        $arraPanel["erroropcion"][3] = $this->objformulario->getEstiloError($entradas[0]["nombre"]);

        unset($entradas);

        $titulocampo = " Profundidad resoluci&oacute;n";
        $nombre = "rotacion";
        $ayuda = "";

        $entradas[0]["tipo"] = "texto";
        $entradas[0]["nombre"] = "nombreopcion_5";
        $entradas[0]["division"] = "3";
        $entradas[0]["validacion"] = "requerido";
        $entradas[0]["valor"] = $this->datosconfiguracion[$entradas[0]["nombre"]];
        $entradas[0]["tamano"] = "20";
        $entradas[0]["mensaje"] = "Nombre de opcion profundidad";
        $entradas[0]["mensaje2"] = "Opcion profundidad completo";

        $entradas[1]["tipo"] = "texto";
        $entradas[1]["nombre"] = "nombrecortoopcion_5";
        $entradas[1]["division"] = "3";
        $entradas[1]["validacion"] = "requerido";
        $entradas[1]["valor"] = $this->datosconfiguracion[$entradas[1]["nombre"]];
        $entradas[1]["tamano"] = "20";
        $entradas[1]["mensaje"] = "Nombre de opcion profundidad corta";
        $entradas[1]["mensaje2"] = "Opcion profunidad corta";

        $entradas[2]["tipo"] = "texto";
        $entradas[2]["nombre"] = "valoropcion_5";
        $entradas[2]["division"] = "3";
        $entradas[2]["validacion"] = "requerido";
        $entradas[2]["valor"] = $this->datosconfiguracion[$entradas[2]["nombre"]];
        $entradas[2]["tamano"] = "50";
        $entradas[2]["mensaje"] = "Valor de opcion profundidad corta";
        $entradas[2]["mensaje2"] = "Valor de profundidad ";

        $arraPanel["opcionEscanerHtml"][4] = $this->objformulario->campoCombinado($titulocampo, $nombre, $entradas, $ayuda);
        $arraPanel["erroropcion"][4] = $this->objformulario->getEstiloError($entradas[0]["nombre"]);

        unset($entradas);

        $titulocampo = " Definici&oacute;n bits por pixel";
        $nombre = "rotacion";
        $ayuda = "";

        $entradas[0]["tipo"] = "texto";
        $entradas[0]["nombre"] = "nombreopcion_6";
        $entradas[0]["division"] = "3";
        $entradas[0]["validacion"] = "requerido";
        $entradas[0]["valor"] = $this->datosconfiguracion[$entradas[0]["nombre"]];
        $entradas[0]["tamano"] = "20";
        $entradas[0]["mensaje"] = "Nombre de opcion definici&ocute;n";
        $entradas[0]["mensaje2"] = "Opcion definici&ocute;n completo";

        $entradas[1]["tipo"] = "texto";
        $entradas[1]["nombre"] = "nombrecortoopcion_6";
        $entradas[1]["division"] = "3";
        $entradas[1]["validacion"] = "requerido";
        $entradas[1]["valor"] = $this->datosconfiguracion[$entradas[1]["nombre"]];
        $entradas[1]["tamano"] = "20";
        $entradas[1]["mensaje"] = "Nombre de opcion definici&oacute;n corta";
        $entradas[1]["mensaje2"] = "Opcion definici&oacute;n corta";

        $entradas[2]["tipo"] = "texto";
        $entradas[2]["nombre"] = "valoropcion_6";
        $entradas[2]["division"] = "3";
        $entradas[2]["validacion"] = "requerido";
        $entradas[2]["valor"] = $this->datosconfiguracion[$entradas[2]["nombre"]];
        $entradas[2]["tamano"] = "50";
        $entradas[2]["mensaje"] = "Valor de opcion definici&oacute;n corta";
        $entradas[2]["mensaje2"] = "Valor de definici&oacute;;n ";

        $arraPanel["opcionEscanerHtml"][5] = $this->objformulario->campoCombinado($titulocampo, $nombre, $entradas, $ayuda);
        $arraPanel["erroropcion"][5] = $this->objformulario->getEstiloError($entradas[0]["nombre"]);

        unset($entradas);

        $titulocampo = " Formato ";
        $nombre = "rotacion";
        $ayuda = "";

        $entradas[0]["tipo"] = "texto";
        $entradas[0]["nombre"] = "nombreopcion_7";
        $entradas[0]["division"] = "3";
        $entradas[0]["validacion"] = "requerido";
        $entradas[0]["valor"] = $this->datosconfiguracion[$entradas[0]["nombre"]];
        $entradas[0]["tamano"] = "20";
        $entradas[0]["mensaje"] = "Nombre de opcion formato";
        $entradas[0]["mensaje2"] = "Opcion formato completo";

        $entradas[1]["tipo"] = "texto";
        $entradas[1]["nombre"] = "nombrecortoopcion_7";
        $entradas[1]["division"] = "3";
        $entradas[1]["validacion"] = "requerido";
        $entradas[1]["valor"] = $this->datosconfiguracion[$entradas[1]["nombre"]];
        $entradas[1]["tamano"] = "20";
        $entradas[1]["mensaje"] = "Nombre de opcion formato corta";
        $entradas[1]["mensaje2"] = "Opcion formato corta";

        $entradas[2]["tipo"] = "texto";
        $entradas[2]["nombre"] = "valoropcion_7";
        $entradas[2]["division"] = "3";
        $entradas[2]["validacion"] = "requerido";
        $entradas[2]["valor"] = $this->datosconfiguracion[$entradas[2]["nombre"]];
        $entradas[2]["tamano"] = "50";
        $entradas[2]["mensaje"] = "Valor de opcion formato corta";
        $entradas[2]["mensaje2"] = "Valor de formato ";

        $arraPanel["opcionEscanerHtml"][6] = $this->objformulario->campoCombinado($titulocampo, $nombre, $entradas, $ayuda);
        $arraPanel["erroropcion"][6] = $this->objformulario->getEstiloError($entradas[0]["nombre"]);

        unset($entradas);

        $titulocampo = " Resoluci&oacute;n ";
        $nombre = "rotacion";
        $ayuda = "";

        $entradas[0]["tipo"] = "texto";
        $entradas[0]["nombre"] = "nombreopcion_8";
        $entradas[0]["division"] = "3";
        $entradas[0]["validacion"] = "requerido";
        $entradas[0]["valor"] = $this->datosconfiguracion[$entradas[0]["nombre"]];
        $entradas[0]["tamano"] = "20";
        $entradas[0]["mensaje"] = "Nombre de opcion resoluci&ocute;n";
        $entradas[0]["mensaje2"] = "Opcion resoluci&oacute;n completo";

        $entradas[1]["tipo"] = "texto";
        $entradas[1]["nombre"] = "nombrecortoopcion_8";
        $entradas[1]["division"] = "3";
        $entradas[1]["validacion"] = "requerido";
        $entradas[1]["valor"] = $this->datosconfiguracion[$entradas[1]["nombre"]];
        $entradas[1]["tamano"] = "20";
        $entradas[1]["mensaje"] = "Nombre de opcion resoluci&oacute;n corta";
        $entradas[1]["mensaje2"] = "Opcion resoluci&oacute;n corta";

        $entradas[2]["tipo"] = "texto";
        $entradas[2]["nombre"] = "valoropcion_8";
        $entradas[2]["division"] = "3";
        $entradas[2]["validacion"] = "requerido";
        $entradas[2]["valor"] = $this->datosconfiguracion[$entradas[2]["nombre"]];
        $entradas[2]["tamano"] = "50";
        $entradas[2]["mensaje"] = "Valor de opcion resoluci&oacute;n corta";
        $entradas[2]["mensaje2"] = "Valor de resoluci&oacute;n ";

        $arraPanel["opcionEscanerHtml"][7] = $this->objformulario->campoCombinado($titulocampo, $nombre, $entradas, $ayuda);
        $arraPanel["erroropcion"][7] = $this->objformulario->getEstiloError($entradas[0]["nombre"]);


        $titulocampo = " Directorio local de imagenes ";
        $nombre = "rotacion";
        $ayuda = "";

        $entradas[0]["tipo"] = "texto";
        $entradas[0]["nombre"] = "nombreopcion_9";
        $entradas[0]["division"] = "3";
        $entradas[0]["validacion"] = "requerido";
        $entradas[0]["valor"] = $this->datosconfiguracion[$entradas[0]["nombre"]];
        $entradas[0]["tamano"] = "20";
        $entradas[0]["mensaje"] = "Nombre de opcion directorio";
        $entradas[0]["mensaje2"] = "Opcion directorio completo";

        $entradas[1]["tipo"] = "texto";
        $entradas[1]["nombre"] = "nombrecortoopcion_9";
        $entradas[1]["division"] = "3";
        $entradas[1]["validacion"] = "requerido";
        $entradas[1]["valor"] = $this->datosconfiguracion[$entradas[1]["nombre"]];
        $entradas[1]["tamano"] = "20";
        $entradas[1]["mensaje"] = "Nombre de opcion directorio corta";
        $entradas[1]["mensaje2"] = "Opcion directorio corta";

        $entradas[2]["tipo"] = "texto";
        $entradas[2]["nombre"] = "valoropcion_9";
        $entradas[2]["division"] = "3";
        $entradas[2]["validacion"] = "url";
        $entradas[2]["valor"] = $this->datosconfiguracion[$entradas[2]["nombre"]];
        $entradas[2]["tamano"] = "50";
        $entradas[2]["mensaje"] = "Valor de opcion directorio corta";
        $entradas[2]["mensaje2"] = "Valor de directorio ";

        $arraPanel["opcionEscanerHtml"][8] = $this->objformulario->campoCombinado($titulocampo, $nombre, $entradas, $ayuda);
        $arraPanel["erroropcion"][8] = $this->objformulario->getEstiloError($entradas[0]["nombre"]);



        return $arraPanel;
    }

    public function getError() {
        return $this->objformulario->getError();
    }

}
