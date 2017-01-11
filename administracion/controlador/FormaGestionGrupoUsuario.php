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
 * Descripcion del codigo de FormaGestionGrupoUsuario
 * 
 * @file FormaGestionGrupoUsuario.php
 * @author Javier Lopez Martinez
 * @date 10/10/2016
 * @brief Contiene ...
 */
class FormaGestionGrupoUsuario {
    //put your code here

    /**
     *  Objeto de formulario
     *
     * @var FormularioBase
     */
    private $objformulario;

    /**
     *  Arreglo de datos de usuario
     *
     * @var Array
     */
    private $datosgrupousuario;

    /**
     *  Objeto de gestion de grupo
     *
     * @var GestionGrupoUsuario
     */
    private $objgestiongrupo;

    /**
     *  Objeto de escaner
     *
     * @var GestionEscaner
     */
    private $objescaner;

    /**
     * @brief Inicializacion de datos de grupousuario
     * 
     * Iniciacion de variables de grupousuario
     * 
     * @param[in] objbase recurso de base de datos.
     * @param[in] objformulario recurso de formulario.
     * @param[in] objgestionusuario gestión de usuario.
     * @return Nada
     */
    public function __construct($objformulario, $objbase) {

        $this->objformulario = $objformulario;
        $this->objgestiongrupo = new GestionGrupoUsuario($objbase);
        $this->datosgrupousuario = array();
    }

    /**
     * @brief Define array de datos de grupo de usuario
     * 
     * Iniciacion de variables de grupo usuario
     * 
     * @param Array $datosusuario Datos de usuario
     * @return Nada
     */
    public function setDatosGrupoUsuario($datosgrupousuario) {
        $this->datosgrupousuario = $datosgrupousuario;
    }

    /**
     * @brief Define array de datos de escaner
     * 
     * Iniciacion de variables de escaner
     * 
     * @param GestionEscaner $objescaner Objeto escaner
     * @return Nada
     */
    public function setEscaner($objescaner) {
        $this->objescaner = $objescaner;
    }

    /**
     * @brief Define array de campos de forma
     * 
     * Formulario del panel de campos grupousuario
     * arma entradas html con parametros
     * formulario
     * 
     * @return Arreglo de campos html
     */
    public function panelGeneral() {
        $titulocampo = "Nombre Grupo ";
        $nombre = "nombregrupousuario";
        $validacion = "alfanumerico";
        $valor = $this->datosgrupousuario[$nombre];
        $tamano = "100";
        $mensaje = "Nombres del grupo";
        $mensaje2 = "Nombres del grupo";
        $arrPanel["campoHtml"][] = $this->objformulario->campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2);
        $arrPanel["errorHtml"][] = $this->objformulario->getEstiloError($nombre);

        unset($opciones);
        $titulocampo = "Tipo de grupo";
        $nombre = "idtipogrupousuario";
        $validacion = "requerido";
        $valor = $this->datosgrupousuario[$nombre];
        $mensaje = "Seleccionar tipo de grupo usuario";
        $mensaje2 = "Tipo de grupo usuario";
        $datosgrupo = $this->objgestiongrupo->consultaTipoGrupoUsuario();

        for ($i = 0; $i < count($datosgrupo); $i++) {
            $nombreopcion = $datosgrupo[$i]["nombretipogrupousuario"];
            $opciones[$datosgrupo[$i]["idtipogrupousuario"]] = $nombreopcion;
        }
        $opciones[""] = "Seleccionar";
        $arrPanel["campoHtml"][] = $this->objformulario->campoMenu($titulocampo, $nombre, $validacion, $valor, $opciones, $mensaje, $mensaje2, $ayuda);
        $arrPanel["errorHtml"][] = $this->objformulario->getEstiloError($nombre);

