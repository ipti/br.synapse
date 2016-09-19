this.addItem = function (params) {
    //Verificar primeiro se esse Item já foi selecionado
    var strItem = "";
    switch (params) {
        case "ActScriptContentIn":
            if ($('#contentInItens').find('input[value=' + $('#contentInID').val() + ']').size() === 0
                    && $('#contentInID').val() !== null) {
                //Add Novo
                strItem += '<li><input type="hidden" value="' + $('#contentInID').val() + '" name="ActScriptContentIn[]">' +
                        $('#contentInID').find('option[value="' + $('#contentInID').val() + '"]').text()
                        + '  - <a id="' + $('#contentInID').val() + '"\n\
            onclick="delItem($(this))" href="javascript:void(0)">' + phpMsgRemove + '</a>';
                $('#contentInItens').append(strItem);
            }
            break;
        case "ActScriptContentOut":
            if ($('#contentOutItens').find('input[value=' + $('#contentOutID').val() + ']').size() === 0
                    && $('#contentOutID').val() !== null) {
                //Add Novo
                strItem += '<li><input type="hidden" value="' + $('#contentOutID').val() + '" name="ActScriptContentOut[]">' +
                        $('#contentOutID').find('option[value="' + $('#contentOutID').val() + '"]').text()
                        + '  - <a id="' + $('#contentOutID').val() + '"\n\
            onclick="delItem($(this))" href="javascript:void(0)">' + phpMsgRemove + '</a>';
                $('#contentOutItens').append(strItem);
            }
            break;

    }
};

this.delItem = function (item) {
    item.closest('li').remove();
}




