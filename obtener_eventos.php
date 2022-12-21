<?php
session_start();
if (@!$_SESSION['user'])header("Location:index.php");
$idUser=$_SESSION['id'];
$userName=$_SESSION['user'];
$nivel=$_SESSION['nivel'];

// Incluimos nuestro archivo config
include 'config.php'; 

// Sentencia sql para traer los eventos desde la base de datos
$sql="(SELECT eventos.* FROM eventos_has_departamentos,eventos,usuarios where eventos.id =eventos_has_departamentos.evento_id AND usuarios.departamento_iddepartamento=eventos_has_departamentos.departmaneto_id)
UNION
(SELECT eventos.* FROM usuarios,eventos where usuarios.idusuarios=eventos.usuarios_idUsuario and eventos.usuarios_idUsuario=".$_SESSION['id'].")";

// Verificamos si existe un dato
if ($conexion-> query($sql)-> num_rows)
{ 

    // creamos un array
    $datos = array(); 

    //guardamos en un array multidimensional todos los datos de la consulta
    $i=0; 

    // Ejecutamos nuestra sentencia sql
    $e = $conexion->query($sql); 

    while($row=$e-> fetch_array()) // realizamos un ciclo while para traer los eventos encontrados en la base de dato
    {
        // Alimentamos el array con los datos de los eventos
        $datos[$i] = $row; 
        $i++;
    }

    // Transformamos los datos encontrado en la BD al formato JSON
        echo json_encode(
                array(
                    "success" => 1,
                    "result" => $datos
                )
            );

    }
    else
    {
        // Si no existen eventos mostramos este mensaje.
        echo "No hay datos"; 
    }


?>
