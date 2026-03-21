<!DOCTYPE html>
<html>
<head>
    <title>Jurassic Park Auth</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #111827;
            padding: 30px;
            border-radius: 12px;
            width: 340px;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 8px;
            outline: none;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 8px;
            background: #22c55e;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #16a34a;
        }

        .secondary {
            margin-top: 10px;
            background: #3b82f6;
        }

        .secondary:hover {
            background: #2563eb;
        }

        .third {
            margin-top: 10px;
            background: #f59e0b;
        }

        .third:hover {
            background: #d97706;
        }

        .role-box {
            margin-top: 10px;
            padding: 10px;
            border-radius: 8px;
            background: #1f2937;
        }

        pre {
            margin-top: 15px;
            background: black;
            padding: 10px;
            border-radius: 8px;
            font-size: 12px;
            text-align: left;
            max-height: 150px;
            overflow: auto;
        }
    </style>
</head>

<body>

<div class="container">
    <h2>🦖 Jurassic Park</h2>

    <input type="text" id="name" placeholder="Name">
    <input type="email" id="email" placeholder="Email">
    <input type="password" id="password" placeholder="Password">

    <select id="role">
        <option value="admin">Admin</option>
        <option value="veterinario">Veterinario</option>
        <option value="mantenimiento">Mantenimiento</option>
    </select>

    <button onclick="login()">Login</button>
    <button class="secondary" onclick="register()">Register</button>
    <button class="third" onclick="getUser()">Ver perfil</button>

    <div class="role-box" id="roleBox" style="display:none;"></div>

    <pre id="result"></pre>
</div>

<script>
let token = '';
let currentUser = null;

// LOGIN
function login() {
    fetch('http://127.0.0.1:8000/api/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            email: document.getElementById('email').value,
            password: document.getElementById('password').value
        })
    })
    .then(res => res.json())
    .then(data => {
        // 🔥 GUARDAR BIEN
        localStorage.setItem("token", data.data.token)
        localStorage.setItem("role", data.data.role)
        localStorage.setItem("name", data.data.name)

        // opcional debug
        document.getElementById('result').innerText = JSON.stringify(data, null, 2);

        // 🔥 REDIRECCIÓN
        window.location.href = "/home"
    })
    .catch(err => console.error(err));
}

// REGISTER
function register() {
    fetch('http://127.0.0.1:8000/api/register', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            role: document.getElementById('role').value
        })
    })
    .then(res => res.json())
    .then(data => {
        // 🔥 Guardar datos en localStorage
        localStorage.setItem("token", data.data.token)
        localStorage.setItem("role", data.data.role)
        localStorage.setItem("name", data.data.name)

        // Mostrar respuesta (debug)
        document.getElementById('result').innerText = JSON.stringify(data, null, 2);

        // 🔥 Redirigir al home
        window.location.href = "/home"
    })
    .catch(err => console.error(err));
}

// GET USER
function getUser() {
    fetch('http://127.0.0.1:8000/api/user', {
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token
        }
    })
    .then(res => res.json())
    .then(data => {
        currentUser = data;

        document.getElementById('result').innerText = JSON.stringify(data, null, 2);

        // Mostrar rol
        const roleBox = document.getElementById('roleBox');
        roleBox.style.display = 'block';
        roleBox.innerText = "👤 " + data.name + " | Rol: " + data.role;

        // Aquí luego puedes condicionar botones según rol
        if (data.role === 'admin') {
            roleBox.innerText += " (FULL ACCESS 🔥)";
        } else {
            roleBox.innerText += " (LIMITED ACCESS ⚠️)";
        }
    })
    .catch(err => console.error(err));
}
</script>

</body>
</html
