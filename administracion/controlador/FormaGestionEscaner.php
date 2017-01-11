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
 * Descripcion del codigo de FormaControlEscaner
 * 
 * @file FormaControlEscaner.php
 * @author Javier Lopez Martinez
 * @date 22/09/2016
 * @brief Contiene ...
 */
class FormaGestionEscaner {

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
     *  Objeto de gestion de escaner
     *
     * @var FormularioBase
     */
    private $objgestionescaner;

    /**
     *  Objeto de gestion de escaner
     *
     * @var FormularioBase
     */
    private $objgestionconfiguracion;

    /**
     *  Arreglo de datos de escaner 
     *
     * @var Array
     */
    private $datosescaner;

    //put your code here
    public function __construct($objbase, $objformulario, $objgestionescaner) {
        $this->objbase = $objbase;
        $this->objformulario = $objformulario;
        $this->objgestionescaner = $objgestionescaner;
        $this->datosescaner = array();
    }

    public function setGestionConfiguracion($objgestionconfiguracion) {
        $this->objgestionconfiguracion = $objgestionconfiguracion;
    }

    public function setDatosEscaner($datosescaner) {
        $this->datosescaner = $datosescaner;
    }

    public function panelGeneral() {

        $error = 0;
        $titulocampo = "Nombre Escaner";
        $nombre = "nombreescaner";
        $validacion = "alfanumerico";
        $valor = $this->datosescaner[$nombre];
        $tamano = "100";
        $mensaje = "Nombre Descriptivo del Escaner";
        $mensaje2 = "Nombre del escaner";
        $arrPanel["nombreEscanerHtml"] = $this->objformulario->campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2);
        $arrPanel["errorEscanerHtml"] = $this->objformulario->getEstiloError($nombre);


