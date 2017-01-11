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
 * Descripcion del codigo de ConformaDocumento
 * 
 * @file ConformaDocumento.php
 * @author Javier Lopez Martinez
 * @date 15/11/2016
 * @brief Contiene ...
 */
class ConformaDocumento {

    /**
     * Activacion del debug
     *
     * @var Bool
     */
    private $debug;

    /**
     * Objeto de control de registros imagenes en indexación
     *
     * @var ControlImagenIndexa
     */
    private $objimagenindexa;

    /**
     * Objeto de informacion tecnica de documento
     *
     * @var InformacionLote
     */
    private $objinfo;

    /**
     * Descripcion de error del proceso de cargue
     *
     * @var String
     */
    private $mensajeError;

    /**
     * Descripcion de exito del proceso de cargue
     *
     * @var String
     */
    private $mensajeExito;

    /**
     * Identificador detalle documento
     *
     * @var Integer
     */
    private $iddetalledocumento;

    /**
     * Identificador de documento
     *
     * @var Integer
     */
    private $iddocumento;

    /**
     * Indicador si proceso remplaza archivo existente
     *
     * @var Bool
     */
    private $remplazar;

    /**
     * Datos de repositorio activo
     *
     * @var Array
     */
    private $datosrepoactivo;

    /**
     * Objeto de gestión documento
     *
     * @var GestionDocumento
     */
    private $objgestiondocumento;

    /**
     * Objeto de gestión lote imagen
     *
     * @var GestionLoteImagen
     */
    private $objloteimagen;

    /**
     * Objeto de gestión imagen
     *
     * @var GestionImagen
     */
    private $objimagen;

    /**
     *  Identificador de usuario
     *
     * @var integer
     */
    private $idusuario;

    /**
     *  Indic<dorf de activacion conversion ocr
     *
     * @var bool
     */
    private $activaconversionocr;

