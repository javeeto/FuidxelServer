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
 * Descripcion del codigo de GestionUsuario
 * 
 * @file GestionUsuario.php
 * @author Javier Lopez Martinez
 * @date 15/09/2016
 * @brief Contiene Clase para gestion los datos de usuario
 */
class GestionUsuario {

    /**
     *  Cadena de nombre de usuario
     *
     * @var string
     */
    private $nombreusuario;

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
     *  Identificador de usuario
     *
     * @var integer
     */
    private $idusuario;

    /**
     *  Identificador de idpersona
     *
     * @var integer
     */
    private $idpersona;

    /**
     *  Arreglo de datos de usuario
     *
     * @var Array
     */
    private $datosusuario;

    /**
     * @brief Inicializacion de variables usuario
     * 
     * Iniciacion de variables y cadenas de conexion BD
     * 
     * @param[in] usuario nombre de usuario de logueo.
     * @param[in] objbase recurso de base de datos.
     * @return Nada
     */
    public function __construct($usuario, $objbase) {
        $this->nombreusuario = $usuario;
        $this->objbase = $objbase;
        $this->debug = 0;
    }

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
     * @brief Define identificador de usuario
     * 
     * Consulta en base de datos datos de sesion de usuario
     * 
     * @param int $idusuario identificador de usuario
     * @return datosusuario Arreglo con datos de usuario
     */
    public function getIdUsuario() {
        return $this->idusuario;
    }

    /**
     * @brief Define identificador de persona
     * 
     * Consulta en base de datos datos de sesion de persona
     * 
     * @param int $persona identificador de persona
     * @return datosusuario Arreglo con datos de persona
     */
    public function setIdPersona($idpersona) {
        $this->idpersona = $idpersona;
    }

    /**
     * @brief Define array de datos de usuario
     * 
     * Iniciacion de variables de usuario
     * 
     * @param Array $datosusuario Datos de usuario
     * @return Nada
     */
    public function setDatosUsuario($datosusuario) {
        $this->datosusuario = $datosusuario;
    }

    /**
     * @brief Consulta en BD datos generales de usuario
     * 
     * Consulta en base de datos datos de sesion de usuario
     * 
     * @return datosusuario Arreglo con datos de usuario
     */
    public function consultaDatosUsuario() {

        $tablas = " usuario u,persona p,entidad e,grupousuario g";
        $condicion = " and u.idpersona=p.idpersona " .
                " and u.idgrupousuario=g.idgrupousuario " .
                " and e.identidad=u.identidad ";

        if (isset($this->idusuario) &&
                trim($this->idusuario) != "") {
            $condicion .= " and u.idusuario='" . $this->idusuario . "'";
        }

        if (isset($this->nombreusuario) &&
                trim($this->nombreusuario) != "") {
            $condicion .= " and u.nombreusuario='" . $this->nombreusuario . "'";
        }


        $datosusuario = $this->objbase->recuperar_datos_tabla($tablas, "u.idestado", "100", $condicion, "", $this->debug);
        unset($datosusuario["claveusuario"]);
        return $datosusuario;
    }
    
        /**
     * @brief Consulta en BD datos generales de usuario
     * 
     * Consulta en base de datos datos de sesion de usuario
     * 
     * @return datosusuario Arreglo con datos de usuario
     */
    public function consultarRegistrosUsuario() {

        $tablas = " usuario u,persona p,entidad e,grupousuario g,estado es,perfil pe";
        $condicion = " and u.idpersona=p.idpersona " .
                " and u.idgrupousuario=g.idgrupousuario " .
                " and e.identidad=u.identidad ".
                " and u.idperfil=pe.idperfil ".
                " and es.idestado=u.idestado";



        $resdatosusuario = $this->objbase->recuperar_resultado_tabla($tablas, "u.idestado", "100", $condicion, "", $this->debug);
        while($rowusuario=$resdatosusuario->fetchRow()){
             unset($rowusuario["claveusuario"]);
            $datosusuario[]=$rowusuario;
        }
       
        return $datosusuario;
    }

    /**
     * @brief Consulta ultimo registro de usuario
     * 
     * Consulta de ultimo registro de acuerdo a filtro de consultar
     * 
     * @param condicion recurso de base de datos.
     * @return integer identificador de usuario
     */
    public function consultaUltimoUsuario($condicion) {

        $query = "select max(idusuario) maxidusuario from usuario where " . $condicion;
        if ($this->debug) {
            echo $query;
        }
        $resquery = $this->objbase->query($query);
        $maxescaner = $resquery->fetchRow();
        return $maxescaner["maxidusuario"];
    }

    /**
     * @brief Registraen BD datos generales de usuario
     * 
     * Registra en base de datos datos  de usuario
     * 
     * @return idusuario Usuario registrado
     */
    public function registrarDatosUsuario() {

        $tabla = "usuario";
        $fila["nombreusuario"] = limpiaCadena($this->datosusuario["nombreusuario"]);
        $fila["claveusuario"] = md5($this->datosusuario["claveusuario"]);
        $fila["fechainiciousuario"] = date("Y-m-d H:i:s");
        $fila["identidad"] = limpiaCadena($this->datosusuario["identidad"]);
        $fila["idpersona"] = $this->idpersona;
        $fila["idperfil"] = limpiaCadena($this->datosusuario["idperfil"]);
        $fila["idgrupousuario"] = limpiaCadena($this->datosusuario["idgrupousuario"]);
        $fila["idestado"] = limpiaCadena($this->datosusuario["idestado"]);

        if (isset($this->idusuario) &&
                $this->idusuario != '') {
            $condicion = " idusuario='" . $this->idusuario . "'";
        } else {
            $condicion = " nombreusuario='" . $fila["nombreusuario"] . "'" .
                    " and idpersona='" . $fila["idpersona"] . "'";
            $nuevousuario = 1;
        }

        $this->objbase->insertar_fila_bd($tabla, $fila, $this->debug, $condicion);
        if ($nuevousuario) {
            $this->idusuario = $this->consultaUltimoUsuario($condicion);
        }
    }

