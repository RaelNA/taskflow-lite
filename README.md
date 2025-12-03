# 🚀 TaskFlow Lite  
Un mini gestor de proyectos y tareas (tipo Kanban) desarrollado con **Astro** en el frontend y **PHP + MySQL** en el backend.  
Diseñado para demostrar mis aptitudes en desarrollo full-stack moderno, arquitectura limpia y consumo de APIs desde frontend moderno.

---

## 📌 Características principales

### 🔐 Autenticación
- Inicio de sesión seguro (PHP + MySQL)
- Validación de credenciales mediante API
- Sesión persistente con `localStorage`

### 🗂 Gestión de proyectos
- Listado de proyectos del usuario
- Creación de nuevos proyectos
- Relación 1-N entre usuarios y proyectos

### 📝 Gestión de tareas
- CRUD completo de tareas
- Estados: `todo`, `doing`, `done`
- Prioridades: `low`, `medium`, `high`
- Relación con proyectos
- Actualización automática por API

### 🎨 Frontend moderno
- Interfaz construida en **Astro**
- Estilos limpios y minimalistas
- Código organizado y escalable

### 🔧 Backend estructurado
- API REST en PHP
- Conexión MySQL optimizada (Prepared Statements)
- Endpoints separados por responsabilidad:
  - `/api/auth_login.php`
  - `/api/auth_register.php`
  - `/api/projects.php`
  - `/api/tasks.php`

---

## 🏗 Estructura del proyecto

```
taskflow-lite/
│
├── src/                       # Frontend Astro
│   ├── pages/
│   │   ├── index.astro        # Login
│   │   ├── dashboard.astro    # Panel principal
│   │   └── ...
│   ├── components/            # Componentes UI
│   └── lib/                   # Funciones fetch API
│
├── api/                       # Backend PHP (corre en XAMPP/Apache)
│   ├── conexion.php
│   ├── utils.php
│   ├── auth_login.php
│   ├── auth_register.php
│   ├── projects.php
│   └── tasks.php
│
├── public/
├── package.json
├── README.md
└── .gitignore
```

## 🛠 Tecnologías utilizadas

### **Frontend**
- Astro
- JavaScript
- HTML5 / CSS3

### **Backend**
- PHP 8 (API REST)
- MySQL (phpMyAdmin)
- mysqli + prepared statements

### **Herramientas**
- XAMPP
- VSCode
- Git / GitHub

---



