# Pastebin Clone — Agent Documentation

## Project Overview
Laravel 11 pastebin application with Docker development environment, Tailwind CSS v3, highlight.js for syntax highlighting, and Redis caching.
The application allows users to create, share, and view code snippets with syntax highlighting, password protection, and expiration controls.

## Tech Stack
- **Backend**: Laravel 11, PHP 8.2+ (8.4 locally), MySQL 8.0, Redis 7
- **Frontend**: Tailwind CSS v3, Vite 6, PostCSS, Autoprefixer
- **Infrastructure**: Docker Compose (4 services: app, nginx, db, redis)

## Project Structure
```
.
├── Dockerfile                  # Multi-stage PHP 8.2-fpm build
├── docker-compose.yml          # 4-service orchestration
├── nginx/default.conf          # Nginx reverse proxy to PHP-FPM
├── .dockerignore               # Docker build exclusions
├── .env / .env.example         # MySQL + Redis configuration
├── tailwind.config.js          # Tailwind CSS v3 config
├── vite.config.js              # Laravel Vite plugin
├── postcss.config.js           # PostCSS with Tailwind + Autoprefixer
├── resources/
│   ├── css/app.css             # Tailwind directives
│   ├── js/app.js               # Main JS entry point
│   └── views/layouts/app.blade.php  # Base Blade layout
└── config/                     # Published Laravel config files
```

## Environment Configuration
- **APP_NAME**: Pastebin
- **DB**: MySQL (host: db, database: pastebin, user: pastebin, pass: secret)
- **Redis**: host: redis, port: 6379
- **CACHE_DRIVER**: redis
- **SESSION_DRIVER**: redis

## Docker Services
| Service | Image | Port |
|---------|-------|------|
| app     | PHP 8.2-fpm (custom) | 9000 (internal) |
| nginx   | nginx:alpine | 3000→80 |
| db      | mysql:8.0 | 3306 |
| redis   | redis:7-alpine | 6379 |

## Build Commands
```bash
# Frontend
npm install        # Install JS dependencies
npm run build      # Build production assets
npm run dev        # Vite dev server

# Backend
composer install   # Install PHP dependencies
php artisan config:publish --all --force   # Publish config files

# Docker
docker compose up -d --build    # Start all services
docker compose down             # Stop all services
```

## View Templates (Phase 2)

### Blade Views (resources/views/)

| File | Purpose |
|------|---------|
| `layouts/app.blade.php` | Base layout with nav, flash messages (success/error/warning/info + validation errors), footer, scripts yield |
| `pastes/index.blade.php` | Homepage with hero section, paste cards grid (title/content preview/language badge/visibility badge/time), pagination, empty state |
| `pastes/create.blade.php` | Paste creation form: title, content textarea (monospace), language select (17 options), expiry select, visibility radios, password with toggle, client-side validation hints |
| `pastes/show.blade.php` | Paste detail: header with badges, action bar (Copy/Raw/Delete), highlight.js code block, share URL section |
| `pastes/password.blade.php` | Password gate: centered card with lock icon, password input, error display, back link |
| `pastes/expired.blade.php` | 410 Gone page: centered message, links to create new paste / home |

### Tailwind Component Classes (defined in app.css)
- `.btn`, `.btn-primary`, `.btn-secondary`, `.btn-danger`, `.btn-sm`, `.btn-lg` — Button styles
- `.form-input`, `.form-textarea`, `.form-select`, `.form-label` — Form styles
- `.form-radio`, `.form-radio-group`, `.form-radio-label` — Radio button styles
- `.badge`, `.badge-language`, `.badge-public`, `.badge-private`, `.badge-unlisted` — Badge styles
- `.alert`, `.alert-success`, `.alert-error`, `.alert-warning`, `.alert-info` — Alert styles
- `.paste-card` — Card hover effects
- `.code-block-wrapper`, `.copy-btn`, `.copy-btn.copied` — Code block styles
- Custom scrollbar styles for code blocks (WebKit + Firefox)

### JavaScript Features (app.js)
- **highlight.js**: Auto-highlights all `<pre><code>` blocks via `hljs.highlightAll()`
- **Copy to Clipboard**: `data-copy` attribute buttons copy target element text, show "Copied!" feedback for 2s
- **Password Toggle**: `data-password-toggle` buttons show/hide password fields with icon/toggle text swap
- **Flash Auto-dismiss**: Flash messages auto-fade after 5 seconds
- **GitHub Dark** theme for syntax highlighting

### CSS
- `resources/css/app.css`: Tailwind base/components/utilities + `@import 'highlight.js/styles/github-dark.css'` + custom component classes

### Frontend Dependencies
- highlight.js (npm package) — syntax highlighting library

