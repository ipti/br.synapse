$(document).on('click','#nextSreen', function(){
    var currentScreen = $('.currentScreen');
    currentScreen.removeClass('currentScreen');
    currentScreen.hide();
    currentScreen.next().addClass('currentScreen');
    currentScreen.next().show();
});

$('div[group]').on('click', function(){
    $(this).css('opacity','0.4');
});




//




