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
 * Descripcion del codigo de consultaExtension
 * 
 * @file consultaExtension.php
 * @author Javier Lopez Martinez
 * @date 17/10/2016
 * @brief Contiene ...
 */
session_start();
$path=session_save_path();
$id=session_id();
touch("/tmp/ejemplo.txt");
$_SESSION["Ejemplo"]=1;
echo "_SESSION=$path,id=$id<pre>";
    print_r($_SESSION);
    echo "</pre>";

echo "_GET5<pre>";
    print_r($_GET);
    echo "</pre>";
    
    echo "_GET5<pre>";
    print_r($_SERVER);
    echo "</pre>";
    
    
$finfo=  finfo_open(FILEINFO_MIME_TYPE);
$filename="/srv/digitalizacion/lotes/192/14772815310001.tiff";
$extensiontipo=finfo_file($finfo, $filename);
finfo_close($finfo);
echo "<BR>EXTENSION=".$extensiontipo;