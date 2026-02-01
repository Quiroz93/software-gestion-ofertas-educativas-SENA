# Software para la Gestión de Ofertas Educativas  
**Centro Agroempresarial y Turístico de los Andes – SENA**

## 📌 Descripción del Proyecto
Este proyecto consiste en el desarrollo de un sistema web orientado a la gestión y publicación de las ofertas educativas del Centro Agroempresarial y Turístico de los Andes del SENA.  
La plataforma permitirá a los usuarios finales consultar de manera clara y estructurada los programas de formación disponibles en cada oferta académica, conocer sus características, requisitos, plan curricular, instructores y acceder a enlaces de inscripción.

El sistema se desarrolla bajo un enfoque ágil utilizando la metodología **Scrum**, aplicando buenas prácticas de desarrollo de software y control de versiones.

---

## 🎯 Objetivo General
Diseñar y desarrollar una plataforma web que permita:
- Gestionar internamente las ofertas educativas.
- Publicar información actualizada de programas de formación.
- Facilitar al usuario final el acceso a información académica y enlaces de inscripción.
- Brindar una experiencia de navegación clara, intuitiva y responsiva.

---

## 📚 Alcance del Sistema
El sistema contempla:
- Gestión de ofertas educativas por año y periodo.
- Gestión de programas de formación asociados a cada oferta.
- Administración de instructores y perfiles profesionales.
- Publicación de planes de desarrollo curricular.
- Visualización de logros y proyectos destacados.
- Integración de enlaces externos (inscripciones y entidades del Estado).
- Acceso público a la información.
- Acceso administrativo para gestión de contenidos.

---

## 🧑‍💻 Tecnologías Utilizadas

### Backend
- PHP
- Laravel

### Frontend
- Bootstrap
- AdminLTE

### Base de Datos
- MySQL

### Infraestructura y Herramientas
- Servidor Web: Apache
- Control de versiones: Git & GitHub
- Entorno de desarrollo: Visual Studio Code
- Gestión ágil: GitHub Projects (Scrum)

---

## 🏗️ Arquitectura General
El sistema se implementa bajo una arquitectura cliente-servidor:
- **Frontend:** Interfaz responsiva para usuarios finales y administradores.
- **Backend:** API y lógica de negocio desarrollada en Laravel.
- **Base de Datos:** Almacenamiento relacional bajo reglas ACID.
- **Seguridad:** Protección contra XSS, CSRF e inyección SQL.

---

## 👥 Equipo de Trabajo
- **Product Owner:** Yeison Ferney Sambrano Galeano  
- **Scrum Master:** Faiber Adrián Abril Alvarado  
- **Desarrolladores:**  
  - José Benigno Quiroz Quiroz  
  - Dylan Estaban Saavedra Poblador  

📆 **Periodicidad del Sprint:** Cada 2 semanas (sujeto a cambios)

---

## 🧩 Historias de Usuario (Resumen)
- Autenticación y gestión administrativa.
- Registro y consulta de ofertas educativas.
- Gestión de programas de formación.
- Visualización de instructores y redes de formación.
- Publicación de logros académicos.
- Generación de códigos QR para enlaces de inscripción.
- Acceso público sin necesidad de registro.

---

## ⚙️ Requerimientos No Funcionales
- Interfaz responsiva.
- Soporte para mínimo 500 usuarios concurrentes.
- Disponibilidad del 99%.
- Carga de páginas menor a 2 segundos.
- Seguridad y cumplimiento de buenas prácticas.

---

## 🚀 Instalación y Configuración

### Requisitos Previos
- PHP >= 8.2
- Composer
- MySQL
- Node.js y NPM

### Pasos de Instalación

1. **Clonar el repositorio:**
```bash
git clone <url-repositorio>
cd SoeSoftware2
```

2. **Instalar dependencias y configurar:**
```bash
composer setup
```

O de manera manual:
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate
npm install
npm run build
```

3. **Configurar base de datos en `.env`:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=soesoftware
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

4. **Ejecutar migraciones y seeders:**
```bash
php artisan migrate:fresh --seed
```

5. **Iniciar el servidor:**
```bash
php artisan serve
```

---

## 🧱 Sistema de Diseño (CSS SENA)

El proyecto utiliza una arquitectura modular de estilos con tokens, base, componentes, layouts y páginas. El punto de entrada es:

- `resources/css/app.css`

Para compilar assets:

```bash
npm run build
```

Para desarrollo con recarga:

```bash
npm run dev
```

---

## 🧪 Testing

```bash
php artisan test
```

5. **Iniciar servidor de desarrollo:**
```bash
php artisan serve
```

### ⚠️ Importante: Enlace Simbólico de Storage

El sistema requiere un enlace simbólico entre `public/storage` y `storage/app/public` para que funcionen las subidas de archivos (fotos de perfil, imágenes, documentos).

**Si las imágenes no se muestran, ejecuta:**
```bash
php artisan storage:link
```

Este comando ya está incluido en `composer setup`, pero puede ser necesario ejecutarlo nuevamente si:
- Clonas el proyecto en otra máquina
- Cambias de sistema operativo
- El directorio `public/storage` se elimina accidentalmente

---

## 🚀 Estado del Proyecto
📌 En desarrollo – fase de implementación inicial.

---

## 📄 Licencia
Este proyecto se distribuye bajo la **Licencia MIT**.  
Consulta el archivo [LICENSE](LICENSE) para más información.

---

## 📫 Contacto
Proyecto desarrollado con fines académicos para el Servicio Nacional de Aprendizaje (SENA).

>>>>>>> 2ced9f7a3f0f79eba891100b0d06f829b798e022
