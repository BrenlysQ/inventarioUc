<?php
header("Content-Type: text/html;charset=utf-8");
include("lib/bd_conexion.php");

$bd=new bd_conexion();
$datos_inventario_editar=$bd->consultaObjeto(array("*"),"inventario_equipo","ID_INVENTARIO='".$_POST['id_inventario']."'",0);



$nombre_tecnico=$bd->consultaObjeto(array("USUARIO","NOMBRE"),"tecnico","1 AND USUARIO='".$datos_inventario_editar[0]->TRANSCRIPTOR."'",0);
$equipo=$bd->consultaObjeto(array("ID_EQUIPO","DESCRIPCION"),"equipo","1 ORDER BY DESCRIPCION ASC ",0);
$departamento=$bd->consultaObjeto(array("id_dependencia","dependen"),"dec_dependencia","1",0);
$condicion=$bd->consultaObjeto(array("ID_CONDICION","DESCRIPCION"),"condicion","1",0);
$accion=$bd->consultaObjeto(array("ID_ACCION","DESCRIPCION"),"accion","1",0);
$uso=$bd->consultaObjeto(array("ID_USO_EQUIPO","DESCRIPCION"),"uso_equipo","1",0);
$lugar=$bd->consultaObjeto(array("ID_LUGAR_UBI","DESCRIPCION"),"lugar_ubicacion","1",0);

$nombre_equipo=$bd->consultaObjeto(array("DESCRIPCION"),"equipo","1 and ID_EQUIPO='".$datos_inventario_editar[0]->ID_EQUIPO."'",0);
if($nombre_equipo[0]->DESCRIPCION=='MOUSE'){
$datos_mouse=$bd->consultaObjeto(array("MODELO","CONECTOR"),"inventario_equipo_mouse","1 and ID_INVENTARIO='".$datos_inventario_editar[0]->ID_INVENTARIO."'",0);
}

if($nombre_equipo[0]->DESCRIPCION=='MONITOR'){
$datos_monitor=$bd->consultaObjeto(array("MODELO"),"inventario_equipo_monitor","1 and ID_INVENTARIO='".$datos_inventario_editar[0]->ID_INVENTARIO."'",0);
}


if($nombre_equipo[0]->DESCRIPCION=='PC'){
$datos_pc=$bd->consultaObjeto(array("*"),"inventario_equipo_pc","1 and ID_INVENTARIO='".$datos_inventario_editar[0]->ID_INVENTARIO."'",0);

$datos_procesador_marca=$bd->consultaObjeto(array("*"),"marca_procesador","1 and ID_MARCA_PRO='".$datos_pc[0]->ID_MARCA_PRO."'",0);

//$datos_procesador_tipo=$bd->consultaObjeto(array("*"),"tipo_procesador","1 and ID_TIPO_PRO='".$datos_procesador_marca[0]->ID_TIPO_PRO."'",0);
}

if($nombre_equipo[0]->DESCRIPCION=='LAPTOP'){
$datos_lapto=$bd->consultaObjeto(array("*"),"inventario_equipo_lapto","1 and ID_INVENTARIO='".$datos_inventario_editar[0]->ID_INVENTARIO."'",0);

$datos_procesador_marca=$bd->consultaObjeto(array("*"),"marca_procesador","1 and ID_MARCA_PRO='".$datos_lapto[0]->ID_MARCA_PRO."'",0);

//$datos_procesador_tipo=$bd->consultaObjeto(array("*"),"tipo_procesador","1 and ID_TIPO_PRO='".$datos_procesador_marca[0]->ID_TIPO_PRO."'",0);

}

if($nombre_equipo[0]->DESCRIPCION=='IMPRESORA'){
$datos_impresora=$bd->consultaObjeto(array("*"),"inventario_equipo_impresora","1 and ID_INVENTARIO='".$datos_inventario_editar[0]->ID_INVENTARIO."'",0);

//$datos_impresora_toner=$bd->consultaObjeto(array("*"),"inventario_equipo_impresora","1 and TIPO_TONER='".$datos_impresora[0]->TIPO_TONER."'",0);

}

if($datos_inventario_editar[0]->ID_CONDICION=='1'){
$datos_equipo_malo=$bd->consultaObjeto(array("*"),"equipo_malo","1 and ID_INVENTARIO='".$datos_inventario_editar[0]->ID_INVENTARIO."'",0);
}

