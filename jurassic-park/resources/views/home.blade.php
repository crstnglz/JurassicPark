<!DOCTYPE html>
<html>
<head>
    <title>Jurassic Park</title>
    <style>
        * { box-sizing: border-box; }
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
        .logo { color: #facc15; font-weight: bold; font-size: 18px; }
        .nav-right { display: flex; align-items: center; gap: 10px; }
        .avatar { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid #22c55e; }
        .btn-profile { background: #22c55e; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; font-weight: bold; }
        .btn-logout  { background: #dc2626; padding: 6px 12px; border-radius: 6px; border: none; color: white; cursor: pointer; font-weight: bold; }

        .container { padding: 40px; max-width: 1100px; margin: auto; }

        /* BIENVENIDA */
        .welcome-card {
            background: rgba(0,0,0,0.6);
            padding: 25px 30px;
            border-radius: 16px;
            border: 1px solid #22c55e;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .welcome-card h2 { margin: 0; color: #facc15; }
        .role-badge { background: #064e3b; color: #86efac; padding: 6px 14px; border-radius: 20px; font-size: 14px; font-weight: bold; }

        /* STATS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }
        .stat-card { background: rgba(0,0,0,0.6); border: 1px solid #14532d; border-radius: 12px; padding: 20px; text-align: center; }
        .stat-card .stat-number { font-size: 36px; font-weight: bold; color: #22c55e; }
        .stat-card .stat-label  { font-size: 13px; color: #6b7280; margin-top: 4px; }
        .stat-card .stat-icon   { font-size: 28px; margin-bottom: 8px; }

        /* NAV CARDS */
        h3 { color: #facc15; margin-bottom: 15px; }
        .nav-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .nav-card {
            background: rgba(0,0,0,0.6);
            border: 1px solid #22c55e;
            border-radius: 16px;
            padding: 25px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .nav-card:hover { background: rgba(34,197,94,0.1); border-color: #facc15; transform: translateY(-3px); }
        .nav-card .nav-icon  { font-size: 40px; margin-bottom: 10px; }
        .nav-card .nav-title { font-size: 16px; font-weight: bold; color: #facc15; }
        .nav-card .nav-desc  { font-size: 12px; color: #6b7280; margin-top: 5px; }

        /* PANEL USUARIOS */
        .section { background: rgba(0,0,0,0.6); border: 1px solid #14532d; border-radius: 16px; padding: 25px; margin-bottom: 30px; }
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .section-header h3 { margin: 0; }

        .btn-green  { background: #22c55e; color: black; border: none; padding: 8px 14px; border-radius: 8px; cursor: pointer; font-weight: bold; }
        .btn-yellow { background: #facc15; color: black; border: none; padding: 8px 14px; border-radius: 8px; cursor: pointer; font-weight: bold; }
        .btn-red    { background: #dc2626; color: white; border: none; padding: 8px 14px; border-radius: 8px; cursor: pointer; font-weight: bold; }
        .btn-gray   { background: #6b7280; color: white; border: none; padding: 8px 14px; border-radius: 8px; cursor: pointer; }

        .user-card {
            background: rgba(0,0,0,0.4);
            border-left: 4px solid #22c55e;
            padding: 12px 15px;
            margin: 8px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 8px;
        }
        .user-info { display: flex; flex-direction: column; gap: 3px; }
        .user-name  { font-weight: bold; color: white; }
        .user-email { font-size: 12px; color: #6b7280; }
        .user-role  { font-size: 11px; background: #064e3b; color: #86efac; padding: 2px 8px; border-radius: 10px; display: inline-block; }

        .actions { display: flex; gap: 6px; }
        .actions button { padding: 5px 10px; border: none; border-radius: 6px; cursor: pointer; }

        .edit-box {
            background: rgba(0,0,0,0.5);
            border: 1px solid #facc15;
            padding: 20px;
            border-radius: 12px;
            margin-top: 15px;
            display: none;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            background: #020617;
            border: 1px solid #14532d;
            color: white;
            border-radius: 8px;
        }
        label { font-size: 13px; color: #86efac; display: block; margin-top: 10px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }

        .empty { text-align: center; color: #6b7280; padding: 20px; }

        /* WORKER PANEL */
        .worker-card {
            background: rgba(0,0,0,0.6);
            border: 1px solid #22c55e;
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            max-width: 400px;
            margin: 0 auto;
        }
        .worker-card:hover { background: rgba(34,197,94,0.1); border-color: #facc15; transform: translateY(-3px); }
        .worker-card .nav-icon  { font-size: 60px; margin-bottom: 15px; }
        .worker-card .nav-title { font-size: 22px; font-weight: bold; color: #facc15; }
        .worker-card .nav-desc  { font-size: 14px; color: #6b7280; margin-top: 8px; }
    </style>
</head>

<body>

<div class="navbar">
    <div class="logo">🦖 Jurassic Park</div>
    <div class="nav-right">
        <img id="navAvatar" class="avatar" src="https://dummyimage.com/35x35/000/fff">
        <button class="btn-profile" onclick="goProfile()">👤 Perfil</button>
        <button class="btn-logout" onclick="logout()">Logout</button>
    </div>
</div>

<div class="container">

    <!-- BIENVENIDA -->
    <div class="welcome-card">
        <h2 id="welcome"></h2>
        <span class="role-badge" id="roleBadge"></span>
    </div>

    <!-- STATS (solo admin) -->
    <div id="statsPanel" style="display:none">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-number" id="statUsuarios">-</div>
                <div class="stat-label">Usuarios</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🏗️</div>
                <div class="stat-number" id="statCeldas">-</div>
                <div class="stat-label">Celdas</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🦖</div>
                <div class="stat-number" id="statDinos">-</div>
                <div class="stat-label">Dinosaurios</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">📋</div>
                <div class="stat-number" id="statTareas">-</div>
                <div class="stat-label">Tareas activas</div>
            </div>
        </div>
    </div>

    <!-- ACCESO RÁPIDO ADMIN -->
    <div id="navPanel" style="display:none">
        <h3>⚡ Acceso Rápido</h3>
        <div class="nav-grid">
            <div class="nav-card" onclick="window.location.href='/celdas'">
                <div class="nav-icon">🏗️</div>
                <div class="nav-title">Gestionar Celdas</div>
                <div class="nav-desc">Crear, editar y eliminar celdas del parque</div>
            </div>
            <div class="nav-card" onclick="window.location.href='/dinosaurios'">
                <div class="nav-icon">🦖</div>
                <div class="nav-title">Gestionar Dinosaurios</div>
                <div class="nav-desc">Registrar y asignar dinosaurios a celdas</div>
            </div>
            <div class="nav-card" onclick="window.location.href='/tareas'">
                <div class="nav-icon">📋</div>
                <div class="nav-title">Gestionar Tareas</div>
                <div class="nav-desc">Asignar tareas a veterinarios y mantenimiento</div>
            </div>
        </div>
    </div>

    <!-- PANEL ADMIN USUARIOS -->
    <div id="adminPanel" style="display:none">

        <div class="section">
            <div class="section-header">
                <h3>👥 Usuarios</h3>
                <button class="btn-green" onclick="getUsers()">🔄 Cargar</button>
            </div>
            <div id="usersList"><div class="empty">Pulsa cargar para ver los usuarios</div></div>

            <div class="edit-box" id="editBox">
                <h3 style="color:#facc15; margin:0 0 15px 0">✏️ Editar usuario</h3>
                <div class="form-row">
                    <div>
                        <label>Nombre</label>
                        <input id="editName">
                    </div>
                    <div>
                        <label>Email</label>
                        <input id="editEmail">
                    </div>
                </div>
                <label>Rol</label>
                <select id="editRole">
                    <option value="admin">Admin</option>
                    <option value="veterinario">Veterinario</option>
                    <option value="mantenimiento">Mantenimiento</option>
                </select>
                <div style="display:flex; gap:10px; margin-top:15px">
                    <button class="btn-green" onclick="saveEdit()">💾 Guardar</button>
                    <button class="btn-gray" onclick="cancelEdit()">Cancelar</button>
                </div>
            </div>
        </div>

        <div class="section">
            <h3>➕ Crear Usuario</h3>
            <div class="form-row">
                <div>
                    <label>Nombre</label>
                    <input id="newName" placeholder="Nombre">
                </div>
                <div>
                    <label>Email</label>
                    <input id="newEmail" placeholder="Email">
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label>Contraseña</label>
                    <input id="newPassword" type="password" placeholder="Contraseña">
                </div>
                <div>
                    <label>Rol</label>
                    <select id="newRole">
                        <option value="admin">Admin</option>
                        <option value="veterinario">Veterinario</option>
                        <option value="mantenimiento">Mantenimiento</option>
                    </select>
                </div>
            </div>
            <button class="btn-yellow" style="margin-top:15px" onclick="createUser()">➕ Crear usuario</button>
        </div>

    </div>

    <!-- PANEL TRABAJADOR -->
    <div id="workerPanel" style="display:none">
        <div class="worker-card" onclick="window.location.href='/mis-tareas'">
            <div class="nav-icon">📋</div>
            <div class="nav-title">Mis Tareas</div>
            <div class="nav-desc">Ver y gestionar tus tareas asignadas</div>
        </div>
    </div>

</div>

<script>
const token = localStorage.getItem("token")
const role  = localStorage.getItem("role")
const name  = localStorage.getItem("name")
const image = localStorage.getItem("image")

let editingUserId = null

if (!token) window.location.href = "/login"

document.getElementById("welcome").innerText   = "Bienvenido, " + name
document.getElementById("roleBadge").innerText = "Rol: " + role

if (image) document.getElementById("navAvatar").src = image

if (role === "admin") {
    document.getElementById("adminPanel").style.display = "block"
    document.getElementById("statsPanel").style.display = "block"
    document.getElementById("navPanel").style.display   = "block"
    loadStats()
} else {
    document.getElementById("workerPanel").style.display = "block"
}

// ======== STATS ========
function loadStats() {
    fetch('/api/users',       { headers: { 'Authorization': 'Bearer ' + token } })
        .then(r => r.json()).then(d => document.getElementById("statUsuarios").innerText = d.length)

    fetch('/api/celdas',      { headers: { 'Authorization': 'Bearer ' + token } })
        .then(r => r.json()).then(d => document.getElementById("statCeldas").innerText = d.length)

    fetch('/api/dinosaurios', { headers: { 'Authorization': 'Bearer ' + token } })
        .then(r => r.json()).then(d => document.getElementById("statDinos").innerText = d.length)

    fetch('/api/tareas',      { headers: { 'Authorization': 'Bearer ' + token } })
        .then(r => r.json()).then(d => document.getElementById("statTareas").innerText =
            d.filter(t => t.estado !== 'completada').length)
}

// ======== USUARIOS ========
function getUsers() {
    fetch('/api/users', { headers: { 'Authorization': 'Bearer ' + token } })
    .then(res => res.json())
    .then(data => {
        usersList.innerHTML = data.map(user => `
            <div class="user-card">
                <div class="user-info">
                    <span class="user-name">${user.name}</span>
                    <span class="user-email">${user.email}</span>
                    <span class="user-role">${user.role}</span>
                </div>
                <div class="actions">
                    <button class="btn-yellow" onclick="editUser(${user.id}, '${user.name}', '${user.email}', '${user.role}')">✏️</button>
                    <button class="btn-red" onclick="deleteUser(${user.id})">❌</button>
                </div>
            </div>
        `).join('')
    })
}

function createUser() {
    fetch('/api/users', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token },
        body: JSON.stringify({
            name:     newName.value,
            email:    newEmail.value,
            password: newPassword.value,
            role:     newRole.value
        })
    }).then(() => {
        getUsers()
        loadStats()
        newName.value = ""
        newEmail.value = ""
        newPassword.value = ""
    })
}

function deleteUser(id) {
    if (!confirm("¿Eliminar este usuario?")) return
    fetch(`/api/users/${id}`, {
        method: 'DELETE',
        headers: { 'Authorization': 'Bearer ' + token }
    }).then(() => { getUsers(); loadStats() })
}

function editUser(id, name, email, role) {
    editingUserId   = id
    editName.value  = name
    editEmail.value = email
    editRole.value  = role
    editBox.style.display = "block"
}

function saveEdit() {
    fetch(`/api/users/${editingUserId}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token },
        body: JSON.stringify({ name: editName.value, email: editEmail.value, role: editRole.value })
    }).then(() => { editBox.style.display = "none"; getUsers() })
}

function cancelEdit() { editBox.style.display = "none" }

// ======== NAV ========
function goProfile() { window.location.href = "/profile" }

function logout() {
    fetch('/api/logout', {
        method: 'POST',
        headers: { 'Authorization': 'Bearer ' + token }
    }).then(() => { localStorage.clear(); window.location.href = "/login" })
}
</script>

</body>
</html>
