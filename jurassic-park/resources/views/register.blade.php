<!DOCTYPE html>
<html>
<head>
    <title>Register - Jurassic Park</title>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #052e16, #020617);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white;
        }

        .box {
            background: rgba(0,0,0,0.6);
            padding: 30px;
            border-radius: 16px;
            border: 1px solid #22c55e;
            width: 320px;
            text-align: center;
        }

        h2 {
            color: #facc15;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 8px;
            border: 1px solid #14532d;
            background: #020617;
            color: white;
        }

        button {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            background: #facc15;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .link {
            margin-top: 15px;
            font-size: 12px;
            cursor: pointer;
            color: #86efac;
        }
    </style>
</head>

<body>

<div class="box">
    <h2>🦖 Register</h2>

    <input id="name" placeholder="Name">
    <input id="email" placeholder="Email">
    <input id="password" type="password" placeholder="Password">

    <select id="role">
        <option value="admin">Admin</option>
        <option value="veterinario">Veterinario</option>
        <option value="mantenimiento">Mantenimiento</option>
    </select>

    <button onclick="register()">Crear cuenta</button>

    <div class="link" onclick="goLogin()">¿Ya tienes cuenta? Login</div>
</div>

<script>
function register() {
    fetch('/api/register', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            name: name.value,
            email: email.value,
            password: password.value,
            role: role.value
        })
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success)
        {
            alert(data.message || "Error al registrarse")
            return
        }

        localStorage.setItem("token", data.data.token)
        localStorage.setItem("name", data.data.name)
        localStorage.setItem("role", data.data.role)
        localStorage.setItem("image", data.data.image ?? "")
        window.location.href = "/home"
    })
    .catch(err => {
        console.error(err)
        alert("Error de conexión con el servidor")
    })
}

function goLogin() {
    window.location.href = "/login"
}
</script>

</body>
</html>
