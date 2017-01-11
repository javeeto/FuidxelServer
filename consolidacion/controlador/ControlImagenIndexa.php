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
 * Descripcion del codigo de ControlImagenIndexa
 * 
 * @file ControlImagenIndexa.php
 * @author Javier Lopez Martinez
 * @date 9/11/2016
 * @brief Contiene ...
 */
class ControlImagenIndexa {

    /**
     * Objeto de gestion imagen
     *
     * @var GestionImagen
     */
    private $objimagen;

    /**
     * Objeto de gestion imagen
     *
     * @var FormularioBase
     */
    private $objformulario;

    /**
     * Objeto de gestion datos metadato
     *
     * @var GestionMetadato
     */
    private $objmetadato;

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
     * Arreglo de imagenes
     *
     * @var Array
     */
    private $datosgrupoimagen;

    /**
     * Identificador documento en grupo de imagen
     *
     * @var Integer
     */
    private $idocumento;

    /**
     * @brief Inicializacion de variables de conexion
     * 
     * Iniciacion de variables y cadenas de conexion BD
     * 
     * @param[in] objbase recurso de base de datos.
     * @return Nada
     */
    public function __construct() {

        $this->debug = 0;
        $this->datosgrupoimagen = array();
        $this->idocumento = 0;
    }

    public function debug() {
        $this->debug = 1;
    }

    /**
     * @brief Define objeto formulario
     * 
     * Define formulario
     * 
     * @return Nada
     */
    function setObjFormulario($objformulario) {
        $this->objformulario = $objformulario;
    }

