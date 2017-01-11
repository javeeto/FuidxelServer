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
 * Funciones de ejecución de escaneo
 * 
 * @file digitalizacion.php
 * @author Javier Lopez Martinez
 * @date 27/09/2016
 * @brief Contiene ...
 */

var conversionTerminado = false;
var creolote = false;
var numeroimgs = 0;

/**
 * @brief Ejecucion de eventos despues de carga de pagina
 * 
 * Despues que la pagina este cargada 
 * se ejecutan los eventos de las ejecuciones
 * 
 * @param url de pagina a llamar
 * @return Nada
 */
$(document).ready(function () {
    /**
     * Si lote esta definido se muestran imagenes correspondientes
     * @type Integer
     */
    var idlote = document.getElementById("lote").value;
    if (idlote != '0') {
        mostrarImagenLote(idlote,0);
    }

    /*
     * Tooltip mensajes emergentes de botones
     */
    $('[data-toggle="tooltip"]').tooltip();

    /**
     * @brief Evento de transferencia de imagenes
     * 
     * Al ejecutar boton correspondiente se realiza
     * el llamado a funcionalidad de transferencia
     * controlLoteImagenes via AJAX 
     * 
     * @return Nada
     */
    $("#transferir").click(function () {
        if (confirm("Desea transferir imagenes digitalizadas?")) {
            var idlote = document.getElementById("lote").value;
            var aleatorio = Math.random() * 10000;
            var urlTransferirLote = "../../satelite/controlador/controlLoteImagenes.php?idloteimagen="+idlote+"&accion=transferirlote&" + aleatorio;
            $.ajax({url: urlTransferirLote, success: function (result) {
                    var obj = jQuery.parseJSON(result);
                    if (obj.resultado == "Ok") {
                        alert("Transferidas " + obj.totalimagenes + " imagenes");
                    } else {
                        alert(obj.error);
                    }
                }});
        }

    });

    /**
     * @brief Inserción de imagenes de separación
     * 
     * Se insertan separaciones despues de
     * imagenes seleccionadas con la caja de chequeo
     * 
     * @return Nada
     */
    $("#separaImagen").click(function () {
        var aleatorio = Math.random() * 10000;
        
        var urlSeparaLote = "../../satelite/controlador/controlEdicionImagen.php?accion=separamasivo&" + aleatorio;
        if (confirm("Desea generar imagenes de separacion?")) {

            var datosepara = "";


            var imagenCheck = document.getElementById("chkimage0");

            var i = 0;
            var imagenCheck2 = document.getElementById("chkimage" + i.toString());
           // alert("imagenCheck=" + imagenCheck);


            while (imagenCheck2 != null) {
                if (i > 0) {
                    //alert("chkimage" + i.toString());
                    imagenCheck = document.getElementById("chkimage" + i.toString());
                }
                if (imagenCheck.checked) {
                    datosepara += i + ",";
                }

                i++;
                imagenCheck2 = document.getElementById("chkimage" + i.toString());
            }

           // alert("datosepara=" + datosepara);
            $.ajax({url: urlSeparaLote, type: "post", data: "separador=" + datosepara, success: function (resSepara) {
                    //alert(resSepara);

                    var objSepara = jQuery.parseJSON(resSepara);
					idlote = document.getElementById("lote").value;

                    if (objSepara.resultado == "Ok") {
                        if (idlote != '0') {
                            mostrarImagenLote(idlote,1);
                        }
                        alert(objSepara.error);
                    } else {
                        alert(objSepara.error);
                    }
                }});

        }
    });

    /**
     * @brief Inicio de ejecución de escaneo 
     * 
     * Inicia ventana modal de formulario
     * de acta de inicio al cerrar la ventana
     * se inicia funcion continuaEscaneo
     * 
     * @return Nada
     */
    $("#ejecutaEscaneo").click(function () {
        var aleatorio = Math.random() * 10000;
        var confactual = $("option:selected", $("#menuConfiguracion")).val();
        
        //var urlConversion = "../../satelite/controlador/controlLoteImagenes.php?accion=consultaescaner&" + aleatorio;
        //var urlMostrarImagen = "../../satelite/vista/loteImagenes.php";
        //var urlEjecutaEscaneo = "../../satelite/controlador/controlLoteImagenes.php?accion=ejecutaescaneo&" + aleatorio;
        var urlNuevoLote = "../../satelite/controlador/controlLoteImagenes.php?configura="+confactual+"&accion=nuevolote&" + aleatorio;

        conversionTerminado = false;
        creolote = false;
        numeroimgs = 0;

        if (confirm("Desea crear un nuevo lote y ejecutar escaneo?")) {

            $.ajax({url: urlNuevoLote, success: function (resultN) {
                    $("#formaimagenes").html("");
                    var objNLote = jQuery.parseJSON(resultN);

                    if (objNLote.resultado == "Ok") {
                        var urlServerActa = "http://" + objNLote.servidor + "/fuixel/clientedigitaliza/vista/actainicioalmacena.php?idlote=" + objNLote.idlote + "&idconfiguracion=" + confactual;
                        // alert(urlServerActa);
						document.getElementById("lote").value = objNLote.idlote;

                        $('#modalFrame').modal();
                        var objframe = document.getElementById("frameacta");
                        objframe.src = '';
                        objframe.src = urlServerActa;
                        // $("#frameacta").src = urlServerActa;
                        // exit();
                    } else {

                    }
                }});

        }

    });
});

