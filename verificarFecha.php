<?php

if(isset($_POST['opc'])) $opc=$_POST['opc'];
else die('Error');
switch($opc)
{
    case 1:
        verificarEmpalmeUser($_POST['fecha'],$_POST['idUser']);
        break;
    case 2:
        verificarDep($_POST['from'],$_POST['to'],$_POST['dep']);
        break;
    default:
        die('Error');
        break;

}
function verificarEmpalmeUser($fecha,$idUser)
{

$query="SELECT COUNT(evt.id) as numempalmes FROM
(
(SELECT eventos.* FROM eventos_has_departamentos,eventos,usuarios where eventos.id=eventos_has_departamentos.evento_id AND usuarios.departamento_iddepartamento = eventos_has_departamentos.departmaneto_id)
UNION
(SELECT eventos.* FROM usuarios,eventos where usuarios.idusuarios=eventos.usuarios_idUsuario and eventos.usuarios_idUsuario=$idUser)
) as evt

WHERE '$fecha' BETWEEN evt.inicio_normal and evt.final_normal; ";

    include 'config.php';
    $resul = $conexion-> query($query);

    if (mysqli_num_fields($resul)>0)
    {
        $row=mysqli_fetch_assoc($resul);

        if($row['numempalmes'] >0 )  echo('<p class="alert alert-danger" >La fecha elegida se encuentra '.$row['numempalmes'].' eventos ya agendadas</p>');
        else echo('');

    }
    else echo('');

}

function verificarDep($fecha_from,$fecha_to,$dep)
{

    include 'config.php';
    $advertencia="";
    $band = false;

    $query="SELECT count(evtsharedep.id) as num from evtsharedep
    WHERE evtsharedep.departmaneto_id=$dep and '$fecha_from' BETWEEN evtsharedep.inicio_normal and evtsharedep.final_normal;";
    $resul = $conexion-> query($query);

    if (mysqli_num_fields($resul)>0)
    {
        $row=mysqli_fetch_assoc($resul);

         if($row['num'] > 0)
         {
        $band = true;
        $advertencia="La fecha inicial causaria empalme con eventos del departamento seleccionado";
         }
    }
    else echo(' ');

    $query="SELECT count(evtsharedep.id) as num from evtsharedep
    WHERE evtsharedep.departmaneto_id=$dep and '$fecha_to' BETWEEN evtsharedep.inicio_normal and evtsharedep.final_normal;";
    $resul = $conexion-> query($query);
    if (mysqli_num_fields($resul)>0)
    {
        $row=mysqli_fetch_assoc($resul);

        if($row['num'] > 0)
        {
        if($band == true)    $advertencia="La fecha inicial y final causaria empalme con eventos del departamento seleccionado";
        else $advertencia="La fecha final causaria empalme con eventos del departamento seleccionado";
        echo('<p class="alert alert-danger" >'.$advertencia.'</p>');

        }
        else echo(' ');
    }
         else echo(' ');

}




?>