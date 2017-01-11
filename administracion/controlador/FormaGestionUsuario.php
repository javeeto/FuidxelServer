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
 * Descripcion del codigo de FormaGestionUsuario
 * 
 * @file FormaGestionUsuario.php
 * @author Javier Lopez Martinez
 * @date 4/10/2016
 * @brief Contiene ...
 */
class FormaGestionUsuario {

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
     * @var GestionUsuario
     */
    private $objgestionusuario;

    /**
     *  Arreglo de datos de usuario
     *
     * @var Array
     */
    private $datosusuario;

    /**
     *  Identificador de usuario
     *
     * @var Integer
     */
    private $idusuario;

    /**
     * @brief Inicializacion de datos de usuario
     * 
     * Iniciacion de variables de usuario
     * 
     * @param[in] objbase recurso de base de datos.
     * @param[in] objformulario recurso de formulario.
     * @param[in] objgestionusuario gestión de usuario.
     * @return Nada
     */
    public function __construct($objbase, $objformulario, $objgestionusuario) {
        $this->objbase = $objbase;
        $this->objformulario = $objformulario;
        $this->objgestionusuario = $objgestionusuario;
        $this->datosusuario = array();
    }

    /**
     * @brief Define array de datos de usuario
     * 
     * Iniciacion de variables de usuario
     * 
     * @param[in] idusuario identificador de usuario
     * @return Nada
     */
    public function setIdUsuario($idusuario) {
        $this->idusuario = $idusuario;
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
     * @brief Define array de campos de forma
     * 
     * Formulario del panel de campos persona
     * arma entradas html con parametros
     * formulario
     * 
     * @return Arreglo de campos html
     */
    public function panelGeneral() {
        //$error = 0;
        $titulocampo = "Nombres ";
        $nombre = "nombrepersona";
        $validacion = "alfanumerico";
        $valor = $this->datosusuario[$nombre];
        $tamano = "100";
        $mensaje = "Nombres de la persona";
        $mensaje2 = "Nombres de la persona";
        $arrPanel["campoHtml"][] = $this->objformulario->campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2);
        $arrPanel["errorHtml"][] = $this->objformulario->getEstiloError($nombre);

        $titulocampo = "Apellidos ";
        $nombre = "apellidopersona";
        $validacion = "alfanumerico";
        $valor = $this->datosusuario[$nombre];
        $tamano = "100";
        $mensaje = "Apellidos de la persona";
        $mensaje2 = "Solo apellidos de la persona";
        $arrPanel["campoHtml"][] = $this->objformulario->campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2);
        $arrPanel["errorHtml"][] = $this->objformulario->getEstiloError($nombre);

        $titulocampo = "Tipo de identificaci&oacute;n";
        $nombre = "idtipoidentificacion";
        $validacion = "requerido";
        $valor = $this->datosusuario[$nombre];
        $mensaje = "Seleccionar tipo de identificacion";
        $mensaje2 = "Tipo de identificacion";
        $datostipo = $this->objgestionusuario->consultaTipoIdentificacion();
        //$opciones
        $opciones = $datostipo;
        $opciones[""] = "Seleccionar";
        $arrPanel["campoHtml"][] = $this->objformulario->campoMenu($titulocampo, $nombre, $validacion, $valor, $opciones, $mensaje, $mensaje2, $ayuda);
        $arrPanel["errorHtml"][] = $this->objformulario->getEstiloError($nombre);

