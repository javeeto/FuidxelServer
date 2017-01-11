<?php

//Formulario de tipo 2 columnas con etiqueta y campo en cada columna respectivamente

class FormularioBaseBk {

    private $filatmp;
    private $contcalendario = 0;
    private $seleccionmultiple;

    function etiqueta($nombre, $etiqueta, $validacion) {
        if ($this->automatico == true) {
            $td = "<td nowrap id='tdtitulogris'>";
            $td_fin = "</td>\n";
        }

        echo $td, $etiqueta;
        if ($validacion != "") {
            if ($this->metodo == 'get' or $this->metodo == 'GET') {
                $this->array_validacion[] = array('campo' => $nombre, 'valido' => $this->validacion($_GET[$nombre], $validacion), 'mensaje' => $etiqueta, 'tipo' => $validacion);
            } elseif ($this->metodo == 'post' or $this->metodo == 'POST') {
                $this->array_validacion[] = array('campo' => $nombre, 'valido' => $this->validacion($_POST[$nombre], $validacion), 'mensaje' => $etiqueta, 'tipo' => $validacion);
            }
        }
        echo $td_fin;
    }

    /**
     * Arreglo con opciones multiples seleccionadas 
     * 
     * @param array $seleccionmultiple 
     */
    function setSeleccionMultiple($seleccionmultiple) {
        $this->seleccionmultiple = $seleccionmultiple;
    }

    //crea un input con todos los parametros correspondientes
    function boton_tipo($tipo, $nombre, $valor, $funcion = "") {
        echo "<input type='$tipo' name='$nombre' id='$nombre'  value='$valor' $funcion>";
    }

    function boton_link_emergente($url, $nombrelink, $ancho, $alto, $menubar = "no", $javascript = "", $activafuncion = 1, $retorno = 0) {

        $htmlgenerado = "
		<script LANGUAGE=\"JavaScript\">\n
		function  nuevaVentanaLink(pagina,nombre,width,height){\n
		parametro=\"width=\"+width+\",height=\"+height+\",menubar=$menubar,scrollbars=yes,resizable=yes\";\n
		//alert('entro');\n
		window.open(pagina,nombre,parametro);\n

		return false;\n
		}
		</script>\n";

        if ($activafuncion)
            $funcion = "onclick=\"return nuevaVentanaLink('" . $url . "','" . $nombrelink . "'," . $ancho . "," . $alto . ");\";";
        else
            $funcion = "";
        $htmlgenerado.="<a href='$url' $javascript $funcion>$nombrelink</a>";
        if ($retorno)
            return $htmlgenerado;
        else
            echo $htmlgenerado;
    }

    function ayuda($ayuda = "") {
        if ($ayuda != "") {
            //echo "<br>AYUDA=".$ayuda." ".$this->rutaraiz."imagenes/pregunta.gif'";;
            //$globo=$this->globo($ayuda);
            $archivoayuda = $this->rutaraiz . "archivoayuda.php?ayuda=" . str_replace(" ", "_", $ayuda);
            $globo = "width='16px' height='16px' onmouseover='ajax_showTooltip(window.event,\"" . $archivoayuda . "\",this); return false' onmouseout='ajax_hideTooltip()'";
            $imagen = "<img src='" . $this->rutaraiz . "pregunta.gif'";
            echo $cadena = $imagen . $globo . "'>";
        }
    }

    //
    function campo_fecha($tipo, $nombre, $valor, $funcion = "", $ayuda = "") {
        $this->contcalendario++;
        $this->boton_tipo($tipo, $nombre, $valor, $funcion);
        $this->boton_tipo("button", "lanzador" . $this->contcalendario, "...", "");
        echo "\n<script type=\"text/javascript\">
		var cal" . $this->contcalendario . " = new Calendar.setup({
				 inputField     :    \"$nombre\",   // id of the input field
				 button         :    \"lanzador" . $this->contcalendario . "\",  // What will trigger the popup of the calendar
				//button	: \"$nombre\",
				 ifFormat       :    \"%d/%m/%Y\"       // format of the input field: Mar 18, 2005
		});
		</script>
                ";
    }

