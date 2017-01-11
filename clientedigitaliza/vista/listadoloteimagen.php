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
 * Descripcion del codigo de listadoloteimagen
 * 
 * @file listadoloteimagen.php
 * @author Javier Lopez Martinez
 * @date 24/10/2016
 * @brief Contiene ...
 */
//require_once '../../administracion/controlador/controlGestionUsuario.php';
session_start();
?>
<!DOCTYPE html>
<html lang="es" >
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1"> 
        <meta  charset="ISO-8859-1">
        <?php require_once '../../plantilla/vista/encabezado.php'; ?>
        <link rel="stylesheet" href="../../plantilla/vista/css/estiloplantilla.css" type="text/css">
        <script src="../../libreria/general/vista/DataTables/media/js/jquery.dataTables.js"></script>
        <link rel="stylesheet" href="../../libreria/general/vista/DataTables/media/css/jquery.dataTables.css" type="text/css">
        <script src="../../clientedigitaliza/vista/js/tablaListaLote.js"></script> 
    </head>
    <body>
        <?php require_once '../../plantilla/vista/menu.php'; ?>
        <div class="container">
            <h2>Lista Lotes</h2>
            <ul class="nav nav-pills">
                <li class="active"><a data-toggle="pill" href="#listado">Listado</a></li>
            </ul>
            <div class="tab-content">
                <div id="listado" class="tab-pane fade in active">
                    <table id="tablaLote" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Fecha creaci&oacute;n</th>
                                <th>Imagenes</th>
                                <th>Documentos</th>
                                <th>Estado</th>
                                <th>Grupo</th>
                                <th>Usuario</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Fecha creaci&oacute;n</th>
                                <th>Imagenes</th>
                                <th>Documentos</th>
                                <th>Estado</th>
                                <th>Grupo</th>
                                <th>Usuario</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
        <?php require_once '../../plantilla/vista/piepagina.php'; ?>
    </body>
</html>