        $titulocampo = "Identificacion ";
        $nombre = "identificacionpersona";
        $validacion = "numerico";
        $valor = $this->datosusuario[$nombre];
        $tamano = "100";
        $mensaje = "Numero de identificacion de la persona";
        $mensaje2 = "Identificacion de la persona";
        $arrPanel["campoHtml"][] = $this->objformulario->campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2, "", "number");
        $arrPanel["errorHtml"][] = $this->objformulario->getEstiloError($nombre);


        $titulocampo = "Direcci&oacute;n ";
        $nombre = "direccionpersona";
        $validacion = "alfanumerico";
        $valor = $this->datosusuario[$nombre];
        $tamano = "100";
        $mensaje = "Direcci&oacute;n principal de la persona";
        $mensaje2 = "Direcci&oacute;n de la persona";
        $arrPanel["campoHtml"][] = $this->objformulario->campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2);
        $arrPanel["errorHtml"][] = $this->objformulario->getEstiloError($nombre);

        $titulocampo = "Telefono";
        $nombre = "telefonopersona";
        $validacion = "numerico";
        $valor = $this->datosusuario[$nombre];
        $tamano = "100";
        $mensaje = "Telefono principal de la persona";
        $mensaje2 = "Telefono de la persona";
        $arrPanel["campoHtml"][] = $this->objformulario->campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2, "", "number");
        $arrPanel["errorHtml"][] = $this->objformulario->getEstiloError($nombre);

        $titulocampo = "Telefono Oficina";
        $nombre = "teloficinapersona";
        $validacion = "numerico";
        $valor = $this->datosusuario[$nombre];
        $tamano = "100";
        $mensaje = "Telefono de la oficina de la persona";
        $mensaje2 = "Telefono oficina de la persona";
        $arrPanel["campoHtml"][] = $this->objformulario->campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2, "", "number");
        $arrPanel["errorHtml"][] = $this->objformulario->getEstiloError($nombre);

        $titulocampo = "Email";
        $nombre = "emailpersona";
        $validacion = "email";
        $valor = $this->datosusuario[$nombre];
        $tamano = "100";
        $mensaje = "Email de la persona";
        $mensaje2 = "Email de la persona";
        $arrPanel["campoHtml"][] = $this->objformulario->campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2);
        $arrPanel["errorHtml"][] = $this->objformulario->getEstiloError($nombre);

        return $arrPanel;
    }

    /**
     * @brief Define array de campos de forma
     * 
     * Formulario del panel de campos usuario
     * arma entradas html con parametros
     * formulario
     * 
     * @return Arreglo de campos html
     */
    public function panelUsuario() {
        //$error = 0;
        $titulocampo = "Usuario ";
        $nombre = "nombreusuario";

        if (isset($this->datosusuario[$nombre]) &&
                trim($this->datosusuario[$nombre]) != '') {
            $validacion = "readonly";
        } else {
            $validacion = "alfabetico";
        }

        $valor = $this->datosusuario[$nombre];
        $tamano = "100";
        $mensaje = "Nombre de usuario en sistema";
        $mensaje2 = "Nombre de usuario";
        $arrPanel["campoHtml"][] = $this->objformulario->campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2);
        $arrPanel["errorHtml"][] = $this->objformulario->getEstiloError($nombre);

        $titulocampo = "Clave ";
        $nombre = "claveusuario";
        $validacion = "alfanumerico";
        $valor = $this->datosusuario[$nombre];
        $tamano = "100";
        $mensaje = "Clave de usuario en sistema";
        $mensaje2 = "Clave de usuario";
        $arrPanel["campoHtml"][] = $this->objformulario->campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2, "", "password");
        $arrPanel["errorHtml"][] = $this->objformulario->getEstiloError($nombre);


        $titulocampo = "Entidad ";
        $nombre = "identidad";
        $validacion = "requerido";
        $valor = $this->datosusuario[$nombre];
        $tamano = "100";
        $mensaje = "Entidad a la que pertenece el usuario";
        $mensaje2 = "Entidad del usuario";

        $datosentidad = $this->objgestionusuario->consultaEntidad();
        //$opciones
        $opciones = $datosentidad;
        $opciones[""] = "Seleccionar";
        $arrPanel["campoHtml"][] = $this->objformulario->campoMenu($titulocampo, $nombre, $validacion, $valor, $opciones, $mensaje, $mensaje2, $ayuda);
        $arrPanel["errorHtml"][] = $this->objformulario->getEstiloError($nombre);

        unset($opciones);
        $titulocampo = "Grupo de usuario ";
        $nombre = "idgrupousuario";
        $validacion = "requerido";
        $valor = $this->datosusuario[$nombre];
        $tamano = "100";
        $mensaje = "Grupo del  usuario";
        $mensaje2 = "Grupo  del usuario";
        $datosgrupo = $this->objgestionusuario->consultaGrupoUsuario();

        for ($i = 0; $i < count($datosgrupo); $i++) {
            $nombreopcion = $datosgrupo[$i]["nombregrupousuario"] . "-" . $datosgrupo[$i]["nombretipogrupousuario"];
            $opciones[$datosgrupo[$i]["idgrupousuario"]] = $nombreopcion;
        }
        $opciones[""] = "Seleccionar";
        $arrPanel["campoHtml"][] = $this->objformulario->campoMenu($titulocampo, $nombre, $validacion, $valor, $opciones, $mensaje, $mensaje2, $ayuda);
        $arrPanel["errorHtml"][] = $this->objformulario->getEstiloError($nombre);



        unset($opciones);
        $titulocampo = "Perfil ";
        $nombre = "idperfil";
        $validacion = "requerido";
        $valor = $this->datosusuario[$nombre];
        $tamano = "100";
        $mensaje = "Perfil del  usuario";
        $mensaje2 = "Perfil  del usuario";
        $datosgrupo = $this->objgestionusuario->consultaPerfil();
        for ($i = 0; $i < count($datosgrupo); $i++) {
            $nombreopcion = $datosgrupo[$i]["nombreperfil"];
            $opciones[$datosgrupo[$i]["idperfil"]] = $nombreopcion;
        }
        $opciones[""] = "Seleccionar";
        $arrPanel["campoHtml"][] = $this->objformulario->campoMenu($titulocampo, $nombre, $validacion, $valor, $opciones, $mensaje, $mensaje2, $ayuda);
        $arrPanel["errorHtml"][] = $this->objformulario->getEstiloError($nombre);


        unset($opciones);
        $titulocampo = "Estado ";
        $nombre = "idestado";
        $validacion = "requerido";
        $valor = $this->datosusuario[$nombre];
        $tamano = "100";
        $mensaje = "Estado del  usuario";
        $mensaje2 = "Estado  del usuario";
        $opciones["100"] = "Activo";
        $opciones["200"] = "Inactivo";
        $arrPanel["campoHtml"][] = $this->objformulario->campoMenu($titulocampo, $nombre, $validacion, $valor, $opciones, $mensaje, $mensaje2, $ayuda);
        $arrPanel["errorHtml"][] = $this->objformulario->getEstiloError($nombre);

        return $arrPanel;
    }

    /**
     * @brief Define error en formulario
     * 
     * Define si se encontro
     * error de validación en el formulario
     * 
     * @return Nada
     */
    public function getError() {
        return $this->objformulario->getError();
    }

}
