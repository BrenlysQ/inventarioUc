<?php
header("Content-Type: text/html;charset=utf-8");
include("lib/bd_conexion.php");

$bd=new bd_conexion();

$datos_tecnico=$bd->consultaObjeto(array("*"),"tecnico","ID_TECNICO='".$_POST['id_tecnico']."'",0);


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
				<h1 class="page-header">Editar T&eacute;cnico de Equipo</h1>
			</div>
		</div><!--/.row-->
	
					
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					
					<div class="panel-body">
						<div class="col-md-12">
						
						<div id="resultado_rt" style="color:#005B88; text-align:center; size:500">&nbsp;</div>
<form id="formulario" name="formulario" method="post" enctype="multipart/form-data">	

<div class="row">
  <div class="col-md-3">
<div class="form-group"><p align="right"><strong>Nombre del T&eacute;cnico:</strong></p></div>
</div>
  <div class="col-md-9">
<div class="form-group">
<input type="text" id="nombre_tec"  name="nombre_tec" value="<?php echo $datos_tecnico[0]->NOMBRE;?>" size="40" class="form-control" placeholder=" * Nombre del T&eacute;cnico" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
  </div>
</div>


<div class="row">
  <div class="col-md-3">
<div class="form-group"><p align="right"><strong>Usuario del T&eacute;cnico:</strong></p></div>
</div>
  <div class="col-md-9">
<div class="form-group">
<input type="text" id="usuario_tec"  name="usuario_tec" value="<?php echo $datos_tecnico[0]->USUARIO;?>" size="40" class="form-control" placeholder=" * Usuario del T&eacute;cnico" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
  </div>
</div>

																								

	
	<input id="id_tecnico" name="id_tecnico" type="hidden" value="<?php echo $datos_tecnico[0]->ID_TECNICO;?>">	
								
						<div class="form-group"><p><em>Los campos marcados con * son campos obligatorios</em></p></div>
							<div class="form-group" align="center">
							<a href="consultar_equipo.php" class="btn btn-primary">Atr&aacute;s</a>
							<input type="submit" value="Registrar"  class="btn btn-primary"/></div>
																					
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
	
	<script>
		
 
		
 $(document).ready(function () {
     $('#formulario').validate({ // initialize the plugin
	
       rules: {
			
			"nombre_tec": { 
				required: true
			},
			"usuario_tec": { 
				required: true
			}
        },
        messages: {
	
			"descripcion": { 
				required: "Debe introducir el Nombre del T&eacute;cnico del Equipo."				
			},
			"usuario_tec": { 
				required: "Debe introducir el Usuario del T&eacute;cnico del Equipo."				
			}
			 
    
        },
	 submitHandler: function (form) { // for demo
		var V_NOMBRE_TEC = $("#nombre_tec").val();
		var V_USUARIO_TEC = $("#usuario_tec").val();
		var V_ID_TEC = $("#id_tecnico").val();
				
		
		   var parametros = {
			"nombre_tec"  : V_NOMBRE_TEC,
			"usuario_tec"  : V_USUARIO_TEC,
			"id_tecnico"  : V_ID_TEC
			

			};

			 $.ajax({
                data:  parametros,
                url:   'proc_editar_tecnico.php',
                type:  'POST',
                beforeSend: function () {
                        $("#resultado_rt").html("Procesando, espere por favor...");
                },
                success:  function (response) {
					   $("#resultado_rt").html(response);
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