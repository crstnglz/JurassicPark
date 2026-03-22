<!DOCTYPE html>
<html>
<head>
    <title>Mis Tareas - Jurassic Park</title>
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
        .btn-nav.green { background: #22c55e; color: black; }

        .container { padding: 40px; max-width: 900px; margin: auto; }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        .page-header h2 { margin: 0; color: #facc15; }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }
        .stat-card {
            background: rgba(0,0,0,0.6);
            border-radius: 12px;
            padding: 15px;
            text-align: center;
        }
        .stat-number { font-size: 28px; font-weight: bold; }
        .stat-label  { font-size: 12px; color: #6b7280; margin-top: 4px; }
        .stat-card.pendiente   .stat-number { color: #facc15; }
        .stat-card.en_progreso .stat-number { color: #3b82f6; }
        .stat-card.completada  .stat-number { color: #22c55e; }

        .filtros { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; }
        .filtro-btn { border: none; padding: 7px 14px; border-radius: 20px; cursor: pointer; font-size: 13px; font-weight: bold; opacity: 0.6; transition: opacity 0.2s; }
        .filtro-btn.active { opacity: 1; }
        .filtro-btn.todos       { background: #374151; color: white; }
        .filtro-btn.pendiente   { background: #713f12; color: #fde68a; }
        .filtro-btn.en_progreso { background: #1e3a5f; color: #93c5fd; }
        .filtro-btn.completada  { background: #14532d; color: #86efac; }

        .tarea-card {
            background: rgba(0,0,0,0.6);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.2s;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }
        .tarea-card.pendiente   { border-left: 4px solid #facc15; }
        .tarea-card.en_progreso { border-left: 4px solid #3b82f6; }
        .tarea-card.completada  { border-left: 4px solid #22c55e; opacity: 0.7; }

        .tarea-info h4 { color: #facc15; margin: 0 0 8px 0; }

        .badge { display: inline-block; padding: 3px 10px; border-radius: 10px; font-size: 12px; margin: 2px 0; font-weight: bold; }
        .badge-pendiente     { background: #713f12; color: #fde68a; }
        .badge-en_progreso   { background: #1e3a5f; color: #93c5fd; }
        .badge-completada    { background: #14532d; color: #86efac; }
        .badge-veterinario   { background: #064e3b; color: #86efac; }
        .badge-mantenimiento { background: #312e81; color: #c7d2fe; }

        .tarea-desc { font-size: 13px; color: #9ca3af; margin-top: 6px; }

        .tarea-actions { display: flex; flex-direction: column; gap: 8px; min-width: 140px; }
        .btn-progreso  { background: #3b82f6; color: white; border: none; padding: 8px 12px; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 13px; }
        .btn-completar { background: #22c55e; color: black; border: none; padding: 8px 12px; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 13px; }
        .btn-disabled  { background: #1f2937; color: #6b7280; border: none; padding: 8px 12px; border-radius: 8px; font-size: 13px; cursor: not-allowed; }

        .empty { text-align: center; color: #6b7280; padding: 60px; font-size: 16px; }
    </style>
</head>
<body>

<div class="navbar">
    <div class="logo">🦖 Jurassic Park</div>
    <div class="nav-right">
        <img id="navAvatar" class="avatar" src="https://dummyimage.com/35x35/000/fff">
        <button class="btn-nav green" onclick="window.location.href='/home'">🏠 Home</button>
    </div>
</div>

<div class="container">

    <div class="page-header">
        <h2>📋 Mis Tareas</h2>
    </div>

    <!-- STATS -->
    <div class="stats-row">
        <div class="stat-card pendiente">
            <div class="stat-number" id="statPendiente">-</div>
            <div class="stat-label">⏳ Pendientes</div>
        </div>
        <div class="stat-card en_progreso">
            <div class="stat-number" id="statProgreso">-</div>
            <div class="stat-label">🔄 En progreso</div>
        </div>
        <div class="stat-card completada">
            <div class="stat-number" id="statCompletada">-</div>
            <div class="stat-label">✅ Completadas</div>
        </div>
    </div>

    <!-- FILTROS -->
    <div class="filtros">
        <button class="filtro-btn todos active" onclick="filtrar('todos')">📋 Todas</button>
        <button class="filtro-btn pendiente" onclick="filtrar('pendiente')">⏳ Pendientes</button>
        <button class="filtro-btn en_progreso" onclick="filtrar('en_progreso')">🔄 En progreso</button>
        <button class="filtro-btn completada" onclick="filtrar('completada')">✅ Completadas</button>
    </div>

    <div id="tareasList">
        <div class="empty">Cargando tareas...</div>
    </div>

</div>

<script>
const token = localStorage.getItem("token")
const role  = localStorage.getItem("role")
const image = localStorage.getItem("image")

if (!token) window.location.href = "/login"
if (role === "admin") window.location.href = "/home"
if (image) document.getElementById("navAvatar").src = image

let todasTareas = []

function getTareas() {
    fetch('/api/tareas', { headers: { 'Authorization': 'Bearer ' + token } })
    .then(res => res.json())
    .then(data => {
        todasTareas = data
        updateStats(data)
        renderTareas(data)
    })
    .catch(err => console.error(err))
}

function updateStats(tareas) {
    document.getElementById("statPendiente").innerText = tareas.filter(t => t.estado === 'pendiente').length
    document.getElementById("statProgreso").innerText  = tareas.filter(t => t.estado === 'en_progreso').length
    document.getElementById("statCompletada").innerText = tareas.filter(t => t.estado === 'completada').length
}

function renderTareas(tareas) {
    const list = document.getElementById("tareasList")
    if (!tareas.length) {
        list.innerHTML = '<div class="empty">✅ No tienes tareas asignadas</div>'
        return
    }
    list.innerHTML = tareas.map(t => `
        <div class="tarea-card ${t.estado}">
            <div class="tarea-info">
                <h4>🏠 ${t.celda ? t.celda.nombre : 'Sin celda'}</h4>
                <span class="badge badge-${t.estado}">
                    ${t.estado === 'pendiente' ? '⏳' : t.estado === 'en_progreso' ? '🔄' : '✅'}
                    ${t.estado.replace('_', ' ')}
                </span>
                <span class="badge badge-${t.tipo}">
                    ${t.tipo === 'veterinario' ? '🩺' : '🔧'} ${t.tipo}
                </span>
                ${t.descripcion ? `<div class="tarea-desc">📝 ${t.descripcion}</div>` : ''}
            </div>
            <div class="tarea-actions">
                ${t.estado === 'pendiente' ? `
                    <button class="btn-progreso" onclick="cambiarEstado(${t.id}, 'en_progreso')">🔄 Iniciar</button>
                ` : t.estado === 'en_progreso' ? `
                    <button class="btn-completar" onclick="cambiarEstado(${t.id}, 'completada')">✅ Completar</button>
                ` : `
                    <button class="btn-disabled" disabled>✅ Completada</button>
                `}
            </div>
        </div>
    `).join('')
}

function filtrar(estado) {
    document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('active'))
    document.querySelector(`.filtro-btn.${estado}`).classList.add('active')
    if (estado === 'todos') renderTareas(todasTareas)
    else renderTareas(todasTareas.filter(t => t.estado === estado))
}

function cambiarEstado(id, estado) {
    fetch(`/api/tareas/${id}/estado`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token },
        body: JSON.stringify({ estado })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) getTareas()
        else alert(data.message || "Error al actualizar")
    })
}

getTareas()
</script>
</body>
</html>
