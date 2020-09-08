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
$marca_procesador=$bd->consultaObjeto(array("ID_MARCA_PRO","DESCRIPCION"),"marca_procesador","1 ORDER BY DESCRIPCION ASC",0);


$nombre_equipo=$bd->consultaObjeto(array("DESCRIPCION"),"equipo","1 and ID_EQUIPO='".$datos_inventario_editar[0]->ID_EQUIPO."'",0);
if($nombre_equipo[0]->DESCRIPCION=='MOUSE'){
$datos_mouse=$bd->consultaObjeto(array("MODELO","CONECTOR"),"inventario_equipo_mouse","1 and ID_INVENTARIO='".$datos_inventario_editar[0]->ID_INVENTARIO."'",0);
}

if($nombre_equipo[0]->DESCRIPCION=='MONITOR'){
$datos_monitor=$bd->consultaObjeto(array("MODELO"),"inventario_equipo_monitor","1 and ID_INVENTARIO='".$datos_inventario_editar[0]->ID_INVENTARIO."'",0);
}

if($nombre_equipo[0]->DESCRIPCION=='PC'){
$datos_pc=$bd->consultaObjeto(array("*"),"inventario_equipo_pc","1 and ID_INVENTARIO='".$datos_inventario_editar[0]->ID_INVENTARIO."'",0);
}

if($nombre_equipo[0]->DESCRIPCION=='LAPTOP'){
$datos_lapto=$bd->consultaObjeto(array("*"),"inventario_equipo_lapto","1 and ID_INVENTARIO='".$datos_inventario_editar[0]->ID_INVENTARIO."'",0);
}

if($datos_inventario_editar[0]->ID_CONDICION=='1'){
$datos_equipo_malo=$bd->consultaObjeto(array("*"),"equipo_malo","1 and ID_INVENTARIO='".$datos_inventario_editar[0]->ID_INVENTARIO."'",0);
}


?>
		
<form id="formulario" name="formulario" method="post" enctype="multipart/form-data">	


<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>* T&eacute;cnico:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<input type="text" value="<?php echo $nombre_tecnico[0]->NOMBRE;?>" size="40" class="form-control" id="tecnico" name="tecnico" disabled />
</div>
  </div>
</div>

<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>* Tipo del Equipo:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<select  id="nombre_equipo" name="nombre_equipo" style="color: #666; width:100%;" onChange="mostrar_especificaciones(this)">
<option value="">* Tipo del Equipo</option>
<?php 
for($e=0;$e<sizeof($equipo);$e++){?>
<option value="<?php echo $equipo[$e]->ID_EQUIPO?>-<?php echo $equipo[$e]->DESCRIPCION?>" <?php if($equipo[$e]->ID_EQUIPO==$datos_inventario_editar[0]->ID_EQUIPO){echo 'selected="selected"';}?>><?php $equipo[$e]->DESCRIPCION?></option>
<?php }?>
</select>
</div>
  </div>
</div>

<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Serial Equipo:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<input type="text" id="serial_equipo"  name="serial_equipo" value="<?php echo $datos_inventario_editar[0]->SERIAL?>" size="40" class="form-control" placeholder=" Serial Equipo" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
  </div>
</div>


<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Serial UC:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<input type="text" id="serial_ust"  name="serial_ust" value="<?php echo $datos_inventario_editar[0]->SERIAL_UST?>" size="40" class="form-control" placeholder=" Serial UC" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
  </div>
</div>

<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>* Condici&oacute; Equipo:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<select  id="condicion_equipo" name="condicion_equipo" style="color: #666; width:100%;" onKeyUp="javascript:this.value=this.value.toUpperCase();" onChange="mostrar_diagnostico(this)">
<option value="">* Situaci&oacuten del Equipo</option>
<?php 
for($c=0;$c<sizeof($condicion);$c++){?>
<option value="<?php echo $condicion[$c]->ID_CONDICION?>" <?php if($datos_inventario_editar[0]->ID_CONDICION==$condicion[$c]->ID_CONDICION){echo 'selected="selected"';}?>><?php echo $condicion[$c]->DESCRIPCION?></option>
<?php }?>
</select>
</div>
  </div>
</div>

<div id="diagnos"  <?php if($datos_inventario_editar[0]->ID_CONDICION=='1'){echo 'style="display:display;"';}else{echo 'style="display:none;"';}?>>

<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong> Diag&oacute;stico del Equipo:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<textarea  id="diagnostico"  name="diagnostico" cols="40" rows="3" class="form-control" placeholder=" Diag&oacute;stico del Equipo" onKeyUp="javascript:this.value=this.value.toUpperCase();"><?php echo $datos_inventario_editar[0]->DIAGNOSTICO;?></textarea>
</div>
  </div>
</div>

<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong> Pieza Da&ntilde;ada:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<input type="text" id="pieza_dannada"  name="pieza_dannada" value="<?php echo $datos_equipo_malo[0]->PIEZA_DANNADA;?>" size="40" class="form-control" placeholder=" Pieza Da&ntilde;ada" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
  </div>
