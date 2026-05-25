# Progreso del proyecto ADOESC y evidencias SENA

> Documento de memoria del trabajo realizado. Aprendiz: **Juan Esteban Cardozo** — Ficha **3078038** — Programa **Análisis y Desarrollo de Software (ADSO)**.
> Última actualización: **2026-05-24**. Total: 18 evidencias trabajadas.

Este archivo deja registro de todo lo construido para retomar el trabajo aunque se cierre la conversación.

---

## 1. El proyecto ADOESC

**ADOESC** (Aplicación Digital para la Organización Eficiente de Eventos Sociales y Corporativos): aplicación web para gestionar eventos, servicios, proveedores, reservas y pagos.

- **Stack:** Laravel 13 · PHP 8.3 · Blade + Bootstrap 5 · MySQL (BD `adoesce_bd` en Laragon).
- **Repositorio (principal):** https://github.com/JuanC101195/ADOESC (rama `main`). Repo antiguo en GitLab (`laravel-adoesc`) ya no se usa.
- **Workspace local:** `C:\laragon\www\laravel-adoesc`.
- **Sitio de prueba publicado (GitHub Pages):** https://juanc101195.github.io/ADOESC/ (rama `gh-pages`, plantilla Grayscale).

### Decisiones técnicas clave
- **Conexión a BD existente sin migrar** las tablas de negocio (ya tenían datos). Sesión/caché en `file`, cola `sync`.
- **Esquema no estándar:** PK `id_<tabla>`, sin timestamps. `usuario(nombre,email,telefono,contraseña)`. `evento(nombre_evento,fecha,lugar,invitados)`. `servicio` → FK a `proveedor` y `categoria`. `pago` sin estado. `reserva.estado` enum(Pendiente,Confirmado,Cancelado).
- **Auth manual** (sin Breeze): modelo `User` mapeado a tabla `usuario`, `getAuthPassword()` devuelve `contraseña`.
- **3 roles:** Administrador (id 1, total), Organizador (id 2, sus eventos), Invitado (id 3, solo lectura). Middleware `rol` en `bootstrap/app.php` + `HasMiddleware` por controlador.
- **Contraseñas:** seeder `ResetPasswordsSeeder` deja todas en `password123` (bcrypt). Usuarios de prueba: `admin@adoesc.com` (Admin), `juan@adoesc.com` (Organizador).
- **API REST:** `POST /api/registro` y `POST /api/login` (`AuthApiController`, FormRequests en `app/Http/Requests/Api/`).

### Comandos útiles (Laragon, PowerShell)
```powershell
$env:Path = "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64;" + $env:Path
Set-Location "C:\laragon\www\laravel-adoesc"
php artisan serve --port=8000           # http://localhost:8000
php artisan db:seed --class=ResetPasswordsSeeder --force
```
- Composer: `C:\laragon\bin\composer\composer.bat` · MySQL CLI: `C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysql.exe`
- Nota: hubo que habilitar `extension=zip` en el php.ini de Laragon para que `composer install` funcionara.

---

## 2. Evidencias SENA realizadas

