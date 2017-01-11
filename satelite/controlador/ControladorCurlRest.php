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
 * Descripcion del codigo de ControladorCurlRest
 * 
 * @file ControladorCurlRest.php
 * @author Javier Lopez Martinez
 * @date 29/09/2016
 * @brief Contiene ...
 */
class ControladorCurlRest {

    /**
     * recurso de conexion curl
     *
     * @var Recurso
     */
    private $conexiocurl;

    /**
     * url de pagina a llamar
     *
     * @var String
     */
    private $url;

    /**
     * @brief Inicializacion de conexion curl
     * 
     * Iniciacion de conexion de curl 
     * 
     * @param url de pagina a llamar
     * @return Nada
     */
    public function __construct($url) {
        if (!isset($_SESSION["s_cookie"])) {
            $cookie_jar = tempnam('/tmp', 'cookie');
            $_SESSION["s_cookie"] = $cookie_jar;
        }
        $this->conexiocurl = curl_init($url);
        $this->url = $url;
        
    }

    /**
     * @brief Inicializacion de conexion curl
     * 
     * Iniciacion de conexion de curl 
     * 
     * @param url de pagina a llamar
     * @return salida Respouesta del cuerpo de la pagina
     */
    public function obtenerRespuesta($postparametros = array()) {
        if (AUTENTICASERVICIOREST) {
            curl_setopt($this->conexiocurl, CURLOPT_USERPWD, USUARIOSERVICIOREST . ":" . CLAVESERVICIOREST);
        }
        curl_setopt($this->conexiocurl, CURLOPT_COOKIEJAR, $_SESSION["s_cookie"]);
        curl_setopt($this->conexiocurl, CURLOPT_COOKIEFILE, $_SESSION["s_cookie"]);
        curl_setopt($this->conexiocurl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($this->conexiocurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->conexiocurl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->conexiocurl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($this->conexiocurl, CURLOPT_POST, 1);
        curl_setopt($this->conexiocurl, CURLOPT_POSTFIELDS, http_build_query($postparametros));
        curl_setopt($this->conexiocurl, CURLINFO_HEADER_OUT, true);
        $salida = curl_exec($this->conexiocurl);
        
        //echo "URL=".$url;
        return $salida;
    }

    /**
     * @brief Inicializacion de conexion curl
     * 
     * Iniciacion de conexion de curl 
     * 
     * @param url de pagina a llamar
     * @return salida Respouesta del cuerpo de la pagina
     */
    public function obtenerEncabezado() {
        $encabezado = curl_getinfo($this->conexiocurl, CURLINFO_HEADER_OUT);

        return $encabezado;
    }

    /**
     * @brief Inicializacion de conexion curl
     * 
     * Iniciacion de conexion de curl 
     * 
     * @param url de pagina a llamar
     * @return salida Respouesta del cuerpo de la pagina
     */
    public function obtenerTipoContenido() {
        $content_type = curl_getinfo($this->conexiocurl, CURLINFO_CONTENT_TYPE);
    }

    /**
     * @brief Inicializacion de conexion curl
     * 
     * Iniciacion de conexion de curl 
     * 
     * @param url de pagina a llamar
     * @return salida Respouesta del cuerpo de la pagina
     */
    public function cerrarConexion() {
        curl_close($this->conexiocurl);
    }

}
