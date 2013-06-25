/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function renderize(){
    this.op;
    this.startRenderize = function (response, op){
        //se operação não existir, o pradão é all
        if(typeof(op) == "undefined"){
            this.op = "all";
        }
        else{
            this.op = op;
            //lista de operações
                //unity
                //class
                //all
        }
        if(typeof(response.unitys) != "undefined"){
            this.loadUnitys(response.unitys, 0);
        }
    }
    this.loadUnitys = function (unitys, fatherID){
        var id = $(".box").last().attr("id");
        id = id.replace("box_", "");
        id = parseInt(id)+1;

        var nextUnity;
        var count = unitys.length;
        
        if(count == 0){
            if(this.op != "unity")
                this.loadJsonClasses(fatherID);
        }
        else if (count == 1){
            $("#box_"+(id)).remove();
            $("#box_"+(id-1)).append("<div id='box_"+id+"' class='box'></div>");
            $("#box_"+id).append("<input type='hidden' id='org_"+id+"' value='"+unitys[0].unity+"'>");
            nextUnity = unitys[0].unity;
            this.loadJsonUnity(nextUnity);
        }
        else{
            var parent = this;
            $("#box_"+id).remove();
            var options = "";
            for(i=0; i<count; i++){
                options += "<option value='"+unitys[i].unity+"'>"+unitys[i].name+"</option>";
            }
            $("#box_"+(id-1)).append("<div id='box_"+id+"' class='box'></div>");
            
            $("#box_"+(id)).append((id == 1) ? "<font>Unity:</font>" : "<font>-></font>");
            $("#box_"+(id)).append("<select id='org_"+id+"' class='org' >"+options+"</select>");
            $("#org_"+id).change(function(){
                id = $(this).attr("id");
                id = id.replace("org_", "");
                id = parseInt(id);
                $("#box_"+(id+1)).remove();
                parent.loadJsonUnity($(this).val());
            });
            nextUnity = unitys[0].unity;
            this.loadJsonUnity(nextUnity);
        }
    }
    this.loadClasses = function (classes){
        var parent = this;
        var options = "";
        var count = classes.length;
        
        for(i=0; i<count; i++){
            options += "<option value='"+classes[i].unity+"'>"+classes[i].name+"</option>";
        }
        $("#classesbox").remove();
        $("#filter").append("<div id='classesbox' class='formField'></div>");
        $("#classesbox").append("<font>Class:</font>");
        $("#classesbox").append("<select id='classes'>"+options+"</select>");
        $("#classes").change(function(){
            if(parent.op == "all")
                parent.loadJsonActors($(this).val());
        });
        var nextClass = classes[0].unity;
        if(parent.op == "all")
            parent.loadJsonActors(nextClass);
    }
    this.loadActors = function (actors){
        var options = "";
        var count = actors.length;
        
        for(i=0; i<count; i++){
            options += "<option value='"+actors[i].actorID+"'>"+actors[i].name+"</option>";
        }
        $("#actorsbox").remove();
        $("#filter").append("<div id='actorsbox' class='formField'></div>")
        $("#actorsbox").append("<font>Actor:</font>");
        $("#actorsbox").append("<select id='actors' name='actor'>"+options+"</select>");
        $("#actorsbox").append("<br>");
        $("#actorsbox").append("<br><input type='submit' value='Start'>");
        $("#actors").change(function(){
        });
    }
    this.loadJsonUnity = function (unityID){
        var parent = this;
        $.ajax({
            url:"/render/json",//this is the request page of ajax
            data:{op:'select', id:unityID},//data for throwing the expected url
            type:"POST",
            dataType:"json",// you can also specify for the result for json or xml
            success:function(response){
                parent.loadUnitys(response.unitys, response.fatherID);
            },
            error:function(){
            }
        });
    }
    this.loadJsonClasses = function (unityID){
        var parent = this;
        $.ajax({
            url:"/render/json",//this is the request page of ajax
            data:{op:'classes', id:unityID},//data for throwing the expected url
            type:"POST",
            dataType:"json",// you can also specify for the result for json or xml
            success:function(response){
                parent.loadClasses(response.classes);
            },
            error:function(){
            }
        });
    }
    this.loadJsonActors = function (unityID){
        var parent = this;
        $.ajax({
            url:"/render/json",//this is the request page of ajax
            data:{op:'actors', id:unityID},//data for throwing the expected url
            type:"POST",
            dataType:"json",// you can also specify for the result for json or xml
            success:function(response){
                parent.loadActors(response.actors);
            },
            error:function(){
            }
        });
    }
}