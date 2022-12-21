<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Calendario | Services</title>
    <link rel="stylesheet" href="css/flexboxgrid.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/style.css">

      <!-- agenda -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"> 
  <link rel="stylesheet" href="css/calendar.css">
  <!-- quita signo adminracion -->
  <link rel="stylesheet" href="<!?=$base_url?>css/style.css">
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
    <header id="main-header" class="navbar-collapse collapse">
      <div class="container">
        <div class="row end-sm end-md end-lg center-xs middle-xs middle-sm middle-md middle-lg">
          <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
            <h1><span class="primary-text">Agenda </span>Municipal</h1>
          </div>
          <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
            <nav id="navbar">
              <ul>
                <li class="current"></li>
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
            <h1>Crea una agenda grupal </h1>
          </div>
        </div>
      </div>
    </section>

    <!-- MAIN PAGE -->
    <section id="page" class="services">
      <div class="container">
          <!-- <form > -->
             <div class="row center-xs center-sm center-md center-lg">
               <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                 <h2><span class="primary-text">Introduce</span> Correctamente tus Datos</h2>
                 <ul>
                   <li>
                     <p></p><p></p>
                     <tr><td><label style="font-size: 14pt"><b>Usuario: </b></label></td>
                       <td width=80><h2> <input class="primary-text" id="username" name="username" required style="border-radius:15px;" type="text" require></td></tr></h2>

                   </li>

                   <li>
                   <p></p>
                   <tr><td><label style="font-size: 14pt"><b>Contraseña: </b></label></td>
                       <td witdh=80><h2><input class="primary-text" id="userkey" name="userkey" required style="border-radius:15px;" type="password"  require></td></tr>
                     <tr><td></td></h2>

                       <p></p>
                       <td width=80 align=center><input class="primary-text" type="submit" id="login" value="Ingresar"></td>
                       </tr></tr></table>
                   </li><p><p>

                     <div id="result"> </div>
                 </ul>

               </div>
             </div>
          <!-- </form > -->
           </div>
         </section>



    <!-- FOOTER -->
    <footer id="main-footer">
      <div class="container">
        <div class="row center-xs center-sm center-md center-lg">

        </div>
      </div>
    </footer>
<script>
    $(document).ready(
        function()
        {
            $('#login').click
            (
                function()
                {
                    var d1=$("#username").val();
                    var d2=$("#userkey").val();
                    if($.trim(d1).length > 0 && $.trim(d2).length > 0)
                    {
                        $.ajax(
                            {
                                url:"admin/operaciones.php?opc=1",
                                method:"POST",
                                data:{d1:d1,d2:d2},
                                cache:"false",
                                beforeSend:function()
                                {
                                    $('#login').val("Enviando");
                                },
                                success:function(data)
                                {
                                    $('#login').val("Ingresar");
                                    if(data == "false")
                                    $('#result').html ( "<p class=\"alert alert-danger\" role=\"alert\">"+"Error de usuario o contraseña"+"</p>");
                                    else $(location).attr('href',data);
                                }
                            }
                        )
                    }
                    else
                    {
                        $('#result').html ( "<p class=\"alert alert-danger\" role=\"alert\">Ingrese datos en los campos vacios</p>");
                    }
                }
            )
        }
    )
    </script>
  </body>
</html>
