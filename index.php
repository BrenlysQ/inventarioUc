<?php
header("Content-Type: text/html;charset=utf-8");
include("lib/bd_conexion.php");

$bd=new bd_conexion();

$tecnico=$bd->consultaObjeto(array("USUARIO","NOMBRE"),"tecnico","1",0);
$equipo=$bd->consultaObjeto(array("ID_EQUIPO","DESCRIPCION"),"equipo","1 ORDER BY DESCRIPCION ASC ",0);
$departamento=$bd->consultaObjeto(array("id_dependencia","dependen"),"dec_dependencia","1",0);
$condicion=$bd->consultaObjeto(array("ID_CONDICION","DESCRIPCION"),"condicion","1",0);
$accion=$bd->consultaObjeto(array("ID_ACCION","DESCRIPCION"),"accion","1",0);
$uso=$bd->consultaObjeto(array("ID_USO_EQUIPO","DESCRIPCION"),"uso_equipo","1",0);
$marca_procesador=$bd->consultaObjeto(array("ID_MARCA_PRO","DESCRIPCION"),"marca_procesador","1 ORDER BY DESCRIPCION ASC",0);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Inventario</title>

<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
<link href="css/select2.css" rel="stylesheet">
<link href="css/fileinput.css" media="all" rel="stylesheet" type="text/css" />


<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
							
		</div><!-- /.container-fluid -->
	</nav>
		
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		
	<?php include("menues/menu_principal.php");?>
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
			
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Agregar Equipo</h1>
			</div>
		</div><!--/.row-->
	
					
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					
					<div class="panel-body">
						<div class="col-md-12">
						
						<div id="resultado_rt" style="color:#005B88; text-align:center; size:500">&nbsp;</div>
<form id="formulario" name="formulario" method="post" enctype="multipart/form-data">	
<div class="form-group">
<select  id="id_tecnico" name="id_tecnico" style="color: #666; width:100%;">
<option value="">* T&eacute;cnico</option>
<?php 
for($t=0;$t<sizeof($tecnico);$t++){?>
<option value="<?php echo $tecnico[$t]->USUARIO?>"><?php echo strtoupper($tecnico[$t]->NOMBRE);?></option>
<?php }?>
</select>
</div>

<div class="form-group">
							
<select  id="nombre_equipo" name="nombre_equipo" style="color: #666; width:100%;" onChange="mostrar_especificaciones(this)">
<option value="">* Tipo del Equipo</option>
<?php 
for($e=0;$e<sizeof($equipo);$e++){?>
<option value="<?php echo $equipo[$e]->ID_EQUIPO?>-<?php echo $equipo[$e]->DESCRIPCION?>"><?php echo $equipo[$e]->DESCRIPCION?></option>
<?php }?>
</select>
</div>
<div class="form-group">
<input type="text" id="serial_equipo"  name="serial_equipo" value="" size="40" class="form-control" placeholder=" Serial Equipo" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
<div class="form-group">
<input type="text" id="serial_ust"  name="serial_ust" value="" size="40" class="form-control" placeholder=" Serial UC" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div> 
<div class="form-group">
<input type="text" id="serial_facyt"  name="serial_facyt" value="" size="40" class="form-control" placeholder=" Serial FaCyt" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div> 

<div class="form-group">                      
<select  id="condicion_equipo" name="condicion_equipo" style="color: #666; width:100%;" onKeyUp="javascript:this.value=this.value.toUpperCase();" onChange="mostrar_diagnostico(this)">
<option value="">* Situaci&oacute;n del Equipo</option>
<?php 
for($c=0;$c<sizeof($condicion);$c++){?>
<option value="<?php echo $condicion[$c]->ID_CONDICION?>"><?php echo $condicion[$c]->DESCRIPCION?></option>
<?php }?>
</select>
</div>

<div id="diagnos" style="display:none;">
<div class="form-group"> 
	<textarea  id="diagnostico"  name="diagnostico" cols="40" rows="3" class="form-control" placeholder=" Diag&oacute;stico del Equipo" onKeyUp="javascript:this.value=this.value.toUpperCase();"></textarea>