</div>

<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong> Recomendaci&oacute;n T&eacute;cnico:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<textarea  id="recomendacion_tec"  name="recomendacion_tec" cols="40" rows="3" class="form-control" placeholder=" Recomendaci&oacute;n T&eacute;cnico" onKeyUp="javascript:this.value=this.value.toUpperCase();"><?php echo $datos_equipo_malo[0]->RECOMENDACION_TECNICO;?></textarea>
</div>
  </div>
</div>
</div> <!--Fin div mostrar diagnostico -->





<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>* Dependencia:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<select  id="id_departamento" name="id_departamento" style="color: #666; width:100%;"  onKeyUp="javascript:this.value=this.value.toUpperCase();">
<option value=""> * Dependencia</option>
<?php 
for($d=0;$d<sizeof($departamento);$d++){?>
<option value="<?php echo $departamento[$d]->id_dependencia?>" <?php if($datos_inventario_editar[0]->id_dependencia==$departamento[$d]->id_dependencia){echo 'selected="selected"';}?>><?php echo  strtoupper($departamento[$d]->dependen);?></option>
<?php }?>
</select>
</div>
  </div>
</div>

<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>* Lugar de Ubicaci&oacute;n:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<textarea  id="ubicacion"  name="ubicacion" cols="40" rows="3" class="form-control" placeholder=" * Lugar de Ubicaci&oacute;n" onKeyUp="javascript:this.value=this.value.toUpperCase();"><?php echo $datos_inventario_editar[0]->UBICACION;?></textarea>
</div>
  </div>
</div>


<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>* Uso del Equipo:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<select  id="uso_equipo" name="uso_equipo" style="color: #666; width:100%;" onKeyUp="javascript:this.value=this.value.toUpperCase();">
<option value=""> * Uso del Equipo</option>
<?php 
for($u=0;$u<sizeof($uso);$u++){?>
<option value="<?php echo $uso[$u]->ID_USO_EQUIPO?>" <?php if($datos_inventario_editar[0]->ID_USO_EQUIPO==$uso[$u]->ID_USO_EQUIPO){echo 'selected="selected"';}?>><?php echo  strtoupper($uso[$u]->DESCRIPCION);?></option>
<?php }?>
</select>
</div>
  </div>
</div>

<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Acci&oacute;n:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<select  id="accion_equipo" name="accion_equipo" style="color: #666; width:100%;" onKeyUp="javascript:this.value=this.value.toUpperCase();">
<option value="">  Acci&oacute;n</option>
<?php 
for($a=0;$a<sizeof($accion);$a++){?>
<option value="<?php echo $accion[$a]->ID_ACCION?>" <?php if($datos_inventario_editar[0]->ID_ACCION==$accion[$a]->ID_ACCION){echo 'selected="selected"';}?>><?php echo  strtoupper($accion[$a]->DESCRIPCION);?></option>
<?php }?>
</select>
</div>
  </div>
</div>

<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Custodio:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<input type="text" id="responsable"  name="responsable" value="<?php echo $datos_inventario_editar[0]->RESPONSABLE?>" size="40" class="form-control" placeholder=" Custodio" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
  </div>
</div>

<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Marca Equipo:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<input type="text" id="marca"  name="marca" value="<?php echo $datos_inventario_editar[0]->MARCA?>" size="40" class="form-control" placeholder=" Marca Equipo" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
  </div>
</div>




<div id="esp_otro" <?php if($nombre_equipo[0]->DESCRIPCION!='MOUSE' && $nombre_equipo[0]->DESCRIPCION!='MONITOR' && $nombre_equipo[0]->DESCRIPCION!='PC' && $nombre_equipo[0]->DESCRIPCION!='LAPTOP'){echo 'style="display:display;"';}else{echo 'style="display:none;"';}?>>

<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Modelo del Equipo:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<input type="text" id="modelo"  name="modelo" value="<?php echo $datos_inventario_editar[0]->MODELO?>" size="40" class="form-control" placeholder=" Modelo Equipo" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
  </div>
</div>


</div><!--Fin Especificacion de otros -->

<div id="espe_mouse" <?php if($nombre_equipo[0]->DESCRIPCION=='MOUSE'){echo 'style="display:display;"';}else{echo 'style="display:none;"';}?> >

<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Modelo del Mouse:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<select  id="modelo_mouse" name="modelo_mouse" style="color: #666; width:100%;" class="form-control" onKeyUp="javascript:this.value=this.value.toUpperCase();">
<option value="">  Modelo del Mouse</option>
<option value="MECANICO" <?php if($datos_mouse[0]->MODELO=="MECANICO"){echo 'selected="selected"';}?>>MECANICO</option>
<option value="OPTICO" <?php if($datos_mouse[0]->MODELO=="OPTICO"){echo 'selected="selected"';}?>>OPTICO</option>
<option value="LASER" <?php if($datos_mouse[0]->MODELO=="LASER"){echo 'selected="selected"';}?>>LASER</option>
<option value="OPTICO" <?php if($datos_mouse[0]->MODELO=="OPTICO"){echo 'selected="selected"';}?>>TRACKBALL</option>
</select>
</div>
  </div>
