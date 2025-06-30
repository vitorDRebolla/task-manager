# 📝 TaskBoard – Task Management App with Drag & Drop

A full-stack task management application built with **Laravel 10**, **Vue 3**, **Inertia.js**, and **Pinia**. It allows you to create, update, delete, and drag tasks between status columns with persistent ordering.

---

## 🚀 Technologies Used

- ⚙️ **[Laravel 10](https://laravel.com/)** – Back-end framework
- ⚡ **[Vue 3](https://vuejs.org/)** – Progressive front-end framework
- 🎯 **[Inertia.js](https://inertiajs.com/)** – Connects Laravel and Vue without APIs
- 🍃 **[Pinia](https://pinia.vuejs.org/)** – State management for Vue
- 💨 **[Tailwind CSS](https://tailwindcss.com/)** – Utility-first CSS framework
- 🧩 **[vuedraggable@next](https://github.com/SortableJS/vue.draggable.next)** – Drag and drop support

---

## 📦 Installation

Follow the steps below to run the project locally.

### 1. Clone the repository

```bash
git clone https://github.com/vitorDRebolla/task-manager.git
cd task-manager
```

### 2. Install PHP and JavaScript dependencies
```bash
composer install
npm install
```

### 3. Configure environment variables
```bash
cp .env.example .env
```

### 4. Generate application key
```bash
php artisan key:generate
```

### 5. Run migrations
```bash
php artisan migrate
```

### 6. Start the development server
```bash
php artisan serve
```

### 7. Compile frontend assets with Vite
```bash
npm run dev
```

Visit: http://localhost:8000

## 📁 Project Structure (simplified)

├── app/               # Laravel backend logic
├── database/          # Migrations
├── public/            # Public assets
├── resources/
│   └── js/
│       ├── Components/   # Vue components (cards, modals)
│       └── Pages/        # Inertia pages
├── routes/
│   └── web.php           # Application routes
└── ...

👨‍💻 Author
Crafted with 💻 and ☕ by Vitor Rebolla
