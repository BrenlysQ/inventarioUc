<?php 
header("Content-Type: text/html;charset=utf-8");
include("lib/bd_conexion.php");
include("funciones.php");

$bd=new bd_conexion();


$querry_insertar_datos="
INSERT INTO  condicion
(
DESCRIPCION
)
VALUES (
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['descripcion'])))."'
)		
";
//echo $querry_insertar_datos;
$bd->ejecutarQuery($querry_insertar_datos);	


echo 'Datos Ingresados Satisfactoriamente';

echo "<script> 

$(':input','#formulario')
 .not(':button, :submit, :reset, :hidden')
 .val('')
 .removeAttr('checked')
 .removeAttr('selected');
 

 
$('html,body').animate({scrollTop: $('#ejecutado').offset().top}, 1000); 
</script>";
?>
