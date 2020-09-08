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

$procesador_marca=$bd->consultaObjeto(array("ID_MARCA_PRO","DESCRIPCION"),"marca_procesador","1 ORDER BY DESCRIPCION ASC",0);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Inventario</title>

<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
<link href="css/jquery.dataTables.css" rel="stylesheet">
<link href="css/select2.css" rel="stylesheet">



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
<div id='contenido_principal'>			
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
			
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Reportes Inventario de Equipo</h1>
			</div>
		</div><!--/.row-->
	
					
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					
					<div class="panel-body">
						<div class="col-md-12">
						

<div class="table-responsive">

<form id="formulario" name="formulario" method="post" enctype="multipart/form-data">	

<div class="form-group">
							
<select  id="nombre_equipo" name="nombre_equipo" style="color: #666; width:100%;" onChange="mostrar_especificaciones(this)">
<option value="">  Tipo del Equipo</option>
<?php 
for($e=0;$e<sizeof($equipo);$e++){?>
<option value="<?php echo $equipo[$e]->ID_EQUIPO?>-<?php echo $equipo[$e]->DESCRIPCION?>"><?php echo $equipo[$e]->DESCRIPCION?></option>
<?php }?>
</select>
</div>

<div id="espe_pc_laptop" style="display:none">

<div class="form-group">
				
<select  id="proc_marca" name="proc_marca" style="color: #666; width:100%;">
<option value="">  Marca del Procesador</option>
<?php 

for($pm=0;$pm<sizeof($procesador_marca);$pm++){?>
<option value="<?php echo $procesador_marca[$pm]->ID_MARCA_PRO?>"><?php echo $procesador_marca[$pm]->DESCRIPCION?></option>
<?php }?>
</select>
</div>

<div class="form-group" id="proc_marca_resultado">
							
<select  id="proc_tipo" name="proc_tipo" style="color: #666; width:100%;">
<option value="">  Tipo del Procesador</option>
</select>
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
</div>
</div>

<div id="espe_impresora" style="display:none;">

<div class="form-group"> 
<input type="text" id="toner_impresora" name="toner_impresora"  value="" placeholder="Tipo de Toner" class="form-control" onKeyUp="javascript:this.value=this.value.toUpperCase();">
</div>
</div>

<div class="form-group">                      
<select  id="condicion_equipo" name="condicion_equipo" style="color: #666; width:100%;" onKeyUp="javascript:this.value=this.value.toUpperCase();">
<option value="">  Situaci&oacute;n del Equipo</option>
<?php 
for($c=0;$c<sizeof($condicion);$c++){?>
<option value="<?php echo $condicion[$c]->ID_CONDICION?>"><?php echo $condicion[$c]->DESCRIPCION?></option>
<?php }?>
</select>
</div>

<div class="form-group">
<select  id="id_tecnico" name="id_tecnico" style="color: #666; width:100%;">
<option value="">  T&eacute;cnico</option>
<?php 
for($t=0;$t<sizeof($tecnico);$t++){?>
<option value="<?php echo $tecnico[$t]->USUARIO?>"><?php echo strtoupper($tecnico[$t]->NOMBRE);?></option>
<?php }?>
</select>
</div>

<div class="form-group">  
<select  id="id_departamento" name="id_departamento" style="color: #666; width:100%;"  onKeyUp="javascript:this.value=this.value.toUpperCase();">
<option value="">  Dependencia</option>
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
<option value="">  Uso del Equipo</option>
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


<div class="form-group"> <select  id="garantia" name="garantia" style="color: #666; width:100%;"  onKeyUp="javascript:this.value=this.value.toUpperCase();" >
<option value="">  Posee Garant&iacute;a</option>
<option value="SI">SI</option>
<option value="NO">NO</option>
</select>
</div>