</div>

<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Conetor del Mouse:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<select  id="conector_mouse" name="conector_mouse" style="color: #666; width:100%;" class="form-control" onKeyUp="javascript:this.value=this.value.toUpperCase();">
<option value="">  Conetor del Mouse</option>
<option value="PS2" <?php if($datos_mouse[0]->CONECTOR=="PS2"){echo 'selected="selected"';}?>>PS2</option>
<option value="USB" <?php if($datos_mouse[0]->CONECTOR=="USB"){echo 'selected="selected"';}?>>USB</option>
<option value="WIRELESS" <?php if($datos_mouse[0]->CONECTOR=="WIRELESS"){echo 'selected="selected"';}?>>WIRELESS</option>
<option value="BLUETOOTH" <?php if($datos_mouse[0]->CONECTOR=="BLUETOOTH"){echo 'selected="selected"';}?>>BLUETOOTH</option>
</select>
</div>
  </div>
</div>


</div><!--Fin mouse -->

<div id="espe_monitor"  <?php if($nombre_equipo[0]->DESCRIPCION=='MONITOR'){echo 'style="display:display;"';}else{echo 'style="display:none;"';}?>>

<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Modelo del Monitor:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<select  id="modelo_monitor" name="modelo_monitor" style="color: #666; width:100%;" class="form-control" onKeyUp="javascript:this.value=this.value.toUpperCase();">
<option value="">  Modelo del Monitor</option>
<option value="CRT" <?php if($datos_monitor[0]->MODELO=="CRT"){echo 'selected="selected"';}?>>CRT</option>
<option value="LCD" <?php if($datos_monitor[0]->MODELO=="LCD"){echo 'selected="selected"';}?>>LCD</option>
<option value="LED" <?php if($datos_monitor[0]->MODELO=="LED"){echo 'selected="selected"';}?>>LED</option>
<option value="DLP" <?php if($datos_monitor[0]->MODELO=="DLP"){echo 'selected="selected"';}?>>DLP</option>
</select>
</div>
  </div>
</div>

</div><!--Fin Monitor -->

<div id="espe_pc"  <?php if($nombre_equipo[0]->DESCRIPCION=='PC'){echo 'style="display:display;"';}else{echo 'style="display:none;"';}?>>
<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Modelo CPU:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<select  id="cpu_pc" name="cpu_pc" style="color: #666; width:100%;"  onKeyUp="javascript:this.value=this.value.toUpperCase();">
<option value="">  Modelo CPU</option>
<option value="BAREBONE" <?php if($datos_pc[0]->CPU=="BAREBONE" || $datos_lapto[0]->CPU=="BAREBONE"){echo 'selected="selected"';}?>>BAREBONE</option>
<option value="MINITORRE" <?php if($datos_pc[0]->CPU=="MINITORRE" || $datos_lapto[0]->CPU=="MINITORRE"){echo 'selected="selected"';}?>>MINITORRE</option>
<option value="SOBREMESA" <?php if($datos_pc[0]->CPU=="SOBREMESA" || $datos_lapto[0]->CPU=="SOBREMESA"){echo 'selected="selected"';}?>>SOBREMESA</option>
<option value="SEMITORRE" <?php if($datos_pc[0]->CPU=="SEMITORRE" || $datos_lapto[0]->CPU=="SEMITORRE"){echo 'selected="selected"';}?>>SEMITORRE</option>
<option value="TORRE" <?php if($datos_pc[0]->CPU=="TORRE" || $datos_lapto[0]->CPU=="TORRE"){echo 'selected="selected"';}?>>TORRE</option>
<option value="SERVIDOR" <?php if($datos_pc[0]->CPU=="SERVIDOR" || $datos_lapto[0]->CPU=="SERVIDOR"){echo 'selected="selected"';}?>>SERVIDOR</option>
<option value="RACK" <?php if($datos_pc[0]->CPU=="RACK" || $datos_lapto[0]->CPU=="RACK"){echo 'selected="selected"';}?>>RACK</option>
<option value="PORTATIL" <?php if($datos_pc[0]->CPU=="PORTATIL" || $datos_lapto[0]->CPU=="PORTATIL"){echo 'selected="selected"';}?>>PORTATIL</option>
</select>
</div>
  </div>
</div>

<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Procesador Marca:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group"> 
<select  id="marca_procesador_p" name="marca_procesador_p" style="color: #666; width:100%;" onKeyUp="javascript:this.value=this.value.toUpperCase();">
<option value="">  Procesador Marca</option>
<?php 
for($ma=0;$ma<sizeof($marca_procesador);$ma++){?>
<option value="<?php echo $marca_procesador[$ma]->ID_MARCA_PRO?>"  <?php if($marca_procesador[$ma]->ID_MARCA_PRO==$datos_pc[0]->ID_MARCA_PRO){echo 'selected="selected"';}?>><?php echo  strtoupper($marca_procesador[$ma]->DESCRIPCION);?></option>
<?php }?>
</select>
</div>
  </div>
