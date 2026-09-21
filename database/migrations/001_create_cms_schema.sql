CREATE TABLE IF NOT EXISTS admin_users (
    id BIGSERIAL PRIMARY KEY,
    email VARCHAR(254) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS site_settings (
    key VARCHAR(100) PRIMARY KEY,
    value TEXT NOT NULL DEFAULT '',
    updated_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS posts (
    id BIGSERIAL PRIMARY KEY,
    title VARCHAR(160) NOT NULL,
    slug VARCHAR(180) NOT NULL UNIQUE CHECK (slug ~ '^[a-z0-9]+(-[a-z0-9]+)*$'),
    excerpt VARCHAR(300) NOT NULL,
    body TEXT NOT NULL,
    category VARCHAR(80) NOT NULL DEFAULT 'Salud Visual',
    author VARCHAR(120) NOT NULL DEFAULT 'Clínica Oftalvista',
    image_path VARCHAR(500) NOT NULL DEFAULT '',
    image_alt VARCHAR(180) NOT NULL DEFAULT '',
    reading_minutes SMALLINT NOT NULL DEFAULT 4 CHECK (reading_minutes BETWEEN 1 AND 60),
    status VARCHAR(12) NOT NULL DEFAULT 'draft' CHECK (status IN ('draft', 'published')),
    published_at TIMESTAMPTZ NOT NULL DEFAULT NOW(),
    meta_description VARCHAR(170) NOT NULL DEFAULT '',
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE INDEX IF NOT EXISTS posts_publication_idx ON posts (status, published_at DESC);

INSERT INTO site_settings (key, value) VALUES
('site.name', 'Oftalvista'),
('site.tagline', 'Cuidamos tu visión, mejoramos tu vida.'),
('nav.home', 'Inicio'), ('nav.services', 'Servicios'), ('nav.testimonials', 'Testimonios'), ('nav.questions', 'Preguntas'), ('nav.blog', 'Blog'),
('header.appointment', 'Reserva tu cita'),
('home.hero_title_before', 'Cuidamos la salud de tu'), ('home.hero_highlight', 'visión'), ('home.hero_title_after', 'con especialistas en oftalmología'),
('home.hero_description', 'Diagnóstico, prevención y tratamiento para la salud visual de niños, adultos y adultos mayores.'),
('home.stat_patients_value', '200+'), ('home.stat_patients_label', 'Pacientes Felices'),
('home.stat_surgeries_value', '50+'), ('home.stat_surgeries_label', 'Cirugías Exitosas'),
('home.stat_experience_value', '15+'), ('home.stat_experience_label', 'Años de experiencia'),
('home.services_title', 'Nuestros servicios a tu disposición'),
('home.services_description', 'Escuchamos, comprendemos y ofrecemos un cuidado oftalmológico de clase mundial que ha devuelto la visión a miles de pacientes.'),
('home.blog_title', 'Información para cuidar tu salud visual'),
('home.blog_description', 'Consejos, recomendaciones y contenido especializado de nuestros profesionales para ayudarte a cuidar tu visión.'),
('blog.title', 'Información para cuidar tu salud visual'),
('blog.description', 'Consejos, recomendaciones y contenido especializado de nuestros profesionales para ayudarte a cuidar tu visión.'),
('contact.phone', '+51978662299'), ('contact.whatsapp', '+51978662299'),
('contact.address', 'Av. Juan Pardo de Zela 437, Lince 15046'),
('contact.hours_title', 'Lunes a Sábado'), ('contact.hours', 'de 9:00 a.m a 7:30 p.m'),
('social.tiktok', 'https://www.tiktok.com/@cmoftalvista'),
('social.instagram', 'https://www.instagram.com/oftalvista.oliveros/'),
('social.facebook', 'https://www.facebook.com/profile.php?id=100064055949475'),
('footer.description', 'En Oftalvista, nos especializamos en el cuidado integral de la salud visual, ofreciendo atención profesional y tecnología de vanguardia para el diagnóstico y tratamiento de enfermedades oculares.')
ON CONFLICT (key) DO NOTHING;
