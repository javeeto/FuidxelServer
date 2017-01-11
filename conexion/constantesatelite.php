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
 * Descripcion del codigo de constantesatelite
 * 
 * @file constantesatelite.php
 * @author Javier Lopez Martinez
 * @date 29/09/2016
 * @brief Contiene ...
 */
define("IPSERVIDORPRINCIPAL", "localhost");
define("RUTALLAMADASERVIDOR", "clientedigitaliza/vista/gestiondigitaliza.php");
define("RUTASESIONSERVIDOR", "srvrestdigitaliza/controlador/controlSesionDigitaliza.php");
define("RUTASESIONSERVIDOR", "srvrestdigitaliza/controlador/controlSesionDigitaliza.php");
define("RUTASERVICIOS", "srvrestdigitaliza");
define("PROTOCOLOSERVIDOR", "http");
define("USUARIOSERVICIOREST", "satelite");
define("CLAVESERVICIOREST", "sat01");
define("AUTENTICASERVICIOREST", true);
define("MITYPEIMAGENORIGEN","image/x-ms-bmp");
define("MITYPEIMAGENDESTINO","image/tiff");
define("EXTENSIONARCHIVOORIGEN","bmp");
define("EXTENSIONARCHIVODESTINO","tiff");
define("EXTENSIONARCHIVOTHUMB","png");
define("RUTABACKUPLOCAL","/srv/digitalizacion/backupimagenes");
define("EJECUCIONESCANEO", 'C:\Users\Javeeto\Documents\Tesis\Codigo\python\ejecucionEscaner.py');
define("ARCHIVOEJECUTAESCANER", '/tmp/procesoescaneo.txt');
//define("RUTATEMPORALIMAGEN","C:/tmp/imagenpngtmp.jpg");
define("RUTATEMPORALIMAGEN","/tmp/imagenjpgtmp.jpg");
define("RUTACARGUETMP","../../cargue/");
define("RUTASEPARADOR","../../satelite/vista/imagenes/whitepage.tiff");
define("RUTASEPARADORTHUMBNAIL","../../satelite/vista/imagenes/whitepagethumb.png");
