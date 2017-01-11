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
 * Descripcion del codigo de ConformaDocumento
 * 
 * @file ConformaDocumento.php
 * @author Javier Lopez Martinez
 * @date 15/11/2016
 * @brief Contiene ...
 */
class CargaXMLDocumento {

    /**
     * Activacion del debug
     *
     * @var Bool
     */
    private $debug;

    /**
     * Objeto de Gestion de documento
     *
     * @var GestionDocumentol
     */
    private $objgestiondoc;

    /**
     * Objeto de Base de datos
     *
     * @var BaseGeneral
     */
    private $objbase;

    /**
     * Funciones  de seguridad
     *
     * @var FuncionesSeguridad
     */
    private $objseguridad;

    /**
     * Identificador usuario
     *
     * @var Integer
     */
    private $idusuario;

    /**
     * Estado de control que debe registrarse
     *
     * @var Integer
     */
    private $estadovalida;

    /**
     * @brief Inicializacion de array base de imagenes
     * 
     * Inicializacion de arreglo base de imagenes
     * 
     * 
     * @return Nada
     */
    public function __construct() {

        $conexionmysql = connectionMysqlPDO();
        $this->objbase = new BaseGeneral($conexionmysql);
        $this->objgestiondoc = new GestionDocumento($this->objbase);
        $this->objseguridad = new FuncionesSeguridad($_SESSION["s_nombreusuario"], $this->objbase);
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

    /**
     * @brief Define identificador de usuario
     * 
     * Consulta en base de datos datos de sesion de usuario
     * 
     * @param int $idusuario identificador de usuario
     * @return datosusuario Arreglo con datos de usuario
     */
    public function setIdUsuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    /**
     * @brief Define estado de validacion carga CMIS
     * 
     * Define estado que sirve validar si se realizo
     * control de otro proceso dependiente OCR o Registro de metadatos
     * 
     * @param integer $iddetalledocumento Identificador de documento
     * @return Nada
     */
    function setEstadovalida($estadovalida) {
        $this->estadovalida = $estadovalida;
    }

    /**
     * @brief Carga archivo registrado a servicio cmis
     * 
     * Carga archivo registrado en servicio cmis
     * 
     * @param integer $iddetalledocumento Identificador de documento
     * @return Nada
     */
    public function CargaDocumento($iddetalledocumento) {
        if (isset($_SESSION["s_nombreusuario"])) {
            session_start();
            /* echo "_POST<pre>";
              print_r($_POST);
              echo "</pre>"; */
            if ($this->objseguridad->validaOpcionUsuario("listadoloteindexa")) {

                $this->objgestiondoc->setIddetalledocumento($iddetalledocumento);

                $datosdetalledoc = $this->objgestiondoc->consultaControlDocumentoDetalle();
                $rutadocumento = $datosdetalledoc[0]["rutarepositorio"] . "/" .
                        $datosdetalledoc[0]["rutadocumento"] . "/" .
                        $datosdetalledoc[0]["rutadetalledocumento"];
                if ($this->debug) {
                    echo "datosdetalledoc<pre>";
                    print_r($datosdetalledoc);
                    echo "</pre>";
                    echo "<br>if (" . $datosdetalledoc[0]["idestadocontrol"] . " == " . $this->estadovalida . ") {";
                }

                if ($datosdetalledoc[0]["idestadocontrol"] == $this->estadovalida) {


                    $objConformaCMIS = new ConformaXmlCMIS();
                    if ($this->debug) {
                        $objConformaCMIS->debug();
                    }
                    $objConformaCMIS->setRutaDocumento($rutadocumento);
                    $objConformaCMIS->setIdDetalleDocumento($iddetalledocumento);
                    $objConformaCMIS->cargaServicio();
                    $objConformaCMIS->cargaDocumento();
                    $objConformaCMIS->cargarMetadatoXML();
                    $this->registraControlPublicacion($iddetalledocumento);
                }
            }
        }
    }

    /**
     * @brief Carga archivo registrado a servicio cmis
     * 
     * Carga archivo registrado en servicio cmis
     * 
     * @param integer $iddetalledocumento Identificador de documento
     * @return Nada
     */
    public function registraControlMetadatos($iddetalledocumento) {

        if ($this->debug) {
            $this->objgestiondoc->debug();
        }

        $datosdocumento["idestadocontrol"] = 7;
        $datosdocumento["iddetalledocumento"] = $iddetalledocumento;
        $datosdocumento["descripcioncontroldocumento"] = "Carga de metadatos ISAD";
        $datosdocumento["paginacontroldocumento"] = 1;
        $this->objgestiondoc->setIdUsuario($this->idusuario);
        $this->objgestiondoc->setIddetalledocumento($iddetalledocumento);
        $this->objgestiondoc->setDatosDocumento($datosdocumento);
        $this->objgestiondoc->registrarControlDocumento();
    }

    /**
     * @brief Carga archivo registrado a servicio cmis
     * 
     * Carga archivo registrado en servicio cmis
     * 
     * @param integer $iddetalledocumento Identificador de documento
     * @return Nada
     */
    public function registraControlPublicacion($iddetalledocumento) {
        if ($this->debug) {
            $this->objgestiondoc->debug();
        }
        $datosdocumento["idestadocontrol"] = 6;
        $datosdocumento["iddetalledocumento"] = $iddetalledocumento;
        $datosdocumento["descripcioncontroldocumento"] = "Publicacion de documento";
        $datosdocumento["paginacontroldocumento"] = 1;
        $this->objgestiondoc->setIdUsuario($this->idusuario);
        $this->objgestiondoc->setDatosDocumento($datosdocumento);
        $this->objgestiondoc->setIddetalledocumento($iddetalledocumento);
        $this->objgestiondoc->registrarControlDocumento();
    }

    /**
     * @brief Carga archivo registrado a servicio cmis
     * 
     * Carga archivo registrado en servicio cmis
     * 
     * @param integer $iddetalledocumento Identificador de documento
     * @return Nada
     */
    public function consultaRegistroMetadato($iddetalledocumento) {

        if ($this->objseguridad->validaOpcionUsuario("listadoloteindexa")) {
            $objmetadato = new GestionMetadato($this->objbase);
            $objmetadato->setIdDetalleDocumento($iddetalledocumento);
            $this->objgestiondoc->setIddetalledocumento($iddetalledocumento);
            $datosdetalledoc = $this->objgestiondoc->consultaControlDocumentoDetalle();
            $datosmetadato = $objmetadato->consultaRegistroDocumento();
           /* if ($this->debug) {
                echo "\ndatosmetadato<pre>";
                print_r($datosmetadato);
                echo "</pre>";
            }*/
            $datosMetaDocumento["documento"] = $datosdetalledoc;
            foreach ($datosmetadato as $idmetadato => $rowetadato) {

                if (isset($rowetadato["valordefinitivoregistro"]) &&
                        trim($rowetadato["valordefinitivoregistro"]) != '' &&
                        isset($rowetadato["xmlcampometadato"]) &&
                        trim($rowetadato["xmlcampometadato"]) != '') {
                    $datosMetaDocumento["metadato"][] = $rowetadato;
                }
            }
        }
        if ($this->debug) {
            echo "===================datosMetaDocumento==============<pre>";
            print_r($datosMetaDocumento);
            echo "</pre>";
        }


        return $datosMetaDocumento;
    }

}