</div>


<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Procesador Velocidad:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<input type="text" id="velocidad_procesador"  name="velocidad_procesador" value="<?php if($datos_pc[0]->PROCESADOR_VELOCIDAD!=''){echo $datos_pc[0]->PROCESADOR_VELOCIDAD;}else{echo $datos_lapto[0]->PROCESADOR_VELOCIDAD;}?>" size="40" class="form-control" placeholder=" Procesador Velocidad" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
  </div>
</div>


<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Memoria Capacidad:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<input type="text" id="memoria_capacidad"  name="memoria_capacidad" value="<?php if($datos_pc[0]->MEMORIA_CAPACIDAD!=''){echo $datos_pc[0]->MEMORIA_CAPACIDAD;}else{echo $datos_lapto[0]->MEMORIA_CAPACIDAD;}?>" size="40" class="form-control" placeholder=" Memoria Capacidad" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
  </div>
</div>


<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Memoria Tipo:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<input type="text" id="memoria_tipo"  name="memoria_tipo" value="<?php if($datos_pc[0]->MEMORIA_TIPO!=''){echo $datos_pc[0]->MEMORIA_TIPO;}else{echo $datos_lapto[0]->MEMORIA_TIPO;}?>" size="40" class="form-control" placeholder=" Memoria Tipo" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
  </div>
</div>


<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Disco Duro Capacidad:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<input type="text" id="disco_duro_capacidad"  name="disco_duro_capacidad" value="<?php if($datos_pc[0]->DISCO_DURO_CAPACIDAD!=''){echo $datos_pc[0]->DISCO_DURO_CAPACIDAD;}else{echo $datos_lapto[0]->DISCO_DURO_CAPACIDAD;}?>" size="40" class="form-control" placeholder=" Disco Duro Capacidad" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
  </div>
</div>


<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Disco Duro Tipo:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<input type="text" id="disco_duro_tipo"  name="disco_duro_tipo" value="<?php if($datos_pc[0]->DISCO_DURO_TIPO!=''){echo $datos_pc[0]->DISCO_DURO_TIPO;}else{echo $datos_lapto[0]->DISCO_DURO_TIPO;}?>" size="40" class="form-control" placeholder=" Disco Duro Tipo" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
  </div>
</div>

<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Unidades de Lectura / Escritura:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group"> <input type="checkbox" name="unidad_lectura_escritura[]"  <?php if(strpos($datos_lapto[0]->UNIDADES_LECTURA, "CD-ROM")!== false || strpos($datos_pc[0]->UNIDADES_LECTURA, "CD-ROM")!== false){echo 'checked="checked"';}?> class="ids" value="CD-ROM"/> CD-ROM</div>
<div class="form-group"> <input type="checkbox" name="unidad_lectura_escritura[]" <?php if(strpos($datos_lapto[0]->UNIDADES_LECTURA, "CD-ROM REWRITABLE")!== false || strpos($datos_pc[0]->UNIDADES_LECTURA, "CD-ROM REWRITABLE")!== false){echo 'checked="checked"';}?>class="ids" value="CD-ROM REWRITABLE"/> CD-ROM REWRITABLE</div>
<div class="form-group"> <input type="checkbox" name="unidad_lectura_escritura[]" <?php if(strpos($datos_lapto[0]->UNIDADES_LECTURA, "DVD")!== false || strpos($datos_pc[0]->UNIDADES_LECTURA, "DVD")!== false){echo 'checked="checked"';}?>class="ids" value="DVD"/> DVD</div>
<div class="form-group"> <input type="checkbox" name="unidad_lectura_escritura[]" <?php if(strpos($datos_lapto[0]->UNIDADES_LECTURA, "DVD REWRITABLE")!== false || strpos($datos_pc[0]->UNIDADES_LECTURA, "DVD REWRITABLE")!== false){echo 'checked="checked"';}?>class="ids" value="DVD REWRITABLE"/> DVD REWRITABLE</div>

  </div>
</div>


</div>

<div id="espe_lapto"  <?php if($nombre_equipo[0]->DESCRIPCION=='LAPTOP'){echo 'style="display:display;"';}else{echo 'style="display:none;"';}?>>


<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Procesador Marca:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group"> 
<select  id="marca_procesador_l" name="marca_procesador_l" style="color: #666; width:100%;" onKeyUp="javascript:this.value=this.value.toUpperCase();">
<option value="">  Procesador Marca</option>
<?php 
for($ma=0;$ma<sizeof($marca_procesador);$ma++){?>
<option value="<?php echo $marca_procesador[$ma]->ID_MARCA_PRO?>"  <?php if($marca_procesador[$ma]->ID_MARCA_PRO==$datos_lapto[0]->ID_MARCA_PRO){echo 'selected="selected"';}?>><?php echo  strtoupper($marca_procesador[$ma]->DESCRIPCION);?></option>
<?php }?>
</select>
</div>
  </div>
