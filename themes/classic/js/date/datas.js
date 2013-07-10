function timestmpToDate(timestmp, idShow) //Terminar
{
var theDate = new Date(timestmp * 1000);
dateString = theDate.toGMTString();
document.getElementById(idShow).value = dateString;
}
function dateToTimestmp(date ,idShow)
{
    date = date.split('/');
    var year = date[2];
    var mes = date[1];
    var dia = date[0];

var humDate = new Date(year, (mes-1), dia);
document.getElementById(idShow).value = (humDate.getTime()/1000.0);
} 