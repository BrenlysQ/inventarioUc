<?php
header("Content-Type: text/html;charset=utf-8");
include("lib/bd_conexion.php");

$bd=new bd_conexion();

$datos_tipo_equipo=$bd->consultaObjeto(array("*"),"equipo","ID_EQUIPO='".$_POST['id_tipo_equipo']."'",0);


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
				<h1 class="page-header">Editar Tipo de Equipo</h1>
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
<div class="form-group"><p align="right"><strong>Descripci&oacute;n del Equipo:</strong></p></div>
</div>
  <div class="col-md-9">
<div class="form-group">
<input type="text" id="descripcion"  name="descripcion" value="<?php echo $datos_tipo_equipo[0]->DESCRIPCION?>" size="40" class="form-control" placeholder=" * Descripci&oacute;n del Equipo" onKeyUp="javascript:this.value=this.value.toUpperCase();"/>
</div>
  </div>
</div>
	
	<input id="id_tipo_equipo" name="id_tipo_equipo" type="hidden" value="<?php echo $datos_tipo_equipo[0]->ID_EQUIPO;?>">	
								
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
			
			"descripcion": { 
				required: true
			}
        },
        messages: {
	
			"descripcion": { 
				required: "Debe introducir la Descripci&oacute;n del Equipo."				
			}
			 
    
        },
	 submitHandler: function (form) { // for demo
		var V_DESCRPCION = $("#descripcion").val();
		var V_ID_EQUIPO = $("#id_tipo_equipo").val();
				
		
		   var parametros = {
			"descripcion"  : V_DESCRPCION,
			"id_tipo_equipo":V_ID_EQUIPO

			};

			 $.ajax({
                data:  parametros,
                url:   'proc_editar_equipo.php',
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