<!DOCTYPE html>
<html>
<head>
    <title>Login - Jurassic Park</title>

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

        input {
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
            background: #22c55e;
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
    <h2>🦖 Login</h2>

    <input id="email" placeholder="Email">
    <input id="password" type="password" placeholder="Password">

    <button onclick="login()">Entrar</button>

    <div class="link" onclick="goRegister()">¿No tienes cuenta? Regístrate</div>
</div>

<script>
function login() {
    fetch('/api/login', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            email: document.getElementById("email").value,
            password: document.getElementById("password").value
        })
    })
    .then(res => res.json())
    .then(data => {
        console.log(data)

        if(data.success)
        {
            localStorage.setItem("token", data.data.token)
            localStorage.setItem("name", data.data.name)
            localStorage.setItem("role", data.data.role)
            localStorage.setItem("image", data.data.image ?? "")

            window.location.href = "/home"
        }
        else
        {
            alert(data.message || "Error al hacer login")
        }
    })
    .catch(err => {
        console.error(err)
        alert("Error de conexión con el servidor")
    })
}

function goRegister() {
    window.location.href = "/register"
}
</script>

</body>
</html>
