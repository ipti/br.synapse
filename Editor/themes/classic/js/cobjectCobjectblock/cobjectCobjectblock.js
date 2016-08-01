$(document).ready(function(){
    $('#CobjectCobjectblock_cobject_id').css('width', '100%');
    $('#CobjectCobjectblock_cobject_id').css('height', '150px');
    $('#CobjectCobjectblock_cobject_block_id').select2();

    $('.button').on('click' , function(){
        $.ajax({
            type: "POST",
            url: "/cobjectCobjectblock/create",
            dataType: 'json',
            data: {
                cobjects_id : $('#CobjectCobjectblock_cobject_id').val(),
                block_id: $('#CobjectCobjectblock_cobject_block_id').val()
            },
            success: function (response, textStatus, jqXHR) {
                var msgs = response;
                console.log(msgs);
            }
        });

    } );
});

