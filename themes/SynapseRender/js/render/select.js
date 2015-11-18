$(document).ready(function () {
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

        DB_synapse.findAllSchools(function (listSchools) {
            //CallBack Schools
            var hClassroom = $('#classroom');
            DB_synapse.findAllClassrooms(function (listClassrooms) {
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
                            strOptionsSchoolsClassrooms += "<option value=" + classroom['id'] + ">"
                                    + school_classrooms['name'] + " [" + classroom['name'] + "]" + "</option>"
                        }
                    }

                    hClassroom.append(strOptionsSchoolsClassrooms);
                } else {
                    hClassroom.html("<option value='-1'>Sem Escola</option>");
                }


            });
        });

        $('#classroom').on('change', function () {
            var classroom_id = $(this).find('option:selected').val();
            DB_synapse.findStudentByClassroom(classroom_id, function (students) {
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

            DB_synapse.findClassroomById(id_classroom_student, function (classroom) {
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



    $('.discipline').on('click', function () {
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


    $('#mode').on('change', function () {
        if ($(this).val() != -1) {
            //Selecionou um Modo
            //Inclui na sessão o nome do modo do render
            sessionStorage.setItem('render_mode', $(this).val());
           
            if ($(this).val() == 'evaluation') {
                //O modo selecionado é avaliação
                //Se o aluno não possuir state_user para esta disciplina(bloco)
                //Então é o primeiro encontro do aluno nessa disciplina(bloco)
                //É necessário, selecionar qual o nível da avaliação
                var id_disciplineSelected = sessionStorage.getItem('id_discipline');
                var id_actorSelected = $("#actor").val();

                DB_synapse.getBlockByDiscipline(id_disciplineSelected, function (cobject_block_id) {
                    // Verifica se encontrou Bloco para a disciplina selecionada
                    if (isset(cobject_block_id)) {
                        //Bloco encontrado
                        //Obter O estado do usuário selecionado neste bloco
                        DB_synapse.getUserState(id_actorSelected, cobject_block_id, function (info_state) {
                            if (isset(info_state)) {
                                //Aluno já possui um estado nesse bloco
                                //Então inicia o render
                                goRender();
                            } else {
                                //É o primeiro acesso do Aluno nesse bloco
                                //É necessário selecionar o Nível
                                $('#select-mode').hide();
                                $('#select-level').show();
                            }
                        });

                    } else {
                        //Não encontrou bloco
                        console.log("Nenhum Bloco foi encontrado para a Disciplina selecionada !!!");
                    }
                });


            } else {
                //Dá início ao Render
                goRender();
            }


        }

    });

    $('#level').on('change', function () {
        if ($(this).val() != -1) {
            //Selecionou um Nível
            //Inclui na sessão o Nível Selecionado para o Modo Atividade
            sessionStorage.setItem('selected_level_evaluation', $(this).val());
            //Dá início ao Render
            goRender();
        }
    });


    $('#toolsAdmin').on('click', function () {
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
    }
    ;


});