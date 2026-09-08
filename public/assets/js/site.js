const comparisons = document.querySelectorAll("[data-comparison]");
const header = document.querySelector(".site-header");
const menuToggle = document.querySelector(".menu-toggle");
const revealSections = document.querySelectorAll(".reveal-section");
const pageLoader = document.querySelector("[data-page-loader]");
const serviceFilters = document.querySelectorAll(".services-filter");
const serviceCards = document.querySelectorAll("[data-service-category]");
const socialProfiles = {
  tiktok: "https://www.tiktok.com/@cmoftalvista",
  instagram: "https://www.instagram.com/oftalvista.oliveros/",
  facebook: "https://www.facebook.com/profile.php?id=100064055949475"
};
const whatsappAppointmentUrl = "https://wa.me/51978662299?text=Buenos%20d%C3%ADas%2C%20quisiera%20mas%20informaci%C3%B3n%20para%20una%20consulta%20oftalmol%C3%B3gica.";

const applyEditableSiteSettings = async () => {
  try {
    const response = await fetch("/api/site-settings.php", { headers: { Accept: "application/json" } });
    if (!response.ok) return;
    const settings = await response.json();
    const digits = (settings["contact.whatsapp"] || "").replace(/\D/g, "");
    const whatsappUrl = digits
      ? `https://wa.me/${digits}?text=${encodeURIComponent("Buenos días, quisiera más información para una consulta oftalmológica.")}`
      : whatsappAppointmentUrl;

    document.querySelectorAll('.icon-button[href^="tel:"]').forEach((link) => {
      link.href = `tel:${settings["contact.phone"] || "+51978662299"}`;
    });
    document.querySelectorAll(".appointment-button, .cataract-signs a, .white-cta-button, .whatsapp-float").forEach((link) => {
      link.href = whatsappUrl;
    });
    document.querySelectorAll(".appointment-button span").forEach((label) => {
      if (settings["header.appointment"]) label.textContent = settings["header.appointment"];
    });

    const navLabels = {
      "/": settings["nav.home"],
      "/servicios": settings["nav.services"],
      "/testimonios": settings["nav.testimonials"],
      "/preguntas": settings["nav.questions"],
      "/blog": settings["nav.blog"]
    };
    document.querySelectorAll(".main-nav a, .footer-nav a").forEach((link) => {
      const path = new URL(link.href, window.location.href).pathname.toLowerCase();
      if (navLabels[path]) link.textContent = navLabels[path];
    });
    document.querySelectorAll(".footer-social a").forEach((link) => {
      const name = link.textContent.trim().toLowerCase();
      if (settings[`social.${name}`]) link.href = settings[`social.${name}`];
    });
  } catch (_) {
    // El sitio conserva sus valores iniciales si la API está temporalmente fuera de línea.
  }
};

applyEditableSiteSettings();

document.querySelectorAll('.icon-button[href^="tel:"]').forEach((link) => {
  link.href = "tel:+51978662299";
});

document.querySelectorAll(".appointment-button, .cataract-signs a, .white-cta-button").forEach((link) => {
  link.href = whatsappAppointmentUrl;
  link.target = "_blank";
  link.rel = "noopener";
});

document.querySelectorAll(".footer-social a").forEach((link) => {
  const label = link.textContent.trim().toLowerCase();
  const profile = socialProfiles[label];
  if (!profile) return;
  link.href = profile;
  link.target = "_blank";
  link.rel = "noopener";
});

document.querySelectorAll('a[target="_blank"]').forEach((link) => {
  const rel = new Set((link.getAttribute("rel") || "").split(/\s+/).filter(Boolean));
  rel.add("noopener");
  rel.add("noreferrer");
  link.setAttribute("rel", [...rel].join(" "));
});

document.querySelectorAll('iframe[src*="google.com/maps"]').forEach((frame) => {
  frame.setAttribute("referrerpolicy", "no-referrer");
});

document.querySelectorAll('.subfooter a[href="#"]').forEach((link) => {
  const credit = document.createElement("span");
  credit.textContent = link.textContent;
  link.replaceWith(credit);
});

const navigationDestinations = {
  servicios: "/servicios",
  resultados: "/testimonios",
  preguntas: "/preguntas"
};

document.querySelectorAll(".main-nav a, .footer-nav a").forEach((link) => {
  const href = link.getAttribute("href") || "";
  const section = Object.keys(navigationDestinations).find((key) => href.endsWith(`#${key}`));
  if (section) link.setAttribute("href", navigationDestinations[section]);
});