## Key Files Created/Modified
1. **Dockerfile** — Multi-stage build with composer:2, PHP 8.2-fpm, extensions (pdo_mysql, mbstring, xml, redis, bcmath, gd)
2. **docker-compose.yml** — app, nginx, db (with healthcheck), redis services with named volumes
3. **nginx/default.conf** — try_files to index.php, fastcgi_pass to app:9000, gzip, security headers
4. **.dockerignore** — Excludes vendor, node_modules, .git, .env, storage logs, IDE files
5. **.env / .env.example** — Updated for MySQL and Redis
6. **tailwind.config.js** — Scans resources/views and resources/js, Inter font
7. **resources/views/layouts/app.blade.php** — Responsive nav (Home, New Paste), main content, footer
8. **resources/js/app.js** — Entry point importing bootstrap.js (axios)
9. **resources/css/app.css** — @tailwind base/components/utilities directives
10. **config/*.php** — Published all Laravel config files
11. **resources/views/pastes/index.blade.php** — Homepage with hero, paste cards, pagination
12. **resources/views/pastes/create.blade.php** — Paste creation form
13. **resources/views/pastes/show.blade.php** — Paste detail with syntax highlighting
14. **resources/views/pastes/password.blade.php** — Password gate
15. **resources/views/pastes/expired.blade.php** — Expired paste page

### Route Names (for views)
Views reference these named routes: `pastes.index`, `pastes.create`, `pastes.store`, `pastes.show`, `pastes.raw`, `pastes.password`, `pastes.password.submit`, `pastes.destroy`

## Notes
- Docker is NOT available in this environment, but all Docker config files are ready for deployment
- PHP 8.4 is installed locally (Laravel 11 requires 8.2+)
- npm build succeeded with 54 modules transformed
- Config publish completed for all 10 config files

## Phase 2 — Database & Model Layer

### Migration: `database/migrations/2024_01_01_000003_create_pastes_table.php`
Creates `pastes` table with columns: id, slug (unique 8-char), title (nullable 255), content (longText), language (default 'plaintext'), expiry_type, visibility, password (nullable bcrypt), is_burned (bool, default false), views_count (int, default 0), expires_at (nullable timestamp), timestamps. Indexes on: slug, visibility, expires_at, created_at.

### Model: `app/Models/Paste.php`
- **Fillable**: title, content, language, expiry_type, visibility, password
- **Hidden**: password
- **Casts**: is_burned ⇒ boolean, expires_at ⇒ datetime
- **Mutator**: `setPasswordAttribute` auto-hashes via `Hash::make()`, null-safe
- **Boot**: auto-generates slug (Str::random(8), unique) + sets expires_at via getExpiryDate() on creating
- **Scopes**: scopePublic, scopeNotExpired, scopeBySlug($slug)
- **Methods**: isExpired(), isPasswordProtected(), hasBurned(), getExpiryDate(): ?Carbon, generateSlug(): string, incrementViews(), burn()

### Factory: `database/factories/PasteFactory.php`
Generates realistic code snippets in 10 languages. States: public(), private(), unlisted(), neverExpires(), burnAfterRead(), passwordProtected($pw).

### Seeder: `database/seeders/PasteSeeder.php`
Seeds 50 public pastes (10 php, 10 javascript, 10 python, 5 html, 5 css, 5 json, 5 plaintext). Registered in DatabaseSeeder.

### Verified
- ✅ `php -l` syntax check on all 5 files
- ✅ `composer dump-autoload` (6348 classes)
- ✅ Migration runs on SQLite
- ✅ Model: all methods, scopes, mutator, boot logic
- ✅ Factory: all states
- ✅ Seeder: 50 pastes across 9 languages
- ✅ `isExpired()` and `hasBurned()` handle null values safely with (bool) cast
- ✅ `burn()` uses `forceFill()` to bypass fillable guard
- 5 Blade view templates created with Tailwind CSS component classes
- highlight.js integrated with GitHub Dark theme and copy-to-clipboard functionality

## Phase 3 — Backend Layer (PasteService, PasteController, Middleware, Routes)

### PasteService: `app/Services/PasteService.php`
Business logic layer for paste CRUD operations:
- `create(array $data): Paste` — Validates and creates a paste, auto-computes expiry via model boot
- `findBySlug(string $slug): Paste` — Finds paste by slug or throws `HttpResponseException` (404 + expired view)
- `getPublicPaginated(int $perPage): LengthAwarePaginator` — Public, non-expired pastes, newest first (20/page)
- `delete(Paste $paste): void` — Soft deletion
- `verifyPassword(Paste $paste, ?string $password): bool` — Hash::check for protected pastes

### PasteController: `app/Http/Controllers/PasteController.php`
7 methods returning the named views:
- `index()` → `pastes.index` (paginated public pastes)
- `create()` → `pastes.create` (creation form)
- `store(Request)` → validation then redirect to `pastes.show` with success flash
- `show(string $slug)` → `pastes.show`, applies expiry/burn/password checks, increments views
- `raw(string $slug)` → plain text `Response::make()` with `Content-Type: text/plain`
- `destroy(string $slug, Request)` → delete with `DeletionToken` verification
- `passwordForm(string $slug)` → `pastes.password` gate
- `passwordSubmit(Request, string $slug)` → verifies password, stores verified slug in session

### Validation Rules (store method)
- `content`: required, min:1, max:500000
- `title`: nullable, max:255
- `language`: required, in: plaintext, php, javascript, python, html, css, json, markdown, bash, sql, typescript, go, rust, java, ruby, c, cpp, yaml
- `expires_at`: required, in: burn, 1h, 1d, 1w, never
- `visibility`: required, in: public, private, unlisted
- `password`: nullable, min:3, max:255

### Middleware
- `app/Http/Middleware/CheckPasteExpiry.php` — Intercepts paste routes, checks if expired/burned → 410
- `app/Http/Middleware/CheckPastePassword.php` — Verifies session `verified_pastes` array, redirects to password gate
- Both registered in bootstrap/app.php as aliases: `paste.expiry`, `paste.password`

### Web Routes: `routes/web.php`
```
GET  /                             → pastes.index
GET  /create                       → pastes.create
POST /pastes                       → pastes.store
GET  /{slug}                       → pastes.show      (paste.expiry, paste.password)
GET  /{slug}/raw                   → pastes.raw       (paste.expiry)
GET  /{slug}/password              → pastes.password
POST /{slug}/password              → pastes.password.submit
DELETE /{slug}                     → pastes.destroy
DELETE /{slug}                     → pastes.destroy
```

### Phase 6: Admin Dashboard
- **Config**: `config/app.php` — `admin_password` key via `ADMIN_PASSWORD` env (default: `admin123`)
- **Middleware**: `app/Http/Middleware/AdminAuth.php` — Checks session `admin_authenticated`, redirects to `admin.login`
  - Registered in `bootstrap/app.php` as `admin` alias (alongside `paste.expiry`, `paste.password`)
- **Controller**: `app/Http/Controllers/Admin/DashboardController.php` — 6 methods:
  - `loginForm()` → `admin.login` view
  - `login(Request)` — validates password against `config('app.admin_password')`, sets session flag
  - `logout()` — clears session flag, redirects to login
  - `index(Request)` — `admin.dashboard` — paginated pastes (50/page) with filters (visibility, status, search) and stats (total/public/private/unlisted)
  - `destroy(string $slug)` — deletes paste by slug, redirects back
  - `destroyExpired()` — bulk deletes all expired/burned pastes, redirects back
  - `resources/views/admin/login.blade.php` — Centered card with lock icon, password field, error display, back-to-home link
  - `resources/views/admin/dashboard.blade.php` — Stats bar, filter form (visibility/status/search), "Delete All Expired" bulk button, paste table (slug→linked, title truncated, language/visibility/expiry badges, created, views, delete with confirmation), pagination, empty state
- **Layout**: Subtle "Admin" link in footer (`resources/views/layouts/app.blade.php`)
- **Environment**: `ADMIN_PASSWORD=admin123` added to `.env.example`

### Phase 6 Routes
```
GET   /admin/login                  → admin.login
POST  /admin/login                  → admin.login.submit
POST  /admin/logout                 → admin.logout
GET   /admin                        → admin.dashboard           (admin middleware)
DELETE /admin/pastes/{slug}         → admin.pastes.destroy       (admin middleware)
POST  /admin/pastes/expired/delete  → admin.pastes.expired.delete (admin middleware)
```

### Verified
- ✅ Login page loads (200), wrong password shows error, correct password redirects to dashboard
- ✅ Dashboard shows stats (total/public/private/unlisted), paste table with 50 rows, pagination
- ✅ Visibility filter (all/public/private/unlisted), status filter (all/active/expired/burned), search works
- ✅ Empty search shows "No pastes found." message
- ✅ Logout form available, unauthenticated requests redirect to login
- ✅ Footer admin link visible on homepage
- ✅ All admin routes return correct views

### URL Patterns for future phases
- API: `GET|POST /api/v1/pastes`, `GET|DELETE /api/v1/pastes/{slug}`
### Phase 5 (REST API): API Layer — Complete

#### Files Created (4):
1. **`app/Http/Controllers/Api/PasteController.php`** — API controller with 4 methods:
   - `index(Request)` — GET /api/v1/pastes — paginated (20 default, max 100), optional `?language=` filter, returns `PasteResource` collection with meta/links
   - `store(Request)` — POST /api/v1/pastes — validates same fields as web, maps `expires_at` shorthand to `expiry_type`, returns `PasteResource` with 201, model refreshed to load DB defaults
   - `show(string)` — GET /api/v1/pastes/{slug} — returns single paste (no password), 404 on miss, 410 if expired/burned, increments views, burns burn_after_read on first access
   - `destroy(string)` — DELETE /api/v1/pastes/{slug} — deletes paste, returns 204, requires `auth:sanctum`

2. **`app/Http/Resources/PasteResource.php`** — JSON resource transformer:
   - Includes: id, slug, title, content, language, expiry_type, visibility, is_burned, views_count, expires_at, created_at, updated_at, url
   - Excludes: password
   - Handles null defaults: `is_burned` → false, `views_count` → 0

3. **`routes/api.php`** — API routes under `v1` prefix:
   - GET /api/v1/pastes → index (public)
   - POST /api/v1/pastes → store (public)
   - GET /api/v1/pastes/{slug} → show (public)
   - DELETE /api/v1/pastes/{slug} → destroy (auth:sanctum)

4. **`app/Console/Commands/CreateSanctumToken.php`** — `php artisan sanctum:create-token {email}` command for generating personal access tokens

#### Files Modified (1):
5. **`bootstrap/app.php`** — Added `$middleware->throttleApi()` for rate limiting (60 req/min per IP via AppServiceProvider)

#### Rate Limiting:
- Configured in `app/Providers/AppServiceProvider.php`: `RateLimiter::for('api', 60/minute by IP)`
- Enabled in `bootstrap/app.php` via `$middleware->throttleApi()`
- Returns `X-RateLimit-Limit` and `X-RateLimit-Remaining` headers
- Returns 429 Too Many Requests when exceeded

#### API Authentication:
- Laravel Sanctum for token-based auth
- `auth:sanctum` middleware on DELETE endpoint
- Personal access tokens via `sanctum:create-token` command

#### Verified:
- ✅ GET paginated: 2 items returned, total=104+ 
- ✅ GET language filter: only matching language results
- ✅ GET per_page cap: capped at 100
- ✅ POST create: 201, slug generated, is_burned=false, views_count=0
- ✅ GET single paste: correct data, no password key
- ✅ GET nonexistent: 404
- ✅ DELETE without auth: 401
- ✅ DELETE with auth token: 204
- ✅ Burn after read: 200 on 1st view, 410 on 2nd view
- ✅ Rate limiting: 60 OK, then 429s
- ✅ Rate limit headers: X-RateLimit-Limit: 60, X-RateLimit-Remaining present

### Phase 7: README & Final Polish — Complete

#### Files Modified (1):
1. **`README.md`** — Replaced default Laravel README with comprehensive project documentation:
   - Title & badges (PHP 8.2+, Laravel 11, Docker)
   - About section with project description
   - Complete features bullet list (15+ features)
   - Requirements (with/without Docker)
   - Quick Start one-command deploy
   - Step-by-step setup instructions with service table
   - Full API documentation (4 endpoints, rate limiting, auth, request/response examples)
   - Admin dashboard guide (URL, default password, features)
   - Environment variables table (11 variables)
   - Tech stack summary
   - MIT License

#### Files Updated (1):
2. **`Agent_Docs.md`** — Added Phase 7 documentation

#### Files Deleted (1):
3. **`resources/views/welcome.blade.php`** — Deleted 41KB default Laravel welcome page (unused, route `/` points to PasteController@index)

#### Asset Loading Fix:
- **Problem**: `@vite` directive used Laravel's `asset()` helper, which generates absolute URLs from request context. On preview domain, assets resolved to `http://localhost:3000/build/assets/...` breaking CSS/JS on external access.
- **Fix**: Replaced `@vite` with manual manifest reading and root-relative URLs (`/build/assets/app-*.css`, `/build/assets/app-*.js`). Root-relative URLs work on any domain.

#### Final Checks:
- ✅ `.env.example` — All keys present. `APP_URL=` set to empty (let Laravel detect from request). `ASSET_URL=` set to empty (for consistency with relative asset paths)
- ✅ `.gitignore` — Covers .env, storage/*.key, vendor, node_modules, IDE files, build output
- ✅ Storage directories — All subdirectories preserved via `.gitignore` with `*` + `!.gitignore` pattern
- ✅ Route name consistency — All views use named routes matching `routes/web.php` definitions
- ✅ `APP_URL=` (empty) set in `.env.example` — allows Laravel to auto-detect URL from request

#### README Sections:
| Section | Content |
|---------|---------|
| Title & Badges | Pastebin — self-hosted Laravel pastebin (PHP 8.2+, Laravel 11, Docker) |