    /**
     * @brief Registraen BD datos generales de usuario
     * 
     * Registra en base de datos datos  de usuario
     * 
     * @return idusuario Usuario registrado
     */
    public function consultaUsuario($usuario) {
        $tablas = "usuario u";
        $condicion = " and  u.nombreusuario='" . trim($usuario) . "'";
        $datosusuario = $this->objbase->recuperar_datos_tabla($tablas, "u.idestado", "100", $condicion, "", $this->debug);
        return $datosusuario;
    }

    /**
     * @brief Consulta ultimo registro de persona
     * 
     * Consulta de ultimo registro de acuerdo a filtro de consultar
     * 
     * @param condicion recurso de base de datos.
     * @return integer identificador de persona
     */
    public function consultaUltimaPersona($condicion) {

        $query = "select max(idpersona) maxidpersona from persona where " . $condicion;
        if ($this->debug) {
            echo $query;
        }
        $resquery = $this->objbase->query($query);
        $maxescaner = $resquery->fetchRow();
        return $maxescaner["maxidpersona"];
    }

    /**
     * @brief Registraen BD datos generales de persona
     * 
     * Registra en base de datos datos  de persona
     * 
     */
    public function registrarDatosPersona() {

        $tabla = "persona";
        $fila["nombrepersona"] = limpiaCadena($this->datosusuario["nombrepersona"]);
        $fila["apellidopersona"] = limpiaCadena($this->datosusuario["apellidopersona"]);
        $fila["identificacionpersona"] = limpiaCadena($this->datosusuario["identificacionpersona"]);
        $fila["idtipoidentificacion"] = limpiaCadena($this->datosusuario["idtipoidentificacion"]);
        $fila["direccionpersona"] = limpiaCadena($this->datosusuario["direccionpersona"]);
        $fila["fechapersona"] = date("Y-m-d H:i:s");
        $fila["idestado"] = limpiaCadena($this->datosusuario["idestado"]);
        $fila["telefonopersona"] = limpiaCadena($this->datosusuario["telefonopersona"]);
        $fila["teloficinapersona"] = limpiaCadena($this->datosusuario["teloficinapersona"]);
        $fila["emailpersona"] = limpiaCadena($this->datosusuario["emailpersona"]);


        if (isset($this->idpersona) &&
                $this->idpersona != '') {
            $condicion = " idpersona='" . $this->idpersona . "'";
        } else {
            $condicion = " nombrepersona='" . $fila["nombrepersona"] . "'" .
                    " and apellidopersona='" . $fila["apellidopersona"] . "'" .
                    " and identificacionpersona='" . $fila["identificacionpersona"] . "'";
            $nuevopersona = 1;
        }

        $this->objbase->insertar_fila_bd($tabla, $fila, $this->debug, $condicion);
        if ($nuevopersona) {
            $this->idpersona = $this->consultaUltimaPersona($condicion);
        }
    }

    /**
     * @brief Consulta en BD lista de tipos de identificacion
     * 
     * Consulta en base de datos datos tipos de identificacion
     * 
     * @return datostipo Arreglo con datos de tipo identificacion
     */
    public function consultaTipoIdentificacion() {
        $tablas = "tipoidentificacion";
        $nombreidtabla = "idtipoidentificacion";
        $idtabla = "nombretipoidentificacion";
        $condicion = " idestado='100'";

        $datostipo = $this->objbase->recuperar_datos_tabla_fila($tablas, $nombreidtabla, $idtabla, $condicion, "", $this->debug);

        return $datostipo;
    }

    /**
     * @brief Consulta en BD lista de entidades
     * 
     * Consulta en base de datos datos lista entidades
     * 
     * @return datosentidad Arreglo con datos de entidad
     */
    public function consultaEntidad($identidad="") {
        $tablas = "entidad";
        $nombreidtabla = "identidad";
        $idtabla = "nombreentidad";
        $condicion = " idestado='100'";
        
        if (isset($identidad) &&
                trim($identidad) != '') {
            $condicion.=" and identidad='".$identidad."'";
        }
        

        $datosentidad = $this->objbase->recuperar_datos_tabla_fila($tablas, $nombreidtabla, $idtabla, $condicion, "", $this->debug);

        return $datosentidad;
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
        $tablas = "grupousuario g,tipogrupousuario t";
        $nombreidtabla = "g.idestado";
        $idtabla = "100";
        $condicion = " and t.idestado='100'" .
                " and g.idtipogrupousuario=t.idtipogrupousuario ";

        $resdatosgrupo = $this->objbase->recuperar_resultado_tabla($tablas, $nombreidtabla, $idtabla, $condicion, "", $this->debug);
        while ($rowgrupo = $resdatosgrupo->fetchRow()) {
            $datosgrupo[] = $rowgrupo;
        }

        return $datosgrupo;
    }

    /**
     * @brief Consulta en BD lista de grupos
     * 
     * Consulta en base de datos grupos de usuario
     * con datos del tipo de grupo
     * 
     * @return datosgrupo Arreglo con datos de entidad
     */
    public function consultaPerfil() {
        $tablas = "perfil";
        $nombreidtabla = "idestado";
        $idtabla = "100";
        $condicion = "";

        $resperfil = $this->objbase->recuperar_resultado_tabla($tablas, $nombreidtabla, $idtabla, $condicion, "", $this->debug);
        while ($rowperfil = $resperfil->fetchRow()) {
            $datosperfil[] = $rowperfil;
        }

        return $datosperfil;
    }

}
