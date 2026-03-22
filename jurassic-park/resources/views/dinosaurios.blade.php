<!DOCTYPE html>
<html>
<head>
    <title>Dinosaurios - Jurassic Park</title>
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

        .dino-card {
            background: rgba(0,0,0,0.6);
            border: 1px solid #22c55e;
            border-radius: 12px;
            padding: 20px;
            transition: all 0.2s;
        }
        .dino-card:hover { border-color: #facc15; background: rgba(0,0,0,0.8); }
        .dino-card h4 { color: #facc15; margin: 0 0 12px 0; font-size: 16px; }

        .badge { display: inline-block; padding: 3px 8px; border-radius: 10px; font-size: 12px; margin: 2px 0; }
        .badge-bajo      { background: #14532d; color: #86efac; }
        .badge-medio     { background: #713f12; color: #fde68a; }
        .badge-alto      { background: #7f1d1d; color: #fca5a5; }
        .badge-muy_alto  { background: #6b21a8; color: #e9d5ff; }
        .badge-extremo   { background: #1e1b4b; color: #a5b4fc; }
        .badge-critico   { background: #450a0a; color: #ff6b6b; }
        .badge-herbivoro { background: #14532d; color: #86efac; }
        .badge-omnivoro  { background: #713f12; color: #fde68a; }
        .badge-carnivoro { background: #7f1d1d; color: #fca5a5; }

        .stat { display: flex; justify-content: space-between; margin: 8px 0; font-size: 14px; }
        .stat span:last-child { color: #22c55e; font-weight: bold; }

        .card-actions { display: flex; gap: 8px; margin-top: 14px; }
        .btn-edit    { background: #facc15; color: black; border: none; padding: 7px 12px; border-radius: 6px; cursor: pointer; flex: 1; font-weight: bold; }
        .btn-delete  { background: #dc2626; color: white; border: none; padding: 7px 12px; border-radius: 6px; cursor: pointer; flex: 1; font-weight: bold; }
        .btn-asignar { background: #6366f1; color: white; border: none; padding: 7px 12px; border-radius: 6px; cursor: pointer; flex: 1; font-weight: bold; }

        .celda-tag  { background: #064e3b; color: #86efac; padding: 3px 8px; border-radius: 10px; font-size: 12px; }
        .sin-celda  { background: #1f2937; color: #6b7280; padding: 3px 8px; border-radius: 10px; font-size: 12px; }

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
        <button class="btn-nav purple" onclick="window.location.href='/celdas'">🏗️ Celdas</button>
        <button class="btn-nav green" onclick="window.location.href='/home'">🏠 Home</button>
    </div>
</div>

<div class="container">

    <div class="page-header">
        <h2>🦖 Gestión de Dinosaurios</h2>
        <button class="btn-create" onclick="showCreateForm()">➕ Nuevo Dinosaurio</button>
    </div>

    <div class="grid" id="dinoGrid">
        <div class="empty">Cargando dinosaurios...</div>
    </div>

    <!-- FORMULARIO CREAR / EDITAR -->
    <div class="form-box" id="formBox" style="display:none">
        <h3 id="formTitle">➕ Nuevo Dinosaurio</h3>

        <div class="form-row">
            <div>
                <label>Nick</label>
                <input id="fNick" placeholder="Ej: Rex">
            </div>
            <div>
                <label>Edad</label>
                <input id="fEdad" type="number" min="0" value="0">
            </div>
        </div>

        <label>Raza</label>
        <select id="fRaza">
            <optgroup label="🌿 Herbívoros">
                <option value="Triceratops">Triceratops</option>
                <option value="Brachiosaurus">Brachiosaurus</option>
                <option value="Stegosaurus">Stegosaurus</option>
                <option value="Ankylosaurus">Ankylosaurus</option>
                <option value="Parasaurolophus">Parasaurolophus</option>
                <option value="Gallimimus">Gallimimus</option>
            </optgroup>
            <optgroup label="🍖 Omnívoros">
                <option value="Oviraptor">Oviraptor</option>
                <option value="Ornitholestes">Ornitholestes</option>
                <option value="Therizinosaurus">Therizinosaurus</option>
            </optgroup>
            <optgroup label="🔴 Carnívoros">
                <option value="Velociraptor">Velociraptor</option>
                <option value="Dilophosaurus">Dilophosaurus</option>
                <option value="Carnotaurus">Carnotaurus</option>
                <option value="Allosaurus">Allosaurus</option>
                <option value="Tyrannosaurus rex">Tyrannosaurus rex</option>
                <option value="Spinosaurus">Spinosaurus</option>
                <option value="Giganotosaurus">Giganotosaurus</option>
                <option value="Indominus rex">Indominus rex</option>
            </optgroup>
        </select>

        <div class="form-row">
            <div>
                <label>Nivel de peligrosidad</label>
                <select id="fPeligrosidad">
                    <option value="bajo">Bajo</option>
                    <option value="medio">Medio</option>
                    <option value="alto">Alto</option>
                    <option value="muy_alto">Muy Alto</option>
                    <option value="extremo">Extremo</option>
                    <option value="critico">Crítico</option>
                </select>
            </div>
            <div>
                <label>Dieta</label>
                <select id="fDieta">
                    <option value="herbivoro">🌿 Herbívoro</option>
                    <option value="omnivoro">🍖 Omnívoro</option>
                    <option value="carnivoro">🔴 Carnívoro</option>
                </select>
            </div>
        </div>

        <label>Celda (opcional)</label>
        <select id="fCelda">
            <option value="">Sin celda</option>
        </select>

        <div class="form-actions">
            <button class="btn-save" onclick="saveForm()">💾 Guardar</button>
            <button class="btn-cancel" onclick="hideForm()">Cancelar</button>
        </div>
    </div>

    <!-- FORMULARIO ASIGNAR -->
    <div class="form-box" id="asignarBox" style="display:none">
        <h3>🏠 Asignar a Celda</h3>
        <p id="asignarDinoNick" style="color:#facc15; margin:0 0 15px 0; font-size:16px"></p>

        <label>Selecciona celda</label>
        <select id="asignarCelda">
            <option value="">Sin celda</option>
        </select>

        <div class="form-actions">
            <button class="btn-save" onclick="saveAsignar()">💾 Asignar</button>
            <button class="btn-cancel" onclick="hideAsignar()">Cancelar</button>
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

let editingId   = null
let asignandoId = null

function getDinos() {
    fetch('/api/dinosaurios', { headers: { 'Authorization': 'Bearer ' + token } })
    .then(res => res.json())
    .then(data => renderDinos(data))
    .catch(err => console.error(err))
}

function renderDinos(dinos) {
    const grid = document.getElementById("dinoGrid")
    if (!dinos.length) {
        grid.innerHTML = '<div class="empty">🦖 No hay dinosaurios registrados aún</div>'
        return
    }
    grid.innerHTML = dinos.map(d => `
        <div class="dino-card">
            <h4>🦖 ${d.nick}</h4>
            <div class="stat"><span>🧬 Raza</span><span>${d.raza}</span></div>
            <div class="stat"><span>📅 Edad</span><span>${d.edad} años</span></div>
            <span class="badge badge-${d.nivel_peligrosidad}">
                ⚠️ ${d.nivel_peligrosidad.replace('_', ' ')}
            </span>
            <span class="badge badge-${d.dieta}">
                ${d.dieta === 'herbivoro' ? '🌿' : d.dieta === 'omnivoro' ? '🍖' : '🔴'} ${d.dieta}
            </span>
            <div class="stat" style="margin-top:8px">
                <span>🏠 Celda</span>
                <span>
                    ${d.celda
                        ? `<span class="celda-tag">${d.celda.nombre}</span>`
                        : `<span class="sin-celda">Sin asignar</span>`
                    }
                </span>
            </div>
            <div class="card-actions">
                <button class="btn-edit" onclick="editDino(${d.id})">✏️</button>
                <button class="btn-asignar" onclick="showAsignar(${d.id}, '${d.nick}', ${d.celda_id ?? 'null'})">🏠</button>
                <button class="btn-delete" onclick="deleteDino(${d.id}, '${d.nick}')">❌</button>
            </div>
        </div>
    `).join('')
}

function loadCeldas(selectId, selectedId = null) {
    fetch('/api/celdas', { headers: { 'Authorization': 'Bearer ' + token } })
    .then(res => res.json())
    .then(celdas => {
        const select  = document.getElementById(selectId)
        const options = celdas.map(c =>
            `<option value="${c.id}" ${c.id == selectedId ? 'selected' : ''}>${c.nombre}</option>`
        ).join('')
        select.innerHTML = '<option value="">Sin celda</option>' + options
    })
}

function showCreateForm() {
    editingId = null
    document.getElementById("formTitle").innerText    = "➕ Nuevo Dinosaurio"
    document.getElementById("fNick").value            = ""
    document.getElementById("fEdad").value            = 0
    document.getElementById("fRaza").value            = "Triceratops"
    document.getElementById("fPeligrosidad").value    = "bajo"
    document.getElementById("fDieta").value           = "herbivoro"
    loadCeldas("fCelda")
    document.getElementById("formBox").style.display  = "block"
    document.getElementById("formBox").scrollIntoView({ behavior: 'smooth' })
}

function editDino(id) {
    fetch(`/api/dinosaurios/${id}`, { headers: { 'Authorization': 'Bearer ' + token } })
    .then(res => res.json())
    .then(d => {
        editingId = id
        document.getElementById("formTitle").innerText    = "✏️ Editar Dinosaurio"
        document.getElementById("fNick").value            = d.nick
        document.getElementById("fEdad").value            = d.edad
        document.getElementById("fRaza").value            = d.raza
        document.getElementById("fPeligrosidad").value    = d.nivel_peligrosidad
        document.getElementById("fDieta").value           = d.dieta
        loadCeldas("fCelda", d.celda_id)
        document.getElementById("formBox").style.display  = "block"
        document.getElementById("formBox").scrollIntoView({ behavior: 'smooth' })
    })
}

function saveForm() {
    const payload = {
        nick:               document.getElementById("fNick").value,
        edad:               parseInt(document.getElementById("fEdad").value),
        raza:               document.getElementById("fRaza").value,
        nivel_peligrosidad: document.getElementById("fPeligrosidad").value,
        dieta:              document.getElementById("fDieta").value,
        celda_id:           document.getElementById("fCelda").value || null,
    }
    const url    = editingId ? `/api/dinosaurios/${editingId}` : '/api/dinosaurios'
    const method = editingId ? 'PUT' : 'POST'
    fetch(url, {
        method,
        headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) { alert(data.message); hideForm(); getDinos() }
        else alert(data.message || "Error al guardar")
    })
}

function deleteDino(id, nick) {
    if (!confirm(`¿Eliminar a "${nick}"?`)) return
    fetch(`/api/dinosaurios/${id}`, {
        method: 'DELETE',
        headers: { 'Authorization': 'Bearer ' + token }
    })
    .then(res => res.json())
    .then(data => { alert(data.message); getDinos() })
}

function showAsignar(id, nick, celdaId) {
    asignandoId = id
    document.getElementById("asignarDinoNick").innerText  = "🦖 " + nick
    loadCeldas("asignarCelda", celdaId)
    document.getElementById("asignarBox").style.display   = "block"
    document.getElementById("asignarBox").scrollIntoView({ behavior: 'smooth' })
}

function saveAsignar() {
    const celda_id = document.getElementById("asignarCelda").value || null
    fetch(`/api/dinosaurios/${asignandoId}/asignar`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token },
        body: JSON.stringify({ celda_id })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) { alert(data.message); hideAsignar(); getDinos() }
        else alert(data.message || "Error al asignar")
    })
}

function hideForm() {
    document.getElementById("formBox").style.display = "none"
    editingId = null
}

function hideAsignar() {
    document.getElementById("asignarBox").style.display = "none"
    asignandoId = null
}

getDinos()
</script>
</body>
</html>
