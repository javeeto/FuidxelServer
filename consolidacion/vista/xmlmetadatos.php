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
require_once '../../consolidacion/controlador/controlXMLMetadato.php';
$tmpmetadatos= $datosMetaDoc;
?>
<?xml version="1.0" encoding="ISO-8859-1" standalone="yes"?>
<atom:entry xmlns:cmis="http://docs.oasis-open.org/ns/cmis/core/200908/"
            xmlns:cmism="http://docs.oasis-open.org/ns/cmis/messaging/200908/"
            xmlns:atom="http://www.w3.org/2005/Atom"
            xmlns:app="http://www.w3.org/2007/app"
            xmlns:cmisra="http://docs.oasis-open.org/ns/cmis/restatom/200908/">
    <atom:title><?= $datosMetaDoc["documento"][0]["rutadetalledocumento"] ?></atom:title>
    <atom:summary><?= $datosMetaDoc["documento"][0]["rutadetalledocumento"] ?></atom:summary>
    <cmisra:object>
        <cmis:properties>   
           <?php foreach ($tmpmetadatos["metadato"] as $imetadato => $filametadato) { ?>
            <cmis:propertyString propertyDefinitionId="isadagncol:<?= $filametadato["xmlcampometadato"] ?>" displayName="<?= $filametadato["opcioncampometadato"] ?>" localName="<?= $filametadato["xmlcampometadato"] ?>" queryName="isadagncol:<?= $filametadato["xmlcampometadato"] ?>"/>
             <?php } ?>   
            <e1:setAspects xmlns:e1="http://www.alfresco.org">
                <e1:aspectsToAdd>P:isadagncol:isadagncol</e1:aspectsToAdd>
                <e1:aspectsToAdd>P:isadagncol:contexto</e1:aspectsToAdd>
                <e1:aspectsToAdd>P:isadagncol:3contenido</e1:aspectsToAdd>
                <e1:properties>

                    <?php foreach ($datosMetaDoc["metadato"] as $imetadato => $filametadato) { ?>
                        <cmis:propertyString propertyDefinitionId="isadagncol:<?= $filametadato["xmlcampometadato"] ?>" localName="<?= $filametadato["xmlcampometadato"] ?>" queryName="isadagncol:<?= $filametadato["xmlcampometadato"] ?>" displayName="<?= $filametadato["opcioncampometadato"] ?>">
                            <cmis:value><?=$filametadato["valordefinitivoregistro"]?></cmis:value>
                        </cmis:propertyString>
                    <?php } ?>                    

                </e1:properties>
            </e1:setAspects>
        </cmis:properties>
    </cmisra:object>
</atom:entry>