<div class="form-group"> <select  id="per_proyecto" name="per_proyecto" style="color: #666; width:100%;"  onKeyUp="javascript:this.value=this.value.toUpperCase();">
<option value="">  Pertenece Proyecto</option>
<option value="SI">SI</option>
<option value="NO">NO</option>
</select>
</div>


<div class="form-group" align="center">
<a href="consultar.php" class="btn btn-primary">Atr&aacute;s</a>
<input  id="reporte" type="submit" value="Generar Reporte"  class="btn btn-primary"/>
</div>

<div id="resultado_rt" style="color:#005B88; text-align:center; size:500">&nbsp;</div><br>	


</form>


</div> <!--/ fin table-responsive-->
					</div> <!--/ fin col-md-12-->
					</div><!-- / fin panel-body-->
				</div>	<!--/ fin panel panel-default-->




			</div><!-- clo-lg-12-->				

			</div> <!-- / fin row-->
			</div><!-- /.col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main-->		
		</div><!-- / fin contenido_principal -->
</div><!-- / fin sidebar-collapse col-sm-3 colg-lg-2 -->



	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/select2.js"></script>
	<script src="js/bootstrap.min.js"></script>	
	<script src="js/jquery-1.7.validate.min.js"></script>
	<script src="js/fileinput.min.js" type="text/javascript"></script>
	<script>

$(document).ready(function(){
   $("#proc_marca").change(function () {
           $("#proc_marca option:selected").each(function () {
            elegido=$(this).val();
            $.post("proc_especificaciones_equi.php", { id_marca: elegido }, function(data){
            $("#proc_tipo").html(data);
            });            
        });
   })
});
		

 function mostrar_especificaciones(sel) {
 var res = sel.value.split("-");
     
	  if (res[1]=="PC"){
		  $("#espe_pc_laptop").show();
		  $("#espe_pc").show();
		  $("#espe_impresora").hide();
                 }
	   if (res[1]=="LAPTOP"){
		  $("#espe_pc_laptop").show();
		  $("#espe_pc").hide();
		    $("#espe_impresora").hide();
		  

      }
       if (res[1]=="IMPRESORA"){
   	  	$("#espe_impresora").show();
	   	$("#espe_lapto").hide();
		$("#espe_pc").hide();

}

	   if (res[1]!="PC" && res[1]!="LAPTOP" && res[1]!="IMPRESORA"){
		  $("#espe_pc_laptop").hide();
		  $("#espe_pc").hide();
		    $("#espe_impresora").hide();
          
      }
}
	
	
function mostrar_tipo_procesador(sel) {

var res = sel.value.split("-");

 var parametros = {
		    "tipo_equipo"  :res[1]

			};

 $.ajax({
                data:  parametros,
                url:   'proc_especificaciones_equi.php',
                type:  'POST',
                beforeSend: function () {
                        $("#det_procesador").html("Procesando, espere por favor...");
                },
                success:  function (response) {
					   $("#det_procesador").html(response);
						//alert("33333Datos insertados satisfactoriamente");
						//window.location.reload();
					
						
                }
            });

/* var res = sel.value.split("-");
   if (res[1]=="PC" || res[1]=="LAPTOP"){
           $("#det_procesador").show();
		}
	else{
		  $("#det_procesador").hide();
	}  */ 
		
}	

mostrar_especificaciones(document.getElementById('nombre_equipo'));			
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
$("#accion_equipo").select2().select2();	
///$('#accion_equipo').select2("val","SIGUE EN FUNCIONAMIENTO");	
$('#en_uso').select2();	
$('#garantia').select2();	
$('#per_proyecto').select2();	
$('#proc_marca').select2();	
$('#proc_tipo').select2();	
$('#cpu_pc').select2();	




   
$('#formulario').validate({ // initialize the plugin

     rules: {
          
        },
        messages: {
			
        },
		
	  submitHandler: function (form) { // for demo
	
		
			var formData = new FormData(document.getElementById("formulario"));
			
			 $.ajax({
                data:  formData,
                url:   'proc_reporte.php',
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