$(document).ready(function() {
    //Verificar se é o RenderOnline
    var isOnline = false;
    if (sessionStorage.getItem("isOnline") !== null &&
        sessionStorage.getItem("isOnline") == 'true') {
        //Render Online
        isOnline = true;
    }


    var DB_synapse = new DB();

    /*
     //Classe Principal
     var getAllClassAndStudents = function () {
     DB_synapse.actorOwnUnity = new Array();
     DB_synapse.getAllClass(DB_synapse.getAllStudentFromClasses, eventFilterMeet);
     }

     var eventFilterMeet = function (actorOwnUnity) {
     var classrooms = actorOwnUnity;
     }

     if (sessionStorage.getItem('login_personage_name') === 'Tutor') {
     getAllClassAndStudents();
     } else {
     eventFilterMeet(null);
     }

     */



    if (sessionStorage.getItem('login_personage_name') === 'Tutor' || sessionStorage.getItem('login_personage_name') === 'admin') {
        $("#login-select").show();
        $("#classroom").html("<option value='-1'>Selecione uma Turma</option>");

        DB_synapse.findAllSchools(function(listSchools) {
            //CallBack Schools
            var hClassroom = $('#classroom');
            DB_synapse.findAllClassrooms(function(listClassrooms) {
                //CallBack Classrooms
                var schools_classrooms = [];
                for (var idxSchool in listSchools) {
                    var school = listSchools[idxSchool];
                    schools_classrooms[idxSchool] = {};
                    schools_classrooms[idxSchool]['id'] = school['id'];
                    schools_classrooms[idxSchool]['name'] = school['name'];
                    schools_classrooms[idxSchool]['classrooms'] = [];

                    for (var idxClassroom in listClassrooms) {
                        var classroom = listClassrooms[idxClassroom];
                        //Relacionar todas as Turmas da Escola Corrente
                        if (school['id'] == classroom['school_id']) {
                            //Turma pertence a escola corrente
                            schools_classrooms[idxSchool]['classrooms'].push(classroom);
                        }
                    }
                }

                if (schools_classrooms.length > 0) {
                    //Encontrou pelo menos uma escola
                    var strOptionsSchoolsClassrooms = "";
                    for (var idxSchool in schools_classrooms) {
                        var school_classrooms = schools_classrooms[idxSchool];
                        for (var idxClassroom in school_classrooms['classrooms']) {
                            var classroom = school_classrooms['classrooms'][idxClassroom];
                            strOptionsSchoolsClassrooms += "<option data-stage-fk="+classroom['stage_code'] +
                                " data-year=" + classroom['degree_year'] + " value=" + classroom['id'] + ">" +
                                school_classrooms['name'] + " [" + classroom['name'] + "]" + "</option>"
                        }
                    }

                    hClassroom.append(strOptionsSchoolsClassrooms);
                } else {
                    hClassroom.html("<option value='-1'>Sem Escola</option>");
                }


            });
        });

        $('#classroom').on('change', function() {
            var classroom_id = $(this).find('option:selected').val();
            DB_synapse.findStudentByClassroom(classroom_id, function(students) {
                //Adicionar os estudantes encontrados no select
                var hActor = $('#actor');
                var strOptionsActors = "";
                for (var idx in students) {
                    var student = students[idx];
                    strOptionsActors += "<option value=" + student['id'] + ">" + student['name'] + "</option>";
                }

                if (students.length > 0) {
                    //Encontrou pelo menos um aluno
                    hActor.html(strOptionsActors);
                } else {
                    hActor.html("<option value='-1'>Sem Aluno</option>");
                }

            });
        });


    } else {
        $("#login-select").hide();
        $('#select-student').hide();
        $("#select-discipline").css('margin-top', '10%');
    }


    function goRender() {
        //Um aluno foi selecionado

        if (sessionStorage.getItem('login_personage_name') == 'Tutor' ||
            sessionStorage.getItem('login_personage_name') == 'admin') {
            //Tutor que logou
            //Ator
            sessionStorage.setItem('id_actor', $('#actor').val());
            sessionStorage.setItem('name_actor', $('#actor').find(":selected").text());

            //Turma
            sessionStorage.setItem('id_classroom', $('#classroom').val());
            sessionStorage.setItem('name_classroom', $('#classroom').find(":selected").text());
            sessionStorage.setItem('classroom_stage_fk', $('#classroom').find(":selected").attr("data-stage-fk"));
            sessionStorage.setItem('classroom_year', $('#classroom').find(":selected").attr("data-year"));

            window.location = "./meet.html";
        } else {
            //Aluno que logou
            //Ator
            var id_actor_student = sessionStorage.getItem('login_id_actor');
            var name_actor_student = sessionStorage.getItem('login_name_actor');
            sessionStorage.setItem('id_actor', id_actor_student);
            sessionStorage.setItem('name_actor', name_actor_student);

            //Turma
            var id_classroom_student = sessionStorage.getItem('login_classroom_id_actor');
            sessionStorage.setItem('id_classroom', id_classroom_student);

            DB_synapse.findClassroomById(id_classroom_student, function(classroom) {
                if (classroom !== null) {
                    //Encontrou
                    sessionStorage.setItem('name_classroom', classroom['name']);
                    window.location = "./meet.html";
                } else {
                    //Não encontrou
                }

            });

        }
    }



    $('.discipline').on('click', function() {
        //Inclui na sessão o id da disciplina selecionada
        sessionStorage.setItem('id_discipline', $(this).attr('discipline'));
        //Antes de continuar, solicitar a seleção do Modo do Render
        //Se algum aluno foi selecionado
        if ($('#actor').val() != -1) {
            $('#select-mode').show();
        } else {
            //Abrirá um modal para cadastro de Alunos
            goRender();
        }
    });


    $('#mode').on('change', function() {
        if ($(this).val() != -1) {
            //Selecionou um Modo
            //Inclui na sessão o nome do modo do render
            sessionStorage.setItem('render_mode', $(this).val());

            if ($(this).val() == 'evaluation') {
                //O modo selecionado é avaliação
                //É necessário, selecionar qual o nível da avaliação
                $('#select-mode').hide();
                $('#select-level').show();
            } else {
                //Dá início ao Render
                goRender();
            }

            //Retira a seleção atual
            $(this).find('option:selected').removeAttr('selected');
            //Volta a posição inicial
            $(this).find('option[value=-1]').attr('selected');

        }

    });

    $('#level').on('change', function() {
        if ($(this).val() != -1) {
            //Selecionou um Nível
            //Inclui na sessão o Nível Selecionado para o Modo Atividade
            sessionStorage.setItem('evaluation_selected_level', $(this).val());
            //Dá início ao Render
            goRender();

            //Retira a seleção atual
            $(this).find('option:selected').removeAttr('selected');
            //Volta a posição inicial
            $(this).find('option[value=-1]').attr('selected');

        }
    });


    $('#toolsAdmin').on('click', function() {
        location.href = "import.html";
    });

    /**
     * Verifica se a variavel esta setada.
     *
     * @param {mixed} variable
     * @returns {Boolean}
     */
    function isset(variable) {
        return (variable !== undefined && variable !== null);
    };


});