?>
<style>
#redondear {
padding:0;
width:260px;
height:260px;
margin-bottom:20px;
}
#centrar_img {
position:relative;
    display: table-cell;
    vertical-align:middle;
    text-align:center;
}
</style>


 <div style="text-align:center;" > 
  <?php if($datos_inventario_editar[0]->DIR_IMAGEN!='' && file_exists('images_inventario_equipo/'.$datos_inventario_editar[0]->DIR_IMAGEN)){?>
  <img id="redondear" src="images_inventario_equipo/<?php echo $datos_inventario_editar[0]->DIR_IMAGEN?>" class="img-thumbnail"/ />
   <?php } else{?>
	 <img id="redondear" src="images_inventario_equipo/sin_imagen_inventario.png"  class="img-thumbnail"/>
	<?php }?>
</div>



<div class="row">
  <div class="col-md-6" style="background-color:#DFF0D8">
<div class="form-group"><strong>T&eacute;cnico: </strong><?php echo strtoupper($nombre_tecnico[0]->NOMBRE);?></div>
</div>
  <div class="col-md-6" style="background-color:#DFF0D8">
<div class="form-group"><strong>Tipo del Equipo: </strong><?php echo strtoupper($nombre_equipo[0]->DESCRIPCION);?></div>
  </div>
</div>

<div class="row">
  <div class="col-md-4">
<div class="form-group"><strong>Serial Equipo: </strong><?php if($datos_inventario_editar[0]->SERIAL!='')echo $datos_inventario_editar[0]->SERIAL; else echo 'N/P';?>
</div>
</div>
  <div class="col-md-4">
  <div class="form-group"><strong>Serial TICS: </strong><?php if($datos_inventario_editar[0]->SERIAL_UST!='')echo $datos_inventario_editar[0]->SERIAL_UST; else echo 'N/P';?>
  </div>
  </div>
  <div class="col-md-4">
  <div class="form-group"><strong>Serial FaCyt: </strong><?php if($datos_inventario_editar[0]->SERIAL_FACYT!='')echo $datos_inventario_editar[0]->SERIAL_FACYT; else echo 'N/P';?>
  </div>
  </div>
</div>


<div class="row">
  <div class="col-md-4" style="background-color:#DFF0D8">
<div class="form-group">
<strong>Estado del Equipo: </strong>
<?php 
for($c=0;$c<sizeof($condicion);$c++){
if($datos_inventario_editar[0]->ID_CONDICION==$condicion[$c]->ID_CONDICION)echo $condicion[$c]->DESCRIPCION;
}?>
</div>
</div>
  <div class="col-md-8" style="background-color:#DFF0D8">
<div class="form-group">
<strong>Diagn&oacute;stico: </strong>
<?php if($datos_inventario_editar[0]->DIAGNOSTICO!='')echo $datos_inventario_editar[0]->DIAGNOSTICO; else echo 'N/P';?></div>

<?php if($datos_inventario_editar[0]->ID_CONDICION=='1'){
if($datos_equipo_malo[0]->PIEZA_DANNADA!=''){?>
<div class="form-group">
<strong>Pieza Da&ntilde;ada: </strong>
<?php if($datos_equipo_malo[0]->PIEZA_DANNADA!='')echo $datos_equipo_malo[0]->PIEZA_DANNADA; else echo 'N/P';?></div>

<?php } if($datos_equipo_malo[0]->RECOMENDACION_TECNICO!=''){?>
<div class="form-group">
<strong>Recomedaci&oacute;n T&eacute;cnico: </strong>
<?php if($datos_equipo_malo[0]->RECOMENDACION_TECNICO!='')echo $datos_equipo_malo[0]->RECOMENDACION_TECNICO; else echo 'N/P';?></div>
 <?php }
  }?>
    </div>
</div>


<div class="row">
  <div class="col-md-6" >
<div class="form-group">
<strong>Dependencia: </strong>
<?php 
for($d=0;$d<sizeof($departamento);$d++){
if($datos_inventario_editar[0]->id_dependencia==$departamento[$d]->id_dependencia)echo strtoupper($departamento[$d]->dependen);
 }?>
</div>
</div>
  <div class="col-md-6">
<div class="form-group"><strong>Custodio: </strong><?php echo $datos_inventario_editar[0]->RESPONSABLE;?></div>
  </div>
</div>



<div class="row">
  <div class="col-md-12"  style="background-color:#DFF0D8">
<div class="form-group"><strong>Lugar de Ubicaci&oacute;n: </strong> <?php if($datos_inventario_editar[0]->UBICACION!='') echo $datos_inventario_editar[0]->UBICACION; else echo 'N/P'; ?>
</div>
</div>
</div>

<div class="row">
  <div class="col-md-6" >
