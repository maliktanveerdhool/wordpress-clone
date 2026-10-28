# WordPress Clone

A WordPress-style publishing platform built with **Laravel 13**, **Blade** and **Tailwind CSS 4**. It ships with a polished public blog, a complete admin dashboard, and seeded demo content so you can explore everything immediately.

> Posts, categories, tags, threaded comments, static pages, image uploads and site settings — all in a single, readable Laravel codebase.

---

## Badges

![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3%2B-777BB4?logo=php&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4.x-06B6D4?logo=tailwindcss&logoColor=white)
![Tests](https://img.shields.io/badge/tests-16_passing-16a34a)
![License](https://img.shields.io/badge/license-MIT-blue)

---

## Overview

**WordPress Clone** is a full-featured blogging application that mirrors the familiar WordPress content model without the plugin sprawl:

- A **public magazine-style site** with a featured hero, post grid, archives, search, author boxes and comments.
- A **WordPress-inspired admin area** with dashboards, post editor, media uploads, taxonomy management, comment moderation and site settings.
- **Seed data** including 10 published posts, a draft, 4 categories, 14 tags, threaded comments and 2 static pages.

The project is intentionally built with first-party Laravel features only — no admin-panel packages, no CMS dependencies — so every part of the stack is easy to read, extend and deploy.

---

## Features

### Public site

- Featured post hero and paginated latest-posts grid
- Category and tag archives with post counts
- Full-text search across titles, excerpts and bodies
- Single post view with Markdown rendering, reading time, view counter and related posts
- Threaded comments with validation and spam throttling
- Static pages (About, Contact) in the main navigation
- Responsive layout with a mobile menu that works without JavaScript
- Author avatars generated locally from initials — no external requests

### Admin dashboard

- At-a-glance stats: published posts, drafts, total views, comments, pending moderation and categories
- Recent posts, latest comments and most-viewed posts
- Post editor with Markdown content, excerpt, slug, category, tags, featured flag, scheduling and image upload
- Category management with accent colours and descriptions
- Tag management with inline creation and usage counts
- Comment moderation: approve, unapprove and delete
- Page management for static content
- Site settings (title, tagline, description, footer copy) stored in the database
- Admin-only middleware and session authentication

---

## Tech stack

| Layer | Technology |
| --- | --- |
| Framework | Laravel 13 |
| Language | PHP 8.3+ |
| Templating | Blade components and layouts |
| Styling | Tailwind CSS 4 (Vite plugin) |
| Build tool | Vite 8 |
| Database | SQLite (default), MySQL/PostgreSQL ready |
| Testing | Pest 5 |
| Fonts | Instrument Sans & Instrument Serif (self-hosted via Bunny) |

---

## Requirements

- PHP **8.3** or newer with the `pdo_sqlite` extension
- Composer **2**
- Node.js **20+** and npm
- SQLite (bundled with PHP) or another Laravel-supported database

---

## Installation

```bash
# 1. Clone the repository
git clone https://github.com/maliktanveerdhool/wordpress-clone.git
cd wordpress-clone

# 2. Install PHP dependencies
composer install

# 3. Create the environment file and application key
cp .env.example .env
php artisan key:generate

# 4. Create the SQLite database
touch database/database.sqlite

# 5. Run migrations and seed the demo content
php artisan migrate --seed

# 6. Install front-end dependencies and build assets
npm install
npm run build
```

Start the development server:

```bash
php artisan serve
# or run the full dev stack (server, queue, logs, Vite)
composer dev
```

The site is now available at **http://localhost:8000**.

> **Laravel Herd users:** the site is served automatically at `http://wordpress-clone.test` once the folder is in your Herd path. Herd derives the domain from the folder name, so a checkout in a folder called `wordpress-testings` will be served at `http://wordpress-testings.test` instead.

---

## Demo credentials

The seeder creates two administrator accounts. Both use the password `password`.

| Role | Email | Password |
| --- | --- | --- |
| Administrator | `admin@example.com` | `password` |
| Editor | `priya@example.com` | `password` |

The login screen is available at `/login` and pre-fills the demo account for convenience.

---

## Testing

The feature suite covers the public blog, comment validation, authentication and the admin area.

```bash
php artisan test
# or
./vendor/bin/pest
```

All tests run against an in-memory SQLite database using `RefreshDatabase`.

---

## Project structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/            # Dashboard, posts, categories, tags, comments, pages, settings
│   │   ├── Auth/             # Session login and logout
│   │   ├── CommentController.php
│   │   ├── HomeController.php
│   │   ├── PostController.php
│   │   └── ...
│   ├── Middleware/           # EnsureUserIsAdmin
│   └── Requests/             # Post, page and category form requests
├── Models/
│   ├── Concerns/HasSlug.php  # Unique slug generation
│   ├── Category.php
│   ├── Comment.php
│   ├── Page.php
│   ├── Post.php
│   ├── Setting.php
│   └── Tag.php
database/
├── migrations/               # Posts, categories, tags, comments, pages, settings
└── seeders/                  # Demo users, content, taxonomies and settings
resources/
├── css/app.css               # Tailwind theme and article prose styles
└── views/
    ├── admin/                # Dashboard and CRUD screens
    ├── components/           # Avatar, category pill, post card
    ├── layouts/              # Public and admin layouts
    ├── partials/             # Header, footer, sidebar, flash messages
    └── posts/                # Single post view
routes/web.php                # Public and admin routes
```

---

## Routes at a glance

| Method | URI | Description |
| --- | --- | --- |
| `GET` | `/` | Home page with featured and latest posts |
| `GET` | `/posts/{slug}` | Single post |
| `POST` | `/posts/{slug}/comments` | Submit a comment |
| `GET` | `/categories/{slug}` | Category archive |
| `GET` | `/tags/{slug}` | Tag archive |
| `GET` | `/search?q=…` | Search results |
| `GET` | `/pages/{slug}` | Static page |
| `GET` | `/login` | Admin login |
| `GET` | `/admin` | Dashboard (auth + admin) |
| `GET/POST/PUT/DELETE` | `/admin/posts` | Post management |
| `GET/POST/PUT/DELETE` | `/admin/categories` | Category management |
| `GET/POST/DELETE` | `/admin/tags` | Tag management |
| `GET/PATCH/DELETE` | `/admin/comments` | Comment moderation |
| `GET/POST/PUT/DELETE` | `/admin/pages` | Page management |
| `GET/PUT` | `/admin/settings` | Site settings |

---

## Writing content

- Post bodies and static pages accept **Markdown**, rendered server-side with Laravel's CommonMark integration.
- Slugs are generated automatically from the title when left blank, with collision handling.
- Featured images can be uploaded through the editor; files are stored in `public/uploads/posts`.
- Posts can be saved as **drafts** or **published**, with an optional publish date for scheduling.
- The featured flag promotes a post into the hero on the home page.

---

## License

Released under the [MIT License](LICENSE).

Built by [maliktanveerdhool](https://github.com/maliktanveerdhool).
