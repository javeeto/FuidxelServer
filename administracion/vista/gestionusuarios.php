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
 * Descripcion del codigo de gestionusuarios
 * 
 * @file gestionusuarios.php
 * @author Javier Lopez Martinez
 * @date 16/09/2016
 * @brief Contiene ...
 */
require_once '../../administracion/controlador/controlGestionUsuario.php';
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
        <script src="../../administracion/vista/js/tablaGestionUsuario.js"></script> 
    </head>
    <body>
        <?php require_once '../../plantilla/vista/menu.php'; ?>
        <div class="container">
            <h2>Gestion Usuario</h2>
            <ul class="nav nav-pills">
                <li class="active"><a data-toggle="pill" href="#formulario">Formulario</a></li>
                <li><a data-toggle="pill" href="#listado">Listado</a></li>
            </ul>
            <div class="tab-content">
                <div id="formulario" class="tab-pane fade in active">

                    <?php if ($error) { ?>
                        <div class="alert alert-danger">
                            <strong>!</strong> <?= $mensajerror ?>
                        </div>
                    <?php } ?>
                    <?php if ($exitoso) { ?>
                        <div class="alert alert-success">
                            <strong>!</strong> <?= $mensajerror ?>
                        </div>
                    <?php } ?>

                    <form class="form-horizontal" method="post">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Datos Generales</div>
                            <div class="panel-body">

                                <?php for ($i = 0; $i < count($panelGeneral["errorHtml"]); $i++) { ?>

                                    <div class="form-group <?= $panelGeneral["errorHtml"][$i] ?>">
                                        <?= $panelGeneral["campoHtml"][$i] ?>
                                    </div>

                                <?php } ?>

                            </div>
                        </div>

                        <div class="panel panel-primary">
                            <div class="panel-heading">Datos de Usuario</div>
                            <div class="panel-body">

                                <?php for ($i = 0; $i < count($panelUsuario["errorHtml"]); $i++) { ?>

                                    <div class="form-group <?= $panelUsuario["errorHtml"][$i] ?>">
                                        <?= $panelUsuario["campoHtml"][$i] ?>
                                    </div>

                                <?php } ?>

                            </div>
                        </div>
                        <div class="form-group">        
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" name="Enviar" id="Enviar" class="btn btn-default" value="1">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="listado" class="tab-pane fade ">
                    <table id="tablaUsuario" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Usuario</th>
                                <th>Nombre</th>
                                <th>Perfil</th>
                                <th>Grupo</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Usuario</th>
                                <th>Nombre</th>
                                <th>Perfil</th>
                                <th>Grupo</th>
                                <th>Estado</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
        <?php require_once '../../plantilla/vista/piepagina.php'; ?>
    </body>
</html>