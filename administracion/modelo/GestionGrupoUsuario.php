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
 * Descripcion del codigo de GestionGrupoUsuario
 * 
 * @file GestionGrupoUsuario.php
 * @author Javier Lopez Martinez
 * @date 10/10/2016
 * @brief Contiene ...
 */
class GestionGrupoUsuario {
    //put your code here

    /**
     *  Objeto de conexion base de datos
     *
     * @var BaseGeneral
     */
    private $objbase;

    /**
     *  Arreglo de datos de usuario
     *
     * @var Array
     */
    private $datosgrupousuario;

    /**
     *  Identificador de grupo de usuario
     *
     * @var Integer
     */
    private $idgrupousuario;

    /**
     * @brief Inicializacion de variables usuario
     * 
     * Iniciacion de variables y cadenas de conexion BD
     * 
     * @param[in] usuario nombre de usuario de logueo.
     * @param[in] objbase recurso de base de datos.
     * @return Nada
     */
    public function __construct($objbase) {
        $this->objbase = $objbase;
        $this->debug = 0;
    }

    public function debug() {
        $this->debug = 1;
    }

    /**
     * @brief Define identificador de grupo usuario
     * 
     * Consulta en base de datos datos de grupo usuario
     * 
     * @param int $idgrupousuario identificador de usuario
     */
    public function setIdGrupoUsuario($idgrupousuario) {
        $this->idgrupousuario = limpiaCadena($idgrupousuario);
        // return $this->idgrupousuario;
    }

    /**
     * @brief Retorna identificador de grupo usuario
     * 
     * Obtiene identificador de grupo usuario
     * 
     * @return Integer idgrupousuario grupo de usuario
     */
    public function getIdGrupoUsuario() {
        return $this->idgrupousuario;
    }

    /**
     * @brief Define array de datos de grupo usuario
     * 
     * Iniciacion de variables de grupo usuario
     * 
     * @param Array $datosgrupousuario Datos de grupo usuario
     * @return Nada
     */
    public function setDatosGrupoUsuario($datosgrupousuario) {
        $this->datosgrupousuario = $datosgrupousuario;
    }

    /**
     * @brief Consulta ultimo registro de grupo usuario
     * 
     * Consulta de ultimo registro de acuerdo a filtro de consultar
     * 
     * @param String $condicion recurso de base de datos.
     * @return Integer identificador de usuario
     */
    public function consultaUltimoGrupoUsuario($condicion) {

        $query = "select max(idgrupousuario) maxidgrupousuario from grupousuario where " . $condicion;
        if ($this->debug) {
            echo $query;
        }
        $resquery = $this->objbase->query($query);
        $maxescaner = $resquery->fetchRow();
        return $maxescaner["maxidgrupousuario"];
    }

    /**
     * @brief Registraen BD datos generales de grupo usuario
     * 
     * Registra en base de datos datos  de grupo  usuario
     * 
     * @return idgrupousuario Grupo Usuario registrado
     */
    public function registrarDatosGrupoUsuario() {

        $tabla = "grupousuario";
        $fila["nombregrupousuario"] = limpiaCadena($this->datosgrupousuario["nombregrupousuario"]);
        $fila["idtipogrupousuario"] = limpiaCadena($this->datosgrupousuario["idtipogrupousuario"]);
        $fila["idestado"] = limpiaCadena($this->datosgrupousuario["idestado"]);
        $fila["fechagrupousuario"] = date("Y-m-d H:i:s");
        $fila["idescaner"] = limpiaCadena($this->datosgrupousuario["idescaner"]);



        if (isset($this->idgrupousuario) &&
                $this->idgrupousuario != '') {
            $condicion = " idgrupousuario='" . $this->idgrupousuario . "'";
        } else {
            $condicion = " nombregrupousuario='" . $fila["nombregrupousuario"] . "'" .
                    " and idescaner='" . $fila["idescaner"] . "'";
            $nuevousuario = 1;
        }

        $this->objbase->insertar_fila_bd($tabla, $fila, $this->debug, $condicion);
        if ($nuevousuario) {
            $this->idgrupousuario = $this->consultaUltimoGrupoUsuario($condicion);
        }
    }

