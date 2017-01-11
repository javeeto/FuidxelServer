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
 * Descripcion del codigo de EdicionImagen
 * 
 * @file EdicionImagen.php
 * @author Javier Lopez Martinez
 * @date 17/10/2016
 * @brief Contiene ...
 */
class EdicionImagen {

    /**
     * ruta completa de imagen
     *
     * @var String
     */
    var $rutaimagen;

    /**
     * ruta sin nombre de imagen
     *
     * @var String
     */
    var $dirimagen;

    /**
     * nombre del archivo de imagen
     *
     * @var String
     */
    var $nombreimagen;

    /**
     * ruta temporal
     *
     * @var String
     */
    var $rutatemporal;

    /**
     * ruta temporal destino
     *
     * @var String
     */
    var $rutadestino;

    /**
     * Objeto de imagick 
     *
     * @var Imagick
     */
    var $objimagick;

    /**
     * Objeto de imagick 
     *
     * @var ImagickDraw
     */
    var $objimagickdraw;

    /**
     * Objeto de imagick 
     *
     * @var ImagickPixel
     */
    var $objimagickpixel;

    /**
     * Configuracion color
     *
     * @var String
     */
    var $configuracolor;

    /**
     * @brief Inicializacion de objetos ImageMagick
     * 
     * Definicion de rutas de imagenes y objetos
     * ImageMagick
     * 
     * @return Nada
     */
    public function __construct($rutaimagen) {
        $this->rutaimagen = $rutaimagen;
        $arrayimagen = explode("/", $rutaimagen);
        $this->nombreimagen = $arrayimagen[(count($arrayimagen) - 1)];
        $this->dirimagen = str_replace($this->nombreimagen, "", $this->rutaimagen);
        $this->objimagick = new Imagick();
        $this->objimagickpixel = new ImagickPixel();
        $this->objimagickdraw = new ImagickDraw();
        $this->objimagick->readImage($this->rutaimagen);
        $this->rutatemporal = RUTATEMPORALIMAGEN;
        $this->configuracolor = "bitonal";
        touch($this->rutatemporal);
        chmod($this->rutatemporal, 0775);
        $this->debug = 0;
    }

    /**
     * Define cadena de configuracion de color
     * bitonal,color,grises
     *
     * @param String configuracolor cadena de configuracion
     * @return nada
     */
    function setConfiguracolor($configuracolor) {
        $this->configuracolor = $configuracolor;
    }

    /**
     * Calculate new image dimensions to new constraints
     *
     * @param Original X size in pixels
     * @param Original Y size in pixels
     * @return New X maximum size in pixels
     * @return New Y maximum size in pixels
     */
    function scaleImage($x, $y, $cx, $cy) {
        //Set the default NEW values to be the old, in case it doesn't even need scaling
        list($nx, $ny) = array($x, $y);

        //If image is generally smaller, don't even bother
        if ($x >= $cx || $y >= $cx) {

            //Work out ratios
            if ($x > 0)
                $rx = $cx / $x;
            if ($y > 0)
                $ry = $cy / $y;

            //Use the lowest ratio, to ensure we don't go over the wanted image size
            if ($rx > $ry) {
                $r = $ry;
            } else {
                $r = $rx;
            }

            //Calculate the new size based on the chosen ratio
            $nx = intval($x * $r);
            $ny = intval($y * $r);
        }

        //Return the results
        return array($nx, $ny);
    }

