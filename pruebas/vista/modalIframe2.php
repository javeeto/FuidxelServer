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
 * Descripcion del codigo de modalIframe
 * 
 * @file modalIframe.php
 * @author Javier Lopez Martinez
 * @date 26/09/2016
 * @brief Contiene ...
 */
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?php require_once '../../plantilla/vista/encabezado.php'; ?>
        <link rel="stylesheet" href="../../plantilla/vista/css/estiloplantilla.css" type="text/css">
        <script src="js/modalejemplo.js"></script>


    </head>
    <body>
        <?php require_once '../../plantilla/vista/menu.php'; ?>
        <div class="container-fluid text-center">

            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="http://localhost/AppDigi/index.php" allowfullscreen=""></iframe>
            </div>

        </div>

        <?php require_once '../../plantilla/vista/piepagina.php'; ?>
    </body>
</html>