</div>


<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Procesador Velocidad:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<input type="text" id="velocidad_procesador"  name="velocidad_procesador" value="<?php if($datos_lapto[0]->PROCESADOR_VELOCIDAD!=''){echo $datos_lapto[0]->PROCESADOR_VELOCIDAD;}?>" size="40" class="form-control" placeholder=" Procesador Velocidad" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
  </div>
</div>


<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Memoria Capacidad:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<input type="text" id="memoria_capacidad"  name="memoria_capacidad" value="<?php if($datos_lapto[0]->MEMORIA_CAPACIDAD!=''){echo $datos_lapto[0]->MEMORIA_CAPACIDAD;}?>" size="40" class="form-control" placeholder=" Memoria Capacidad" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
  </div>
</div>

<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Memoria Tipo:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<input type="text" id="memoria_tipo"  name="memoria_tipo" value="<?php if($datos_lapto[0]->MEMORIA_TIPO!=''){echo $datos_lapto[0]->MEMORIA_TIPO;}?>" size="40" class="form-control" placeholder=" Memoria Tipo" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
  </div>
</div>


<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Disco Duro Capacidad:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<input type="text" id="disco_duro_capacidad"  name="disco_duro_capacidad" value="<?php if($datos_lapto[0]->DISCO_DURO_CAPACIDAD!=''){echo $datos_lapto[0]->DISCO_DURO_CAPACIDAD;}?>" size="40" class="form-control" placeholder=" Disco Duro Capacidad" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
  </div>
</div>

<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Disco Duro Tipo:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<input type="text" id="disco_duro_tipo"  name="disco_duro_tipo" value="<?php if($datos_lapto[0]->DISCO_DURO_TIPO!=''){echo $datos_lapto[0]->DISCO_DURO_TIPO;}?>" size="40" class="form-control" placeholder=" Disco Duro Tipo" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
  </div>
</div>

<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Unidades de Lectura / Escritura:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<div class="form-group"> <input type="checkbox" name="unidad_lectura_escritura[]"  <?php if(strpos($datos_lapto[0]->UNIDADES_LECTURA, "CD-ROM")!== false){echo 'checked="checked"';}?> class="ids" value="CD-ROM"/> CD-ROM</div>
<div class="form-group"> <input type="checkbox" name="unidad_lectura_escritura[]" <?php if(strpos($datos_lapto[0]->UNIDADES_LECTURA, "CD-ROM REWRITABLE")!== false){echo 'checked="checked"';}?>class="ids" value="CD-ROM REWRITABLE"/> CD-ROM REWRITABLE</div>
<div class="form-group"> <input type="checkbox" name="unidad_lectura_escritura[]" <?php if(strpos($datos_lapto[0]->UNIDADES_LECTURA, "DVD")!== false){echo 'checked="checked"';}?>class="ids" value="DVD"/> DVD</div>
<div class="form-group"> <input type="checkbox" name="unidad_lectura_escritura[]" <?php if(strpos($datos_lapto[0]->UNIDADES_LECTURA, "DVD REWRITABLE")!== false){echo 'checked="checked"';}?>class="ids" value="DVD REWRITABLE"/> DVD REWRITABLE</div>
</div>
  </div>
</div>


</div>


<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>* Se encuentra en uso el Equipo:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<select  id="en_uso" name="en_uso" style="color: #666; width:100%;"  onKeyUp="javascript:this.value=this.value.toUpperCase();">
<option value=""> * Se encuentra en uso el Equipo</option>
<option value="SI" <?php if($datos_inventario_editar[0]->USO=="SI"){echo 'selected="selected"';}?>>SI</option>
<option value="NO" <?php if($datos_inventario_editar[0]->USO=="NO"){echo 'selected="selected"';}?>>NO</option>
</select>
</div>
  </div>
</div>

<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>* Posee Garant&iacute;a:</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<select  id="garantia" name="garantia" style="color: #666; width:100%;"  onKeyUp="javascript:this.value=this.value.toUpperCase();" onChange="mostrar_anno_garantia(this)">
<option value=""> * Posee Garant&iacute;a</option>
<option value="SI" <?php if($datos_inventario_editar[0]->GARANTIA=="SI"){echo 'selected="selected"';}?>>SI</option>
<option value="NO" <?php if($datos_inventario_editar[0]->GARANTIA=="NO"){echo 'selected="selected"';}?>>NO</option>
</select>
</div>
  </div>
</div>

<?php if($datos_inventario_editar[0]->ANNO_GARANTIA>0){?>
<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Año de Garant&iacute;a Equipo</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<div id="anno_garantia" style="display:display;">
<input type="text" id="anno_garantia_equipo"  name="anno_garantia_equipo" value="<?php echo $datos_inventario_editar[0]->ANNO_GARANTIA;?>" size="40" class="form-control" placeholder=" Año de Garant&iacute;a Equipo" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
</div>
  </div>
</div>
<?php }?>




