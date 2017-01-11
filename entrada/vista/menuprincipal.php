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
 * Descripcion del codigo de menuprincipal
 * 
 * @file menuprincipal.php
 * @author Javier Lopez Martinez
 * @date 15/09/2016
 * @brief Contiene ...
 */
require_once '../../conexion/idioma/entrada.php';
require_once '../controlador/controlMenuOpcion.php';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?php require_once '../../plantilla/vista/encabezado.php'; ?>
        <link rel="stylesheet" href="../../plantilla/vista/estiloplantilla.css" type="text/css">
    </head>
    <body>
        <?php require_once '../../plantilla/vista/menu.php'; ?>
        <div class="container">
            <h3>FuidXel </h3>
            <p>Herramienta de apoyo de gesti&oacute;n documental para las organizaciones.</p>
        </div>
        <?php require_once '../../plantilla/vista/piepagina.php'; ?>
    </body>
</html>