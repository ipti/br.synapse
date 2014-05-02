var self = this;
$('div.answer > div[group]').hide();


$(document).on('click','#nextSreen', function(){
    var currentScreen = $('.currentScreen');
    currentScreen.removeClass('currentScreen');
    currentScreen.hide();
    currentScreen.next().addClass('currentScreen');
    currentScreen.next().show();
});

$('div[group]').on('click', function(){
    var ask_answer = $(this).parents('div').attr('class');
    if(ask_answer == 'ask') { 
       // $(this).css('opacity') == 1 &&
        if(!$(this).hasClass('ael_clicked')){
            $(this).css('opacity','0.4');
            $(this).siblings().hide();
            $(this).closest('div.ask').siblings('div.answer').children('div[group]:not(.ael_clicked)').show(1000);
            $(this).addClass('ael_clicked');
        }else{
            $(this).css('opacity','1');
            $(this).siblings().show();
            $(this).closest('div.ask').siblings('div.answer').children('div[group]:not(.ael_clicked)').hide(1000);
            $(this).removeClass('ael_clicked');
        }
    }else if(ask_answer == 'answer'){
            $(this).siblings().hide();
            $(this).hide();
            $(this).closest('div.answer').siblings('div.ask').children('div[group]').show(1000);
            $(this).closest('div.answer').siblings('div.ask').children('div[group].ael_clicked').hide();
            $(this).addClass('ael_clicked');
    }
   
});

   this.isset = function (variable){
        return (typeof variable !== 'underfined' && variable !== null);
    }


