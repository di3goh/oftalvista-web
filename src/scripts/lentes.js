const products = [
  { slug: "mvk-nino-h", name: "MVK Niño H", category: "Niños", type: "Montura oftálmica", audience: "Niño", count: 3, files: ["mvk niño H - 1.jpg", "mvk niño H - 2.jpg", "mvk niño H - 3.jpg"] },
  { slug: "mvk-nino-m", name: "MVK Niño M", category: "Niños", type: "Montura oftálmica", audience: "Niña", count: 3, files: ["mvk niño M - 1.jpg", "mvk niño M - 2.jpg", "mvk niño M - 3.jpg"] },
  { slug: "nano-nino-m", name: "Nano Niño M", category: "Niños", type: "Montura oftálmica", audience: "Niña", count: 3, files: ["nano niño M - 1.jpg", "nano niño M - 2.jpg", "nano niño M - 3.jpg"] },
  { slug: "nano-nino-v", name: "Nano Niño V", category: "Niños", type: "Montura oftálmica", audience: "Niños", count: 3, files: ["nano niño V - 1.jpg", "nano niño V - 2.jpg", "nano niño V - 3.jpg"] },
  { slug: "sol-polarizado-h", name: "Sol Polarizado H", category: "Sol", type: "Lente de sol polarizado", audience: "Hombre", count: 3, files: ["sol polarizado H - 1.jpg", "sol polarizado H - 2.jpg", "sol polarizado H - 3.jpg"] },
  { slug: "sol-polarizado-m", name: "Sol Polarizado M", category: "Sol", type: "Lente de sol polarizado", audience: "Mujer", count: 6, files: Array.from({ length: 6 }, (_, index) => `sol polarizado M - ${index + 1}.jpg`) },
  { slug: "sol-uv-400-h", name: "Sol UV 400 H", category: "Sol", type: "Lente de sol UV 400", audience: "Hombre", count: 3, files: ["sol UV 400 H - 1.jpg", "sol UV 400 H - 2.jpg", "sol UV 400 H - 3.jpg"] }
].sort((a, b) => a.name.localeCompare(b.name, "es"));

const grid = document.querySelector("[data-products-grid]");
const status = document.querySelector("[data-catalog-status]");
const detail = document.querySelector("[data-product-detail]");
const filters = document.querySelectorAll("[data-product-filter]");
const imagePath = (file) => `./LENTES/${encodeURIComponent(file).replaceAll("%2F", "/")}`;
let activeFilter = "Todos";

function escapeHtml(value = "") {
  return String(value).replace(/[&<>\'"]/g, (character) => ({
    "&": "&amp;", "<": "&lt;", ">": "&gt;", "'": "&#39;", '"': "&quot;"
  })[character]);
}

function card(product) {
  return `<article class="product-card">
    <a class="product-card__open" href="./productos/${product.slug}/" aria-label="Ver ${escapeHtml(product.name)} y sus ${product.count} variantes">
      <div class="product-card__media"><img src="${imagePath(product.files[0])}" alt="${escapeHtml(product.name)} — variante 1" loading="lazy"><span class="product-card__availability">${product.count} variantes</span></div>
      <div class="product-card__body">
        <div class="product-card__eyebrow"><span>Oftalvista</span><span>${escapeHtml(product.category)}</span></div>
        <h2>${escapeHtml(product.name)}</h2>
        <p>${escapeHtml(product.type)} · ${escapeHtml(product.audience)}</p>
        <div class="product-card__details"><span>${product.count} fotos disponibles</span><span>Ver modelo ↗</span></div>
      </div>
    </a>
  </article>`;
}

function render() {
  if (!grid || !status) return;
  const visible = activeFilter === "Todos" ? products : products.filter((product) => product.category === activeFilter);
  grid.innerHTML = visible.map(card).join("");
  status.textContent = `${visible.length} ${visible.length === 1 ? "modelo" : "modelos"} · ${visible.reduce((sum, product) => sum + product.count, 0)} variantes`;
}

filters.forEach((button) => button.addEventListener("click", () => {
  activeFilter = button.dataset.productFilter;
  filters.forEach((item) => {
    const selected = item === button;
    item.classList.toggle("is-active", selected);
    item.setAttribute("aria-pressed", String(selected));
  });
  render();
}));

render();
