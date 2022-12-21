<?php
session_start();
if (@!$_SESSION['user'])header("Location:index.php");
$idUser=$_SESSION['id'];
$userName=$_SESSION['user'];
$nivel=$_SESSION['nivel'];

// Definimos nuestra zona horaria
date_default_timezone_set("America/Chihuahua");

// incluimos el archivo de funciones
include 'funciones.php';

// incluimos el archivo de configuracion
include 'config.php';

// Verificamos si se ha enviado el campo con name from
if (isset($_POST['fromTXT']))
{

    // Si se ha enviado verificamos que no vengan vacios
    if ($_POST['fromTXT']!="" AND $_POST['toTXT']!="")
    {

        // Recibimos el fecha de inicio y la fecha final desde el form

        $inicio = _formatear($_POST['fromTXT']);
        // y la formateamos con la funcion _formatear

        $final  = _formatear($_POST['toTXT']);

        // Recibimos el fecha de inicio y la fecha final desde el form

        $inicio_normal = $_POST['fromTXT'];

        // y la formateamos con la funcion _formatear
        $final_normal  = $_POST['toTXT'];

        // Recibimos los demas datos desde el form
        $titulo = evaluar($_POST['title']);

        // y con la funcion evaluar
        $body   = evaluar($_POST['event']);

        // reemplazamos los caracteres no permitidos
        $clase  = evaluar($_POST['class']);


        // insertamos el evento
        $query="INSERT INTO eventos VALUES(null,'$titulo','$body','','$clase','$inicio','$final','$inicio_normal','$final_normal','$idUser')";



        // Ejecutamos nuestra sentencia sql
        $conexion->query($query);

        // Obtenemos el ultimo id insetado
        $im=$conexion->query("SELECT MAX(id) AS id FROM eventos");
        $row = $im->fetch_row();
        $id = trim($row[0]);

        // para generar el link del evento
        $link = "descripcion_evento.php?id=".$id;

        // y actualizamos su link
        $query="UPDATE eventos SET url = '$link' WHERE id = $id";

        // Ejecutamos nuestra sentencia sql
        $conexion->query($query);



        if ( isset($_POST['tempIDdep']) )
        {
            $array = explode(',',$_POST['tempIDdep']);


            for($i=0; $i <= (count($array)-1); $i++)
            {
                $query2="INSERT INTO eventos_has_departamentos (evento_id, departmaneto_id) VALUES (".$id.",".$array[$i].")";
                $conexion->query($query2);
            }

        }



        // redireccionamos a nuestro calendario
        header("Location:agenda.php");
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Agenda</title>
    <link rel="stylesheet" href="css/flexboxgrid.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- agenda -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/calendar.css">
    <!-- quita signo adminracion -->
    <link rel="stylesheet" href="css/style.css">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <script type="text/javascript" src="js/es-ES.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/moment.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-datetimepicker.js"></script>
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css" />
    <script src="js/bootstrap-datetimepicker.es.js"></script>

</head>
<body>
<!-- HEADER -->
<header id="main-header">
    <div class="container">
        <div class="row end-sm end-md end-lg center-xs middle-xs middle-sm middle-md middle-lg">
            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                <h1><span class="primary-text">Agenda </span>Municpal</h1>
            </div>
            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                <nav id="navbar">
                    <ul>
                        <li><a href=" ">Bienvenido <strong><?php echo $userName;?></strong></a><input type="hidden" id="tempIdUser" name="tempIDdep" value="<?php echo $idUser; ?>"></li>
                        <li class="current"><a href="agenda.php">Agenda</a></li>
                        <?php if($nivel==1) echo '<li class="current"><a href="admin/principal.php">Administrar agenda</a></li>'; ?>
                        <li><a href="desconectar.php">Salir</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>

<!-- SUBHEADER -->
<section id="subheader">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h1>H. Ayuntamiento ----- </h1>
            </div>
        </div>
    </div>
</section>

<!-- MAIN PAGE -->
<section id="page" class="contact">
<div class="container">
    <div class="page-header"><h2></h2></div>
    <div class="container">
        <div class="row">
            <div class="pull-right form-inline">
                <button class="btn btn-info" data-toggle='modal' data-target='#add_evento'><b>Añadir Evento</b> </button>

                    <div class="btn-group">
                        <button class="btn" data-calendar-nav="prev"><a><< Anterior</a></button>
                        <button class="btn" data-calendar-nav="today"><a>Hoy</a></button>
                        <button class="btn" data-calendar-nav="next"><a>Siguiente >></a></button>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-primary" data-calendar-view="year"><b>Año</b></button>
                        <button class="btn btn-primary active" data-calendar-view="month"><b>Mes</b></button>
                        <button class="btn btn-primary" data-calendar-view="week"><b>Semana</b></button>
                        <button class="btn btn-primary" data-calendar-view="day"><b>Día</b></button>
                    </div>

            </div>

        </div>
    </div>

    <div class="row"><br> <br><br></div>
    <div class="row">
        <div id="calendar"></div> <!-- Aqui se mostrara nuestro calendario -->

    </div>

    <!--ventana modal para el calendario-->
    <div class="modal fade" id="events-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" style="height: 400px">
                    <p>One fine body&hellip;</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>


<script>///evento Al cerrar el visualizador de eventos
    $("#events-modal").on('hidden.bs.modal', function () {
        $(location).attr('href',"")
    });
</script>

<div class="container">
<div class="row">
<script src="js/underscore-min.js"></script>
<script src="js/calendar.js"></script>
<script type="text/javascript">
    (function($){
        //creamos la fecha actual
        var date = new Date();
        var yyyy = date.getFullYear().toString();
        var mm = (date.getMonth()+1).toString().length == 1 ? "0"+(date.getMonth()+1).toString() : (date.getMonth()+1).toString();
        var dd  = (date.getDate()).toString().length == 1 ? "0"+(date.getDate()).toString() : (date.getDate()).toString();

        //establecemos los valores del calendario
        var options = {

            // definimos que los eventos se mostraran en ventana modal
            modal: '#events-modal',

            // dentro de un iframe
            modal_type:'iframe',

            //obtenemos los eventos de la base de datos
            events_source: 'obtener_eventos.php',

            // mostramos el calendario en el mes
            view: 'month',

            // y dia actual
            day: yyyy+"-"+mm+"-"+dd,


            // definimos el idioma por defecto
            language: 'es-ES',

            //Template de nuestro calendario
            tmpl_path: 'tmpls/',
            tmpl_cache: false,


            // Hora de inicio
            time_start: '08:00',

            // y Hora final de cada dia
            time_end: '22:00',

            // intervalo de tiempo entre las hora, en este caso son 30 minutos
            time_split: '30',

            // Definimos un ancho del 100% a nuestro calendario
            width: '100%',
            //se cargan las variables de la bd
            onAfterEventsLoad: function(events)
            {
                if(!events)
                {
                    return;
                }
                var list = $('#eventlist');
                list.html('');

                $.each(events, function(key, val)
                {
                   // alert(key+"----"+"--"+val.id);
                    $(document.createElement('li'))
                        .html('<a href=descripcion_evento.php?id="' + val.id + '">' + val.title + '</a>')
                        .appendTo(list);
                });
            },
            onAfterViewLoad: function(view)
            {
                $('.page-header h2').text(this.getTitle());
                $('.btn-group button').removeClass('active');
                $('button[data-calendar-view="' + view + '"]').addClass('active');
            },
            classes: {
                months: {
                    general: 'label'
                }
            }
        };


        // id del div donde se mostrara el calendario
        var calendar = $('#calendar').calendar(options);

        $('.btn-group button[data-calendar-nav]').each(function()
        {
            var $this = $(this);
            $this.click(function()
            {
                calendar.navigate($this.data('calendar-nav'));
            });
        });

        $('.btn-group button[data-calendar-view]').each(function()
        {
            var $this = $(this);
            $this.click(function()
            {
                calendar.view($this.data('calendar-view'));
            });
        });

        $('#first_day').change(function()
        {
            var value = $(this).val();
            value = value.length ? parseInt(value) : null;
            calendar.setOptions({first_day: value});
            calendar.view();
        });
    }(jQuery));
</script>

<div class="modal fade" id="add_evento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Agregar nuevo evento</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="frmAddEvt" class="form-horizontal">
                    <label for="from">Inicio</label>
                    <div class='input-group date' id='from'>
                        <input type='text' id="fromTXT" name="fromTXT" class="form-control" readonly />
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </div>
                    <div id="fromW"></div>
                    <label for="to">Final</label>
                    <div class='input-group date' id='to'>
                        <input type='text' name="toTXT" id="toTXT" class="form-control" readonly/>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </div>
                    <div id="toW"></div>
                    <br>
                    <label for="tipo">Estilo del evento</label>
                    <select class="form-control" name="class" id="tipo">
                        <option value="event-info">Informacion</option>
                        <option value="event-success" >Exito</option>
                        <option value="event-important">Importantante</option>
                        <option value="event-warning" >Advertencia</option>
                        <option value="event-special" >Especial</option>
                    </select>

                    <br>
                    <label for="title">Título</label>
                    <input type="text" required autocomplete="off" name="title" class="form-control" id="title" placeholder="Introduce un título">

                    <br>


                    <label for="body">Evento</label>
                    <textarea id="body" name="event" required class="form-control" rows="3"></textarea>
                    <input type="hidden" id="tempIDdep" name="tempIDdep" value="">


                    <?php
                    include 'config.php';
                    $items="";
                    $query="SELECT iddepartamento as id, nombredepartamento as dep FROM departamento";
                    $Resultado=$conexion->query($query);
                    if(mysqli_num_rows($Resultado) > 0)
                    {
                        while($Datos=mysqli_fetch_array($Resultado))
                        {
                            $items .= '<a  class="list-group-item"><label class="checkbox-inline"><input type="checkbox" id="chk_'.$Datos['id'].'" value="'.$Datos['id'].'" onchange="valorChk(frmAddEvt);chk(\'#chk_'.$Datos['id'].'\',chk_'.$Datos['id'].')">'.$Datos['dep'].'</label> </a>';
                        }

                    }

                    ?>

                    <br>
                    <label for="body">Compartir evento:</label>
                    <div class="list-group">
                        <a  class="list-group-item"> Seleccione si desea compartir</a>
                        <?php echo $items; ?>
                    </div>
                    <div id="depW"></div>


                    <script>
                        function valorChk(furmulario)
                        {
                            var resultado="";
                            for(var i=0;i<furmulario.length;i++)
                            {
                                 if(furmulario[i].checked) resultado += furmulario[i].value + ",";
                            }

                            $("#tempIDdep").val(resultado);


                        }
                        function chk(id,obj)
                        {
                            var dep="";
                            var  from=$('#fromTXT').val();
                            var  to=$('#toTXT').val();
                            var opc=2;

                            if(obj.checked && from.length > 0 && to.length > 0)
                            {
                                dep=obj.value;

                                $.ajax(
                                    {
                                        url:"verificarFecha.php",
                                        method:"POST",
                                        data:{from:from,to:to,dep:dep,opc:opc},
                                        cache:"false",
                                        success:function(data)
                                        {
                                            if(data == ' ') $('#depW').html ( " ");
                                            else  $('#depW').html ( ""+data);
                                        }
                                    }
                                );

                            }
                            else
                            {
                                $('#depW').html ( " ");
                            }

                        }
                        </script>

                    <script type="text/javascript">
                        $(function ()
                        {
                            $('#from').datetimepicker({
                                language: 'es',
                                minDate: new Date()
                            });
                            $('#to').datetimepicker({
                                language: 'es',
                                minDate: new Date()
                            });

                            $('#from').change(function()
                            {

                              var  fecha=$('#fromTXT').val();
                              var idUser=$('#tempIdUser').val();
                              var opc=1;
                                $.ajax(
                                    {
                                        url:"verificarFecha.php",
                                        method:"POST",
                                        data:{fecha:fecha,idUser:idUser,opc:opc},
                                        cache:"false",
                                        success:function(data)
                                        {
                                            $('#fromW').html ( ""+data);
                                        }
                                    }
                                );
                            });

                            $('#to').change(function()
                                {
                                    var  fecha=$('#toTXT').val();
                                    var  idUser=$('#tempIdUser').val();
                                    var opc=1;
                                    $.ajax(
                                        {
                                            url:"verificarFecha.php",
                                            method:"POST",
                                            data:{fecha:fecha,idUser:idUser,opc:opc},
                                            cache:"false",
                                            success:function(data)
                                            {
                                                $('#toW').html ( ""+data);
                                            }
                                        }
                                    );
                                }
                            );

                        });



                    </script>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Agregar</button>
          </form>
        </div>
       </div>

    </div>
</div>


</div>
</div>
</div>
</section>

<!-- FOOTER -->
<footer id="main-footer">
    <div class="container">
        <div class="row center-xs center-sm center-md center-lg">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <p></p>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
