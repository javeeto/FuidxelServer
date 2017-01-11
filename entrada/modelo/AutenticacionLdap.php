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
 * Descripcion del codigo de Autenticacion
 * 
 * @file Autenticacion.php
 * @author Javier Lopez Martinez
 * @date 15/09/2016
 * @brief Contiene ...
 */
class AutenticacionLdap {

    /**
     * Variable con nombre de usuario
     *
     * @var string
     */
    private $usuario;

    /**
     * Variable con nombre de usuario
     *
     * @var string
     */
    private $clave;

    /**
     *  Cadena de conexion ldap de administracion
     *
     * @var string
     */
    private $cadenaadmin;

    /**
     *  Cadena de conexion ldap de administracion
     *
     * @var string
     */
    private $claveadmin;

    /**
     *  IP o nombre de servidor LDAP 
     *
     * @var string
     */
    private $servidor;

    /**
     *  Puerto de conexion a servidor LDAP
     *
     * @var string
     */
    private $puerto;

    /**
     *  Recurso de conexion LDAP
     *
     * @var resource
     */
    private $conexion;

    /**
     * @brief Inicializacion de variables de conexion
     * 
     * Iniciacion de variables y cadenas de conexion LDAP
     * tanto de usuario en sesion como administrador de cuentas
     * @param[in] usuario nombre de usuario de logueo.
     * @param[in] clave de usuario.
     * @return Nada
     */
    function __construct($usuario, $clave) {
        $this->usuario = $usuario;
        $this->clave = $clave;
        $this->cadenaadmin = CADENAADMINLDAP;
        $this->claveadmin = CLAVEADMINLDAP;
        $this->servidor = IPSERVIDORLDAP;
        $this->puerto = PUERTOSERVIDORLDAP;

        $this->raizdirectorio = RAIZDIRECTORIOLDAP;
        $this->conexion = ldap_connect($this->servidor, $this->puerto);
        ldap_set_option($this->conexion, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->conexion, LDAP_OPT_REFERRALS, 0);
    }

    /**
     * @brief Conexion de administrador  
     * 
     * Para tareas de administracion como crear o modificar
     * entradas es necesaria esta conexion
     * 
     * @return Nada
     */
    function ConexionAdmin() {

        if (!($resultado = @ldap_bind($this->conexion, $this->cadenaadmin, $this->claveadmin))) {
            echo "ERROR DE CONEXION, COMPRUEBE LA CONEXION AL SERVIDOR LDAP " . $this->conexion . "," . $this->cadenaadmin . ",";
            $resultado = @ldap_bind($this->conexion);
        }
    }

    /**
     * @brief Funcion de autenticacion de sesion ldap
     * 
     * Iniciacion de variables y cadenas de conexion LDAP
     * tanto de usuario en sesion como administrador de cuentas
     * @param[in] usuario nombre de usuario de logueo.
     * @param[in] clave de usuario.
     * @return Nada
     */
    function Autentificar() {
        @$sr = ldap_search($this->conexion, $this->raizdirectorio, "uid=" . $this->usuario);
        @$info = ldap_get_entries($this->conexion, $sr);

        if (@ldap_count_entries($this->conexion, $sr) < 1)
            $this->tmpexisteusuario = false;
        else
            $this->tmpexisteusuario = true;

        ldap_close($this->conexion);
        $this->conexion = ldap_connect($this->servidor, $this->puerto);  // Asumimos que el servidor LDAP esta en el
        ldap_set_option($this->conexion, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->conexion, LDAP_OPT_REFERRALS, 0);
        //echo "\n".$info[0]["dn"].",".$password;
        if (@$resultado = ldap_bind($this->conexion, $info[0]["dn"], $this->clave)) {
            return true;
        }

        return false;
    }

    /**
     * @brief Crea entrada de usuario
     * 
     * A partir de arreglo crea entrada de usuario en el
     * directorio
     * 
     * @param Array $datosusuario Arreglo con datos de usuario
     * 
     * @return Nada
     */
    function crearUsuario($datosusuario) {

        $info["cn"] = $datosusuario["nombreusuario"];
        $info["givenName"] = limpiaCadena($datosusuario["nombrepersona"]);
        $info["mail"] = limpiaCadena($datosusuario["emailpersona"]);
        $info["o"] = limpiaCadena($datosusuario["nombreentidad"]);
        $info['objectclass'][0] = "inetOrgPerson";
        $info['objectclass'][1] = "top";
        $info["sn"] = quitartilde($datosusuario["teloficinapersona"]);
        $info["telephonenumber"] = quitartilde($datosusuario["teloficinapersona"]);
        $info["uid"] = $datosusuario["nombreusuario"];
        $tiempo = (int) (mktime(0, 0, 0, date("m"), (date("d") + 1), date("Y")) / (24 * 60 * 60));
        $info["userPassword"] = "{MD5}" . base64_encode(pack("H*", md5($datosusuario["claveusuario"])));

        $respuesta = ldap_add($this->conexion, "uid=" . $datosusuario["nombreusuario"] . "," . $this->raizdirectorio, $info);
        if (!$respuesta)
            return false;
    }

    /**
     * @brief Modifica entrada de usuario
     * 
     * Realiza buqueda de usuario con respecto al
     * nombre de usuario
     * 
     * @param Array $datosusuario Arreglo con datos de usuario
     * @param String $usuario Nombre de usuario
     * 
     * @return Nada
     */
    function modificarUsuario($datosusuario, $usuario) {

        //$info["cn"] = $datosusuario["nombreusuario"];
        $infonuevo["givenName"] = limpiaCadena($datosusuario["nombrepersona"]);
        $infonuevo["mail"] = limpiaCadena($datosusuario["emailpersona"]);
        $infonuevo["o"] = limpiaCadena($datosusuario["nombreentidad"]);
        //$info['objectclass'][0] = "inetOrgPerson";
       // $info['objectclass'][1] = "top";
        $infonuevo["sn"] = quitartilde($datosusuario["teloficinapersona"]);
        $infonuevo["telephonenumber"] = quitartilde($datosusuario["teloficinapersona"]);
       // $info["uid"] = $datosusuario["nombreusuario"];
        $infonuevo["userPassword"] = "{MD5}" . base64_encode(pack("H*", md5($datosusuario["claveusuario"])));

        $sr = ldap_search($this->conexion, $this->raizdirectorio, "uid=" . $usuario);
        $info = ldap_get_entries($this->conexion, $sr);

        if (isset($info[0]["dn"]) &&
                trim($info[0]["dn"]) != '') {
            if (@ldap_modify($this->conexion, $info[0]["dn"], $infonuevo)) {

                return 1;
            } else {

                return 0;
            }
        } else {
            return 0;
        }
    }

}
