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
 * Description of GestionActaInicio
 *
 * @file GestionConfiguracion.php
 * @author Javier Lopez Martinez
 * @date 25/10/2016
 * @brief Contiene ...
 */
class GestionActaInicio {

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
     * Identificador de acta control
     *
     * @var Integer
     */
    private $idactacontrol;

    /**
     * Arreglo de datos de acta
     *
     * @var Array
     */
    private $datosacta;

    /**
     * Arreglo de datos de usuario
     *
     * @var Array
     */
    private $datosusuario;

    /**
     * @brief Inicializacion de variables usuario
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
     * @brief Debug de ejecucion
     * 
     * Activación de debug de instrucciones sql
     * 
     * @return Nada
     */
    public function debug() {
        $this->debug = 1;
    }

    /**
     * @brief Obtiene id acta control
     * 
     * Obtiene identificador de acta control
     * 
     * @return Integer identificador acta
     */
    function getIdactacontrol() {
        return $this->idactacontrol;
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
     * @brief Obtiene arreglo de datos acta 
     * 
     * Obtiene  arreglo de datos de acta control
     * 
     * @return Array datos acta
     */
    function getDatosActa() {
        return $this->datosacta;
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
     * @brief Define arreglo de datos de usuario 
     * 
     * Define  arreglo de datos de usuario 
     * 
     * @param Array $datosusuario datos usuario
     */
    function setDatosUsuario($datosusuario) {
        $this->datosusuario = $datosusuario;
    }

    /**
     * @brief Consulta ultima acta de control
     * 
     * Consulta de ultimo registro de acta de acuerdo a filtro de consultar
     * 
     * @param condicion sql recurso de base de datos.
     * @return Integer identificador de acta control
     */
    public function consultaUltimaActa($condicion) {

        $query = "select max(idactacontrol) maxidacta from actacontrol where " . $condicion;
        if ($this->debug) {
            echo $query;
        }
        $resquery = $this->objbase->query($query);
        $maxescaner = $resquery->fetchRow();
        return $maxescaner["maxidacta"];
    }

    /**
     * @brief Registro de formulario de datos de acta 
     * 
     * Registro de datos de acta control 
     * 
     * @return Bool respuesta de ingreso exitoso
     */
    public function registroDatosActa() {

        $tabla = "actacontrol";
        $fila["identidad"] = limpiaCadena($this->datosacta["identidad"]);
        $fila["idloteimagen"] = limpiaCadena($this->datosacta["idloteimagen"]);
        $fila["documentoactacontrol"] = limpiaCadena($this->datosacta["documentoactacontrol"]);
        $fila["idgrupousuario"] = limpiaCadena($this->datosusuario["idgrupousuario"]);
        $fila["idusuario"] = limpiaCadena($this->datosusuario["idusuario"]);
        $fila["fechaactacontrol"] = $this->datosacta["fechalote"];
        $fila["fechainicioactacontrol"] = date("Y-m-d H:i:s");
        $fila["fechafinalactacontrol"] = date("Y-m-d H:i:s");
        $fila["configuraactacontrol"] = limpiaCadena($this->datosacta["configuracion"]);
        $fila["idtipoactacontrol"] = limpiaCadena($this->datosacta["idtipoactacontrol"]);
        $fila["idrepositorio"] = limpiaCadena($this->datosacta["idrepositorio"]);
        if (isset($this->datosacta["imagenacta"]) &&
                trim($this->datosacta["imagenacta"]) != '') {
            $fila["imagenactacontrol"] = limpiaCadena($this->datosacta["imagenacta"]);
            $fila["observacionactacontrol"] = limpiaCadena($this->datosacta["observacionacta"]);
            $fila["serialactacontrol"] = limpiaCadena($this->datosacta["serialmedio"]);
            $fila["faltanteactacontrol"] = limpiaCadena($this->datosacta["faltante"]);
        }
        $fila["idestado"] = "100";

        if (isset($this->idactacontrol) &&
                trim($this->idactacontrol) != '') {
            $condicion = " idescaner='" . $this->idactacontrol . "'";
        } else {
            $condicion = " idloteimagen='" . $fila["idloteimagen"] . "'" .
                    " and idusuario='" . $fila["idusuario"] . "'" .
                    " and idtipoactacontrol='" . $fila["idtipoactacontrol"] . "'" .
                    " and identidad='" . $fila["identidad"] . "'";

            $nuevaacta = 1;
        }
        $this->objbase->insertar_fila_bd($tabla, $fila, $this->debug, $condicion);
        if ($nuevaacta) {
            $this->idactacontrol = $this->consultaUltimaActa($condicion);
        }
    }

    /**
     * @brief Registro de adjunto acta 
     * 
     * Registro de formulario de datos de adjunto acta 
     * 
     * @return Bool respuesta de ingreso exitoso
     */
    public function registrarDatosAdjunto($datosadjunto) {
        $tabla = "adjuntoactacontrol";
        $fila["rutaadjuntoactacontrol"] = limpiaCadenaUrl($datosadjunto["rutadocumento"]);
        $fila["nombreadjuntoactacontrol"] = limpiaCadena($datosadjunto["nombredocumento"]);
        $fila["idactacontrol"] = limpiaCadena($this->idactacontrol);
        $fila["fechaadjuntoactacontrol"] = date("Y-m-d H:i:s");
        $fila["idestado"] = "100";

        $condicion = " nombreadjuntoactacontrol='" . $fila["nombreadjuntoactacontrol"] . "'" .
                " and idactacontrol='" . $fila["idactacontrol"] . "'";

        $this->objbase->insertar_fila_bd($tabla, $fila, $this->debug, $condicion);
    }

    /**
     * @brief Consulta acta inicio
     * 
     * consulta de control de acta
     * 
     * @return Bool respuesta de ingreso exitoso
     */
    public function consultaActaControl() {
        $tabla = "actacontrol a, entidad e, grupousuario g,usuario u,persona p";
        $nombreidtabla = "a.idestado";
        $idtabla = "100";
        $condicion = " and a.identidad=e.identidad " .
                " and a.idgrupousuario=g.idgrupousuario " .
                " and a.idusuario=u.idusuario " .
                " and p.idpersona=u.idpersona ";

        if (isset($this->idactacontrol) &&
                trim($this->idactacontrol) != '') {
            $condicion .= " and a.idactacontrol='" . $this->idactacontrol . "'";
        }
        $resdatosacta = $this->objbase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", $this->debug);
        while ($rowacta = $resdatosacta->fetchRow()) {
            $datosacta[] = $rowacta;
        }

        return $datosacta;
    }

    /**
     * @brief Consulta adjunto de acta 
     * 
     * consulta de adjuntos de acta 
     * 
     * @return Bool respuesta de ingreso exitoso
     */
    public function consultaAdjuntoActa() {
        $tabla = "adjuntoactacontrol a";
        $nombreidtabla = "a.idestado";
        $idtabla = "100";
        $condicion = "";

        if (isset($this->idactacontrol) &&
                trim($this->idactacontrol) != '') {
            $condicion .= " and a.idactacontrol='" . $this->idactacontrol . "'";
        }
        $resdatosacta = $this->objbase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", $this->debug);
        while ($rowacta = $resdatosacta->fetchRow()) {
            $datosacta[] = $rowacta;
        }

        return $datosacta;
    }

}
