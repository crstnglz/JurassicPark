<!-- TOAST CONTAINER -->
<div id="toastContainer" style="
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-width: 350px;
"></div>

<script src="https://js.pusher.com/8.0/pusher.min.js"></script>
<script>
// ======== SISTEMA DE TOASTS ========
function showToast(mensaje, tipo = 'info', duracion = 5000) {
    const colores = {
        success: { bg: '#14532d', border: '#22c55e', color: '#86efac', icon: '✅' },
        warning: { bg: '#713f12', border: '#facc15', color: '#fde68a', icon: '⚠️' },
        danger:  { bg: '#450a0a', border: '#dc2626', color: '#ff6b6b', icon: '🚨' },
        info:    { bg: '#1e3a5f', border: '#3b82f6', color: '#93c5fd', icon: 'ℹ️' },
    }

    const c     = colores[tipo] || colores.info
    const toast = document.createElement('div')
    toast.style.cssText = `
        background: ${c.bg};
        border: 1px solid ${c.border};
        color: ${c.color};
        padding: 14px 18px;
        border-radius: 10px;
        font-size: 14px;
        font-family: 'Segoe UI', sans-serif;
        box-shadow: 0 4px 20px rgba(0,0,0,0.5);
        display: flex;
        align-items: flex-start;
        gap: 10px;
        animation: slideIn 0.3s ease;
        cursor: pointer;
        max-width: 350px;
    `
    toast.innerHTML = `
        <span style="font-size:18px">${c.icon}</span>
        <span style="flex:1">${mensaje}</span>
        <span style="opacity:0.6; font-size:18px; line-height:1" onclick="this.parentElement.remove()">×</span>
    `
    toast.addEventListener('click', () => toast.remove())
    document.getElementById('toastContainer').appendChild(toast)

    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease'
        setTimeout(() => toast.remove(), 300)
    }, duracion)
}

// Animaciones CSS
const style = document.createElement('style')
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to   { transform: translateX(0);    opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0);    opacity: 1; }
        to   { transform: translateX(100%); opacity: 0; }
    }
`
document.head.appendChild(style)

// ======== CONEXIÓN REVERB ========
const _token  = localStorage.getItem("token")
const _role   = localStorage.getItem("role")
const _userId = localStorage.getItem("id")

if (_token) {
    const pusher = new Pusher('{{ env("REVERB_APP_KEY") }}', {
        wsHost:            '{{ env("REVERB_HOST") }}',
        wsPort:            {{ env("REVERB_PORT", 8080) }},
        forceTLS:          false,
        enabledTransports: ['ws'],
        cluster:           'mt1',
        disableStats:      true,
    })

    // ======== CANAL PARQUE (admin) ========
    if (_role === 'admin') {
        const canalParque = pusher.subscribe('parque')

        // HU27 - Celda actualizada
        canalParque.bind('celda.actualizada', (data) => {
            showToast(
                `🏗️ <strong>${data.nombre}</strong> — Alimento: ${data.alimento}% | Averías: ${data.averias_pendientes}`,
                data.alimento <= 20 || data.averias_pendientes >= 3 ? 'danger' : 'warning',
                6000
            )
        })

        // HU29 - Brecha de seguridad
        canalParque.bind('brecha.seguridad', (data) => {
            const tipo = data.resultado === 'catastrofe' ? 'danger' :
                         data.resultado === 'fuga_menor' ? 'warning' : 'success'
            const msg  = data.resultado === 'catastrofe'
                ? `🚨 CATÁSTROFE en <strong>${data.celda}</strong> — ${data.carnivoros_letales.length} carnívoro(s) suelto(s)`
                : data.resultado === 'fuga_menor'
                ? `⚠️ Fuga menor en <strong>${data.celda}</strong>`
                : `✅ Brecha contenida en <strong>${data.celda}</strong>`
            showToast(msg, tipo, 8000)
        })
    }

    // ======== CANAL TRABAJADOR ========
    if ((_role === 'veterinario' || _role === 'mantenimiento') && _userId) {
        console.log('🔌 Suscribiendo al canal trabajador.' + _userId)
        const canalTrabajador = pusher.subscribe('trabajador.' + _userId)

        canalTrabajador.bind('pusher:subscription_succeeded', () => {
            console.log('✅ Suscrito correctamente al canal trabajador.' + _userId)
        })

        // HU28 - Tarea asignada
        canalTrabajador.bind('tarea.asignada', (data) => {
            console.log('📋 Tarea recibida:', data)
            showToast(
                `📋 Nueva tarea asignada — <strong>${data.celda ? data.celda.nombre : 'Sin celda'}</strong> (${data.tipo})`,
                'info',
                7000
            )
            // ✅ Recargar tareas automáticamente sin refrescar
            if (typeof getTareas === 'function') getTareas()
            if (typeof loadWorkerTareas === 'function') loadWorkerTareas()
        })
    }

    pusher.connection.bind('connected', () => {
        console.info('✅ Conectado correctamente a Reverb')
    })

    pusher.connection.bind('error', (err) => {
        console.warn('⚠️ Error WebSocket:', err)
    })
}
</script>
