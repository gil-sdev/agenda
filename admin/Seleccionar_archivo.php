<?php


print 'Hola mundo';
print '<form action="Seleccionar_archivo.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
<p>
<label>
<input name="archivo" type="file" id="archivo"></label>
Seleccione un archivo
</p>
<p>
<label> <input type="submit" name="Submit" value="Enviar">
</label>
</form>
</p>
<p><br></p>';
?>