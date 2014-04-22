$(document).ready(function(){
    $('.T_screen[class!=currentScreen]').hide();
});

$(document).on('click','#nextSreen', function(){
    var currentScreen = $('.currentScreen');
    currentScreen.removeClass('.currentScreen');
    currentScreen.hide();
    currentScreen.next().addClass('.currentScreen');
    currentScreen.next().show();
});





