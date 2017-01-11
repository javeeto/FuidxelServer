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
 * Descripcion del codigo de GestionMetadato
 * 
 * @file GestionMetadato.php
 * @author Javier Lopez Martinez
 * @date 13/11/2016
 * @brief Contiene ...
 */
class GestionMetadato {

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
     * Identificador de formulario metadato
     *
     * @var Integer
     */
    private $idformulario;

    /**
     * Arreglo de datos de grupo de metadatos
     *
     * @var Array
     */
    private $datosgrupometadato;

    /**
     * Arreglo de datos de metadatos
     *
     * @var Array
     */
    private $datosmetadato;

    /**
     * Arreglo de datos de campo
     *
     * @var Array
     */
    private $datoscampo;

    /**
     * Arreglo de datos de registro de campo
     *
     * @var Array
     */
    private $datosregistro;

    /**
     * Identificador de usuario
     *
     * @var Integer
     */
    private $idusuario;

    /**
     * Identificador de registro de campo
     *
     * @var Integer
     */
    private $idregistrometadato;

    /**
     * Identificador de detalledocumento
     *
     * @var Integer
     */
    private $iddetalledocumento;
    
   /**
     * Nombre de campo metadato
     *
     * @var String
     */
    private $campometadato;

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
        $this->idregistrometadato = "";
    }

    /**
     * @brief Impresion debug
     * 
     * Activa Impresion de seguimiento debug 
     * 
     * @return Nada
     */
    public function debug() {
        $this->debug = 1;
    }

    /**
     * @brief Define identificador formulario
     * 
     * Define identificador de formulario metadato
     * 
     * @param Integer $idformulario Identificador formulario
     * @return Nada
     */
    function setIdFormulario($idformulario) {
        $this->idformulario = $idformulario;
    }

    /**
     * @brief Obtiene arreglo de grupo metadato
     * 
     * Retorna arreglo de datos de grupo metadato
     * labels para grupo de datos en formulario
     * 
     * @return Array Arreglo de datos de grupo
     */
    function getDatosGrupoMetadato() {
        return $this->datosgrupometadato;
    }

    /**
     * @brief Obtiene arreglo de metadato
     * 
     * Retorna arreglo de datos de metadato
     * campos para  formulario
     * 
     * @return Array Arreglo de datos de metadatos
     */
    function getDatosMetadato() {
        return $this->datosmetadato;
    }

    /**
     * @brief Obtiene arreglo de campo metadato
     * 
     * Retorna arreglo de datos de campo metadato
     * campos para  formulario
     * 
     * @return Array Arreglo de datos de campo metadatos
     */
    function getDatosCampo() {
        return $this->datoscampo;
    }

    /**
     * @brief Define arreglo de registro de campo
     * 
     * Define arreglo de registro de campo
     * 
     * @param Array $datosregistro Arreglo con registro
     * @return Nada
     */    
    function setCampoMetadato($campometadato) {
        $this->campometadato = $campometadato;
    }

    
    /**
     * @brief Define arreglo de registro de campo
     * 
     * Define arreglo de registro de campo
     * 
     * @param Array $datosregistro Arreglo con registro
     * @return Nada
     */
    function setDatosRegistro($datosregistro) {
        $this->datosregistro = $datosregistro;
    }

    /**
     * @brief Define identificador de usuario
     * 
     * Define identificador de usuario que realiza registro
     * 
     * @param Integer $idusuario id usuario
     * @return Nada
     */
    function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    /**
     * @brief Define identificador de registro de campo
     * 
     * identificador de registro de campo
     * 
     * @param Integer $idregistrometadato id registro
     * @return Nada
     */
    function setIdRegistroMetadato($idregistrometadato) {
        $this->idregistrometadato = $idregistrometadato;
    }

    /**
     * @brief Define identificador de detalle documento
     * 
     * identificador de detalle documento relacionado
     * a registros metadatos
     * 
     * @param Integer $iddetalledocumento id detalle
     * @return Nada
     */
    function setIdDetalleDocumento($iddetalledocumento) {
        $this->iddetalledocumento = $iddetalledocumento;
    }

    /**
     * @brief Consulta metadato datos de parametros
     * 
     * Consulta metadato de formulario definido
     * 
     * @return Arreglo de todos los registros de metadatos
     */
    public function consultaMetadatoFormulario() {

        $tabla = "metadato m, grupometadato g, formulariometadato f, tipometadato t";
        $nombreidtabla = "m.idestado";
        $idtabla = "100";

        $condicion = " and g.idgrupometadato=m.idgrupometadato " .
                " and f.idformulariometadato=m.idformulariometadato " .
                " and t.idtipometadato=m.idtipometadato ";


        if (isset($this->idformulario) &&
                trim($this->idformulario) != "") {
            $condicion .= " and f.idformulariometadato='" . $this->idformulario . "'";
        }
        $condicion.=" order by g.ordengrupometadato,m.ordenmetadato ";

        $operacion = "";
        $resmetadato = $this->objbase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, $operacion, $this->debug);
        $i = 0;
        while ($rowmetadato = $resmetadato->fetchRow()) {
            $this->datosmetadato[$i] = $rowmetadato;
            $grupos[$rowmetadato["idgrupometadato"]] = $rowmetadato;
            $i++;
        }
        $i = 0;
        foreach ($grupos as $idgrupo => $filagrupo) {
            $this->datosgrupometadato[$i]["nombregrupometadato"] = $filagrupo["nombregrupometadato"];
            $this->datosgrupometadato[$i]["idgrupometadato"] = $filagrupo["idgrupometadato"];
            $this->datosgrupometadato[$i]["nombrecortogrupometadato"] = $filagrupo["nombrecortogrupometadato"];

            $i++;
        }
    }

    /**
     * @brief Consulta campos de metadato de parametros
     * 
     * Consulta metadato de formulario definido
     * 
     * @return Arreglo de todos los registros de metadatos
     */
    public function consultaCampoMetadato() {

        $tabla = "campometadato c, metadato m,tipocampometadato t";
        $nombreidtabla = "c.idestado";
        $idtabla = "100";

        $condicion = " and m.idmetadato=c.idmetadato " .
                " and c.idtipocampometadato=t.idtipocampometadato ";


        if (isset($this->idformulario) &&
                trim($this->idformulario) != "") {
            $condicion .= " and m.idformulariometadato='" . $this->idformulario . "'";
        }
        $condicion.=" order by m.ordenmetadato,c.idcampometadato ";

        $operacion = "";
        $rescampo = $this->objbase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, $operacion, $this->debug);
        $i = 0;
        while ($rowcampo = $rescampo->fetchRow()) {
            $this->datoscampo[$rowcampo["idmetadato"]][] = $rowcampo;
            $i++;
        }
    }

    /**
     * @brief Consulta de opciones de detalle campo
     * 
     * Consulta detalle campo, retorna arreglo de
     * opciones
     * 
     * @return Arreglo de todos los registros de metadatos
     */
    public function consultaDetalleCampo($idcampo) {
        $tabla = "detallecampo d";
        $nombreidtabla = "d.idestado";
        $idtabla = "100";
        $condicion = "";
        if (isset($idcampo) &&
                trim($idcampo) != "") {
            $condicion .= " and m.idcampometadato='" . $idcampo . "'";
        }
        $condicion .= " order by d.nombredetallecampo";

        $operacion = "";
        $rescampo = $this->objbase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, $operacion, $this->debug);
        $i = 0;
        while ($rowcampo = $rescampo->fetchRow()) {
            $datosdetallecampo[] = $rowcampo;
            $i++;
        }
        return $datosdetallecampo;
    }

    /**
     * @brief Registro de formulario de datos configuracion 
     * 
     * Registro de datos de configuracion 
     * 
     * @return Bool respuesta de ingreso exitoso
     */
    public function registroCampoMetadato() {
        $tabla = "registrometadato";
        $fila["idcampometadato"] = limpiaCadena($this->datosregistro["idcampometadato"]);
        $fila["iddetalledocumento"] = limpiaCadena($this->datosregistro["iddetalledocumento"]);
        $fila["valorregistrometadato"] = limpiaCadena($this->datosregistro["valorregistrometadato"]);
        if (isset($this->datosregistro["valorfecharegistrometadato"]) &&
                trim($this->datosregistro["valorfecharegistrometadato"]) != '') {
            if (validarFecha($this->datosregistro["valorfecharegistrometadato"])) {
                $fila["valorfecharegistrometadato"] = formato_fecha_mysql($this->datosregistro["valorfecharegistrometadato"]) . " 00:00:00";
            }
        }
        $fila["valortextoregistrometadato"] = limpiaCadena($this->datosregistro["valortextoregistrometadato"]);
        $fila["fecharegistrometadato"] = date("Y-m-d H:i:s");
        $fila["idusuario"] = $this->idusuario;
        $fila["idestado"] = "100";


        if (isset($this->idregistrometadato) &&
                $this->idregistrometadato != '') {
            $condicion = " idregistrometadato='" . $this->idregistrometadato . "'";
        }

        $this->objbase->insertar_fila_bd($tabla, $fila, $this->debug, $condicion);
    }

    /**
     * @brief Consulta registros de metadatos 
     * 
     * Consulta registros de metadatos con respecto
     * a detalle documento y retorna arreglo correspondiente
     * 
     * @return Array respuesta de ingreso exitoso
     */
    public function consultaRegistroDocumento() {
        $tabla = "registrometadato r,campometadato c, metadato m";
        $nombreidtabla = "r.idestado";
        $idtabla = "100";
        $condicion = " and r.iddetalledocumento='" . $this->iddetalledocumento . "'" .
                " and r.idcampometadato=c.idcampometadato " .
                " and c.idmetadato=m.idmetadato ";

        if (isset($this->idformulario) &&
                trim($this->idformulario) != '') {
            $condicion .= " and m.idformulariometadato='" . $this->idformulario . "'";
        }
        
        if (isset($this->campometadato) &&
                trim($this->campometadato) != '') {
            $condicion .= " and c.nombrecortocampometadato='" . $this->campometadato . "'";
        }
        
        $operacion = "";
        $resregistrodoc = $this->objbase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, $operacion, $this->debug);
        $i = 0;
        while ($rowregistrodoc = $resregistrodoc->fetchRow()) {
            $datosregistrodoc[$rowregistrodoc["idcampometadato"]] = $rowregistrodoc;
            $valor="";

            switch ($rowregistrodoc["idtipocampometadato"]) {
                case "4":
                    $valor = quitarsaltolinea($rowregistrodoc["valorregistrometadato"]);
                    break;
                case "3":
                    $valor = substr($rowregistrodoc["valorfecharegistrometadato"], 0, 10);
                    break;
                case "1":
                    $valor = quitarsaltolinea($rowregistrodoc["valortextoregistrometadato"]);
                    break;
            }
            $datosregistrodoc[$rowregistrodoc["idcampometadato"]]["valordefinitivoregistro"]=$valor;
            


            $i++;
        }
        return $datosregistrodoc;
    }

    /**
     * @brief Valida unicidad de registro de acuerdo a arreglo
     * 
     * Valida unicidad de registro de acuerdo a arreglo
     * de valores a registrar
     * 
     * @param Array $valoresCampos Arreglo de campos con indice de de campo
     * @return Array respuesta de ingreso exitoso
     */
    public function validaUnicidadRegistro($valoresCampos) {
        $i = 0;
        $cadenaTablas = "";
        foreach ($valoresCampos as $idmetadato => $filametadato) {
            foreach ($filametadato as $icampo => $filavalor) {
                $i++;
                $idcampo = $filavalor["idcampometadato"];

                $valor = limpiaCadena($_POST[$filavalor["nombrecortocampometadato"]]);

                if ($i > 1) {
                    $cadenaTablas.=" ,registrometadato as  r" . $i . " ";
                    $condicionAdicional.=" and r" . $i . ".idcampometadato='" . $idcampo . "'";
                    $condicionAdicional.=" and r" . $i . ".iddetalledocumento=r" . ($i - 1) . ".iddetalledocumento";
                    $condicionAdicional.=" and r" . $i . ".idestado='100'";
                } else {
                    $cadenaTablas.=" registrometadato as  r" . $i . " ";
                    $condicionAdicional.=" and r" . $i . ".idcampometadato='" . $idcampo . "'";
                }


                switch ($filavalor["nombrecortotipocampometadato"]) {
                    case "valor":
                        $condicionAdicional.=" and  r" . $i . ".valorregistrometadato='" . $valor . "'";
                        break;
                    case "fecha":
                        $condicionAdicional.=" and r" . $i . ".valorfecharegistrometadato='" . $valor . "'";
                        break;
                    case "texto":
                        $condicionAdicional.=" and r" . $i . ".valortextoregistrometadato='" . $valor . "'";
                        break;
                }
            }
        }
        $tabla = $cadenaTablas;
        $nombreidtabla = "r1.idestado";
        $idtabla = "100";
        $condicion = $condicionAdicional;

        $operacion = "";
        $datosregistro = $this->objbase->recuperar_datos_tabla($tabla, $nombreidtabla, $idtabla, $condicion, $operacion, $this->debug);
        if (isset($datosregistro["iddetalledocumento"]) ||
                trim($datosregistro["iddetalledocumento"]) != '') {
            return 0;
        }
        return 1;
    }

}