    function ventana_emergente_submit($url, $nombre, $valor, $ancho, $alto, $form = "form1", $menubar = "no") {
        echo "<script LANGUAGE=\"JavaScript\">
	function  nuevaVentana(pagina,nombre,width,height){\n
	parametro=\"width=\"+width+\",height=\"+height+\",menubar=$menubar,scrollbars=yes,resizable=yes\";\n

	window.open(pagina,nombre,parametro);\n
	target=" . $form . ".target;\n
	action=" . $form . ".action;\n

	" . $form . ".target=nombre;\n
	" . $form . ".action=pagina;\n
	" . $form . ".submit();\n
	
	" . $form . ".target=target;\n
	" . $form . ".action=action;\n
	
	}
	</script>";
        $funcion = "onclick=\"nuevaVentana('" . $url . "','" . $nombre . "'," . $ancho . "," . $alto . ")\";";
        $this->boton_tipo("button", $nombre, $valor, $funcion);
    }

    function caja_chequeo($nombre, $valor, $check = '', $mensajeconfirma = '', $funcionadicional = "") {

        $cajachequeo = "<input type='checkbox' id='$nombre' name='$nombre'  value='$valor' $funcionadicional $check>";
        echo $cajachequeo;
    }

    //Dibuja una  caja de chequeo de tipo ajax
    function cajax_chequeo($nombre, $valorsi, $valorno, $archivo, $check = '', $mensajeconfirma = '', $tipogeneracion = 1, $funcionadicional = "") {
        if ($tipogeneracion) {
            echo "<input type='checkbox'  name='$nombre'  value='$valor' onclick='$funcionadicional return botecheckbox(\"$nombre\",$valorsi,$valorno,\"$archivo\",this,\"$mensajeconfirma\");' $check>";
        } else {
            $cajachequeo = "<input type='checkbox'  name='$nombre'  value='$valor' onclick='$funcionadicional return botecheckbox(\"$nombre\",$valorsi,$valorno,\"$archivo\",this,\"$mensajeconfirma\");' $check>";
            return $cajachequeo;
        }
    }

    //Dibuja varias  cajax_chequeo de tipo ajax
    function dibujar_cajax_chequeos($arrayparametroscajax, $archivo, $tipoestilo = 'labelresaltado', $funcionadicional = "") {
        for ($i = 0; $i < count($arrayparametroscajax); $i++) {
            $enunciado = $arrayparametroscajax[$i]["enunciado"];
            $nombre = $arrayparametroscajax[$i]["nombre"];
            $valorsi = $arrayparametroscajax[$i]["valorsi"];
            $valorno = $arrayparametroscajax[$i]["valorno"];
            $check = $arrayparametroscajax[$i]["check"];
            $campo = 'cajax_chequeo';
            $parametros = "'$nombre','$valorsi','$valorno','$archivo','$check','','1','$funcionadicional'";
            $this->dibujar_campo($campo, $parametros, "$enunciado", "labelresaltado", '$nombre', '');
        }
    }

    //
    function menu_fila($nombre, $selecciona, $condicion = "", $ayuda = "", $retornacadena = 0) {
        $html = "";
        $html.= "\n<select name='$nombre' id='$nombre' $condicion>";
        foreach ($this->filatmp as $clave => $val) {
            if ($selecciona == $clave)
                $html.= "\n<option value='$clave' selected>$val</option>";
            else
                $html.= "\n<option value='$clave'>$val</option>";
        }
        $html.= "\n</select>";
        if ($retornacadena) {
            return $html;
        } else {
            echo $html;
        }
    }

    function label_fila($nombre, $selecciona, $condicion = "") {

        echo "<table width=100%><tr>";
        //while (list ($clave, $val) = each ($this->filatmp))
        foreach ($this->filatmp as $clave => $val)
            echo "<td>" . $clave . "</td>";
        echo "</tr>";

        echo "<tr>";

        $i = 0;
        foreach ($this->filatmp as $clave => $val) {
            /* if($i==0)
              echo "<td>".$val."</td>"; */

            echo "<td>" . $val . "</td>";
            //echo "<td>".$val."</td>";
            $i++;
        }
        //echo "<td>".$val."</td>";
        echo "</tr>";
        echo "</table>";
        unset($this->filatmp);
    }