        unset($opciones);
        $titulocampo = "Escaner asignado";
        $nombre = "idescaner";
        $validacion = "requerido";
        $valor = $this->datosgrupousuario[$nombre];
        $mensaje = "Seleccionar escaner";
        $mensaje2 = "Escaner de grupo usuario";
        $datosescaner = $this->objescaner->consultarRegistrosEscaner();

        for ($i = 0; $i < count($datosescaner); $i++) {
            $nombreopcion = $datosescaner[$i]["idescaner"] . "-" . $datosescaner[$i]["nombreescaner"];
            $opciones[$datosescaner[$i]["idescaner"]] = $nombreopcion;
        }
        $opciones[""] = "Seleccionar";
        $arrPanel["campoHtml"][] = $this->objformulario->campoMenu($titulocampo, $nombre, $validacion, $valor, $opciones, $mensaje, $mensaje2, $ayuda);
        $arrPanel["errorHtml"][] = $this->objformulario->getEstiloError($nombre);


        unset($opciones);
        $titulocampo = "Estado ";
        $nombre = "idestado";
        $validacion = "requerido";
        $valor = $this->datosgrupousuario[$nombre];
        $tamano = "100";
        $mensaje = "Estado del  grupo";
        $mensaje2 = "Estado  del grupo";
        $opciones["100"] = "Activo";
        $opciones["200"] = "Inactivo";
        $arrPanel["campoHtml"][] = $this->objformulario->campoMenu($titulocampo, $nombre, $validacion, $valor, $opciones, $mensaje, $mensaje2, $ayuda);
        $arrPanel["errorHtml"][] = $this->objformulario->getEstiloError($nombre);

        return $arrPanel;
    }

    /**
     * @brief Define array de campos de forma
     * 
     * Formulario del panel de asignacion
     * de grupo de usuario dependientes 
     * arma entradas html con parametros
     * formulario
     * 
     * @return Arreglo de campos html
     */
    public function panelAsignacion() {

        unset($opciones);
        // $this->objgestiongrupo->debug();
        $titulocampo = "Asignar Grupo";
        $nombre = "idgrupousuariohijo";
        $validacion = "";
        $valor = $this->datosgrupousuario[$nombre."0"];
        $mensaje = "Seleccionar grupo asignado";
        $mensaje2 = "grupo de usuario";
        //$this->objgestiongrupo->debug();
        $datosgrupo = $this->objgestiongrupo->consultaGrupoUsuario();


        for ($i = 0; $i < count($datosgrupo); $i++) {
            $nombreopcion = $datosgrupo[$i]["idgrupousuario"] . "-" . $datosgrupo[$i]["nombregrupousuario"] . "-" . $datosgrupo[$i]["nombretipogrupousuario"];
            $opciones[$datosgrupo[$i]["idgrupousuario"]] = $nombreopcion;
        }
        $opciones[""] = "Seleccionar";

        $arrPanel["campoHtml"][] = $this->objformulario->campoMenu($titulocampo, $nombre."0", $validacion, $valor, $opciones, $mensaje, $mensaje2, $ayuda);
        $arrPanel["errorHtml"][] = $this->objformulario->getEstiloError($nombre."0");

        $i = 1;
        while (isset($this->datosgrupousuario[$nombre . $i]) &&
        trim($this->datosgrupousuario[$nombre . $i]) != '') {
            //unset($opciones);
            if (isset($this->datosgrupousuario[$nombre]))
                unset($opciones[$this->datosgrupousuario[$nombre]]);
            $titulocampo = "Asignar Grupo " . $i;
            $nombre = $nombre . $i;
            $validacion = "";
            $valor = $this->datosgrupousuario[$nombre];
            $mensaje = "Seleccionar escaner";
            $mensaje2 = "Asignar grupo usuario";

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
        $titulocampo = "Asignar Grupo " . $i;
        $nombre = $nombre . $i;
        $validacion = "";
        $valor = $this->datosgrupousuario[$nombre];
        $mensaje = "Seleccionar escaner";
        $mensaje2 = "Asignar grupo usuario";
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
