import { mkdir, readFile, writeFile } from "node:fs/promises";
import path from "node:path";

const root = process.cwd();
const source = await readFile(path.join(root, "productos/mvk-nino-h/index.html"), "utf8");
const products = [
  { slug: "mvk-nino-m", name: "MVK Niño M", type: "Montura oftálmica", audience: "Niña", category: "Niños", images: ["mvk niño M - 1.jpg", "mvk niño M - 2.jpg", "mvk niño M - 3.jpg"] },
  { slug: "nano-nino-m", name: "Nano Niño M", type: "Montura oftálmica", audience: "Niña", category: "Niños", images: ["nano niño M - 1.jpg", "nano niño M - 2.jpg", "nano niño M - 3.jpg"] },
  { slug: "nano-nino-v", name: "Nano Niño V", type: "Montura oftálmica", audience: "Niños", category: "Niños", images: ["nano niño V - 1.jpg", "nano niño V - 2.jpg", "nano niño V - 3.jpg"] },
  { slug: "sol-polarizado-h", name: "Sol Polarizado H", type: "Lente de sol polarizado", audience: "Hombre", category: "Sol", images: ["sol polarizado H - 1.jpg", "sol polarizado H - 2.jpg", "sol polarizado H - 3.jpg"] },
  { slug: "sol-polarizado-m", name: "Sol Polarizado M", type: "Lente de sol polarizado", audience: "Mujer", category: "Sol", images: Array.from({ length: 6 }, (_, i) => `sol polarizado M - ${i + 1}.jpg`) },
  { slug: "sol-uv-400-h", name: "Sol UV 400 H", type: "Lente de sol UV 400", audience: "Hombre", category: "Sol", images: ["sol UV 400 H - 1.jpg", "sol UV 400 H - 2.jpg", "sol UV 400 H - 3.jpg"] }
];

function escapeHtml(value) {
  return value.replace(/[&<>"']/g, (character) => ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" })[character]);
}

for (const product of products) {
  const escapedName = escapeHtml(product.name);
  const title = `${escapedName}: ${product.type.toLowerCase()} | Oftalvista`;
  const description = `Conoce ${product.name} de Oftalvista. Revisa sus ${product.images.length} variantes y consulta disponibilidad en nuestra óptica en Lince, Lima.`;
  const images = product.images.map((filename, index) => {
    const image = `/LENTES/${encodeURIComponent(filename).replaceAll("%2F", "/")}`;
    const pressed = index === 0 ? "true" : "false";
    const loading = index === 0 ? 'fetchpriority="high"' : 'loading="lazy" decoding="async"';
    return `<button class="product-gallery__thumb" type="button" data-gallery-image="${image}" data-gallery-alt="${escapedName}, variante ${index + 1}" aria-label="Ver variante ${index + 1}" aria-pressed="${pressed}"><img src="${image}" alt="" width="120" height="120" ${loading}></button>`;
  }).join("");
  const whatsappText = encodeURIComponent(`Hola, quisiera consultar por ${product.name}.`);
  let html = source
    .replaceAll("MVK Niño H", escapedName)
    .replaceAll("mvk-nino-h", product.slug)
    .replace("Montura oftálmica · Niño", `${escapeHtml(product.type)} · ${escapeHtml(product.audience)}`)
    .replace("Montura oftálmica infantil MVK Niño H", `${escapeHtml(product.type)} ${escapeHtml(product.audience)} ${escapedName}`)
    .replace("tres variantes", `${product.images.length} variantes`)
    .replace("montura MVK Niño H", `${product.type.toLowerCase()} ${product.name}`)
    .replace("MVK%20Ni%C3%B1o%20H", encodeURIComponent(product.name))
    .replaceAll("../../", "/");
  html = html
    .replace(/<title>[^<]*<\/title>/, `<title>${title}</title>`)
    .replace(/<meta name="description" content="[^"]*">/, `<meta name="description" content="${escapeHtml(description)}">`)
    .replace(/<link rel="canonical" href="[^"]*">/, `<link rel="canonical" href="https://oftalvista.com.pe/productos/${product.slug}/">`)
    .replace(/<span class="optics-kicker">Montura oftálmica · [^<]*<\/span>/, `<span class="optics-kicker">${escapeHtml(product.type)} · ${escapeHtml(product.audience)}</span>`)
    .replace(/<p>Explora las [^<]*<\/p>/, `<p>Conoce este modelo y sus ${product.images.length} variantes. Escríbenos para consultar disponibilidad y recibir asesoría personalizada.</p>`)
    .replace(/href="https:\/\/wa\.me\/51978662299\?text=[^"]*"/, `href="https://wa.me/51978662299?text=${whatsappText}"`)
    .replace(/<main class="product-detail product-detail--page">[\s\S]*?<\/main>/, `<main class="product-detail product-detail--page"><nav class="product-breadcrumb" aria-label="Ruta de navegación"><a href="/opticas.html#catalogo">Ópticas</a><span aria-hidden="true">/</span><span>${escapedName}</span></nav><div class="product-detail__layout"><section class="product-gallery" aria-label="Galería de ${escapedName}"><div class="product-gallery__main"><img data-gallery-main src="${`/LENTES/${encodeURIComponent(product.images[0]).replaceAll("%2F", "/")}`}" alt="${escapedName}, vista principal" width="1200" height="1200" fetchpriority="high"></div><div class="product-gallery__thumbs" aria-label="Seleccionar variante">${images}</div></section><section class="product-detail__info"><span class="optics-kicker">${escapeHtml(product.type)} · ${escapeHtml(product.audience)}</span><h1>${escapedName}</h1><p class="product-detail__description">Conoce este modelo y sus ${product.images.length} variantes. Escríbenos para consultar disponibilidad y recibir asesoría personalizada.</p><ul class="product-detail__specs"><li><strong>Categoría:</strong> ${escapeHtml(product.category)}</li><li><strong>Tipo:</strong> ${escapeHtml(product.type)}</li><li><strong>Público:</strong> ${escapeHtml(product.audience)}</li><li><strong>Variantes:</strong> ${product.images.length}</li></ul><div class="product-detail__actions"><a class="product-detail__consult" href="https://wa.me/51978662299?text=${whatsappText}" target="_blank" rel="noopener noreferrer">Consultar por WhatsApp ↗</a><a class="product-detail__back-action" href="/opticas.html#catalogo">← Volver al catálogo</a></div></section></div></main>`);
  html = html.replace(/<script>document.querySelectorAll\("\[data-gallery-image\]"\)[\s\S]*?<\/script>/, "");
  html = html.replace(/<script>document.querySelectorAll\("\[data-gallery-image\]"\)[\s\S]*?<\/script>/g, "");
  html = html.replace(/<script>document.querySelectorAll\("\[data-gallery-image\]"\)[\s\S]*?<\/script>/g, "");
  html = html.replace("</body>", `<script>document.querySelectorAll("[data-gallery-image]").forEach((button) => button.addEventListener("click", () => { const image = document.querySelector("[data-gallery-main]"); image.src = button.dataset.galleryImage; image.alt = button.dataset.galleryAlt; document.querySelectorAll("[data-gallery-image]").forEach((item) => item.setAttribute("aria-pressed", String(item === button))); }));</script></body>`);
  const directory = path.join(root, "productos", product.slug);
  await mkdir(directory, { recursive: true });
  await writeFile(path.join(directory, "index.html"), html, "utf8");
}

console.log(`Generated ${products.length} product pages.`);






