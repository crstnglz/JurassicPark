<!DOCTYPE html>
<html>
<head>
    <title>Perfil - Jurassic Park</title>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #052e16, #020617);
            color: white;
        }

        .navbar {
            background: rgba(0,0,0,0.7);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            border-bottom: 2px solid #22c55e;
        }

        .logo {
            color: #facc15;
            font-weight: bold;
        }

        .back {
            background: #22c55e;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90vh;
        }

        .box {
            background: rgba(0,0,0,0.6);
            padding: 30px;
            border-radius: 16px;
            border: 1px solid #22c55e;
            width: 350px;
            text-align: center;
        }

        img {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            border: 2px solid #22c55e;
            object-fit: cover;
            margin-bottom: 10px;
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
            margin-top: 10px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .pass { background: #22c55e; }
        .avatar { background: #facc15; color: black; }
    </style>
</head>

<body>

<div class="navbar">
    <div class="logo">🦖 Jurassic Park</div>
    <button class="back" onclick="goHome()">← Volver</button>
</div>

<div class="container">

    <div class="box">

        <h2>👤 Mi Perfil</h2>

        <img id="avatarImg" src="">

        <p id="name"></p>
        <p id="role"></p>

        <!-- 🔐 PASSWORD -->
        <h3>🔐 Cambiar contraseña</h3>
        <input type="password" id="currentPassword" placeholder="Contraseña actual">
        <input type="password" id="newPassword" placeholder="Nueva contraseña">
        <input type="password" id="confirmPassword" placeholder="Confirmar contraseña">

        <button class="pass" onclick="updatePassword()">Actualizar contraseña</button>

        <!-- 🖼️ IMAGE -->
        <h3>🖼️ Imagen de perfil</h3>
        <input type="file" id="image">

        <button class="avatar" onclick="updateImage()">Subir imagen</button>

    </div>

</div>

<script>
const token = localStorage.getItem("token")
const name = localStorage.getItem("name")
const role = localStorage.getItem("role")
const image = localStorage.getItem("image")

if (!token) window.location.href = "/login"

document.getElementById("name").innerText = name
document.getElementById("role").innerText = "Rol: " + role

if (image) {
    document.getElementById("avatarImg").src = image
}

// 🔐 PASSWORD
function updatePassword() {
    fetch('/api/update-password', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token
        },
        body: JSON.stringify({
            current_password: document.getElementById("currentPassword").value,
            new_password: document.getElementById("newPassword").value,
            new_password_confirmation: document.getElementById("confirmPassword").value
        })
    })
    .then(res => res.json())
    .then(data => {
        console.log(data)

        if (data.message) {
            alert(data.message)
        } else {
            alert("Error al actualizar contraseña")
        }
    })
    .catch(err => console.error(err))
}

// 🖼️ IMAGE CLOUDINARY
function updateImage() {
    const file = document.getElementById("image").files[0]

    if (!file) {
        alert("Selecciona una imagen")
        return
    }

    const formData = new FormData()
    formData.append('image', file)

    fetch('/api/subircloud', {
        method: 'POST',
        headers: {
            'Authorization': 'Bearer ' + token
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        console.log(data)

        if (data.url) {
            document.getElementById("avatarImg").src = data.url
            localStorage.setItem("image", data.url)
            alert("Imagen actualizada 🖼️")
        } else {
            alert("Error al subir imagen")
        }
    })
    .catch(err => console.error(err))
}

// 🔙 VOLVER
function goHome() {
    window.location.href = "/home"
}
</script>

</body>
</html>