    function radio_fila($nombre, $selecciona, $condicion = "", $ancho = "100%") {

        echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align='left' width='" . $ancho . "'><tr>";
        //while (list ($clave, $val) = each ($this->filatmp))
        /* foreach($this->filatmp as $clave => $val)
          echo "<td>".$val."</td>";
          echo "</tr>";

          echo "<tr>"; */
        $i = 0;
        foreach ($this->filatmp as $clave => $val) {
            if ($i == 0)
                echo "<td width='30%'>" . $val . "</td>";

            if ($selecciona == $clave)
                echo "<td><input type=radio name='$nombre' id='$nombre' value='$clave' $condicion checked></td>";
            else
                echo "<td><input type=radio name='$nombre' id='$nombre' value='$clave' $condicion ></td>";
            //echo "<td>".$val."</td>";
            $i++;
        }
        echo "<td width='30%'>" . $val . "</td>";
        echo "</tr>";
        echo "</table>";
    }

    function radio_fila_unico($nombre, $selecciona, $condicion = "", $clave = "", $val = "") {

        echo "<table align='left' border='0' cellspacing='0' cellpadding='0'><tr>";
        //while (list ($clave, $val) = each ($this->filatmp))
        /* foreach($this->filatmp as $clave => $val)
          echo "<td>".$val."</td>";
          echo "</tr>";

          echo "<tr>"; */
        //$i=0;

        echo "<td>" . $val . "</td>";

        if ($selecciona == $clave)
            echo "<td><input type=radio name='$nombre' id='$nombre' value='$clave' $condicion checked></td>";
        else
            echo "<td><input type=radio name='$nombre' id='$nombre' value='$clave' $condicion ></td>";
        //echo "<td>".$val."</td>";
        //$i++;
        //echo "<td>".$val."</td>";
        echo "</tr>";
        echo "</table>";
    }

    function menu_fila_multi($nombre, $selecciona, $tamano, $condicion = "") {

        echo "<select name='" . $nombre . "[]' id='" . $nombre . "' multiple='multiple' size='$tamano' $condicion>";
        while (list ($clave, $val) = each($this->filatmp)) {
            if (is_array($this->seleccionmultiple)) {
                if (in_array($clave, array_values($this->seleccionmultiple))) {
                    echo "<option value='$clave' selected>$val</option>";
                } else {
                    echo "<option value='$clave'>$val</option>";
                }
            } else {
                if ($selecciona == $clave)
                    echo "<option value='$clave' selected>$val</option>";
                else
                    echo "<option value='$clave'>$val</option>";
            }
        }
        echo "</select>";
    }

    function captcha($id, $valor = "", $funcion = "") {
        // require_once($urlcaptcha.'/securimage.php');

        echo "<table border='0' cellpadding='0' cellspacing='0' width=100% ><tr>";
        require_once($this->rutaraiz . 'securimage/securimage.php');
        echo "<td>";
        echo "<img id='captcha" . $id . "' id='captcha" . $id . "' src='" . $this->rutaraiz . "securimage/securimage_show.php' alt='CAPTCHA Image' />";
        echo "</td></tr><tr><td>";
        echo "<br>" . $this->boton_tipo("textfield", $id, $valor, $funcion);
        echo "</td></tr>";
        echo "</table>";
    }

    function cambiar_valor_campo($campo, $valor, $form = "form1") {
        echo "\n<script type=\"text/javascript\">
			var campo=document.getElementById('" . $campo . "');
			campo.value=\"" . $valor . "\";
		</script>\n
		";
    }