<div class="form-group">
<strong>Uso del Equipo: </strong>
<?php 
for($u=0;$u<sizeof($uso);$u++){
if($datos_inventario_editar[0]->ID_USO_EQUIPO==$uso[$u]->ID_USO_EQUIPO)echo strtoupper($uso[$u]->DESCRIPCION);
}?>
</div>
</div>
 <div class="col-md-6" >
<div class="form-group">
<strong>Acci&oacute;n: </strong>
<?php 
for($a=0;$a<sizeof($accion);$a++){
if($datos_inventario_editar[0]->ID_ACCION==$accion[$a]->ID_ACCION)echo  strtoupper($accion[$a]->DESCRIPCION);
}?>
</div>
  </div>
</div>



<div id="esp_otro" <?php if($nombre_equipo[0]->DESCRIPCION!='MOUSE' && $nombre_equipo[0]->DESCRIPCION!='MONITOR' && $nombre_equipo[0]->DESCRIPCION!='PC' && $nombre_equipo[0]->DESCRIPCION!='LAPTOP'){echo 'style="display:display;"';}else{echo 'style="display:none;"';}?>>
<div class="row">
  <div class="col-md-12" style="background-color:#DFF0D8">
<div class="form-group"><strong>Modelo Equipo: </strong><?php echo $datos_inventario_editar[0]->MODELO;?>
</div>
</div>
</div>
</div>


<div id="espe_mouse" <?php if($nombre_equipo[0]->DESCRIPCION=='MOUSE'){echo 'style="display:display;"';}else{echo 'style="display:none;"';}?> >

<div class="row">
  <div class="col-md-6" style="background-color:#DFF0D8">
<div class="form-group"><strong>Modelo del Equipo: </strong>
<?php 
if($datos_mouse[0]->MODELO=="MECANICO") echo 'MECANICO';
if($datos_mouse[0]->MODELO=="OPTICO") echo 'OPTICO';
if($datos_mouse[0]->MODELO=="LASER") echo 'LASER';
if($datos_mouse[0]->MODELO=="TRACKBALL") echo'TRACKBALL';
?></div>
</div>
  <div class="col-md-6" style="background-color:#DFF0D8">
  <div class="form-group"><strong>Conetor del Mouse: </strong>
<?php 
if($datos_mouse[0]->CONECTOR=="PS2")echo 'PS2';
if($datos_mouse[0]->CONECTOR=="USB")echo 'USB';
if($datos_mouse[0]->CONECTOR=="WIRELESS")echo 'WIRELESS';
if($datos_mouse[0]->CONECTOR=="BLUETOOTH")echo 'BLUETOOTH';
?></div>
  </div>
</div>
</div>


<div id="espe_monitor"  <?php if($nombre_equipo[0]->DESCRIPCION=='MONITOR'){echo 'style="display:display;"';}else{echo 'style="display:none;"';}?>>

<div class="row">
  <div class="col-md-12" style="background-color:#DFF0D8">
<div class="form-group"><strong>Modelo del Equipo: </strong>
<?php 
if($datos_monitor[0]->MODELO=="CRT")echo 'CRT';
if($datos_monitor[0]->MODELO=="LCD")echo 'LCD';
if($datos_monitor[0]->MODELO=="LED")echo 'LED';
if($datos_monitor[0]->MODELO=="DLP")echo 'DLP';
?></div>
</div>
</div>
</div>


<div id="espe_pc"  <?php if($nombre_equipo[0]->DESCRIPCION=='PC'){echo 'style="display:display;"';}else{echo 'style="display:none;"';}?>>

<div class="row">
  <div class="col-md-6" style="background-color:#DFF0D8">
<div class="form-group">
<strong>Modelo CPU: </strong>
<?php 
if($datos_pc[0]->CPU=="BAREBONE")echo 'BAREBONE';
if($datos_pc[0]->CPU=="MINITORRE")echo 'MINITORRE';
if($datos_pc[0]->CPU=="SOBREMESA")echo 'SOBREMESA';
if($datos_pc[0]->CPU=="SEMITORRE")echo 'SEMITORRE';
if($datos_pc[0]->CPU=="TORRE")echo 'TORRE';
if($datos_pc[0]->CPU=="SERVIDOR")echo 'SERVIDOR';
if($datos_pc[0]->CPU=="RACK")echo 'RACK';
if($datos_pc[0]->CPU=="PORTATIL")echo 'PORTATIL';
?>
</div>
</div>
  <div class="col-md-6" style="background-color:#DFF0D8">
<div class="form-group">
<strong>Procesador Marca: </strong><?php 

