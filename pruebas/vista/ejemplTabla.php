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
 * Descripcion del codigo de ejemplTabla
 * 
 * @file ejemplTabla.php
 * @author Javier Lopez Martinez
 * @date 23/09/2016
 * @brief Contiene ...
 */
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?php require_once '../../plantilla/vista/encabezado.php'; ?>
        <link rel="stylesheet" href="../../plantilla/vista/estiloplantilla.css" type="text/css">
        <script src="../../libreria/general/vista/DataTables/media/js/jquery.dataTables.js"></script>
        <link rel="stylesheet" href="../../libreria/general/vista/DataTables/media/css/jquery.dataTables.css" type="text/css">
        <script src="tablaejemplo.js"></script>
    </head>
    <body>
        <?php require_once '../../plantilla/vista/menu.php'; ?>
        <div class="container">



            <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Office</th>
                        <th>Extn.</th>
                        <th>Start date</th>
                        <th>Salary</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Office</th>
                        <th>Extn.</th>
                        <th>Start date</th>
                        <th>Salary</th>
                    </tr>
                </tfoot>
            </table>

        </div>
        <?php require_once '../../plantilla/vista/piepagina.php'; ?>
    </body>
</html>