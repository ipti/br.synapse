var newEditor = new editor();
$(function() { 
    $('.canvas').pajinate({
        start_page : 0,
        items_per_page : 1,
        nav_label_first : '<<',
        nav_label_last : '>>',
        nav_label_prev : '<',
        nav_label_next : '>',
        show_first_last : false,
        num_page_links_to_display: 20,
        nav_panel_id : '.navsreen',
        editor : newEditor
    }); 
    
    newEditor.countPieceSet['sc0'] = 0;
    newEditor.countPieces['sc0_ps0'] = 0;
    
    //$("#toolbar").draggable({
    //    axis: "y"
    //});                   
    $("#addScreen").click(function(){
        newEditor.addScreen();
    });
    $("#delScreen").click(function(){
        newEditor.delScreen(false);
    });
    $(".insertText").live('click',function(){
        newEditor.addText($(this).closest('div[group]'));
    });
    $(".insertImage").live('click',function(){ //.last()
        newEditor.addImage($(this).closest('div[group]'));
    });
    $("#addPieceSet").click(function(){
        newEditor.addPieceSet();
    })
    $(".addPiece").live("click",(function(){
        newEditor.addPiece($(this).attr('id'));
    }));
    $('.piece').live("mousedown",function(){
        newEditor.changePiece($(this));
    });
    $('.save').click(function(){
        newEditor.saveAll();
    });
    
    if(newEditor.isload){    
        newEditor.load();
    }
    
    $('.input_element').live("change",function() {
        newEditor.elementChanged($(this));
    });
    
    
});
