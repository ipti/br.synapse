$(document).on('click','#nextSreen', function(){
    var currentScreen = $('.currentScreen');
    currentScreen.removeClass('currentScreen');
    currentScreen.hide();
    currentScreen.next().addClass('currentScreen');
    currentScreen.next().show();
});

$('div[group]').on('click', function(){
   if($(this).css('opacity') == 1){
       $(this).css('opacity','0.4');
   }else{
       $(this).css('opacity','1');
   }
});

$('div.answer').hide();
