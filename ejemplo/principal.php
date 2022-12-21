<?php header("Content-type:text/html;charset=utf-8");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="CONTENT-TYPE" content="text/html" charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable, initial-scalable=no initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
   <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
    <style>
        .modal-header{ background-color: #d7ecf7;}
    </style>

</head>

<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="../agenda.php">Agenda
            <?php
            session_start();
            if (@!$_SESSION['user']) header("Location:index.php");
            $idUser=$_SESSION['id'];
            $userName=$_SESSION['user'];
            $nivel=$_SESSION['nivel'];

            print "".$_SESSION['user'];

            ?>
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                <li >
                    <a href="#" onclick="javascript:Operacion(4,2,1)">
                    Usuarios
                        <span class="sr-only" >(current)</span>
                    </a>
                </li>
                <li>
                    <a href="#"  onclick="javascript:Operacion(4,10,1)">
                        Departamentos
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li>
                    <a href="#">Respaldos
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li>
                    <a href="../desconectar.php">Salir
                        <span class="sr-only">(current)</span>
                    </a>

                </li>
            </ul>

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<section id="main" class="container">
    <div id="page-wrapper" class="col-md-9" role="main">
        <div id="resultados">
        </div>
    </div>
</section>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="script2.js"></script>

</body>
</html>
