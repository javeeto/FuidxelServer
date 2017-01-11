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
 * Descripcion del codigo de GestionLoteImagen
 * 
 * @file GestionLoteImagen.php
 * @author Javier Lopez Martinez
 * @date 28/09/2016
 * @brief Contiene ...
 */
class GestionLoteImagen {

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
     * Datos de repositorio activo
     *
     * @var Array
     */
    private $datosrepoactivo;

    /**
     * Datos de usuario
     *
     * @var Array
     */
    private $datosusuario;

    /**
     * Datos de grupo usuario
     *
     * @var Array
     */
    private $datosgrupousuario;

    /**
     * Identificador unico de usuario
     *
     * @var Array
     */
    private $idusuario;

    /**
     * Identificador lote de imagen
     *
     * @var Integer
     */
    private $idloteimagen;

    /**
     * Identificador imagen
     *
     * @var Integer
     */
    private $idimagen;
    
    /**
     * Identificador de repositorio
     *
     * @var Integer
     */
    private $idrepositorio;    

    /**
     * @brief Inicializacion de objeto de conexion BDx
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
     * @brief Obtiene datos de repositorio
     * 
     * Obtiene datos de repositorio
     * 
     * @return Array datos repositorio
     */
    function getDatosRepoActivo() {
        return $this->datosrepoactivo;
    }

    /**
     * @brief Define identificador de lote
     * 
     * Define identificador de lote
     * 
     * @return Nada
     */
    function setIdLoteImagen($idloteimagen) {
        $this->idloteimagen = $idloteimagen;
    }
    
    /**
     * @brief Define identificador de repositorio
     * 
     * Define identificador de repositorio
     * 
     * @return Nada
     */    
    function setIdRepositorio($idrepositorio) {
        $this->idrepositorio = $idrepositorio;
    }

        /**
     * @brief Define identificador de imagen
     * 
     * Define identificador de imagen
     * 
     * @return Nada
     */
    function setIdImagen($idimagen) {
        $this->idimagen = $idimagen;
    }

    /**
     * @brief Creacion de lote
     * 
     * Creacion de registro de lote de imagenes
     * 
     * @return Nada
     */
    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    /**
     * @brief Define datos de usuario
     * 
     * Define arreglo de datos de usuario
     * 
     * @return Nada
     */
    public function setDatosUsuario($datosusuario) {
        $this->datosusuario = $datosusuario;
    }

    /**
     * @brief Define Datos de grupo de usuario
     * 
     * Define arreglo datos de grupo de usuario
     * 
     * @return Nada
     */
    public function setDatosGrupoUsuario($datosgrupousuario) {
        $this->datosgrupousuario = $datosgrupousuario;
    }

    /**
     * @brief Consulta de repositorio activo
     * 
     * Consulta de repositorio activo del tipo indicado
     * 
     * @param[in] tiporepositorio tipo de respositorio .
     * @return Nada
     */
    public function consultaRepoActivo($tiporepositorio) {

        $tabla = "repositorio";
        $nombreidtabla = "idestado";
        $idtabla = "100";
        $condicion = " and idtiporepositorio='" . $tiporepositorio . "'";
        if (isset($this->idrepositorio) &&
                trim($this->idrepositorio) != '') {
            $condicion .= " and idrepositorio='" . $this->idrepositorio . "'";
        } else {
            $condicion .= " and '" . date("Y-m-d H:i:s") . "' between fechainiciorepositorio and fechafinalrepositorio " ;
        }

        $this->datosrepoactivo = $this->objbase->recuperar_datos_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", $this->debug);
    }

    /**
     * @brief Consulta de datos de lote
     * 
     * Consulta datos de lote 
     * 
     * @return Array arreglo de datos de lote
     */
    public function consultaDatosLote() {

        $tabla = "loteimagen l";
        $nombreidtabla = "l.idestado";
        $idtabla = "100";

        if (isset($this->idloteimagen) &&
                trim($this->idloteimagen) != '') {
            $condicion = " and l.idloteimagen='" . $this->idloteimagen . "'";
        }
        $datoslote = $this->objbase->recuperar_datos_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", $this->debug);
        return $datoslote;
    }

    /**
     * @brief Creacion de lote
     * 
     * Creacion de registro de lote de imagenes
     * 
     * @return Nada
     */
    public function nuevoLote() {

        $tabla = "loteimagen";
        $fila["rutaloteimagen"] = "";
        $fila["fechainicioloteimagen"] = date("Y-m-d H:i:s");
        $fila["fechafinalloteimagen"] = date("Y-m-d H:i:s");
        $fila["idusuario"] = $this->idusuario;
        $fila["idrepositorio"] = $this->datosrepoactivo["idrepositorio"];
        $fila["idestado"] = "100";

        $condicion = " fechainicioloteimagen= '" . $fila["fechainicioloteimagen"] . "'" .
                " and idusuario='" . $fila["idusuario"] . "'";

        $this->objbase->insertar_fila_bd($tabla, $fila, $this->debug, $condicion);
        $this->idloteimagen = $this->consultaUltimoLote($condicion);
        return $this->idloteimagen;
    }

