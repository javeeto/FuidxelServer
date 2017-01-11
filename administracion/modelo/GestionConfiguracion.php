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
 * Descripcion del codigo de GestionConfiguracion
 * 
 * @file GestionConfiguracion.php
 * @author Javier Lopez Martinez
 * @date 25/10/2016
 * @brief Contiene ...
 */
class GestionConfiguracion {
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
     * Arreglo de datos de registo
     *
     * @var Bool
     */
    public $datosconfiguracion;

    /**
     * Arreglo de opciones de registo
     *
     * @var Bool
     */
    private $opcionesescaner;

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

    public function debug() {
        $this->debug = 1;
    }

    /**
     * @brief Define identificador del escaner
     * 
     * Define identificador del escaner
     * 
     * @param[in]  id escaner 
     * @return Nada
     */
    public function setIdConfiguracion($idconfiguracion) {

        $this->datosconfiguracion["idconfiguracion"] = limpiaCadena($idconfiguracion);
    }



    /**
     * @brief Inicializacion de variables usuario
     * 
     * Iniciacion de variables y cadenas de conexion BD
     * 
     * @param[in] objbase recurso de base de datos.
     * @return Nada
     */
    public function consultaEstadoConfiguracion() {
        $tabla = "estado";
        $nombreidtabla = "1";
        $idtabla = "1";
        $condicion = "";
        $operacion = "";
        $resestadoescaner = $this->objbase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, $operacion);
        $i = 0;
        while ($rowestadoescaner = $resestadoescaner->fetchRow()) {
            $datosestado[$i] = $rowestadoescaner;
            $i++;
        }
        return $datosestado;
    }

    /**
     * @brief Consulta todos los registros de escaner 
     * 
     * Consulta y retorna todos los registros de escaneres
     * 
     * @return Arreglo de todos los registros de escaner
     */
    public function consultarRegistrosConfiguracion() {
        $tabla = "configuracion c,estado a";
        $nombreidtabla = "a.idestado";
        $idtabla = "100";
        $condicion =  " and c.idestado=a.idestado";
        if (isset($this->datosconfiguracion["idconfiguracion"]) &&
                trim($this->datosconfiguracion["idconfiguracion"]) != "") {
            $condicion .= " and c.idconfiguracion='" . $this->datosconfiguracion["idconfiguracion"] . "'";
        }
        $operacion = "";
        $resconfiguracion = $this->objbase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, $operacion);
        $i = 0;
        while ($rowconfiguracion = $resconfiguracion->fetchRow()) {
            $datosconfiguracion[$i] = $rowconfiguracion;
            $i++;
        }
        return $datosconfiguracion;
    }

    /**
     * @brief Define array de registro de datos escaner
     * 
     * Array de datos de registro para inserción de datos de escaner 
     * 
     * @return Bool respuesta de ingreso exitoso
     */
    public function setDatosConfiguracion($datosconfiguracion) {
        if (isset($this->datosconfiguracion["idconfiguracion"]) &&
                $this->datosconfiguracion["idconfiguracion"] != '') {
            $idconfiguraciontmp = $this->datosconfiguracion["idconfiguracion"];
        }
        $this->datosconfiguracion = $datosconfiguracion;
        if (isset($idconfiguraciontmp) &&
                $idconfiguraciontmp != '') {
            $this->datosconfiguracion["idconfiguracion"] = $idconfiguraciontmp;
        }
        $i = 1;


        while (isset($datosconfiguracion["nombreopcion_" . $i]) &&
        trim($datosconfiguracion["nombreopcion_" . $i]) != '') {
            $this->opcionesescaner["nombreopcion"][] = $datosconfiguracion["nombreopcion_" . $i];
            $this->opcionesescaner["nombrecortoopcion"][] = $datosconfiguracion["nombrecortoopcion_" . $i];
            $this->opcionesescaner["valoropcion"][] = $datosconfiguracion["valoropcion_" . $i];
            $i++;
            if ($i > 50) {
                break;
            }
        }
    }

    /**
     * @brief Consulta ultimo registro de configuracion
     * 
     * Consulta de ultimo registro de acuerdo a filtro de consultar
     * 
     * @param condicion recurso de base de datos.
     * @return Bool respuesta de ingreso exitoso
     */
    public function consultaUltimoConfiguracion($condicion) {

        $query = "select max(idconfiguracion) maxidconfiguracion from configuracion where " . $condicion;
        if ($this->debug) {
            echo $query;
        }
        $resquery = $this->objbase->query($query);
        $maxconfiguracion = $resquery->fetchRow();
        return $maxconfiguracion["maxidconfiguracion"];
    }

    /**
     * @brief Registro de formulario de datos configuracion 
     * 
     * Registro de datos de configuracion 
     * 
     * @return Bool respuesta de ingreso exitoso
     */
    public function registroDatosConfiguracion() {
        $tabla = "configuracion";
        $fila["nombreconfiguracion"] = limpiaCadena($this->datosconfiguracion["nombreconfiguracion"]);
        $fila["nombrecortoconfiguracion"] = limpiaCadena($this->datosconfiguracion["nombrecortoconfiguracion"]);
        $fila["fechaconfiguracion"] = date("Y-m-d H:i:s");
        $fila["idestado"] = limpiaCadena($this->datosconfiguracion["idestado"]);

        $nuevoconfiguracion = 0;

        if (isset($this->datosconfiguracion["idconfiguracion"]) &&
                $this->datosconfiguracion["idconfiguracion"] != '') {
            $condicion = " idconfiguracion='" . $this->datosconfiguracion["idconfiguracion"] . "'";
        } else {
            $condicion = " nombreconfiguracion='" . $fila["nombreconfiguracion"] . "'" .
                    " and nombrecortoconfiguracion='" . $fila["nombrecortoconfiguracion"] . "'" .
                    " and idestado='" . $fila["idestado"] . "'";
            $nuevoconfiguracion = 1;
        }
        $this->objbase->insertar_fila_bd($tabla, $fila, $this->debug, $condicion);
        if ($nuevoconfiguracion) {
            $this->datosconfiguracion["idconfiguracion"] = $this->consultaUltimoConfiguracion($condicion);
        }
    }

    /**
     * @brief Consulta de opciones de configuracion
     * 
     * Cosulta de datos de opciones de configuracion con
     * respecto a un array de datos predefinido
     * 
     * @return Bool respuesta de ingreso exitoso
     */
    public function consultaOpcionesEscaner() {
        $tabla = "opcionescaner o";
        $nombreidtabla = " o.idconfiguracion";
        $idtabla = $this->datosconfiguracion["idconfiguracion"];


        $operacion = "";
        $resconfiguracion = $this->objbase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, $operacion);
        $i = 0;
        while ($rowconfiguracion = $resconfiguracion->fetchRow()) {
            $datosconfiguracion[$i] = $rowconfiguracion;
            $i++;
        }
        return $datosconfiguracion;
    }

    /**
     * @brief Registro de opciones de escaner
     * 
     * Registro de datos de opciones de escaner con
     * respecto a un array de datos predefinido
     * 
     * @return Bool respuesta de ingreso exitoso
     */
    public function registroOpcionesEscaner() {
        $tabla = "opcionescaner";
        if ($this->debug) {
            echo "opcionesescaner<pre>";
            print_r($this->opcionesescaner);
            echo "</pre>";
        }
        for ($i = 0; $i < count($this->opcionesescaner["nombreopcion"]); $i++) {
            $fila["nombreopcion"] = limpiaCadena($this->opcionesescaner["nombreopcion"][$i]);
            $fila["nombrecortoopcion"] = limpiaCadena($this->opcionesescaner["nombrecortoopcion"][$i]);
            $fila["valoropcion"] = limpiaCadenaUrl($this->opcionesescaner["valoropcion"][$i]);
            $fila["idconfiguracion"] = $this->datosconfiguracion["idconfiguracion"];
            $fila["idescaner"] ="1";
            $fila["idestado"] = "100";

            if (isset($this->datosconfiguracion["idconfiguracion"]) &&
                    $this->datosconfiguracion["idconfiguracion"] != '') {
                if ($this->debug) {
                    echo "opcionesescaner<pre>";
                    print_r($fila);
                    echo "</pre>";
                }
                $condicion = " idconfiguracion='" . $this->datosconfiguracion["idconfiguracion"] . "'" .
                        " and nombreopcion='" . $fila["nombreopcion"] . "'";
                $this->objbase->insertar_fila_bd($tabla, $fila, $this->debug, $condicion);
            }
        }
    }    
   
    

}
