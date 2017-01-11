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

function rotarImagen(obj) {
    // alert("Rotar imagen " + obj.value);
    /*  $('#img1').click(function () {
     alert("Rotar imagen " );
     });*/
    var urlEdicionImagen = "../../satelite/controlador/controlEdicionImagen.php?iimagen=" + obj.value + "&accion=rotarimagen";

    $.ajax({url: urlEdicionImagen, success: function (result) {
            // var obj = jQuery.parseJSON(result);
            if (result == "Ok") {
                // alert("Rotado");
                var objimagen = document.getElementById("imgsrc" + obj.value);
                objimagen.src = '';
                var aleatorio = Math.random() * 10000;

                objimagen.src = "../../satelite/controlador/mostrarImagen.php?idimagen=" + obj.value + "&" + aleatorio;

            }
        }});
}

function separarImagen(obj) {
    // alert("Rotar imagen " + obj.value);
    /*  $('#img1').click(function () {
     alert("Rotar imagen " );
     });*/
    var urlEdicionImagen = "../../satelite/controlador/controlEdicionImagen.php?iimagen=" + obj.value + "&accion=separar";

    $.ajax({url: urlEdicionImagen, success: function (result) {
            var objres = jQuery.parseJSON(result);
            if (objres.resultado == "Ok") {
                // alert("Rotado");
                var objimagen = document.getElementById("separaimagen" + obj.value);
                objimagen.src = '';
                var aleatorio = Math.random() * 10000;
                if (objres.estado == "1") {
                    objimagen.src = "imagenes/link-broken_red.png";
                } else {
                    objimagen.src = "imagenes/link.png";
                }
            }
        }});
}

function verImagen(obj, vimagen) {
    $('#myModal').modal();
    var aleatorio = Math.random() * 10000;
    var urlEdicionImagen = "../../satelite/controlador/controlEdicionImagen.php?iimagen=" + vimagen + "&accion=creartemporal";
    $.ajax({url: urlEdicionImagen, success: function (result) {

            if (result == "Ok") {
                var imgTmp = "../../satelite/controlador/mostrarImagenTmp.php?" + aleatorio;
                var objimagen = document.getElementById("imagenModal");
                objimagen.src = imgTmp;
            }
        }});



}