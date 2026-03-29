# Testing Admin Boilerplate

## Environment Setup

1. **Install dependencies**: `composer install && npm install`
2. **Generate Wayfinder routes**: `php artisan wayfinder:generate` (required before frontend can compile)
3. **Migrate and seed**: `php artisan migrate:fresh --seed` (creates 26 users: 1 admin + 25 factory)
4. **Start dev server**: `composer run dev` (starts Laravel serve + Vite + queue + pail via concurrently)
   - Laravel: http://localhost:8000
   - Vite: http://localhost:5173

## Devin Secrets Needed

No external secrets required. The app uses SQLite and seeded test accounts.

## Test Account

- **Email**: admin@example.com
- **Password**: password
- This account is created by `database/seeders/UserSeeder.php`

## Key Pages & Navigation

- **Login**: `/login`
- **Dashboard**: `/dashboard` — 3 stat cards (Total Users, New This Month, Settings placeholder) + Recent Users table (last 5)
- **Users Index**: `/admin/users` — Paginated table (10/page), search, CRUD actions
- **Create User**: `/admin/users/create` — Name, Email, Password, Confirm Password
- **Edit User**: `/admin/users/{id}/edit` — Pre-filled Name and Email
- **Appearance**: `/settings/appearance` — Light/Dark/System theme toggle
- Sidebar has "Dashboard" and "Users" nav items

## Critical Testing Flows

### 1. Pagination (verifies PaginatedData type)
- Navigate to Users page
- Should show "Showing 1 to 10 of 26 users" with page buttons 1, 2, 3
- Click through all pages — if PaginatedData type is wrong (nested vs flat), the page will crash with TypeError

### 2. CRUD + Flash Toasts (verifies Sonner integration)
- Create a user → expect green toast "User created successfully."
- Edit the user → expect green toast "User updated successfully."
- Delete the user → confirmation dialog shows user name → expect green toast "User deleted successfully."
- If Sonner import is wrong (raw 'sonner' vs themed wrapper), toasts won't render

### 3. Search
- Type in search box on Users page → table filters in real-time
- URL updates with `?search=` query param

### 4. Self-Deletion Guard
- The logged-in admin user's row should NOT have a Delete button
- All other users should have both Edit and Delete

### 5. Dark Mode Toasts (verifies useAppearance hook)
- Go to Settings > Appearance, click "Dark"
- Trigger a toast (create/edit/delete user)
- Toast should render with dark styling matching the dark UI
- If useTheme() from next-themes is used instead of useAppearance(), theme falls back to 'system'

## Running Tests

- **Pest (PHP)**: `php artisan test` — 9 feature tests for UserController + Dashboard
- **Vitest (JS)**: `npm run test` — 12 component tests
- **Biome lint**: `npx @biomejs/biome check .` — expect 0 errors (warnings are acceptable for starter kit code)

## Common Issues

- **Wayfinder routes missing**: If frontend fails to compile with import errors for `@/routes/...`, run `php artisan wayfinder:generate`
- **Pre-existing TypeScript errors**: `tsc --noEmit` reports ~15 errors from starter kit files (`.form` property on Wayfinder route helpers). These are not introduced by the admin boilerplate.
- **Biome warnings**: ~50 warnings are expected from starter kit code. Only 0 errors should be present.
- **Flaky search test**: The Pest search test uses "John Doe" as the search term (not just "John") to avoid matching the randomly-generated auth user name.
