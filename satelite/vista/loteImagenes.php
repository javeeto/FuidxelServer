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
 * Descripcion del codigo de listaImagenes
 * 
 * @file listaImagenes.php
 * @author Javier Lopez Martinez
 * @date 30/09/2016
 * @brief Contiene ...
 */
require_once '../../satelite/controlador/controlMostrarImagenes.php';
?>
<?php 
if (is_array($arregloSrc)) {
    foreach ($arregloSrc as $i => $srcImagen) {
        ?>
            <div class="col-md-3 thumbnail" >
                
                    <p>
                        <b><?= ($i + 1) ?></b>
                        
                        <input type="checkbox" id="chkimage<?= ($i) ?>" name="chkimage<?= ($i) ?>" value="<?= $i ?>"/>               
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="image" value="<?= $i ?>" onclick="rotarImagen(this);" id="rotaimagen<?= $i ?>" name="rotaimagen<?= ($i + 1) ?>" value="<?= ($i + 1) ?>" src="imagenes/button-rotate-cw.png"  data-toggle="tooltip" data-placement="button" title="Rotar Imagen" style="width:30px; height:30px; cursor:pointer;" >                
                        <input type="image" value="<?= $i ?>" onclick="separarImagen(this);" id="separaimagen<?= $i ?>" name="separaimagen<?= ($i + 1) ?>" value="<?= ($i + 1) ?>" src="<?= ($separaImg[$i]) ?>" data-toggle="tooltip" data-placement="bottom" title="Definir como separador" style="width:30px;height:30px; cursor:pointer;">
                       <!--<input type="image" id="borraimagen" name="borraimagen" value="<?= ($i + 1) ?>" src="imagenes/button-cross.png" data-toggle="tooltip" data-placement="bottom" title="Borrar imagen"  style="width:30px;height:30px; cursor:pointer;">                -->
                    </p>

                <a href="#img<?= ($i + 1) ?>" id="img<?= $i ?>" onclick="verImagen(this,'<?= $i ?>');" >    
                    <img src="<?= $srcImagen ?>"  id="imgsrc<?= $i ?>" alt="Imagen <?= ($i + 1) ?>" style="width:180px;height:230px">
                </a>
            </div>
    <?php }
}
?>