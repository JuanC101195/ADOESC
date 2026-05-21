# ADOESC

**Aplicación Digital para la Organización Eficiente de Eventos Sociales y Corporativos.**

Sistema web para gestionar eventos, los servicios que se contratan para ellos, los
proveedores, las reservas y los pagos. Incluye autenticación con tres roles y un panel
principal que cambia según el rol del usuario.

## Stack

- **Laravel 13** (PHP 8.3)
- **Blade** + **Bootstrap 5** (responsive; colores corporativos verde `#007940` y negro)
- **MySQL** (servido por Laragon)
- **Eloquent ORM** sobre la base de datos existente `adoesce_bd`

## Requisitos

- PHP 8.3 con la extensión **`zip`** habilitada (necesaria para Composer).
- Composer.
- Laragon (o cualquier stack) con **Apache + MySQL** corriendo.
- Base de datos `adoesce_bd` ya creada con sus tablas.

> **Nota:** si `composer install` se queda clonando por git y agota el tiempo, suele ser
> porque la extensión `zip` de PHP está deshabilitada. Habilítala en tu `php.ini`
> (`extension=zip`) y vuelve a intentar.

## Instalación

```bash
# 1. Clonar el repositorio
git clone https://gitlab.com/JuanC101195/laravel-adoesc.git
cd laravel-adoesc

# 2. Instalar dependencias
composer install

# 3. Crear el archivo de entorno
copy .env.example .env      # Windows
# cp .env.example .env      # Linux/Mac

# 4. Generar la clave de la aplicación
php artisan key:generate
```

### Conexión a la base de datos

El proyecto **se conecta a la BD existente `adoesce_bd` y NO ejecuta migraciones**
sobre las tablas de negocio (ya contienen datos). La configuración por defecto en
`.env` apunta a Laragon:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=adoesce_bd
DB_USERNAME=root
DB_PASSWORD=
```

Las sesiones y la caché usan el driver `file` para no requerir tablas adicionales.

### Levantar el servidor

```bash
php artisan serve --port=8000
```

La aplicación queda disponible en **http://localhost:8000**.

## Usuarios y contraseñas de prueba

Las contraseñas originales de la BD eran de prueba (texto plano), por lo que no
servían para iniciar sesión. El seeder `ResetPasswordsSeeder` las normaliza a un
hash bcrypt con la clave **`password123`** para todos los usuarios:

```bash
php artisan db:seed --class=ResetPasswordsSeeder
```

| Rol           | Correo de ejemplo  | Contraseña    |
|---------------|--------------------|---------------|
| Administrador | admin@adoesc.com   | password123   |
| Organizador   | juan@adoesc.com    | password123   |

> El seeder es una herramienta de **desarrollo**. No debe ejecutarse en producción.

## Roles y permisos

| Rol             | Permisos                                                                 |
|-----------------|--------------------------------------------------------------------------|
| **Administrador** | Acceso total, incluida la gestión de usuarios y asignación de roles.   |
| **Organizador**   | Gestiona únicamente sus propios eventos y las reservas asociadas.      |
| **Invitado**      | Solo lectura: puede consultar pero no crear, editar ni eliminar.       |

El control de acceso se aplica con el middleware `rol` (alias en `bootstrap/app.php`)
y, de forma fina, con `HasMiddleware` en cada controlador.

## Módulos (CRUD)

- **Eventos** — listar, crear, editar, eliminar (el organizador solo ve los suyos).
- **Categorías de servicio**
- **Servicios** (asociados a un proveedor y una categoría)
- **Proveedores**
- **Reservas** (asocian un evento con un servicio; estados: Pendiente / Confirmado / Cancelado)
- **Pagos** (asociados a una reserva)
- **Usuarios** (solo Administrador, con asignación de rol)

## Estructura relevante

```
app/
  Http/
    Controllers/        # CRUD por módulo + Auth + Dashboard
    Middleware/         # RoleMiddleware (control por rol)
    Requests/           # FormRequests con validaciones en español
  Models/               # Eloquent: User, Rol, Evento, Servicio, etc.
database/
  seeders/              # ResetPasswordsSeeder
resources/
  views/                # Layouts, auth, dashboard y vistas CRUD por módulo
routes/
  web.php               # Rutas de autenticación y resources protegidos
```

## Convenciones de la base de datos

Las tablas usan claves primarias con el patrón `id_<tabla>` (p. ej. `id_usuario`) y no
tienen columnas de timestamps. La autenticación es **manual** sobre la tabla `usuario`
(columnas `email` y `contraseña`); el modelo `User` sobrescribe `getAuthPassword()` para
apuntar a la columna `contraseña`.
