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
 * Descripcion del codigo de exploradir
 * 
 * @file exploradir.php
 * @author Javier Lopez Martinez
 * @date 27/10/2016
 * @brief Contiene ...
 */
$archivos=  scandir("/mnt/digitalizacion/lotes/220");
echo "archivos<pre>";
print_r($archivos);
echo "<pre>";
