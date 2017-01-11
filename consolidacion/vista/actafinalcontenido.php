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
 * Descripcion del codigo de actainiciocontenido
 * 
 * @file actainiciocontenido.php
 * @author Javier Lopez Martinez
 * @date 7/11/2016
 * @brief Contiene ...
 */
?>
<table border="1">
    <tr>
        <td align="center" colspan="2"><h3>ACTA DE FINAL DE ALMACENAMIENTO</h3></td>
    </tr>

    <tr>
        <td>

            ENTIDAD:</td>
        <td> <b><varphp>nombreentidad</varphp></b>
        </td>
    </tr>
    <tr>
        <td>
            USUARIO: </td>
        <td><b><varphp>nombreusuario</varphp></b>
        </td>
    </tr>    
    <tr>
        <td>
            LOTE No: </td>
        <td><b><varphp>idlote</varphp></b>
        </td>
    </tr>
    <tr>
        <td>
            No IMAGENES: </td>
        <td><b><varphp>noimageneslote</varphp></b>
        </td>
    </tr>          
    <tr>
        <td>
            No FALTANTES: </td>
        <td><b><varphp>faltanteslote</varphp></b>
        </td>
    </tr>    
    <tr>
        <td>
            No SERIAL MEDIO DIGITALIZAICON: </td>
        <td><b><varphp>serialmedio</varphp></b>
        </td>
    </tr>      
    <tr>
        <td>
            No DOCUMENTOS: </td>
        <td><b><varphp>documentoactacontrol</varphp></b>
        </td>
    </tr>
    <tr>
        <td>
            GRUPO DE ESCANEO: </td>
        <td><b><varphp>nombregrupousuario</varphp></b>
        </td>
    </tr>
    <tr>
        <td>
            OBSERVACIONES:</td>
        <td><b><varphp>observacionacta</varphp></b>
        </td>
    </tr>    
    <tr>
        <td>
            CONFIGURACION DE IMAGENES:</td>
        <td><b><varphp>configuraactacontrol</varphp></b>
        </td>
    </tr>
    <tr>
        <td>
            FECHA DE LOTE: </td>
        <td><b><varphp>fechaactacontrol</varphp></b>
        </td>
    </tr>    
    <tr>
        <td>
            FECHA DE IMPRESION: </td>
        <td><b><varphp>fechaimpresion</varphp></b>
        </td>
    </tr>

    <tr>
        <td align="center" colspan="2">
            <br><br><br><br>
            <b>INDICES Y DESCRIPTORES</b><br>
        </td>
    </tr>
    <tr>
        <td align="center" colspan="2"> <varphp>listaindicelote</varphp></td>
</tr>    

<tr>
    <td align="center" colspan="2">
        <br><br><br><br>
        <b>CERTIFICADOS DE FUNCIONAMIENTO </b><br>
    </td>
</tr>
<tr>

    <td align="center" colspan="2">

<varphp>certificado</varphp>
</td>
</tr>


<tr>
    <td colspan="2">
        <br><br><br><br>
        <b>____________________________________</b><br><br>
        <b>OFICIAL DE GESTI&Oacute;N DOCUMENTAL</b><br>
        <br><br><br><br>
        <b>____________________________________</b><br><br>
        <b><varphp>nombreusuario</varphp></b><br>
        <b>OPERADOR DEL ESCANER</b><br>
    </td>
</tr>


</table>