    /**
     * @brief Registraen BD datos generales de grupo usuario
     * 
     * Registra en base de datos datos  de grupo  usuario
     * 
     * @return idgrupousuario Grupo Usuario registrado
     */
    public function registrarDatosAsignaGrupo() {


        $tabla = "asignagrupousuario";
        $i = 0;
        $this->desactivaAsignacion();
        while ($this->datosgrupousuario["idgrupousuariohijo" . $i] &&
        trim($this->datosgrupousuario["idgrupousuariohijo" . $i]) != '') {
            $fila["idgrupousuario"] = $this->idgrupousuario;
            $fila["idgrupousuariohijo"] = limpiaCadena($this->datosgrupousuario["idgrupousuariohijo" . $i]);
            $fila["idestado"] = limpiaCadena($this->datosgrupousuario["idestado"]);
            $fila["fechaasignagrupousuario"] = date("Y-m-d H:i:s");


            if (isset($this->idgrupousuario) &&
                    $this->idgrupousuario != '') {
                $condicion = " idgrupousuario='" . $this->idgrupousuario . "'" .
                        " and idgrupousuariohijo='" . $fila["idgrupousuariohijo"] . "'";
            }

            $this->objbase->insertar_fila_bd($tabla, $fila, $this->debug, $condicion);
            /* if ($nuevousuario) {
              $this->idgrupousuario = $this->consultaUltimoGrupoUsuario($condicion);
              } */
            $i++;
        }
    }

    /**
     * @brief Actualiza registros de asignacion
     * 
     * Actualiza asignacion a estado desactivado 200
     * del idgrupousuario en sesion
     * 
     * @return idgrupousuario Grupo Usuario registrado
     */
    private function desactivaAsignacion() {
        if (isset($this->idgrupousuario) &&
                trim($this->idgrupousuario) != '') {
            $tabla = "asignagrupousuario";
            $fila["idestado"] = "200";
            $nombreidtabla = "idgrupousuario";
            $idtabla = $this->idgrupousuario;
            $condicion="";
            $this->objbase->actualizar_fila_bd($tabla, $fila, $nombreidtabla, $idtabla, $condicion, $this->debug);
        }
    }

    /**
     * @brief Consulta en BD lista de tipos de grupo
     * 
     * Consulta en base de datos datos tipos de grupo usuario
     * 
     * @return datostipo Arreglo con datos de tipo grupo
     */
    public function consultaTipoGrupoUsuario() {
        $tablas = "tipogrupousuario t";
        $nombreidtabla = "idestado";
        $idtabla = "100";
        $condicion = "";

        $resdatostipogrupo = $this->objbase->recuperar_resultado_tabla($tablas, $nombreidtabla, $idtabla, $condicion, "", $this->debug);
        while ($rowtipo = $resdatostipogrupo->fetchRow()) {
            $datostipo[] = $rowtipo;
        }

        return $datostipo;
    }

        /**
     * @brief Consulta en BD lista de tipos de grupo
     * 
     * Consulta en base de datos datos tipos de grupo usuario
     * 
     * @return datostipo Arreglo con datos de tipo grupo
     */
    public function consultaAsignaGrupoUsuario() {
        
        $tablas = "asignagrupousuario";
        $nombreidtabla = "idestado";
        $idtabla = "100";
        $condicion = " and idgrupousuario='".$this->idgrupousuario."'";

        $resdatostipogrupo = $this->objbase->recuperar_resultado_tabla($tablas, $nombreidtabla, $idtabla, $condicion, "", $this->debug);
        while ($rowtipo = $resdatostipogrupo->fetchRow()) {
            $datostipo[] = $rowtipo;
        }

        return $datostipo;
    }
    
    /**
     * @brief Consulta en BD lista de grupos
     * 
     * Consulta en base de datos grupos de usuario
     * con datos del tipo de grupo
     * 
     * @return datosgrupo Arreglo con datos de entidad
     */
    public function consultaGrupoUsuario() {

        $tablas = "grupousuario g,tipogrupousuario t,escaner e,estado es";
        $nombreidtabla = "g.idestado";
        $idtabla = "100";
        $condicion = " and g.idtipogrupousuario=t.idtipogrupousuario ".
                " and e.idescaner=g.idescaner ".
                " and es.idestado=g.idestado ";

        if (isset($this->idgrupousuario) &&
                trim($this->idgrupousuario) != "") {
            $condicion .= " and g.idgrupousuario='" . $this->idgrupousuario . "'";
        }

        $resdatosgrupo = $this->objbase->recuperar_resultado_tabla($tablas, $nombreidtabla, $idtabla, $condicion, "", $this->debug);
        while ($rowgrupo = $resdatosgrupo->fetchRow()) {
            $datosgrupo[] = $rowgrupo;
        }

        return $datosgrupo;
    }

}
