// // - - - - - - - - - -  //
// CRIAR BANCO DE DADOS //
// - - - - - - - - - -  //

//Verificar se NÃO é o RenderOnline
if (sessionStorage.getItem("isOnline") === null ||
    sessionStorage.getItem("isOnline") == 'false' ||
    sessionStorage.getItem("isOnline") == '-1') {

    this.DB = function() {
        self = this;
        nameBD = "synapseDB";
        DBversion = 1;
        DBsynapse = null;

        db = null;

        dataImportFunction = null;

        //Quantidade de Conjuntos de Cobjects a serem Importados
        DB.numSetCobjectToImport = 0;

        this.verifyIDBrownser = function() {
            // Na linha abaixo, você deve incluir os prefixos do navegador que você vai testar.
            window.indexedDB = window.indexedDB || window.mozIndexedDB || window.webkitIndexedDB || window.msIndexedDB;
            // Não use "var indexedDB = ..." se você não está numa function.
            // Posteriormente, você pode precisar de referências de algum objeto window.IDB*:
            window.IDBTransaction = window.IDBTransaction || window.webkitIDBTransaction || window.msIDBTransaction;
            window.IDBKeyRange = window.IDBKeyRange || window.webkitIDBKeyRange || window.msIDBKeyRange;
            // (Mozilla nunca usou prefixo nesses objetos, então não precisamos window.mozIDB*)
            return window.indexedDB;
        }

        this.openDBuild = function(alterSchema, dataImportFunction, dataJsonLin, dataJsonMat, dataJsonCommonInfo, dataJsonByScripts) {
            self.dataImportFunction = dataImportFunction;
            self.dataJsonLin = dataJsonLin;
            self.dataJsonMat = dataJsonMat;
            self.dataJsonCommonInfo = dataJsonCommonInfo;
            self.dataJsonByScripts = dataJsonByScripts;

            window.indexedDB = self.verifyIDBrownser();
            if (!window.indexedDB) {
                console.log("Seu navegador não suporta uma versão estável do IndexedDB. Alguns recursos não estarão disponíveis.");
            }
            //Verificar se precisa mudar o setVersion para alterar o schema do BD
            var alterSchema = (this.isset(alterSchema) && alterSchema);

            //Se ainda não atualizou o DBversion, então abre o banco na sua versão atual
            var synapseBD;
            synapseBD = window.indexedDB.open(nameBD, 2);

            synapseBD.onerror = function(event) {
                console.log("Error: ");
                console.log(event);

            }

            synapseBD.onsuccess = function(event) {
                var db = event.target.result;
                db.onerror = function(event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    alert("Database error: " + event.target.errorCode);
                };

                db.onclose = function(event) {
                    console.log(event);
                };

                db.onversionchange = function(event) {
                    console.log(event);
                };

                DBversion = db.version;
                if (alterSchema) {
                    DBversion++;
                }
                //Antes de abrir o banco novamente, fecha essa conexão com o BD
                //synapseBD.result.close();
                db.close();
                openBuild();
            }

            synapseBD.onversionchange = function(event) {
                console.log(event);
            };

            synapseBD.onblocked = function(event) {
                // Se existe outra aba com a versão antiga
                console.log("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            };

        }



        var openBuild = function() {
            DBsynapse = window.indexedDB.open(nameBD, DBversion);
            DBsynapse.onversionchange = function(event) {
                console.log(event);
            };

            DBsynapse.onerror = function(event) {
                console.log("Error: ");
                console.log(event);
            };
            DBsynapse.onsuccess = function(event) {
                var db = event.target.result;
                db.onerror = function(event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    alert("Database error: " + event.target.errorCode);
                };

                db.onclose = function(event) {
                    console.log(event);
                };

            }

            DBsynapse.onblocked = function(event) {
                // Se existe outra aba com a versão antiga
                console.log("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            };

            //Se for uma nova versão é criado o novo schemma do banco
            self.buildAllSchema();


        }


        this.buildAllSchema = function() {
            //Criar Schemas das tabelas
            DBsynapse.onupgradeneeded = function(event) {
                var db = event.target.result;

                db.onclose = function(event) {
                    console.log(event);
                };

                console.log(db);
                //============  School  ===========================
                var schoolStore = db.createObjectStore("school", {
                    keyPath: "id"
                });
                // Podemos ter nomes duplicados, então não podemos usar como índice único.
                schoolStore.createIndex("name", "name", {
                    unique: false
                });

                //=============================================

                var unityStore = db.createObjectStore("unity", {
                    keyPath: "id"
                });
                // Podemos ter nomes duplicados, então não podemos usar como índice único.
                unityStore.createIndex("name", "name", {
                    unique: false
                });
                // Podemos ter school_id duplicados, então não podemos usar como índice único.
                unityStore.createIndex("school_id", "school_id", {
                    unique: false
                });

                // Falta organization_id & father_id
                //===========================================

                // cria um objectStore de ACTOR
                var actorStore = db.createObjectStore("actor", {
                    keyPath: "id"
                });
                // Podemos ter nomes duplicados, então não podemos usar como índice único.
                actorStore.createIndex("name", "name", {
                    unique: false
                });
                actorStore.createIndex("login", "login", {
                    unique: true
                });
                actorStore.createIndex("unity_id", "unity_id", {
                    unique: false
                });
                // Falta personage_name & password
                //===============================================

                // cria um objectStore da discipline
                var disciplineStore = db.createObjectStore("discipline", {
                    keyPath: "id"
                });
                disciplineStore.createIndex("name", "name", {
                    unique: true
                });
                //================================================

                // cria um objectStore da degree
                var degreeStore = db.createObjectStore("degree", {
                    keyPath: "id"
                });
                degreeStore.createIndex("name", "name", {
                    unique: true
                });
                //================================================

                // cria um objectStore da StageVsModality
                var stageVsModalityStore = db.createObjectStore("stage_vs_modality", {
                    keyPath: "id"
                });
                stageVsModalityStore.createIndex("stage_code", "stage_code", {
                    unique: true
                });
                //================================================

                // cria um objectStore do cobjectblock
                var cobjectblockStore = db.createObjectStore("cobjectblock", {
                    keyPath: "id"
                });
                // Nome do bloco deve ser Único
                cobjectblockStore.createIndex("name", "name", {
                    unique: true
                });

                // discipline_id
                cobjectblockStore.createIndex("discipline_id", "discipline_id", {
                    unique: false
                });

                //================================================


                // cria um objectStore do cobject_cobjectblock
                var cobject_cobjectblockStore = db.createObjectStore("cobject_cobjectblock", {
                    keyPath: "id"
                });
                //Criar Index para cobject_block_id
                cobject_cobjectblockStore.createIndex("cobject_block_id", "cobject_block_id", {
                    unique: false
                });

                // Faltam cobject_id
                //================================================

                // cria um objectStore do act_goal
                var act_goalStore = db.createObjectStore("act_goal", {
                    keyPath: "id"
                });
                //Criar Index para discipline_id
                act_goalStore.createIndex("discipline_id", "discipline_id", {
                    unique: false
                });
                //Criar Index para stage
                act_goalStore.createIndex("degree_id", "degree_id", {
                    unique: false
                });

                // Cria um objectStore do act_script
                var act_scriptStore = db.createObjectStore("act_script", {
                    keyPath: "id"
                });
                //Criar Index para discipline_id
                act_scriptStore.createIndex("discipline_id", "discipline_id", {
                    unique: false
                });

                // Cria um objectStore do act_script_goal
                var act_script_goalStore = db.createObjectStore("act_script_goal", {
                    keyPath: "id"
                });
                //Criar Index para goal_id
                act_script_goalStore.createIndex("goal_id", "goal_id", {
                    unique: false
                });
                //Criar Index para script_id
                act_script_goalStore.createIndex("script_id", "script_id", {
                    unique: false
                });
                //==============================================================

                //Cria um objectStore do Cobject
                var cobjectStore = db.createObjectStore("cobject", {
                    keyPath: "cobject_id"
                });
                // E Falta  o Json de toda a view deste cobject_id
                //================================================
                // cria um objectStore do performance_actor
                var performance_actorStore = db.createObjectStore("performance_actor", {
                    keyPath: "id",
                    autoIncrement: true
                });

                //===============================================

                //Criar o OBJECTSTORE ESPECÍFICO do RENDER
                // state_actor
                var state_actorStore = db.createObjectStore("state_actor", {
                    keyPath: "id",
                    autoIncrement: true
                });

                state_actorStore.createIndex("actor_id", "actor_id", {
                    unique: false
                });
                state_actorStore.createIndex("render_mode", "render_mode", {
                    unique: false
                });
                state_actorStore.createIndex("cobject_block_id", "cobject_block_id", {
                    unique: false
                });
                state_actorStore.createIndex("evaluation_selected_level", "evaluation_selected_level", {
                    unique: false
                });

                state_actorStore.createIndex("discipline_id", "discipline_id", {
                    unique: false
                });

                // stop_point_diagnostic
                var stop_point_diagnosticStore = db.createObjectStore("stop_point_diagnostic", {
                    keyPath: "id",
                    autoIncrement: true
                });

                stop_point_diagnosticStore.createIndex("actor_id", "actor_id", {
                    unique: false
                });
                stop_point_diagnosticStore.createIndex("act_goal_content_id", "act_goal_content_id", {
                    unique: false
                });



                // Usando transação oncomplete para afirmar que a criação do objectStore
                // é terminada antes de adicionar algum dado nele.
                schoolStore.transaction.oncomplete = function(event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat, self.dataJsonCommonInfo, self.dataJsonByScripts);
                    console.log('Criou os Schemas');
                }

                unityStore.transaction.oncomplete = function(event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat, self.dataJsonCommonInfo, self.dataJsonByScripts);
                    console.log('Criou os Schemas');
                }

                actorStore.transaction.oncomplete = function(event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat, self.dataJsonCommonInfo, self.dataJsonByScripts);
                    console.log('Criou os Schemas');
                }
                disciplineStore.transaction.oncomplete = function(event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat, self.dataJsonCommonInfo, self.dataJsonByScripts);
                    console.log('Criou os Schemas');
                }
                degreeStore.transaction.oncomplete = function(event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat, self.dataJsonCommonInfo, self.dataJsonByScripts);
                    console.log('Criou os Schemas');
                }
                stageVsModalityStore.transaction.oncomplete = function(event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat, self.dataJsonCommonInfo, self.dataJsonByScripts);
                    console.log('Criou os Schemas');
                }
                cobjectblockStore.transaction.oncomplete = function(event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat, self.dataJsonCommonInfo, self.dataJsonByScripts);
                    console.log('Criou os Schemas');
                }
                cobject_cobjectblockStore.transaction.oncomplete = function(event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat, self.dataJsonCommonInfo, self.dataJsonByScripts);
                    console.log('Criou os Schemas');
                }
                cobjectStore.transaction.oncomplete = function(event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat, self.dataJsonCommonInfo, self.dataJsonByScripts);
                    console.log('Criou os Schemas');
                }
                performance_actorStore.transaction.oncomplete = function(event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat, self.dataJsonCommonInfo, self.dataJsonByScripts);
                    console.log('Criou os Schemas');
                }
                state_actorStore.transaction.oncomplete = function(event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat, self.dataJsonCommonInfo, self.dataJsonByScripts);
                    console.log('Criou os Schemas');
                }


                act_goalStore.transaction.oncomplete = function(event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat, self.dataJsonCommonInfo, self.dataJsonByScripts);
                    console.log('Criou os Schemas');
                }

                act_scriptStore.transaction.oncomplete = function(event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat, self.dataJsonCommonInfo, self.dataJsonByScripts);
                    console.log('Criou os Schemas');
                }

                act_script_goalStore.transaction.oncomplete = function(event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat, self.dataJsonCommonInfo, self.dataJsonByScripts);
                    console.log('Criou os Schemas');
                }

                stop_point_diagnosticStore.transaction.oncomplete = function(event) {
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat, self.dataJsonCommonInfo, self.dataJsonByScripts);
                    console.log('Criou os Schemas');
                }

                useDatabase(db);


            }
        }


        // - - - - - - - - - -  //
        // IMPORT PARA BANCO DE DADOS //
        // - - - - - - - - - -  //


        //Importar Dados Comuns a todo Arquivo de Importação
        this.importCommonInfo = function (dataJsonCommonInfo) {
            console.log(dataJsonCommonInfo);
            var schools = new Array();
            var unitys = new Array();
            var actors = new Array();
            var disciplines = new Array();
            var degrees = new Array();
            var stageVsModality = new Array();

            //Percorrer todos objetos existentes no ActorsOwnUnity
            $.each(dataJsonCommonInfo.ActorsInClassroom, function (idx, object) {
                var tempSchool = {};
                tempSchool.id = object.school_id;
                tempSchool.name = object.school_name;
                if (!existInArray(schools, tempSchool.id)) {
                    schools.push(tempSchool);
                }

                var tempUnity = {};
                tempUnity.id = object.classroom_id;
                //FK para a school
                tempUnity.school_id = object.school_id;
                tempUnity.name = object.classroom_name;
                if (!existInArray(unitys, tempUnity.id)) {
                    unitys.push(tempUnity);
                }
                var tempActor = {};
                tempActor.id = object.id;
                tempActor.login = object.login;
                tempActor.name = object.name;
                tempActor.password = object.password;
                tempActor.personage_name = object.personage;
                //Chave Estrageira para a sua unidade
                tempActor.unity_id = object.classroom_id;
                if (!existInArray(actors, tempActor.id)) {
                    actors.push(tempActor);
                }
            });
            disciplines = dataJsonCommonInfo.Disciplines;
            degrees = dataJsonCommonInfo.Degrees;
            stageVsModality = dataJsonCommonInfo.StageVsModality;

            //Add campo 'createdOffline' nos actors
            for (var idx in actors) {
                var actor = actors[idx];
                actor.createdOffline = false;
            }
            //Add campo 'createdOffline' nos 'schools'
            for (var idx in schools) {
                var school = schools[idx];
                school.createdOffline = false;
            }
            //Add campo 'createdOffline' nas 'unitys'
            for (var idx in unitys) {
                var unity = unitys[idx];
                unity.createdOffline = false;
            }

            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function(event) {
                console.log("Error: ");
                console.log(event);
                //alert("Você não habilitou minha web app para usar IndexedDB?!");
            };
            DBsynapse.onsuccess = function(event) {
                var db = event.target.result;
                db.onerror = function(event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    console.log("Database error: " + event.target.error.message);
                };

                    //==================================================
                    //Importar as schools
                    self.importSchool(db, schools);

                    //Importar as unitys
                    self.importUnity(db, unitys);

                    //Importar os atores
                    self.importActor(db, actors);

                    //Importar as disciplines
                    self.importDiscipline(db, disciplines);

                    //Importar os degrees
                    self.importDegree(db, degrees);

                    //Importar os stageVsModality
                    self.importStageVsModality(db, stageVsModality);

                    //Importar Escolas e Turmas Offline VERIFICAR
                   // self.importSchoolsClassroomsOff(db, data_schoolsClassrooms);

                //Fecha o DB
                db.close();

            }
            DBsynapse.onblocked = function(event) {
                // Se existe outra aba com a versão antiga
                window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            }

        }

        //Importar Dados das Atividades agrupada em Blocos
        this.importByBlock = function (dataJsonCobjectByBlock) {
            var dataCobjectBlock = dataJsonCobjectByBlock.CobjectBlock;
            var dataCobjectCobjectBlock =  dataJsonCobjectByBlock.Cobject_cobjectBlocks;
            var dataCobjects =  dataJsonCobjectByBlock.Cobjects;

            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function(event) {
                console.log("Error: ");
                console.log(event);
                //alert("Você não habilitou minha web app para usar IndexedDB?!");
            };
            DBsynapse.onsuccess = function(event) {
                var db = event.target.result;
                db.onerror = function(event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    console.log("Database error: " + event.target.error.message);
                };

                //==================================================
                //Importar os cobjectblocks
                self.importCobjectblock(db, dataCobjectBlock);

                //Importar os cobject_cobjectblocks
                self.importCobject_cobjectblock(db, dataCobjectCobjectBlock);

                // Salvar o Objeto JSON. NÃO PRECISA CRIAR VARIAS TABELA E GERAR UM JSON. Custa processamento.
                //Importar os cobjects

                self.importCobject(db, dataCobjects);

                //Fecha o DB
                db.close();
            }
            DBsynapse.onblocked = function(event) {
                // Se existe outra aba com a versão antiga
                window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            }

        }

        //Importar Dados das Atividades agrupada em Blocos
        this.importByScript = function (dataJsonCobjectByScript) {
            var act_goals = dataJsonCobjectByScript.Goals;
            var act_scripts = dataJsonCobjectByScript.Scripts;
            var act_script_goals= dataJsonCobjectByScript.ScriptsGoals;
            var data_cobjects = dataJsonCobjectByScript.Cobjects;

            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function(event) {
                console.log("Error: ");
                console.log(event);
                //alert("Você não habilitou minha web app para usar IndexedDB?!");
            };
            DBsynapse.onsuccess = function(event) {
                var db = event.target.result;
                db.onerror = function(event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    console.log("Database error: " + event.target.error.message);
                };

                //==================================================
                //Importar as act_goals
                self.importActGoals(db, act_goals);

                //Importar as act_scripts
                self.importActScripts(db, act_scripts);

                //Importar as act_script_goals
                self.importActScriptGoal(db, act_script_goals);

                //Importar os cobjects
                self.importCobject(db, data_cobjects);

                //Fecha o DB
                db.close();
            }
            DBsynapse.onblocked = function(event) {
                // Se existe outra aba com a versão antiga
                window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            }

        }

        this.importAllDataRender = function(schools, unitys, actors, disciplines, cobjectblock, cobject_cobjectblocks, cobjects) {
            //Obter o goal, content e script do cobjects
            var act_goals = new Array();
            var act_contents = new Array();
            var act_goal_contents = new Array();
            var act_scripts = new Array();
            var act_script_contents = new Array();

            for (var idx in cobjects) {
                var current_cobject = cobjects[idx];
                //Objetivo corrente
                var current_goal_id = current_cobject.goal_id;
                var current_goal = current_cobject.goal;
                var current_goal_discipline_id = current_cobject.goal_discipline_id;
                var stage = current_cobject.stage;
                var year = current_cobject.year;
                var grade = current_cobject.grade;

                //Conteúdo corrente
                var current_content_id = current_cobject.content_id;
                var current_content = current_cobject.content;
                var current_content_discipline_id = current_cobject.content_discipline_id;

                //Roteiro Corrente
                var current_script_id = current_cobject.script_id;
                var current_script_discipline_id = current_cobject.script_discipline_id;

                //Na relação objetivo + conteúdo
                var current_goal_content_id = current_cobject.goal_content_id;

                //Na relação roteiro + conteúdo
                var current_script_content_id = current_cobject.script_content_id;
                var current_script_content_status = current_cobject.script_content_status;

                //indexar array com o id do banco, para que não insira repetições;

                act_goals[current_goal_id] = {
                    id: current_goal_id,
                    name: current_goal,
                    discipline_id: current_goal_discipline_id,
                    stage: stage,
                    year: year,
                    grade: grade
                };

                act_contents[current_content_id] = {
                    id: current_content_id,
                    name: current_content,
                    discipline_id: current_content_discipline_id
                };

                act_scripts[current_script_id] = {
                    id: current_script_id,
                    discipline_id: current_script_discipline_id
                };

                act_goal_contents[current_goal_content_id] = {
                    id: current_goal_content_id,
                    goal_id: current_goal_id,
                    content_id: current_content_id
                };

                act_script_contents[current_script_content_id] = {
                    id: current_script_content_id,
                    script_id: current_script_id,
                    content_id: current_content_id,
                    status: current_script_content_status
                };


            }


            var options = {
                schools: schools,
                unitys: unitys,
                actors: actors,
                disciplines: disciplines,
                cobjectblock: cobjectblock,
                cobject_cobjectblocks: cobject_cobjectblocks,
                cobjects: cobjects,
                act_goals: act_goals,
                act_contents: act_contents,
                act_scripts: act_scripts,
                act_goal_contents: act_goal_contents,
                act_script_contents: act_script_contents

            };

        }

        //////////////////////
        //Métodos de Import
        /////////////////////

        //Importar as schools
        this.importSchool = function(db, data_school) {
            var SchoolObjectStore = db.transaction("school", "readwrite").objectStore("school");
            for (var i in data_school) {
                SchoolObjectStore.add(data_school[i]);
            }
            SchoolObjectStore.transaction.oncomplete = function(event) {
                db.close();
                console.log("Schools IMPORTED!");
            };
        };

        //Importar as unitys
        this.importUnity = function(db, data_unity) {
            var UnityObjectStore = db.transaction("unity", "readwrite").objectStore("unity");
            for (var i in data_unity) {
                UnityObjectStore.add(data_unity[i]);
            }
            UnityObjectStore.transaction.oncomplete = function(event) {
                db.close();
                console.log("Unitys IMPORTED!");
            }
        }

        //Importar os atores
        this.importActor = function(db, data_actor) {
            var ActorObjectStore = db.transaction("actor", "readwrite").objectStore("actor");
            for (var i in data_actor) {
                ActorObjectStore.add(data_actor[i]);
            }
            ActorObjectStore.transaction.oncomplete = function(event) {
                db.close();
                console.log("Actors IMPORTED!");
            }
        }

        //Importar as disciplines
        this.importDiscipline = function(db, data_discipline) {
            var DisciplineObjectStore = db.transaction("discipline", "readwrite").objectStore("discipline");
            for (var i in data_discipline) {
                DisciplineObjectStore.add(data_discipline[i]);
            }
            DisciplineObjectStore.transaction.oncomplete = function(event) {
                db.close();
                console.log("Disciplines IMPORTED!");
            }
        }

        //Importar os Degrees
        this.importDegree = function(db, data_degree) {
            var DegreeObjectStore = db.transaction("degree", "readwrite").objectStore("degree");
            for (var i in data_degree) {
                DegreeObjectStore.add(data_degree[i]);
            }
            DegreeObjectStore.transaction.oncomplete = function(event) {
                db.close();
                console.log("Degree IMPORTED!");
            }
        }


        //Importar os StageVsModality
        this.importStageVsModality = function(db, data_StageVsModality) {
            var StageVsModalityObjectStore = db.transaction("stage_vs_modality", "readwrite").objectStore("stage_vs_modality");
            for (var i in data_StageVsModality) {
                StageVsModalityObjectStore.add(data_StageVsModality[i]);
            }
            StageVsModalityObjectStore.transaction.oncomplete = function(event) {
                db.close();
                console.log("StageVsModality IMPORTED!");
            }
        }

        //Importar os cobjectblocks
        this.importCobjectblock = function(db, data_cobjectBlock) {
            var CobjectblockObjectStore = db.transaction("cobjectblock", "readwrite").objectStore("cobjectblock");
            for (var i in data_cobjectBlock) {
                CobjectblockObjectStore.add(data_cobjectBlock[i]);
            }
            CobjectblockObjectStore.transaction.oncomplete = function(event) {
                db.close();
                console.log("Cobjectblocks IMPORTED!");
            }
        }

        //Importar os cobject_cobjectblocks
        this.importCobject_cobjectblock = function(db, data_cobject_cobjectBlock) {
            var Cobject_cobjectBlockObjectStore = db.transaction("cobject_cobjectblock", "readwrite").objectStore("cobject_cobjectblock");

            for (var i in data_cobject_cobjectBlock) {
                data_cobject_cobjectBlock[i].id = eval(data_cobject_cobjectBlock[i].id);
                Cobject_cobjectBlockObjectStore.add(data_cobject_cobjectBlock[i]);
            }
            Cobject_cobjectBlockObjectStore.transaction.oncomplete = function(event) {
                db.close();
                console.log("Cobject_cobjectblocks IMPORTED!");
            }
        }

        // Salvar o Objeto JSON. NÃO PRECISA CRIAR VARIAS TABELA E GERAR UM JSON. Custa processamento.
        //Importar os cobjects
        this.importCobject = function(db, data_cobject) {
            var CobjectObjectStore = db.transaction("cobject", "readwrite").objectStore("cobject");
            for (var i in data_cobject) {
                var currentCobject = data_cobject[i];
                CobjectObjectStore.add(currentCobject);
            }
            CobjectObjectStore.transaction.oncomplete = function(event) {
                db.close();
                //Somente deve aparecer a mensagem que Salvou todos os Cobjects
                //Quando todos os arquivos que possui conjuntos de Cobjects forem importados
                DB.numSetCobjectToImport--;
                if(DB.numSetCobjectToImport == 0){
                    window.alert("Atividades Importadas!");
                }

            }
        }

        //Importar os performance_actors
        this.importPerformance_actor = function(db, data_performance_actor) {
            var Performance_actorObjectStore = db.transaction("performance_actor", "readwrite").objectStore("performance_actor");
            for (var i in data_performance_actor) {
                Performance_actorObjectStore.add(data_performance_actor[i]);
            }
            Performance_actorObjectStore.transaction.oncomplete = function(event) {
                db.close();
                console.log("Performance_actors IMPORTED!");
            }
        }

        //Importar os Escolas OffLine, se houver
        this.importSchoolsClassroomsOff = function(db, schoolClassrooms) {
            //schoolsClassrooms['schools'][0]['classrooms']
            var listSchools = schoolClassrooms['schools'];
            var idxSchool = 0;
            self.addSchoolClassroomsOff(listSchools, idxSchool);
        }



        //Importar as act_goals
        this.importActGoals = function(db, act_goals) {
            if (act_goals.length > 0) {
                var ActGoalObjectStore = db.transaction("act_goal", "readwrite").objectStore("act_goal");
                for (var i in act_goals) {
                    var currentGroupGoals = act_goals[i]['goals'];
                    var currentGroupDiscipline = act_goals[i]['discipline_id'];
                    for (var j in currentGroupGoals) {
                        //Para cada Goals nesse Grupo(goals que possuem mesma discipline e stage)
                        var currentDataStoreGoal = {
                            id: currentGroupGoals[j]['id'],
                            name: currentGroupGoals[j]['goal_name'],
                            degree_id : currentGroupGoals[j]['goal_degree_id'],
                            discipline_id : currentGroupDiscipline
                        };
                        ActGoalObjectStore.add(currentDataStoreGoal);
                    }
                }
                ActGoalObjectStore.transaction.oncomplete = function(event) {
                    db.close();
                    console.log("ActGoals IMPORTED!");
                }
            }
        }

        //Importar as act_contents
        this.importActContents = function(db, act_contents) {
            if (act_contents.length > 0) {
                var ActContentObjectStore = db.transaction("act_content", "readwrite").objectStore("act_content");
                for (var i in act_contents) {
                    ActContentObjectStore.add(act_contents[i]);
                }
                ActContentObjectStore.transaction.oncomplete = function(event) {
                    db.close();
                    console.log("ActContents IMPORTED!");
                }
            }
        }

        //Importar as act_scripts
        this.importActScripts = function(db, act_scripts) {
                var ActScriptObjectStore = db.transaction("act_script", "readwrite").objectStore("act_script");
                for (var i in act_scripts) {
                    ActScriptObjectStore.add(act_scripts[i]);
                }
                ActScriptObjectStore.transaction.oncomplete = function(event) {
                    db.close();
                    console.log("ActScript IMPORTED!");
                }
        }

        //Importar as act_script_goal
        this.importActScriptGoal = function(db, act_script_goals) {
            if (act_script_goals.length > 0) {
                var ActScriptGoalObjectStore = db.transaction("act_script_goal", "readwrite").objectStore("act_script_goal");
                for (var i in act_script_goals) {
                    ActScriptGoalObjectStore.add(act_script_goals[i]);
                }
                ActScriptGoalObjectStore.transaction.oncomplete = function(event) {
                    db.close();
                    console.log("ActScriptGoal IMPORTED!");
                }
            }
        }

        //Importar as act_goal_contents
        this.importActGoalContent = function(db, act_goal_contents) {
            if (act_goal_contents.length > 0) {
                var ActGoalContentObjectStore = db.transaction("act_goal_content", "readwrite").objectStore("act_goal_content");
                for (var i in act_goal_contents) {
                    ActGoalContentObjectStore.add(act_goal_contents[i]);
                }
                ActGoalContentObjectStore.transaction.oncomplete = function(event) {
                    db.close();
                    console.log("ActGoalContent IMPORTED!");
                }
            }
        }

        //Importar as act_script_contents
        this.importActScriptContent = function(db, act_script_contents) {
            if (act_script_contents.length > 0) {
                var ActScriptContentObjectStore = db.transaction("act_script_content", "readwrite").objectStore("act_script_content");
                for (var i in act_script_contents) {
                    ActScriptContentObjectStore.add(act_script_contents[i]);
                }
                ActScriptContentObjectStore.transaction.oncomplete = function(event) {
                    db.close();
                    console.log("ActScriptContent IMPORTED!");
                }
            }
        }


        // - - - - - - - - - -  //
        // EXPORTE PARA BANCO DE DADOS //
        // - - - - - - - - - -  //

        //Export os performances_actors
        this.exportPerformance_actor = function(callBack) {
            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function(event) {
                console.log("Error: ");
                console.log(event);
                //alert("Você não habilitou minha web app para usar IndexedDB?!");
            };
            DBsynapse.onsuccess = function(event) {
                var db = event.target.result;
                db.onerror = function(event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    console.log("Database error: " + event.target.errorCode);
                };

                var performances = new Array();

                var Performance_actorObjectStore = db.transaction("performance_actor", "readonly").objectStore("performance_actor");
                Performance_actorObjectStore.openCursor().onsuccess = function(event) {
                    var cursor = event.target.result;
                    if (cursor) {
                        var currentPerformance = '{"actor_id":"' + cursor.value.actor_id;
                        currentPerformance += '", "interval_resolution":"' + cursor.value.interval_resolution;
                        currentPerformance += '", "group_id":"' + cursor.value.group_id;
                        currentPerformance += '", "iscorrect":"' + cursor.value.iscorrect;
                        currentPerformance += '", "piece_id":"' + cursor.value.piece_id;
                        currentPerformance += '", "value":"' + cursor.value.value + '"}';
                        performances.push(currentPerformance);

                        cursor.continue();
                    } else {
                        //Não existe mais registros!
                        var jsonExport = "[";
                        for (var i = 0; i < performances.length; i++) {
                            jsonExport += performances[i];
                            //Se NAO for o ultimo
                            if (i < performances.length - 1) {
                                jsonExport += ", ";
                            }
                        }
                        jsonExport += "]";

                        //Chama a função de callBack
                        callBack(jsonExport);

                    }
                };

            }
            DBsynapse.onblocked = function(event) {
                // Se existe outra aba com a versão antiga
                window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            }

        }



        // - - - - - - - - - -  //
        // EXPORTE PARA O EEG - IBlue //
        // - - - - - - - - - -  //

        this.exportToEEG = function(callBack) {
            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function(event) {
                console.log("Error: ");
                console.log(event);
                //alert("Você não habilitou minha web app para usar IndexedDB?!");
            };
            DBsynapse.onsuccess = function(event) {
                var db = event.target.result;
                db.onerror = function(event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    console.log("Database error: " + event.target.errorCode);
                };

                var performancesForActors = [];
                var Performance_actorObjectStore = db.transaction("performance_actor", "readonly").objectStore("performance_actor");
                Performance_actorObjectStore.openCursor().onsuccess = function(event) {
                    var cursor = event.target.result;

                    if (cursor) {
                        //Criação de um array, onde armazenará todas as performances e agrupá-las por Atores
                        if (performancesForActors[cursor.value.actor_id] === undefined ||
                            performancesForActors[cursor.value.actor_id] === null) {
                            performancesForActors[cursor.value.actor_id] = [];
                        }
                        var sizePerformancesThisActor = performancesForActors[cursor.value.actor_id].length;
                        performancesForActors[cursor.value.actor_id][sizePerformancesThisActor] = [];
                        performancesForActors[cursor.value.actor_id][sizePerformancesThisActor]['actor_id'] = cursor.value.actor_id;
                        performancesForActors[cursor.value.actor_id][sizePerformancesThisActor]['interval_resolution'] = cursor.value.interval_resolution;
                        performancesForActors[cursor.value.actor_id][sizePerformancesThisActor]['final_time'] = cursor.value.final_time;
                        performancesForActors[cursor.value.actor_id][sizePerformancesThisActor]['piece_id'] = cursor.value.piece_id;
                        performancesForActors[cursor.value.actor_id][sizePerformancesThisActor]['iscorrect'] = cursor.value.iscorrect;


                        cursor.continue();
                    } else {
                        //Não existe mais registros
                        //
                        //Transformar o Array de Atores e suas performances em uma String
                        for (var actorID in performancesForActors) {
                            //Para cada Actor
                            var textToExport = "actor_id|interval_resolution|final_time|piece_id|iscorrect";
                            for (var idxPerformance in performancesForActors[actorID]) {
                                //Para cada performance do Actor corrente
                                var performance = performancesForActors[actorID][idxPerformance];
                                textToExport += "\n" + performance['actor_id'];
                                textToExport += "|" + performance['interval_resolution'];
                                textToExport += "|" + performance['final_time'];
                                textToExport += "|" + performance['piece_id'];
                                textToExport += "|" + performance['iscorrect'];
                            }
                            //Baixa um arquivo TXT do ExportToEEG desse Actor Corrente
                            //Realizar download da String
                            callBack(textToExport, actorID);
                        }

                    }
                };

            }
            DBsynapse.onblocked = function(event) {
                // Se existe outra aba com a versão antiga
                window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            }

        }


        //Pesquisas No Banco
        this.login = function(login, password, callBack) {
            if (login !== '' && password !== '' && self.isset(login) && self.isset(password)) {

                if (login == 'admin') {
                    if (password == '123456') {
                        //Senha correta
                        var name = "Administrador";
                        var id = "-1";
                        var personage_name = "admin";
                        var classroom_id = "-1";
                        //Armazenar nome do usuário e id_Actor na sessão
                        sessionStorage.setItem("authorization", true);
                        sessionStorage.setItem("login_id_actor", id);
                        sessionStorage.setItem("login_name_actor", name);
                        sessionStorage.setItem('login_personage_name', personage_name);
                        sessionStorage.setItem("login_classroom_id_actor", classroom_id);

                    } else {
                        //Senha incorreta
                        sessionStorage.setItem("authorization", false);
                    }

                    //Chama o callBack
                    callBack();

                } else {
                    //Não é um admin
                    window.indexedDB = self.verifyIDBrownser();
                    DBsynapse = window.indexedDB.open(nameBD);
                    DBsynapse.onerror = function(event) {
                        console.log("Error: ");
                        console.log(event);
                        // alert("Você não habilitou minha web app para usar IndexedDB?!");
                    }
                    DBsynapse.onsuccess = function(event) {
                        var db = event.target.result;
                        db.onerror = function(event) {
                                // Função genérica para tratar os erros de todos os requests desse banco!
                                console.log("Database error: " + event.target.errorCode);
                            }
                            //Tudo ok Então Busca O Actor
                        var ActorObjectStore = db.transaction("actor").objectStore("actor");
                        var requestGet = ActorObjectStore.index("login").get(login);
                        requestGet.onerror = function(event) {
                            // Tratar erro!
                        }
                        requestGet.onsuccess = function(event) {
                            // Fazer algo com request.result!
                            if (self.isset(requestGet.result)) {
                                //Encontrou o Usuário
                                if (password == requestGet.result.password) {
                                    //Senha correta
                                    var name = requestGet.result.name;
                                    var id = requestGet.result.id;
                                    var personage_name = requestGet.result.personage_name;
                                    var classroom_id = requestGet.result.unity_id;
                                    //Armazenar nome do usuário e id_Actor na sessão
                                    sessionStorage.setItem("authorization", true);
                                    sessionStorage.setItem("login_id_actor", id);
                                    sessionStorage.setItem("login_name_actor", name);
                                    sessionStorage.setItem('login_personage_name', personage_name);
                                    sessionStorage.setItem("login_classroom_id_actor", classroom_id);
                                } else {
                                    sessionStorage.setItem("authorization", false);
                                }

                            } else {
                                //Usuário Não encontrado
                                sessionStorage.setItem("authorization", false);
                            }

                            //Chama o método callBack
                            callBack();
                        }

                    }
                    DBsynapse.onblocked = function(event) {
                        // Se existe outra aba com a versão antiga
                        window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
                    }
                }

            } else {
                //Usuário ou Senha nulos
                sessionStorage.setItem("authorization", false);
                //Chama o método callBack
                callBack();
            }

        }



        //Confirmar a snha do administrador
        this.confirmPassWordAdmin = function(password, callBack) {
            var login = "admin";
            var passWordOk = false;
            if (login !== '' && password !== '' && self.isset(login) && self.isset(password)) {
                if (password == '123456') {
                    //Senha correta
                    passWordOk = true;
                }
                //Chama o callBack
                callBack(passWordOk);

            } else {
                //Chama o método callBack
                callBack(passWordOk);
            }

        }

        //===================
        this.getCobject = function(cobject_id, callBack) {
            if (self.isset(cobject_id)) {
                window.indexedDB = self.verifyIDBrownser();
                DBsynapse = window.indexedDB.open(nameBD);
                DBsynapse.onerror = function(event) {
                    console.log("Error: ");
                    console.log(event);
                    //alert("Você não habilitou minha web app para usar IndexedDB?!");
                }
                DBsynapse.onsuccess = function(event) {
                    var db = event.target.result;
                    db.onerror = function(event) {
                            // Função genérica para tratar os erros de todos os requests desse banco!
                            window.alert("Database error: " + event.target.errorCode);
                        }
                        //Tudo ok Então Busca O Cobject
                    var cobjectStore = db.transaction("cobject").objectStore("cobject");
                    var requestGet = cobjectStore.get(cobject_id);
                    requestGet.onerror = function(event) {
                        // Tratar erro!
                    }
                    requestGet.onsuccess = function(event) {
                        var json_cobject = requestGet.result;
                        callBack(json_cobject);
                    }

                }
                DBsynapse.onblocked = function(event) {
                    // Se existe outra aba com a versão antiga
                    window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
                }
            }
        }

        //===================
        this.getCobjectsFromBlock = function(block_id, callBack) {
            if (self.isset(block_id)) {
                window.indexedDB = self.verifyIDBrownser();
                DBsynapse = window.indexedDB.open(nameBD);
                DBsynapse.onerror = function(event) {
                    console.log("Error: ");
                    console.log(event);
                    // alert("Você não habilitou minha web app para usar IndexedDB?!");
                }
                DBsynapse.onsuccess = function(event) {
                    var db = event.target.result;
                    db.onerror = function(event) {
                            // Função genérica para tratar os erros de todos os requests desse banco!
                            window.alert("Database error: " + event.target.errorCode);
                        }
                        //Tudo ok Então Busca O Cobject
                    var cobjectStore = db.transaction("cobject_cobjectblock").objectStore("cobject_cobjectblock");
                    var requestGet = cobjectStore.index('cobject_block_id');
                    var objectsThisBlock = new Array();
                    var singleKeyRange = IDBKeyRange.only(block_id);
                    var existBlock = false;
                    requestGet.openCursor(singleKeyRange).onsuccess = function(event) {
                        var cursor = event.target.result;
                        if (cursor) {
                            // Faz algo com o que encontrar
                            existBlock = true;
                            objectsThisBlock.push(cursor.value.cobject_id);
                            cursor.continue();
                        } else {
                            //Finalizou a Pesquisa
                            if (existBlock) {
                                callBack(objectsThisBlock);
                            } else {
                                console.log("Nenhum Cobject foi encontrado para este Bloco");
                            }

                        }

                    };
                    requestGet.onerror = function(event) {
                        // Tratar erro!
                        console.log("Não encontrou Cobjects para estes Bloco!");
                    }
                }
                DBsynapse.onblocked = function(event) {
                    // Se existe outra aba com a versão antiga
                    window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
                }
            }
        }

        //Armazenar a  performance
        this.addPerformance_actor = function(data) {
            var piece_id = data.piece_id;
            var actor_id = data.actor_id;
            var final_time = data.final_time;
            var interval_resolution = data.interval_resolution;
            var value = self.isset(data.value) ? data.value : null;
            var iscorrect = data.iscorrect;
            var group_id = self.isset(data.group_id) ? data.group_id : null;

            var data_performance_actor = {
                'piece_id': piece_id,
                'group_id': group_id,
                'actor_id': actor_id,
                'final_time': final_time,
                'interval_resolution': interval_resolution,
                'value': value,
                'iscorrect': iscorrect
            };

            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function(event) {
                console.log("Error: ");
                console.log(event);
                //alert("Você não habilitou minha web app para usar IndexedDB?!");
            }
            DBsynapse.onsuccess = function(event) {
                var db = event.target.result;
                db.onerror = function(event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    console.log("Database error: " + event.target.errorCode);
                }
                var Performance_actorObjectStore = db.transaction("performance_actor", "readwrite").objectStore("performance_actor");
                Performance_actorObjectStore.add(data_performance_actor);
                Performance_actorObjectStore.transaction.oncomplete = function(event) {
                    // console.log('Performance Salva !!!! ');
                }

            }
            DBsynapse.onblocked = function(event) {
                // Se existe outra aba com a versão antiga
                window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            }

        }

        //Adicionar ou Realiza UPDATE dos registros do estado atual deste actor no block
        this.NewORUpdateUserState = function(data_state_actor) {
            var render_mode = data_state_actor.render_mode;
            var actor_id = data_state_actor.actor_id;

            //Escolhe a pesquisa por Ator
            if (self.isset(actor_id)) {
                window.indexedDB = self.verifyIDBrownser();
                DBsynapse = window.indexedDB.open(nameBD);
                DBsynapse.onerror = function(event) {
                    console.log("Error: ");
                    console.log(event);
                    // alert("Você não habilitou minha web app para usar IndexedDB?!");
                }
                DBsynapse.onsuccess = function(event) {
                    var db = event.target.result;
                    db.onerror = function(event) {
                            // Função genérica para tratar os erros de todos os requests desse banco!
                            console.log("Database error: " + event.target.errorCode);
                        }
                        //Tudo ok Então Busca O UserState
                    var stateActorStore = db.transaction("state_actor", "readwrite").objectStore("state_actor");
                    var requestGet = stateActorStore.index('actor_id');
                    var user_state_id = null;
                    var singleKeyRange = IDBKeyRange.only(actor_id);
                    requestGet.openCursor(singleKeyRange).onsuccess = function(event) {
                        var cursor = event.target.result;
                        if (cursor) {
                            // Faz algo com o que encontrar
                            // If for modo Avaliação
                            var mayUpdate = false;
                            if (render_mode == 'evaluation' && cursor.value.render_mode == render_mode) {
                                var cobject_block_id = data_state_actor.cobject_block_id;
                                var evaluation_selected_level = data_state_actor.evaluation_selected_level;
                                //Verificar se possui o mesmo bloco e nível
                                if (cursor.value.cobject_block_id == cobject_block_id &&
                                    cursor.value.evaluation_selected_level == evaluation_selected_level) {
                                    //Realiza Update
                                    mayUpdate = true;
                                }
                            }

                            if (mayUpdate) {
                                user_state_id = cursor.value.id;
                                //Set os novos dados do estado do actor corrente
                                if (self.isset(data_state_actor.last_piece_id)) {
                                    cursor.value.last_piece_id = data_state_actor.last_piece_id;
                                }

                                cursor.value.qtd_correct = data_state_actor.qtd_correct;
                                cursor.value.qtd_wrong = data_state_actor.qtd_wrong;

                                if (self.isset(data_state_actor.last_cobject_id)) {
                                    cursor.value.last_cobject_id = data_state_actor.last_cobject_id;
                                }

                                var request_update = cursor.update(cursor.value);
                                request_update.onsuccess = function(event) {
                                    console.log(' State Actor Atualizado !!!! ');
                                };
                                request_update.onerror = function(event) {
                                    console.log(' ERRO ao Atualizar State Actor !!!! ');
                                };
                            }

                            cursor.continue();
                        } else {
                            //Finalizou a Pesquisa, se não existir um estado corrent, o parms=null
                            var update = self.isset(user_state_id);
                            //Cria um novo Se NÃO houve update
                            if (!update) {
                                var state_actorObjectStore = db.transaction("state_actor", "readwrite").objectStore("state_actor");
                                state_actorObjectStore.add(data_state_actor);
                                state_actorObjectStore.transaction.oncomplete = function(event) {
                                    console.log(' NEW State Actor Salvo !!!! ');
                                }
                            }
                        }

                    };
                    requestGet.onerror = function(event) {
                        // Tratar erro!
                    }
                }
                DBsynapse.onblocked = function(event) {
                    // Se existe outra aba com a versão antiga
                    window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
                }
            }
        }

        //Recuperar o estado do usuário
        this.getUserState = function(actor_id, render_mode, userStateFilterInfo, callBack) {
            if (render_mode == 'evaluation') {
                var cobject_block_id = userStateFilterInfo['cobject_block_id'];
                var evaluation_selected_level = userStateFilterInfo['evaluation_selected_level'];
            }

            if (self.isset(actor_id) && self.isset(cobject_block_id) &&
                self.isset(evaluation_selected_level)) {
                var info_state = null;
                window.indexedDB = self.verifyIDBrownser();
                DBsynapse = window.indexedDB.open(nameBD);
                DBsynapse.onerror = function(event) {
                    console.log("Error: ");
                    console.log(event);
                    // alert("Você não habilitou minha web app para usar IndexedDB?!");
                }
                DBsynapse.onsuccess = function(event) {
                    var db = event.target.result;
                    db.onerror = function(event) {
                            // Função genérica para tratar os erros de todos os requests desse banco!
                            console.log("Database error: " + event.target.errorCode);
                        }
                        //Tudo ok Então Busca O Cobject
                    var state_actorStore = db.transaction("state_actor").objectStore("state_actor");
                    var requestGet = state_actorStore.index('actor_id');
                    var singleKeyRange = IDBKeyRange.only(actor_id);
                    requestGet.openCursor(singleKeyRange).onsuccess = function(event) {
                        var cursor = event.target.result;
                        if (cursor) {
                            if (render_mode == 'evaluation') {
                                // Para cada id do Actor encontrado, verificar se possui o
                                // modo do reder, cobject_block_id  e o nível selecionado
                                if (cursor.value.render_mode == render_mode &&
                                    cursor.value.cobject_block_id == cobject_block_id &&
                                    cursor.value.evaluation_selected_level == evaluation_selected_level) {
                                    //Encontrou o estado deste Actor para este Bloco
                                    info_state = {
                                        actor_id: cursor.value.actor_id,
                                        cobject_block_id: cursor.value.cobject_block_id,
                                        render_mode: cursor.value.render_mode,
                                        evaluation_selected_level: cursor.value.evaluation_selected_level,
                                        last_cobject_id: cursor.value.last_cobject_id,
                                        last_piece_id: cursor.value.last_piece_id,
                                        qtd_correct: cursor.value.qtd_correct,
                                        qtd_wrong: cursor.value.qtd_wrong,
                                        last_cobject_id: cursor.value.last_cobject_id
                                    };
                                }
                            }

                            // Se não encontrou, vai pro próximo
                            cursor.continue();
                        } else {
                            //Finalizou a Pesquisa
                            callBack(info_state);
                        }

                    };
                    requestGet.onerror = function(event) {
                        // Tratar erro!
                    }
                }
                DBsynapse.onblocked = function(event) {
                    // Se existe outra aba com a versão antiga
                    window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
                }
            }
        }


        //Recuperar o estado do usuário
        this.getUserState_ModeDiagnostic = function(actor_id, render_mode, userStateFilterInfo, callBack) {
            if (render_mode == 'proficiency') {
                var discipline_id = userStateFilterInfo['discipline_id'];
            }

            if (self.isset(actor_id) && self.isset(discipline_id)) {
                var info_state = null;
                window.indexedDB = self.verifyIDBrownser();
                DBsynapse = window.indexedDB.open(nameBD);
                DBsynapse.onerror = function(event) {
                    console.log("Error: ");
                    console.log(event);
                    // alert("Você não habilitou minha web app para usar IndexedDB?!");
                }
                DBsynapse.onsuccess = function(event) {
                    var db = event.target.result;
                    db.onerror = function(event) {
                            // Função genérica para tratar os erros de todos os requests desse banco!
                            console.log("Database error: " + event.target.errorCode);
                        }
                        //Tudo ok Então Busca O Cobject
                    var state_actorStore = db.transaction("state_actor").objectStore("state_actor");
                    var requestGet = state_actorStore.index('actor_id');
                    var singleKeyRange = IDBKeyRange.only(actor_id);
                    requestGet.openCursor(singleKeyRange).onsuccess = function(event) {
                        var cursor = event.target.result;
                        if (cursor) {
                            if (render_mode == 'proficiency') {
                                // Para cada id do Actor encontrado, verificar se possui o
                                // modo do render e discipline_id
                                if (cursor.value.render_mode == render_mode &&
                                    cursor.value.discipline_id == discipline_id) {
                                    //Encontrou o estado deste Actor + discipline + modo proficiency
                                    info_state = {
                                        actor_id: cursor.value.actor_id,
                                        discipline_id: cursor.value.discipline_id,
                                        render_mode: cursor.value.render_mode,
                                        last_cobject_id: cursor.value.last_cobject_id,
                                        last_piece_id: cursor.value.last_piece_id,
                                        qtd_correct: cursor.value.qtd_correct,
                                        qtd_wrong: cursor.value.qtd_wrong,
                                    };
                                }
                            }

                            // Se não encontrou, vai pro próximo
                            cursor.continue();
                        } else {
                            //Finalizou a Pesquisa
                            callBack(info_state);
                        }

                    };
                    requestGet.onerror = function(event) {
                        // Tratar erro!
                    }
                }
                DBsynapse.onblocked = function(event) {
                    // Se existe outra aba com a versão antiga
                    window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
                }
            }
        }



        function useDatabase(db) {
            // Esteja certo de que adicionou um evento para notificar se a página muda a versão
            // Devemos fechar o banco. Isso permite à outra página ser atualizada
            db.onversionchange = function(event) {
                db.close();
                alert("Uma nova versão desta web app está pronta. Atualiza, por favor!");
            }
        }

        this.getBlockByDiscipline = function(discipline_id, callBack) {
            if (self.isset(discipline_id)) {
                window.indexedDB = self.verifyIDBrownser();
                DBsynapse = window.indexedDB.open(nameBD);
                DBsynapse.onerror = function(event) {
                    console.log("Error: ");
                    console.log(event);
                    // alert("Você não habilitou minha web app para usar IndexedDB?!");
                }
                DBsynapse.onsuccess = function(event) {
                    var cobject_block_id = null;
                    var db = event.target.result;
                    db.onerror = function(event) {
                            // Função genérica para tratar os erros de todos os requests desse banco!
                            console.log("Database error: " + event.target.errorCode);
                        }
                        //Tudo ok Então Busca O CobjectBlock
                    var cobjectBlockStore = db.transaction("cobjectblock").objectStore("cobjectblock");
                    var requestGet = cobjectBlockStore.index('discipline_id');
                    var singleKeyRange = IDBKeyRange.only(discipline_id);
                    requestGet.openCursor(singleKeyRange).onsuccess = function(event) {
                        var cursor = event.target.result;
                        if (cursor) {
                            //Encontrou o Bloco que possui a disciplina escolhida
                            cobject_block_id = cursor.value.id;
                            callBack(cobject_block_id);
                        } else {
                            //Não encontrou
                            callBack(null);
                        }

                    };
                    requestGet.onerror = function(event) {
                        // Tratar erro!
                    }
                }
                DBsynapse.onblocked = function(event) {
                    // Se existe outra aba com a versão antiga
                    window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
                }
            }
        }



        //Registrar Turma
        this.addSchoolClassroomsOff = function(listSchools, idxSchool) {
            var school = listSchools[idxSchool];
            if (self.isset(school)) {
                var school_name = school['name'];
                var listClassrooms_name = school['classrooms'];

                //=========================
                window.indexedDB = self.verifyIDBrownser();
                DBsynapse = window.indexedDB.open(nameBD);
                DBsynapse.onerror = function(event) {
                    console.log("Error: ");
                    console.log(event);
                    // alert("Você não habilitou minha web app para usar IndexedDB?!");
                }
                DBsynapse.onsuccess = function(event) {
                    var db = event.target.result;

                    db.onerror = function(event) {
                        // Função genérica para tratar os erros de todos os requests desse banco!
                        console.log("Database error: " + event.target.error.message);
                    }
                    var maxID = 0;
                    var findSchoolsObjectStore = db.transaction("school", "readonly").objectStore("school");
                    findSchoolsObjectStore.openCursor().onsuccess = function(event) {
                        var cursor = event.target.result;
                        //Encontrar Maior ID
                        if (cursor) {
                            //Encontrou pelo menos um ID
                            var currentID = parseInt(cursor.value.id);
                            if (currentID > maxID) {
                                maxID = currentID;
                            }
                            cursor.continue();
                        } else {
                            //Finalizou
                            //Agora add a nova school com este ID
                            var dataSchool = {
                                createdOffline: true,
                                id: (++maxID).toString(),
                                name: school_name,
                            };

                            //Tudo ok Então Registra a Nova Escola
                            var schoolObjectStore = db.transaction("school", "readwrite").objectStore("school");
                            schoolObjectStore.add(dataSchool);
                            schoolObjectStore.transaction.oncomplete = function(event) {
                                console.log(' NEW School Salvo !!!! ');
                                //Após ter salvo uma nova Escola (Offline)
                                //Salvar cada ClassRoom para esta school_id
                                var idxClassroomStart = 0;
                                var infoSchools = {};
                                infoSchools['listSchools'] = listSchools;
                                infoSchools['idxSchool'] = idxSchool;

                                self.addClassroomsOff(maxID, listClassrooms_name, idxClassroomStart, infoSchools);

                            };
                        }
                    }

                }
                DBsynapse.onblocked = function(event) {
                    // Se existe outra aba com a versão antiga
                    window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
                }
            }
        }



        //Registrar Turma
        this.addClassroomsOff = function(school_id, listClassrooms_name, idxClassroom, infoSchools) {
            var classroom_name = listClassrooms_name[idxClassroom];

            if (self.isset(classroom_name)) {
                idxClassroom++;

                window.indexedDB = self.verifyIDBrownser();
                DBsynapse = window.indexedDB.open(nameBD);
                DBsynapse.onerror = function(event) {
                    console.log("Error: ");
                    console.log(event);
                    // alert("Você não habilitou minha web app para usar IndexedDB?!");
                }
                DBsynapse.onsuccess = function(event) {
                    var db = event.target.result;

                    db.onerror = function(event) {
                        // Função genérica para tratar os erros de todos os requests desse banco!
                        console.log("Database error: " + event.target.error.message);
                    }
                    var maxID = 0;
                    var findClassroomsObjectStore = db.transaction("unity", "readonly").objectStore("unity");
                    findClassroomsObjectStore.openCursor().onsuccess = function(event) {
                        var cursor = event.target.result;
                        //Encontrar Maior ID
                        if (cursor) {
                            //Encontrou pelo menos um ID
                            var currentID = parseInt(cursor.value.id);
                            if (currentID > maxID) {
                                maxID = currentID;
                            }
                            cursor.continue();
                        } else {
                            //Finalizou
                            //Agora add a nova classroom com este ID
                            var dataClassroom = {
                                createdOffline: true,
                                father_id: "-1",
                                id: (++maxID).toString(),
                                name: classroom_name,
                                organization_id: "-1",
                                school_id: school_id.toString()
                            };

                            //Tudo ok Então Registra a Nova Turma
                            var classroomObjectStore = db.transaction("unity", "readwrite").objectStore("unity");
                            classroomObjectStore.add(dataClassroom);
                            classroomObjectStore.transaction.oncomplete = function(event) {
                                console.log(' NEW Classroom Salvo !!!! ');
                                self.addClassroomsOff(school_id, listClassrooms_name, idxClassroom, infoSchools);
                            };
                        }
                    }

                }
                DBsynapse.onblocked = function(event) {
                    // Se existe outra aba com a versão antiga
                    window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
                }
            } else {
                //Salvou Todas as Turmas para a Escola Corrente.
                //Salva a próxima escola e suas turmas se existirem
                self.addSchoolClassroomsOff(infoSchools['listSchools'], ++infoSchools['idxSchool']);

            }
        }

        //Registrar Aluno
        this.addStudentOff = function(classroom_id, user_name) {
            if (self.isset(user_name)) {
                window.indexedDB = self.verifyIDBrownser();
                DBsynapse = window.indexedDB.open(nameBD);
                DBsynapse.onerror = function(event) {
                    console.log("Error: ");
                    console.log(event);
                    // alert("Você não habilitou minha web app para usar IndexedDB?!");
                }
                DBsynapse.onsuccess = function(event) {
                    var db = event.target.result;

                    db.onerror = function(event) {
                        // Função genérica para tratar os erros de todos os requests desse banco!
                        console.log("Database error: " + event.target.error.message);
                    }
                    var maxID = 0;
                    var findStudentsObjectStore = db.transaction("actor", "readonly").objectStore("actor");
                    findStudentsObjectStore.openCursor().onsuccess = function(event) {
                        var cursor = event.target.result;
                        //Encontrar Maior ID
                        if (cursor) {
                            //Encontrou pelo menos um ID
                            var currentID = parseInt(cursor.value.id);
                            if (currentID > maxID) {
                                maxID = currentID;
                            }
                            cursor.continue();
                        } else {
                            //Finalizou
                            //Agora add O estudante com este ID
                            var dataStudent = {
                                createdOffline: true,
                                id: (++maxID).toString(),
                                login: user_name,
                                name: user_name,
                                password: "123456",
                                personage_name: "Aluno",
                                unity_id: classroom_id,
                            };

                            //Tudo ok Então Registra o Novo Aluno
                            var studentObjectStore = db.transaction("actor", "readwrite").objectStore("actor");
                            studentObjectStore.add(dataStudent);
                            studentObjectStore.transaction.oncomplete = function(event) {
                                console.log(' NEW Actor Salvo !!!! ');
                                location.href = "select.html";
                            };
                        }
                    }

                }
                DBsynapse.onblocked = function(event) {
                    // Se existe outra aba com a versão antiga
                    window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
                }
            }
        }

        //Pesquisar Todas as escolas
        this.findAllSchools = function(callBack) {
            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function(event) {
                console.log("Error: ");
                console.log(event);
                //alert("Você não habilitou minha web app para usar IndexedDB?!");
            };
            DBsynapse.onsuccess = function(event) {
                var db = event.target.result;
                db.onerror = function(event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    console.log("Database error: " + event.target.errorCode);
                };

                var schools = new Array();

                var schoolObjectStore = db.transaction("school", "readonly").objectStore("school");
                schoolObjectStore.openCursor().onsuccess = function(event) {
                    var cursor = event.target.result;
                    if (cursor) {
                        schools.push({
                            id: cursor.value.id,
                            name: cursor.value.name
                        });

                        cursor.continue();
                    } else {
                        //Não existe mais registros!
                        //Passa as escolas pra a função de callBack
                        callBack(schools);
                    }
                };

            }
            DBsynapse.onblocked = function(event) {
                // Se existe outra aba com a versão antiga
                window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            }

        }

        //Pesquisar Todas as Turmas
        this.findAllClassrooms = function(callBack) {
            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function(event) {
                console.log("Error: ");
                console.log(event);
                //alert("Você não habilitou minha web app para usar IndexedDB?!");
            };
            DBsynapse.onsuccess = function(event) {
                var db = event.target.result;
                db.onerror = function(event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    console.log("Database error: " + event.target.errorCode);
                };

                var classrooms = new Array();

                var classroomObjectStore = db.transaction("unity", "readonly").objectStore("unity");
                classroomObjectStore.openCursor().onsuccess = function(event) {
                    var cursor = event.target.result;
                    if (cursor) {
                        classrooms.push({
                            id: cursor.value.id,
                            name: cursor.value.name,
                            school_id: cursor.value.school_id
                        });

                        cursor.continue();
                    } else {
                        //Não existe mais registros!
                        //Passa as classrooms pra a função de callBack
                        callBack(classrooms);
                    }
                };

            }
            DBsynapse.onblocked = function(event) {
                // Se existe outra aba com a versão antiga
                window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            }

        }


        //Pesquisar Todos os Cobjects, porém retorna somente informações importantes
        this.findAllMinCobjects = function(callBack) {
            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function(event) {
                console.log("Error: ");
                console.log(event);
                //alert("Você não habilitou minha web app para usar IndexedDB?!");
            };
            DBsynapse.onsuccess = function(event) {
                var db = event.target.result;
                db.onerror = function(event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    console.log("Database error: " + event.target.errorCode);
                };

                var cobjects = new Array();

                var cobjectObjectStore = db.transaction("cobject", "readonly").objectStore("cobject");
                cobjectObjectStore.openCursor().onsuccess = function(event) {
                    var cursor = event.target.result;
                    if (cursor) {
                        cobjects.push({
                            cobject_id: cursor.value.cobject_id,
                            goal: cursor.value.goal,
                            year: cursor.value.year
                        });

                        cursor.continue();
                    } else {
                        //Não existe mais registros!
                        //Passa os cobjects pra a função de callBack
                        callBack(cobjects);
                    }
                };

            }
            DBsynapse.onblocked = function(event) {
                // Se existe outra aba com a versão antiga
                window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            }

        }


        //Pesquisar Cobject específico
        this.findCobjectById = function(cobject_id, callBack) {

            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function(event) {
                console.log("Error: ");
                console.log(event);
                //alert("Você não habilitou minha web app para usar IndexedDB?!");
            };
            DBsynapse.onsuccess = function(event) {
                var db = event.target.result;
                db.onerror = function(event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    console.log("Database error: " + event.target.errorCode);
                };

                var cobject = null;
                var cobjectObjectStore = db.transaction("cobject", "readonly").objectStore("cobject");

                //Selecionar somente o cobject que possui o cobject_id especificado
                cobjectObjectStore.get(cobject_id).onsuccess = function(event) {
                    var result = event.target.result;
                    if (result) {
                        //Encontrou o cobject
                        cobject = result;
                        callBack(cobject);
                    } else {
                        //Não encontrou o cobject
                        callBack(cobject);
                    }

                }

            }
            DBsynapse.onblocked = function(event) {
                // Se existe outra aba com a versão antiga
                window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            }
        }


        //Pesquisar Turma específica
        this.findClassroomById = function(classroom_id, callBack) {

            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function(event) {
                console.log("Error: ");
                console.log(event);
                //alert("Você não habilitou minha web app para usar IndexedDB?!");
            };
            DBsynapse.onsuccess = function(event) {
                var db = event.target.result;
                db.onerror = function(event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    console.log("Database error: " + event.target.errorCode);
                };

                var classroom = null;
                var classroomObjectStore = db.transaction("unity", "readonly").objectStore("unity");

                //Selecionar somente a turma que possui o classroom_id especificado
                classroomObjectStore.get(classroom_id).onsuccess = function(event) {
                    var result = event.target.result;
                    if (result) {
                        //Encontrou a classroom
                        classroom = result;
                        callBack(classroom);
                    } else {
                        //Não encontrou a class room
                        callBack(classroom);
                    }

                }

            }
            DBsynapse.onblocked = function(event) {
                // Se existe outra aba com a versão antiga
                window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            }
        }



        //Pesquisar todas as classes de uma determinada escola
        this.findClassroomBySchool = function(school_id, callBack) {

            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function(event) {
                console.log("Error: ");
                console.log(event);
                //alert("Você não habilitou minha web app para usar IndexedDB?!");
            };
            DBsynapse.onsuccess = function(event) {
                var db = event.target.result;
                db.onerror = function(event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    console.log("Database error: " + event.target.errorCode);
                };

                var classrooms = new Array();
                var classroomObjectStore = db.transaction("unity", "readonly").objectStore("unity");

                //Selecionar somente as turmas pra a escola específica
                var requestGet = classroomObjectStore.index('school_id');
                var singleKeyRange = IDBKeyRange.only(school_id);

                requestGet.openCursor(singleKeyRange).onsuccess = function(event) {
                    var cursor = event.target.result;
                    if (cursor) {
                        classrooms.push({
                            id: cursor.value.id,
                            name: cursor.value.name
                        });

                        cursor.continue();
                    } else {
                        //Não existe mais registros!
                        //Passa as turmas pra a função de callBack
                        callBack(classrooms);
                    }
                };

            }
            DBsynapse.onblocked = function(event) {
                // Se existe outra aba com a versão antiga
                window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            }
        }




        //Pesquisar todas as classes de uma determinada escola
        this.findStudentByClassroom = function(classroom_id, callBack) {

            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function(event) {
                console.log("Error: ");
                console.log(event);
                //alert("Você não habilitou minha web app para usar IndexedDB?!");
            };
            DBsynapse.onsuccess = function(event) {
                var db = event.target.result;
                db.onerror = function(event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    console.log("Database error: " + event.target.errorCode);
                };

                var students = new Array();
                var studentObjectStore = db.transaction("actor", "readonly").objectStore("actor");

                //Selecionar somente os alunos pra a turma específica
                var requestGet = studentObjectStore.index('unity_id');
                var singleKeyRange = IDBKeyRange.only(classroom_id);

                requestGet.openCursor(singleKeyRange).onsuccess = function(event) {
                    var cursor = event.target.result;
                    if (cursor) {
                        students.push({
                            id: cursor.value.id,
                            name: cursor.value.name
                        });

                        cursor.continue();
                    } else {
                        //Não existe mais registros!
                        //Passa os estudantes pra a função de callBack
                        callBack(students);
                    }
                };

            }
            DBsynapse.onblocked = function(event) {
                // Se existe outra aba com a versão antiga
                window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            }
        }




        this.isset = function(variable) {
            return (typeof variable !== 'undefined' && variable !== null);
        }

    }

}