/**
 * @brief Inicio de ejecución de escaneo 
 * 
 * Inicia ventana modal de formulario
 * de acta de inicio, al cerrar la ventana
 * se inicia funcion continuaEscaneo
 * 
 * @return Nada
 */
function conversionImagen() {
    var aleatorio = Math.random() * 10000;
    var confactual = $("option:selected", $("#menuConfiguracion")).val();
    var urlConversion = "../../satelite/controlador/controlLoteImagenes.php?configura="+confactual+"&accion=consultaescaner&" + aleatorio;
    $.ajax({url: urlConversion, success: function (result) {


            var obj = jQuery.parseJSON(result);
            var i = 0;
            var imagenHtml = "";
            if (obj.resultado == "OK") {
                if (!creolote) {
                    $("#nolote").html("Lote #" + obj.idlote);
                    document.getElementById("lote").value = obj.idlote;
                    creolote = true;
                }
                mostrarImagen();
            }
            numeroimgs += obj.imgsconversion;

            if (obj.estadoproceso == "0" || obj.existenimagenes == "1" || numeroimgs < obj.totalimagenes) {
                //  alert("Imagenes Escaneadas: " + obj.totalimagenes + " Convertidas=" + numeroimgs);
                var salidaConversion = setTimeout(conversionImagen, 1000);


            }

            if (obj.estadoproceso == "1" && obj.existenimagenes == "0" && numeroimgs >= obj.totalimagenes) {
                conversionTerminado = true;
                alert("Escaneo finalizado\n Imagenes Escaneadas: " + obj.totalimagenes + " Convertidas=" + numeroimgs);
                $("#divinfo").html("<p>Finalizado</p>Imagenes=" + obj.totalimagenes);

            }

        }});
}

/**
 * @brief Imprime imagenes en marco principal
 * 
 * Obtiene html de lista de imagenes de lote
 * de acta de inicio, al cerrar la ventana
 * se inicia funcion continuaEscaneo
 * 
 * @return Nada
 */
function mostrarImagen() {
    var aleatorio = Math.random() * 10000;
    var urlMostrarImagen = "../../satelite/vista/loteImagenes.php?&" + aleatorio;
    $.ajax({url: urlMostrarImagen, success: function (resultM) {
            var formaHtml = $("#formaimagenes").html() + resultM;
            $("#formaimagenes").html(formaHtml);
        }});
}

function mostrarImagenLote(idlote,reinicio) {
    var aleatorio = Math.random() * 10000;
    var urlMostrarImagen = "../../satelite/vista/loteImagenes.php?reinicio=" + reinicio + "&idlote=" + idlote + "&" + aleatorio;
    $.ajax({url: urlMostrarImagen, success: function (resultM) {
            var formaHtml = resultM;
			$("#formaimagenes").html("");
            $("#formaimagenes").html(formaHtml);
        }});
}

function continuaEscaneo() {
    var aleatorio = Math.random() * 10000;
     var confactual = $("option:selected", $("#menuConfiguracion")).val();
    var urlConversion = "../../satelite/controlador/controlLoteImagenes.php?configura="+confactual+"&accion=consultaescaner&" + aleatorio;
    var urlMostrarImagen = "../../satelite/vista/loteImagenes.php";
    var urlEjecutaEscaneo = "../../satelite/controlador/controlLoteImagenes.php?configura="+confactual+"&accion=ejecutaescaneo&" + aleatorio;
    var urlNuevoLote = "../../satelite/controlador/controlLoteImagenes.php?configura="+confactual+"&accion=nuevolote&" + aleatorio;

    conversionTerminado = false;
    creolote = false;
    numeroimgs = 0;

    alert("Inicia proceso de escaneo");
    $("#divinfo").html("<p>Cargando...</p><img src='imagenes/gears.svg'>");
	
	    $.ajax({url: urlConversion, success: function (result) {

            var obj = jQuery.parseJSON(result);
            var i = 0;
            var imagenHtml = "";
            if (obj.resultado == "OK") {
                $("#nolote").html("Lote #" + obj.idlote);
                document.getElementById("lote").value = obj.idlote;
                creolote = true;
                mostrarImagen();
            }
            numeroimgs += obj.imgsconversion;
            // alert("Imagenes Escaneadas 0: " + obj.totalimagenes + " Convertidas=" + numeroimgs);
            $("#divinfo").html("<p>Cargando...</p><img src='imagenes/gears.svg'>");


            if (obj.estadoproceso === "0" || obj.existenimagenes === "1" || numeroimgs < obj.totalimagenes) {
                // alert("Imagenes Escaneadas 1: " + obj.totalimagenes + " Convertidas=" + numeroimgs);
                var salidaConversion = setTimeout(conversionImagen, 1000);
                // alert("Imagenes Escaneadas 2: " + obj.totalimagenes + " Convertidas=" + numeroimgs);
            }

            if (obj.estadoproceso === "1" && obj.existenimagenes === "0" && numeroimgs >= obj.totalimagenes) {
                conversionTerminado = true;
                alert("Escaneo finalizado\n Imagenes Escaneadas: " + obj.totalimagenes + " Convertidas=" + numeroimgs);
                $("#divinfo").html("<p>Finalizado</p>Imagenes=" + obj.totalimagenes);
				document.getElementById("lote").value = obj.idlote;
            }

        }});
	
	
    $.ajax({url: urlEjecutaEscaneo, success: function (resultE) {
		
            if (resultE == "OK") {
                //alert("Escaneo realizado correctamente");
            }
        }});

}
