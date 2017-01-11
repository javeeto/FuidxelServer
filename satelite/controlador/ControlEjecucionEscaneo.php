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
 * Descripcion del codigo de ControlEjecucionEscaneo
 * 
 * @file ControlEjecucionEscaneo.php
 * @author Javier Lopez Martinez
 * @date 30/09/2016
 * @brief Contiene ...
 */
class ControlEjecucionEscaneo {

    /**
     * recurso de conexion objeto control curl
     *
     * @var ControladorCurlRest
     */
    private $objcurlrest;

    /**
     * Activacion del debug
     *
     * @var Bool
     */
    private $debug;

    /**
     * Arreglo de opciones de escaner
     *
     * @var Array
     */
    private $opcionesescaner;

    /**
     * Identificador de lote
     *
     * @var Integer
     */
    private $idlote;

    /**
     * Numero de imagenes convertidas
     *
     * @var Integer
     */
    private $numeroimgs;

    /**
     * Identifica configuracion seleccionada
     * o por defecto
     *
     * @var Integer
     */
    private $configuracion;

    /**
     * @brief Inicializacion de de objeto curl
     * 
     * Iniciacion de objeto de ejecución
     * de servicio curl
     * 
     * @param ControladorCurlRest $objcurlrest Objeto control curl
     * @return Nada
     */
    public function __construct($objcurlrest) {
        $this->objcurlrest = $objcurlrest;
        $this->opcionesescaner = array();
        $this->configuracion = 0;
        $this->debug = 0;
        $this->numeroimgs = 0;
    }

    /**
     * @brief Retorna numero de configuracion
     * 
     * Retorna identificador en arreglo de la 
     * configuracion seleccionada
     * 
     * @return Integer numero de configuracion
     */
    function getConfiguracion() {
        return $this->configuracion;
    }

    /**
     * @brief Retorna opciones escaner
     * 
     * Retorna arreglo de opciones de 
     * escaner
     * 
     * @return Array arreglo deopciones
     */
    public function getOpcionesescaner() {
        return $this->opcionesescaner;
    }