    //
    function campo_sugerido($tablas, $campollave, $camponombre, $condicion, $valorcampo, $valorcamponombre, $nombrecampo, $direccionsuggest, $imprimir = 0, $javascript = "") {

        $_SESSION["id" . $nombrecampo . 'tablas'] = $tablas;
        $_SESSION["id" . $nombrecampo . 'campollave'] = $campollave;
        $_SESSION["id" . $nombrecampo . 'camponombre'] = $camponombre;
        $_SESSION["id" . $nombrecampo . 'condicion'] = $condicion;

        echo "<script LANGUAGE=\"JavaScript\">
	var getFunctionsUrl = \"$direccionsuggest\";
	var " . $campollave . "functiononclick='" . $javascript . "';
	//alert(" . $campollave . "functiononclick);
	</script>";
//	echo "<div id='content' onclick='hideSuggestions();'>";
        echo "<input name='id$nombrecampo' type='text' id='id$nombrecampo' size='40' class='editParameter' onkeyup=\"handleKeyUp(event,this,'$campollave','$nombrecampo')\" value='$valorcamponombre'>";
        echo "<input name='" . $nombrecampo . "' type='hidden' id='" . $nombrecampo . "' value='$valorcampo'>";
        echo "<div id='scroll'></div>
		  <div id='suggest'></div>";
    }

    //
    function dibujar_campos($tipo, $parametros, $titulo, $estilo_titulo, $idtitulo, $tipo_titulo = "", $imprimir = 0, $tdcomentario = "", $ayuda = "", $titulosadicionales = array()) {
        echo "
			<tr>
			<td id='$estilo_titulo' $tdcomentario>";
        $this->etiqueta("$idtitulo", "$titulo", "$tipo_titulo");
        //echo "etiqueta($idtitulo,$titulo,$tipo_titulo);";
        echo "</td>
			<td $tdcomentario>";
        for ($i = 0; $i < count($tipo); $i++) {
            if ($imprimir) {
                echo "tipo<pre>";
                print_r($tipo);
                echo "</pre>";
                echo "_GET<pre>";
                print_r($_GET);

                echo "</pre>";
                echo "_SESSION campos<pre>";
                print_r($_SESSION["campos"]);
                echo "</pre>";
                echo "_POST<pre>";
                print_r($_POST);
                echo "</pre>";
                echo "\$this->" . $tipo[$i] . "(" . $parametros[$i] . ");";
            }


            if (isset($titulosadicionales[$i]) &&
                    is_array($titulosadicionales[$i])) {
                // echo "Entro?";
                $this->etiqueta($titulosadicionales[$i]['idtitulo'], $titulosadicionales[$i]['titulo'], $titulosadicionales[$i]['tipo_titulo']);
            }
            if (isset($titulosadicionales[$i]['filatmp']) &&
                    is_array($titulosadicionales[$i]['filatmp'])) {
                /* echo "<br>tipo<pre>";
                  print_r($tipo);
                  echo "</pre>";
                  echo "<br>$i<pre>";
                  print_r($titulosadicionales);
                  echo "</pre>"; */
                unset($this->filatmp);
                $this->filatmp = $titulosadicionales[$i]['filatmp'];
                /* echo "filatmp $i<pre>";
                  print_r($this->filatmp);
                  echo "</pre>"; */
            }

            eval("\$this->" . $tipo[$i] . "(" . $parametros[$i] . ");");
        }
        // echo "AYUDA:".$ayuda;
        $this->ayuda($ayuda);
        echo "</td>
	</tr><em></em>
	";
    }

    function dibujar_camposseparados($tipo, $parametros, $titulo, $estilo_titulo, $idtitulo, $tipo_titulo = "", $imprimir = 0, $tdcomentario = "", $ayuda = "") {
        echo "
			<tr>
			<td id='$estilo_titulo' $tdcomentario>";
        $this->etiqueta("$idtitulo", "$titulo", "$tipo_titulo");
        //echo "etiqueta($idtitulo,$titulo,$tipo_titulo);";
        echo "</td>";

        for ($i = 0; $i < count($tipo); $i++) {
            echo "<td $tdcomentario>";
            if ($imprimir)
                echo "\$this->" . $tipo[$i] . "(" . $parametros[$i] . ");";
            eval("\$this->" . $tipo[$i] . "(" . $parametros[$i] . ");");
            echo "</td>";
        }

        echo "
			
			</tr><em></em>
			";
    }

