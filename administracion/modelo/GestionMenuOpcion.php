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
 * Descripcion del codigo de GestionMenuOpcion
 * 
 * @file GestionMenuOpcion.php
 * @author Javier Lopez Martinez
 * @date 16/09/2016
 * @brief Contiene ...
 */
class GestionMenuOpcion {

    /**
     * Arreglo de datos de usuario
     *
     * @var Array
     */
    private $datosusuario;

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
     * @brief Inicializacion de variables usuario
     * 
     * Iniciacion de variables y cadenas de conexion BD
     * 
     * @param[in] datosusuario nombre de usuario de logueo.
     * @param[in] objbase recurso de base de datos.
     * @return Nada
     */
    public function __construct($datosusuario, $objbase) {
        $this->datosusuario = $datosusuario;
        $this->objbase = $objbase;
        $this->debug = 0;
    }

    public function debug() {
        $this->debug = 1;
    }

    /**
     * @brief Consulta en base de datos  opciones de menu
     * 
     * Consulta en base de datos menu de opciones
     * ejecuta funcion recursiva por cada opcion encabezado encontrada
     * 
     * @param[in] datosusuario nombre de usuario de logueo.
     * @param[in] objbase recurso de base de datos.
     * @return opciones arreglo anidado de opciones 
     */
    public function consultaMenuOpcion($opcionespadre = array()) {

        $tablas = " perfilmenuopcion p, menuopcion m, tipomenuopcion t";
        $condicion = " and m.idmenuopcion=p.idmenuopcion " .
                " and t.idtipomenuopcion=m.idtipomenuopcion " .
                " and m.idestado='100'" .
                " and p.idestado='100'" .
                " and t.idestado='100'" .
                " and m.idiomamenuopcion='" . IDIOMAENTORNO . "'";

        if (isset($opcionespadre["idmenuopcion"])) {
            $condicion .= " and m.idmenuopcionpadre='" . $opcionespadre["idmenuopcion"] . "' ";
        } else {
            $condicion .= " and t.nombretipomenuopcion='encabezado' ";
        }
        $condicion .= " order by m.ordenmenuopcion";

        $opcionesfetch = $this->objbase->recuperar_resultado_tabla($tablas, "p.idperfil", $this->datosusuario["idperfil"], $condicion, "", $this->debug);
        $j = 0;
        while ($rowopciones = $opcionesfetch->fetchRow()) {
            $opciones[$j] = $rowopciones;
            $j++;
        }

        for ($i = 0; $i < count($opciones); $i++) {
            $opciones[$i]["hijos"] = $this->consultaMenuOpcion($opciones[$i]);
            if(!count($opciones[$i]["hijos"])>0){
                unset($opciones[$i]["hijos"]);
            }
        }


        return $opciones;
    }

}
