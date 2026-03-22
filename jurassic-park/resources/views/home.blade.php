<!DOCTYPE html>
<html>
<head>
    <title>Jurassic Park</title>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #052e16, #020617);
            color: #e5e7eb;
        }

        .navbar {
            background: rgba(0,0,0,0.7);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #22c55e;
        }

        .logo {
            color: #facc15;
            font-weight: bold;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #22c55e;
        }

        .profile-btn {
            background: #22c55e;
            padding: 6px 10px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
        }

        .logout {
            background: #dc2626;
            padding: 6px 10px;
            border-radius: 6px;
            border: none;
            color: white;
            cursor: pointer;
        }

        .container {
            padding: 40px;
            max-width: 900px;
            margin: auto;
        }

        .card {
            background: rgba(0,0,0,0.6);
            padding: 25px;
            border-radius: 16px;
            border: 1px solid #22c55e;
            text-align: center;
        }

        .role {
            margin-top: 10px;
            background: #064e3b;
            padding: 10px;
            border-radius: 8px;
        }

        .admin-panel {
            margin-top: 40px;
            display: none;
        }

        h3 {
            color: #facc15;
        }

        .user-card {
            background: rgba(0,0,0,0.6);
            border-left: 4px solid #22c55e;
            padding: 10px;
            margin: 10px 0;
            display: flex;
            justify-content: space-between;
            border-radius: 8px;
        }

        .actions button {
            margin-left: 5px;
            padding: 5px 8px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit { background: #facc15; color: black; }
        .delete { background: #dc2626; color: white; }

        .load { background: #22c55e; padding: 8px; margin-top: 10px; }
        .create { background: #facc15; padding: 10px; margin-top: 10px; }

        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 10px;
            background: #020617;
            border: 1px solid #14532d;
            color: white;
            border-radius: 6px;
        }

        .edit-box {
            background: rgba(0,0,0,0.7);
            border: 1px solid #facc15;
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
            display: none;
        }

        .save { background: #22c55e; margin-top: 10px; }
        .cancel { background: #dc2626; margin-top: 5px; }
    </style>
</head>

<body>

<div class="navbar">
    <div class="logo">🦖 Jurassic Park</div>

    <div class="nav-right">
        <img id="navAvatar" class="avatar" src="https://dummyimage.com/35x35/000/fff">

        <button class="profile-btn" onclick="goProfile()">Perfil</button>
        <button class="logout" onclick="logout()">Logout</button>
    </div>
</div>

<div class="container">

    <div class="card">
        <h2 id="welcome"></h2>
        <div class="role" id="role"></div>
    </div>

    <div class="admin-panel" id="adminPanel">

        <h3>👥 Usuarios</h3>
        <button class="load" onclick="getUsers()">Cargar usuarios</button>

        <div id="usersList"></div>

        <!-- EDIT -->
        <div class="edit-box" id="editBox">
            <h3>✏️ Editar usuario</h3>

            <input id="editName">
            <input id="editEmail">

            <select id="editRole">
                <option value="admin">Admin</option>
                <option value="veterinario">Veterinario</option>
                <option value="mantenimiento">Mantenimiento</option>
            </select>

            <button class="save" onclick="saveEdit()">Guardar</button>
            <button class="cancel" onclick="cancelEdit()">Cancelar</button>
        </div>

        <h3>➕ Crear usuario</h3>

        <input id="newName">
        <input id="newEmail">
        <input id="newPassword">

        <select id="newRole">
            <option value="admin">Admin</option>
            <option value="veterinario">Veterinario</option>
            <option value="mantenimiento">Mantenimiento</option>
        </select>

        <button class="create" onclick="createUser()">Crear usuario</button>

    </div>

</div>

<script>
const token = localStorage.getItem("token")
const role = localStorage.getItem("role")
const name = localStorage.getItem("name")
const avatar = localStorage.getItem("avatar")

let editingUserId = null

if (!token) window.location.href = "/login"

welcome.innerText = "Bienvenido, " + name
role.innerText = "Rol: " + role

if (avatar) {
    document.getElementById("navAvatar").src = avatar
}

if (role === "admin") adminPanel.style.display = "block"

function goProfile() {
    window.location.href = "/profile"
}

// LOGOUT
function logout() {
    fetch('/api/logout', {
        method: 'POST',
        headers: { 'Authorization': 'Bearer ' + token }
    }).then(() => {
        localStorage.clear()
        window.location.href = "/login"
    })
}

// GET USERS
function getUsers() {
    fetch('/api/users', {
        headers: { 'Authorization': 'Bearer ' + token }
    })
    .then(res => res.json())
    .then(data => {
        usersList.innerHTML = data.map(user => `
            <div class="user-card">
                ${user.name} (${user.role})
                <div class="actions">
                    <button class="edit" onclick="editUser(${user.id}, '${user.name}', '${user.email}', '${user.role}')">✏️</button>
                    <button class="delete" onclick="deleteUser(${user.id})">❌</button>
                </div>
            </div>
        `).join('')
    })
}

// CREATE
function createUser() {
    fetch('/api/users', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token
        },
        body: JSON.stringify({
            name: newName.value,
            email: newEmail.value,
            password: newPassword.value,
            role: newRole.value
        })
    }).then(() => getUsers())
}

// DELETE
function deleteUser(id) {
    fetch(`/api/users/${id}`, {
        method: 'DELETE',
        headers: { 'Authorization': 'Bearer ' + token }
    }).then(() => getUsers())
}

// EDIT
function editUser(id, name, email, role) {
    editingUserId = id

    editName.value = name
    editEmail.value = email
    editRole.value = role

    editBox.style.display = "block"
}

// SAVE
function saveEdit() {
    fetch(`/api/users/${editingUserId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token
        },
        body: JSON.stringify({
            name: editName.value,
            email: editEmail.value,
            role: editRole.value
        })
    })
    .then(() => {
        editBox.style.display = "none"
        getUsers()
    })
}

// CANCEL
function cancelEdit() {
    editBox.style.display = "none"
}
</script>

</body>
</html>
