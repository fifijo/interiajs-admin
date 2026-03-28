# Admin Boilerplate

A modern admin panel built with Laravel and React, featuring a complete user management system.

## Tech Stack

| Layer       | Technology                                                    |
| ----------- | ------------------------------------------------------------- |
| Backend     | Laravel 13, PHP 8.3+                                         |
| Frontend    | React 19, TypeScript, Tailwind CSS 4                         |
| Bridge      | Inertia.js v3, Wayfinder (type-safe routes)                  |
| Components  | shadcn/ui (Radix primitives)                                 |
| Linting     | Biome (replaces ESLint + Prettier)                           |
| Testing     | Pest (feature), Vitest (component), Playwright (E2E)         |
| AI Tooling  | Laravel Boost (MCP servers, skills, guidelines)              |
| Database    | SQLite (default), MySQL/PostgreSQL supported                 |

## Prerequisites

- PHP 8.3+
- Composer
- Node.js 18+
- npm

## Quick Start

```bash
# Clone and install
git clone <repo-url> && cd admin-boilerplate
composer install
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Set up database
php artisan migrate
php artisan db:seed   # Creates admin user + 25 test users

# Start development
composer run dev      # Starts PHP server + Vite dev server
```

### Default Admin Account

After seeding, log in with:
- **Email:** admin@example.com
- **Password:** password

## AI Agent Setup

This project includes [Laravel Boost](https://github.com/laravel/boost) for AI-assisted development:

```bash
php artisan boost:install    # Select your AI agent (Cursor, etc.)
```

This generates `.mcp.json` for your editor with tools for database queries, schema inspection, error logs, and Laravel docs search.

## Development Commands

```bash
# Code quality
npm run check           # Biome check (format + lint + organize imports)
npm run format          # Biome format only
npm run lint            # Biome lint only
npm run types:check     # TypeScript type checking

# Testing
php artisan test        # Pest feature tests
npm run test            # Vitest component tests
npm run test:e2e        # Playwright E2E tests

# Build
npm run build           # Production build
npm run build:ssr       # SSR production build
```

## Adding shadcn/ui Components

```bash
npx shadcn@latest add <component-name>
```

Components are installed to `resources/js/components/ui/`. See [shadcn/ui docs](https://ui.shadcn.com/docs) for the full component list.

## Adding Admin Pages

1. Create a controller in `app/Http/Controllers/Admin/`
2. Add a route in `routes/web.php` under the admin prefix
3. Run `php artisan wayfinder:generate` for type-safe route helpers
4. Create the page component in `resources/js/pages/admin/`
5. Add a nav item in `resources/js/components/app-sidebar.tsx`

## Project Structure

```
app/
├── Http/Controllers/Admin/    # Admin controllers (UserController)
├── Http/Requests/Admin/       # Form request validation
├── Policies/                  # Authorization policies
resources/js/
├── components/ui/             # shadcn/ui components
├── layouts/                   # App and auth layouts
├── pages/
│   ├── admin/users/           # User CRUD pages
│   ├── auth/                  # Authentication pages
│   ├── settings/              # User settings pages
│   └── dashboard.tsx          # Dashboard with stats
├── tests/                     # Vitest component tests
tests/
├── Feature/Admin/             # Pest feature tests
├── e2e/                       # Playwright E2E tests
```

## Layout Variants

The starter kit includes multiple layout options:
- **Sidebar:** inset (default), floating, default
- **Auth:** simple, card, split