        $titulocampo = "Dispositivo";
        $nombre = "dispositivoescaner";
        $validacion = "alfanumerico";
        $valor = $this->datosescaner[$nombre];
        $tamano = "50";
        $mensaje = "Nombre tecnico del dispositivo";
        $mensaje2 = "Dispositivo";
        $arrPanel["nombreDispositivoHtml"] = $this->objformulario->campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2);
        $arrPanel["errorDispositivoHtml"] = $this->objformulario->getEstiloError($nombre);


        $titulocampo = "Host Anfitrion Escaner";
        $nombre = "ipescaner";
        $validacion = "requerido";
        $valor = $this->datosescaner[$nombre];
        $tamano = "50";
        $mensaje = "Direccion IP o nombre del equipo anfitrion del escaner";
        $mensaje2 = "IP";
        $arrPanel["nombreipHtml"] = $this->objformulario->campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2);
        $arrPanel["erroripHtml"] = $this->objformulario->getEstiloError($nombre);

        $titulocampo = "Directorio Remoto";
        $nombre = "directorioescaner";
        $validacion = "url";
        $valor = $this->datosescaner[$nombre];
        $tamano = "50";
        $mensaje = "Ruta de directorio en servidor del almacenamiento de imagenes";
        $mensaje2 = "Ruta directorio imagenes";
        $arrPanel["nombredirHtml"] = $this->objformulario->campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2);
        $arrPanel["errordirHtml"] = $this->objformulario->getEstiloError($nombre);


        $titulocampo = "Sitio Escaner";
        $nombre = "sitioescaner";
        $validacion = "requerido";
        $valor = $this->datosescaner[$nombre];
        $tamano = "50";
        $mensaje = "Sitio fisico donde esta el escaner";
        $mensaje2 = "Lugar Escaner";
        $arrPanel["nombresitioHtml"] = $this->objformulario->campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2);
        $arrPanel["errorsitioHtml"] = $this->objformulario->getEstiloError($nombre);

        $titulocampo = "Tipo de escaner";
        $nombre = "idtipoescaner";
        $validacion = "requerido";
        $valor = $this->datosescaner[$nombre];
        $mensaje = "Seleccionar tipo de escaner obligatorio";
        $mensaje2 = "Tipo de escaner";
        $datostipoescaner = $this->objgestionescaner->consultaTipoEscaner();
        //$opciones
        $opciones[""] = "Seleccionar";
        for ($i = 0; $i < count($datostipoescaner); $i++) {
            $opciones[$datostipoescaner[$i]["idtipoescaner"]] = $datostipoescaner[$i]["nombretipoescaner"];
        }
        $arrPanel["nombretipoHtml"] = $this->objformulario->campoMenu($titulocampo, $nombre, $validacion, $valor, $opciones, $mensaje, $mensaje2, $ayuda);
        $arrPanel["errortipoHtml"] = $this->objformulario->getEstiloError($nombre);

        $titulocampo = "Estado de escaner";
        $nombre = "idestado";
        $validacion = "requerido";
        $valor = $this->datosescaner[$nombre];
        $mensaje = "Seleccionar estado de escaner obligatorio";
        $mensaje2 = "Estado de escaner";
        $datosestadoescaner = $this->objgestionescaner->consultaEstadoEscaner();
        //$opciones
        $opciones[""] = "Seleccionar";
        for ($i = 0; $i < count($datosestadoescaner); $i++) {
            $opsestadoescaner[$datosestadoescaner[$i]["idestado"]] = $datosestadoescaner[$i]["nombreestado"];
        }
        $arrPanel["nombreestadoHtml"] = $this->objformulario->campoMenu($titulocampo, $nombre, $validacion, $valor, $opsestadoescaner, $mensaje, $mensaje2, $ayuda);
        $arrPanel["errorestadoHtml"] = $this->objformulario->getEstiloError($nombre);

        return $arrPanel;
    }

    /**
     * @brief Define array de campos de forma
     * 
     * Formulario del panel de asignacion
     * de configuracion relacionados a escaner 
     * arma entradas html con parametros
     * formulario
     * 
     * @return Arreglo de campos html
     */
    public function panelConfiguracion() {

        unset($opciones);
        // $this->objgestiongrupo->debug();
        $titulocampo = "Asignar Configuracion";
        $nombre = "idconfiguracion";
        $validacion = "";
        $valor = $this->datosescaner[$nombre . "0"];
        $mensaje = "Seleccionar configuracion";
        $mensaje2 = "configuracion";
        //$this->objgestiongrupo->debug();
        $datosgrupo = $this->objgestionconfiguracion->consultarRegistrosConfiguracion();


        for ($i = 0; $i < count($datosgrupo); $i++) {
            $nombreopcion = $datosgrupo[$i]["idconfiguracion"] . "-" . $datosgrupo[$i]["nombreconfiguracion"];
            $opciones[$datosgrupo[$i]["idconfiguracion"]] = $nombreopcion;
        }
        $opciones[""] = "Seleccionar";

        $arrPanel["campoHtml"][] = $this->objformulario->campoMenu($titulocampo, $nombre . "0", $validacion, $valor, $opciones, $mensaje, $mensaje2, $ayuda);
        $arrPanel["errorHtml"][] = $this->objformulario->getEstiloError($nombre . "0");

        $i = 1;
        while (isset($this->datosescaner[$nombre . $i]) &&
        trim($this->datosescaner[$nombre . $i]) != '') {
            //unset($opciones);
            if (isset($this->datosescaner[$nombre]))
                unset($opciones[$this->datosescaner[$nombre]]);
            $titulocampo = "Asignar Configuracion " . $i;
            $nombre = $nombre . $i;
            $validacion = "";
            $valor = $this->datosescaner[$nombre];
            $mensaje = "Seleccionar configuracion";
            $mensaje2 = "configuracion";

            //$datosgrupo = $this->objgestiongrupo->consultaGrupoUsuario();

            /* for ($i = 0; $i < count($datosgrupo); $i++) {
              $nombreopcion = $datosgrupo[$i]["idgrupousuario"] . "-" . $datosescaner[$i]["nombregrupousuario"] . "-" . $datosescaner[$i]["nombretipogrupousuario"];
              $opciones[$datosescaner[$i]["idescaner"]] = $nombreopcion;
              }
              $opciones[""] = "Seleccionar"; */
            $arrPanel["campoHtml"][] = $this->objformulario->campoMenu($titulocampo, $nombre, $validacion, $valor, $opciones, $mensaje, $mensaje2, $ayuda);
            $arrPanel["errorHtml"][] = $this->objformulario->getEstiloError($nombre);
            $i++;
        }
        if (isset($this->datosgrupousuario[$nombre]))
            unset($opciones[$this->datosgrupousuario[$nombre]]);
        $titulocampo = "Asignar Configuracion " . $i;
        $nombre = $nombre . $i;
        $validacion = "";
        $valor = $this->datosescaner[$nombre];
        $mensaje = "Seleccionar configuracion";
        $mensaje2 = "configuracion";
        //$datosgrupo = $this->objgestiongrupo->consultaGrupoUsuario();
        /* for ($i = 0; $i < count($datosgrupo); $i++) {
          $nombreopcion = $datosgrupo[$i]["idgrupousuario"] . "-" . $datosescaner[$i]["nombregrupousuario"] . "-" . $datosescaner[$i]["nombretipogrupousuario"];
          $opciones[$datosescaner[$i]["idescaner"]] = $nombreopcion;
          }
          $opciones[""] = "Seleccionar"; */

        $arrPanel["campoHtml"][] = $this->objformulario->campoMenu($titulocampo, $nombre, $validacion, $valor, $opciones, $mensaje, $mensaje2, $ayuda);
        $arrPanel["errorHtml"][] = $this->objformulario->getEstiloError($nombre);
        $i++;
        return $arrPanel;
    }

    public function panelOpciones() {
        $titulocampo = "Opciones dispositivo";
        $nombre = "dispositivo";
        $ayuda = "Rellenar con las opciones y valores de configuracion Ej device=,-d, dispositivo";

        $entradas[0]["tipo"] = "texto";
        $entradas[0]["nombre"] = "nombreopcion_1";
        $entradas[0]["division"] = "4";
        $entradas[0]["validacion"] = "requerido";
        $entradas[0]["valor"] = $this->datosescaner[$entradas[0]["nombre"]];
        $entradas[0]["tamano"] = "20";
        $entradas[0]["mensaje"] = "Nombre de opcion dispositivo completa";
        $entradas[0]["mensaje2"] = "Dispositivo completo";

        $entradas[1]["tipo"] = "texto";
        $entradas[1]["nombre"] = "nombrecortoopcion_1";
        $entradas[1]["division"] = "2";
        $entradas[1]["validacion"] = "requerido";
        $entradas[1]["valor"] = $this->datosescaner[$entradas[1]["nombre"]];
        $entradas[1]["tamano"] = "20";
        $entradas[1]["mensaje"] = "Nombre de opcion dispositivo corta";
        $entradas[1]["mensaje2"] = "Dispositivo corta";

        $entradas[2]["tipo"] = "texto";
        $entradas[2]["nombre"] = "valoropcion_1";
        $entradas[2]["division"] = "4";
        $entradas[2]["validacion"] = "requerido";
        $entradas[2]["valor"] = $this->datosescaner[$entradas[2]["nombre"]];
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
        $entradas[0]["division"] = "4";
        $entradas[0]["validacion"] = "requerido";
        $entradas[0]["valor"] = $this->datosescaner[$entradas[0]["nombre"]];
        $entradas[0]["tamano"] = "20";
        $entradas[0]["mensaje"] = "Nombre de opcion compresi&oacute;n completa";
        $entradas[0]["mensaje2"] = "Opcion compresi&oacute;n completo";

        $entradas[1]["tipo"] = "texto";
        $entradas[1]["nombre"] = "nombrecortoopcion_2";
        $entradas[1]["division"] = "2";
        $entradas[1]["validacion"] = "requerido";
        $entradas[1]["valor"] = $this->datosescaner[$entradas[1]["nombre"]];
        $entradas[1]["tamano"] = "20";
        $entradas[1]["mensaje"] = "Nombre de opcion compresi&oacute;n corta";
        $entradas[1]["mensaje2"] = "Opcion compresi&oacute;n corta";

        $entradas[2]["tipo"] = "texto";
        $entradas[2]["nombre"] = "valoropcion_2";
        $entradas[2]["division"] = "4";
        $entradas[2]["validacion"] = "requerido";
        $entradas[2]["valor"] = $this->datosescaner[$entradas[2]["nombre"]];
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
        $entradas[0]["division"] = "4";
        $entradas[0]["validacion"] = "requerido";
        $entradas[0]["valor"] = $this->datosescaner[$entradas[0]["nombre"]];
        $entradas[0]["tamano"] = "20";
        $entradas[0]["mensaje"] = "Nombre de opcion rotaci&oacute;n autom&aacute;tica";
        $entradas[0]["mensaje2"] = "Opcion rotaci&oacute;n completo";

        $entradas[1]["tipo"] = "texto";
        $entradas[1]["nombre"] = "nombrecortoopcion_3";
        $entradas[1]["division"] = "2";
        $entradas[1]["validacion"] = "requerido";
        $entradas[1]["valor"] = $this->datosescaner[$entradas[1]["nombre"]];
        $entradas[1]["tamano"] = "20";
        $entradas[1]["mensaje"] = "Nombre de opcion rotaci&oacute;n corta";
        $entradas[1]["mensaje2"] = "Opcion rotaci&oacute;n corta";

        $entradas[2]["tipo"] = "texto";
        $entradas[2]["nombre"] = "valoropcion_3";
        $entradas[2]["division"] = "4";
        $entradas[2]["validacion"] = "requerido";
        $entradas[2]["valor"] = $this->datosescaner[$entradas[2]["nombre"]];
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
        $entradas[0]["division"] = "4";
        $entradas[0]["validacion"] = "requerido";
        $entradas[0]["valor"] = $this->datosescaner[$entradas[0]["nombre"]];
        $entradas[0]["tamano"] = "20";
        $entradas[0]["mensaje"] = "Nombre de opcion duplex";
        $entradas[0]["mensaje2"] = "Opcion duplex completo";

        $entradas[1]["tipo"] = "texto";
        $entradas[1]["nombre"] = "nombrecortoopcion_4";
        $entradas[1]["division"] = "2";
        $entradas[1]["validacion"] = "requerido";
        $entradas[1]["valor"] = $this->datosescaner[$entradas[1]["nombre"]];
        $entradas[1]["tamano"] = "20";
        $entradas[1]["mensaje"] = "Nombre de opcion duplex corta";
        $entradas[1]["mensaje2"] = "Opcion duplex corta";

        $entradas[2]["tipo"] = "texto";
        $entradas[2]["nombre"] = "valoropcion_4";
        $entradas[2]["division"] = "4";
        $entradas[2]["validacion"] = "requerido";
        $entradas[2]["valor"] = $this->datosescaner[$entradas[2]["nombre"]];
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
        $entradas[0]["division"] = "4";
        $entradas[0]["validacion"] = "requerido";
        $entradas[0]["valor"] = $this->datosescaner[$entradas[0]["nombre"]];
        $entradas[0]["tamano"] = "20";
        $entradas[0]["mensaje"] = "Nombre de opcion profundidad";
        $entradas[0]["mensaje2"] = "Opcion profundidad completo";

        $entradas[1]["tipo"] = "texto";
        $entradas[1]["nombre"] = "nombrecortoopcion_5";
        $entradas[1]["division"] = "2";
        $entradas[1]["validacion"] = "requerido";
        $entradas[1]["valor"] = $this->datosescaner[$entradas[1]["nombre"]];
        $entradas[1]["tamano"] = "20";
        $entradas[1]["mensaje"] = "Nombre de opcion profundidad corta";
        $entradas[1]["mensaje2"] = "Opcion profunidad corta";

        $entradas[2]["tipo"] = "texto";
        $entradas[2]["nombre"] = "valoropcion_5";
        $entradas[2]["division"] = "4";
        $entradas[2]["validacion"] = "requerido";
        $entradas[2]["valor"] = $this->datosescaner[$entradas[2]["nombre"]];
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
        $entradas[0]["division"] = "4";
        $entradas[0]["validacion"] = "requerido";
        $entradas[0]["valor"] = $this->datosescaner[$entradas[0]["nombre"]];
        $entradas[0]["tamano"] = "20";
        $entradas[0]["mensaje"] = "Nombre de opcion definici&ocute;n";
        $entradas[0]["mensaje2"] = "Opcion definici&ocute;n completo";

        $entradas[1]["tipo"] = "texto";
        $entradas[1]["nombre"] = "nombrecortoopcion_6";
        $entradas[1]["division"] = "2";
        $entradas[1]["validacion"] = "requerido";
        $entradas[1]["valor"] = $this->datosescaner[$entradas[1]["nombre"]];
        $entradas[1]["tamano"] = "20";
        $entradas[1]["mensaje"] = "Nombre de opcion definici&oacute;n corta";
        $entradas[1]["mensaje2"] = "Opcion definici&oacute;n corta";

        $entradas[2]["tipo"] = "texto";
        $entradas[2]["nombre"] = "valoropcion_6";
        $entradas[2]["division"] = "4";
        $entradas[2]["validacion"] = "requerido";
        $entradas[2]["valor"] = $this->datosescaner[$entradas[1]["nombre"]];
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
        $entradas[0]["division"] = "4";
        $entradas[0]["validacion"] = "requerido";
        $entradas[0]["valor"] = $this->datosescaner[$entradas[0]["nombre"]];
        $entradas[0]["tamano"] = "20";
        $entradas[0]["mensaje"] = "Nombre de opcion formato";
        $entradas[0]["mensaje2"] = "Opcion formato completo";

        $entradas[1]["tipo"] = "texto";
        $entradas[1]["nombre"] = "nombrecortoopcion_7";
        $entradas[1]["division"] = "2";
        $entradas[1]["validacion"] = "requerido";
        $entradas[1]["valor"] = $this->datosescaner[$entradas[1]["nombre"]];
        $entradas[1]["tamano"] = "20";
        $entradas[1]["mensaje"] = "Nombre de opcion formato corta";
        $entradas[1]["mensaje2"] = "Opcion formato corta";

        $entradas[2]["tipo"] = "texto";
        $entradas[2]["nombre"] = "valoropcion_7";
        $entradas[2]["division"] = "4";
        $entradas[2]["validacion"] = "requerido";
        $entradas[2]["valor"] = $this->datosescaner[$entradas[2]["nombre"]];
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
        $entradas[0]["division"] = "4";
        $entradas[0]["validacion"] = "requerido";
        $entradas[0]["valor"] = $this->datosescaner[$entradas[0]["nombre"]];
        $entradas[0]["tamano"] = "20";
        $entradas[0]["mensaje"] = "Nombre de opcion resoluci&ocute;n";
        $entradas[0]["mensaje2"] = "Opcion resoluci&oacute;n completo";

        $entradas[1]["tipo"] = "texto";
        $entradas[1]["nombre"] = "nombrecortoopcion_8";
        $entradas[1]["division"] = "2";
        $entradas[1]["validacion"] = "requerido";
        $entradas[1]["valor"] = $this->datosescaner[$entradas[1]["nombre"]];
        $entradas[1]["tamano"] = "20";
        $entradas[1]["mensaje"] = "Nombre de opcion resoluci&oacute;n corta";
        $entradas[1]["mensaje2"] = "Opcion resoluci&oacute;n corta";

        $entradas[2]["tipo"] = "texto";
        $entradas[2]["nombre"] = "valoropcion_8";
        $entradas[2]["division"] = "4";
        $entradas[2]["validacion"] = "requerido";
        $entradas[2]["valor"] = $this->datosescaner[$entradas[2]["nombre"]];
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
        $entradas[0]["division"] = "4";
        $entradas[0]["validacion"] = "requerido";
        $entradas[0]["valor"] = $this->datosescaner[$entradas[0]["nombre"]];
        $entradas[0]["tamano"] = "20";
        $entradas[0]["mensaje"] = "Nombre de opcion directorio";
        $entradas[0]["mensaje2"] = "Opcion directorio completo";

        $entradas[1]["tipo"] = "texto";
        $entradas[1]["nombre"] = "nombrecortoopcion_9";
        $entradas[1]["division"] = "2";
        $entradas[1]["validacion"] = "requerido";
        $entradas[1]["valor"] = $this->datosescaner[$entradas[1]["nombre"]];
        $entradas[1]["tamano"] = "20";
        $entradas[1]["mensaje"] = "Nombre de opcion directorio corta";
        $entradas[1]["mensaje2"] = "Opcion directorio corta";

        $entradas[2]["tipo"] = "texto";
        $entradas[2]["nombre"] = "valoropcion_9";
        $entradas[2]["division"] = "4";
        $entradas[2]["validacion"] = "url";
        $entradas[2]["valor"] = $this->datosescaner[$entradas[2]["nombre"]];
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
