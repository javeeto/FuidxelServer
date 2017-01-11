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
 * Descripcion del codigo de ControlLoteImagen
 * 
 * @file ControlLoteImagen.php
 * @author Javier Lopez Martinez
 * @date 27/10/2016
 * @brief Contiene ...
 */
class ControlLoteImagen {

    /**
     * Identificador lote de imagen
     *
     * @var Integer
     */
    private $idloteimagen;

    /**
     * Identificador de usuario de sesion
     *
     * @var Integer
     */
    private $idusuario;

    /**
     * Arreglo de datos de escaner
     *
     * @var Array
     */
    private $datosescaner;

    /**
     * Arreglo de datos de imagen
     *
     * @var Array
     */
    private $datosimagenes;

    /**
     * Objeto de gestion bd de lote imagen
     *
     * @var Array
     */
    private $objgestionlote;

    /**
     * @brief Inicializacion variables
     * 
     * Iniciacion de variables 
     * 
     * @return Nada
     */
    public function __construct() {
        //$this->idloteimagen = 0";
    }

    /**
     * @brief Define identificador de usuario
     * 
     * Define identificador de usuario
     * 
     * @param Integer $idusuario Identificador de usuario
     * @return Nada
     */
    function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    /**
     * @brief Retorna identificador de lote
     * 
     * Retorna numero de lote
     * 
     * @return Integer numero de lote
     */
    function getIdloteimagen() {
        return $this->idloteimagen;
    }

    /**
     * @brief Define identificador de lote
     * 
     * Define identificador de lote
     * 
     * @param Integer $idloteimagen Identificador de lote
     * @return Nada
     */
    function setIdloteimagen($idloteimagen) {
        $this->idloteimagen = $idloteimagen;
    }

    /**
     * @brief Obtiene datos de escaner
     * 
     * Retorna arreglo de datos de escaner
     * 
     * @return Array datos de escaner
     */
    function getDatosescaner() {
        return $this->datosescaner;
    }

    /**
     * @brief Obtiene datos de imagen
     * 
     * Retorna arreglo de datos de imagen
     * 
     * @return Array datos de imagen
     */
    function getDatosimagenes() {
        return $this->datosimagenes;
    }

    /**
     * @brief Define arreglo de datos escaner
     * 
     * Define arreglo de datos escaner
     * 
     * @param Array $datosescaner datos de escaner
     * @return Nada
     */
    function setDatosescaner(Array $datosescaner) {
        $this->datosescaner = $datosescaner;
    }

    /**
     * @brief Define arreglo de datos escaner
     * 
     * Define arreglo de datos escaner
     * 
     * @param Array $datosescaner datos de escaner
     * @return Nada
     */
    function setDatosimagenes(Array $datosimagenes) {
        $this->datosimagenes = $datosimagenes;
    }

    /**
     * @brief Obtiene objeto de lote de imagenes
     * 
     * Obtiene objeto modelo de datos
     * de lote de imagenes
     * 
     * @return GestionLoteImagen Objeto de lote imagen
     */
    function getObjGestionLote() {
        return $this->objgestionlote;
    }

    /**
     * @brief Define objeto de lote imagen
     * 
     * Define objeto modelo de datos
     * de lote de imagenes
     * 
     * @param GestionLoteImagen $objgestionlote Instancia lote de imagen
     * @return Nada
     */
    function setObjGestioLote($objgestionlote) {
        $this->objgestionlote = $objgestionlote;
    }

    /**
     * @brief Obtiene imagenes transferidas
     * 
     * Transfiere imagenes compartidas por cliente
     * guarda imagenes en repositorio temporal definido
     * por escaner
     * 
     * @param Array $salida datos de respuesta 
     * @return Nada
     */
    public function transferir($imagenesTransferidas) {

        $datosescaner = $this->datosescaner;

        $urlsatelite = "http://" . $datosescaner[0]["ipescaner"] . URLSATELITECARGUE . "/" . $this->idloteimagen . ".tar";

        $contenidotmp = file_get_contents($urlsatelite);
        file_put_contents($datosescaner[0]["directorioescaner"] . "/" . $this->idloteimagen . ".tar", $contenidotmp);

        $phar = new PharData($datosescaner[0]["directorioescaner"] . "/" . $this->idloteimagen . ".tar");

        $continuar = 1;
        if (!file_exists($datosescaner[0]["directorioescaner"] . "/" . $this->idloteimagen)) {
            mkdir($datosescaner[0]["directorioescaner"] . "/" . $this->idloteimagen);
        } else {

            $archivos = scandir($datosescaner[0]["directorioescaner"] . "/" . $this->idloteimagen);
            if (count($archivos) > 2) {
                $continuar = 0;
            }
        }

        if ($continuar) {
            $phar->extractTo($datosescaner[0]["directorioescaner"] . "/" . $this->idloteimagen);

            unset($phar);
            unlink($datosescaner[0]["directorioescaner"] . "/" . $this->idloteimagen . ".tar");

            $archivos = scandir($datosescaner[0]["directorioescaner"] . "/" . $this->idloteimagen);
            $salida["totalimagenes"] = (count($archivos) - 3) . "";
            $diferenciaenv = $salida["totalimagenes"] - $imagenesTransferidas;

            if ($diferenciaenv == 0) {
                $salida["resultado"] = "Ok";
            } else {
                $salida["resultado"] = "NOk";
                $salida["error"] = ERR0303 .
                        "\nImagenes enviadas=" . $imagenesTransferidas .
                        "\nImagenes recibidas=" . $salida["totalimagenes"];
                $this->borraImagenesLote();
            }
        } else {
            unlink($datosescaner[0]["directorioescaner"] . "/" . $this->idloteimagen . ".tar");

            $salida["error"] = ERR0304;
            $salida["resultado"] = "NOk";
            // print_r($salida);
        }
        return $salida;
    }

