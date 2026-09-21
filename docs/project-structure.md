# Estructura del proyecto

El proyecto usa un único punto de entrada público (`public/index.php`) y separa la lógica HTTP, las vistas, los archivos públicos y la persistencia.

```text
oftalvista-web/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Respuestas de cada sección pública
│   │   └── Router.php       # Rutas limpias y redirecciones antiguas
│   ├── Repositories/        # Acceso a PostgreSQL y Redis
│   └── Support/             # Seguridad, vistas y utilidades compartidas
├── bin/                     # Arranque, instalación y tareas ejecutables
├── database/
│   ├── migrations/          # Cambios versionados del esquema
│   └── seeds/               # Contenido inicial del sitio y del blog
├── docker/                  # Configuración de Apache y contenedores
├── docs/                    # Documentación técnica
├── public/                  # Único DocumentRoot expuesto por Apache
│   ├── admin/               # Endpoints del panel administrativo
│   ├── api/                 # Endpoints JSON
│   ├── assets/              # CSS, JavaScript, imágenes y fuentes
│   ├── uploads/             # Imágenes subidas desde el CMS
│   └── index.php            # Front controller del sitio público
├── resources/views/
│   ├── errors/              # Páginas HTTP de error
│   └── pages/               # Plantillas de las páginas públicas
└── tests/                   # Pruebas automatizadas
```

## Convenciones de nombres

- Clases PHP y su archivo: `PascalCase`, siguiendo PSR-4. Ejemplo: `BlogController.php`.
- Métodos, funciones y variables PHP: `camelCase`. Ejemplo: `findPublishedBySlug()`.
- Plantillas, rutas web y archivos públicos: `kebab-case`. Ejemplo: `blog-show.php` y `/cirugia-de-cataratas`.
- Directorios: minúsculas y nombres por responsabilidad. Se conservan `Controllers` y demás segmentos del namespace en PascalCase donde corresponde a PSR-4.
- Tablas y columnas de PostgreSQL: `snake_case`.
- Variables de entorno: `UPPER_SNAKE_CASE`.

No se agregan páginas PHP sueltas en la raíz. Los únicos scripts web directamente accesibles viven bajo `public/`; la aplicación, configuración y base de datos quedan fuera del `DocumentRoot`.

## Flujo de una página pública

1. Apache dirige la URL limpia a `public/index.php`.
2. `Router` resuelve la ruta y llama al controlador correspondiente.
3. El controlador consulta repositorios y prepara los datos.
4. `View` renderiza una plantilla de `resources/views/pages`.

Para agregar una página, crea su controlador o acción, registra la ruta en `Router.php` y agrega la plantilla en `resources/views/pages` con nombre `kebab-case`.
