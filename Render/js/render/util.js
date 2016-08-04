/**
 * Created by FábioNascimento on 04/08/2016.
 */
    /**
     * Verifica se a variavel esta setada.
     *
     * @param {mixed} variable
     * @returns {Boolean}
     */
    isset = function(variable) {
        return (variable !== undefined && variable !== null);
    };

    isEmpty = function(variable) {
        return !self.isset(variable) || variable === '';
    };




