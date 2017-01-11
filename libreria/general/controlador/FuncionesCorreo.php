<?php
/**
 * Funcion para enviar correo donde el primer parametro es un array 
 * con la información del contenido,asunto,remitente
 * 
 * @param array $array_datos
 * @param string $destinatario
 * @param string $nombredestinatario
 * @param string $trato
 * @return boolean 
 */
function ConstruirCorreo($array_datos, $destinatario, $nombredestinatario, $trato) {
    if (is_array($array_datos)) {
        //Se definen parametros iniciales
        $mail = new PHPMailer();
        $mail->Mailer = MAILERCONEXIONCORREO;
        $mail->Host = HOSTCONEXIONCORREO;
        $mail->SMTPAuth = SMTPAUTHCONEXIONCORREO;
        $mail->Username = USERNAMECONEXIONCORREO;
        $mail->Password = PASSWORDCONEXIONCORREO;
        $mail->From = $array_datos['correoorigen'];
        $mail->FromName = $array_datos['nombreorigen'];
        $mail->ContentType = "text/html";
        $mail->Subject = $array_datos['asunto'];
        //se define encabezado y cuerpo del correo
        $encabezado = $trato . ":" . $nombredestinatario;
        $cuerpo = $encabezado . "<br><br>" . $array_datos['encabezamiento'];
        $mail->Body = $cuerpo;
        $mail->AddAddress($destinatario, $nombredestinatario);

        //Se valida si viene una lista de url para adjuntar archivos
        if (is_array($array_datos['detalle'])) {
            foreach ($array_datos['detalle'] as $llave => $url) {

                if (!$mail->AddAttachment($url, $llave)) {
                    alerta_javascript("Error no lo mando AddAttachment($url,$llave)");
                }
            }
        }
        if (!$mail->Send()) {
            echo "El mensaje no pudo ser enviado";
            echo "Mailer Error: " . $mail->ErrorInfo;            
        } else {
            if ($depurar == true) {
                echo "Mensaje Enviado";
                echo "<br>";
                echo "<pre>";
                print_r($mail);
                echo "</pre>";
            }
        }
        return true;
    } else {
        return false;
    }
}

?>
