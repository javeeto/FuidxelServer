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
 * Descripcion del codigo de GestionDocumento
 * 
 * @file GestionDocumento.php
 * @author Javier Lopez Martinez
 * @date 15/11/2016
 * @brief Contiene ...
 */
class GestionDocumento {

    /**
     *  Objeto de conexion base de datos
     *
     * @var BaseGeneral
     */
    private $objbase;

    /**
     * Activacion del debug
     *
     * @var Bool
     */
    private $debug;

    /**
     * Arreglo de datos documento
     * para registrar
     *
     * @var Array
     */
    private $datosdocumento;

    /**
     * Identificador detalle documento
     *
     * @var Integer
     */
    private $iddetalledocumento;

    /**
     * Identificador de documento
     *
     * @var Integer
     */
    private $iddocumento;

    /**
     * Identificador de imagen
     *
     * @var Integer
     */
    private $idimagen;

    /**
     *  Identificador de usuario
     *
     * @var integer
     */
    private $idusuario;

    /**
     * @brief Inicializacion de variables de conexion
     * 
     * Iniciacion de variables y cadenas de conexion BD
     * 
     * @param[in] objbase recurso de base de datos.
     * @return Nada
     */
    public function __construct($objbase) {
        $this->objbase = $objbase;
        $this->debug = 0;
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
     * @brief Define identificador de registro detalle documento documento
     * 
     * Define identificador de detalle de registro documento
     * en indexación
     * 
     * @param Integer $iddetalledocumento Objeto control imagen
     * @return Nada
     */
    function setIddetalledocumento($iddetalledocumento) {
        $this->iddetalledocumento = $iddetalledocumento;
    }

    /**
     * @brief Define identificador de registro documento
     * 
     * Define identificador de  documento en indexación
     * 
     * @param Integer $iddocumento Identificador documento
     * @return Nada
     */
    function setIddocumento($iddocumento) {
        $this->iddocumento = $iddocumento;
    }

    /**
     * @brief Define identificador de imagen 
     * 
     * Define identificador de imagen en indexación
     * 
     * @param Integer $idimagen Identificador imagen
     * @return Nada
     */
    function setIdimagen(Integer $idimagen) {
        $this->idimagen = $idimagen;
    }

    /**
     * @brief Define arreglo de datos documento 
     * 
     * Define arreglo de datos documento
     * 
     * @param Array $datosdocumento Datos Documento
     * @return Nada
     */
    function setDatosDocumento($datosdocumento) {
        $this->datosdocumento = $datosdocumento;
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
     * @brief Consulta ultimo registro de documento
     * 
     * Consulta de ultimo registro de acuerdo a filtro de consulta
     * 
     * @param condicion recurso de base de datos.
     * @return integer identificador de documento
     */
    public function consultaUltimoDocumento($condicion) {

        $query = "select max(iddocumento) maxiddocumento from documento where " . $condicion;
        if ($this->debug) {
            echo $query;
        }
        $resquery = $this->objbase->query($query);
        $maxescaner = $resquery->fetchRow();
        return $maxescaner["maxiddocumento"];
    }

    /**
     * @brief Registraen BD datos generales de documento
     * 
     * Registra en base de datos datos documento
     * 
     * @return iddocumento Documento registrado
     */
    public function registrarDocumento() {
        $nuevodocumento = 0;
        $tabla = "documento";
        $fila["rutadocumento"] = limpiaCadena($this->datosdocumento["rutadocumento"]);

        $fila["fechafinaldocumento"] = date("Y-m-d H:i:s");
        $fila["idrepositorio"] = limpiaCadena($this->datosdocumento["idrepositorio"]);
        $fila["idusuario"] = $this->idusuario;
        $fila["idestado"] = "100";
        if (isset($this->iddocumento) &&
                $this->iddocumento != '') {
            $condicion = " iddocumento='" . $this->iddocumento . "'";
        } else {
            $fila["fechainiciodocumento"] = date("Y-m-d H:i:s");
            $condicion2 = " rutadocumento='" . $fila["rutadocumento"] . "'" .
                    " and idusuario='" . $fila["idusuario"] . "'" .
                    " and idrepositorio='" . $fila["idrepositorio"] . "'";
            $nuevodocumento = 1;
        }

        $this->objbase->insertar_fila_bd($tabla, $fila, $this->debug, $condicion);
        if ($nuevodocumento) {
            $this->iddocumento = $this->consultaUltimoDocumento($condicion2);
        }
        return $this->iddocumento;
    }

    /**
     * @brief Consulta ultimo registro de documento
     * 
     * Consulta de ultimo registro de acuerdo a filtro de consulta
     * 
     * @param condicion recurso de base de datos.
     * @return integer identificador de documento
     */
    public function consultaUltimoDetalle($condicion) {

        $query = "select max(iddetalledocumento) maxiddetalle from detalledocumento where " . $condicion;
        if ($this->debug) {
            echo $query;
        }
        $resquery = $this->objbase->query($query);
        $maxescaner = $resquery->fetchRow();
        return $maxescaner["maxiddetalle"];
    }

    /**
     * @brief Registraen BD datos generales de documento
     * 
     * Registra en base de datos datos documento
     * 
     * @return iddocumento Documento registrado
     */
    public function registrarDetalleDocumento() {
        $nuevodocumento = 0;
        $tabla = "detalledocumento";
        $fila["iddocumento"] = $this->iddocumento;
        $fila["rutadetalledocumento"] = limpiaCadena($this->datosdocumento["rutadetalledocumento"]);
        $fila["ordendetalledocumento"] = limpiaCadena($this->datosdocumento["ordendetalledocumento"]);
        $fila["fechadetalledocumento"] = date("Y-m-d H:i:s");
        $fila["idusuario"] = $this->idusuario;
        $fila["idestado"] = "100";
        if (isset($this->iddetalledocumento) &&
                $this->iddetalledocumento != '') {
            $condicion = " iddetalledocumento='" . $this->iddetalledocumento . "'";
        } else {
            $condicion = " iddocumento='" . $fila["iddocumento"] . "'" .
                    " and ordendetalledocumento='" . $fila["ordendetalledocumento"] . "'";
            $nuevodetalledocumento = 1;
        }
        $this->objbase->insertar_fila_bd($tabla, $fila, $this->debug, $condicion);
        if ($nuevodetalledocumento) {
            $this->iddetalledocumento = $this->consultaUltimoDetalle($condicion);
        }
        return $this->iddetalledocumento;
    }

    /**
     * @brief Actualiza anteriores controles 
     * 
     * Actualiza anteriores controles de documento
     * para dejarlos en estado inhabilitado y el nuevo
     * control quede como activo
     * 
     * @return iddocumento Documento registrado
     */
    public function inhabilitaControl() {
        $nuevodocumento = 0;
        $tabla = "controldocumento";
        $fila["idestado"] = "300";

        if (isset($this->iddetalledocumento) &&
                trim($this->iddetalledocumento) != '') {

            $nombreidtabla = "iddetalledocumento";
            $idtabla = $this->iddetalledocumento;
            $condicion = " and idestado='100'";
            $this->objbase->actualizar_fila_bd($tabla, $fila, $nombreidtabla, $idtabla, $condicion, $this->debug);
        }
    }

    /**
     * @brief Registraen BD datos generales de documento
     * 
     * Registra en base de datos datos documento
     * 
     * @return iddocumento Documento registrado
     */
    public function registrarControlDocumento() {
        $this->inhabilitaControl();
        $nuevodocumento = 0;
        $tabla = "controldocumento";
        $fila["iddetalledocumento"] = $this->iddetalledocumento;
        $fila["idestadocontrol"] = limpiaCadena($this->datosdocumento["idestadocontrol"]);
        $fila["fechacontroldocumento"] = date("Y-m-d H:i:s");
        $fila["descripcioncontroldocumento"] = limpiaCadena($this->datosdocumento["descripcioncontroldocumento"]);
        $fila["idusuario"] = $this->idusuario;
        $fila["idestado"] = "100";
        $fila["paginacontroldocumento"] = limpiaCadena($this->datosdocumento["paginacontroldocumento"]);
        if (isset($this->idimagen) &&
                $this->idimagen != '') {
            $fila["idimagen"] = $this->idimagen;
        }

        $this->objbase->insertar_fila_bd($tabla, $fila, $this->debug, $condicion);
    }

    /**
     * @brief Registraen BD datos generales de documento
     * 
     * Registra en base de datos datos documento
     * 
     * @return iddocumento Documento registrado
     */
    public function consultaDocumentoSinOCR() {
        $tabla = "documento d, detalledocumento dd, repositorio r,controldocumento c";
        $nombreidtabla = "c.idestado";
        $idtabla = "100";
        $condicion = " and c.iddetalledocumento=dd.iddetalledocumento " .
                "and d.iddocumento=dd.iddocumento " .
                "and r.idrepositorio=d.idrepositorio " .
                "and c.idestadocontrol in ('3','7') ";

        $resdatosdoc = $this->objbase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", $this->debug);
        while ($rowdatosdoc = $resdatosdoc->fetchRow()) {
            $datosdoc[] = $rowdatosdoc;
        }
        return $datosdoc;
    }

    /**
     * @brief Registraen BD datos generales de documento
     * 
     * Registra en base de datos datos documento
     * 
     * @return iddocumento Documento registrado
     */
    public function consultaDocumentoDetalle() {
        $tabla = "documento d, detalledocumento dd, repositorio r";
        $nombreidtabla = "d.idestado";
        $idtabla = "100";
        $condicion = " and d.iddocumento=dd.iddocumento " .
                "and r.idrepositorio=d.idrepositorio " .
                "and dd.iddetalledocumento='" . $this->iddetalledocumento . "' ";

        $resdatosdoc = $this->objbase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", $this->debug);
        while ($rowdatosdoc = $resdatosdoc->fetchRow()) {
            $datosdoc[] = $rowdatosdoc;
        }
        return $datosdoc;
    }
    
        /**
     * @brief Consulta detalle documento con control
     * 
     * Consulta detalle documento con control
     * 
     * @return iddocumento Documento registrado
     */
    public function consultaControlDocumentoDetalle() {
        $tabla = "documento d, detalledocumento dd, repositorio r,controldocumento c";
        $nombreidtabla = "d.idestado";
        $idtabla = "100";
        $condicion = " and d.iddocumento=dd.iddocumento " .
                " and dd.iddetalledocumento=c.iddetalledocumento " .
                "and r.idrepositorio=d.idrepositorio " .
                "and c.idestado='100' " .
                "and dd.iddetalledocumento='" . $this->iddetalledocumento . "' ";

        $resdatosdoc = $this->objbase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", $this->debug);
        while ($rowdatosdoc = $resdatosdoc->fetchRow()) {
            $datosdoc[] = $rowdatosdoc;
        }
        return $datosdoc;
    }

}
