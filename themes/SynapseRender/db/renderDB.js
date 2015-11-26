// // - - - - - - - - - -  //
// CRIAR BANCO DE DADOS //
// - - - - - - - - - -  //

//Verificar se NÃO é o RenderOnline
if (sessionStorage.getItem("isOnline") === null ||
        sessionStorage.getItem("isOnline") == 'false') {

    this.DB = function () {
        self = this;
        nameBD = "synapseDB";
        DBversion = 1;
        DBsynapse = null;

        db = null;


        dataImportFunction = null;

        this.verifyIDBrownser = function () {
            // Na linha abaixo, você deve incluir os prefixos do navegador que você vai testar.
            window.indexedDB = window.indexedDB || window.mozIndexedDB || window.webkitIndexedDB || window.msIndexedDB;
            // Não use "var indexedDB = ..." se você não está numa function.
            // Posteriormente, você pode precisar de referências de algum objeto window.IDB*:
            window.IDBTransaction = window.IDBTransaction || window.webkitIDBTransaction || window.msIDBTransaction;
            window.IDBKeyRange = window.IDBKeyRange || window.webkitIDBKeyRange || window.msIDBKeyRange;
            // (Mozilla nunca usou prefixo nesses objetos, então não precisamos window.mozIDB*)
            return window.indexedDB;
        }

        this.openDBuild = function (alterSchema, dataImportFunction, dataJsonLin, dataJsonMat) {

            self.dataImportFunction = dataImportFunction;
            self.dataJsonLin = dataJsonLin;
            self.dataJsonMat = dataJsonMat;

            window.indexedDB = self.verifyIDBrownser();
            if (!window.indexedDB) {
                console.log("Seu navegador não suporta uma versão estável do IndexedDB. Alguns recursos não estarão disponíveis.");
            }
            //Verificar se precisa mudar o setVersion para alterar o schema do BD
            var alterSchema = (this.isset(alterSchema) && alterSchema);

            //Se ainda não atualizou o DBversion, então abre o banco na sua versão atual
            var synapseBD;
            synapseBD = window.indexedDB.open(nameBD, 2);

            synapseBD.onerror = function (event) {
                console.log("Error: ");
                console.log(event);
                //alert("Você não habilitou minha web app para usar IndexedDB?!");
            }

            synapseBD.onsuccess = function (event) {
                var db = event.target.result;
                db.onerror = function (event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    alert("Database error: " + event.target.errorCode);
                };

                db.onclose = function (event) {
                    console.log(event);
                };

                db.onversionchange = function (event) {
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

            synapseBD.onversionchange = function (event) {
                console.log(event);
            };

            synapseBD.onblocked = function (event) {
                // Se existe outra aba com a versão antiga
                console.log("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            };

        }



        var openBuild = function () {

            DBsynapse = window.indexedDB.open(nameBD, DBversion);

            DBsynapse.onversionchange = function (event) {
                //STOP HERE
                console.log(event);
            };

            DBsynapse.onerror = function (event) {
                console.log("Error: ");
                console.log(event);
                // alert("Você não habilitou minha web app para usar IndexedDB?!");
            };
            DBsynapse.onsuccess = function (event) {
                var db = event.target.result;
                db.onerror = function (event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    alert("Database error: " + event.target.errorCode);
                };
            }

            DBsynapse.onblocked = function (event) {
                // Se existe outra aba com a versão antiga
                console.log("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            };

            //Se for uma nova versão é criado o novo schemma do banco
            self.buildAllSchema();

        }


        this.buildAllSchema = function () {
            //Criar Schemas das tabelas

            DBsynapse.onupgradeneeded = function (event) {
                var db = event.target.result;

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

                //Criar Schema para os scripts(roteiros), contents e goals. E outro schema para relacionar
                //os goals em seu content e os contents no seu respectivo script(Roteiro). 

                /*  act_goal {
                 `id`,
                 `name`,
                 `degree_id`,
                 `discipline_id`
                 }*/

                // cria um objectStore do act_goal
                var act_goalStore = db.createObjectStore("act_goal", {
                    keyPath: "id"
                });
                //Criar Index para discipline_id
                act_goalStore.createIndex("discipline_id", "discipline_id", {
                    unique: false
                });

                /* act_content {
                 `id`,
                 `content_parent`,
                 `discipline_id`,
                 `description`
                 } */

                // cria um objectStore do act_content
                var act_contentStore = db.createObjectStore("act_content", {
                    keyPath: "id"
                });
                //Criar Index para discipline_id
                act_contentStore.createIndex("discipline_id", "discipline_id", {
                    unique: false
                });


                /* act_goal_content{
                 `id`,
                 `goal_id`,
                 `content_id`
                 }  */

                // cria um objectStore do act_goal_content
                var act_goal_contentStore = db.createObjectStore("act_goal_content", {
                    keyPath: "id"
                });
                //Criar Index para goal_id
                act_goal_contentStore.createIndex("goal_id", "goal_id", {
                    unique: false
                });
                //Criar Index para content_id
                act_goal_contentStore.createIndex("content_id", "content_id", {
                    unique: false
                });


                /* act_script {
                 `id`,
                 `discipline_id`,
                 `performance_index`,
                 `father_content`
                 }
                 */

                // cria um objectStore do act_script
                var act_scriptStore = db.createObjectStore("act_script", {
                    keyPath: "id"
                });
                //Criar Index para discipline_id
                act_scriptStore.createIndex("discipline_id", "discipline_id", {
                    unique: false
                });


                /* act_script_content {
                 `id`,
                 `content_id`,
                 `script_id`,
                 `status`
                 } */

                // cria um objectStore do act_script_content
                var act_script_contentStore = db.createObjectStore("act_script_content", {
                    keyPath: "id"
                });
                //Criar Index para content_id
                act_script_contentStore.createIndex("content_id", "content_id", {
                    unique: false
                });
                //Criar Index para script_id
                act_script_contentStore.createIndex("script_id", "script_id", {
                    unique: false
                });

                //==============================================================


                // cria um objectStore do cobject
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
                //Faltam
                /* piece_id
                 piece_element_id
                 actor_id
                 start_time
                 final_time
                 value
                 iscorrect
                 group_id  */
                //===============================================

                //Criar o ObjectStore específico do RENDER
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

                // falta o {mode => [activity, proficiency, train] }



                // Usando transação oncomplete para afirmar que a criação do objectStore 
                // é terminada antes de adicionar algum dado nele.
                schoolStore.transaction.oncomplete = function (event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat);
                    console.log('Criou os Schemas');
                }

                unityStore.transaction.oncomplete = function (event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat);
                    console.log('Criou os Schemas');
                }

                actorStore.transaction.oncomplete = function (event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat);
                    console.log('Criou os Schemas');
                }
                disciplineStore.transaction.oncomplete = function (event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat);
                    console.log('Criou os Schemas');
                }
                cobjectblockStore.transaction.oncomplete = function (event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat);
                    console.log('Criou os Schemas');
                }
                cobject_cobjectblockStore.transaction.oncomplete = function (event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat);
                    console.log('Criou os Schemas');
                }
                cobjectStore.transaction.oncomplete = function (event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat);
                    console.log('Criou os Schemas');
                }
                performance_actorStore.transaction.oncomplete = function (event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat);
                    console.log('Criou os Schemas');
                }
                state_actorStore.transaction.oncomplete = function (event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat);
                    console.log('Criou os Schemas');
                }


                act_goalStore.transaction.oncomplete = function (event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat);
                    console.log('Criou os Schemas');
                }

                act_contentStore.transaction.oncomplete = function (event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat);
                    console.log('Criou os Schemas');
                }

                act_goal_contentStore.transaction.oncomplete = function (event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat);
                    console.log('Criou os Schemas');
                }

                act_scriptStore.transaction.oncomplete = function (event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat);
                    console.log('Criou os Schemas');
                }

                act_script_contentStore.transaction.oncomplete = function (event) {
                    //Se for o último dos 9 então contruiu todos os schemas
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat);
                    console.log('Criou os Schemas');
                }

                stop_point_diagnosticStore.transaction.oncomplete = function (event) {
                    db.close();
                    self.dataImportFunction(self.dataJsonLin, self.dataJsonMat);
                    console.log('Criou os Schemas');
                }



                useDatabase(db);


            }
        }



        // - - - - - - - - - -  //
        // IMPORT PARA BANCO DE DADOS //
        // - - - - - - - - - -  //

        this.importAllDataRender = function (schools, unitys, actors, disciplines, cobjectblock
                , cobject_cobjectblocks, cobjects) {
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
                    discipline_id: current_goal_discipline_id
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


            console.log(act_goals);
            console.log(act_contents);
            console.log(act_scripts);

            console.log(act_goal_contents);
            console.log(act_script_contents);



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



            self.verifyExistBlock(options, function (options, schoolsClassrooms, existBlock) {
                //Call Back

                var schools = options.schools;
                var unitys = options.unitys;
                var actors = options.actors;
                var disciplines = options.disciplines;
                var cobjectblock = options.cobjectblock;
                var cobject_cobjectblocks = options.cobject_cobjectblocks;
                var cobjects = options.cobjects;

                var act_goals = options.act_goals;
                var act_contents = options.act_contents;
                var act_scripts = options.act_scripts;
                var act_goal_contents = options.act_goal_contents;
                var act_script_contents = options.act_script_contents;

                if (!existBlock) {
                    //=================================================
                    //Escola, Unidade e Usuário
                    var data_school = schools;
                    var data_unity = unitys;
                    var data_actor = actors;
                    //======================================
                    //Blocos de Atividades para cada Disciplina
                    var data_discipline = disciplines;
                    //==================================================
                }

                var data_cobjectBlock = cobjectblock;
                var data_cobject_cobjectBlock = cobject_cobjectblocks;
                //Cobjets
                var data_cobject = cobjects;

                //Escola e Turmas Offlines
                var data_schoolsClassrooms = schoolsClassrooms;

                window.indexedDB = self.verifyIDBrownser();
                DBsynapse = window.indexedDB.open(nameBD);
                DBsynapse.onerror = function (event) {
                    console.log("Error: ");
                    console.log(event);
                    //alert("Você não habilitou minha web app para usar IndexedDB?!");
                };
                DBsynapse.onsuccess = function (event) {
                    var db = event.target.result;
                    db.onerror = function (event) {
                        // Função genérica para tratar os erros de todos os requests desse banco!
                        console.log("Database error: " + event.target.error.message);
                    };

                    if (!existBlock) {
                        //==================================================
                        //Importar as schools
                        self.importSchool(db, data_school);

                        //Importar as unitys
                        self.importUnity(db, data_unity);

                        //Importar os atores
                        self.importActor(db, data_actor);

                        //Importar as disciplines
                        self.importDiscipline(db, data_discipline);

                        //Importar Escolas e Turmas Offline
                        self.importSchoolsClassroomsOff(db, data_schoolsClassrooms);



                        //Importar as act_goals
                        self.importActGoals(db, act_goals);

                        //Importar as act_contents
                        self.importActContents(db, act_contents);

                        //Importar as act_scripts
                        self.importActScripts(db, act_scripts);

                        //Importar as act_goal_contents
                        self.importActGoalContent(db, act_goal_contents);

                        //Importar as act_script_contents
                        self.importActScriptContent(db, act_script_contents);


                        //==================================================
                    }

                    //Importar os cobjectblocks
                    self.importCobjectblock(db, data_cobjectBlock);

                    //Importar os cobject_cobjectblocks
                    self.importCobject_cobjectblock(db, data_cobject_cobjectBlock);

                    // Salvar o Objeto JSON. NÃO PRECISA CRIAR VARIAS TABELA E GERAR UM JSON. Custa processamento.
                    //Importar os cobjects
                    self.importCobject(db, data_cobject);

                    //Importar os performance_actors
                    // self.importPerformance_actor(db,data_performance_actor); 

                    //Fecha o DB
                    db.close();

                }
                DBsynapse.onblocked = function (event) {
                    // Se existe outra aba com a versão antiga
                    window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
                }




            });





        }

        //////////////////////
        //Métodos de Import 
        /////////////////////

        //Importar as schools
        this.importSchool = function (db, data_school) {
            var SchoolObjectStore = db.transaction("school", "readwrite").objectStore("school");
            for (var i in data_school) {
                SchoolObjectStore.add(data_school[i]);
            }
            SchoolObjectStore.transaction.oncomplete = function (event) {
                db.close();
                console.log("Schools IMPORTED!");
            };
        };

        //Importar as unitys
        this.importUnity = function (db, data_unity) {
            var UnityObjectStore = db.transaction("unity", "readwrite").objectStore("unity");
            for (var i in data_unity) {
                UnityObjectStore.add(data_unity[i]);
            }
            UnityObjectStore.transaction.oncomplete = function (event) {
                db.close();
                console.log("Unitys IMPORTED!");
            }
        }

        //Importar os atores
        this.importActor = function (db, data_actor) {
            var ActorObjectStore = db.transaction("actor", "readwrite").objectStore("actor");
            for (var i in data_actor) {
                ActorObjectStore.add(data_actor[i]);
            }
            ActorObjectStore.transaction.oncomplete = function (event) {
                db.close();
                console.log("Actors IMPORTED!");
            }
        }

        //Importar as disciplines
        this.importDiscipline = function (db, data_discipline) {
            var DisciplineObjectStore = db.transaction("discipline", "readwrite").objectStore("discipline");
            for (var i in data_discipline) {
                DisciplineObjectStore.add(data_discipline[i]);
            }
            DisciplineObjectStore.transaction.oncomplete = function (event) {
                db.close();
                console.log("Disciplines IMPORTED!");
            }
        }

        //Importar os cobjectblocks
        this.importCobjectblock = function (db, data_cobjectBlock) {
            var CobjectblockObjectStore = db.transaction("cobjectblock", "readwrite").objectStore("cobjectblock");
            for (var i in data_cobjectBlock) {
                CobjectblockObjectStore.add(data_cobjectBlock[i]);
            }
            CobjectblockObjectStore.transaction.oncomplete = function (event) {
                db.close();
                console.log("Cobjectblocks IMPORTED!");
            }
        }

        //Importar os cobject_cobjectblocks
        this.importCobject_cobjectblock = function (db, data_cobject_cobjectBlock) {
            var Cobject_cobjectBlockObjectStore = db.transaction("cobject_cobjectblock", "readwrite").objectStore("cobject_cobjectblock");

            for (var i in data_cobject_cobjectBlock) {
                data_cobject_cobjectBlock[i].id = eval(data_cobject_cobjectBlock[i].id);
                Cobject_cobjectBlockObjectStore.add(data_cobject_cobjectBlock[i]);
            }
            Cobject_cobjectBlockObjectStore.transaction.oncomplete = function (event) {
                db.close();
                console.log("Cobject_cobjectblocks IMPORTED!");
            }
        }

        // Salvar o Objeto JSON. NÃO PRECISA CRIAR VARIAS TABELA E GERAR UM JSON. Custa processamento.
        //Importar os cobjects
        this.importCobject = function (db, data_cobject) {
            var CobjectObjectStore = db.transaction("cobject", "readwrite").objectStore("cobject");
            for (var i in data_cobject) {
                var currentCobject = data_cobject[i];
                CobjectObjectStore.add(currentCobject);
            }
            CobjectObjectStore.transaction.oncomplete = function (event) {
                db.close();
                window.alert("Cobjects IMPORTED!");
            }
        }

        //Importar os performance_actors
        this.importPerformance_actor = function (db, data_performance_actor) {
            var Performance_actorObjectStore = db.transaction("performance_actor", "readwrite").objectStore("performance_actor");
            for (var i in data_performance_actor) {
                Performance_actorObjectStore.add(data_performance_actor[i]);
            }
            Performance_actorObjectStore.transaction.oncomplete = function (event) {
                db.close();
                console.log("Performance_actors IMPORTED!");
            }
        }

        //Importar os Escolas OffLine, se houver
        this.importSchoolsClassroomsOff = function (db, schoolClassrooms) {
            //schoolsClassrooms['schools'][0]['classrooms']
            var listSchools = schoolClassrooms['schools'];
            var idxSchool = 0;
            self.addSchoolClassroomsOff(listSchools, idxSchool);
        }


        ;

        ;

        ;

        ;

        ;

        //Importar as act_goals
        this.importActGoals = function (db, act_goals) {
            var ActGoalObjectStore = db.transaction("act_goal", "readwrite").objectStore("act_goal");
            for (var i in act_goals) {
                ActGoalObjectStore.add(act_goals[i]);
            }
            ActGoalObjectStore.transaction.oncomplete = function (event) {
                db.close();
                console.log("ActGoals IMPORTED!");
            }
        }

        //Importar as act_contents
        this.importActContents = function (db, act_contents) {
            var ActContentObjectStore = db.transaction("act_content", "readwrite").objectStore("act_content");
            for (var i in act_contents) {
                ActContentObjectStore.add(act_contents[i]);
            }
            ActContentObjectStore.transaction.oncomplete = function (event) {
                db.close();
                console.log("ActContents IMPORTED!");
            }
        }

        //Importar as act_scripts
        this.importActScripts = function (db, act_scripts) {
            var ActScriptObjectStore = db.transaction("act_script", "readwrite").objectStore("act_script");
            for (var i in act_scripts) {
                ActScriptObjectStore.add(act_scripts[i]);
            }
            ActScriptObjectStore.transaction.oncomplete = function (event) {
                db.close();
                console.log("ActScript IMPORTED!");
            }
        }

        //Importar as act_goal_contents
        this.importActGoalContent = function (db, act_goal_contents) {
            var ActGoalContentObjectStore = db.transaction("act_goal_content", "readwrite").objectStore("act_goal_content");
            for (var i in act_goal_contents) {
                ActGoalContentObjectStore.add(act_goal_contents[i]);
            }
            ActGoalContentObjectStore.transaction.oncomplete = function (event) {
                db.close();
                console.log("ActGoalContent IMPORTED!");
            }
        }

        //Importar as act_script_contents
        this.importActScriptContent = function (db, act_script_contents) {
            var ActScriptContentObjectStore = db.transaction("act_script_content", "readwrite").objectStore("act_script_content");
            for (var i in act_script_contents) {
                ActScriptContentObjectStore.add(act_script_contents[i]);
            }
            ActScriptContentObjectStore.transaction.oncomplete = function (event) {
                db.close();
                console.log("ActScriptContent IMPORTED!");
            }
        }


        // - - - - - - - - - -  //
        // EXPORTE PARA BANCO DE DADOS //
        // - - - - - - - - - -  //

        //Export os performances_actors
        this.exportPerformance_actor = function () {
            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function (event) {
                console.log("Error: ");
                console.log(event);
                //alert("Você não habilitou minha web app para usar IndexedDB?!");
            };
            DBsynapse.onsuccess = function (event) {
                var db = event.target.result;
                db.onerror = function (event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    console.log("Database error: " + event.target.errorCode);
                };

                var performances = new Array();

                var Performance_actorObjectStore = db.transaction("performance_actor", "readonly").objectStore("performance_actor");
                Performance_actorObjectStore.openCursor().onsuccess = function (event) {
                    var cursor = event.target.result;
                    if (cursor) {
                        var currentPerformance = '{"actor_id":"' + cursor.value.actor_id;
                        currentPerformance += '", "final_time":"' + cursor.value.final_time;
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

                        //Realizar download da String
                        var pom = document.createElement('a');
                        var current_date = new Date();
                        pom.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(jsonExport));
                        pom.setAttribute('download', 'perfomances(' + current_date.getDate() + '-' + current_date.getMonth()
                                + '-' + current_date.getFullYear() + '_' + current_date.getTime() + ')');
                        pom.click();

                    }
                };

            }
            DBsynapse.onblocked = function (event) {
                // Se existe outra aba com a versão antiga
                window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            }

        }


        //Pesquisas No Banco        
        this.login = function (login, password, callBack) {
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
                    DBsynapse.onerror = function (event) {
                        console.log("Error: ");
                        console.log(event);
                        // alert("Você não habilitou minha web app para usar IndexedDB?!");
                    }
                    DBsynapse.onsuccess = function (event) {
                        var db = event.target.result;
                        db.onerror = function (event) {
                            // Função genérica para tratar os erros de todos os requests desse banco!
                            console.log("Database error: " + event.target.errorCode);
                        }
                        //Tudo ok Então Busca O Actor
                        var ActorObjectStore = db.transaction("actor").objectStore("actor");
                        var requestGet = ActorObjectStore.index("login").get(login);
                        requestGet.onerror = function (event) {
                            // Tratar erro!
                        }
                        requestGet.onsuccess = function (event) {
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
                    DBsynapse.onblocked = function (event) {
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

        //===================
        this.getCobject = function (cobject_id, callBack) {
            if (self.isset(cobject_id)) {
                window.indexedDB = self.verifyIDBrownser();
                DBsynapse = window.indexedDB.open(nameBD);
                DBsynapse.onerror = function (event) {
                    console.log("Error: ");
                    console.log(event);
                    //alert("Você não habilitou minha web app para usar IndexedDB?!");
                }
                DBsynapse.onsuccess = function (event) {
                    var db = event.target.result;
                    db.onerror = function (event) {
                        // Função genérica para tratar os erros de todos os requests desse banco!
                        window.alert("Database error: " + event.target.errorCode);
                    }
                    //Tudo ok Então Busca O Cobject
                    var cobjectStore = db.transaction("cobject").objectStore("cobject");
                    var requestGet = cobjectStore.get(cobject_id);
                    requestGet.onerror = function (event) {
                        // Tratar erro!
                    }
                    requestGet.onsuccess = function (event) {
                        var json_cobject = requestGet.result;
                        callBack(json_cobject);
                    }

                }
                DBsynapse.onblocked = function (event) {
                    // Se existe outra aba com a versão antiga
                    window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
                }
            }
        }

        //===================
        this.getCobjectsFromBlock = function (block_id, callBack) {
            if (self.isset(block_id)) {
                window.indexedDB = self.verifyIDBrownser();
                DBsynapse = window.indexedDB.open(nameBD);
                DBsynapse.onerror = function (event) {
                    console.log("Error: ");
                    console.log(event);
                    // alert("Você não habilitou minha web app para usar IndexedDB?!");
                }
                DBsynapse.onsuccess = function (event) {
                    var db = event.target.result;
                    db.onerror = function (event) {
                        // Função genérica para tratar os erros de todos os requests desse banco!
                        window.alert("Database error: " + event.target.errorCode);
                    }
                    //Tudo ok Então Busca O Cobject
                    var cobjectStore = db.transaction("cobject_cobjectblock").objectStore("cobject_cobjectblock");
                    var requestGet = cobjectStore.index('cobject_block_id');
                    var objectsThisBlock = new Array();
                    var singleKeyRange = IDBKeyRange.only(block_id);
                    var existBlock = false;
                    requestGet.openCursor(singleKeyRange).onsuccess = function (event) {
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
                    requestGet.onerror = function (event) {
                        // Tratar erro!
                        console.log("Não encontrou Cobjects para estes Bloco!");
                    }
                }
                DBsynapse.onblocked = function (event) {
                    // Se existe outra aba com a versão antiga
                    window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
                }
            }
        }

        //Armazenar a  performance
        this.addPerformance_actor = function (data) {
            var piece_id = data.piece_id;
            var actor_id = data.actor_id;
            var final_time = data.final_time;
            var value = self.isset(data.value) ? data.value : null;
            var iscorrect = data.iscorrect;
            var group_id = self.isset(data.group_id) ? data.group_id : null;

            var data_performance_actor = {
                'piece_id': piece_id,
                'group_id': group_id,
                'actor_id': actor_id,
                'final_time': final_time,
                'value': value,
                'iscorrect': iscorrect
            };

            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function (event) {
                console.log("Error: ");
                console.log(event);
                //alert("Você não habilitou minha web app para usar IndexedDB?!");
            }
            DBsynapse.onsuccess = function (event) {
                var db = event.target.result;
                db.onerror = function (event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    console.log("Database error: " + event.target.errorCode);
                }
                var Performance_actorObjectStore = db.transaction("performance_actor", "readwrite").objectStore("performance_actor");
                Performance_actorObjectStore.add(data_performance_actor);
                Performance_actorObjectStore.transaction.oncomplete = function (event) {
                    // console.log('Performance Salva !!!! ');
                }

            }
            DBsynapse.onblocked = function (event) {
                // Se existe outra aba com a versão antiga
                window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            }

        }

        //Adicionar ou Realiza UPDATE dos registros do estado atual deste actor no block
        this.NewORUpdateUserState = function (data_state_actor) {
            var render_mode = data_state_actor.render_mode;
            var actor_id = data_state_actor.actor_id;

            //Escolhe a pesquisa por Ator
            if (self.isset(actor_id)) {
                window.indexedDB = self.verifyIDBrownser();
                DBsynapse = window.indexedDB.open(nameBD);
                DBsynapse.onerror = function (event) {
                    console.log("Error: ");
                    console.log(event);
                    // alert("Você não habilitou minha web app para usar IndexedDB?!");
                }
                DBsynapse.onsuccess = function (event) {
                    var db = event.target.result;
                    db.onerror = function (event) {
                        // Função genérica para tratar os erros de todos os requests desse banco!
                        console.log("Database error: " + event.target.errorCode);
                    }
                    //Tudo ok Então Busca O UserState
                    var stateActorStore = db.transaction("state_actor", "readwrite").objectStore("state_actor");
                    var requestGet = stateActorStore.index('actor_id');
                    var user_state_id = null;
                    var singleKeyRange = IDBKeyRange.only(actor_id);
                    requestGet.openCursor(singleKeyRange).onsuccess = function (event) {
                        var cursor = event.target.result;
                        if (cursor) {
                            // Faz algo com o que encontrar
                            // If for modo Avaliação
                            var mayUpdate = false;
                            if (render_mode == 'evaluation' && cursor.value.render_mode == render_mode ) {
                                var cobject_block_id = data_state_actor.cobject_block_id;
                                var evaluation_selected_level = data_state_actor.evaluation_selected_level;
                                //Verificar se possui o mesmo bloco e nível
                                if (cursor.value.cobject_block_id == cobject_block_id
                                        && cursor.value.evaluation_selected_level == evaluation_selected_level) {
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
                                request_update.onsuccess = function (event) {
                                    console.log(' State Actor Atualizado !!!! ');
                                };
                                request_update.onerror = function (event) {
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
                                state_actorObjectStore.transaction.oncomplete = function (event) {
                                    console.log(' NEW State Actor Salvo !!!! ');
                                }
                            }
                        }

                    };
                    requestGet.onerror = function (event) {
                        // Tratar erro!
                    }
                }
                DBsynapse.onblocked = function (event) {
                    // Se existe outra aba com a versão antiga
                    window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
                }
            }
        }

        //Recuperar o estado do usuário
        this.getUserState = function (actor_id, render_mode, userStateFilterInfo, callBack) {
            if (render_mode == 'evaluation') {
                var cobject_block_id = userStateFilterInfo['cobject_block_id'];
                var evaluation_selected_level = userStateFilterInfo['evaluation_selected_level'];
            }

            if (self.isset(actor_id) && self.isset(cobject_block_id)
                    && self.isset(evaluation_selected_level)) {
                var info_state = null;
                window.indexedDB = self.verifyIDBrownser();
                DBsynapse = window.indexedDB.open(nameBD);
                DBsynapse.onerror = function (event) {
                    console.log("Error: ");
                    console.log(event);
                    // alert("Você não habilitou minha web app para usar IndexedDB?!");
                }
                DBsynapse.onsuccess = function (event) {
                    var db = event.target.result;
                    db.onerror = function (event) {
                        // Função genérica para tratar os erros de todos os requests desse banco!
                        console.log("Database error: " + event.target.errorCode);
                    }
                    //Tudo ok Então Busca O Cobject
                    var state_actorStore = db.transaction("state_actor").objectStore("state_actor");
                    var requestGet = state_actorStore.index('actor_id');
                    var singleKeyRange = IDBKeyRange.only(actor_id);
                    requestGet.openCursor(singleKeyRange).onsuccess = function (event) {
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
                    requestGet.onerror = function (event) {
                        // Tratar erro!
                    }
                }
                DBsynapse.onblocked = function (event) {
                    // Se existe outra aba com a versão antiga
                    window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
                }
            }
        }

        /*
         this.getAllClass = function (callBack, callBackEvent) {
         window.indexedDB = self.verifyIDBrownser();
         DBsynapse = window.indexedDB.open(nameBD);
         DBsynapse.onerror = function (event) {
         console.log("Error: ");
         console.log(event);
         //alert("Você não habilitou minha web app para usar IndexedDB?!");
         }
         DBsynapse.onsuccess = function (event) {
         var db = event.target.result;
         db.onerror = function (event) {
         // Função genérica para tratar os erros de todos os requests desse banco!
         console.log("Database error: " + event.target.errorCode);
         }
         var unityStore = db.transaction("unity").objectStore("unity");
         var unitys = new Array();
         unityStore.openCursor().onsuccess = function (event) {
         
         var cursor = event.target.result;
         if (cursor) {
         // Percorre cada registro da unity
         var unity_id = cursor.value.id;
         var unity_name = cursor.value.name;
         var currentUnity = {
         'unity_id': unity_id,
         'unity_name': unity_name
         };
         unitys.push(currentUnity);
         cursor.continue();
         } else {
         //Finalizou a Pesquisa das Unitys
         callBack(unitys, callBackEvent);
         }
         
         };
         unityStore.onerror = function (event) {
         // Tratar erro!
         }
         }
         DBsynapse.onblocked = function (event) {
         // Se existe outra aba com a versão antiga
         window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
         }
         
         }
         this.getAllStudentFromClasses = function (unitys, callBackEvent) {
         self.totalUnitys = unitys.length;
         for (var idx = 0; idx < unitys.length; idx++) {
         self.getAllStudentFromClass(unitys[idx], callBackEvent);
         }
         }
         
         this.getAllStudentFromClass = function (unity, callBackEvent) {
         window.indexedDB = self.verifyIDBrownser();
         DBsynapse = window.indexedDB.open(nameBD);
         DBsynapse.onerror = function (event) {
         console.log("Error: ");
         console.log(event);
         //alert("Você não habilitou minha web app para usar IndexedDB?!");
         }
         DBsynapse.onsuccess = function (event) {
         var db = event.target.result;
         db.onerror = function (event) {
         // Função genérica para tratar os erros de todos os requests desse banco!
         console.log("Database error: " + event.target.errorCode);
         }
         var unity_id = unity.unity_id;
         var actorStore = db.transaction("actor").objectStore("actor");
         var requestGet = actorStore.index('unity_id');
         var singleKeyRange = IDBKeyRange.only(unity_id);
         var actors = new Array();
         var contStudent = 0;
         requestGet.openCursor().onsuccess = function (event) {
         var cursorActor = event.target.result;
         if (cursorActor) {
         // Percorre cada registro no actor para a unity corrent e personage = 'Aluno'
         if (cursorActor.value.personage_name == 'Aluno') {
         var actor_id = cursorActor.value.id;
         var actor_name = cursorActor.value.name;
         //Pesquisar Todos os alunos desta unidade
         actors[contStudent] = {
         'actor_id': actor_id,
         'actor_name': actor_name
         };
         contStudent++;
         }
         
         cursorActor.continue();
         
         } else {
         //Finalisou para os Actors desta Class
         var currentUnity = {
         'unity_id': unity_id,
         'unity_name': unity.unity_name,
         'actors': actors
         };
         self.actorOwnUnity.push(currentUnity);
         //Verificar se é a ÚLTIMA Class
         if (self.actorOwnUnity.length == self.totalUnitys) {
         //Dispara o evento para o filter do select
         callBackEvent(self.actorOwnUnity);
         }
         }
         
         };
         requestGet.onerror = function (event) {
         // Tratar erro!
         }
         }
         DBsynapse.onblocked = function (event) {
         // Se existe outra aba com a versão antiga
         window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
         }
         
         }
         
         */




        //Verificar se já possui um bloco
        this.verifyExistBlock = function (options, callBack) {
            var existBlock = false;
            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function (event) {
                console.log("Error: ");
                console.log(event);
                //alert("Você não habilitou minha web app para usar IndexedDB?!");
            }

            DBsynapse.onsuccess = function (event) {
                var db = event.target.result;
                db.onerror = function (event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    console.log("Database error: " + event.target.errorCode);
                }

                var blockStore = db.transaction("cobjectblock").objectStore("cobjectblock");
                var cobjectblock = new Array();
                blockStore.openCursor().onsuccess = function (event) {
                    var cursor = event.target.result;
                    if (cursor && !existBlock) {
                        // Percorre cada registro do cobjectblock
                        existBlock = true;
                    }

                    var schoolsClassrooms = null;
                    //===== Somente se for necessário definir o nome das Escolas-Turmas Novas ===========
                    var schoolsClassrooms = new Array();
                    schoolsClassrooms['schools'] = new Array();

                    schoolsClassrooms['schools'][0] = new Array();
                    schoolsClassrooms['schools'][0]['classrooms'] = new Array();

                    schoolsClassrooms['schools'][1] = new Array();
                    schoolsClassrooms['schools'][1]['classrooms'] = new Array();


                    schoolsClassrooms['schools'][0]['name'] = "EMEF Raimundo Menezes";
                    schoolsClassrooms['schools'][0]['classrooms'].push("2° Ano");
                    schoolsClassrooms['schools'][0]['classrooms'].push("3° Ano");
                    schoolsClassrooms['schools'][0]['classrooms'].push("4° Ano");

                    schoolsClassrooms['schools'][1]['name'] = "EMEF Vereador Soutelo";
                    schoolsClassrooms['schools'][1]['classrooms'].push("2° Ano");
                    schoolsClassrooms['schools'][1]['classrooms'].push("3° Ano");
                    schoolsClassrooms['schools'][1]['classrooms'].push("4° Ano");

                    //====================================

                    callBack(options, schoolsClassrooms, existBlock);

                };
                blockStore.onerror = function (event) {
                    // Tratar erro!
                }
            }

            DBsynapse.onblocked = function (event) {
                // Se existe outra aba com a versão antiga
                window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            }

        }

        function useDatabase(db) {
            // Esteja certo de que adicionou um evento para notificar se a página muda a versão
            // Devemos fechar o banco. Isso permite à outra página ser atualizada
            db.onversionchange = function (event) {
                db.close();
                alert("Uma nova versão desta web app está pronta. Atualiza, por favor!");
            }
        }

        this.getBlockByDiscipline = function (discipline_id, callBack) {
            if (self.isset(discipline_id)) {
                window.indexedDB = self.verifyIDBrownser();
                DBsynapse = window.indexedDB.open(nameBD);
                DBsynapse.onerror = function (event) {
                    console.log("Error: ");
                    console.log(event);
                    // alert("Você não habilitou minha web app para usar IndexedDB?!");
                }
                DBsynapse.onsuccess = function (event) {
                    var cobject_block_id = null;
                    var db = event.target.result;
                    db.onerror = function (event) {
                        // Função genérica para tratar os erros de todos os requests desse banco!
                        console.log("Database error: " + event.target.errorCode);
                    }
                    //Tudo ok Então Busca O CobjectBlock
                    var cobjectBlockStore = db.transaction("cobjectblock").objectStore("cobjectblock");
                    var requestGet = cobjectBlockStore.index('discipline_id');
                    var singleKeyRange = IDBKeyRange.only(discipline_id);
                    requestGet.openCursor(singleKeyRange).onsuccess = function (event) {
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
                    requestGet.onerror = function (event) {
                        // Tratar erro!
                    }
                }
                DBsynapse.onblocked = function (event) {
                    // Se existe outra aba com a versão antiga
                    window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
                }
            }
        }



//Registrar Turma
        this.addSchoolClassroomsOff = function (listSchools, idxSchool) {
            var school = listSchools[idxSchool];
            if (self.isset(school)) {
                var school_name = school['name'];
                var listClassrooms_name = school['classrooms'];

                //=========================
                window.indexedDB = self.verifyIDBrownser();
                DBsynapse = window.indexedDB.open(nameBD);
                DBsynapse.onerror = function (event) {
                    console.log("Error: ");
                    console.log(event);
                    // alert("Você não habilitou minha web app para usar IndexedDB?!");
                }
                DBsynapse.onsuccess = function (event) {
                    var db = event.target.result;

                    db.onerror = function (event) {
                        // Função genérica para tratar os erros de todos os requests desse banco!
                        console.log("Database error: " + event.target.error.message);
                    }
                    var maxID = 0;
                    var findSchoolsObjectStore = db.transaction("school", "readonly").objectStore("school");
                    findSchoolsObjectStore.openCursor().onsuccess = function (event) {
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
                            schoolObjectStore.transaction.oncomplete = function (event) {
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
                DBsynapse.onblocked = function (event) {
                    // Se existe outra aba com a versão antiga
                    window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
                }
            }
        }



        //Registrar Turma
        this.addClassroomsOff = function (school_id, listClassrooms_name, idxClassroom, infoSchools) {
            var classroom_name = listClassrooms_name[idxClassroom];

            if (self.isset(classroom_name)) {
                idxClassroom++;

                window.indexedDB = self.verifyIDBrownser();
                DBsynapse = window.indexedDB.open(nameBD);
                DBsynapse.onerror = function (event) {
                    console.log("Error: ");
                    console.log(event);
                    // alert("Você não habilitou minha web app para usar IndexedDB?!");
                }
                DBsynapse.onsuccess = function (event) {
                    var db = event.target.result;

                    db.onerror = function (event) {
                        // Função genérica para tratar os erros de todos os requests desse banco!
                        console.log("Database error: " + event.target.error.message);
                    }
                    var maxID = 0;
                    var findClassroomsObjectStore = db.transaction("unity", "readonly").objectStore("unity");
                    findClassroomsObjectStore.openCursor().onsuccess = function (event) {
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
                            classroomObjectStore.transaction.oncomplete = function (event) {
                                console.log(' NEW Classroom Salvo !!!! ');
                                self.addClassroomsOff(school_id, listClassrooms_name, idxClassroom, infoSchools);
                            };
                        }
                    }

                }
                DBsynapse.onblocked = function (event) {
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
        this.addStudentOff = function (classroom_id, user_name) {
            if (self.isset(user_name)) {
                window.indexedDB = self.verifyIDBrownser();
                DBsynapse = window.indexedDB.open(nameBD);
                DBsynapse.onerror = function (event) {
                    console.log("Error: ");
                    console.log(event);
                    // alert("Você não habilitou minha web app para usar IndexedDB?!");
                }
                DBsynapse.onsuccess = function (event) {
                    var db = event.target.result;

                    db.onerror = function (event) {
                        // Função genérica para tratar os erros de todos os requests desse banco!
                        console.log("Database error: " + event.target.error.message);
                    }
                    var maxID = 0;
                    var findStudentsObjectStore = db.transaction("actor", "readonly").objectStore("actor");
                    findStudentsObjectStore.openCursor().onsuccess = function (event) {
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
                            studentObjectStore.transaction.oncomplete = function (event) {
                                console.log(' NEW Actor Salvo !!!! ');
                                location.href = "select.html";
                            };
                        }
                    }

                }
                DBsynapse.onblocked = function (event) {
                    // Se existe outra aba com a versão antiga
                    window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
                }
            }
        }

        //Pesquisar Todas as escolas
        this.findAllSchools = function (callBack) {
            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function (event) {
                console.log("Error: ");
                console.log(event);
                //alert("Você não habilitou minha web app para usar IndexedDB?!");
            };
            DBsynapse.onsuccess = function (event) {
                var db = event.target.result;
                db.onerror = function (event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    console.log("Database error: " + event.target.errorCode);
                };

                var schools = new Array();

                var schoolObjectStore = db.transaction("school", "readonly").objectStore("school");
                schoolObjectStore.openCursor().onsuccess = function (event) {
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
            DBsynapse.onblocked = function (event) {
                // Se existe outra aba com a versão antiga
                window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            }

        }

        //Pesquisar Todas as Turmas
        this.findAllClassrooms = function (callBack) {
            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function (event) {
                console.log("Error: ");
                console.log(event);
                //alert("Você não habilitou minha web app para usar IndexedDB?!");
            };
            DBsynapse.onsuccess = function (event) {
                var db = event.target.result;
                db.onerror = function (event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    console.log("Database error: " + event.target.errorCode);
                };

                var classrooms = new Array();

                var classroomObjectStore = db.transaction("unity", "readonly").objectStore("unity");
                classroomObjectStore.openCursor().onsuccess = function (event) {
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
            DBsynapse.onblocked = function (event) {
                // Se existe outra aba com a versão antiga
                window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            }

        }


        //Pesquisar Todos os Cobjects, porém retorna somente informações importantes
        this.findAllMinCobjects = function (callBack) {
            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function (event) {
                console.log("Error: ");
                console.log(event);
                //alert("Você não habilitou minha web app para usar IndexedDB?!");
            };
            DBsynapse.onsuccess = function (event) {
                var db = event.target.result;
                db.onerror = function (event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    console.log("Database error: " + event.target.errorCode);
                };

                var cobjects = new Array();

                var cobjectObjectStore = db.transaction("cobject", "readonly").objectStore("cobject");
                cobjectObjectStore.openCursor().onsuccess = function (event) {
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
            DBsynapse.onblocked = function (event) {
                // Se existe outra aba com a versão antiga
                window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            }

        }


        //Pesquisar Cobject específico
        this.findCobjectById = function (cobject_id, callBack) {

            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function (event) {
                console.log("Error: ");
                console.log(event);
                //alert("Você não habilitou minha web app para usar IndexedDB?!");
            };
            DBsynapse.onsuccess = function (event) {
                var db = event.target.result;
                db.onerror = function (event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    console.log("Database error: " + event.target.errorCode);
                };

                var cobject = null;
                var cobjectObjectStore = db.transaction("cobject", "readonly").objectStore("cobject");

                //Selecionar somente o cobject que possui o cobject_id especificado
                cobjectObjectStore.get(cobject_id).onsuccess = function (event) {
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
            DBsynapse.onblocked = function (event) {
                // Se existe outra aba com a versão antiga
                window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            }
        }


        //Pesquisar Turma específica
        this.findClassroomById = function (classroom_id, callBack) {

            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function (event) {
                console.log("Error: ");
                console.log(event);
                //alert("Você não habilitou minha web app para usar IndexedDB?!");
            };
            DBsynapse.onsuccess = function (event) {
                var db = event.target.result;
                db.onerror = function (event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    console.log("Database error: " + event.target.errorCode);
                };

                var classroom = null;
                var classroomObjectStore = db.transaction("unity", "readonly").objectStore("unity");

                //Selecionar somente a turma que possui o classroom_id especificado
                classroomObjectStore.get(classroom_id).onsuccess = function (event) {
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
            DBsynapse.onblocked = function (event) {
                // Se existe outra aba com a versão antiga
                window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            }
        }



        //Pesquisar todas as classes de uma determinada escola
        this.findClassroomBySchool = function (school_id, callBack) {

            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function (event) {
                console.log("Error: ");
                console.log(event);
                //alert("Você não habilitou minha web app para usar IndexedDB?!");
            };
            DBsynapse.onsuccess = function (event) {
                var db = event.target.result;
                db.onerror = function (event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    console.log("Database error: " + event.target.errorCode);
                };

                var classrooms = new Array();
                var classroomObjectStore = db.transaction("unity", "readonly").objectStore("unity");

                //Selecionar somente as turmas pra a escola específica
                var requestGet = classroomObjectStore.index('school_id');
                var singleKeyRange = IDBKeyRange.only(school_id);

                requestGet.openCursor(singleKeyRange).onsuccess = function (event) {
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
            DBsynapse.onblocked = function (event) {
                // Se existe outra aba com a versão antiga
                window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            }
        }




        //Pesquisar todas as classes de uma determinada escola
        this.findStudentByClassroom = function (classroom_id, callBack) {

            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function (event) {
                console.log("Error: ");
                console.log(event);
                //alert("Você não habilitou minha web app para usar IndexedDB?!");
            };
            DBsynapse.onsuccess = function (event) {
                var db = event.target.result;
                db.onerror = function (event) {
                    // Função genérica para tratar os erros de todos os requests desse banco!
                    console.log("Database error: " + event.target.errorCode);
                };

                var students = new Array();
                var studentObjectStore = db.transaction("actor", "readonly").objectStore("actor");

                //Selecionar somente os alunos pra a turma específica
                var requestGet = studentObjectStore.index('unity_id');
                var singleKeyRange = IDBKeyRange.only(classroom_id);

                requestGet.openCursor(singleKeyRange).onsuccess = function (event) {
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
            DBsynapse.onblocked = function (event) {
                // Se existe outra aba com a versão antiga
                window.alert("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
            }
        }




        this.isset = function (variable) {
            return (typeof variable !== 'undefined' && variable !== null);
        }

    }

}