<<<<<<< HEAD
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
=======
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