    //
    function dibujar_campo($tipo, $parametros, $titulo, $estilo_titulo, $idtitulo, $tipo_titulo = "", $imprimir = 0, $tdcomentario = "", $ayuda = "", $arraytamanoayuda = "") {
        echo "
			<tr>
			<td id='$estilo_titulo' $tdcomentario>";
        $this->etiqueta("$idtitulo", "$titulo", "$tipo_titulo");
        //echo "etiqueta($idtitulo,$titulo,$tipo_titulo);";
        echo "</td>
			<td $tdcomentario>";

        if ($imprimir)
            echo "\$this->" . $tipo . "(" . $parametros . ");";
        //echo $parametros;
        if (is_array($arraytamanoayuda) && count($arraytamanoayuda) > 0) {
            echo "<script LANGUAGE=\"JavaScript\">
						var ajaxtooltiptamanowidth='" . $arraytamanoayuda["width"] . "';
						var ajaxtooltiptamanoheight='" . $arraytamanoayuda["height"] . "';
				</script>";
        }
        eval("\$this->" . $tipo . "(" . $parametros . ");");
        $this->ayuda($ayuda);

        echo "
			</td>
			</tr>
			";
    }

    //
    function dibujar_fila_titulo($titulo, $estilo_titulo, $colspan = "2", $condicion = "", $tipotitulo = "label") {
        if ($tipotitulo == "label") {
            echo "<tr>
			<td colspan='$colspan' $condicion ><label id='$estilo_titulo'>$titulo</label></td>
			</tr>
            ";
        } else {
            echo "<tr>
			<td colspan='$colspan' $condicion id='$estilo_titulo'>$titulo</td>
			</tr>
            ";
        }
    }

    //
    function dibujar_filas_texto($fila, $idestilotitulos, $idestiloceldas, $comentariotitulo, $comentariocelda) {
        echo "<tr>";
        while (list ($clave, $val) = each($fila)) {
            $claves[] = $clave;
            $valores[] = $val;
        }
        for ($i = 0; $i < count($claves); $i++)
            echo "<td id='$idestilotitulos' $comentariotitulo>" . str_replace("_", " ", $claves[$i]) . "</td>\n";
        echo "</tr>";
        echo "<tr>";
        for ($i = 0; $i < count($valores); $i++)
            echo "<td id='$idestiloceldas' $comentariocelda>" . $valores[$i] . "</td>\n";
        echo "</tr>";
    }

    function dibujar_fila_texto($fila, $idestilotitulos, $idestiloceldas, $comentariotitulo, $comentariocelda, $adicionaltr = "") {
        echo "<tr " . $adicionaltr . ">";
        for ($i = 0; $i < count($fila); $i++)
            echo "<td id='$idestiloceldas' $comentariocelda>" . $fila[$i] . "</td>\n";
        echo "</tr>";
    }

