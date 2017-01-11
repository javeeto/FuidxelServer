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
 * Descripcion del codigo de GestionImagen
 * 
 * @file GestionImagen.php
 * @author Javier Lopez Martinez
 * @date 9/11/2016
 * @brief Contiene ...
 */
class GestionImagen {

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
     * Identificador lote de imagen
     *
     * @var Integer
     */
    private $idloteimagen;

    /**
     * Identificador detalle de documento
     *
     * @var Integer
     */
    private $iddetalledocumento;

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

    public function debug() {
        $this->debug = 1;
    }

    /**
     * @brief Define identificador de lote
     * 
     * Define identificador de lote
     * 
     * @return Nada
     */
    function setIdLoteImagen($idloteimagen) {
        $this->idloteimagen = limpiaCadena($idloteimagen);
    }

    /**
     * @brief Define identificador de documento
     * 
     * Define identificador de detalle de documento
     * 
     * @return Nada
     */
    function setIddetalledocumento($iddetalledocumento) {
        $this->iddetalledocumento = $iddetalledocumento;
    }

    /**
     * @brief Consulta acta inicio
     * 
     * consulta de control de acta
     * 
     * @return Bool respuesta de ingreso exitoso
     */
    public function consultaImagen() {
        $tabla = "imagen i,loteimagen l,tipoimagen t,estadoloteimagen el";
        $nombreidtabla = "i.idestado";
        $idtabla = "100";
        $condicion = " and i.idloteimagen=l.idloteimagen " .
                " and i.idtipoimagen=t.idtipoimagen " .
                " and el.idestadoloteimagen=l.idestadoloteimagen ";

        if (isset($this->idloteimagen) &&
                trim($this->idloteimagen) != '') {
            $condicion .= " and i.idloteimagen='" . $this->idloteimagen . "'";
        }

        if (isset($this->iddetalledocumento) &&
                trim($this->iddetalledocumento) != '') {
            $condicion .= " and i.iddetalledocumento='" . $this->iddetalledocumento . "'";
        }

        $condicion .= " order by i.idimagen ";
        $resdatosimagen = $this->objbase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", $this->debug);
        while ($rowdatosimagen = $resdatosimagen->fetchRow()) {
            $datosimagen[] = $rowdatosimagen;
        }

        return $datosimagen;
    }

}
