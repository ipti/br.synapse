// // - - - - - - - - - -  //
// CRIAR BANCO DE DADOS //
// - - - - - - - - - -  //
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

    this.openDBuild = function (alterSchema, dataImportFunction) {
        self.dataImportFunction = dataImportFunction;

        window.indexedDB = self.verifyIDBrownser();
        if (!window.indexedDB) {
            console.log("Seu navegador não suporta uma versão estável do IndexedDB. Alguns recursos não estarão disponíveis.");
        }
        //Verificar se precisa mudar o setVersion para alterar o schema do BD
        var alterSchema = (this.isset(alterSchema) && alterSchema);

        //Se ainda não atualizou o DBversion, então abre o banco na sua versão atual
        var synapseBD;
        synapseBD = window.indexedDB.open(nameBD);

        synapseBD.onerror = function (event) {
            alert("Você não habilitou minha web app para usar IndexedDB?!");
        }

        synapseBD.onsuccess = function (event) {

            var db = event.target.result;
            db.onerror = function (event) {
                // Função genérica para tratar os erros de todos os requests desse banco!
                alert("Database error: " + event.target.errorCode);
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

    }



    var openBuild = function () {
        DBsynapse = window.indexedDB.open(nameBD, DBversion);
        
        DBsynapse.onversionchange = function (event) {
            //STOP HERE
            DBsynapse.close();
        };
        
        DBsynapse.onerror = function (event) {
            alert("Você não habilitou minha web app para usar IndexedDB?!");
        };
        DBsynapse.onsuccess = function (event) {
            var db = event.target.result;
            db.onerror = function (event) {
                // Função genérica para tratar os erros de todos os requests desse banco!
                alert("Database error: " + event.target.errorCode);
            };
        }
        //Se for uma nova versão é criado o novo schemma do banco
        self.buildAllSchema();

        DBsynapse.onblocked = function (event) {
            // Se existe outra aba com a versão antiga
            console.log("Existe uma versão antiga da web app aberta em outra aba, feche-a por favor!");
        };

    }


    this.buildAllSchema = function () {
        //Criar Schemas das tabelas

        DBsynapse.onupgradeneeded = function (event) {
            var db = event.target.result;

            var unityStore = db.createObjectStore("unity", {
                keyPath: "id"
            });
            // Podemos ter nomes duplicados, então não podemos usar como índice único.
            unityStore.createIndex("name", "name", {
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
            // Falta discipline_id

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
            var state_actorStore = db.createObjectStore("state_actor", {
                keyPath: "id",
                autoIncrement: true
            });

            state_actorStore.createIndex("actor_id", "actor_id", {
                unique: false
            });
            state_actorStore.createIndex("cobject_block_id", "cobject_block_id", {
                unique: false
            });


            // Usando transação oncomplete para afirmar que a criação do objectStore 
            // é terminada antes de adicionar algum dado nele.

            unityStore.transaction.oncomplete = function (event) {
                //Se for o último dos 8 então contruiu todos os schemas
                db.close();
                self.dataImportFunction();
                console.log('Criou os Schemas');
            }

            actorStore.transaction.oncomplete = function (event) {
                //Se for o último dos 8 então contruiu todos os schemas
                db.close();
                self.dataImportFunction();
                console.log('Criou os Schemas');
            }
            disciplineStore.transaction.oncomplete = function (event) {
                //Se for o último dos 8 então contruiu todos os schemas
                db.close();
                self.dataImportFunction();
                console.log('Criou os Schemas');
            }
            cobjectblockStore.transaction.oncomplete = function (event) {
                //Se for o último dos 8 então contruiu todos os schemas
                db.close();
                self.dataImportFunction();
                console.log('Criou os Schemas');
            }
            cobject_cobjectblockStore.transaction.oncomplete = function (event) {
                //Se for o último dos 8 então contruiu todos os schemas
                db.close();
                self.dataImportFunction();
                console.log('Criou os Schemas');
            }
            cobjectStore.transaction.oncomplete = function (event) {
                //Se for o último dos 8 então contruiu todos os schemas
                db.close();
                self.dataImportFunction();
                console.log('Criou os Schemas');
            }
            performance_actorStore.transaction.oncomplete = function (event) {
                //Se for o último dos 8 então contruiu todos os schemas
                db.close();
                self.dataImportFunction();
                console.log('Criou os Schemas');
            }
            state_actorStore.transaction.oncomplete = function (event) {
                //Se for o último dos 8 então contruiu todos os schemas
                db.close();
                self.dataImportFunction();
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

        var options = {
            schools: schools,
            unitys: unitys,
            actors: actors,
            disciplines: disciplines,
            cobjectblock: cobjectblock,
            cobject_cobjectblocks: cobject_cobjectblocks,
            cobjects: cobjects
        };
        self.verifyExistBlock(options, function (schools, unitys, actors, disciplines, cobjectblock
                , cobject_cobjectblocks, cobjects, existBlock) {
            //Call Back
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

            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function (event) {
                alert("Você não habilitou minha web app para usar IndexedDB?!");
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
            CobjectObjectStore.add(data_cobject[i]);
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

    // - - - - - - - - - -  //
    // EXPORTE PARA BANCO DE DADOS //
    // - - - - - - - - - -  //

    //Export os performances_actors
    this.exportPerformance_actor = function () {
        window.indexedDB = self.verifyIDBrownser();
        DBsynapse = window.indexedDB.open(nameBD);
        DBsynapse.onerror = function (event) {
            alert("Você não habilitou minha web app para usar IndexedDB?!");
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


        ///=====


    }


    //Pesquisas No Banco        
    this.login = function (login, password, callBack) {
        if (login !== '' && password !== '' && self.isset(login) && self.isset(password)) {
            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function (event) {
                alert("Você não habilitou minha web app para usar IndexedDB?!");
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
                            //Armazenar nome do usuário e id_Actor na sessão 
                            sessionStorage.setItem("authorization", true);
                            sessionStorage.setItem("login_id_actor", id);
                            sessionStorage.setItem("login_name_actor", name);
                            sessionStorage.setItem('login_personage_name', personage_name);
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
                alert("Você não habilitou minha web app para usar IndexedDB?!");
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
                alert("Você não habilitou minha web app para usar IndexedDB?!");
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
                        //Finalisou a Pesquisa
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
            alert("Você não habilitou minha web app para usar IndexedDB?!");
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
        var actor_id = data_state_actor.actor_id;
        var cobject_block_id = data_state_actor.cobject_block_id;
        //Escolhe a pesquisa por Ator
        if (self.isset(actor_id)) {
            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function (event) {
                alert("Você não habilitou minha web app para usar IndexedDB?!");
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
                        //Verificar se JÁ POSSUI UM ESTADO ATUAL PARA ESTE USUÁRIO NESTE BLOCK
                        if (cursor.value.cobject_block_id == cobject_block_id) {
                            //Realiza Update
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
                        //Finalisou a Pesquisa, se não existir um estado corrent, o parms=null
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
    this.getUserState = function (actor_id, cobject_block_id, callBack) {

        if (self.isset(actor_id) && self.isset(cobject_block_id)) {
            var info_state = null;
            window.indexedDB = self.verifyIDBrownser();
            DBsynapse = window.indexedDB.open(nameBD);
            DBsynapse.onerror = function (event) {
                alert("Você não habilitou minha web app para usar IndexedDB?!");
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
                        // Para cada id do Actor encontrado, verificar cobject_block_id
                        if (cursor.value.cobject_block_id == cobject_block_id) {
                            //Encontrou o estado deste Actor para este Bloco
                            info_state = {
                                cobject_block_id: cursor.value.cobject_block_id,
                                actor_id: cursor.value.actor_id,
                                last_cobject_id: cursor.value.last_cobject_id,
                                last_piece_id: cursor.value.last_piece_id,
                                qtd_correct: cursor.value.qtd_correct,
                                qtd_wrong: cursor.value.qtd_wrong,
                                last_cobject_id: cursor.value.last_cobject_id
                            };
                        }
                        //else { Se não encontrou, vai pro próximo
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


    this.getAllClass = function (callBack, callBackEvent) {
        window.indexedDB = self.verifyIDBrownser();
        DBsynapse = window.indexedDB.open(nameBD);
        DBsynapse.onerror = function (event) {
            alert("Você não habilitou minha web app para usar IndexedDB?!");
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
            alert("Você não habilitou minha web app para usar IndexedDB?!");
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


    //Verificar se já possui um bloco
    this.verifyExistBlock = function (options, callBack) {
        var existBlock = false;
        window.indexedDB = self.verifyIDBrownser();
        DBsynapse = window.indexedDB.open(nameBD);
        DBsynapse.onerror = function (event) {
            alert("Você não habilitou minha web app para usar IndexedDB?!");
        }

        DBsynapse.onsuccess = function (event) {
            var db = event.target.result;
            db.onerror = function (event) {
                // Função genérica para tratar os erros de todos os requests desse banco!
                console.log("Database error: " + event.target.errorCode);
            }

            console.log(db);

            var blockStore = db.transaction("cobjectblock").objectStore("cobjectblock");
            var cobjectblock = new Array();
            blockStore.openCursor().onsuccess = function (event) {
                var cursor = event.target.result;
                if (cursor && !existBlock) {
                    // Percorre cada registro do cobjectblock
                    existBlock = true;
                }

                callBack(options.unitys, options.actors, options.disciplines, options.cobjectblock
                        , options.cobject_cobjectblocks, options.cobjects, existBlock);

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


    this.isset = function (variable) {
        return (typeof variable !== 'undefined' && variable !== null);
    }

}