</div>
<div class="form-group">
<input type="text" id="pieza_dannada"  name="pieza_dannada" value="" size="40" class="form-control" placeholder=" Pieza Da&ntilde;ada" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>

<div class="form-group"> 
	<textarea  id="recomendacion_tec"  name="recomendacion_tec" cols="40" rows="3" class="form-control" placeholder=" Recomendaci&oacute;n T&eacute;cnico" onKeyUp="javascript:this.value=this.value.toUpperCase();"></textarea>

</div>

</div>


<div class="form-group">  
<select  id="id_departamento" name="id_departamento" style="color: #666; width:100%;"  onKeyUp="javascript:this.value=this.value.toUpperCase();">
<option value=""> * Dependencia</option>
<?php 
for($d=0;$d<sizeof($departamento);$d++){?>
<option value="<?php echo $departamento[$d]->id_dependencia?>"><?php echo  strtoupper($departamento[$d]->dependen);?></option>
<?php }?>
</select>
</div>

<div class="form-group">
	<textarea  id="ubicacion"  name="ubicacion" cols="40" rows="3" class="form-control" placeholder=" * Lugar de Ubicaci&oacute;n" onKeyUp="javascript:this.value=this.value.toUpperCase();"></textarea>
</div>
		
<div class="form-group">  
<select  id="uso_equipo" name="uso_equipo" style="color: #666; width:100%;" onKeyUp="javascript:this.value=this.value.toUpperCase();">
<option value=""> * Uso del Equipo</option>
<?php 
for($u=0;$u<sizeof($uso);$u++){?>
<option value="<?php echo $uso[$u]->ID_USO_EQUIPO?>"><?php echo  strtoupper($uso[$u]->DESCRIPCION);?></option>
<?php }?>
</select>
</div>

<div class="form-group">  
<select  id="accion_equipo" name="accion_equipo" style="color: #666; width:100%;" onKeyUp="javascript:this.value=this.value.toUpperCase();">
<option value="">  Acci&oacute;n</option>
<?php 
for($a=0;$a<sizeof($accion);$a++){?>
<option value="<?php echo $accion[$a]->ID_ACCION?>"><?php echo  strtoupper($accion[$a]->DESCRIPCION);?></option>
<?php }?>
</select>
</div>

<div class="form-group"> 
<input type="text" id="responsable"  name="responsable" value="" size="40" class="form-control" placeholder=" Custodio" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
<div class="form-group" > 

<div class="form-group"> 
<input type="text" id="marca"  name="marca" value="" size="40" class="form-control" placeholder=" Marca Equipo" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
</div>

<div id="esp_otro" style="display:none;">
<div class="form-group"> 
<input type="text" id="modelo"  name="modelo" value="" size="40" class="form-control" placeholder=" Modelo Equipo" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
</div>

<div id="espe_mouse" style="display:none;">
<div class="form-group"> 
<select  id="modelo_mouse" name="modelo_mouse" style="color: #666; width:100%;" class="form-control" onKeyUp="javascript:this.value=this.value.toUpperCase();">
<option value="">  Modelo del Equipo</option>
<option value="MECANICO">MECANICO</option>
<option value="OPTICO">OPTICO</option>
<option value="LASER">LASER</option>
<option value="OPTICO">TRACKBALL</option>
</select>
</div>
<div class="form-group"> 
<select  id="conector_mouse" name="conector_mouse" style="color: #666; width:100%;" class="form-control" onKeyUp="javascript:this.value=this.value.toUpperCase();">
<option value="">  Conetor del Mouse</option>
<option value="PS2">PS2</option>
<option value="USB">USB</option>
<option value="WIRELESS">WIRELESS</option>
<option value="BLUETOOTH">BLUETOOTH</option>
</select>
</div>
</div>

