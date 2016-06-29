/**
 * Get the query value by the variable name.
 *
 * @param variable
 * @returns {*} The value or -1 if not found.
 */
this.getQueryVariable = function(variable) {
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split("=");
        if (pair[0] == variable) {
            return pair[1];
        }
    }
    return -1; //Não encontrado
}
