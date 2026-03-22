<!DOCTYPE html>
<html>
<head>
    <title>Celdas - Jurassic Park</title>
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
        .btn-nav { background: #22c55e; border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer; color: black; font-weight: bold; }
        .btn-nav.purple { background: #6366f1; color: white; }
        .btn-nav.red    { background: #dc2626; color: white; }

        .container { padding: 40px; max-width: 1100px; margin: auto; }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        .page-header h2 { margin: 0; color: #facc15; }

        .btn-create { background: #22c55e; color: black; border: none; padding: 10px 18px; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 14px; }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .celda-card {
            background: rgba(0,0,0,0.6);
            border: 1px solid #22c55e;
            border-radius: 12px;
            padding: 20px;
            transition: all 0.2s;
        }
        .celda-card:hover { border-color: #facc15; background: rgba(0,0,0,0.8); }
        .celda-card h4 { color: #facc15; margin: 0 0 12px 0; font-size: 16px; }

        .badge { display: inline-block; padding: 3px 8px; border-radius: 10px; font-size: 12px; margin: 2px 0; }
        .badge-bajo     { background: #14532d; color: #86efac; }
        .badge-medio    { background: #713f12; color: #fde68a; }
        .badge-alto     { background: #7f1d1d; color: #fca5a5; }
        .badge-muy_alto { background: #6b21a8; color: #e9d5ff; }
        .badge-extremo  { background: #1e1b4b; color: #a5b4fc; }
        .badge-critico  { background: #450a0a; color: #ff6b6b; }

        .stat { display: flex; justify-content: space-between; margin: 8px 0; font-size: 14px; }
        .stat span:last-child { color: #22c55e; font-weight: bold; }

        .progress-bar { background: #1a2e1a; border-radius: 6px; height: 8px; margin: 4px 0 10px 0; }
        .progress-fill { height: 8px; border-radius: 6px; transition: width 0.3s; }

        .card-actions { display: flex; gap: 8px; margin-top: 14px; }
        .btn-edit   { background: #facc15; color: black; border: none; padding: 7px 12px; border-radius: 6px; cursor: pointer; flex: 1; font-weight: bold; }
        .btn-delete { background: #dc2626; color: white; border: none; padding: 7px 12px; border-radius: 6px; cursor: pointer; flex: 1; font-weight: bold; }

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
        input, select {
            width: 100%;
            padding: 10px;
            background: #020617;
            border: 1px solid #14532d;
            color: white;
            border-radius: 8px;
        }

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
        <button class="btn-nav purple" onclick="window.location.href='/dinosaurios'">🦖 Dinosaurios</button>
        <button class="btn-nav" onclick="window.location.href='/home'">🏠 Home</button>
    </div>
</div>

<div class="container">

    <div class="page-header">
        <h2>🏗️ Gestión de Celdas</h2>
        <button class="btn-create" onclick="showCreateForm()">➕ Nueva Celda</button>
    </div>

    <div class="grid" id="celdaGrid">
        <div class="empty">Cargando celdas...</div>
    </div>

    <div class="form-box" id="formBox" style="display:none">
        <h3 id="formTitle">➕ Nueva Celda</h3>

        <label>Nombre</label>
        <input id="fNombre" placeholder="Ej: Sector A1">

        <div class="form-row">
            <div>
                <label>Cantidad de animales</label>
                <input id="fAnimales" type="number" min="0" value="0">
            </div>
            <div>
                <label>Alimento (%)</label>
                <input id="fAlimento" type="number" min="0" max="100" value="100">
            </div>
        </div>

        <div class="form-row">
            <div>
                <label>Averías pendientes</label>
                <input id="fAverias" type="number" min="0" value="0">
            </div>
            <div>
                <label>Nivel de seguridad</label>
                <select id="fSeguridad">
                    <option value="bajo">Bajo</option>
                    <option value="medio" selected>Medio</option>
                    <option value="alto">Alto</option>
                </select>
            </div>
        </div>

        <label>Nivel de peligrosidad</label>
        <select id="fPeligrosidad">
            <option value="bajo">Bajo</option>
            <option value="medio">Medio</option>
            <option value="alto">Alto</option>
            <option value="muy_alto">Muy Alto</option>
            <option value="extremo">Extremo</option>
            <option value="critico">Crítico</option>
        </select>

        <div class="form-actions">
            <button class="btn-save" onclick="saveForm()">💾 Guardar</button>
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

let editingId = null

function getCeldas() {
    fetch('/api/celdas', { headers: { 'Authorization': 'Bearer ' + token } })
    .then(res => res.json())
    .then(data => renderCeldas(data))
    .catch(err => console.error(err))
}

function renderCeldas(celdas) {
    const grid = document.getElementById("celdaGrid")
    if (!celdas.length) {
        grid.innerHTML = '<div class="empty">🏗️ No hay celdas creadas aún</div>'
        return
    }
    grid.innerHTML = celdas.map(c => `
        <div class="celda-card">
            <h4>🏠 ${c.nombre}</h4>
            <span class="badge badge-${c.nivel_peligrosidad}">⚠️ ${c.nivel_peligrosidad.replace('_',' ')}</span>
            <span class="badge badge-${c.nivel_seguridad}">🔒 Seg: ${c.nivel_seguridad}</span>
            <div class="stat"><span>🦖 Animales</span><span>${c.cantidad_animales}</span></div>
            <div class="stat"><span>🍖 Alimento</span><span>${c.alimento}%</span></div>
            <div class="progress-bar">
                <div class="progress-fill" style="width:${c.alimento}%; background:${c.alimento > 50 ? '#22c55e' : c.alimento > 20 ? '#facc15' : '#dc2626'}"></div>
            </div>
            <div class="stat">
                <span>🔧 Averías</span>
                <span style="color:${c.averias_pendientes > 0 ? '#dc2626' : '#22c55e'}">${c.averias_pendientes}</span>
            </div>
            <div class="card-actions">
                <button class="btn-edit" onclick="editCelda(${c.id})">✏️ Editar</button>
                <button class="btn-delete" onclick="deleteCelda(${c.id}, '${c.nombre}')">❌ Eliminar</button>
            </div>
        </div>
    `).join('')
}

function showCreateForm() {
    editingId = null
    document.getElementById("formTitle").innerText    = "➕ Nueva Celda"
    document.getElementById("fNombre").value          = ""
    document.getElementById("fAnimales").value        = 0
    document.getElementById("fAlimento").value        = 100
    document.getElementById("fAverias").value         = 0
    document.getElementById("fSeguridad").value       = "medio"
    document.getElementById("fPeligrosidad").value    = "bajo"
    document.getElementById("formBox").style.display  = "block"
    document.getElementById("formBox").scrollIntoView({ behavior: 'smooth' })
}

function editCelda(id) {
    fetch(`/api/celdas/${id}`, { headers: { 'Authorization': 'Bearer ' + token } })
    .then(res => res.json())
    .then(c => {
        editingId = id
        document.getElementById("formTitle").innerText    = "✏️ Editar Celda"
        document.getElementById("fNombre").value          = c.nombre
        document.getElementById("fAnimales").value        = c.cantidad_animales
        document.getElementById("fAlimento").value        = c.alimento
        document.getElementById("fAverias").value         = c.averias_pendientes
        document.getElementById("fSeguridad").value       = c.nivel_seguridad
        document.getElementById("fPeligrosidad").value    = c.nivel_peligrosidad
        document.getElementById("formBox").style.display  = "block"
        document.getElementById("formBox").scrollIntoView({ behavior: 'smooth' })
    })
}

function saveForm() {
    const payload = {
        nombre:             document.getElementById("fNombre").value,
        cantidad_animales:  parseInt(document.getElementById("fAnimales").value),
        alimento:           parseInt(document.getElementById("fAlimento").value),
        averias_pendientes: parseInt(document.getElementById("fAverias").value),
        nivel_seguridad:    document.getElementById("fSeguridad").value,
        nivel_peligrosidad: document.getElementById("fPeligrosidad").value,
    }
    const url    = editingId ? `/api/celdas/${editingId}` : '/api/celdas'
    const method = editingId ? 'PUT' : 'POST'
    fetch(url, {
        method,
        headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) { alert(data.message); hideForm(); getCeldas() }
        else alert(data.message || "Error al guardar")
    })
}

function deleteCelda(id, nombre) {
    if (!confirm(`¿Eliminar la celda "${nombre}"?`)) return
    fetch(`/api/celdas/${id}`, {
        method: 'DELETE',
        headers: { 'Authorization': 'Bearer ' + token }
    })
    .then(res => res.json())
    .then(data => { alert(data.message); getCeldas() })
}

function hideForm() {
    document.getElementById("formBox").style.display = "none"
    editingId = null
}

getCeldas()
</script>
</body>
</html>
