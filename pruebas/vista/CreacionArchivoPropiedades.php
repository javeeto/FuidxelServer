<?php

# Licensed to the Apache Software Foundation (ASF) under one
# or more contributor license agreements.  See the NOTICE file
# distributed with this work for additional information
# regarding copyright ownership.  The ASF licenses this file
# to you under the Apache License, Version 2.0 (the
# "License"); you may not use this file except in compliance
# with the License.  You may obtain a copy of the License at
# 
# http://www.apache.org/licenses/LICENSE-2.0
# 
# Unless required by applicable law or agreed to in writing,
# software distributed under the License is distributed on an
# "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
# KIND, either express or implied.  See the License for the
# specific language governing permissions and limitations
# under the License.

require_once ('../../libreria/opencmis/controlador/cmis_service.php');
require_once ('../../libreria/opencmis/controlador/cmis-lib.php');
require_once ('../../libreria/opencmis/controlador/cmis_repository_wrapper.php');

function list_objs($objs) {
    foreach ($objs->objectList as $obj) {
        if ($obj->properties['cmis:baseTypeId'] == "cmis:document") {
            print "Document: " . $obj->properties['cmis:name'] . "\n";
        } elseif ($obj->properties['cmis:baseTypeId'] == "cmis:folder") {
            print "Folder: " . $obj->properties['cmis:name'] . "\n";
        } else {
            print "Unknown Object Type: " . $obj->properties['cmis:name'] . "\n";
        }
    }
}

function check_response($client) {
    if ($client->getLastRequest()->code > 299) {
        print "There was a problem with this request!\n";
        exit(255);
    }
}

/*
  $repo_url = $_SERVER["argv"][1];
  $repo_username = $_SERVER["argv"][2];
  $repo_password = $_SERVER["argv"][3];
  $repo_folder = $_SERVER["argv"][4];
  $repo_new_folder = $_SERVER["argv"][5]; */



$repo_url = "http://192.168.43.218:8080/alfresco/api/-default-/public/cmis/versions/1.1/atom/";
$repo_username = "admin";
$repo_password = "admin";
$repo_folder = "/AppDigi/Digitalizacion1";
$repo_new_folder = "/NuevoDir";


$client = new CMISService($repo_url, $repo_username, $repo_password);
print "Connected\n";
$myfolder = $client->getObjectByPath($repo_folder);



print "Got Folder\n";
check_response($client);
if ($myfolder->properties['cmis:baseTypeId'] != "cmis:folder") {
    print "NOT A FOLDER!\n";
    exit(255);
}



$opts = array('http' =>
  array(
    'header'  => "Content-Type: application/pdf\r\n"
  )
);
                       
$context  = stream_context_create($opts);
/*$url = 'https://'.$https_server;*/
$strPdf = file_get_contents("/tmp/Documento_3.pdf", false, $context);


//$strPdf = utf8_decode(file_get_contents("/tmp/Documento_3.pdf"));

$repo_property_values = array("cmis:title" => "Reporte 005",
    "cmis:description" => "Ejemplo2",
    "cmis:contentStreamMimeType" => "application/pdf");



$obj_doc = $client->createDocument($myfolder->id, "0000005.pdf", array(), $strPdf,'application/pdf');
check_response($client);

$archivoNuevo = $client->getObjectByPath($repo_folder . "/0000005.pdf");

$repo_property_values = "0000005.pdf,Archivo Tramite, Este archivo no contiene algo,Javier Lopez";


/* $objetoXml="</cmis:value>
  </cmis:propertyId>
  <alf:setAspects>
  <alf:aspectsToAdd>P:cm:titled</alf:aspectsToAdd>
  <alf:properties>
  <cmis:propertyString propertyDefinitionId=\"cm:publisher\" displayName=\"Publisher\" queryName=\"cm:publisher\">
  <cmis:value>Norma</cmis:value>
  </cmis:propertyString>"; */


echo "Propiedades<pre>";
print_r($repo_property_values);
echo "</pre>";



//$mypropmap = array( $archivoNuevo->id => $repo_property_values);
//$myobject = $client->updateProperties($archivoNuevo->id, $repo_property_values);
/*
 * <cmis:propertyString propertyDefinitionId=\"cmis:contentStreamMimeType\" displayName=\"Content Stream MIME Type\" localName=\"contentStreamMimeType\" queryName=\"cmis:contentStreamMimeType\">
<cmis:value>application/pdf</cmis:value>
</cmis:propertyString>
 */

$content = file_get_contents("ejemploDatos2.xml");

        $doc = new DOMDocument();
        $doc->loadXML($content);



$obj_url = $client->getLink($archivoNuevo->id, "edit");
$obj_url = CMISRepositoryWrapper :: getOpUrl($obj_url, $repo_property_values);

$retval = $client->doRequest($obj_url, "PUT", $content, MIME_ATOM_XML_ENTRY);
print "Updated Object\n:\n===========================================\n";
echo "<pre>";
echo "RETVAL<br><br>\n";
print_r($retval);


$myobject = $client->extractObject($retval->body);
$client->cacheObjectInfo($myobject);
check_response($client);


echo "MYOBJECT<br><br>\n";
print_r($myobject);
echo "</pre>";
print "\n===========================================\n\n";
