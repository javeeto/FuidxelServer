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
 * Description of FormaActaFinal
 *
 * @author javeeto
 */
class FormaActaFinal {

    /**
     *  Objeto de formulario
     *
     * @var FormularioBase
     */
    private $objformulario;

    /**
     *  Objeto de gestion de acta
     *
     * @var GestionActaInicio
     */
    private $objacta;

    /**
     *  Objeto de gestion de usuario
     *
     * @var GestionUsuario
     */
    private $objusuario;

    /**
     *  Arreglo de datos de configuracion 
     *
     * @var Array
     */
    private $datosacta;

    //put your code here
    public function __construct($objformulario) {
        $this->objformulario = $objformulario;
        //  $this->objgestionacta = $objgestionacta;
        $this->datosacta = array();
    }

    public function setDatosActa($datosacta) {
        $this->datosacta = $datosacta;
    }

    public function setObjUsuario($objusuario) {
        $this->objusuario = $objusuario;
    }

    function setObjacta( $objacta) {
        $this->objacta = $objacta;
    }

    public function panelGeneral() {

        $titulocampo = "Entidad";
        $nombre = "identidad";
        $validacion = "requerido";
        $valor = $this->datosacta[$nombre];
        $mensaje = "Entidad relacionada al usuario";
        $mensaje2 = "Nombre de Entidad ";
        $datosentidad = $this->objusuario->consultaEntidad($this->datosacta["identidad"]);
        //$opciones
        // $opciones[""] = "Seleccionar";
        /* for ($i = 0; $i < count($datosestadoconfiguracion); $i++) {
          $opsestadoconfiguracion[$datosestadoconfiguracion[$i]["idestado"]] = $datosestadoconfiguracion[$i]["nombreestado"];
          } */
        $arrPanel["nombreEntidadHtml"] = $this->objformulario->campoMenu($titulocampo, $nombre, $validacion, $valor, $datosentidad, $mensaje, $mensaje2, $ayuda);
        $arrPanel["errorEntidadHtml"] = $this->objformulario->getEstiloError($nombre);


        $error = 0;
        $titulocampo = "No de lote";
        $nombre = "idloteimagen";
        $validacion = "readonly";
        $valor = $this->datosacta[$nombre];
        $tamano = "100";
        $mensaje = "Numero del lote imagenes del acta";
        $mensaje2 = "Numero de lote";
        $arrPanel["nombreLoteHtml"] = $this->objformulario->campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2);
        $arrPanel["errorLoteHtml"] = $this->objformulario->getEstiloError($nombre);


        $titulocampo = "No de documentos";
        $nombre = "documentoactacontrol";
        $validacion = "readonly";
        $valor = $this->datosacta[$nombre];
        $tamano = "100";
        $mensaje = "Cantidad de documentos";
        $mensaje2 = "Numero total de documentos en lote";
        $arrPanel["nombreDocumentoHtml"] = $this->objformulario->campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2);
        $arrPanel["errorDocumentoHtml"] = $this->objformulario->getEstiloError($nombre);

        $titulocampo = "No de imagenes";
        $nombre = "imagenacta";
        $validacion = "readonly";
        $valor = $this->datosacta[$nombre];
        $tamano = "100";
        $mensaje = "Cantidad de documentos";
        $mensaje2 = "Numero total de documentos en lote";
        $arrPanel["nombreImagenHtml"] = $this->objformulario->campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2);
        $arrPanel["errorImagenHtml"] = $this->objformulario->getEstiloError($nombre);
        
            
        $titulocampo = "No serial medio digitalizacion";
        $nombre = "serialmedio";
        $validacion = "";
        $valor = $this->datosacta[$nombre];
        $tamano = "100";
        $mensaje = "Serial de escaner";
        $mensaje2 = "No serial de equipo de escaneo";
        $arrPanel["nombreSerialHtml"] = $this->objformulario->campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2);
        $arrPanel["errorSerialHtml"] = $this->objformulario->getEstiloError($nombre);

        $titulocampo = "Faltantes";
        $nombre = "faltante";
        $validacion = "";
        $valor = $this->datosacta[$nombre];
        $tamano = "100";
        $mensaje = "Numero de imagenes faltantes";
        $mensaje2 = "Imagenes faltantes";
        $arrPanel["nombreFaltanteHtml"] = $this->objformulario->campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2);
        $arrPanel["errorFaltanteHtml"] = $this->objformulario->getEstiloError($nombre);
        
        
        $titulocampo = "Observaciones";
        $nombre = "observacionacta";
        $ayuda ="";        
        $entradas[0]["tipo"]="observacion";
        $entradas[0]["nombre"]="observacionacta";
        $entradas[0]["division"]="9";        
        $entradas[0]["validacion"]="";
        $entradas[0]["valor"]=$this->datosacta[$nombre];
        $entradas[0]["tamano"]="250";
        $entradas[0]["mensaje"]="Serial de escaner";
        $entradas[0]["mensaje2"]="No serial de equipo de escaneo";
        $entradas[0]["patronCadena"]="";       
        
        $arrPanel["nombreObservacionHtml"] = $this->objformulario->campoCombinado($titulocampo, $nombre, $entradas, $ayuda);
        $arrPanel["errorObservacionHtml"] = $this->objformulario->getEstiloError($nombre);


        $titulocampo = "Certificado de calidad equipo";
        $nombre = "nombrecertificado";
        $validacion = "";
        $valor = $this->datosacta[$nombre];
        $tamano = "100";
        $mensaje = "Archivo de certificado";
        $mensaje2 = "Adjuntar archivo de certificado";
        $arrPanel["nombreCertificadoHtml"] = $this->objformulario->campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2, "", "file");
        $arrPanel["errorCertificadoHtml"] = $this->objformulario->getEstiloError($nombre);

        $titulocampo = "Certificado de procedencia documental";
        $nombre = "certificadoprocedencia";
        $validacion = "";
        $valor = $this->datosacta[$nombre];
        $tamano = "100";
        $mensaje = "Archivo de certificado";
        $mensaje2 = "Adjuntar archivo de certificado";
        $arrPanel["nombreCertProcedenciaHtml"] = $this->objformulario->campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2, "", "file");
        $arrPanel["errorCertProcedenciaHtml"] = $this->objformulario->getEstiloError($nombre);
        
        $titulocampo = "Certificado de revisi&oacute;n imagenes existentes ";
        $nombre = "certificadorevision";
        $validacion = "";
        $valor = $this->datosacta[$nombre];
        $tamano = "100";
        $mensaje = "Archivo de certificado";
        $mensaje2 = "Adjuntar archivo de certificado";
        $arrPanel["nombreCertRevisionHtml"] = $this->objformulario->campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2, "", "file");
        $arrPanel["errorCertRevisionHtml"] = $this->objformulario->getEstiloError($nombre);

        

        $titulocampo = "Fecha de digitalizaci&oacute;n";
        $nombre = "fechalote";
        $validacion = "readonly";
        $valor = $this->datosacta[$nombre];
        $tamano = "100";
        $mensaje = "Fecha completa de lote";
        $mensaje2 = "Fecha y hora de lote";
        $arrPanel["nombreFechaHtml"] = $this->objformulario->campoEntrada($titulocampo, $nombre, $valor, $validacion, $tamano, $mensaje, $mensaje2 );
        $arrPanel["errorFechaHtml"] = $this->objformulario->getEstiloError($nombre);


        return $arrPanel;
    }
    
    public function getError() {
        return $this->objformulario->getError();
    }    

}