if($datos_procesador_marca[0]->DESCRIPCION!=''){echo $datos_procesador_marca[0]->DESCRIPCION;}else{echo'N/P';}?>
</div>
  </div>
</div>


<div class="row">
  <div class="col-md-6">
<div class="form-group">
<strong>Procesador Tipo: </strong><?php if($datos_procesador_tipo[0]->DESCRIPCION!=''){echo $datos_procesador_tipo[0]->DESCRIPCION;}else{echo'N/P';}?>
</div>
</div>
  <div class="col-md-6">
<div class="form-group">
<strong>Procesador Velocidad: </strong><?php if($datos_pc[0]->PROCESADOR_VELOCIDAD!=''){echo $datos_pc[0]->PROCESADOR_VELOCIDAD;}else{echo'N/P';}?>
</div>
  </div>
</div>



<div class="row">
  <div class="col-md-6" style="background-color:#DFF0D8">
<div class="form-group">
<strong>Memoria Capacidad: </strong>
<?php if($datos_pc[0]->MEMORIA_CAPACIDAD!=''){echo $datos_pc[0]->MEMORIA_CAPACIDAD;}else{echo'N/P';}?>
</div>
</div>
  <div class="col-md-6" style="background-color:#DFF0D8">
<div class="form-group">
<strong>Memoria Tipo: </strong><?php if($datos_pc[0]->MEMORIA_TIPO!=''){echo $datos_pc[0]->MEMORIA_TIPO;}else{echo'N/P';}?>
</div>
  </div>
</div>


<div class="row">
  <div class="col-md-6">
<div class="form-group">
<strong>Disco Duro Capacidad: </strong><?php if($datos_pc[0]->DISCO_DURO_CAPACIDAD!=''){echo $datos_pc[0]->DISCO_DURO_CAPACIDAD;}else{echo'N/P';}?>
</div>
</div>
  <div class="col-md-6">
<div class="form-group">
<strong>Disco Duro Tipo: </strong> <?php if($datos_pc[0]->DISCO_DURO_TIPO!=''){echo $datos_pc[0]->DISCO_DURO_TIPO;}else{echo'N/P';}?>
</div>
  </div>
</div>


<div class="row">
  <div class="col-md-12" style="background-color:#DFF0D8">
<div class="form-group">
<strong> Unidades de Lectura / Escritura</strong>
<?php 
if($datos_pc[0]->UNIDADES_LECTURA!=''){echo'<br>';
if(strpos($datos_pc[0]->UNIDADES_LECTURA, "CD-ROM")!== false)echo ' CD-ROM ';
if(strpos($datos_pc[0]->UNIDADES_LECTURA, "CD-ROM REWRITABLE")!== false)echo ' CD-ROM REWRITABLE ';
if(strpos($datos_pc[0]->UNIDADES_LECTURA, "DVD")!== false)echo ' DVD';
if(strpos($datos_pc[0]->UNIDADES_LECTURA, "DVD REWRITABLE")!== false)echo ' DVD REWRITABLE ';
}else{echo'N/P';}
?>
</div>
</div>
</div>

</div><!--fin PC -->

<div id="espe_lapto"  <?php if($nombre_equipo[0]->DESCRIPCION=='LAPTOP'){echo 'style="display:display;"';}else{echo 'style="display:none;"';}?>>


<div class="row">
  <div class="col-md-12" style="background-color:#DFF0D8">
<div class="form-group">
<strong>Procesador Marca: </strong><?php if($datos_procesador_marca[0]->DESCRIPCION!=''){echo $datos_procesador_marca[0]->DESCRIPCION;}else{echo'N/P';}?>
</div>
</div>
</div>


<div class="row">
  <!--div class="col-md-6">
<div class="form-group">
<strong>Procesador Tipo: </strong><?php// if($datos_procesador_tipo[0]->DESCRIPCION!=''){echo $datos_procesador_tipo[0]->DESCRIPCION;}else{echo'N/P';}?>
</div>
</div-->
  <div class="col-md-6">
<div class="form-group">
<strong>Procesador Velocidad: </strong><?php if($datos_lapto[0]->PROCESADOR_VELOCIDAD!=''){echo $datos_lapto[0]->PROCESADOR_VELOCIDAD;}else{echo'N/P';}?>
</div>
  </div>
</div>


<div class="row">
  <div class="col-md-6" style="background-color:#DFF0D8">
<div class="form-group">
<strong>Memoria Capacidad: </strong>
<?php if($datos_lapto[0]->MEMORIA_CAPACIDAD!=''){echo $datos_lapto[0]->MEMORIA_CAPACIDAD;}else{echo'N/P';}?>
</div>
</div>
  <div class="col-md-6" style="background-color:#DFF0D8">
