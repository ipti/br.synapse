function timestmpToDate(timestmp, idShow) //Terminar
{
    if(timestmp != "") {
        var theDate = new Date(timestmp * 1000);
        dia = theDate.getDate();
        mes = theDate.getMonth() + 1;
        ano = theDate.getFullYear();
        dia = (dia < 10) ? '0'+dia : dia;
        mes = (mes < 10) ? '0'+mes : mes;
        dateString = dia+'/'+mes+'/'+ano;
        document.getElementById(idShow).value = dateString;
    }
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