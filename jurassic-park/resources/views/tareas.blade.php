<!DOCTYPE html>
<html>
<head>
    <title>Tareas - Jurassic Park</title>
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
        .btn-nav { border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer; font-weight: bold; }
        .btn-nav.green  { background: #22c55e; color: black; }
        .btn-nav.purple { background: #6366f1; color: white; }
        .btn-nav.yellow { background: #facc15; color: black; }

        .container { padding: 40px; max-width: 1100px; margin: auto; }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        .page-header h2 { margin: 0; color: #facc15; }

        .btn-create { background: #22c55e; color: black; border: none; padding: 10px 18px; border-radius: 8px; cursor: pointer; font-weight: bold; }

        /* FILTROS */
        .filtros {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .filtro-btn {
            border: none;
            padding: 7px 14px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
            opacity: 0.6;
            transition: opacity 0.2s;
        }
        .filtro-btn.active { opacity: 1; }
        .filtro-btn.todos       { background: #374151; color: white; }
        .filtro-btn.pendiente   { background: #713f12; color: #fde68a; }
        .filtro-btn.en_progreso { background: #1e3a5f; color: #93c5fd; }
        .filtro-btn.completada  { background: #14532d; color: #86efac; }

        /* GRID TAREAS */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .tarea-card {
            background: rgba(0,0,0,0.6);
            border-radius: 12px;
            padding: 20px;
            transition: all 0.2s;
        }
        .tarea-card.pendiente   { border-left: 4px solid #facc15; }
        .tarea-card.en_progreso { border-left: 4px solid #3b82f6; }
        .tarea-card.completada  { border-left: 4px solid #22c55e; opacity: 0.7; }
        .tarea-card:hover { background: rgba(0,0,0,0.8); }

        .tarea-card h4 { color: #facc15; margin: 0 0 10px 0; }

        .badge { display: inline-block; padding: 3px 10px; border-radius: 10px; font-size: 12px; margin: 2px 0; font-weight: bold; }
        .badge-pendiente   { background: #713f12; color: #fde68a; }
        .badge-en_progreso { background: #1e3a5f; color: #93c5fd; }
        .badge-completada  { background: #14532d; color: #86efac; }
        .badge-veterinario   { background: #064e3b; color: #86efac; }
        .badge-mantenimiento { background: #312e81; color: #c7d2fe; }

        .stat { display: flex; justify-content: space-between; margin: 8px 0; font-size: 14px; }
        .stat span:last-child { color: #22c55e; font-weight: bold; }

        .card-actions { display: flex; gap: 8px; margin-top: 14px; }
        .btn-delete { background: #dc2626; color: white; border: none; padding: 7px 12px; border-radius: 6px; cursor: pointer; flex: 1; font-weight: bold; }

        /* FORMULARIO */
        .form-box {
            background: rgba(0,0,0,0.7);
            border: 1px solid #facc15;
            border-radius: 12px;
            padding: 25px;
            margin-top: 30px;
        }
        .form-box h3 { color: #facc15; margin: 0 0 20px 0; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        label { font-size: 13px; color: #86efac; display: block; margin-top: 12px; margin-bottom: 4px; }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            background: #020617;
            border: 1px solid #14532d;
            color: white;
            border-radius: 8px;
        }
        textarea { resize: vertical; min-height: 80px; }
        .form-actions { display: flex; gap: 10px; margin-top: 20px; }
        .btn-save   { background: #22c55e; color: black; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: bold; }
        .btn-cancel { background: #6b7280; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; }

        .empty { text-align: center; color: #6b7280; padding: 60px; font-size: 16px; }
    </style>
</head>
<body>

<div class="navbar">
    <div class="logo">🦖 Jurassic Park</div>
    <div class="nav-right">
        <img id="navAvatar" class="avatar" src="https://dummyimage.com/35x35/000/fff">
        <button class="btn-nav purple" onclick="window.location.href='/celdas'">🏗️ Celdas</button>
        <button class="btn-nav yellow" onclick="window.location.href='/dinosaurios'">🦖 Dinosaurios</button>
        <button class="btn-nav green" onclick="window.location.href='/home'">🏠 Home</button>
    </div>
</div>

<div class="container">

    <div class="page-header">
        <h2>📋 Gestión de Tareas</h2>
        <button class="btn-create" onclick="showCreateForm()">➕ Asignar Tarea</button>
    </div>

    <!-- FILTROS -->
    <div class="filtros">
        <button class="filtro-btn todos active" onclick="filtrar('todos')">📋 Todas</button>
        <button class="filtro-btn pendiente" onclick="filtrar('pendiente')">⏳ Pendientes</button>
        <button class="filtro-btn en_progreso" onclick="filtrar('en_progreso')">🔄 En progreso</button>
        <button class="filtro-btn completada" onclick="filtrar('completada')">✅ Completadas</button>
    </div>

    <div class="grid" id="tareasGrid">
        <div class="empty">Cargando tareas...</div>
    </div>

    <!-- FORMULARIO ASIGNAR -->
    <div class="form-box" id="formBox" style="display:none">
        <h3>➕ Asignar Tarea</h3>

        <div class="form-row">
            <div>
                <label>Trabajador</label>
                <select id="fUser">
                    <option value="">Selecciona trabajador</option>
                </select>
            </div>
            <div>
                <label>Celda</label>
                <select id="fCelda">
                    <option value="">Selecciona celda</option>
                </select>
            </div>
        </div>

        <label>Tipo de tarea</label>
        <select id="fTipo">
            <option value="veterinario">🩺 Veterinario</option>
            <option value="mantenimiento">🔧 Mantenimiento</option>
        </select>

        <label>Descripción (opcional)</label>
        <textarea id="fDescripcion" placeholder="Describe la tarea..."></textarea>

        <div class="form-actions">
            <button class="btn-save" onclick="saveForm()">💾 Asignar</button>
            <button class="btn-cancel" onclick="hideForm()">Cancelar</button>
        </div>
    </div>

</div>

<script>
const token = localStorage.getItem("token")
const role  = localStorage.getItem("role")
const image = localStorage.getItem("image")

if (!token) window.location.href = "/login"
if (role !== "admin") window.location.href = "/home"
if (image) document.getElementById("navAvatar").src = image

let todasTareas = []
let filtroActual = 'todos'

function getTareas() {
    fetch('/api/tareas', { headers: { 'Authorization': 'Bearer ' + token } })
    .then(res => res.json())
    .then(data => { todasTareas = data; renderTareas(data) })
    .catch(err => console.error(err))
}

function renderTareas(tareas) {
    const grid = document.getElementById("tareasGrid")
    if (!tareas.length) {
        grid.innerHTML = '<div class="empty">📋 No hay tareas asignadas aún</div>'
        return
    }
    grid.innerHTML = tareas.map(t => `
        <div class="tarea-card ${t.estado}">
            <h4>📋 ${t.celda ? t.celda.nombre : 'Sin celda'}</h4>
            <span class="badge badge-${t.estado}">
                ${t.estado === 'pendiente' ? '⏳' : t.estado === 'en_progreso' ? '🔄' : '✅'}
                ${t.estado.replace('_', ' ')}
            </span>
            <span class="badge badge-${t.tipo}">
                ${t.tipo === 'veterinario' ? '🩺' : '🔧'} ${t.tipo}
            </span>
            <div class="stat"><span>👤 Trabajador</span><span>${t.usuario ? t.usuario.name : '-'}</span></div>
            ${t.descripcion ? `<div class="stat"><span>📝 Desc.</span><span>${t.descripcion}</span></div>` : ''}
            <div class="card-actions">
                <button class="btn-delete" onclick="deleteTarea(${t.id})">❌ Eliminar</button>
            </div>
        </div>
    `).join('')
}

function filtrar(estado) {
    filtroActual = estado
    document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('active'))
    document.querySelector(`.filtro-btn.${estado}`).classList.add('active')
    if (estado === 'todos') renderTareas(todasTareas)
    else renderTareas(todasTareas.filter(t => t.estado === estado))
}

function loadWorkers() {
    fetch('/api/users', { headers: { 'Authorization': 'Bearer ' + token } })
    .then(res => res.json())
    .then(users => {
        const select  = document.getElementById("fUser")
        const workers = users.filter(u => u.role !== 'admin')
        select.innerHTML = '<option value="">Selecciona trabajador</option>' +
            workers.map(u => `<option value="${u.id}">${u.name} (${u.role})</option>`).join('')
    })
}

function loadCeldas() {
    fetch('/api/celdas', { headers: { 'Authorization': 'Bearer ' + token } })
    .then(res => res.json())
    .then(celdas => {
        const select = document.getElementById("fCelda")
        select.innerHTML = '<option value="">Selecciona celda</option>' +
            celdas.map(c => `<option value="${c.id}">${c.nombre}</option>`).join('')
    })
}

function showCreateForm() {
    loadWorkers()
    loadCeldas()
    document.getElementById("fTipo").value        = "veterinario"
    document.getElementById("fDescripcion").value = ""
    document.getElementById("formBox").style.display = "block"
    document.getElementById("formBox").scrollIntoView({ behavior: 'smooth' })
}

function saveForm() {
    const payload = {
        user_id:     document.getElementById("fUser").value,
        celda_id:    document.getElementById("fCelda").value,
        tipo:        document.getElementById("fTipo").value,
        descripcion: document.getElementById("fDescripcion").value || null,
    }

    if (!payload.user_id || !payload.celda_id) {
        alert("Selecciona un trabajador y una celda")
        return
    }

    fetch('/api/tareas', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) { alert(data.message); hideForm(); getTareas() }
        else alert(data.message || "Error al asignar tarea")
    })
}

function deleteTarea(id) {
    if (!confirm("¿Eliminar esta tarea?")) return
    fetch(`/api/tareas/${id}`, {
        method: 'DELETE',
        headers: { 'Authorization': 'Bearer ' + token }
    })
    .then(res => res.json())
    .then(data => { alert(data.message); getTareas() })
}

function hideForm() {
    document.getElementById("formBox").style.display = "none"
}

getTareas()
</script>
</body>
</html>
