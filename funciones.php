<?php
function TildesHtml($cadena) { 
 return str_replace(array("á","é","í","ó","ú","ñ","Á","É","Í","Ó","Ú","Ñ","'"),
                                         array("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&ntilde;",
                                                    "&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;","&Ntilde;","&#39;"), $cadena);     
 }
 
 function array_recibe($url_array) {
    $tmp = stripslashes($url_array);
    $tmp = urldecode($tmp);
    $tmp = unserialize($tmp);
   return $tmp;
}

function array_envia($array) {
    $tmp = serialize($array);
    $tmp = urlencode($tmp);
    return $tmp;
}

?>