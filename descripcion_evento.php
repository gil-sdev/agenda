

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="CONTENT-TYPE" content="text/html" charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable, initial-scalable=no initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
</head>
<body>
<?php

session_start();
if (@!$_SESSION['user'])header("Location:index.php");
$idUser=$_SESSION['id'];
$userName=$_SESSION['user'];
$nivel=$_SESSION['nivel'];

//incluimos nuestro archivo config
include 'config.php';

// Incluimos nuestro archivo de funciones
include 'funciones.php';

// Obtenemos el id del evento
$id  = evaluar($_GET['id']);

// y lo buscamos en la base de dato
$bd  = $conexion->query("SELECT * FROM eventos WHERE id=$id");

// Obtenemos los datos
$row = $bd->fetch_assoc();

// titulo
$titulo=$row['title'];

// cuerpo
$evento=$row['body'];

// Fecha inicio
$inicio=$row['inicio_normal'];

// Fecha Termino
$final=$row['final_normal'];

// Eliminar evento
if (isset($_POST['eliminar_evento']))
{
    $idEvtDel  = evaluar($_GET['id']);

    $sql = "SELECT eventos.usuarios_idUsuario FROM eventos WHERE id=$idEvtDel ";
    $res=$conexion->query($sql);
    $datum= $res->fetch_assoc();

    if($datum['usuarios_idUsuario'] == $idUser)
    {
        $sql = "DELETE FROM eventos_has_departamentos WHERE evento_id = $idEvtDel";

        if($conexion->query($sql));// echo '<div class=\"alert alert-success\" role=\"alert\">El evento compartido ha sido eliminado</div>';
        $sql = "DELETE FROM eventos WHERE id = $id";
        if ($conexion->query($sql))
        {
            echo "<div class=\"alert alert-success\" role=\"alert\">Evento eliminado</div>";
            exit();
        }
        else
        {
            echo "<div class=\"alert alert-danger\" role=\"alert\">El evento no se pudo eliminar </div>";
            exit();
        }

    }
}
?>
<div class="panel panel-primary" id="info">
    <div class="panel-heading"><?=$titulo?></div>
    <div class="panel-body">
        <div>
            <b>Fecha inicio:</b> <?=$inicio?>
        </div>
        <div>
            <b>Fecha termino:</b> <?=$final?>
        </div>
        <div>
            <p><b>Descripcion:</b> <?=$evento?></p>
        </div>
    </div>
    <form  method="post">
            <?php
            if($row['usuarios_idUsuario'] == $idUser )  echo '<p class="text-center"><button type="submit" class="btn btn-danger" name="eliminar_evento" id="eliminar">Eliminar</button></p>';
            else
            { if(isset($titulo))
                  {
                $sql='SELECT usuarios.usuario,departamento.nombredepartamento
                    from usuarios,departamento
                    WHERE
                    usuarios.departamento_iddepartamento = departamento.iddepartamento AND
                    usuarios.idusuarios';
                $sql=$sql.'='.$row['usuarios_idUsuario'];

               $dUser= $conexion->query($sql);
               $dat= $dUser->fetch_assoc();

                echo '<div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" >&times;</span></button>
            No es posible elimnar el evento, ya que no es el autor del evento<br>Usuario creador: '.$dat['usuario'].'<br>Departamento: '.$dat['nombredepartamento'].'
        </div>';
                }
            }
            ?>

    </form>
</div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
