# Oftalvista web

Sitio p?blico est?tico de Oftalvista. Incluye servicios, cat?logo de lentes, art?culos hist?ricos y p?ginas legales. El panel y Supabase no forman parte de esta versi?n. El Libro de Reclamaciones virtual permanece deshabilitado.

## Desarrollo

Requiere Node.js 20.19+ o 22.12+.

```bash
npm ci
npm run dev
npm run build
npm run preview
```

## Despliegue en Vercel

Usar `npm run build` y `dist` como directorio de salida (configurados en `vercel.json`). Tras desplegar, verificar la portada, el cat?logo, los art?culos y `https://oftalvista.com.pe/sitemap.xml`, y enviar el sitemap en Google Search Console. Las p?ginas de productos se generan durante la compilaci?n.
