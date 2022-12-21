var bandera = 0;
function Buscador() {
  var xmlhttp = false;
  try {
    xmlhttp = new ActiveXObject('Msxml2.XMLHTTP');
  } catch (e) {
    try {
      xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
    } catch (E) {
      xmlhttp = false;
    }
  }
  if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
    xmlhttp = new XMLHttpRequest();
  }
  return xmlhttp;
}
function Div(div) {
  switch (div) { //VER EN QUE DIV SE VA MOSTRAR LOS DATOS
    case 1:
      c = document.getElementById('resultados');
      break
    case 2:
      c = document.getElementById('resultados2');
      break
    case 3:
      c = document.getElementById('resultados3');
      break
  }
  return c
}
function Operacion(q, opc, div)
{
  c = Div(div)
  ajax = Buscador();
  var variables = '';
  switch (opc) {
    case 4:
      variables = '&d1=' + TXT('d1Add') + '&d2=' + TXT('d2Add') + '&d3=' + TXT('d3Add') + '&d4=' + TXT('d4Add') + '&d5=' + TXT('d5Add') + '&d6=' + TXT('d6Add') + '&d7=' + Combo('d7Add') + '&d8=' + Combo('d8Add') + '&d9=' + Combo('d9Add');
      break;
    case 8:
      variables = '&d1=' + TXT('d1') + '&d2=' + TXT('d2') + '&d3=' + TXT('d3') + '&d4=' + TXT('d4') + '&d5=' + TXT('d5') + '&d6=' + TXT('d6') + '&d7=' + Combo('d7') + '&d8=' + Combo('d8') + '&d9=' +  Combo('d9');
      break;
    case 11:
      variables = '&txtBucador=' + TXT('txtBucador');
      break;
    case 14:
      variables = '&txtAddDep=' + TXT('txtAddDep');
      break;
    case 15:
      variables = '&txtDep=' + TXT('txtDep');
      break;
  }
  if (bandera == 1)
  {
    return false;
}
ajax.open('GET', 'operaciones.php?q=' + q + '&opc=' + opc + variables);

ajax.onreadystatechange = function ()
{
  if (ajax.readyState == 4) {
    c.innerHTML = ajax.responseText
    window.scrollTo(0, c.offsetTop);
  }
}
ajax.send(null)
}
function ConfirmarEliminar(q, notes)
{
divNotes.innerHTML = notes;
document.getElementById('txtTempDElDep').value = q;
}
function delDep(opc, div)
{
temp = document.getElementById('txtTempDElDep').value;
Operacion(temp, opc, div);
}
function editDep(q, notes)
{
document.getElementById('txtDep').value = notes;
document.getElementById('txtTempDElDep').value = q;
}
function fEditDep(opc, div)
{
temp = document.getElementById('txtDep').value;
Operacion(temp, opc, div);
}
function EditSetUserFrm(d1, d2, d3, d4, d5, d6, d7, d8, d9)
{
document.getElementById('txtTempEditUserId').value = d1;
document.getElementById('d1').value = d2;
document.getElementById('d2').value = d3;
document.getElementById('d3').value = d4;
document.getElementById('d4').value = d5;
document.getElementById('d5').value = d6;
document.getElementById('d6').value = d7;
document.getElementById('d7').value = d8;
document.getElementById('d8').value = d9;
}
function EditGetUserFrm(opc, div)
{
temp = document.getElementById('txtTempEditUserId').value;
Operacion(temp, opc, div);
}
function frmEliminarUser(q, notes)
{
divNotes.innerHTML = notes;
document.getElementById('txtTempDelUser').value = q;
}
function fDelUser(opc, div)
{
temp = document.getElementById('txtTempDelUser').value;
Operacion(temp, opc, div);
//
}//***************************VALIDACI�N PARA CAMPOS DE TIPO TEXTO***********************

function TXT(dato) {
if (document.getElementById(dato).title != '')
{
if (Valida_txt(document.getElementById(dato)) == false) bandera = 1;
 else return document.getElementById(dato).value; //FALTA AGREGAR
} 
else return document.getElementById(dato).value;
}
function Valida_txt(texto)
{
d = texto.value.replace(/(^\s+|\s+$)/g, '');
if (d.length == 0) {
//   texto.style='background-color:#FF6600';
alert('TIENE QUE CAPTURAR DATO VÁLIDO EN EL CAMPO ' + texto.title)
return false;
} else {
// texto.style='background-color:#FFFFFF';
return true;
}
}//**************************************************************************************
//*********VALIDA DATO DE UNA LISTA*****************************************************

function Combo(dato) {
document.getElementById(dato).style = 'background-color:#FFFFFF';
if (document.getElementById(dato).value == - 1) { //SI NO SE HA SELECCIONADO EL COMBO
document.getElementById(dato).style = 'background-color:#FFFF00';
alert('NO HA SELECCIONADO REGISTRO EN LA LISTA ' + document.getElementById(dato).name);
    bandera = 1;
}
return document.getElementById(dato).value;
}