<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Pertenece Proyecto</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<select  id="per_proyecto" name="per_proyecto" style="color: #666; width:100%;"  onKeyUp="javascript:this.value=this.value.toUpperCase();" onChange="mostrar_desc_proyecto(this)">
<option value="">  Pertenece Proyecto</option>
<option value="SI" <?php if($datos_inventario_editar[0]->PERTENECE_PROYECYO=="SI"){echo 'selected="selected"';}?>>SI</option>
<option value="NO" <?php if($datos_inventario_editar[0]->PERTENECE_PROYECYO=="NO"){echo 'selected="selected"';}?>>NO</option>
</select>
</div>
  </div>
</div>


<div id="posee_proyecto" <?php if($datos_inventario_editar[0]->PERTENECE_PROYECYO=='SI'){echo 'style="display:display;"';}else{echo 'style="display:none;"';}?>>
<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Titulo Proyecto Investigaci&oacute;n</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<input type="text" id="desc_proyecto"  name="desc_proyecto" value="<?php echo $datos_inventario_editar[0]->DESCRIPCION_PROYECTO;?>" size="40" class="form-control" placeholder=" Titulo Proyecto Investigaci&oacute;n" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
  </div>
</div>
</div><!--Fin titulo proyecto -->


<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Observaciones del Equipo</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group">
<textarea  id="descripcion"  name="descripcion" cols="40" rows="3" class="form-control" placeholder=" Observaciones del Equipo" onKeyUp="javascript:this.value=this.value.toUpperCase();"><?php echo $datos_inventario_editar[0]->OBSERVACIONES?></textarea>
</div>
  </div>
</div>


<div class="row">
  <div class="col-md-2">
<div class="form-group"><p align="right"><strong>Imagen del Equipo</strong></p></div>
</div>
  <div class="col-md-10">
<div class="form-group" id='box_imagen'>
<div class="file-preview {class}" id="pre_imagen">
   <div class="file-preview-status text-center text-success"></div>
   <div class=""></div>
   <div class="clearfix"></div>
 <?php if($datos_inventario_editar[0]->DIR_IMAGEN!='' && file_exists('images_inventario_equipo/'.$datos_inventario_editar[0]->DIR_IMAGEN)){?>
  <img id="redondear" src="images_inventario_equipo/<?php echo $datos_inventario_editar[0]->DIR_IMAGEN?>" class="img-thumbnail" />
   <?php } else{?>
	 <img id="redondear" src="images_inventario_equipo/sin_imagen_inventario.png"  class="img-thumbnail"/>
	<?php }?>   
   
</div>
<input id="imagen_i" name="imagen_i" type="file" class="file"   style="color:#FFFFFF">

</div>
<div class="form-group" >
<label for="imagen_i" generated="true" class="error"></label>
</div>	

  </div>
</div>




<input id="id_inventario" name="id_inventario" type="hidden" value="<?php echo $datos_inventario_editar[0]->ID_INVENTARIO;?>">	

<input id="nombre_equipo_ant" name="nombre_equipo_ant" type="hidden" value="<?php echo $datos_inventario_editar[0]->ID_EQUIPO;?>">

<input id="imagen_anterior" name="imagen_anterior" type="hidden" value="<?php echo $datos_inventario_editar[0]->DIR_IMAGEN?>">								
						<div class="form-group"><p><em>Los campos marcados con * son campos obligatorios</em></p></div>
							<div class="form-group" align="center">
							<a href="consultar.php" class="btn btn-primary">Atr&aacute;s</a>
							<input type="submit" value="Guardar"  class="btn btn-primary"/></div>
																					
							</form>
					
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/select2.js"></script>
	<script src="js/bootstrap.min.js"></script>	
	<script src="js/jquery-1.7.validate.min.js"></script>
	<script src="js/fileinput.min.js" type="text/javascript"></script>
	
	<script>
		
 function mostrar_especificaciones(sel) {
 var res = sel.value.split("-");
   if (res[1]=="MOUSE"){
           $("#espe_mouse").show();
           $("#esp_otro").hide();
		   $("#espe_monitor").hide();
		   $("#espe_pc").hide();
		   $("#espe_lapto").hide();
		}   
      if (res[1]=="MONITOR"){
		  $("#espe_monitor").show();
           $("#esp_otro").hide();
		   $("#espe_mouse").hide();
		   $("#espe_pc").hide();
		    $("#espe_lapto").hide();

      }
	  if (res[1]=="PC"){
		  $("#espe_pc").show();
           $("#esp_otro").hide();
		   $("#espe_mouse").hide();
		   $("#espe_monitor").hide();
		   $("#espe_lapto").hide();

      }
	   if (res[1]=="LAPTOP"){
	      $("#espe_lapto").show();
		  $("#espe_pc").hide();
          $("#esp_otro").hide();
		  $("#espe_mouse").hide();
		  $("#espe_monitor").hide();
		  

      }
	   if (res[1]!="MOUSE" && res[1]!="MONITOR" && res[1]!="PC" && res[1]!="LAPTOP"){
		  $("#esp_otro").show();
           $("#espe_pc").hide();
		   $("#espe_mouse").hide();
		   $("#espe_monitor").hide();
		   $("#espe_lapto").hide();

      }
}		

