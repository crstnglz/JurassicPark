<!DOCTYPE html>
<html>
<head>
    <title>Brecha de Seguridad - Jurassic Park</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'Segoe UI', sans-serif; background: linear-gradient(135deg, #052e16, #020617); color: #e5e7eb; }
        .navbar { background: rgba(0,0,0,0.7); padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #dc2626; }
        .logo { color: #facc15; font-weight: bold; font-size: 18px; }
        .nav-right { display: flex; align-items: center; gap: 10px; }
        .avatar { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid #22c55e; }
        .btn-nav { border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer; font-weight: bold; }
        .btn-nav.green { background: #22c55e; color: black; }

        .container { padding: 40px; max-width: 900px; margin: auto; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .page-header h2 { margin: 0; color: #dc2626; }

        .sim-box { background: rgba(0,0,0,0.6); border: 1px solid #dc2626; border-radius: 16px; padding: 30px; margin-bottom: 30px; }
        .sim-box h3 { color: #dc2626; margin: 0 0 10px 0; }
        .sim-box p  { color: #9ca3af; margin: 0 0 20px 0; }

        .selector-row { display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap; }
        .selector-row > div { flex: 1; min-width: 200px; }

        label { font-size: 13px; color: #86efac; display: block; margin-bottom: 6px; }
        select { width: 100%; padding: 10px; background: #020617; border: 1px solid #14532d; color: white; border-radius: 8px; }

        .btn-sim-brecha { background: #dc2626; color: white; border: none; padding: 12px 24px; border-radius: 10px; cursor: pointer; font-size: 15px; font-weight: bold; transition: all 0.2s; white-space: nowrap; }
        .btn-sim-brecha:hover    { background: #b91c1c; transform: scale(1.05); }
        .btn-sim-brecha:disabled { background: #374151; color: #6b7280; cursor: not-allowed; transform: none; }

        .resultado-box { border-radius: 16px; padding: 30px; margin-bottom: 25px; text-align: center; }
        .resultado-box.contenida  { background: rgba(34,197,94,0.1);  border: 2px solid #22c55e; }
        .resultado-box.fuga_menor { background: rgba(250,204,21,0.1); border: 2px solid #facc15; }
        .resultado-box.catastrofe { background: rgba(220,38,38,0.1);  border: 2px solid #dc2626; }
        .resultado-icon  { font-size: 60px; margin-bottom: 10px; }
        .resultado-title { font-size: 24px; font-weight: bold; margin-bottom: 5px; }
        .resultado-box.contenida  .resultado-title { color: #22c55e; }
        .resultado-box.fuga_menor .resultado-title { color: #facc15; }
        .resultado-box.catastrofe .resultado-title { color: #dc2626; }
        .resultado-prob { font-size: 14px; color: #9ca3af; }

        .informe-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px; }
        .info-card { background: rgba(0,0,0,0.6); border-radius: 12px; padding: 20px; }
        .info-card h4 { color: #facc15; margin: 0 0 15px 0; }

        .stat { display: flex; justify-content: space-between; margin: 8px 0; font-size: 14px; }
        .stat .lbl { color: #9ca3af; }
        .stat .val { font-weight: bold; color: #22c55e; }
        .stat .val.danger { color: #dc2626; }
        .stat .val.warn   { color: #facc15; }

        .badge { display: inline-block; padding: 3px 10px; border-radius: 10px; font-size: 12px; font-weight: bold; }
        .badge-bajo     { background: #14532d; color: #86efac; }
        .badge-medio    { background: #713f12; color: #fde68a; }
        .badge-alto     { background: #7f1d1d; color: #fca5a5; }
        .badge-muy_alto { background: #6b21a8; color: #e9d5ff; }
        .badge-extremo  { background: #1e1b4b; color: #a5b4fc; }
        .badge-critico  { background: #450a0a; color: #ff6b6b; }

        .eventos-box { background: rgba(0,0,0,0.6); border: 1px solid #374151; border-radius: 12px; padding: 20px; margin-bottom: 25px; }
        .eventos-box h4 { color: #facc15; margin: 0 0 15px 0; }
        .evento { padding: 10px 15px; margin: 6px 0; border-radius: 8px; font-size: 14px; background: rgba(255,255,255,0.05); border-left: 3px solid #374151; }
        .evento.danger { border-left-color: #dc2626; background: rgba(220,38,38,0.1); }
        .evento.warn   { border-left-color: #facc15; background: rgba(250,204,21,0.05); }
        .evento.ok     { border-left-color: #22c55e; background: rgba(34,197,94,0.05); }

        .acciones-box { background: rgba(0,0,0,0.6); border: 1px solid #6366f1; border-radius: 12px; padding: 20px; }
        .acciones-box h4 { color: #a5b4fc; margin: 0 0 15px 0; }
        .btn-asignar { background: #6366f1; color: white; border: none; padding: 10px 18px; border-radius: 8px; cursor: pointer; font-weight: bold; margin-top: 10px; width: 100%; }
        .btn-asignar:hover { background: #4f46e5; }

        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 100; justify-content: center; align-items: center; }
        .modal-overlay.active { display: flex; }
        .modal { background: #0a1628; border: 1px solid #facc15; border-radius: 16px; padding: 30px; width: 400px; max-width: 90%; }
        .modal h3 { color: #facc15; margin: 0 0 20px 0; }
        .modal-actions { display: flex; gap: 10px; margin-top: 20px; }
        .btn-save   { background: #22c55e; color: black; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: bold; flex: 1; }
        .btn-cancel { background: #6b7280; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; flex: 1; }

        .progress-bar  { background: #1a2e1a; border-radius: 6px; height: 8px; margin: 4px 0; }
        .progress-fill { height: 8px; border-radius: 6px; }
    </style>
</head>
<body>

<div class="navbar">
    <div class="logo">🦖 Jurassic Park</div>
    <div class="nav-right">
        <img id="navAvatar" class="avatar" src="https://dummyimage.com/35x35/000/fff">
        <button class="btn-nav green" onclick="window.location.href='/simulacion'">🎮 Sim. Normal</button>
        <button class="btn-nav green" onclick="window.location.href='/home'">🏠 Home</button>
    </div>
</div>

<div class="container">
    <div class="page-header">
        <h2>💥 Simulación de Brecha de Seguridad</h2>
    </div>

    <div class="sim-box">
        <h3>⚡ Configurar Brecha</h3>
        <p>Selecciona una celda manualmente o deja que el sistema elija una aleatoriamente.</p>
        <div class="selector-row">
            <div>
                <label>Celda afectada</label>
                <select id="selectCelda"><option value="">🎲 Aleatoria</option></select>
            </div>
            <button class="btn-sim-brecha" id="btnBrecha" onclick="lanzarBrecha()">💥 Lanzar Brecha</button>
        </div>
    </div>

    <div id="resultadoPanel" style="display:none">
        <div class="resultado-box" id="resultadoBox">
            <div class="resultado-icon" id="resultadoIcon"></div>
            <div class="resultado-title" id="resultadoTitle"></div>
            <div class="resultado-prob" id="resultadoProb"></div>
        </div>

        <div class="informe-grid">
            <div class="info-card">
                <h4>🏠 Celda Afectada</h4>
                <div class="stat"><span class="lbl">Nombre</span><span class="val" id="iNombre"></span></div>
                <div class="stat"><span class="lbl">Seguridad</span><span id="iSeguridad"></span></div>
                <div class="stat"><span class="lbl">Peligrosidad</span><span id="iPeligrosidad"></span></div>
                <div class="stat"><span class="lbl">🍖 Alimento</span><span class="val" id="iAlimento"></span></div>
                <div class="stat"><span class="lbl">🔧 Averías</span><span class="val" id="iAverias"></span></div>
                <div class="stat"><span class="lbl">🦖 Dinosaurios</span><span class="val" id="iDinos"></span></div>
            </div>
            <div class="info-card">
                <h4>📊 Estadísticas</h4>
                <div class="stat"><span class="lbl">Probabilidad fuga</span><span class="val" id="iProb"></span></div>
                <div class="progress-bar"><div class="progress-fill" id="iProbBar"></div></div>
                <div class="stat" style="margin-top:10px"><span class="lbl">💀 Bajas personal</span><span class="val danger" id="iBajas"></span></div>
                <div class="stat"><span class="lbl">🩸 Dinos heridos</span><span class="val warn" id="iDinosHeridos"></span></div>
                <div class="stat"><span class="lbl">🦖 Carnívoros sueltos</span><span class="val danger" id="iCarnivoros"></span></div>
                <div class="stat"><span class="lbl">😡 Dinos agresivos</span><span class="val warn" id="iAgresivos"></span></div>
            </div>
        </div>

        <div class="eventos-box">
            <h4>📋 Registro de Eventos</h4>
            <div id="eventosList"></div>
        </div>

        <div class="acciones-box" id="accionesBox" style="display:none">
            <h4>👷 Acciones Recomendadas</h4>
            <p style="color:#9ca3af; font-size:14px" id="accionesDesc"></p>
            <button class="btn-asignar" onclick="openModal()">👷 Asignar Trabajador a la Celda</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="modalOverlay">
    <div class="modal">
        <h3>👷 Asignar Trabajador</h3>
        <p id="modalCeldaNombre" style="color:#9ca3af; margin:0 0 15px 0"></p>
        <label>Trabajador</label>
        <select id="modalUser"><option value="">Selecciona trabajador</option></select>
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

@include('partials.toast')

<script>
const token = localStorage.getItem("token")
const role  = localStorage.getItem("role")
const image = localStorage.getItem("image")

if (!token) window.location.href = "/login"
if (role !== "admin") window.location.href = "/home"
if (image) document.getElementById("navAvatar").src = image

let celdaAfectadaId = null

function loadCeldas() {
    fetch('/api/celdas', { headers: { 'Authorization': 'Bearer ' + token } })
    .then(res => res.json())
    .then(celdas => {
        const select = document.getElementById("selectCelda")
        select.innerHTML = '<option value="">🎲 Aleatoria</option>' +
            celdas.map(c => `<option value="${c.id}">${c.nombre} (seg: ${c.nivel_seguridad})</option>`).join('')
    })
}

function lanzarBrecha() {
    const btn     = document.getElementById("btnBrecha")
    const celdaId = document.getElementById("selectCelda").value
    btn.disabled  = true
    btn.innerText = "⏳ Calculando..."

    fetch('/api/simulacion/brecha', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token },
        body: JSON.stringify(celdaId ? { celda_id: celdaId } : {})
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            mostrarResultado(data.informe)
            btn.innerText = "💥 Relanzar Brecha"
        } else {
            showToast(data.message || "Error en la simulación", 'danger')
            btn.innerText = "💥 Lanzar Brecha"
        }
        btn.disabled = false
    })
    .catch(err => { console.error(err); btn.disabled = false; btn.innerText = "💥 Lanzar Brecha" })
}

function mostrarResultado(informe) {
    celdaAfectadaId = informe.celda.id

    const resultadoBox = document.getElementById("resultadoBox")
    resultadoBox.className = `resultado-box ${informe.resultado}`

    const iconos  = { contenida: '✅', fuga_menor: '⚠️', catastrofe: '🚨' }
    const titulos = { contenida: 'Brecha Contenida', fuga_menor: 'Fuga Menor', catastrofe: '¡CATÁSTROFE!' }

    document.getElementById("resultadoIcon").innerText  = iconos[informe.resultado]
    document.getElementById("resultadoTitle").innerText = titulos[informe.resultado]
    document.getElementById("resultadoProb").innerText  = `Probabilidad de fuga calculada: ${informe.probabilidad_fuga}%`

    document.getElementById("iNombre").innerText    = informe.celda.nombre
    document.getElementById("iSeguridad").innerHTML = `<span class="badge badge-${informe.celda.nivel_seguridad}">${informe.celda.nivel_seguridad}</span>`
    document.getElementById("iPeligrosidad").innerHTML = `<span class="badge badge-${informe.celda.nivel_peligrosidad}">${informe.celda.nivel_peligrosidad.replace('_',' ')}</span>`
    document.getElementById("iAlimento").innerText  = informe.celda.alimento + '%'
    document.getElementById("iAlimento").className  = 'val' + (informe.celda.alimento <= 20 ? ' danger' : '')
    document.getElementById("iAverias").innerText   = informe.celda.averias_pendientes
    document.getElementById("iAverias").className   = 'val' + (informe.celda.averias_pendientes > 0 ? ' danger' : '')
    document.getElementById("iDinos").innerText     = informe.total_dinosaurios
    document.getElementById("iProb").innerText      = informe.probabilidad_fuga + '%'
    document.getElementById("iProbBar").style.width = informe.probabilidad_fuga + '%'
    document.getElementById("iProbBar").style.background =
        informe.probabilidad_fuga > 70 ? '#dc2626' : informe.probabilidad_fuga > 40 ? '#facc15' : '#22c55e'
    document.getElementById("iBajas").innerText        = informe.bajas_personal
    document.getElementById("iDinosHeridos").innerText = informe.dinosaurios_heridos
    document.getElementById("iCarnivoros").innerText   = informe.carnivoros_letales.length
    document.getElementById("iAgresivos").innerText    = informe.dinosaurios_agresivos ? 'Sí' : 'No'

    document.getElementById("eventosList").innerHTML = informe.eventos.map(e => {
        let clase = 'evento'
        if (e.includes('💀') || e.includes('🚨') || e.includes('🦖')) clase += ' danger'
        else if (e.includes('⚠️') || e.includes('🍖') || e.includes('🩸')) clase += ' warn'
        else if (e.includes('✅')) clase += ' ok'
        return `<div class="${clase}">${e}</div>`
    }).join('')

    if (informe.resultado !== 'contenida') {
        document.getElementById("accionesBox").style.display = "block"
        document.getElementById("accionesDesc").innerText = informe.resultado === 'catastrofe'
            ? '🚨 Situación crítica — asigna veterinarios y mantenimiento urgentemente.'
            : '⚠️ Fuga menor detectada — se recomienda asignar personal para revisar la celda.'
        document.getElementById("modalCeldaNombre").innerText = '📍 Celda: ' + informe.celda.nombre
    } else {
        document.getElementById("accionesBox").style.display = "none"
    }

    document.getElementById("resultadoPanel").style.display = "block"
    document.getElementById("resultadoPanel").scrollIntoView({ behavior: 'smooth' })
}

function openModal()  { loadWorkers(); document.getElementById("modalOverlay").classList.add("active") }
function closeModal() { document.getElementById("modalOverlay").classList.remove("active") }

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
    const user_id = document.getElementById("modalUser").value
    const tipo    = document.getElementById("modalTipo").value
    if (!user_id) { showToast("Selecciona un trabajador", 'warning'); return }

    fetch('/api/tareas', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token },
        body: JSON.stringify({ user_id, celda_id: celdaAfectadaId, tipo, descripcion: 'Asignado tras brecha de seguridad' })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) { showToast('✅ Trabajador asignado correctamente', 'success'); closeModal() }
        else showToast(data.message || "Error al asignar", 'danger')
    })
}

document.getElementById("modalOverlay").addEventListener('click', function(e) { if (e.target === this) closeModal() })
loadCeldas()
</script>
</body>
</html>