if (!document.querySelector('link[rel="canonical"]')) {
  const canonical = document.createElement("link");
  canonical.rel = "canonical";
  const currentPath = window.location.pathname.replace(/\/index\.(?:html|php)$/, "/");
  canonical.href = `https://oftalvista.com.pe${currentPath}`;
  document.head.append(canonical);
}

const hidePageLoader = () => {
  pageLoader?.classList.add("is-hidden");
  window.setTimeout(() => pageLoader?.remove(), 320);
};

if (pageLoader) {
  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    hidePageLoader();
  } else {
    window.setTimeout(hidePageLoader, 760);
  }
}

serviceFilters.forEach((filter) => {
  filter.addEventListener("click", () => {
    const selected = filter.textContent.trim().toLowerCase();
    serviceFilters.forEach((item) => {
      const isActive = item === filter;
      item.classList.toggle("services-filter--active", isActive);
      item.setAttribute("aria-pressed", String(isActive));
    });

    serviceCards.forEach((card) => {
      const category = card.dataset.serviceCategory;
      const showCard = selected === "todos" || category === selected;
      card.hidden = !showCard;
    });
  });
});

document.documentElement.classList.add("has-scroll-reveal");

if ("IntersectionObserver" in window) {
  const revealObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach((entry) => {
      if (!entry.isIntersecting) return;
      entry.target.classList.add("is-visible");
      observer.unobserve(entry.target);
    });
  }, { rootMargin: "0px 0px -10% 0px", threshold: 0.12 });

  revealSections.forEach((section) => revealObserver.observe(section));
} else {
  revealSections.forEach((section) => section.classList.add("is-visible"));
}

comparisons.forEach((comparison) => {
  const range = comparison.querySelector(".comparison__range");

  const setPosition = (value) => {
    const clamped = Math.max(0, Math.min(100, Number(value)));
    comparison.style.setProperty("--position", `${clamped}%`);
    range.value = clamped;
  };

  const updateFromPointer = (event) => {
    const rect = comparison.getBoundingClientRect();
    const x = event.clientX - rect.left;
    setPosition((x / rect.width) * 100);
  };

  range.addEventListener("input", (event) => setPosition(event.target.value));

  comparison.addEventListener("pointerdown", (event) => {
    comparison.setPointerCapture(event.pointerId);
    updateFromPointer(event);
  });

  comparison.addEventListener("pointermove", (event) => {
    if (comparison.hasPointerCapture(event.pointerId)) {
      updateFromPointer(event);
    }
  });
});

const easeOutCubic = (value) => {
  return 1 - Math.pow(1 - value, 3);
};

const smoothScrollTo = (targetY, duration = 620) => {
  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    window.scrollTo(0, targetY);
    return;
  }

  const startY = window.scrollY;
  const distance = targetY - startY;
  const startTime = performance.now();

  const step = (now) => {
    const elapsed = now - startTime;
    const progress = Math.min(elapsed / duration, 1);
    window.scrollTo(0, startY + distance * easeOutCubic(progress));

    if (progress < 1) {
      requestAnimationFrame(step);
    }
  };

  requestAnimationFrame(step);
};

const closeMobileMenu = () => {
  header?.classList.remove("site-header--menu-open");
  menuToggle?.setAttribute("aria-expanded", "false");
  menuToggle?.setAttribute("aria-label", "Abrir menú");
};

const updateHeaderState = () => {
  if (!header) return;
  header.classList.toggle("site-header--scrolled", window.scrollY > 24);
};

menuToggle?.addEventListener("click", () => {
  const isOpen = header.classList.toggle("site-header--menu-open");
  menuToggle.setAttribute("aria-expanded", String(isOpen));
  menuToggle.setAttribute("aria-label", isOpen ? "Cerrar menú" : "Abrir menú");
});

document.querySelectorAll('a[href^="#"]').forEach((link) => {
  link.addEventListener("click", (event) => {
    const hash = link.getAttribute("href");
    const target = hash && hash !== "#" ? document.querySelector(hash) : null;

    closeMobileMenu();

    if (!target) return;

    event.preventDefault();

    const headerHeight = header?.getBoundingClientRect().height ?? 0;
    const targetY = target.id === "inicio"
      ? 0
      : target.getBoundingClientRect().top + window.scrollY - headerHeight - 18;

    smoothScrollTo(Math.max(targetY, 0));
    history.pushState(null, "", hash);
  });
});

window.addEventListener("scroll", () => {
  updateHeaderState();
}, { passive: true });

window.addEventListener("resize", () => {
  updateHeaderState();
});

updateHeaderState();