    /**
     * @brief Inicializacion de array base de imagenes
     * 
     * Inicializacion de arreglo base de imagenes
     * 
     * 
     * @return Nada
     */
    public function __construct() {
        $this->debug = 0;
        $this->datosgrupoimagen = array();
        $this->remplazar = 1;
        $this->activaconversionocr = 1;
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
     * @brief Define identificador de usuario
     * 
     * Consulta en base de datos datos de sesion de usuario
     * 
     * @param int $idusuario identificador de usuario
     * @return datosusuario Arreglo con datos de usuario
     */
    public function setIdUsuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    /**
     * @brief Obtiene mensaje de exito
     * 
     * Obtiene mensaje de exito
     * 
     * @return String de mensaje de exito
     */
    function getMensajeExito() {
        return $this->mensajeExito;
    }

    /**
     * @brief Obtiene mensaje de error
     * 
     * Obtiene mensaje de error
     * 
     * @return String  mensaje de error
     */
    function getMensajeError() {
        return $this->mensajeError;
    }

    /**
     * @brief Obtiene id detalle documento
     * 
     *  Obtiene id detalle documento
     * 
     * @return Integer  id detalle documento
     */
    function getIdDetalleDocumento() {
        return $this->iddetalledocumento;
    }

    /**
     * @brief Obtiene id documento
     * 
     * Obtiene id documento
     * 
     * @return Integer id documento
     */
    function getIdDocumento() {
        return $this->iddocumento;
    }

    /**
     * @brief Define datos de repositorio
     * 
     * Define datos de repositorio
     * 
     * @param Array $datosrepoactivo datos repositorio
     * @return Nada
     */
    function setDatosRepoActivo($datosrepoactivo) {
        return $this->datosrepoactivo = $datosrepoactivo;
    }

    /**
     * @brief Define objeto imagen
     * 
     * Define objeto de gestion de datos imagen
     * 
     * @param GestionImagen $objimagen datos imagen
     * @return Nada
     */
    function setObjimagen($objimagen) {
        $this->objimagen = $objimagen;
    }

    /**
     * @brief Define datos de repositorio
     * 
     * Define datos de repositorio
     * 
     * @param Array $datosrepoactivo datos repositorio
     * @return Nada
     */
    function setObjGestionDocumento($objgestiondocumento) {
        $this->objgestiondocumento = $objgestiondocumento;
    }

    /**
     * @brief Define objeto de registro indexacion imagen
     * 
     * Objeto de clase de control de registros de imagen
     * en indexación
     * 
     * @param ControlImagenIndexa $objimagenindexa Objeto control imagen
     * @return Nada
     */
    function setObjImagenIndexa($objimagenindexa) {
        $this->objimagenindexa = $objimagenindexa;
    }

    /**
     * @brief Define objeto de registro lote imagen
     * 
     * Objeto de clase de lotes de imagen
     * 
     * @param GestionLoteImagen $objloteimagen Objeto registro lote
     * @return Nada
     */
    function setObjloteimagen($objloteimagen) {
        $this->objloteimagen = $objloteimagen;
    }

    /**
     * @brief Define activacion de conversion ocr
     * 
     * Define activacion de conversion ocr
     * 
     * @param Bool $activaconversionocr Define activacion
     * @return Nada
     */
    function setActivaConversionocr($activaconversionocr) {
        $this->activaconversionocr = $activaconversionocr;
    }

    /**
     * @brief Define objeto de informacion de documento
     * 
     * Define objeto de informacion
     * 
     * @param InformacionLote $objinfo objeto info doc
     * @return Nada
     */
    function setObjinfo($objinfo) {
        $this->objinfo = $objinfo;
    }

    /**
     * @brief Agrupa imagenes y genera pdf 
     * 
     * Agrupa imagenes en carpeta temporal y
     * genera pdf correspondiente
     * 
     * @return Nada
     */
    public function agrupaImagen() {
        $rutaImagenGrupo = $this->objimagenindexa->arregloImagenGrupo();
        $rutasepara = explode("/", $rutaImagenGrupo["imagen"][0]);
        $nombreimagen = $rutasepara[(count($rutasepara) - 1)];
        $dirimagen = str_replace($nombreimagen, "", $rutas["imagen"][0]);
        $archunico = tempnam($dirimagen, "TMP");
        $dirdestino = $archunico . ".d";
        //$dirdestino = $dirimagen . "/" . $marcatiempo . "/";
        if (!file_exists($dirdestino)) {
            mkdir($dirdestino, 0775);
            unlink($archunico);
        }

        for ($i = 0; $i < count($rutaImagenGrupo["imagen"]); $i++) {
            $rutasepara = explode("/", $rutaImagenGrupo["imagen"][$i]);
            $nombreimagen = $rutasepara[(count($rutasepara) - 1)];
            if (!copy($rutaImagenGrupo["imagen"][$i], $dirdestino . "/" . $nombreimagen)) {
                $this->mensajeError.=ERR0318;
                return 0;
            }
        }
        $this->convertirDirImagenPDF($dirdestino);

        if ($this->validaArchivoCreado($dirdestino . "/salida.pdf")) {
            if ($this->registraDocumentoDefinitivo($dirdestino . "/salida.pdf")) {
                $this->actualizaImagenGrupo();
                return 1;
            }
        } else {
            return 0;
        }
    }

    /**
     * @brief Ejecuta script de conversion
     * 
     * Convierte imagenes a PDF con script que recibe
     * directorio a convertir 
     * 
     * @param String $dirimagen Directorio de imagenes
     * @return Nada
     */
    public function convertirDirImagenPDF($dirimagen) {
        $dirlog = DIRLOGIMAGEN;
        if (!file_exists($dirlog)) {
            mkdir($dirlog, 0775);
        }
        $logejecucion = $dirlog . "/logmultipdf.txt 2>> " . $dirlog . "/logmultipdf.txt";
        $ejecucion = DIRBASHEJECUCION . "/./tiff2pdfindividual.sh " . $dirimagen . " >" . $logejecucion;
        $respuesta = exec($ejecucion, $salida, $retorno);
        if ($this->debug) {
            echo "SALIDA<pre>";
            var_dump($respuesta);
            var_dump($salida);
            var_dump($retorno);
            echo "</pre>";
        }
    }

    /**
     * @brief Agrupa imagenes y genera pdf 
     * 
     * Agrupa imagenes en carpeta temporal y
     * genera pdf correspondiente
     * 
     * @return Nada
     */
    public function validaArchivoCreado($rutaarchivo) {
        if (!file_exists($rutaarchivo)) {
            $this->mensajeError.= ERR0309 . " " . $temporalarchivo . " " . $rutaarchivo;
            return 0;
        } else {
            $tamano = round(filesize($rutaarchivo) / 1024);
            if (filesize($rutaarchivo) <= 1000) {
                $this->mensajeError.=ERR0313;
                return 0;
            } else {
                $this->mensajeExito.=ERR0314;
                return 1;
            }
        }
    }

    /**
     * @brief Actualiza todas las imagenes de grupo 
     * 
     * Actualiza todas las imagenes de grupo 
     * del grupo a indexar para asignarlas al nuevo documento
     * 
     * @return Nada
     */
    public function actualizaImagenGrupo() {
        $gruposimagen = $this->objimagenindexa->getDatosgrupoimagen();
        $grupoimagen = $gruposimagen[$this->objimagenindexa->getIdocumento()];
        //$this->objloteimagen->debug();
        foreach ($grupoimagen as $iimagen => $filaimagen) {
            $this->objloteimagen->setIdImagen($filaimagen["idimagen"]);
            $filaactualiza["iddetalledocumento"] = $this->iddetalledocumento;
            $this->objloteimagen->registroImagen($filaactualiza);
        }
    }

    /**
     * @brief Envia pdf temporal a ruta definitiva y registra en BD 
     * 
     * Copia archivo temporal en PDF a ruta definitiva
     * obteniendo ruta repositorio.Registra en tablas
     * documento, detalledocumento y control documento
     * 
     * @param String $rutatmp Ruta de archivo temporal
     * @return Nada
     */
    public function registraDocumentoDefinitivo($rutatmp) {
        $rutadocumento = date("Ym");
        $dirdestino = $this->datosrepoactivo["rutarepositorio"] . "/" . $rutadocumento;
        if (!file_exists($dirdestino)) {
            if ($this->debug) {
                echo "datosrepoactivo<pre>";
                print_r($this->datosrepoactivo);
                echo "</pre>";

                echo "RUTA DEFINITIVA DESTINO=" . $dirdestino;
            }
            mkdir($dirdestino, 0775, true);
        }
        $this->objgestiondocumento->setIdUsuario($this->idusuario);
        $datosdocumento["idrepositorio"] = $this->datosrepoactivo["idrepositorio"];
        $datosdocumento["rutadocumento"] = $rutadocumento;
        $datosdocumento["rutadocumentodetalle"] = "";
        $datosdocumento["ordendetalledocumento"] = "1";
        $datosdocumento["idestadocontrol"] = "3";
        $datosdocumento["descripcioncontroldocumento"] = "";
        $datosdocumento["paginacontroldocumento"] = "1";

        $this->objgestiondocumento->setDatosDocumento($datosdocumento);

        $iddocumento = $this->objgestiondocumento->registrarDocumento();
        $idddetalledocumento = $this->objgestiondocumento->registrarDetalleDocumento();

        $this->iddetalledocumento = $idddetalledocumento;
        $this->iddocumento = $iddocumento;

        $iddoccero = str_pad($iddocumento, 6, "0", STR_PAD_LEFT);
        $iddetcero = str_pad($idddetalledocumento, 6, "0", STR_PAD_LEFT);
        $nombredefinitivo = $rutadocumento . $iddoccero . $iddetcero . ".pdf";
        $rutadestino = $dirdestino . "/" . $nombredefinitivo;
        $rutaconversion = RUTACONVERCIONOCR . "/" . $nombredefinitivo;


        if ($this->activaconversionocr) {
            if (!$this->validaCopiaArchivo($rutatmp, $rutaconversion, $nombredefinitivo)) {
                $this->mensajeError.=ERR0319;
                return 0;
            }
        }

        if ($this->debug) {
            echo "<br>validaCopiaArchivo($rutatmp, $rutadestino, $nombredefinitivo)<br>";
        }


        if ($this->validaCopiaArchivo($rutatmp, $rutadestino, $nombredefinitivo)) {
            $datosdocumento["rutadetalledocumento"] = $nombredefinitivo;
            $datosdocumento["descripcioncontroldocumento"] = "Creado Exitosamente";
            $this->objgestiondocumento->setIddocumento($iddocumento);
            $this->objgestiondocumento->setIddetalledocumento($iddetalledocumento);
            $this->objgestiondocumento->setDatosDocumento($datosdocumento);

            $idddetalledocumento = $this->objgestiondocumento->registrarDetalleDocumento();
            $this->objgestiondocumento->registrarControlDocumento();
            return 1;
        } else {
            $datosdocumento["rutadetalledocumento"] = $nombredefinitivo;
            $datosdocumento["descripcioncontroldocumento"] = " No Creado Exitosamente " . $rutadestino;
            $this->objgestiondocumento->setIddocumento($iddocumento);
            $this->objgestiondocumento->setIddetalledocumento($iddetalledocumento);
            $this->objgestiondocumento->setDatosDocumento($datosdocumento);

            $idddetalledocumento = $this->objgestiondocumento->registrarDetalleDocumento();
            $this->objgestiondocumento->registrarControlDocumento();
            return 0;
        }
    }

    /**
     * @brief consulta registros de documentos sin ocr
     * 
     * Consulta registros de documentos sin ocr
     * y remplaza archivos enn la ruta definitiva
     * 
     * @param CargaXMLDocumento $objcargacmis Carga de documento a cmis
     * @return Nada
     */
    public function retornaArchivoConOCR($objcargacmis) {
        $docsinocr = $this->objgestiondocumento->consultaDocumentoSinOCR();
        if ($this->debug) {
            echo "docsinocr<pre>";
            print_r($docsinocr);
            echo "</pre>";
        }
        if (is_array($docsinocr)) {
            foreach ($docsinocr as $idocumento => $filadocumento) {

                $dirorigen = RUTACONVERCIONOCRSALIDA;
                $dirdestino = $filadocumento["rutarepositorio"] . "/" . $filadocumento["rutadocumento"];
                $nombredefinitivo = $filadocumento["rutadetalledocumento"];
                $rutadestino = $dirdestino . "/" . $nombredefinitivo;
                $rutaorigen = $dirorigen . "/" . $nombredefinitivo;


                if ($this->activaconversionocr) {
                    if ($this->debug) {
                        echo "\n<br> validaCopiaArchivo($rutaorigen, $rutadestino, $nombredefinitivo";
                    }
                    if (file_exists($rutaorigen)) {
                        if ($this->validaCopiaArchivo($rutaorigen, $rutadestino, $nombredefinitivo)) {
                            $datosdocumento["idestadocontrol"] = 4;
                            $datosdocumento["descripcioncontroldocumento"] = "Documento OCR copiado exitosamente";
                            $datosdocumento["paginacontroldocumento"] = 1;
                            $this->objgestiondocumento->setIdUsuario("1");
                            $this->objgestiondocumento->setDatosDocumento($datosdocumento);
                            $this->iddetalledocumento=$filadocumento["iddetalledocumento"];
                            $this->integraInformacionDocumento();
                            $this->objgestiondocumento->setIddetalledocumento($filadocumento["iddetalledocumento"]);
                            $objcargacmis->CargaDocumento($filadocumento["iddetalledocumento"]);
                            $this->objgestiondocumento->registrarControlDocumento();
                        } else {
                            $this->mensajeError.=ERR0320;
                            return 0;
                        }
                    }
                }
            }
        }
        return 1;
    }

    /**
     * @brief Agrupa imagenes y genera pdf 
     * 
     * Agrupa imagenes en carpeta temporal y
     * genera pdf correspondiente
     * 
     * @return Nada
     */
    public function validaCopiaArchivo($rutaorigen, $rutadestino, $archivodestino) {
        if (file_exists($rutadestino)) {
            if ($this->remplazar) {

                if (copy($rutaorigen, "/tmp/" . $archivodestino)) {
                    $this->mensajeExito.=ERR0310;
                    unlink($rutadestino);
                } else {
                    $this->mensajeError.=ERR0311;
                    return 0;
                }
            } else {
                $this->mensajeError.=ERR0312;
                return 0;
            }
        }

        if (copy($rutaorigen, $rutadestino)) {
            return $this->validaArchivoCreado($rutadestino);
        } else {
            $this->mensajeError.= ERR0309 . " " . $temporalarchivo . " " . $filepath;
            return 0;
        }
    }

    /**
     * @brief Genera html para menu de documento
     * 
     * Genera html para menu de documento 
     * 
     * 
     * @return String html de menu de documento de lote
     */
    function integraInformacionDocumento() {


        $this->objgestiondocumento->setIddetalledocumento($this->iddetalledocumento);
        $this->objimagen->setIddetalledocumento($this->iddetalledocumento);
        $datosimagen=$this->objimagen->consultaImagen();
        $this->objloteimagen->setIdLoteImagen($datosimagen[0]["idloteimagen"]);
        
        $datoslote = $this->objloteimagen->consultaLotesEscaneo();
        $datosdocumento = $this->objgestiondocumento->consultaDocumentoDetalle();
        $rutadocumento = $datosdocumento[0]["rutarepositorio"] . "/" . $datosdocumento[0]["rutadocumento"] . "/" . $datosdocumento[0]["rutadetalledocumento"];
        $infodocumento = $this->objinfo->infoSistemaRutaPDF($rutadocumento);
        $objmetadato = $this->objimagenindexa->getObjMetadato();
        $objmetadato->setIdDetalleDocumento($this->iddetalledocumento);
        $objmetadato->setIdFormulario(FORMULARIOISADG);
        $objmetadato->setIdusuario($this->idusuario);

        $tablametadato = array("mediocapturacaracteris",
            "modelocaracteristica",
            "imagencaracteristicas",
            "formatocompresion",
            "tamanodigital",
            "resolucioncaracteris",
            "lenguacaracteris",
            "dimensionescaracteris",
            "colorescaracteris",
            "Folios");


        $tablainfo = array("Escaner",
            $datoslote[0]["nombreescaner"],
            "",
            "",
            $infodocumento["sizefile"],
            $infodocumento["resx"] . "x" . $infodocumento["resx"] . " dpi",
            "",
            $infodocumento["pagesize2"],
            $infodocumento["color"],
            $infodocumento["pages"]);

        $datosmetadato = $objmetadato->consultaRegistroDocumento();

        foreach ($datosmetadato as $idcampo => $filadatos) {
            for ($i = 0; $i < count($tablametadato); $i++) {
                if ($filadatos["nombrecortocampometadato"] == $tablametadato[$i]) {
                    $datosregistro["idcampometadato"] = $filadatos["idcampometadato"];
                    $datosregistro["iddetalledocumento"] = $this->iddetalledocumento;
                    $datosregistro["valortextoregistrometadato"] = $tablainfo[$i];
                    $objmetadato->setDatosRegistro($datosregistro);
                    $objmetadato->registroCampoMetadato();
                }
            }
        }
    }

}
