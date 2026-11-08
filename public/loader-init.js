// Run before styles are painted so later page visits never flash the loader.
try {
  if (!sessionStorage.getItem('oftalvista-loader-seen')) {
    sessionStorage.setItem('oftalvista-loader-seen', '1');
    document.documentElement.classList.add('show-page-loader');
  }
} catch {
  // If storage is unavailable, keep navigation immediate.
}
