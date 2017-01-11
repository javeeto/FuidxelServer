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
 * Descripcion del codigo de EjFormMetadato
 * 
 * @file EjFormMetadato.php
 * @author Javier Lopez Martinez
 * @date 14/11/2016
 * @brief Contiene ...
 */
session_start();
$s_idformulario = 2;
$s_iddetalledocumento=1;
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1"> 
        <meta  charset="ISO-8859-1">
        <?php require_once '../../plantilla/vista/encabezado.php'; ?>

        <link rel="stylesheet" href="../../plantilla/vista/css/estiloplantilla.css" type="text/css">
    </head>
    <body>
        <?php require_once '../../plantilla/vista/menu.php'; ?>
        <div class="container">
            <h2>Indexacion</h2>
            <?php require_once '../../libreria/general/vista/FormularioMetadato.php'; ?>
        </div>
        <?php require_once '../../plantilla/vista/piepagina.php'; ?>
    </body>
</html>