    function validacion($nombrevar, $validacion) {
        $valido = 1;
        //if(isset($nombrevar)){
        switch ($validacion) {
            case "requerido":
                if ($nombrevar == '') {
                    $valido = 0;
                }
                break;
            case "hora":
                if (!ereg("^([1]{1}[0-9]{1}|[2]{1}[0-3]{1}|[0]{0,1}[0-9]{1}):[0-5]{1}[0-9]{1}$", $nombrevar)) {
                    $valido = 0;
                }
                break;
            case "numero":
                if ($nombrevar == '') {
                    $valido = 0;
                } elseif (!ereg("^[0-9]{0,20}$", $nombrevar)) {
                    $valido = 0;
                }
                break;

            case "porcentaje":
                if (!ereg("^[0-9]{0,20}$", $nombrevar) or $nombrevar == '') {
                    $valido = 0;
                } elseif ($nombrevar < 0 || $nombrevar > 100) {
                    $valido = 0;
                }
                break;
            case "letras":
                if ($nombrevar == '') {
                    $valido = 0;
                } elseif (!ereg("^[a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]*$", $nombrevar)) {
                    $valido = 0;
                }
                break;
            case "email":
                $patron = "^[A-z0-9\._-]+"
                        . "@"
                        . "[A-z0-9][A-z0-9-]*"
                        . "(\.[A-z0-9_-]+)*"
                        . "\.([A-z]{2,6})$";
                if ($nombrevar == '') {
                    $valido = 0;
                } elseif (!ereg($patron, $nombrevar)) {
                    $valido = 0;
                }
                break;
            case "email_norequerido":
                $patron = "^[A-z0-9\._-]+"
                        . "@"
                        . "[A-z0-9][A-z0-9-]*"
                        . "(\.[A-z0-9_-]+)*"
                        . "\.([A-z]{2,6})$";
                if ($nombrevar == '') {
                    $valido = 1;
                } elseif (!ereg($patron, $nombrevar)) {
                    $valido = 0;
                }
                break;
            case "nombre":
                if ($nombrevar == '') {
                    $valido = 0;
                } elseif (!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$", $nombrevar)) {
                    $valido = 0;
                }
                break;
            case "combo":
                if ($nombrevar == "0") {
                    $valido = 0;
                }
                break;
            case "fecha":
                // Para fechas >= a 2000
                //$regs = array();
                if ($nombrevar == '') {
                    $valido = 0;
                } elseif (!ereg("^([0-9]{4})-([1-9]{1}|0[1-9]{1}|1[0-2]{1})-([1-9]{1}|[0-2]{1}[1-9]{1}|3[0-1]{1}|10|20)$", $nombrevar, $regs)) {
                    $valido = 0;
                }
                if (!checkdate($regs[2], $regs[3], $regs[1])) {
                    $valido = 0;
                }
                break;
            case "decimal":
                if (!is_float($nombrevar)) {
                    $valido = 0;
                }
                break;
            case "fecha60": //fechas no mayores a 60 dias
                $fechahoy = date("Y-n-j");
                $fechasinformato = strtotime("+60 day", strtotime($fechahoy));
                $fecha60 = date("Y-n-j", $fechasinformato);
                $fechasinformato2 = strtotime("-60 day", strtotime($fechahoy));
                $fechamenos60 = date("Y-n-j", $fechasinformato2);
                //echo $nombrevar,$fechamenos60,fecha60;
                if ($nombrevar == '') {
                    $valido = 0;
                } elseif ($nombrevar < $fechamenos60) {
                    $valido = 0;
                }
                if ($nombrevar > $fecha60) {
                    $valido = 0;
                }
                break;


            case "fechaant":
                // Para fechas < a 2000
                //$regs = array();
                if ($nombrevar == '') {
                    $valido = 0;
                } elseif (!ereg("^(1[0-9]{3})-([1-9]{1}|0[1-9]{1}|1[0-2]{1})-([1-9]{1}|[0-2]{1}[1-9]{1}|3[0-1]{1}|10|20)$", $nombrevar, $regs)) {
                    $valido = 0;
                } elseif (!checkdate($regs[2], $regs[3], $regs[1])) {
                    $valido = 0;
                }
                break;
        }

        if ($valido == 0) {
            echo "<label id='labelresaltado'>*</label>";
        }
        return $valido;
    }

    function valida_formulario() {
        $mensajes = "";
        if (is_array($this->array_validacion)) {
            foreach ($this->array_validacion as $llave => $valor) {
                if ($valor['valido'] == '0') {
                    if ($valor['tipo'] == 'requerido') {
                        $mensajes = $mensajes . $valor['mensaje'] . ', es ' . $valor['tipo'] . '\n';
                    } else {
                        $mensajes = $mensajes . $valor['mensaje'] . ', debe ser del tipo ' . $valor['tipo'] . '\n';
                    }
                    $this->validaciongeneral = false;
                }
            }
        }

        if ($this->validaciongeneral == false) {
            echo "<script language='javascript'>alert('$this->mensajegeneral$mensajes');</script>";
            return false;
        } else {
            return true;
        }
    }

}
?>

