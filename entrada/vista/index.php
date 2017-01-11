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
 * Descripcion del codigo de index
 * 
 * @file index.php
 * @author Javier Lopez Martinez
 * @date 13/09/2016
 * @brief Contiene clase para definir opciones de escaneo 
 */
require_once '../../conexion/idioma/entrada.php';
require_once '../controlador/controlEntrada.php';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?php require_once '../../plantilla/vista/encabezado.php'; ?>
        <script type="text/javascript" src="js/validacion.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="jumbotron">
                <h1><?= ENTRADA_TITULOAPP ?></h1>   
                <h2><?= ENTRADA_INGRESO ?></h2>
                <?php if ($error) { ?>
                    <div class="alert alert-danger">
                        <strong>!</strong> <?= $mensajerror ?>
                    </div>
                <?php } ?>
                <form onsubmit="validacionForma(objForm);" method="POST">

                    <div class="form-group">
                        <label for="usuario"><?= ENTRADA_USUARIO ?>:</label>
                        <input type="text" pattern="[a-zA-Z ]*" title="Nombre de usuario con Maximo 20 Caracteres alfabeticos" maxlength="20" class="form-control" id="usuario" name="usuario" placeholder="Ingrese Usuario">
                    </div>
                    <div class="form-group">
                        <label for="clave"><?= ENTRADA_CLAVE ?>:</label>
                        <input type="password" class="form-control" name="clave" id="clave" maxlength="20" placeholder="Ingrese password">
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox"> <?= ENTRADA_RECORDARME ?></label>
                    </div>
                    <button type="submit" class="btn btn-default"><?= ENTRADA_ENVIAR ?></button>
                </form>
            </div>
        </div>

        <?php require_once '../../plantilla/vista/piepagina.php'; ?>
    </body>
</html>