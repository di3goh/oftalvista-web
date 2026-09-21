# Oftalvista Web + CMS

Sitio público en PHP 8.3 con un panel administrativo para publicaciones y contenido editable. Usa PostgreSQL como fuente de datos y Redis para el caché del blog, rate limiting y revocación de sesiones JWT.

## Inicio rápido

1. Crea el archivo local de configuración con secretos aleatorios:

   ```bash
   sh bin/create-env.sh
   ```

2. Revisa `.env` si deseas cambiar el correo, la contraseña inicial o los puertos. `ADMIN_PASSWORD` necesita al menos 12 caracteres.

3. Levanta y verifica los servicios:

   ```bash
   docker compose up --build -d
   docker compose ps
   curl http://localhost:8080/api/health.php
   ```

- Sitio: <http://localhost:8080>
- Administrador: <http://localhost:8080/admin/login.php>
- pgAdmin: <http://localhost:5050>
- En pgAdmin, el host de PostgreSQL es `postgres`, puerto `5432`, y las credenciales son las variables `POSTGRES_*` del `.env`.

En el primer arranque se crean las tablas, el usuario administrador y se importan las seis publicaciones HTML originales. Los siguientes arranques conservan publicaciones, ajustes e imágenes en volúmenes Docker.

## Módulos

- Publicaciones: crear, editar, guardar como borrador, programar/publicar, subir imagen y eliminar.
- Contenido del sitio: título principal, texto destacado, métricas, títulos/descripciones de secciones, etiquetas del menú, contacto, horarios y redes sociales.
- Página pública: portada, listado dinámico del blog y detalle por slug, con compatibilidad 301 para enlaces `.html` anteriores.

## Arquitectura y nombres

- `public/` es el único directorio expuesto por Apache y contiene el front controller, recursos, API y panel administrativo.
- `app/Http/Controllers/` contiene la lógica de las páginas; `resources/views/` contiene únicamente su presentación.
- `database/migrations/` y `database/seeds/` contienen el esquema y los datos iniciales.
- Las clases PHP usan `PascalCase`; métodos y variables, `camelCase`; plantillas, recursos y URLs, `kebab-case`; base de datos, `snake_case`.
- Las rutas públicas son limpias: `/servicios`, `/blog`, `/blog/{slug}` y `/cirugia-de-cataratas`. Las URLs antiguas redirigen con estado 301.

La estructura completa y la guía para agregar páginas están en [docs/project-structure.md](docs/project-structure.md).

## Seguridad aplicada

- Contraseñas con Argon2id y rehash automático.
- JWT HS256 firmado con `APP_KEY`, expiración de 8 horas, cookie `HttpOnly`/`SameSite=Strict` y revocación en Redis al cerrar sesión.
- Protección CSRF en toda mutación administrativa.
- Bloqueo temporal tras cinco intentos fallidos por combinación de correo e IP.
- PDO con consultas preparadas y emulación desactivada.
- Escape contextual de textos y allowlist HTML para el cuerpo de las publicaciones.
- Validación de imágenes por contenido real, tipo y tamaño; nombres aleatorios y SVG no permitido.
- CSP, protección contra iframes, MIME sniffing y listado de directorios desactivado.

En producción usa HTTPS (activa automáticamente `Secure` en la cookie si `APP_URL` empieza con `https://`), no expongas pgAdmin públicamente y administra secretos fuera del repositorio.

## Pruebas

```bash
docker compose exec php php tests/run.php
curl -I http://localhost:8080/admin/login.php
curl -I http://localhost:8080/blog
```
