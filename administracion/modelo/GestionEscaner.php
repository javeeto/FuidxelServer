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
 * Descripcion del codigo de GestionEscaner
 * 
 * @file GestionEscaner.php
 * @author Javier Lopez Martinez
 * @date 21/09/2016
 * @brief Contiene ...
 */
class GestionEscaner {

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
    public $datosescaner;

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
    public function setIdEscaner($idescaner) {

        $this->datosescaner["idescaner"] = limpiaCadena($idescaner);
    }

    /**
     * @brief Inicializacion de variables usuario
     * 
     * Iniciacion de variables y cadenas de conexion BD
     * 
     * @param[in] objbase recurso de base de datos.
     * @return Nada
     */
    public function consultaTipoEscaner() {
        $tabla = "tipoescaner";
        $nombreidtabla = "1";
        $idtabla = "1";
        $condicion = " and idestado='100' ";
        $operacion = "";
        $restipoescaner = $this->objbase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, $operacion);
        $i = 0;
        while ($rowtipoescaner = $restipoescaner->fetchRow()) {
            $datosescaner[$i] = $rowtipoescaner;
            $i++;
        }
        return $datosescaner;
    }

    /**
     * @brief Inicializacion de variables usuario
     * 
     * Iniciacion de variables y cadenas de conexion BD
     * 
     * @param[in] objbase recurso de base de datos.
     * @return Nada
     */
    public function consultaEstadoEscaner() {
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
    public function consultarRegistrosEscaner() {
        $tabla = "escaner e,tipoescaner t,estado a";
        $nombreidtabla = "1";
        $idtabla = "1";
        $condicion = " and e.idtipoescaner=t.idtipoescaner" .
                " and e.idestado=a.idestado";
        if (isset($this->datosescaner["idescaner"]) &&
                trim($this->datosescaner["idescaner"]) != "") {
            $condicion .= " and e.idescaner='" . $this->datosescaner["idescaner"] . "'";
        }
        $operacion = "";
        $resescaner = $this->objbase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, $operacion);
        $i = 0;
        while ($rowescaner = $resescaner->fetchRow()) {
            $datosescaner[$i] = $rowescaner;
            $i++;
        }
        return $datosescaner;
    }

    /**
     * @brief Define array de registro de datos escaner
     * 
     * Array de datos de registro para inserción de datos de escaner 
     * 
     * @return Bool respuesta de ingreso exitoso
     */
    public function setDatosEscaner($datosescaner) {
        if (isset($this->datosescaner["idescaner"]) &&
                $this->datosescaner["idescaner"] != '') {
            $idescanertmp = $this->datosescaner["idescaner"];
        }
        $this->datosescaner = $datosescaner;
        if (isset($idescanertmp) &&
                $idescanertmp != '') {
            $this->datosescaner["idescaner"] = $idescanertmp;
        }
        $i = 1;


        while (isset($datosescaner["nombreopcion_" . $i]) &&
        trim($datosescaner["nombreopcion_" . $i]) != '') {
            $this->opcionesescaner["nombreopcion"][] = $datosescaner["nombreopcion_" . $i];
            $this->opcionesescaner["nombrecortoopcion"][] = $datosescaner["nombrecortoopcion_" . $i];
            $this->opcionesescaner["valoropcion"][] = $datosescaner["valoropcion_" . $i];
            $i++;
            if ($i > 50) {
                break;
            }
        }
    }

    /**
     * @brief Consulta ultimo registro de escaner
     * 
     * Consulta de ultimo registro de acuerdo a filtro de consultar
     * 
     * @param condicion recurso de base de datos.
     * @return Bool respuesta de ingreso exitoso
     */
    public function consultaUltimoEscaner($condicion) {

        $query = "select max(idescaner) maxidescaner from escaner where " . $condicion;
        if ($this->debug) {
            echo $query;
        }
        $resquery = $this->objbase->query($query);
        $maxescaner = $resquery->fetchRow();
        return $maxescaner["maxidescaner"];
    }

    /**
     * @brief Registro de formulario de datos escaner 
     * 
     * Registro de datos de escaner 
     * 
     * @return Bool respuesta de ingreso exitoso
     */
    public function registroDatosEscaner() {
        $tabla = "escaner";
        $fila["nombreescaner"] = limpiaCadena($this->datosescaner["nombreescaner"]);
        $fila["dispositivoescaner"] = limpiaCadena($this->datosescaner["dispositivoescaner"]);
        $fila["ipescaner"] = limpiaCadena($this->datosescaner["ipescaner"]);
        $fila["sitioescaner"] = limpiaCadena($this->datosescaner["sitioescaner"]);
        $fila["idtipoescaner"] = limpiaCadena($this->datosescaner["idtipoescaner"]);
        $fila["directorioescaner"] = limpiaCadenaUrl($this->datosescaner["directorioescaner"]);
        $fila["idestado"] = limpiaCadena($this->datosescaner["idestado"]);

        $nuevoescaner = 0;

        if (isset($this->datosescaner["idescaner"]) &&
                $this->datosescaner["idescaner"] != '') {
            $condicion = " idescaner='" . $this->datosescaner["idescaner"] . "'";
        } else {
            $condicion = " nombreescaner='" . $fila["nombreescaner"] . "'" .
                    " and dispositivoescaner='" . $fila["dispositivoescaner"] . "'" .
                    " and ipescaner='" . $fila["ipescaner"] . "'";
            $nuevoescaner = 1;
        }
        $this->objbase->insertar_fila_bd($tabla, $fila, $this->debug, $condicion);
        if ($nuevoescaner) {
            $this->datosescaner["idescaner"] = $this->consultaUltimoEscaner($condicion);
        }
    }

    /**
     * @brief Consulta de opciones de escaner
     * 
     * Cosulta de datos de opciones de escaner con
     * respecto a un array de datos predefinido
     * 
     * @return Bool respuesta de ingreso exitoso
     */
    public function consultaOpcionesEscaner() {
        $tabla = "opcionescaner o";
        $nombreidtabla = " o.idescaner";
        $idtabla = $this->datosescaner["idescaner"];


        $operacion = "";
        $resescaner = $this->objbase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, $operacion);
        $i = 0;
        while ($rowescaner = $resescaner->fetchRow()) {
            $datosescaner[$i] = $rowescaner;
            $i++;
        }
        return $datosescaner;
    }

    /**
     * @brief Consulta en BD lista de configuraciones asignadas
     * 
     * Consulta en base de datos datos configuraciones
     * relacionadas al escaner
     * 
     * @return datostipo Arreglo con datos de configuracion
     */
    public function consultaConfiguracionEscaner() {

        $tablas = "configuraescaner";
        $nombreidtabla = "idestado";
        $idtabla = "100";
        $condicion = " and idescaner='" . $this->datosescaner["idescaner"] . "'".
                " order by principalconfiguraescaner desc,idconfiguraescaner asc";

        $resdatostipogrupo = $this->objbase->recuperar_resultado_tabla($tablas, $nombreidtabla, $idtabla, $condicion, "", $this->debug);
        while ($rowtipo = $resdatostipogrupo->fetchRow()) {
            $datostipo[] = $rowtipo;
        }

        return $datostipo;
    }

    /**
     * @brief Registraen BD datos generales de configuracion
     * 
     * Registra en base de datos datos  de configuracion
     * 
     * @return idgrupousuario Grupo Usuario registrado
     */
    public function registrarDatosConfiguracion() {


        $tabla = "configuraescaner";
        $i = 0;
        $this->desactivaConfiguracion();
        while ($this->datosescaner["idconfiguracion" . $i] &&
        trim($this->datosescaner["idconfiguracion" . $i]) != '') {
            $fila["idescaner"] = $this->datosescaner["idescaner"];
            $fila["idconfiguracion"] = limpiaCadena($this->datosescaner["idconfiguracion" . $i]);
            $fila["idestado"] = limpiaCadena($this->datosescaner["idestado"]);
            $fila["fechaconfiguraescaner"] = date("Y-m-d H:i:s");
            if ($i == 0) {
                $fila["principalconfiguraescaner"] = "1";
            } else {
                $fila["principalconfiguraescaner"] = "0";
            }


            if (isset($this->datosescaner["idescaner"]) &&
                    $this->datosescaner["idescaner"] != '') {
                $condicion = " idescaner='" . $fila["idescaner"] . "'" .
                        " and idconfiguracion='" . $fila["idconfiguracion"] . "'";
            }

            $this->objbase->insertar_fila_bd($tabla, $fila, $this->debug, $condicion);
            /* if ($nuevousuario) {
              $this->idgrupousuario = $this->consultaUltimoGrupoUsuario($condicion);
              } */
            $i++;
        }
    }

    /**
     * @brief Actualiza registros de configuracion escaner
     * 
     * Actualiza configuracione escaner a estado desactivado 200
     * del idescaner en sesion
     * 
     * @return idgrupousuario Grupo Usuario registrado
     */
    private function desactivaConfiguracion() {
        if (isset($this->datosescaner["idescaner"]) &&
                trim($this->datosescaner["idescaner"]) != '') {
            $tabla = "configuraescaner";
            $fila["idestado"] = "200";
            $nombreidtabla = "idescaner";
            $idtabla = $this->datosescaner["idescaner"];
            $condicion = "";
            $this->objbase->actualizar_fila_bd($tabla, $fila, $nombreidtabla, $idtabla, $condicion, $this->debug);
        }
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
            $fila["idescaner"] = $this->datosescaner["idescaner"];
            $fila["idestado"] = "100";

            if (isset($this->datosescaner["idescaner"]) &&
                    $this->datosescaner["idescaner"] != '') {
                if ($this->debug) {
                    echo "opcionesescaner<pre>";
                    print_r($fila);
                    echo "</pre>";
                }
                $condicion = " idescaner='" . $this->datosescaner["idescaner"] . "'" .
                        " and nombreopcion='" . $fila["nombreopcion"] . "'";
                $this->objbase->insertar_fila_bd($tabla, $fila, $this->debug, $condicion);
            }
        }
    }

}
