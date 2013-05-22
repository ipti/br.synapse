var newEditor = new editor();
$(function() {
    $('.canvas').pajinate({
        items_per_page : 1,
        nav_label_first : '<<',
        nav_label_last : '>>',
        nav_label_prev : '<',
        nav_label_next : '>',
        show_first_last : false,
        num_page_links_to_display: 20,
        nav_panel_id : '.navpage',
        editor : newEditor
    }); 
    
    newEditor.countQuestion['pg0'] = 0;
    newEditor.countTasks['pg0_q0'] = 0;
    
    $("#toolbar").draggable({
        axis: "y"
    });
                            
    $("#addpage").click(function(){
        newEditor.addPage();
    });
    $(".insertText").click(function(){
        newEditor.addTexto();
    });
    $(".insertImage").last().click(function(){
        newEditor.addImage();
    });
    $("#addquestion").click(function(){
        newEditor.addQuest();
    })
    /*$(".page").live("click",(function(){
                    //alert(newEditor.currentPageId);
                    $('.page').removeClass('activePage');
                    //newEditor.currentPageId = $(this).attr('id');
                    $(this).addClass('active');
                }));
                /* $(".tasklist").live("click",(function(){
                    $('.tasklist').removeClass('active');
                    $(this).addClass('active');
                    newEditor.currentQuest = $(this).attr('id');
                }));*/
    $(".addTask").live("click",(function(){
        newEditor.addTask($(this).attr('id'));
    }));
    $('.task').live("mousedown",function(){
        newEditor.changeTask($(this));
    });
    $('.save').click(function(){
        newEditor.saveAll();
    });
});