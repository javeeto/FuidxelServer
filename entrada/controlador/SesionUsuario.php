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
 * Descripcion del codigo de ControlMenu
 * 
 * @file ControlMenu.php
 * @author Javier Lopez Martinez
 * @date 15/09/2016
 * @brief Contiene ...
 */
class SesionUsuario {

    /**
     *  Objeto de conexion base de datos
     *
     * @var BaseGeneral
     */
    private $objbase;

    /**
     * @brief Inicializacion de variables de conexion
     * 
     * Iniciacion de variables y cadenas de conexion BD
     * 
     * @return Nada
     */
    public function __construct($objbase) {
        
        $this->objbase = $objbase;
        
    }

    /**
     * @brief Inicializacion de variables de conexion
     * 
     * Iniciacion de variables y cadenas de conexion BD
     * @param[in] usuario nombre de usuario de logueo.
     * @return Nada
     */
    public function datosSesionUsuario($usuario) {
        
        $objusuario = new GestionUsuario($usuario, $this->objbase);
        //$objusuario->debug();
        $datosusuario=$objusuario->consultaDatosUsuario();
        return $datosusuario;
    }

}