    /**
     * @brief Borra imagenes en lote
     * 
     * Busca imagenes en el lote y las borra
     * tambien borra del directorio thumnail las
     * miniaturas
     * 
     * @param Array $salida datos de respuesta 
     * @return Nada
     */
    public function borraImagenesLote() {
        $datosescaner = $this->datosescaner;
        $dirlote = $datosescaner[0]["directorioescaner"] . "/" . $this->idloteimagen;
        $archivos = scandir();
        chdir($dirlote);
        foreach ($archivos as $iarchivo => $archivo) {

            if (trim($archivo) != "." &&
                    trim($archivo) != ".." &&
                    trim($archivo) != "thumbnail") {
                unlink($archivo);
            }
        }
        chdir($dirlote . "/thumbnail");
        $archivos = scandir($dirlote . "/thumbnail");
        foreach ($archivos as $iarchivo => $archivo) {

            if (trim($archivo) != "." &&
                    trim($archivo) != ".." &&
                    trim($archivo) != "thumbnail") {
                unlink($archivo);
            }
        }
        rmdir($dirlote . "/thumbnail");
        rmdir($dirlote);
    }

    /**
     * @brief Registra array de imagenes de lote
     * 
     * Registra imagenes de lote en bloque de acuerdo
     * a arreglo de sesion de imagenes
     * 
     * @param Array $salida datos de respuesta 
     * @return Nada
     */
    public function registraImagenesxLote() {
        //$this->datosimagenes[];
        $datosescaner = $this->datosescaner;
        $dirlote = $datosescaner[0]["directorioescaner"] . "/" . $this->idloteimagen;
        $archivos = scandir($dirlote);
        foreach ($archivos as $iarchivo => $archivo) {
            if (trim($archivo) != "." &&
                    trim($archivo) != ".." &&
                    trim($archivo) != "thumbnail") {
                $filaimagen["rutaimagen"] = $dirlote . "/" . $archivo;
                $filaimagen["idloteimagen"] = $this->idloteimagen;
                $filaimagen["idusuario"] = $this->idusuario;
                $filaimagen["fechaimagen"] = date("Y-m-d H:i:s");
                $filaimagen["idestado"] = "100";
                $filaimagen["iddetalledocumento"] = "1";
               
                if($this->esSeparador($archivo)){
                     $filaimagen["idtipoimagen"] = "1";
                }else{
                    $filaimagen["idtipoimagen"] = FORMATOTIPOIMAGEN;
                }
                $this->objgestionlote->registroImagen($filaimagen);
            }
        }
    }
    
    /**
     * @brief Encuentra si archivo es un separador
     * 
     * Busca dentro del arreglo de imagenes si encuentra 
     * coincidencia de archivo y busca en separador si corresponde
     * al indice con esto valida si es un separador
     * 
     * @param String $archivo nombre de archivo sin ruta
     * @return Bool si o no es separador
     */
    public function esSeparador($archivo) {
        
        for ($i = 0; $i < count($this->datosimagenes["imagen"]); $i++) {
            $estaimagen = substr_count($this->datosimagenes["imagen"][$i],$archivo);
            //echo "\n<br>".$estaimagen."-".$archivo."-". $this->datosimagenes["imagen"][$i];
            if ($estaimagen > 0) {
                if ($this->datosimagenes["separacion"][$this->idloteimagen][$i]) {
                    return 1;
                }
            }
        }
        return 0;
    }
    /**
     * @brief Registra array  de lote
     * 
     * Actualiza datos de lote  de acuerdo
     * a arreglo de sesion de imagenes
     * 
     * @param Array $salida datos de respuesta 
     * @return Nada
     */
    public function registraLoteTransferido($totalimagenes) {
        $filalote["idusuario"]=$this->idusuario;
        $filalote["totalloteimagen"]=$totalimagenes;
        $filalote["idestadoloteimagen"]=2;
        $filalote["totaldocumentoloteimagen"]=count($this->datosimagenes["separacion"][$this->idloteimagen])+1;
        //$this->objgestionlote->debug();
        $this->objgestionlote->setIdLoteImagen($this->idloteimagen);
        $this->objgestionlote->actualizaLote($filalote);
    }
}
