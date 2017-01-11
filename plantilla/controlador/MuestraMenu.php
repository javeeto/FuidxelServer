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
 * Descripcion del codigo de MuestraMenu
 * 
 * @file muestraMenu.php
 * @author Javier Lopez Martinez
 * @date 16/09/2016
 * @brief Contiene ...
 */
class MuestraMenu {

    /**
     * Arreglo de datos de opcion
     *
     * @var Array
     */
    private $datosopciones;

    /**
     * @brief Inicializacion de variables de opciones
     * 
     * Iniciacion de variables y cadenas 
     * 
     * @param[in] datosopciones arreglo anidado de opciones
     * @param[in] objbase recurso de base de datos.
     * @return Nada
     */
    public function __construct($datosopciones) {
        $this->datosopciones = $datosopciones;
        $this->debug = 0;
    }

    /**
     * @brief Inicializacion de variables de opciones
     * 
     * Iniciacion de variables y cadenas 
     * 
     * @param[in] datosopciones arreglo anidado de opciones
     * @param[in] objbase recurso de base de datos.
     * @return Nada
     */
    public function recursivoMenuNav($opcionpadre = array()) {
        $arrayopciones = array();
        $cadenamenuopcion = "";
        if (isset($opcionpadre[0]["nombremenuopcion"]) &&
                trim($opcionpadre[0]["nombremenuopcion"]) != '') {
            $arrayopciones = $opcionpadre;
        } else {
            $arrayopciones = $this->datosopciones;
            $cadenamenuopcion = "<li class='active'><a href='../../entrada/vista/menuprincipal.php'>Home</a></li>\n";
        }

        for ($i = 0; $i < count($arrayopciones); $i++) {
            if (count($arrayopciones[$i]["hijos"]) > 0) {

                $cadenamenuopcion.="<li class='dropdown'>\n
                            <a class='dropdown-toggle' data-toggle='dropdown' href='#'>" . $arrayopciones[$i]["nombrecortomenuopcion"] . "<span class='caret'></span></a>\n
                            <ul class='dropdown-menu'>\n";
                $cadenamenuopcion.=$this->recursivoMenuNav($arrayopciones[$i]["hijos"]);
                $cadenamenuopcion.="</ul></li>\n";
            } else {
                $cadenamenuopcion.=" <li><a href='" . $arrayopciones[$i]["rutamenuopcion"] . "'>" . $arrayopciones[$i]["nombrecortomenuopcion"] . "</a></li>\n";
            }
        }
        return $cadenamenuopcion;
    }

}
