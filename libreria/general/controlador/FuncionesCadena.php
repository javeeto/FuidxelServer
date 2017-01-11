<?php

//Agrega ceros a la izquierda para un numero $numero que tenga una longitud $longitud fija
function agregarceros($numero, $longitud) {
    $masceros = "";
    $longitudcadena = strlen($numero);
    $diferencia = $longitud - $longitudcadena;

    for ($i = 0; $i < $diferencia; $i++)
        $masceros .= "0";

    return $masceros . $numero;
}

//Agrega ceros a la izquierda para un numero $numero que tenga una longitud $longitud fija
function agregarcerosderecha($numero, $longitud) {
    $masceros = "";
    $longitudcadena = strlen($numero);
    $diferencia = $longitud - $longitudcadena;

    for ($i = 0; $i < $diferencia; $i++)
        $masceros .= "0";

    return $numero . $masceros;
}

//Delvuelve una cantidad de espacios determinada
function esp($esps) {

    for ($i = 0; $i < $esps; $i++)
        $masesp .= " ";

    return $masesp;
}

//Agrega espacios a la derecha para un campo $numero que tenga una longitud $longitud fija
function agregarespacios($numero, $longitud) {
    $longitudcadena = strlen($numero);
    $diferencia = $longitud - $longitudcadena;

    for ($i = 0; $i < $diferencia; $i++)
        $masesps .= " ";

    return $numero . $masesps;
}

//Agrega puntos de direccion relativa ../ a la izquierda un numero de veces determinada $pts
function puntos($pts) {
    for ($i = 0; $i < $pts; $i++)
        $maspts .= "../";

    return $maspts;
}

//Devuelve palabras guardadas en una cadena separadas por espacio
function sacarpalabras($cadena, $iniciarenpalabra, $finalizarenpalabra = "") {
    $cadenas = explode(" ", $cadena);

    for ($i = $iniciarenpalabra; $i < count($cadenas); $i++) {
        $palabras .= $cadenas[$i] . " ";
        if ($i == $finalizarenpalabra)
            break;
    }
    return $palabras;
}

//Cuenta Palabras
function cuentapalabras($cadena) {
    $cadenas = explode(" ", $cadena);
    $cuenta = count($cadenas);
    return $cuenta;
}

//Imprime cadena en un alert de javascript
function alerta_javascript($mensaje) {
    echo "\n<script type=\"text/javascript\">
		alert('$mensaje');\n
		</script>\n";
}

//Quita las tildes en un cadena
function quitartilde($palabra) {
    $tildes = array("�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�");
    $sintildes = array("A", "E", "I", "O", "U", "A", "E", "I", "O", "U", "n", "n");
    $nuevacadena = $palabra;
    for ($j = 0; $j < count($tildes); $j++)
        $nuevacadena = str_replace($tildes[$j], $sintildes[$j], $nuevacadena);
    return $nuevacadena;
}

//Cambia espacio por barra piso en un string
function cambiarespacio($palabra) {
    $nuevapalabra = str_replace(" ", "_", $palabra);
    return $nuevapalabra;
}

//Saca numeros de un string
function sacarnumeros($palabra) {
    for ($i = 0; $i < strlen($palabra); $i++)
        for ($j = 0; $j <= 9; $j++)
            if ($palabra[$i] == "$j")
                $numero.=$j;
    return $numero;
}

//	Quita saltos de linea en un string;
function quitarsaltolinea($parrafo) {
    //echo "<br><br>$parrafo<br>for($i=0;$i<".strlen($parrafo).";$i++){";
    for ($i = 0; $i < strlen($parrafo); $i++) {
        if (ord($parrafo[$i]) == 10)
            $parrafo[$i] = chr(32);
        if (ord($parrafo[$i]) == 13)
            $parrafo[$i] = chr(32);
    }
    return $parrafo;
}

//Limpiar Entrada
function limpiaCadena($cadena) {
    $carraterInvalido = array("{", "}", "(", ")", ";", ":", "<", ">", "/", "$","\\");
    $cadena = str_replace($carraterInvalido, "", $cadena);
    $cadena = strip_tags($cadena);
    $cadena = htmlentities($cadena);
    $cadena = quitarsaltolinea($cadena);
    if (get_magic_quotes_gpc()) {
        $cadena = stripcslashes($cadena);
    }
    return $cadena;
}

//Limpiar Entrada
function limpiaCadenaUrl($cadena) {
    $carraterInvalido = array("{", "}", "(", ")", ";", "<", ">", "$");
    $caracterValido = array("/", "\\", ":");
    $caracterValidoRemplazo = array("/", "\\\\", ":");
   
    $cadena = str_ireplace($caracterValido, $caracterValidoRemplazo, $cadena);
    $cadena = str_replace($carraterInvalido, "", $cadena);
    $cadena = strip_tags($cadena);
    $cadena = htmlentities($cadena);
    $cadena = quitarsaltolinea($cadena);
    if (get_magic_quotes_gpc()) {
        $cadena = stripcslashes($cadena);
    }
    
    return $cadena;
}

//Convierte un numero en su descripcion textual
function convercionnumerotexto($numero) {
    $unidades[1] = array("uno", "d�s", "tr�s", "cuatro", "cinco", "s�is", "siete", "ocho", "nueve");
    $unidades[2] = array("dieci", "veinti", "treinta y ", "cuarenta y ", "cincuenta y ", "sesenta y ", "setenta y ", "ochenta y ", "noventa y ");
    $unidades[3] = array("ciento", "doscientos", "trescientos", "cuatrocientos", "quinientos", "seicientos", "setencientos", "ochocientos", "novecientos");
    $potencia = strlen($numero);
    switch ($numero) {
        case "1":
            $cadenavalor = "un";
            break;
        case "10":
            $cadenavalor = "diez";
            break;
        case "11":
            $cadenavalor = "once";
            break;
        case "12":
            $cadenavalor = "doce";
            break;
        case "13":
            $cadenavalor = "trece";
            break;
        case "14":
            $cadenavalor = "catorce";
            break;
        case "15":
            $cadenavalor = "quince";
            break;
        case "20":
            $cadenavalor = "veinte";
            break;

        default:
            for ($i = 0; $i <= $potencia; $i++) {
                if ($numero % 10 == 0)
                    $cadenavalor.=str_replace(" y ", "", $unidades[($potencia - $i)][($numero[($i)] - 1)]);
                else
                    $cadenavalor.=$unidades[($potencia - $i)][($numero[($i)] - 1)];
            }
            break;
    }
    return $cadenavalor;
}

function numeroRomanoAEntero($textoromano) {
    $romanos = array("I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X");
    for ($i = 0; $i < count($romanos); $i++) {
        if ($romanos[$i] == trim($textoromano)) {
            return ($i + 1);
        }
    }
}

?>