<div id="espe_monitor" style="display:none;">
<div class="form-group"> 
<select  id="modelo_monitor" name="modelo_monitor" style="color: #666; width:100%;" class="form-control" onKeyUp="javascript:this.value=this.value.toUpperCase();">
<option value="">  Modelo del Equipo</option>
<option value="CRT">CRT</option>
<option value="LCD">LCD</option>
<option value="LED">LED</option>
<option value="DLP">DLP</option>
</select>
</div>
</div>

<div id="espe_pc" style="display:none;">
<div class="form-group"> 
<select  id="cpu_pc" name="cpu_pc" style="color: #666; width:100%;"  onKeyUp="javascript:this.value=this.value.toUpperCase();">
<option value="">  Modelo CPU</option>
<option value="BAREBONE">BAREBONE</option>
<option value="MINITORRE">MINITORRE</option>
<option value="SOBREMESA">SOBREMESA</option>
<option value="SEMITORRE">SEMITORRE</option>
<option value="TORRE">TORRE</option>
<option value="SERVIDOR">SERVIDOR</option>
<option value="RACK">RACK</option>
<option value="PORTATIL">PORTATIL</option>
</select>
</div>

<div class="form-group"> 
<select  id="marca_procesador_p" name="marca_procesador_p" style="color: #666; width:100%;" onKeyUp="javascript:this.value=this.value.toUpperCase();">
<option value="">  Procesador Marca</option>
<?php 
for($ma=0;$ma<sizeof($marca_procesador);$ma++){?>
<option value="<?php echo $marca_procesador[$ma]->ID_MARCA_PRO?>"><?php echo  strtoupper($marca_procesador[$ma]->DESCRIPCION);?></option>
<?php }?>
</select>
</div>


<div class="form-group"> 
<input type="text" id="velocidad_procesador"  name="velocidad_procesador" value="" size="40" class="form-control" placeholder=" Procesador Velocidad" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
<div class="form-group"> 
<input type="text" id="memoria_capacidad"  name="memoria_capacidad" value="" size="40" class="form-control" placeholder=" Memoria Capacidad" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
<div class="form-group"> 
<input type="text" id="memoria_tipo"  name="memoria_tipo" value="" size="40" class="form-control" placeholder=" Memoria Tipo" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
<div class="form-group"> 
<input type="text" id="disco_duro_capacidad"  name="disco_duro_capacidad" value="" size="40" class="form-control" placeholder=" Disco Duro Capacidad" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
<div class="form-group"> 
<input type="text" id="disco_duro_tipo"  name="disco_duro_tipo" value="" size="40" class="form-control" placeholder=" Disco Duro Tipo" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
<div class="form-group"> 
<strong> Unidades de Lectura / Escritura</strong><br>
<div class="form-group"> <input type="checkbox" name="unidad_lectura_escritura[]" class="ids" value="CD-ROM"/> CD-ROM</div>
<div class="form-group"> <input type="checkbox" name="unidad_lectura_escritura[]" class="ids" value="CD-ROM REWRITABLE"/> CD-ROM REWRITABLE</div>
<div class="form-group"> <input type="checkbox" name="unidad_lectura_escritura[]" class="ids" value="DVD"/> DVD</div>
<div class="form-group"> <input type="checkbox" name="unidad_lectura_escritura[]" class="ids" value="DVD REWRITABLE"/> DVD REWRITABLE</div>
</div>
</div>

<div id="espe_lapto" style="display:none;">
<div class="form-group"> 
<select  id="marca_procesador_l" name="marca_procesador_l" style="color: #666; width:100%;" onKeyUp="javascript:this.value=this.value.toUpperCase();">
<option value="">  Procesador Marca</option>
<?php 
for($ma=0;$ma<sizeof($marca_procesador);$ma++){?>
<option value="<?php echo $marca_procesador[$ma]->ID_MARCA_PRO?>"><?php echo  strtoupper($marca_procesador[$ma]->DESCRIPCION);?></option>
<?php }?>
</select>
</div>

