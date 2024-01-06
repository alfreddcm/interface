    // Load todos from local storage on page load
    window.onload = function() {
        loadTodos();
    };

    function addTodo() {
        var todoInput = document.getElementById('todoInput');
        var todoList = document.getElementById('todoList');

        if (todoInput.value.trim() === '') {
            alert('Please enter a valid todo.');
            return;
        }

        var todoItem = document.createElement('li');
        todoItem.className = 'todoItem';
        todoItem.innerHTML = `
                <span>${todoInput.value}</span>
                <button onclick="removeTodo(this)">Remove</button>
            `;
        todoList.appendChild(todoItem);

        todoInput.value = '';
    }

    function removeTodo(button) {
        var todoItem = button.parentElement;
        todoItem.remove();
    }

    function saveToLocalStorage() {
        var todoList = document.getElementById('todoList');
        var todos = [];

        // Iterate through todo items and save their text content
        for (var i = 0; i < todoList.children.length; i++) {
            var todoText = todoList.children[i].querySelector('span').innerText;
            todos.push(todoText);
        }

        // Save todos array to local storage
        localStorage.setItem('todos', JSON.stringify(todos));

        // Save todos to a text file on the server
        saveTodosToFile(todos);

        alert('Todos saved successfully!');
    }


    function saveTodosToFile(todos) {
        // Convert todos array to a newline-separated string
        var todosString = todos.join('\n');

        // Create an AJAX request to save the todos on the server
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../php/save_todos.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        // Send the todos data to the server
        xhr.send('userId=' + getUserId() + '&todos=' + encodeURIComponent(todosString));

        // Handle the response from the server (optional)
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log('Todos saved on the server');
            } else {
                console.error('Failed to save todos on the server');
            }
        };
    }


    function getUserId() {

        return document.getElementById('userId').value;
    }


    function loadTodos() {
        var todoList = document.getElementById('todoList');
        var todos = JSON.parse(localStorage.getItem('todos')) || [];

        // Populate todo items from local storage
        for (var i = 0; i < todos.length; i++) {
            var todoItem = document.createElement('li');
            todoItem.className = 'todoItem';
            todoItem.innerHTML = `
                    <span>${todos[i]}</span>
                    <button onclick="removeTodo(this)">Remove</button>
                `;
            todoList.appendChild(todoItem);
        }
    }

    function clearTodos() {
        var todoList = document.getElementById('todoList');
        todoList.innerHTML = '';
        localStorage.removeItem('todos');
        alert('Todos cleared!');
    }
