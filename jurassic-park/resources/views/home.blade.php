<!DOCTYPE html>
<html>
<head>
    <title>Jurassic Park</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #020617, #0f172a);
            color: white;
        }

        .navbar {
            background: #020617;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
        }

        .logo {
            font-weight: bold;
            font-size: 20px;
            color: #22c55e;
        }

        .logout {
            background: #ef4444;
            border: none;
            padding: 8px 12px;
            border-radius: 8px;
            color: white;
            cursor: pointer;
        }

        .container {
            padding: 40px;
            text-align: center;
        }

        .card {
            background: #111827;
            padding: 25px;
            border-radius: 12px;
            max-width: 400px;
            margin: auto;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
        }

        .role {
            margin-top: 10px;
            padding: 8px;
            border-radius: 8px;
            background: #1f2937;
        }

        .admin-panel {
            margin-top: 30px;
            display: none;
        }

        .admin-panel button {
            margin: 5px;
            padding: 10px;
            border: none;
            border-radius: 8px;
            background: #3b82f6;
            color: white;
            cursor: pointer;
        }

        .admin-panel button:hover {
            background: #2563eb;
        }
    </style>
</head>

<body>

<div class="navbar">
    <div class="logo">🦖 Jurassic Park</div>
    <button class="logout" onclick="logout()">Logout</button>
</div>

<div class="container">
    <div class="card">
        <h2 id="welcome"></h2>
        <div class="role" id="role"></div>
    </div>

    <div class="admin-panel" id="adminPanel">
        <h3>🔥 Panel de Administrador</h3>
        <button onclick="alert('Aquí irá GET /users')">Ver usuarios</button>
        <button onclick="alert('Aquí irá POST /users')">Crear usuario</button>
        <button onclick="alert('Aquí irá DELETE /users')">Eliminar usuario</button>
    </div>
</div>

<script>
const token = localStorage.getItem("token")
const role = localStorage.getItem("role")
const name = localStorage.getItem("name")

// 🔒 Si no hay token → fuera
if (!token) {
    window.location.href = "/login"
}

// Mostrar info
document.getElementById("welcome").innerText = "Bienvenido, " + name
document.getElementById("role").innerText = "Rol: " + role

// Mostrar panel admin
if (role === "admin") {
    document.getElementById("adminPanel").style.display = "block"
}

// Logout
function logout() {
    const token = localStorage.getItem("token")

    fetch('http://127.0.0.1:8000/api/logout', {
        method: 'POST',
        headers: {
            'Authorization': 'Bearer ' + token
        }
    })
    .then(res => res.json())
    .then(data => {
        console.log(data)

        // 🧹 limpiar sesión
        localStorage.clear()

        // 🔁 volver al login
        window.location.href = "/login"
    })
    .catch(err => console.error(err));
}
</script>

</body>
</html>
