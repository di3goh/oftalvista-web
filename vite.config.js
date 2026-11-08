import { defineConfig } from "vite";

export default defineConfig({
  plugins: [{
    name: "seo-social-metadata",
    transformIndexHtml(html) {
      const title = html.match(/<title>([^<]+)<\/title>/i)?.[1];
      const description = html.match(/<meta name="description" content="([^"]*)"/i)?.[1];
      const canonical = html.match(/<link rel="canonical" href="([^"]+)"/i)?.[1];
      if (!title || !description || !canonical || html.includes('property="og:title"')) return html;
      const tags = [
        ['og:type', 'website'], ['og:site_name', 'Oftalvista'],
        ['og:title', title], ['og:description', description], ['og:url', canonical],
        ['og:image', 'https://oftalvista.com.pe/assets/favicon.png']
      ].map(([property, content]) => `<meta property="${property}" content="${content}">`).join('\n    ');
      return html.replace('</head>', `    ${tags}\n  </head>`);
    }
  }],
  publicDir: "public",
  build: {
    target: "es2022",
    outDir: "dist",
    emptyOutDir: true,
    copyPublicDir: true,
    rollupOptions: {
      input: [
        "index.html", "Servicios.html", "testimonios.html", "preguntas.html", "blog.html", "libro-reclamaciones.html",
        "opticas.html", "consulta-oftalmologica.html",
        "cirugia-de-cataratas.html", "cirugia-de-pterigion.html", "cirugia-de-parpados.html",
        "terminos-y-condiciones.html", "politica-de-privacidad.html",
        "blog/examen-de-la-vista.html", "blog/senales-visitar-oftalmologo.html",
        "blog/cataratas-sintomas-causas-tratamiento.html", "blog/pterigion-causas-tratamiento.html",
        "blog/ojo-seco-causas-sintomas.html", "blog/errores-refractivos.html",
        "productos/mvk-nino-h/index.html", "productos/mvk-nino-m/index.html",
        "productos/nano-nino-m/index.html", "productos/nano-nino-v/index.html",
        "productos/sol-polarizado-h/index.html", "productos/sol-polarizado-m/index.html",
        "productos/sol-uv-400-h/index.html"
      ]
    }
  }
});
