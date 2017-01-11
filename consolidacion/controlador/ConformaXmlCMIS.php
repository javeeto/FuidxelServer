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
 * Description of ConformaXmlCMIS
 *
 * @author javeeto
 */
class ConformaXmlCMIS {

    /**
     * Activacion del debug
     *
     * @var Bool
     */
    private $debug;

    /**
     * Url de servicio CMIS
     *
     * @var String
     */
    private $repoUrl;

    /**
     * Usuario de servicio CMIS
     *
     * @var String
     */
    private $repoUsuario;

    /**
     * Clave de servicio CMIS
     *
     * @var String
     */
    private $repoClave;

    /**
     * Directorio en servicio CMIS
     *
     * @var String
     */
    private $repoDir;

    /**
     * Directorio en servicio CMIS
     *
     * @var String
     */
    private $repoNuevoDir;

    /**
     *  Objeto de integracion cmis
     *
     * @var CMISService
     */
    private $clienteCMIS;

    /**
     *  Objeto de folder remoto CMIS
     *
     * @var ObjectByPath
     */
    private $objDir;

    /**
     *  Objeto de archivo nuevo remoto CMIS
     *
     * @var ObjectByPath
     */
    private $objArchivoNuevo;

    /**
     *  Ruta de documento local
     *
     * @var String
     */
    private $rutaDocumento;

    /**
     *  Nombre de archivo a cargar
     *
     * @var String
     */
    private $nombreArchivo;

    /**
     *  Identificador de detalle documento a cargar
     *
     * @var Integer
     */
    private $iddetalledocumento;

    /**
     * @brief Inicializacion de array base de imagenes
     * 
     * Inicializacion de arreglo base de imagenes
     * 
     * 
     * @return Nada
     */
    public function __construct() {
        $this->repoUrl = "http://" . CMISREPOHOST . "/" . CMISREPOURL;
        $this->repoUsuario = CMISREPOUSER;
        $this->repoClave = CMISREPOPASSWORD;
        $this->repoDir = CMISREPODIR;
        $this->repoNuevoDir = CMISREPONUEVODIR;
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
     * @brief Define ruta local de documento
     * 
     * Define ruta local de documento
     * 
     * @return Nada
     */
    function setRutaDocumento($rutaDocumento) {
        $this->rutaDocumento = $rutaDocumento;
    }

    /**
     * @brief Define identificador de documento
     * 
     * Define identificador de detalle de documento
     * 
     * @return Nada
     */
    function setIdDetalleDocumento($iddetalledocumento) {
        $this->iddetalledocumento = $iddetalledocumento;
    }

    /**
     * @brief Chequeo de respuesta de integracion 
     * 
     * Chequeo si la respuesta de integracion es exitosa
     * 
     * @return Nada
     */
    function chequeoRespuesta() {
        if ($this->clienteCMIS->getLastRequest()->code > 299) {
            print "There was a problem with this request!\n";
            exit(255);
        }
    }

    /**
     * @brief Inicio de objetos de integracion
     * 
     * Inicializacion instancias de integracion
     * cliente CMIS y folder remoto
     * 
     * @return Nada
     */
    function cargaServicio() {
        if ($this->debug) {
            echo "<br>" . $this->repoUrl . "," . $this->repoUsuario . "," . $this->repoClave;
        }
        $this->clienteCMIS = new CMISService($this->repoUrl, $this->repoUsuario, $this->repoClave);
        $this->objDir = $this->clienteCMIS->getObjectByPath($this->repoDir);
    }

    /**
     * @brief Inicio de objetos de integracion
     * 
     * Inicializacion instancias de integracion
     * cliente CMIS y folder remoto
     * 
     * @return Nada
     */
    function cargaDocumento() {
        $opts = array('http' =>
            array(
                'header' => "Content-Type: application/pdf\r\n"
            )
        );

        $contexto = stream_context_create($opts);
        

        
        $strPdf = file_get_contents($this->rutaDocumento, false, $context);
        $separaRuta = explode("/", $this->rutaDocumento);
        $this->nombreArchivo = $separaRuta[(count($separaRuta) - 1)];

        $this->objArchivoTmp = $this->clienteCMIS->getObjectByPath($this->repoDir . "/" . $this->nombreArchivo);
        if(isset($this->objArchivoTmp->id)&&
                trim($this->objArchivoTmp->id)!=''){
            $this->clienteCMIS->deleteObject($this->objArchivoTmp->id);
        }        

        $obj_doc = $this->clienteCMIS->createDocument($this->objDir->id, $this->nombreArchivo, array(), $strPdf, 'application/pdf');
        if ($this->debug) {
            $this->chequeoRespuesta();
        }

        $this->objArchivoNuevo = $this->clienteCMIS->getObjectByPath($this->repoDir . "/" . $this->nombreArchivo);
    }

    /**
     * @brief Carga xml a servicio cmis
     * 
     * Carga xml con metadatos al servicio cmis
     * al archivo ya cargado con anticipacion
     * 
     * @return Nada
     */
    function cargarMetadatoXML() {
        $content = file_get_contents(CMISCARGAXML . "?usuario=admin&iddetalledocumento=" . $this->iddetalledocumento);

        $repo_property_values = $this->nombreArchivo . ",Archivo Tramite, Este archivo no contiene algo,Javier Lopez";

        $doc = new DOMDocument();
        $doc->loadXML($content);

        

        $obj_url = $this->clienteCMIS->getLink($this->objArchivoNuevo->id, "edit");
        $obj_url = CMISRepositoryWrapper :: getOpUrl($obj_url, $repo_property_values);

        $retval = $this->clienteCMIS->doRequest($obj_url, "PUT", $content, MIME_ATOM_XML_ENTRY);
        
        if ($this->debug) {
            print "Updated Object\n:\n===========================================\n";
            echo "<pre>";
            echo "================================XMLCONTENT==============================";
            print_r($content);
            echo "================================FINXMLCONTENT==============================";
            echo "RETVAL<br><br>\n";
            print_r($retval);
        }

        $myobject = $this->clienteCMIS->extractObject($retval->body);
        $this->clienteCMIS->cacheObjectInfo($myobject);
        if ($this->debug) {
            $this->chequeoRespuesta($this->clienteCMIS);
        }
    }

}