function mostrar_desc_proyecto(sel) {
  if(sel.value=='SI'){
   $("#posee_proyecto").show();
   } 
   else{
    $("#posee_proyecto").hide();
   }
		
}

function mostrar_anno_garantia(sel) {
  if(sel.value=='SI'){
   $("#anno_garantia").show();
   } 
   else{
    $("#anno_garantia").hide();
   }
		
}

function mostrar_diagnostico(sel) {

  if(sel.value=='1'){
   $("#diagnos").show();
   } 
   else{
    $("#diagnos").hide();
   }
		
}

function mostrar_anno_garantia(sel) {
  if(sel.value=='SI'){
   $("#anno_garantia").show();
   } 
   else{
    $("#anno_garantia").hide();
   }
		
}
		
 $(document).ready(function () {
  	$.validator.addMethod("valueNotEquals", function(value, element, arg){
		  return arg != value;
		 }, "Value must not equal arg.");

 $.validator.addMethod('filesize', function (value, element, param) {
    return this.optional(element) || (element.files[0].size <= param)
}, 'File size must be less than {0}');
  
$("#imagen_i").fileinput(
	{
	 initialPreview: [
            '<img src="images_inventario_equipo/10_INVENTARIO_GENERAL_2017_01_18.jpg" class="file-preview-image" alt="The Moon" title="The Moon">'
        ]
	}
);
	    

 

    $('#formulario').validate({ // initialize the plugin
	
       rules: {
           "id_tecnico": { 
				valueNotEquals: ""
			},
		   "nombre_equipo": { 
				valueNotEquals: ""
			},
			 "condicion_equipo": { 
				valueNotEquals: ""
			},
			 "id_departamento": { 
				valueNotEquals: ""
			},
			 "uso_equipo": { 
				valueNotEquals: ""
			},
			"en_uso": { 
				valueNotEquals: ""
			},
			 "garantia": { 
				valueNotEquals: ""
			},
			
			"ubicacion": { 
				required: true,
				minlength: 5
			},
			"imagen_i": {
			 accept:"jpg|png|jpeg|gif",
			 filesize: 1048576 
			},
			'anno_garantia_equipo': { 
				number: true 
			}
        },
        messages: {
			"id_tecnico": { 
			 	valueNotEquals: "Seleccione el T&eacute;cnico."
			},
			"nombre_equipo": { 
			 	valueNotEquals: "Seleccione el Equipo."
			},
			"condicion_equipo":{
				valueNotEquals: "Seleccione el Estado del Equipo."
			}
			,
			"id_departamento":{
				valueNotEquals: "Seleccione la Dependencia a la que pertenece el Equipo."
			},
			 "uso_equipo": { 
				valueNotEquals: "Seleccione el uso del Equipo."
			},
			"en_uso":{
				valueNotEquals: "Seleccione si el Equipo se encuentra en uso o no."
			},
			"garantia":{
				valueNotEquals: "Seleccione si el Equipo Posee garant&iacute;a ."
			},
			"ubicacion": { 
				required: "Debe introducir la Ubicaci&oacute;n del Equipo.",
				minlength:"La ubicaci&oacute;n del Equioi debe tener m&iacute;nimo 5 caracteres."
				
			},
			"imagen_i": {
			   accept: "Tipo de archivo no permitodo. Solo imagen.",
			   filesize: "Tamaño m&aacute;ximo permitido 1MB."
			},
			"anno_garantia_equipo": {
			   number: "Ingrese solo n&uacute;mero."
			}		
			 
    
        },
	 submitHandler: function (form) { // for demo
		/*
		var V_USUARIO_TECNICO = $("#id_tecnico").val();
		var V_NOMBRE_EQUIPO = $("#nombre_equipo").val();
		var V_SERIAL_EQUIPO = $("#serial_equipo").val();
		var V_SERIAL_UST = $("#serial_ust").val();
		var V_ID_DEPARTAMENTO = $("#id_departamento").val();
		var V_UBICACION = $("#ubicacion").val();
		var V_USO = $("#uso_equipo").val();
		var V_ACCION = $("#accion_equipo").val();
		var V_RESPONSABLE = $("#responsable").val();
		var V_MARCA = $("#marca").val();
		var V_MODELO = $("#modelo").val();
		var V_MODELO_MOUSE = $("#modelo_mouse").val();
		var V_CONECTOR_MOUSE = $("#conector_mouse").val();
		var V_MODELO_MONITOR = $("#modelo_monitor").val();
		var V_CPU_PC = $("#cpu_pc").val();
		var V_MARCA_PROCESADOR = $("#marca_procesador").val();
		var V_TIPO_PROCESADOR = $("#tipo_procesador").val();
		var V_VELOCIDAD_PROCESADOR = $("#velocidad_procesador").val();
		var V_MEMORIA_CAPACIDAD = $("#memoria_capacidad").val();
		var V_MEMORIA_TIPO = $("#memoria_tipo").val();
		var V_DISCO_DURO_CAPACIDAD = $("#disco_duro_capacidad").val();
		var V_DISCO_DURO_TIPO = $("#disco_duro_tipo").val();
		var V_UNIDAD_LECTURA_ESCRITURA = $('.ids:checked').serialize();
		var V_CONDICION_EQUIPO = $("#condicion_equipo").val();
		var V_EN_USO = $("#en_uso").val();
		var V_GARANTIA = $("#garantia").val();
		var V_PERT_PROYECTO = $("#per_proyecto").val();
		var V_DESC_PROYECTO = $("#desc_proyecto").val();
		var V_DESCRIPCION = $("#descripcion").val();
		var V_NOMBRE_EQUIPO_ANT = $("#nombre_equipo_ant").val();
		var V_ID_INVENTARIO = $("#id_inventario").val();
		
		//var V_IMAGEN = $('#imagen_i');
		
		//console.log(V_IMAGEN);
				
			var ids = [];
			$('.ids:checked').each(function(i, e) {
				ids.push($(this).val());
			});
		
		   var parametros = {
		    "usuario_tecnico"  :V_USUARIO_TECNICO,
			"nombre_equipo"  :V_NOMBRE_EQUIPO,
			"serial_equipo"  : V_SERIAL_EQUIPO,
			"serial_ust"  : V_SERIAL_UST,
			"id_departamento"  : V_ID_DEPARTAMENTO,
			"ubicacion"  : V_UBICACION,
			"uso_equipo"  : V_USO,
			"accion_equipo"  : V_ACCION,
			"responsable"  : V_RESPONSABLE,
			"marca"  : V_MARCA,
			"modelo"  :V_MODELO,
			"modelo_mouse"  : V_MODELO_MOUSE,
			"conector_mouse"  : V_CONECTOR_MOUSE,
			"modelo_monitor"  : V_MODELO_MONITOR,
			"cpu_pc"  : V_CPU_PC,
			"marca_procesador"  : V_MARCA_PROCESADOR,
			"tipo_procesador"  : V_TIPO_PROCESADOR,
			"velocidad_procesador"  : V_VELOCIDAD_PROCESADOR,
			"memoria_capacidad"  : V_MEMORIA_CAPACIDAD,
			"memoria_tipo"  : V_MEMORIA_TIPO,
			"disco_duro_capacidad"  : V_DISCO_DURO_CAPACIDAD,
			"disco_duro_tipo"  : V_DISCO_DURO_TIPO,
			'unidad_lectura_escritura[]': ids.join(),
			//"unidad_lectura_escritura"  : V_UNIDAD_LECTURA_ESCRITURA ,
			"condicion_equipo"  : V_CONDICION_EQUIPO,
			"en_uso"  : V_EN_USO,
			"garantia"  : V_GARANTIA,
			"per_proyecto"  : V_PERT_PROYECTO,
			"desc_proyecto"  : V_DESC_PROYECTO,
			"descripcion"  : V_DESCRIPCION,
			"nombre_equipo_ant"  :V_NOMBRE_EQUIPO_ANT,
			//"imagen_i" : V_IMAGEN,
			"id_inventario": V_ID_INVENTARIO
			


			};			
			
			/*var ids = [];
			$('.ids:checked').each(function(i, e) {
				ids.push($(this).val());
			});*/
			
			
			/*var formData = new FormData(document.getElementById("formulario"));
			formData.append('imagen_i', $('#imagen_i')[0].files[0]);
			formData.append('unidad_lectura_escritura[]', ids.join());*/
			
			var formData = new FormData(document.getElementById("formulario"));
			formData.append('imagen_i', $('#imagen_i')[0].files[0]);
			
		
			formData.append('velocidad_procesador', $("#velocidad_procesador").val());
			formData.append('memoria_capacidad', $("#memoria_capacidad").val());
			formData.append('memoria_tipo', $("#memoria_tipo").val());
			formData.append('disco_duro_capacidad', $("#disco_duro_capacidad").val());
			formData.append('disco_duro_tipo', $("#disco_duro_tipo").val());
			
			 $.ajax({
			 	data:  formData,
              	url:   'proc_editar.php',
                type:  'POST',
				mimeType: "multipart/form-data",
				processData: false,  // tell jQuery not to process the data
      			contentType: false,  // tell jQuery not to set contentType
                beforeSend: function () {
                        $("#contenido_modal_e").html("Procesando, espere por favor...");
                },
                success:  function (response) {
					   $("#contenido_modal_e").html(response);
						//alert("33333Datos insertados satisfactoriamente");
						//window.location.reload();
					
						
                }
            });
           
        }
    });

});
	</script>	