<div class="form-group"> 
<input type="text" id="velocidad_procesador"  name="velocidad_procesador" value="" size="40" class="form-control" placeholder=" Procesador Velocidad" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
<div class="form-group"> 
<input type="text" id="memoria_capacidad"  name="memoria_capacidad" value="" size="40" class="form-control" placeholder=" Memoria Capacidad" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
<div class="form-group"> 
<input type="text" id="memoria_tipo"  name="memoria_tipo" value="" size="40" class="form-control" placeholder=" Memoria Tipo" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
<div class="form-group"> 
<input type="text" id="disco_duro_capacidad"  name="disco_duro_capacidad" value="" size="40" class="form-control" placeholder=" Disco Duro Capacidad" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
<div class="form-group"> 
<input type="text" id="disco_duro_tipo"  name="disco_duro_tipo" value="" size="40" class="form-control" placeholder=" Disco Duro Tipo" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
<div class="form-group"> 
<strong> Unidades de Lectura / Escritura</strong><br>
<div class="form-group"> <input type="checkbox" name="unidad_lectura_escritura[]" class="ids" value="CD-ROM"/> CD-ROM</div>
<div class="form-group"> <input type="checkbox" name="unidad_lectura_escritura[]" class="ids" value="CD-ROM REWRITABLE"/> CD-ROM REWRITABLE</div>
<div class="form-group"> <input type="checkbox" name="unidad_lectura_escritura[]" class="ids" value="DVD"/> DVD</div>
<div class="form-group"> <input type="checkbox" name="unidad_lectura_escritura[]" class="ids" value="DVD REWRITABLE"/> DVD REWRITABLE</div>
</div>
</div>

<div class="form-group"> <select  id="en_uso" name="en_uso" style="color: #666; width:100%;"  onKeyUp="javascript:this.value=this.value.toUpperCase();">
<option value=""> * Se encuentra en uso el Equipo</option>
<option value="SI">SI</option>
<option value="NO">NO</option>
</select>
</div>

<div class="form-group"> <select  id="garantia" name="garantia" style="color: #666; width:100%;"  onKeyUp="javascript:this.value=this.value.toUpperCase();" onChange="mostrar_anno_garantia(this)">
<option value=""> * Posee Garant&iacute;a</option>
<option value="SI">SI</option>
<option value="NO">NO</option>
</select>
</div>
<div id="anno_garantia" style="display:none;">
<div class="form-group"> 
<input type="text" id="anno_garantia_equipo"  name="anno_garantia_equipo" value="" size="40" class="form-control" placeholder=" Año de Garant&iacute;a Equipo" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
</div>

<div class="form-group"> <select  id="per_proyecto" name="per_proyecto" style="color: #666; width:100%;"  onKeyUp="javascript:this.value=this.value.toUpperCase();" onChange="mostrar_desc_proyecto(this)">
<option value="">  Pertenece Proyecto</option>
<option value="SI">SI</option>
<option value="NO">NO</option>
</select>
</div>
<div id="posee_proyecto" style="display:none;">
<div class="form-group"> 
<input type="text" id="desc_proyecto"  name="desc_proyecto" value="" size="40" class="form-control" placeholder=" Titulo Proyecto Investigaci&oacute;n" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
</div>
<div class="form-group">
	<textarea  id="descripcion"  name="descripcion" cols="40" rows="3" class="form-control" placeholder=" Observaciones del Equipo" onKeyUp="javascript:this.value=this.value.toUpperCase();"></textarea>
</div>

<div class="form-group" id='box_imagen'>

<input id="imagen_i" name="imagen_i" type="file" class="file"   style="color:#FFFFFF">

</div>
<div class="form-group" >
<label for="imagen_i" generated="true" class="error"></label>
</div>		
						<div class="form-group"><p><em>Los campos marcados con * son campos obligatorios</em></p></div>
							<div class="form-group" align="center">
							<a href="consultar.php" class="btn btn-primary">Atr&aacute;s</a>
							<input  id="registrar" type="submit" value="Registrar"  class="btn btn-primary"/></div>
																					
							</form>
					</div>
				</div>
			</div><!-- /.col-->
		</div><!-- /.row -->
		
	</div><!--/.main-->

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

