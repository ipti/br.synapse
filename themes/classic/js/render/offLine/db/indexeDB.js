var synapseDB = {};
window.indexedDB = window.indexedDB || window.webkitIndexedDB ||
                   window.mozIndexedDB;

if ('webkitIndexedDB' in window) {
  window.IDBTransaction = window.webkitIDBTransaction;
  window.IDBKeyRange = window.webkitIDBKeyRange;
}

synapseDB.indexedDB = {};
synapseDB.indexedDB.db = null;

synapseDB.indexedDB.onerror = function(e) {
  console.log(e);
};

synapseDB.indexedDB.open = function() {
  var request = indexedDB.open("synapse");

  request.onsuccess = function(e) {
    var v = 1;
    synapseDB.indexedDB.db = e.target.result;
    var db = synapseDB.indexedDB.db;
    // We can only create Object stores in a setVersion transaction;
    if (v != db.version) {
      var setVrequest = db.setVersion(v);

      // onsuccess is the only place we can create Object Stores
      setVrequest.onerror = synapseDB.indexedDB.onerror;
      setVrequest.onsuccess = function(e) {
        if(db.objectStoreNames.contains("todo")) {
          db.deleteObjectStore("todo");
        }

        var store = db.createObjectStore("todo",
          {keyPath: "timeStamp"});
        e.target.transaction.oncomplete = function() {
          synapseDB.indexedDB.getAllTodoItems();
        };
      };
    } else {
      request.transaction.oncomplete = function() {
        synapseDB.indexedDB.getAllTodoItems();
      };
    }
  };
  request.onerror = synapseDB.indexedDB.onerror;
};

synapseDB.indexedDB.addTodo = function(todoText) {
  var db = synapseDB.indexedDB.db;
  var trans = db.transaction(["todo"], "readwrite");
  var store = trans.objectStore("todo");

  var data = {
    "text": todoText,
    "timeStamp": new Date().getTime()
  };

  var request = store.put(data);

  request.onsuccess = function(e) {
    synapseDB.indexedDB.getAllTodoItems();
  };

  request.onerror = function(e) {
    console.log("Error Adding: ", e);
  };
};

synapseDB.indexedDB.deleteTodo = function(id) {
  var db = synapseDB.indexedDB.db;
  var trans = db.transaction(["todo"], "readwrite");
  var store = trans.objectStore("todo");

  var request = store.delete(id);

  request.onsuccess = function(e) {
    synapseDB.indexedDB.getAllTodoItems();
  };

  request.onerror = function(e) {
    console.log("Error Adding: ", e);
  };
};

synapseDB.indexedDB.getAllTodoItems = function() {
  var todos = document.getElementById("todoItems");
  todos.innerHTML = "";

  var db = synapseDB.indexedDB.db;
  var trans = db.transaction(["todo"], "readwrite");
  var store = trans.objectStore("todo");

  // Get everything in the store;
  var cursorRequest = store.openCursor();

  cursorRequest.onsuccess = function(e) {
    var result = e.target.result;
    if(!!result == false)
      return;

    renderTodo(result.value);
    result.continue();
  };

  cursorRequest.onerror = synapseDB.indexedDB.onerror;
};

function renderTodo(row) {
  var todos = document.getElementById("todoItems");
  var li = document.createElement("li");
  var a = document.createElement("a");
  var t = document.createTextNode(row.text);

  a.addEventListener("click", function() {
    synapseDB.indexedDB.deleteTodo(row.timeStamp);
  }, false);

  a.textContent = " [Delete]";
  li.appendChild(t);
  li.appendChild(a);
  todos.appendChild(li);
}

function addTodo() {
  var todo = document.getElementById("todo");
  synapseDB.indexedDB.addTodo(todo.value);
  todo.value = "";
}

function init() {
  synapseDB.indexedDB.open();
}

window.addEventListener("DOMContentLoaded", init, false);​