<!DOCTYPE html>
<html>
<head>
    <title>Simulación - Jurassic Park</title>
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
        .btn-nav.red    { background: #dc2626; color: white; }

        .container { padding: 40px; max-width: 1100px; margin: auto; }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        .page-header h2 { margin: 0; color: #facc15; }

        /* BOTÓN SIMULACIÓN */
        .sim-box {
            background: rgba(0,0,0,0.6);
            border: 1px solid #22c55e;
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            margin-bottom: 30px;
        }
        .sim-box p { color: #9ca3af; margin: 10px 0 20px 0; }
        .btn-sim {
            background: #facc15;
            color: black;
            border: none;
            padding: 14px 30px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: all 0.2s;
        }
        .btn-sim:hover { background: #eab308; transform: scale(1.05); }
        .btn-sim:disabled { background: #374151; color: #6b7280; cursor: not-allowed; transform: none; }

        /* RESUMEN */
        .resumen {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }
        .resumen-card {
            background: rgba(0,0,0,0.6);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
        }
        .resumen-card .num  { font-size: 36px; font-weight: bold; }
        .resumen-card .lbl  { font-size: 13px; color: #6b7280; margin-top: 4px; }
        .resumen-card.total    { border: 1px solid #374151; }
        .resumen-card.critica  { border: 1px solid #dc2626; }
        .resumen-card.atencion { border: 1px solid #facc15; }
        .resumen-card.normal   { border: 1px solid #22c55e; }
        .resumen-card.total    .num { color: #e5e7eb; }
        .resumen-card.critica  .num { color: #dc2626; }
        .resumen-card.atencion .num { color: #facc15; }
        .resumen-card.normal   .num { color: #22c55e; }

        /* GRID CELDAS */
        h3 { color: #facc15; margin-bottom: 15px; }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .celda-card {
            background: rgba(0,0,0,0.6);
            border-radius: 12px;
            padding: 20px;
            transition: all 0.2s;
        }
        .celda-card.critica  { border-left: 4px solid #dc2626; }
        .celda-card.atencion { border-left: 4px solid #facc15; }
        .celda-card.normal   { border-left: 4px solid #22c55e; }

        .celda-card h4 { margin: 0 0 12px 0; }
        .celda-card h4.critica  { color: #dc2626; }
        .celda-card h4.atencion { color: #facc15; }
        .celda-card h4.normal   { color: #22c55e; }

        .badge { display: inline-block; padding: 3px 10px; border-radius: 10px; font-size: 12px; margin: 2px 0; font-weight: bold; }
        .badge-bajo     { background: #14532d; color: #86efac; }
        .badge-medio    { background: #713f12; color: #fde68a; }
        .badge-alto     { background: #7f1d1d; color: #fca5a5; }
        .badge-muy_alto { background: #6b21a8; color: #e9d5ff; }
        .badge-extremo  { background: #1e1b4b; color: #a5b4fc; }
        .badge-critico  { background: #450a0a; color: #ff6b6b; }

        .stat { display: flex; justify-content: space-between; margin: 8px 0; font-size: 14px; }
        .stat .label { color: #9ca3af; }

        .cambio-positivo { color: #dc2626; font-weight: bold; }
        .cambio-neutro   { color: #22c55e; font-weight: bold; }

        .progress-bar  { background: #1a2e1a; border-radius: 6px; height: 10px; margin: 4px 0 10px 0; }
        .progress-fill { height: 10px; border-radius: 6px; transition: width 0.5s; }

        .btn-asignar {
            width: 100%;
            background: #6366f1;
            color: white;
            border: none;
            padding: 8px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 12px;
        }
        .btn-asignar:hover { background: #4f46e5; }

        /* MODAL ASIGNAR */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.8);
            z-index: 100;
            justify-content: center;
            align-items: center;
        }
        .modal-overlay.active { display: flex; }
        .modal {
            background: #0a1628;
            border: 1px solid #facc15;
            border-radius: 16px;
            padding: 30px;
            width: 400px;
            max-width: 90%;
        }
        .modal h3 { color: #facc15; margin: 0 0 20px 0; }
        .modal p   { color: #9ca3af; margin: 0 0 15px 0; }

        label { font-size: 13px; color: #86efac; display: block; margin-top: 12px; margin-bottom: 4px; }
        select {
            width: 100%;
            padding: 10px;
            background: #020617;
            border: 1px solid #14532d;
            color: white;
            border-radius: 8px;
        }
        .modal-actions { display: flex; gap: 10px; margin-top: 20px; }
        .btn-save   { background: #22c55e; color: black; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: bold; flex: 1; }
        .btn-cancel { background: #6b7280; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; flex: 1; }

        .empty { text-align: center; color: #6b7280; padding: 60px; font-size: 16px; }
        .loading { text-align: center; color: #22c55e; padding: 40px; font-size: 18px; }
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
        <h2>🎮 Simulación de Funcionamiento Normal</h2>
    </div>

    <!-- BOTÓN LANZAR -->
    <div class="sim-box">
        <h3 style="color:#facc15; margin:0">⚡ Lanzar Simulación</h3>
        <p>Se reducirá el alimento de todas las celdas y se generarán averías aleatorias según el nivel de peligrosidad y seguridad de cada celda.</p>
        <button class="btn-sim" id="btnSim" onclick="lanzarSimulacion()">
            🚀 Iniciar Simulación
        </button>
    </div>

    <!-- RESUMEN -->
    <div id="resumenPanel" style="display:none">
        <h3>📊 Resumen de la Simulación</h3>
        <div class="resumen">
            <div class="resumen-card total">
                <div class="num" id="rTotal">0</div>
                <div class="lbl">Total celdas</div>
            </div>
            <div class="resumen-card critica">
                <div class="num" id="rCritica">0</div>
                <div class="lbl">🚨 Críticas</div>
            </div>
            <div class="resumen-card atencion">
                <div class="num" id="rAtencion">0</div>
                <div class="lbl">⚠️ Atención</div>
            </div>
            <div class="resumen-card normal">
                <div class="num" id="rNormal">0</div>
                <div class="lbl">✅ Normales</div>
            </div>
        </div>

        <h3>🗺️ Estado del Parque</h3>
        <div class="grid" id="informeGrid"></div>
    </div>

</div>

<!-- MODAL ASIGNAR TRABAJADOR -->
<div class="modal-overlay" id="modalOverlay">
    <div class="modal">
        <h3>👷 Asignar Trabajador</h3>
        <p id="modalCeldaNombre"></p>

        <label>Trabajador</label>
        <select id="modalUser">
            <option value="">Selecciona trabajador</option>
        </select>

        <label>Tipo de tarea</label>
        <select id="modalTipo">
            <option value="veterinario">🩺 Veterinario</option>
            <option value="mantenimiento">🔧 Mantenimiento</option>
        </select>

        <div class="modal-actions">
            <button class="btn-save" onclick="saveAsignar()">💾 Asignar</button>
            <button class="btn-cancel" onclick="closeModal()">Cancelar</button>
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

let celdaSeleccionada = null

// ======== LANZAR SIMULACIÓN ========
function lanzarSimulacion() {
    const btn = document.getElementById("btnSim")
    btn.disabled = true
    btn.innerText = "⏳ Simulando..."

    fetch('/api/simulacion/normal', {
        method: 'POST',
        headers: { 'Authorization': 'Bearer ' + token }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            mostrarResultados(data)
            btn.innerText = "🔄 Relanzar Simulación"
        } else {
            alert(data.message || "Error en la simulación")
            btn.innerText = "🚀 Iniciar Simulación"
        }
        btn.disabled = false
    })
    .catch(err => {
        console.error(err)
        btn.disabled = false
        btn.innerText = "🚀 Iniciar Simulación"
    })
}

// ======== MOSTRAR RESULTADOS ========
function mostrarResultados(data) {
    // Resumen
    document.getElementById("rTotal").innerText   = data.resumen.total_celdas
    document.getElementById("rCritica").innerText  = data.resumen.celdas_criticas
    document.getElementById("rAtencion").innerText = data.resumen.celdas_atencion
    document.getElementById("rNormal").innerText   = data.resumen.celdas_normales
    document.getElementById("resumenPanel").style.display = "block"

    // Ordenar: críticas primero
    const informe = data.informe.sort((a, b) => {
        const orden = { critica: 0, atencion: 1, normal: 2 }
        return orden[a.alerta] - orden[b.alerta]
    })

    document.getElementById("informeGrid").innerHTML = informe.map(c => `
        <div class="celda-card ${c.alerta}">
            <h4 class="${c.alerta}">
                ${c.alerta === 'critica' ? '🚨' : c.alerta === 'atencion' ? '⚠️' : '✅'}
                ${c.nombre}
            </h4>

            <span class="badge badge-${c.nivel_peligrosidad}">⚠️ ${c.nivel_peligrosidad.replace('_',' ')}</span>
            <span class="badge badge-${c.nivel_seguridad}">🔒 ${c.nivel_seguridad}</span>

            <div class="stat">
                <span class="label">🍖 Alimento</span>
                <span>${c.alimento_anterior}% → <span class="${c.alimento_actual <= 20 ? 'cambio-positivo' : 'cambio-neutro'}">${c.alimento_actual}%</span></span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" style="width:${c.alimento_actual}%;
                    background:${c.alimento_actual > 50 ? '#22c55e' : c.alimento_actual > 20 ? '#facc15' : '#dc2626'}">
                </div>
            </div>

            <div class="stat">
                <span class="label">📉 Reducción</span>
                <span class="cambio-positivo">-${c.reduccion_alimento}%</span>
            </div>

            <div class="stat">
                <span class="label">🔧 Averías</span>
                <span>${c.averias_anteriores} → <span class="${c.averias_actuales > 0 ? 'cambio-positivo' : 'cambio-neutro'}">${c.averias_actuales}</span>
                ${c.nuevas_averias > 0 ? `<span style="color:#dc2626">(+${c.nuevas_averias} nuevas)</span>` : ''}
                </span>
            </div>

            <div style="margin-top:10px">
    <div style="font-size:13px; color:#86efac; margin-bottom:6px">👷 Trabajadores asignados:</div>
    <div id="trabajadores-${c.id}">
        <span style="color:#6b7280; font-size:13px">Cargando...</span>
    </div>
</div>
<button class="btn-asignar" onclick="openModal(${c.id}, '${c.nombre}')">
    👷 Asignar Trabajador
</button>
        </div>
    `).join('')

    // Cargar trabajadores asignados a cada celda
informe.forEach(c => loadTareasCelda(c.id))

    document.getElementById("resumenPanel").scrollIntoView({ behavior: 'smooth' })
}

// ======== MODAL ASIGNAR ========
function openModal(celdaId, celdaNombre) {
    celdaSeleccionada = celdaId
    document.getElementById("modalCeldaNombre").innerText = "📍 Celda: " + celdaNombre
    loadWorkers()
    document.getElementById("modalOverlay").classList.add("active")
}

function closeModal() {
    document.getElementById("modalOverlay").classList.remove("active")
    celdaSeleccionada = null
}

function loadWorkers() {
    fetch('/api/users', { headers: { 'Authorization': 'Bearer ' + token } })
    .then(res => res.json())
    .then(users => {
        const select  = document.getElementById("modalUser")
        const workers = users.filter(u => u.role !== 'admin')
        select.innerHTML = '<option value="">Selecciona trabajador</option>' +
            workers.map(u => `<option value="${u.id}">${u.name} (${u.role})</option>`).join('')
    })
}

function saveAsignar() {
    const user_id  = document.getElementById("modalUser").value
    const tipo     = document.getElementById("modalTipo").value

    if (!user_id) {
        alert("Selecciona un trabajador")
        return
    }

    fetch('/api/tareas', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token },
        body: JSON.stringify({
            user_id:  user_id,
            celda_id: celdaSeleccionada,
            tipo:     tipo,
            descripcion: 'Asignado tras simulación normal'
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            closeModal()
            loadTareasCelda(celdaSeleccionada)
        } else {
            alert(data.message || "Error al asignar")
        }
    })
}

// ======== CARGAR TRABAJADORES ASIGNADOS A UNA CELDA ========
function loadTareasCelda(celdaId) {
    fetch('/api/tareas', { headers: { 'Authorization': 'Bearer ' + token } })
    .then(res => res.json())
    .then(tareas => {
        const tareasCelda = tareas.filter(t =>
            t.celda_id == celdaId && t.estado !== 'completada'
        )

        const contenedor = document.getElementById(`trabajadores-${celdaId}`)
        if (!contenedor) return

        if (!tareasCelda.length) {
            contenedor.innerHTML = '<span style="color:#6b7280; font-size:13px">Sin trabajadores asignados</span>'
            return
        }

        contenedor.innerHTML = tareasCelda.map(t => `
            <div style="display:flex; align-items:center; gap:6px; margin:4px 0; font-size:13px">
                <span>${t.tipo === 'veterinario' ? '🩺' : '🔧'}</span>
                <span style="color:#e5e7eb">${t.usuario ? t.usuario.name : '-'}</span>
                <span style="color:#6b7280">(${t.estado.replace('_',' ')})</span>
            </div>
        `).join('')
    })
}

// Cerrar modal al hacer click fuera
document.getElementById("modalOverlay").addEventListener('click', function(e) {
    if (e.target === this) closeModal()
})
</script>
</body>
</html>