    /**
     * @brief define secuencia de configuracion
     * 
     * Define secuencia de configuracion
     * 
     * @return Nada
     */
    public function setConfiguracion($configuracion) {
        $this->configuracion = $configuracion;
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
     * @brief define identificador  lote 
     * 
     * Define Identificador de lote 
     * 
     * @param int $idlote Description
     * @return Nada
     */
    public function setIdLote($idlote) {
        $this->idlote = $idlote;
    }

    /**
     * @brief define arreglo de opciones escaner 
     * 
     * define array con objetos de opciones de
     * escaner
     * 
     * @param int $idlote Description
     * @return Nada
     */
    public function setOpcionesEscaner($opcionesescaner) {
        $this->opcionesescaner = $opcionesescaner;
    }

    /**
     * @brief Copia recursiva de archivos
     * 
     * Copia recursiva de archivos de un directorio
     * a otro
     * 
     * @param pathOrigen directorio origen de imagenes
     * @param pathDestino directorio destino de imagenes
     * @return salida Respouesta del cuerpo de la pagina
     */
    public function copiaRecursiva($pathOrigen, $pathDestino, $raiznombre, $copiar = true, $borrar = false) {

        $this_path = getcwd();
        $hayImagenes = 0;
        $conimagen = 0;
        //echo "PathOrigen=$pathOrigen,PathDestino=$pathDestino<br>\n";
        if (is_dir($pathOrigen)) {
            chdir($pathOrigen);
            $handle = opendir($pathOrigen);
            while (($file = readdir($handle)) !== false) {
                $arrfiles[] = $file;
            }
            closedir($handle);
            for ($ifile = 0; $ifile < count($arrfiles); $ifile++) {
                $file = $arrfiles[$ifile];
                if (($file != ".") && ($file != "..")) {
                    //chmod($pathOrigen . "/" . $file, 0777);
                    if ($this->debug) {
                        echo "PathOrigen=$pathOrigen,PathDestino=$pathDestino,Archivo=" . $file . "<br>\n";
                    }
                    if (is_dir($file)) {
                        $salidarecursiva = $this->copiaRecursiva($pathOrigen . $file . "/", $pathDestino, $raiznombre, $copiar, $borrar);
                        //chdir($pathOrigen);
                        if ($borrar) {
                            //  chmod($pathOrigen . "/" . $file, 0777);
                            rmdir($pathOrigen . "/" . $file);
                            if ($this->debug) {
                                echo "Borra archivo= " . $pathOrigen . $file . "<br>\n";
                            }
                        }
                        return $salidarecursiva;
                    }
                    //echo file_exists($pathOrigen . $file) . "-" . $this->formatoArchivoOrigen($pathOrigen . $file);
                    if (file_exists($pathOrigen . $file)) {
                        if ($this->formatoArchivoOrigen($pathOrigen . $file)) {
                            if ($this->debug) {
                                echo "archivo= " . $pathOrigen . $file . "<br>\n";
                            }
                            $archivos[] = $file;
                        }

                        $fileinfo = pathinfo($file);
                        if (strtoupper($fileinfo["extension"]) == strtoupper(EXTENSIONARCHIVOORIGEN)) {
                            $hayImagenes = 1;
                            if (!$copiar &&
                                    !$borrar) {
                                /* echo "(!$copiar &&
                                  !$borrar)\n<br>"; */
                                if ($this->debug) {
                                    echo "-2 Saleo o no -" . $hayImagenes . "-";
                                }
                                return $hayImagenes;
                                //echo "-Saleo o no-";
                            }
                        }
                    }
                }
            }
        }




        if ($this->debug) {
            echo "archivos1<pre>";
            print_r($archivos);
            echo "</pre>";
        }
        if (is_array($archivos)) {
            natcasesort($archivos);



            if ($this->debug) {
                echo "archivos<pre>";
                print_r($archivos);
                echo "</pre>";
            }

            foreach ($archivos as $file) {
                if ($copiar) {
                    $conimagen++;
                    $filefinal = $raiznombre . str_pad($conimagen, 4, "0", STR_PAD_LEFT) . "." . EXTENSIONARCHIVOORIGEN;
                    copy($pathOrigen . "/" . $file, $pathDestino . "/" . $filefinal);
                    chmod($pathDestino . "/" . $filefinal, 0777);
                    //break;
                }
                if ($borrar) {
                    // chmod($pathOrigen . "/" . $file, 0777);
                    unlink($pathOrigen . "/" . $file);
                    if ($this->debug) {
                        echo "Borra archivo= " . $pathOrigen . $file . "<br>\n";
                    }
                }
                $this->numeroimgs = 1;
                break;
            }
        }

        if ($this->debug) {
            echo "-1 Saleo o no -" . $hayImagenes . "-";
        }
        return $hayImagenes;
    }

    /**
     * @brief Arma ruta de imagenes 
     * 
     * Arma ruta imagenes con directorio de escaneo y numero
     * lote
     * 
     * @param pathOrigen directorio origen de imagenes
     * @return ruta Ruta armada 
     */
    public function rutaLoteImagen() {
        $ruta = $this->opcionesescaner["dir"]->valoropcion . "/lotes/" . $this->idlote . "/";
        return $ruta;
    }

    /**
     * @brief Consulta recursiva de imagenes
     * 
     * Consulta recursiva de archivos de un directorio
     * a otro
     * 
     * @param pathOrigen directorio origen de imagenes
     * @return salida Respouesta del cuerpo de la pagina
     */
    public function consultaImagenes($pathOrigen) {

        $this_path = getcwd();
        $hayImagenes = 0;
        $conimagen = 0;
        //echo "PathOrigen=$pathOrigen,PathDestino=$pathDestino<br>\n";
        if (is_dir($pathOrigen)) {
            chdir($pathOrigen);
            $handle = opendir($pathOrigen);
            while (($file = readdir($handle)) !== false) {
                $arrfiles[] = $file;
            }
            closedir($handle);
            for ($ifile = 0; $ifile < count($arrfiles); $ifile++) {
                $file = $arrfiles[$ifile];
                // $archivos["imagenesbk"][] = $pathOrigen . $file;
                if (($file != ".") && ($file != "..")) {
                    //chmod($pathOrigen . "/" . $file, 0777);


                    if ($this->debug) {
                        echo "PathOrigen=$pathOrigen,PathDestino=$pathDestino,Archivo=" . $file . "<br>\n";
                    }
                    if (is_dir($file)) {
                        $archivostmp = $this->consultaImagenes($pathOrigen . $file . "/");

                        //chdir($pathOrigen);
                        // return $archivos;
                    }
                    //echo file_exists($pathOrigen . $file) . "-" . $this->formatoArchivoOrigen($pathOrigen . $file);
                    if (file_exists($pathOrigen . $file)) {
                        if ($this->formatoArchivoDestino($pathOrigen . $file)) {
                            if ($this->debug) {
                                echo "archivo= " . $pathOrigen . $file . "<br>\n";
                            }
                            $archivos["imagenes"][] = $pathOrigen . $file;
                            $archivos["thumbnail"][] = $pathOrigen . "thumbnail/" . str_replace(strtoupper(EXTENSIONARCHIVODESTINO), "png", strtoupper($file));
                            if (is_array($archivostmp)) {
                                $archivos["imagenes"] = array_merge(array($archivos["imagenes"], $archivostmp["imagenes"]));
                                $archivos["thumbnail"] = array_merge(array($archivos["thumbnail"], $archivostmp["thumbnail"]));
                            }
                        }
                    }
                }
            }
        }
        /* echo "imagenesbk<pre>";
          print_r($archivos["imagenesbk"]);
          echo "</pre>"; */
        if (is_array($archivos["imagenes"])) {
            natcasesort($archivos["imagenes"]);
            natcasesort($archivos["thumbnail"]);
        }
        return $archivos;
    }

    /**
     * @brief Creacion remota de lote 
     * 
     * Creacion remota de lote ,
     * array de salida
     * 
     * @param url de pagina a llamar
     * @return salida Respouesta del cuerpo de la pagina
     */
    public function validaExistenImagenes($pathOrigen) {
        $salidarecursiva = $this->copiaRecursiva($pathOrigen, "", "", false, false);
        if ($this->debug) {
            echo "PATHoRIGEN=$pathOrigen salidarecursiva=" . $salidarecursiva;
        }
        return $salidarecursiva;
    }

    /**
     * @brief Creacion remota de lote 
     * 
     * Creacion remota de lote ,
     * array de salida
     * 
     * @param url de pagina a llamar
     * @return salida Respouesta del cuerpo de la pagina
     */
    public function formatoOpcionesEscaner($datosescaner) {

        /* for ($i = 0; $i < count($datosescaner->opcionesescaner); $i++) {
          $this->opcionesescaner[$datosescaner->opcionesescaner[$i]->nombreopcion] = $datosescaner->opcionesescaner[$i];
          } */
        if($this->debug){
            echo "<br>Configuracion=".$this->configuracion."<br>";
        }
        $opciones = $datosescaner->configuracion[$this->configuracion]->opciones;

        for ($i = 0; $i < count($opciones); $i++) {
            $this->opcionesescaner[$opciones[$i]->nombreopcion] = $opciones[$i];
        }
    }

    /**
     * @brief Valida formato de imagen
     * 
     * Valida formato de imagen
     * 
     * 
     * @param patharchivo ruta de archivo completo
     * @return bool true o false de acuerdo a validacion
     */
    public function formatoArchivoOrigen($patharchivo) {
        try {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $extensiontipo = @finfo_file($finfo, $patharchivo);
            finfo_close($finfo);
            if ($extensiontipo == MITYPEIMAGENORIGEN) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @brief Valida formato de imagen destino
     * 
     * Valida formato de imagen destino
     * 
     * 
     * @param patharchivo ruta de archivo completo
     * @return bool true o false de acuerdo a validacion
     */
    public function formatoArchivoDestino($patharchivo) {
        try {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $extensiontipo = @finfo_file($finfo, $patharchivo);
            finfo_close($finfo);
            if ($extensiontipo == MITYPEIMAGENDESTINO) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @brief Creacion remota de lote 
     * 
     * Creacion remota de lote ,
     * array de salida
     * 
     * @param url de pagina a llamar
     * @return salida Respouesta del cuerpo de la pagina
     */
    public function crearLote() {

        $poststring = array("s_claveconexion" => $_SESSION["s_sesionremota"]->claveconexion,
            "accion" => "nuevolote");

        // $urlsesion = PROTOCOLOSERVIDOR . "://" . IPSERVIDORPRINCIPAL . "/fuixel/" . RUTASERVICIOS . "/controlador/controlGestionLote.php";
        $salida = $this->objcurlrest->obtenerRespuesta($poststring);
        //  $this->objcurlrest->cerrarConexion();
        $datonuevolote = json_decode($salida);

        return $datonuevolote;
    }

    /**
     * @brief Transfiere lote de imagenes
     * 
     * Transfiere lote imagenes a servidor
     * empaquetando el directorio en  un tar
     * 
     * @param String $idlote numero de lote de imagenes
     * @return salida Respuesta del proceso de transferencia
     */
    public function transferirLote($datosimagenes) {

        $datosescaner = $datosimagenes["datosescaner"];
        $this->formatoOpcionesEscaner($datosescaner);
        $opcionesescaner = $this->getOpcionesescaner();
        $rutasatelite = $this->opcionesescaner["dir"]->valoropcion;
        $phar = new PharData(RUTACARGUETMP . "/" . $this->idlote . ".tar");
        $phar->buildFromDirectory($rutasatelite . "/lotes/" . $this->idlote);
        $archivos = scandir($rutasatelite . "/lotes/" . $this->idlote);
        $totalimagenes = count($archivos) - 3;

        unset($phar);



        $poststring = array("s_claveconexion" => $_SESSION["s_sesionremota"]->claveconexion,
            "accion" => "transferirlote",
            "s_idescaner" => $_SESSION["s_sesionremota"]->idescaner,
            "s_idlote" => $this->idlote,
            "s_usuario" => $_SESSION["s_usuario"],
            "s_totalimagenes" => $totalimagenes,
            "s_datosimagenes" => $datosimagenes);

        // $urlsesion = PROTOCOLOSERVIDOR . "://" . IPSERVIDORPRINCIPAL . "/fuixel/" . RUTASERVICIOS . "/controlador/controlGestionLote.php";
        $salida = $this->objcurlrest->obtenerRespuesta($poststring);

        unlink(RUTACARGUETMP . "/" . $this->idlote . ".tar");
        //  $this->objcurlrest->cerrarConexion();
        // echo $salida;
        //$datotransferir = json_decode($salida);

        return $salida;
    }

    /**
     * @brief Creacion remota de lote 
     * 
     * Creacion remota de lote ,
     * array de salida
     * 
     * @param url de pagina a llamar
     * @return salida Respouesta del cuerpo de la pagina
     */
    public function consultaEscaneo() {

        $poststring = array("s_claveconexion" => $_SESSION["s_sesionremota"]->claveconexion,
            "s_idescaner" => $_SESSION["s_idescaner"],
            "accion" => "consultaescaner");

        $salida = $this->objcurlrest->obtenerRespuesta($poststring);
        $encabezado = $this->objcurlrest->obtenerEncabezado();


        $datoescaner = json_decode($salida);
        return $datoescaner;
    }

    /**
     * @brief Mueve imagenes encontradas en carpeta de
     * escaneo
     * 
     * Creacion remota de lote ,
     * array de salida
     * 
     * @param url de pagina a llamar
     * @return salida Respouesta del cuerpo de la pagina
     */
    public function formatoImagenFinal($pathOrigen, $pathDestino) {

        $this_path = getcwd();
        $hayImagenes = 0;
        $conimagen = 0;
        $imagenes = array();
        //echo "PathOrigen=$pathOrigen,PathDestino=$pathDestino<br>\n";
        if ($this->debug) {
            echo "2-PathOrigen=$pathOrigen,PathDestino=$pathDestino<br>\n";
        }


        if (is_dir($pathOrigen)) {
            chdir($pathOrigen);
            $handle = opendir('.');
            while (($file = readdir($handle)) !== false) {
                $arrfiles[] = $file;
            }
            closedir($handle);
            for ($ifile = 0; $ifile < count($arrfiles); $ifile++) {
                $file = $arrfiles[$ifile];
                if (($file != ".") && ($file != "..")) {
                    if ($this->debug) {
                        echo "3-PathOrigen=$pathOrigen,PathDestino=$pathDestino,Archivo=" . $file . "<br>\n";
                        echo "if (" . file_exists($pathOrigen . $file) . " && " . $this->formatoArchivoOrigen($pathOrigen . $file) . ")<br>\n";
                    }
                    if (file_exists($pathOrigen . $file) &&
                            $this->formatoArchivoOrigen($pathOrigen . $file)) {

                        $archivos[] = $file;
                        break;
                    }
                }
            }
        }

        if (is_array($archivos)) {
            natcasesort($archivos);

            foreach ($archivos as $file) {

                if ($this->debug) {
                    echo "4-PathOrigen=$pathOrigen,PathDestino=$pathDestino,Archivo=" . $file . "<br>\n";
                }

                $arrayextension = explode(".", $file);
                $extension = str_replace($arrayextension[0], "", $file);
                $nombreabsoluto = $arrayextension[0];
                $newfile = $nombreabsoluto . "." . EXTENSIONARCHIVODESTINO;
                $newfilethumb = $nombreabsoluto . "." . EXTENSIONARCHIVOTHUMB;

                $objimagen = new EdicionImagen($pathOrigen . $file);
                $objimagen->setConfiguracolor($this->opcionesescaner["pixeltype"]->valoropcion);

                if ($this->debug) {
                    echo "4-PathDestino=" . $pathDestino . $newfile . "<br>\n";
                }
                $objimagen->setRutaDestino($pathDestino . $newfile);
                $timeinicioimg = time();
                $objimagen->convertirTif();
                $timefinimg = time();
                unlink($pathOrigen . $file);
                if (!file_exists($pathDestino . "/thumbnail/")) {
                    mkdir($pathDestino . "/thumbnail", 0777, true);
                    chmod($pathDestino . "/thumbnail", 0777);
                }
                $objimagen->setRutaDestino($pathDestino . "/thumbnail/" . $newfilethumb);
                $objimagen->creaThumbnail();
                $imagenes["thumbnail"][] = $pathDestino . "/thumbnail/" . $newfilethumb;
                $imagenes["imagen"][] = $pathDestino . $newfile;

                $diftime = $timefinimg - $timeinicioimg;
                $imagenes["tiempoimagen"][] = $diftime;
            }
        }
        return $imagenes;
    }

    /**
     * @brief Ejecuta 
     * escaneo
     * 
     * Creacion remota de lote ,
     * array de salida
     * 
     * @param url de pagina a llamar
     * @return salida Respouesta del cuerpo de la pagina
     */
    public function ejecutaEscaneo() {

        $datosescaner = $this->consultaEscaneo();
        $this->formatoOpcionesEscaner($datosescaner);
        $pathOrigen = $this->opcionesescaner["dir"]->valoropcion . "/00000/";
        $opcionestmp = $this->opcionesescaner;
        /* echo "opciones<pre>";
          print_r($opcionestmp);
          echo "</pre>"; */
        $cadenaopcion = EJECUCIONESCANEO;
        foreach ($opcionestmp as $nombreopcion => $datosopciones) {
            $cadenaopcion.=" -" . $datosopciones->nombrecortoopcion . " " . $datosopciones->valoropcion;
        }
        //echo " start /b " . $cadenaopcion . '\\00000';
        //$pid = shell_exec(" nohup /home/javeeto/bash/copyfile.sh 2>&1 /tmp/copylog.txt &");       
        exec("nohup /home/javeeto/bash/copyfile.sh > /tmp/copylog.txt &");
        // echo "nohup /home/javeeto/bash/copyfile.sh 2>&1 /tmp/copylog.txt &<br>\n";

        /* $rutainicialimagenes = "/srv/digitalizacion/batch0001/";
          for ($i = 1; $i <= 10; $i++) {
          sleep("3");
          copy($rutainicialimagenes . "/image" . $i . ".bmp", $pathOrigen . "image" . $i . ".bmp");
          } */

        //$WshShell = new COM("WScript.Shell");
        //$oExec = $WshShell->Run("cmd ".$cadenaopcion."\\00000", 0, false);
        //exec("start /B ".$cadenaopcion.'\\00000 > NUL 2> NUL');
        //exec("start /B ".$cadenaopcion.'\\00000 > NUL 2> NUL');
        //pclose(popen("start /B ".$cadenaopcion.'\\00000', "a"));
        //pclose(popen("start \"bla\" \"" . $cadenaopcion . "\" ", "r")); 
        /* $ejecucion = "start \"bla\" \"c:\Python27\pythonw.exe\" " . $cadenaopcion . "\\00000  > NUL 2> NUL ";
          echo $ejecucion;
          pclose(popen($ejecucion, "r")); */

        return "OK";
    }

    /**
     * @brief Copia y crea nueva imagenes en blanco
     * 
     * Crea nueva imagenes en blanco y con respecto al
     * nombre las inserta para emular nuevas separaciones
     * 
     * @param url de pagina a llamar
     * @return salida Respouesta del cuerpo de la pagina
     */
    public function insertarImagenSeparacion($listaImagen) {
        $arregloLista = explode(",", $listaImagen);
        $salida["resultado"] = "Ok";
        $salida["error"] = ERR0317;
        for ($i = 0; $i < (count($arregloLista) - 1); $i++) {
            $iimagen = limpiaCadena($arregloLista[$i]);
            $rutaimagen = $_SESSION["s_datosimagenes"]["imagen"][$iimagen];

            $rutasepara = explode("/", $rutaimagen);
            $nombreimagen = $rutasepara[(count($rutasepara) - 1)];
            $dirimagen = str_replace($nombreimagen, "", $rutaimagen);
            $parteimagen = explode(".", $nombreimagen);
            $extimagen = $parteimagen[(count($parteimagen) - 1)];
            $solonombre = str_replace("." . $extimagen, "", $nombreimagen);
            $rutablanca = $dirimagen . "/" . $solonombre . "_01.tiff";
            $rutathumbblanca = $dirimagen . "/thumbnail/" . $solonombre . "_01.png";

            if (!copy(RUTASEPARADOR, $rutablanca)) {
                $salida["resultado"] = "NOK";
                $salida["error"] = ERR0316;
            }
            if (!copy(RUTASEPARADORTHUMBNAIL, $rutathumbblanca)) {
                $salida["resultado"] = "NOK";
                $salida["error"] = ERR0316;
            }
        }
        return $salida;
    }

    /**
     * @brief Mueve imagenes encontradas en carpeta de
     * escaneo
     * 
     * Creacion remota de lote ,
     * array de salida
     * 
     * @param url de pagina a llamar
     * @return salida Respouesta del cuerpo de la pagina
     */
    public function moverImagenesLocal() {
        //touch("C:\\tmp\\logejecuta.txt");
        $_SESSION["s_datosimagenes"]["contadorejecucion"] ++;
        //echo $_SESSION["s_datosimagenes"]["contadorejecucion"]."- Entro 1 ".date("H:i:s")."\n<br>";

        $tmpdatosescaner = $_SESSION["s_datosimagenes"]["datosescaner"];
        if (isset($tmpdatosescaner->opcionesescaner[0]->nombreopcion) &&
                trim($tmpdatosescaner->opcionesescaner[0]->nombreopcion != '')) {
            $datosescaner = $_SESSION["s_datosimagenes"]["datosescaner"];
        } else {
            $datosescaner = $this->consultaEscaneo();
            $_SESSION["s_datosimagenes"]["datosescaner"] = $datosescaner;
        }

        // $datosescaner = $this->consultaEscaneo();
        if ($this->debug) {
            echo "opcionesescaner<pre>";
            print_r($this->opcionesescaner);
            echo "</pre>";
        }

        $this->formatoOpcionesEscaner($datosescaner);
        //echo $_SESSION["s_datosimagenes"]["contadorejecucion"]."- Entro 2 ".date("H:i:s")."\n<br>";

        $pathOrigen = $this->opcionesescaner["dir"]->valoropcion . "/00000/";
        if ($this->debug) {
            echo "validaExistenImagenes=" . $this->validaExistenImagenes($pathOrigen) . "\n<br>";
        }
        //$this->debug();
        if ($this->validaExistenImagenes($pathOrigen)) {

            //echo $_SESSION["s_datosimagenes"]["contadorejecucion"]."- Entro 3 ".date("H:i:s")."\n<br>";
            if (isset($_SESSION["s_datosimagenes"]["datoslote"]->idlote) &&
                    $_SESSION["s_datosimagenes"]["datoslote"]->idlote != '') {
                $datoslote = $_SESSION["s_datosimagenes"]["datoslote"];
            } else {
                $datoslote = $this->crearLote();
                $_SESSION["s_datosimagenes"]["datoslote"] = $datoslote;
                $_SESSION["s_datosimagenes"]["datosescaner"] = $datosescaner;
            }

            //echo $_SESSION["s_datosimagenes"]["contadorejecucion"]."- Entro 4 ".date("H:i:s")."\n<br>";

            if ($this->debug) {
                echo "datoslote<pre>";
                print_r($datoslote);
                echo "</pre>";
            }
            //creacion backup
            $raiznombre = time();

            if (!file_exists($pathOrigen)) {
                $salida["resultado"] = "error";
                $salida["error"] = ERR0302;
                return $salida;
            }
            $pathDestino = RUTABACKUPLOCAL . "/lotes/" . $datoslote->idlote;
            if (!file_exists($pathDestino)) {
                mkdir($pathDestino, 0777, true);
                chmod($pathDestino, 0777);
            }

            $this->copiaRecursiva($pathOrigen, $pathDestino, $raiznombre, true, false);
            //echo $_SESSION["s_datosimagenes"]["contadorejecucion"]."- Entro 5 ".date("H:i:s")."\n<br>";
            //Mover imagenes final
            $pathOrigen = $this->opcionesescaner["dir"]->valoropcion . "/00000/";
            $pathDestino = $this->opcionesescaner["dir"]->valoropcion . "/lotes/" . $datoslote->idlote;
            if (!file_exists($pathDestino)) {
                mkdir($pathDestino, 0777, true);
                chmod($pathDestino, 0777);
            }

            if ($this->debug) {
                echo "PATH= $pathOrigen, $pathDestino, $raiznombre, true, true";
            }

            $this->copiaRecursiva($pathOrigen, $pathDestino, $raiznombre, true, true);
            //echo $_SESSION["s_datosimagenes"]["contadorejecucion"]."- Entro 6 ".date("H:i:s")."\n<br>";

            $pathOrigen = $this->opcionesescaner["dir"]->valoropcion . "/lotes/" . $datoslote->idlote . "/";
            $pathDestino = $this->opcionesescaner["dir"]->valoropcion . "/lotes/" . $datoslote->idlote . "/";
            /* if (!file_exists($pathDestino)) {
              mkdir($pathDestino, 0777, true);
              chmod($pathDestino, 0777);
              } */

            //$this->debug();

            if ($this->debug) {
                echo "PathOrigen=$pathOrigen,PathDestino=$pathDestino<br>\n";
            }

            $timeini = time();
            $imagenes = $this->formatoImagenFinal($pathOrigen, $pathDestino);
            $timefin = time();
            $tiempoconv = $timefin - $timeini;
            //echo $_SESSION["s_datosimagenes"]["contadorejecucion"]."- Entro 7 ".date("H:i:s")."\n<br>";
            $salida = $imagenes;
            $salida["idlote"] = $datoslote->idlote;
            $salida["resultado"] = "OK";
            $salidarchivo = explode(":", trim(file_get_contents(ARCHIVOEJECUTAESCANER)));
            $salida["estadoproceso"] = $salidarchivo[0];
            $salida["totalimagenes"] = $salidarchivo[1];
            $salida["imgsconversion"] = $this->numeroimgs;
            $salida["timeimgs"] = $tiempoconv;
            if ($this->validaExistenImagenes($pathOrigen)) {
                $salida["existenimagenes"] = "1";
            } else {
                $salida["existenimagenes"] = "0";
            }


            $this->objcurlrest->cerrarConexion();
            //echo $_SESSION["s_datosimagenes"]["contadorejecucion"]."- Entro 8 ".date("H:i:s")."\n<br>";
            return $salida;
        } else {
            $salida["resultado"] = "error";
            $salida["error"] = ERR0301;
            //$salida["estadoproceso"] = trim(file_get_contents(ARCHIVOEJECUTAESCANER));
            $salida["imgsconversion"] = $this->numeroimgs;
            $salidarchivo = explode(":", trim(file_get_contents(ARCHIVOEJECUTAESCANER)));
            $salida["estadoproceso"] = $salidarchivo[0];
            $salida["totalimagenes"] = $salidarchivo[1];
            if ($this->validaExistenImagenes($pathOrigen)) {
                $salida["existenimagenes"] = "1";
            } else {
                $salida["existenimagenes"] = "0";
            }
            //echo $_SESSION["s_datosimagenes"]["contadorejecucion"]."- Entro 9 ".date("H:i:s")."\n<br>";
            return $salida;
        }
    }

    /**
     * @brief Mueve imagenes encontradas en carpeta de
     * escaneo
     * 
     * Creacion remota de lote ,
     * array de salida
     * 
     * @param url de pagina a llamar
     * @return salida Respouesta del cuerpo de la pagina
     */
    public function menuOpcionEscaner($datosescaner) {
        $objformulario = new FormularioBase();

        $opciones = $datosescaner->configuracion;
        $nombre = "menuConfiguracion";
        for ($i = 0; $i < count($opciones); $i++) {
            //$this->opcionesescaner[$opciones[$i]->nombreopcion] = $opciones[$i];
            $opciones[$i] = $opciones[$i]->nombrecorto;
        }
        if ($this->debug) {
            echo "opciones<pre>";
            print_r($opciones);
            echo "</pre>";
        }


        $division = "1";
        $selecciona = $this->configuracion;
        $formatoValida = 0;
        $patronCadena = "";

        $htmlMenu = $objformulario->menuIndividual($nombre, $opciones, $division, $selecciona, $formatoValida, $patronCadena);
        return $htmlMenu;
    }

}