    /**
     * @brief Define datos de grupo imagen
     * 
     * Define datos grupo de imagen
     * 
     * @return Nada
     */
    function setDatosGrupoImagen(Array $datosgrupoimagen) {
        $this->datosgrupoimagen = $datosgrupoimagen;
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
     * @brief Define objeto de datos de imagen
     * 
     * Define objeto imagen
     * 
     * @return Nada
     */
    function setObjGestionImagen($objgestionimagen) {
        $this->objimagen = $objgestionimagen;
    }

    /**
     * @brief Obtiene objeto metadato
     * 
     * Retorna objeto metadato
     * 
     * @return Nada
     */
    function getObjMetadato() {
        return $this->objmetadato;
    }

    /**
     * @brief Define objeto metadato
     * 
     * Define objeto de metadato
     * 
     * @param GestionMetadato $objmetadato Objeto metadato
     * @return Nada
     */
    function setObjMetadato($objmetadato) {
        $this->objmetadato = $objmetadato;
    }

    /**
     * @brief Define indice de documento en grupo
     * 
     * Define documento en grupo de lote
     * 
     * @return Nada
     */
    function setIdocumento($idocumento) {
        $this->idocumento = $idocumento;
    }

    /**
     * @brief Define indice de documento en grupo
     * 
     * Define documento en grupo de lote
     * 
     * @return Nada
     */
    function getDatosgrupoimagen() {
        return $this->datosgrupoimagen;
    }

    function getIdocumento() {
        return $this->idocumento;
    }
        /**
     * @brief Retorna detalle documento de grupo documento
     * 
     * Retorna detalle documento de grupo documento
     * 
     * @return Nada
     */
    function getIdDetalleDocumento() {
        return $this->datosgrupoimagen[$this->idocumento][0]["iddetalledocumento"];
    }
    /**
     * @brief Obtiene array con imagenes separadas por documento
     * 
     * Separa imagenes transferidas por documento tomando imagen 
     * de separacion y agrupando imagenes por indice
     * 
     * @return Array arreglo de imagenes agrupadas
     */
    function separaDocumentoImagen() {
        $this->objimagen->setIdLoteImagen($this->idloteimagen);
        if ($this->debug) {
            $this->objimagen->debug();
        }
        $datosimagenes = $this->objimagen->consultaImagen();
        $congrupo = 0;
        $conimagen = 0;
        foreach ($datosimagenes as $iimagen => $filaimagen) {


            if ($filaimagen["idtipoimagen"] == "1") {
                $congrupo++;
                $conimagen = 0;
                continue;
            }
            $this->datosgrupoimagen[$congrupo][$conimagen] = $filaimagen;
            if (trim($filaimagen["iddetalledocumento"]) != "1") {
                $this->objmetadato->setIdDetalleDocumento($filaimagen["iddetalledocumento"]);
                $this->datosgrupoimagen[$congrupo][$conimagen]["registrometadato"] = $this->objmetadato->consultaRegistroDocumento();
            }
            $conimagen++;
        }
        return $this->datosgrupoimagen;
    }

    /**
     * @brief Obtiene arreglo de rutas de miniatura
     * 
     * Separa imagenes transferidas por documento tomando imagen 
     * de separacion y agrupando imagenes por indice
     * 
     * @return Array arreglo de imagenes agrupadas
     */
    function miniaturaGrupoImagen() {
        // $tmpdatosgrupoimagen=$this->datosgrupoimagen;
        for ($i = 0; $i < count($this->datosgrupoimagen); $i++) {
            $rutaimagen = $this->datosgrupoimagen[$i][0]["rutaimagen"];
            $rutasepara = explode("/", $rutaimagen);
            $nombreimagen = $rutasepara[(count($rutasepara) - 1)];
            $dirimagen = str_replace($nombreimagen, "", $rutaimagen);
            $parteimagen = explode(".", $nombreimagen);
            $extimagen = $parteimagen[(count($parteimagen) - 1)];
            $solonombre = str_replace($extimagen, "", $nombreimagen);
            $dirminiatura = $dirimagen . "thumbnail";
            $rutaminiatura = $dirminiatura . "/" . $solonombre . "png";
            $rutas[$i] = $rutaminiatura;
        }
        return $rutas;
    }

    /**
     * @brief Obtiene arreglo de rutas de miniatura
     * 
     * Separa imagenes transferidas por documento tomando imagen 
     * de separacion y agrupando imagenes por indice
     * 
     * @return Array arreglo de imagenes agrupadas
     */
    function arregloImagenGrupo() {
        if ($this->debug) {
            echo "<br>this->datosgrupoimagen[" . $this->idocumento . "]";
            echo "<br>datosgrupoimagen<pre>";
            print_r($this->datosgrupoimagen);
            echo "</pre>";
        }
        for ($i = 0; $i < count($this->datosgrupoimagen[$this->idocumento]); $i++) {
            $rutas["imagen"][$i] = $this->datosgrupoimagen[$this->idocumento][$i]["rutaimagen"];

            $rutasepara = explode("/", $rutas["imagen"][$i]);
            $nombreimagen = $rutasepara[(count($rutasepara) - 1)];
            $dirimagen = str_replace($nombreimagen, "", $rutas["imagen"][$i]);
            $parteimagen = explode(".", $nombreimagen);
            $extimagen = $parteimagen[(count($parteimagen) - 1)];
            $solonombre = str_replace($extimagen, "", $nombreimagen);
            $dirminiatura = $dirimagen . "thumbnail";
            $rutaminiatura = $dirminiatura . "/" . $solonombre . "png";
            $rutas["thumbnail"][$i] = $rutaminiatura;
        }
        return $rutas;
    }

    /**
     * @brief Obtiene arreglo de rutas de miniatura
     * 
     * Separa imagenes transferidas por documento tomando imagen 
     * de separacion y agrupando imagenes por indice
     * 
     * @return Array arreglo de imagenes agrupadas
     */
    function tituloGrupoImagen() {
        //$this->objmetadato->debug();
        $arreglocampos = $this->extraerCamposFormulario();


        for ($i = 0; $i < count($this->datosgrupoimagen); $i++) {
            $registrodato = $this->datosgrupoimagen[$i][0]["registrometadato"];

            if (is_array($registrodato)) {
                $concampo = 0;
                foreach ($registrodato as $iregistrodato => $filametadato) {
                    $filacampo = $arreglocampos[$filametadato["idcampometadato"]];
                    $titulogrupo[$i][$concampo]["nombrecampo"] = $filacampo["nombrecortocampometadato"];
                    switch ($filacampo["nombretipocampometadato"]) {
                        case "valor":
                            $titulogrupo[$i][$concampo]["valorcampo"] = $filametadato["valorregistrometadato"];
                            break;
                        case "fecha":
                            $titulogrupo[$i][$concampo]["valorcampo"] = $filametadato["valorfecharegistrometadato"];
                            break;
                        case "texto":
                            $titulogrupo[$i][$concampo]["valorcampo"] = $filametadato["valortextoregistrometadato"];
                            break;
                    }
                    $concampo++;
                }
            } else {
                $tmparreglocampos = $arreglocampos;
                $concampo = 0;
                foreach ($tmparreglocampos as $idcampo => $filacampo) {
                    $titulogrupo[$i][$concampo]["nombrecampo"] = $filacampo["nombrecortocampometadato"];
                    $concampo++;
                }

            }
        }
        return $titulogrupo;
    }

    /**
     * @brief Obtiene arreglo de rutas de miniatura
     * 
     * Separa imagenes transferidas por documento tomando imagen 
     * de separacion y agrupando imagenes por indice
     * 
     * @return Array arreglo de imagenes agrupadas
     */
    function extraerCamposFormulario() {
        $this->objmetadato->consultaCampoMetadato();
        $campometadato = $this->objmetadato->getDatosCampo();
        foreach ($campometadato as $imetadato => $filametadato) {
            foreach ($filametadato as $icampo => $filacampo) {
                $arreglocampos[$filacampo["idcampometadato"]] = $filacampo;
            }
        }
        if ($this->debug) {
            echo "<pre>";
            echo "campometadato";
            print_r($campometadato);
            echo "arreglocampos";
            print_r($arreglocampos);
            echo "</pre>";
        }
        return $arreglocampos;
    }

    /**
     * @brief Obtiene arreglo de rutas de miniatura
     * 
     * Separa imagenes transferidas por documento tomando imagen 
     * de separacion y agrupando imagenes por indice
     * 
     * @return Array arreglo de imagenes agrupadas
     */
    function listaImagenForma() {
        $nombre = "menuImagen";
        for ($i = 0; $i < count($this->datosgrupoimagen[$this->idocumento]); $i++) {
            $opciones[$i] = "Pag " . ($i + 1);
        }
        $division = "otra";
        $selecciona = 0;
        $formatoValida = 0;
        $patronCadena = "";

        $htmlMenu = $this->objformulario->menuIndividual($nombre, $opciones, $division, $selecciona, $formatoValida, $patronCadena);
        return $htmlMenu;
    }

        /**
     * @brief Genera html para menu de documento
     * 
     * Genera html para menu de documento 
     * 
     * 
     * @return String html de menu de documento de lote
     */
    function listaDocumentoForma() {
        $nombre = "menuDoc";
        for ($i = 0; $i < count($this->datosgrupoimagen); $i++) {
            $opciones[$i] = "Doc " . ($i + 1);
        }
        $division = "1";
        $selecciona = $this->idocumento;
        $formatoValida = 0;
        $patronCadena = "";

        $htmlMenu = $this->objformulario->menuIndividual($nombre, $opciones, $division, $selecciona, $formatoValida, $patronCadena);
        return $htmlMenu;
    }
    


}