> Los documentos LaTeX/PDF y archivos de cada evidencia están en carpetas dentro de `C:\Users\LeNoVo\Documents\`. Todos los LaTeX usan plantilla SENA (banda verde/negra, código de evidencia, booktabs) y se compilan en Overleaf con pdfLaTeX. Sin atribución a Claude en commits.

| Código | Evidencia | Formato | Estado | Carpeta local |
|---|---|---|---|---|
| GA7-220501096-AA3-EV01 | Documentación del CRUD + framework (Laravel) | PDF | ✅ Entregada | `ADOESC-Evidencia-GA7-EV01` |
| GA7-220501096-AA5-EV01 | Servicio web (API REST registro/login) | ZIP+PDF | ✅ Lista | `ADOESC-Evidencia-GA7-AA5-EV01` |
| GA7-220501096-AA5-EV02 | Testing de la API con Postman (+Newman) | ZIP+PDF | ✅ Lista (falta adjuntar PDF y link video) | `ADOESC-Evidencia-GA7-AA5-EV02` |
| GA9-220501096-AA1-EV01 | Taller de pruebas de software | PDF | ✅ Lista | `ADOESC-Evidencia-GA9-AA1-EV01` |
| GA9-220501096-AA1-EV02 | Plan de pruebas de software | PDF | ✅ Lista | `ADOESC-Evidencia-GA9-AA1-EV02` |
| GA9-220501096-AA2-EV01 | Formato de casos de prueba (Excel) | XLSX | ✅ Lista | `ADOESC-Evidencia-GA9-AA2-EV01` |
| GA9-220501096-AA3-EV02 | Reporte de plan de pruebas ejecutadas | PDF (+Excel diligenciado) | ✅ Lista | `ADOESC-Evidencia-GA9-AA3-EV02` |
| GA10-220501097-AA1-EV01 | Conceptos de redes y networking | PDF | ✅ Lista | `ADOESC-Evidencia-GA10-AA1-EV01` |
| GA10-220501097-AA3-EV01 | Instalación de plataforma + despliegue de producto de prueba | PDF | ✅ Lista | `ADOESC-Evidencia-GA10-AA3-EV01` |
| GA10-220501097-AA4-EV01 | Clústeres, redundancia y alta disponibilidad | PDF | ✅ Lista | `ADOESC-Evidencia-GA10-AA4-EV01` |
| GA10-220501097-AA5-EV01 | Config. de servicios (Ubuntu+Apache+MySQL) con virtualización y contenedores | PDF/Word | ✅ Lista | `ADOESC-Evidencia-GA10-AA5-EV01` |
| GA10-220501097-AA7-EV01 | Pruebas de funcionalidad de un sitio publicado en internet | PDF | ✅ Lista | `ADOESC-Evidencia-GA10-AA7-EV01` |
| GA10-240201529-AA2-EV01 | Modelo Canvas del emprendimiento | PDF | ✅ Lista | `ADOESC-Evidencia-GA10-240201529-AA2-EV01` |
| GA10-240201529-AA3-EV01 | Modelo financiero (viabilidad del emprendimiento) | XLSX | ✅ Lista | `ADOESC-Evidencia-GA10-240201529-AA3-EV01` |
| GA10-220501097-AA8-EV01 | Plan de mantenimiento y soporte (ISO 14764) | PDF | ✅ Lista | `ADOESC-Evidencia-GA10-AA8-EV01` |
| GA10-220501097-AA9-EV01 | Plan de migración y respaldo (listas de chequeo) | PDF | ✅ Lista | `ADOESC-Evidencia-GA10-AA9-EV01` |
| GA10-220501097-AA12-EV01 | Plan de capacitación + acta de entrega | PDF (+video) | ✅ Lista (falta grabar video y link) | `ADOESC-Evidencia-GA10-AA12-EV01` |

### Detalles y evidencia real generada
- **AA5-EV01/EV02 (API + Postman):** API probada con curl y con **Newman** (5 peticiones, 10 aserciones, 0 fallos). Colección `ADOESC_API.postman_collection.json`. Capturas reales `newman_resumen.png`, `newman_completo.png`, y capturas de Postman tomadas por el aprendiz.
- **GA10-AA3-EV01:** plantilla gratuita **Grayscale** (Start Bootstrap, MIT) desplegada en Laragon (`C:\laragon\www\plantilla-prueba`), captura real `despliegue_plantilla.png`.
- **GA10-AA5-EV01:** parte de **contenedores** ejecutada de verdad con **Docker** (Dockerfile `ubuntu:22.04`+apache2 y `mysql:8.0` vía compose; contenedores `adoesc_apache`/`adoesc_mysql`; captura `contenedor_apache.png`). Parte de **virtualización** resuelta con **WSL2 + Ubuntu 24.04** (Apache 2.4.58, MySQL 8.0.45 instalados de verdad; 4 imágenes `vm_*.png` reales estilo terminal). Docker Desktop debe iniciarse manual; limpiar con `docker compose down` en la carpeta `docker`.
- **GA10-AA7-EV01:** plantilla publicada en internet vía **GitHub Pages** → https://juanc101195.github.io/ADOESC/ (captura `sitio_publicado.png`).
- **GA10-240201529-AA2-EV01:** Modelo Canvas (9 bloques) del emprendimiento ADOESC como negocio SaaS.

### Plantilla SENA usada (LaTeX)
- Verde SENA `#39A900`, negro, banda superior/inferior en la portada, encabezado con el código de evidencia y línea verde, secciones con `\titlerule` verde, tablas con `booktabs`, código con `listings`.
- Macro `\captura{archivo.png}{caption}`: muestra la imagen si existe o un recuadro "[Pendiente]" si no (las imágenes se suben a la **raíz** del proyecto en Overleaf).
- Capturas reales generadas con **Chrome/Puppeteer headless** contra servidores locales.

---

## 3. Pendientes / próximos pasos
- **GA7-AA5-EV02:** el aprendiz debe grabar el video (Postman) y pegar el link de YouTube en el `.tex`, generar el PDF y meterlo al ZIP.
- Posibles evidencias futuras del programa (no realizadas aún): **GA9-AA5**, y otras que aparezcan.
- Mejoras opcionales al código ADOESC a medida que lleguen nuevas evidencias.

---

## 4. Preferencias de trabajo (acordadas)
- Una rama por cambio; validar local antes de mergear; **no commitear sin pedir**.
- **Sin atribución a Claude** en commits/PRs/código.
- GitHub es el repositorio principal (no GitLab).
- Plan Pro: trabajar de forma eficiente con los tokens.
