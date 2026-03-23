# 🦖 Jurassic Park - Sistema de Gestión

Aplicación web desarrollada con **Laravel** para la gestión y simulación de un parque de dinosaurios. Permite gestionar celdas, dinosaurios, usuarios y trabajadores, además de lanzar simulaciones de funcionamiento normal y brechas de seguridad con comunicación en tiempo real mediante WebSockets.

---

## 🚀 Tecnologías utilizadas

- **Laravel** — Backend y API REST
- **Laravel Sanctum** — Autenticación por tokens
- **Laravel Reverb** — WebSockets en tiempo real
- **Eloquent ORM** — Mapeo de base de datos y relaciones
- **phpMyAdmin** — Base de datos
- **Cloudinary** — Almacenamiento de imágenes en la nube
- **Blade** — Motor de plantillas para las vistas
- **Pusher JS** — Cliente WebSocket en el frontend

---

## ⚙️ Instalación

### 1. Clonar el repositorio
```bash
git clone https://github.com/crstnglz/JurassicPark.git
cd jurassic-park
```

### 2. Instalar dependencias
```bash
composer install
```

### 3. Configurar el entorno
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configurar la base de datos

Edita el `.env` con tus credenciales de MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jurassic_park
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Configurar Cloudinary

Regístrate en [cloudinary.com](https://cloudinary.com) y añade tus credenciales al `.env`:
```env
CLOUDINARY_KEY=tu_api_key
CLOUDINARY_SECRET=tu_api_secret
CLOUDINARY_CLOUD_NAME=tu_cloud_name
```

### 6. Configurar Reverb (WebSockets)
```bash
php artisan install:broadcasting
```

Elige **Reverb** como driver. Las variables se añadirán automáticamente al `.env`.

### 7. Ejecutar migraciones y seeders
```bash
php artisan migrate
php artisan db:seed
```

### 8. Levantar los servidores

Abre **tres terminales**:
```bash
# Terminal 1 - Servidor Laravel
php artisan serve

# Terminal 2 - Servidor WebSockets
php artisan reverb:start

# Terminal 3 - (opcional) Queue worker si usas colas
php artisan queue:work
```

Accede a la aplicación en: `http://127.0.0.1:8000`

---

## 👥 Roles de usuario

| Rol | Permisos |
|-----|----------|
| **Admin** | CRUD de usuarios, celdas y dinosaurios. Lanzar simulaciones. Asignar tareas. |
| **Veterinario** | Ver y gestionar sus tareas asignadas. Al completar, restaura el alimento de la celda. |
| **Mantenimiento** | Ver y gestionar sus tareas asignadas. Al completar, reduce las averías de la celda. |

---

## 🦖 Funcionalidades principales

### Gestión de Celdas
- Crear, editar y eliminar celdas del parque
- Cada celda tiene: nivel de peligrosidad, seguridad, alimento y averías pendientes

### Gestión de Dinosaurios
- CRUD completo de dinosaurios
- Asignación a celdas
- Estados: activo, fugado, herido
- Recuperación de dinosaurios fugados o heridos

### Gestión de Tareas
- El admin asigna tareas a veterinarios y personal de mantenimiento
- Estados: pendiente → en progreso → completada
- Al completar una tarea de veterinario → alimento de la celda sube al 100%
- Al completar una tarea de mantenimiento → averías de la celda bajan en 1

### Simulación Normal
- Reduce el alimento de todas las celdas según su nivel de peligrosidad
- Genera averías aleatorias según nivel de seguridad
- Genera un informe con el estado del parque
- Permite asignar trabajadores a las celdas afectadas

### Simulación de Brecha de Seguridad
- Selección de celda manual o aleatoria
- Algoritmo que calcula la probabilidad de fuga según:
  - Nivel de seguridad de la celda
  - Averías pendientes
  - Nivel de alimento
  - Peligrosidad de los dinosaurios
- Tres resultados posibles: contenida, fuga menor, catástrofe
- Los carnívoros letales se marcan como fugados en la BD
- Genera un informe detallado con eventos

### WebSockets en tiempo real
- Notificación al trabajador cuando se le asigna una tarea
- Notificación al trabajador cuando su tarea es eliminada
- Notificación al admin cuando el trabajador actualiza el estado de una tarea
- Alertas al admin cuando se lanza una simulación o brecha

---

## 🔌 API Endpoints principales

### Autenticación
| Método | Ruta | Descripción |
|--------|------|-------------|
| POST | `/api/login` | Login de usuario |
| POST | `/api/register` | Registro de usuario |
| POST | `/api/logout` | Logout |
| POST | `/api/update-password` | Actualizar contraseña |

### Usuarios
| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/api/users` | Listar usuarios |
| POST | `/api/users` | Crear usuario |
| PUT | `/api/users/{id}` | Editar usuario |
| DELETE | `/api/users/{id}` | Eliminar usuario |

### Celdas
| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/api/celdas` | Listar celdas |
| POST | `/api/celdas` | Crear celda |
| GET | `/api/celdas/{id}` | Ver celda |
| PUT | `/api/celdas/{id}` | Editar celda |
| DELETE | `/api/celdas/{id}` | Eliminar celda |

### Dinosaurios
| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/api/dinosaurios` | Listar dinosaurios |
| POST | `/api/dinosaurios` | Crear dinosaurio |
| GET | `/api/dinosaurios/{id}` | Ver dinosaurio |
| PUT | `/api/dinosaurios/{id}` | Editar dinosaurio |
| DELETE | `/api/dinosaurios/{id}` | Eliminar dinosaurio |
| POST | `/api/dinosaurios/{id}/asignar` | Asignar a celda |
| POST | `/api/dinosaurios/{id}/recuperar` | Recuperar dinosaurio |

### Tareas
| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/api/tareas` | Listar tareas |
| POST | `/api/tareas` | Crear tarea |
| PUT | `/api/tareas/{id}/estado` | Cambiar estado |
| DELETE | `/api/tareas/{id}` | Eliminar tarea |

### Simulaciones
| Método | Ruta | Descripción |
|--------|------|-------------|
| POST | `/api/simulacion/normal` | Simulación normal |
| POST | `/api/simulacion/brecha` | Simulación brecha |

---

## 👤 Usuario administrador por defecto

Puedes crear un usuario admin desde el registro o usando el seeder:
```
Email: admin@test.com
Password: 12345678
Rol: admin
```

---

## 📝 Licencia

Proyecto desarrollado para el módulo de **2º CFGS DAW** por **Cristina** — CIFP Virgen de Gracia.