    /**
     * @brief Ruta destino
     * 
     * Define ruta destino
     * 
     * @param string $rutadestino ruta final imagen         * 
     * @return Nada
     */
    public function setRutaDestino($rutadestino) {
        $this->rutadestino = $rutadestino;
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
     * @brief Rota imagen en sesion 90 grados derecha
     * 
     * Ejecuta rotacion image magick de 90 grados al
     * sentido de las manesillas del reloj
     * 
     * @return Nada
     */
    public function rota90Derecha() {
        $this->objimagick->rotateImage(new ImagickPixel('none'), 90);
        $this->objimagick->writeImage($this->rutaimagen);
        $this->objimagick->clear();
        $this->objimagick->destroy();
    }

    /**
     * @brief Obtiene informacion si la imagen es blanca
     * 
     * Obtiene informacion de la imagen para saber si la imagen 
     * es blanca, filtrando los bordes y obteniendo la desviación estandar
     * de los pixeles.
     * 
     * @return bool Indicador si es no blanca
     */
    function esPaginaBlanca() {

        $gravity = Imagick::GRAVITY_CENTER;
        $this->objimagick->setImageGravity($gravity);
        $withfincrop = round($this->objimagick->getImageWidth() * 0.95);
        $heightfincrop = round($this->objimagick->getImageHeight() * 0.95);
        $withinicrop = round($this->objimagick->getImageWidth() * 0.05);
        $heightinicrop = round($this->objimagick->getImageHeight() * 0.05);
        $this->objimagick->cropImage($withfincrop, $heightfincrop, $withinicrop, $heightinicrop);
        $this->objimagick->writeImage($this->rutaimagen . "_cut.jpg");
        $img = new Imagick($this->rutaimagen . "_cut.jpg");
        $dataimage = $img->getImageChannelMean(Imagick::CHANNEL_DEFAULT);
        unlink($this->rutaimagen . "_cut.jpg");

        if ($dataimage["standardDeviation"] < 1000) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @brief Crear imagen temporal de imagen en sesion
     * 
     * Crear vista preliminar de imagen en sesion
     * 
     * @return string ruta de imagen temporal
     */
    function crearJpgTemporal() {

        $this->objimagick->setImageFormat("jpg");
        $this->objimagick->writeImage($this->rutatemporal);

        $imagentemporal = $this->rutatemporal;
        return $imagentemporal;
    }

    /**
     * @brief Crear thumbnail de imagen en sesion
     * 
     * Crear vista preliminar de imagen en sesion
     * 
     * @param ControladorCurlRest $objcurlrest Objeto control curl
     * @return Nada
     */
    public function creaThumbnail($tamano = 150) {
        if ($this->debug) {
            echo "RUTA:" . $this->rutaimagen . " IMAGEN:" . $this->dirimagen . "/thumbnail/thumb" . $this->nombreimagen . ".png";
        }

        list($newX, $newY) = $this->scaleImage(
                $this->objimagick->getImageWidth(), $this->objimagick->getImageHeight(), $tamano, $tamano);

        $this->objimagick->thumbnailImage($newX, $newY);
        $this->objimagick->setImageFormat("png");
        $this->objimagick->writeImage($this->rutadestino);
    }

    /**
     * @brief Compresion tif de imagenes bitonales
     * 
     * Compresion tif de imagenes bitonales
     * 
     * @return Nada
     */
    public function comprimeTif() {
        // COMPRESSION_GROUP4
        // COMPRESSION_LZW
        $compression_type = Imagick::COMPRESSION_GROUP4;
        $this->objimagick->setImageCompression($compression_type);
        $this->objimagick->setImageFormat("tiff");
        $this->objimagick->writeImage($this->rutadestino);
    }

    /**
     * @brief Compresion tif de imagenes a color
     * 
     * Compresion tif de imagenes a color
     * 
     * @return Nada
     */
    public function comprimeTifColor() {
        $compression_type = Imagick::COMPRESSION_JPEG;
        $this->objimagick->setImageCompression($compression_type);
        $this->objimagick->setImageFormat("tiff");
        $this->objimagick->writeImage($this->rutadestino);
    }

    /**
     * @brief Compresion tif de imagenes a color
     * 
     * Compresion tif de imagenes a color
     * 
     * @return Nada
     */
    public function convertirTif() {
       // $imagencolors = $this->objimagick->getImageColors();
        if ($this->configuracolor == "bitonal") {
            $this->comprimeTif();            
        } else {
           $this->comprimeTifColor();
        }
    }

    /**
     * @brief Compresion jpg de imagenes a color
     * 
     * Compresion jpg de imagenes a color
     * 
     * @return Nada
     */
    public function comprimeJPG() {
        $compression_type = Imagick::COMPRESSION_JPEG;
        $this->objimagick->setImageCompression($compression_type);
        $this->objimagick->setImageFormat("jpg");
        $this->objimagick->writeimages($this->rutadestino, false);
    }

    /**
     * @brief Compresion jpg de imagenes a color
     * 
     * Compresion jpg de imagenes a color
     * 
     * @return Nada
     */
    public function comprimePNG() {
        //$compression_type = Imagick::COMPRESSION_JPEG;
        //$this->objimagick->setImageCompression($compression_type);
        $this->objimagick->setImageFormat("png");
        $this->objimagick->writeimages($this->rutadestino, false);
    }

}
