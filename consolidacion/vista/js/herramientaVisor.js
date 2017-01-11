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
$(document).ready(function () {
    verImagen(0);

    $("#menuImagen").change(function () {
        verImagen($("option:selected", this).val());
    });

    $("#siguienteImagen").click(function () {
        var objimagen = document.getElementById("imagenactual");
        var objtotal = document.getElementById("totalimagen");
        var imagen = objimagen.value * 1;
        var total = objtotal.value * 1;
        if (total > (imagen + 1)) {

            objimagen.value = imagen + 1;
            $("#menuImagen").val(objimagen.value);
            verImagen(objimagen.value);
        }
    });

    $("#anteriorImagen").click(function () {
        var objimagen = document.getElementById("imagenactual");
        var imagen = objimagen.value * 1;

        if (0 <= (imagen - 1)) {
            objimagen.value = imagen - 1;
            $("#menuImagen").val(objimagen.value);
            verImagen(objimagen.value);
        }
    });


    $("#menuDoc").change(function () {
        verDoc($("option:selected", this).val());
    });

    $("#siguienteDoc").click(function () {
        var docactual = $("option:selected", $("#menuDoc")).val();
        var doctotal = $("#menuDoc option").length;
        
        var documento = docactual * 1;
        var total = doctotal * 1;
        
       // alert("Documento:"+documento+" total:"+total);
        if (total > (documento + 1)) {
         
            $("#menuDoc").val((documento + 1));           
            verDoc((documento + 1));
        }
    });

    $("#anteriorDoc").click(function () {
        var docactual = $("option:selected", $("#menuDoc")).val();
        var doctotal = $("#menuDoc option").length;
        var documento = docactual * 1;
        var total = doctotal * 1;
       // alert("Documento:"+documento+" total:"+total);
        if (0 <= (documento - 1)) {
         
            $("#menuDoc").val((documento - 1));           
            verDoc((documento - 1));
        }
    });

});

function verImagen(vimagen) {
    $('#myModal').modal();
    var aleatorio = Math.random() * 10000;
    var urlEdicionImagen = "../../consolidacion/controlador/controlEdicionImagen.php?iimagen=" + vimagen + "&accion=creartemporal";
    $.ajax({url: urlEdicionImagen, success: function (result) {

            if (result == "Ok") {
                var imgTmp = "../../satelite/controlador/mostrarImagenTmp.php?" + aleatorio;
                var objimagen = document.getElementById("imagenModal");
                objimagen.src = imgTmp;
            }
        }});


}

function verDoc(vdoc) {
    var iloteimagen = document.getElementById("idlote");
    $(location).attr('href', 'formaindexaimagen.php?idocumento=' + vdoc + '&idloteimagen=' + iloteimagen.value);
}