mostrar_especificaciones(document.getElementById('nombre_equipo'));		
mostrar_diagnostico(document.getElementById('condicion_equipo'));	
mostrar_desc_proyecto(document.getElementById('per_proyecto'));
mostrar_anno_garantia(document.getElementById('garantia')) ;
		
 $(document).ready(function () {
  	$.validator.addMethod("valueNotEquals", function(value, element, arg){
		  return arg != value;
		 }, "Value must not equal arg.");
  

 $.validator.addMethod('filesize', function (value, element, param) {
    return this.optional(element) || (element.files[0].size <= param)
}, 'File size must be less than {0}');

   
$('#nombre_equipo').select2();	
$('#condicion_equipo').select2();
$('#id_tecnico').select2();		
$('#id_departamento').select2();			
$('#uso_equipo').select2();	
$("#accion_equipo").select2().select2("val", 1);	
///$('#accion_equipo').select2("val","SIGUE EN FUNCIONAMIENTO");	
$('#en_uso').select2();	
$('#garantia').select2();	
$('#per_proyecto').select2();	
$('#marca_procesador_l').select2();	
$('#marca_procesador_p').select2();	

$('#cpu_pc').select2();	


			
   
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
				minlength:"La ubicaci&oacute;n del Equipo debe tener m&iacute;nimo 5 caracteres."
				
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
		var V_SERIAL_FACYT = $("#serial_facyt").val();	
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
		var V_DIAGNOSTICO = $("#diagnostico").val();
		var V_EN_USO = $("#en_uso").val();
		var V_GARANTIA = $("#garantia").val();
		var V_PERT_PROYECTO = $("#per_proyecto").val();
		var V_DESC_PROYECTO = $("#desc_proyecto").val();
		var V_DESCRIPCION = $("#descripcion").val();
		//var V_IMAGEN = $("#imagen_i").val();
	
		
		var ids = [];
			$('.ids:checked').each(function(i, e) {
				ids.push($(this).val());
			});

		
		     var parametros = {
		    "usuario_tecnico"  :V_USUARIO_TECNICO,
			"nombre_equipo"  :V_NOMBRE_EQUIPO,
			"serial_equipo"  : V_SERIAL_EQUIPO,
			"serial_ust"  : V_SERIAL_UST,
			"serial_facyt"  : V_SERIAL_FACYT,	
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
			"diagnostico":V_DIAGNOSTICO,
			"en_uso"  : V_EN_USO,
			"garantia"  : V_GARANTIA,
			"per_proyecto"  : V_PERT_PROYECTO,
			"desc_proyecto"  : V_DESC_PROYECTO,
			"descripcion"  : V_DESCRIPCION
			//"imagen_i"  : V_IMAGEN
			
					

			};*/
		

			var formData = new FormData(document.getElementById("formulario"));
			formData.append('imagen_i', $('#imagen_i')[0].files[0]);
			
			formData.append('marca_procesador', $("#marca_procesador").val());
			formData.append('velocidad_procesador', $("#velocidad_procesador").val());
			formData.append('memoria_capacidad', $("#memoria_capacidad").val());
			formData.append('memoria_tipo', $("#memoria_tipo").val());
			formData.append('disco_duro_capacidad', $("#disco_duro_capacidad").val());
			formData.append('disco_duro_tipo', $("#disco_duro_tipo").val());
			
			
			/*formData.append('unidad_lectura_escritura[]', ids.join());*/
			
			 $.ajax({
                data:  formData,
                url:   'proc_ingresar.php',
                type:  'POST',
				mimeType: "multipart/form-data",
				processData: false,  // tell jQuery not to process the data
      			contentType: false,  // tell jQuery not to set contentType
                beforeSend: function () {
                        $("#resultado_rt").html("Procesando, espere por favor...");
                },
                success:  function (response) {
					   $("#resultado_rt").html(response);
					   // document.getElementById('resultado_rt').innerHTML='Datos Ingresados Satisfactoriamente';  
						//alert("33333Datos insertados satisfactoriamente");
						//window.location.reload();
					
						
                }
            });
           
        }
    });

});


	</script>	
</body>

</html>