<div class="form-group">
<strong>Memoria Tipo: </strong><?php if($datos_lapto[0]->MEMORIA_TIPO!=''){echo $datos_lapto[0]->MEMORIA_TIPO;}else{echo'N/P';}?>
</div>
  </div>
</div>


<div class="row">
  <div class="col-md-6">
<div class="form-group">
<strong>Disco Duro Capacidad: </strong><?php if($datos_lapto[0]->DISCO_DURO_CAPACIDAD!=''){echo $datos_lapto[0]->DISCO_DURO_CAPACIDAD;}else{echo'N/P';}?>
</div>
</div>
  <div class="col-md-6">
<div class="form-group">
<strong>Disco Duro Tipo: </strong> <?php if($datos_lapto[0]->DISCO_DURO_TIPO!=''){echo $datos_lapto[0]->DISCO_DURO_TIPO;}else{echo'N/P';}?>
</div>
  </div>
</div>


<div class="row">
  <div class="col-md-12" style="background-color:#DFF0D8">
<div class="form-group">
<strong> Unidades de Lectura / Escritura</strong>
<?php 
if($datos_lapto[0]->UNIDADES_LECTURA!=''){echo'<br>';
if(strpos($datos_lapto[0]->UNIDADES_LECTURA, "CD-ROM")!== false)echo ' CD-ROM ';
if(strpos($datos_lapto[0]->UNIDADES_LECTURA, "CD-ROM REWRITABLE")!== false)echo ' CD-ROM REWRITABLE ';
if(strpos($datos_lapto[0]->UNIDADES_LECTURA, "DVD")!== false)echo ' DVD';
if(strpos($datos_lapto[0]->UNIDADES_LECTURA, "DVD REWRITABLE")!== false)echo ' DVD REWRITABLE ';
}else{echo'N/P';}
?>
</div>
</div>
</div>

</div><!--FIN LAPTOP -->

<div id="espe_impresora"  <?php if($nombre_equipo[0]->DESCRIPCION=='IMPRESORA'){echo 'style="display:display;"';}else{echo 'style="display:none;"';}?>>

<div class="row">
<div class="col-md-12" style="background-color:#DFF0D8">
<div class="form-group">
<strong>Tipo de Toner: </strong>
<?php 
if($datos_impresora[0]!=''){
  echo $datos_impresora[0]->TIPO_TONER;
}else{echo'N/P';}?>
</div>
</div>
</div>
</div>

<div class="row">
  <div class="col-md-6">
<div class="form-group">
<strong>Se encuentra en uso el Equipo: </strong>
<?php 
if($datos_inventario_editar[0]->USO=="SI")echo 'SI';
if($datos_inventario_editar[0]->USO=="NO")echo 'NO';
?>
</div>
</div>
 <div class="col-md-6">
<div class="form-group">
<strong>Posee Garant&iacute;a el Equipo: </strong>
<?php 
if($datos_inventario_editar[0]->GARANTIA=="SI")echo 'SI';
if($datos_inventario_editar[0]->GARANTIA=="NO")echo 'NO';
?>
&nbsp;&nbsp;
<?php 
if($datos_inventario_editar[0]->ANNO_GARANTIA>0 && $datos_inventario_editar[0]->GARANTIA=="SI")echo $datos_inventario_editar[0]->ANNO_GARANTIA.'&nbsp;a&ntilde;os';
?>
</div>
  </div>
</div>



<div class="row">
  <div class="col-md-6" style="background-color:#DFF0D8">
<div class="form-group">
<strong>Pertenece a un Proyecto: </strong>
<?php 
if($datos_inventario_editar[0]->PERTENECE_PROYECYO=="SI")echo 'SI';
if($datos_inventario_editar[0]->PERTENECE_PROYECYO=="NO")echo 'NO';
?>
</div>
</div>
 <div class="col-md-6" style="background-color:#DFF0D8">

<div class="form-group">  
<strong>Titulo del Proyecto: </strong>
<?php if($datos_inventario_editar[0]->DESCRIPCION_PROYECTO!=''){echo $datos_inventario_editar[0]->DESCRIPCION_PROYECTO;}else{echo'N/P';}?>
</div>
  </div>
</div>


<div class="row">
  <div class="col-md-12">
<div class="form-group"><strong>Observaciones del Equipo: </strong>
<?php if($datos_inventario_editar[0]->OBSERVACIONES!=''){echo $datos_inventario_editar[0]->OBSERVACIONES;}else{echo'N/P';}?>
</div>
</div>
</div>

