<?php 
header("Content-Type: text/html;charset=utf-8");
include("lib/bd_conexion.php");
include("funciones.php");

$bd=new bd_conexion();


$querry_editar_datos="
UPDATE equipo SET 
DESCRIPCION='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['descripcion'])))."'
WHERE  ID_EQUIPO='".$_POST['id_tipo_equipo']."'	
";
//echo $querry_editar_datos;
$bd->ejecutarQuery($querry_editar_datos);	


echo 'Datos Editados Satisfactoriamente';

echo "<script>
 $('html,body').animate({scrollTop: $('#ejecutado').offset().top}, 1000);
/*$('html, body').animate({
                scrollTop: $('#ejecutado').offset().top
            }, 1500, 'swing');*/
/*</script>";

?>
