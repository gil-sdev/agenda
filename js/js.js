$(document).ready(
    function()
    {
        $('#login').click(
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
                                if(data='ok')
                                {
                                    $(location).attr('href','admin/principal.php');
                                }
                                else
                                {
                                    $(location).attr('href','admin/principal.php');
                                    $('#result').html
                                        (
                                        "No hay"
                                        );
                                }
                            }

                        }
                    )
                }
            }
        )
    }
)