    /**
     * @brief Actualiza datos de lote
     * 
     * Creacion de registro de lote de imagenes
     * 
     * @return Nada
     */
    public function actualizaLote($filalote) {

        $tabla = "loteimagen";

        $condicion = " idloteimagen= '" . $this->idloteimagen . "'";

        $this->objbase->insertar_fila_bd($tabla, $filalote, $this->debug, $condicion);
        //$this->idloteimagen = $this->consultaUltimoLote($condicion);
        return $this->idloteimagen;
    }

    /**
     * @brief Creacion de grupo lote imagen
     * 
     * Creacion de registro de lote de imagenes
     * 
     * @return Nada
     */
    public function nuevoGrupoLoteImagen() {

        $tabla = "grupoloteimagen";
        $fila["idgrupousuario"] = $this->datosusuario["idgrupousuario"];
        $fila["idloteimagen"] = $this->idloteimagen;
        $fila["fechainiciogrupolote"] = date("Y-m-d H:i:s");
        $fila["fechafinalgrupolote"] = date("Y-m-d H:i:s");
        $fila["idusuario"] = $this->idusuario;
        $fila["idestado"] = "100";

        $condicion = " idgrupousuario= '" . $fila["idgrupousuario"] . "'" .
                " and idusuario='" . $fila["idusuario"] . "'" .
                " and idloteimagen='" . $fila["idloteimagen"] . "'";

        $this->objbase->insertar_fila_bd($tabla, $fila, $this->debug, $condicion);
        // $idloteimagen = $this->consultaUltimoLote($condicion);
        // return $idloteimagen;
    }

    /**
     * @brief Consulta de ult
     * 
     * Creacion de registro de lote de imagenes
     * 
     * @return Nada
     */
    public function consultaUltimoLote($condicion) {


        $query = "select max(idloteimagen) maxidloteimagen from loteimagen where " . $condicion;
        if ($this->debug) {
            echo $query;
        }

        $resloteimagen = $this->objbase->query($query);
        $datosloteimagen = $resloteimagen->fetchRow();
        return $datosloteimagen["maxidloteimagen"];
    }

    /**
     * @brief Consulta lista de lotes relacionado al usuario
     * 
     * Consulta lista de lotes relacionado al usuario
     * 
     * @return Nada
     */
    public function consultaLotesEscaneo() {

        $tablas = "loteimagen l, grupoloteimagen g, grupousuario gu," .
                " usuario u,persona p,escaner e,estadoloteimagen et";
        $nombreidtabla = "1";
        $idtabla = 1;
        $condicion = " and l.idloteimagen=g.idloteimagen " .
                " and g.idgrupousuario=u.idgrupousuario " .
                " and p.idpersona=u.idpersona " .
                " and gu.idgrupousuario=u.idgrupousuario" .
                " and et.idestadoloteimagen=l.idestadoloteimagen" .
                " and gu.idescaner=e.idescaner ";

        if ($this->datosgrupousuario["idtipogrupousuario"] == "2") {
            $condicion .= "";
        } else {
            if (isset($this->datosgrupousuario["idgrupousuario"]) &&
                    trim($this->datosgrupousuario["idgrupousuario"]) != '') {
                $condicion .= " and g.idgrupousuario='" . $this->datosgrupousuario["idgrupousuario"] . "'";
            }
        }

        if (isset($this->idloteimagen) &&
                trim($this->idloteimagen) != '') {
            $condicion .= " and l.idloteimagen='" . $this->idloteimagen . "' ";
        }

        $resdatosgrupo = $this->objbase->recuperar_resultado_tabla($tablas, $nombreidtabla, $idtabla, $condicion, "", $this->debug);
        while ($rowgrupo = $resdatosgrupo->fetchRow()) {
            $datosgrupo[] = $rowgrupo;
        }

        return $datosgrupo;
    }

    /**
     * @brief Registro de  nueva imagen
     * 
     * Registro a partir de arraglo de imagen
     * 
     * @return Nada
     */
    public function registroImagen($filaimagen) {
        $tabla = "imagen";

        if (isset($this->idimagen) &&
                trim($this->idimagen) != '') {
            $condicion = " idimagen='" . $this->idimagen . "'";
        } else {

            $condicion = " rutaimagen= '" . $filaimagen["rutaimagen"] . "'" .
                    " and idloteimagen='" . $filaimagen["idloteimagen"] . "'" .
                    " and idtipoimagen='" . $filaimagen["idtipoimagen"] . "'";
        }


        $this->objbase->insertar_fila_bd($tabla, $filaimagen, $this->debug, $condicion);
    }

}
