# Comprehensive Code Review — Institute for Living a Longer Life

**Reviewed by:** Claude Code (Staff-Engineer Audit)  
**Date:** 2026-05-13  
**Branch:** `main`  
**Scope:** Full-stack Laravel application — backend, frontend (Blade + Alpine.js), auth, payments, RBAC, database

---

## Table of Contents

1. [Executive Summary](#1-executive-summary)
2. [Architecture Overview](#2-architecture-overview)
3. [Critical Issues](#3-critical-issues)
4. [High Priority Issues](#4-high-priority-issues)
5. [Medium Priority Issues](#5-medium-priority-issues)
6. [Low Priority / Nice-to-Have](#6-low-priority--nice-to-have)
7. [Per-file Findings Table](#7-per-file-findings-table)
8. [Quick Wins](#8-quick-wins)
9. [Recommended Refactor Roadmap](#9-recommended-refactor-roadmap)

---

## 1. Executive Summary

Ranked by severity:

1. **[CRITICAL] IDOR on all collaborator resource actions** — A collaborator can read, edit, delete, or change the status of any other user's products with no ownership check.
2. **[CRITICAL] `exit()` permanently breaks collaborator updates** — `AdminCollaboratorController::update()` starts with `exit('updateCollaborator')`, making the entire method a permanent dead-end.
3. **[CRITICAL] Payment success/cancel uses the most recent order globally** — `CheckoutController::success()` and `cancel()` fetch `Order::limit(1)->orderBy('id','desc')->first()`, meaning two concurrent checkouts give the wrong order to the wrong user, and `cancel()` marks another user's paid order as `failed`.
4. **[CRITICAL] No Stripe webhook** — The entire payment flow trusts the `?session_id=` redirect URL. There is no server-side webhook handler. Abandoned tabs after payment leave orders permanently pending; the success URL can be hit without any actual payment.
5. **[CRITICAL] Stripe API keys stored in the database** — `stripe_sandbox_secret` / `stripe_production_secret` are in the `site_settings` table. Anyone with admin DB read access (or SQL injection) gets live Stripe credentials.
6. **[CRITICAL] Plaintext passwords emailed to users** — Three places send the user's raw password in an email (guest checkout, collaborator registration, admin-created collaborators). Default password `12345678` is hardcoded.
7. **[CRITICAL] `ShopController::filter()` leaks member-exclusive products** — No `whereIn('category', [...])` guard in the filter action; passing `?category=member_exclusive` returns private-tier products to unauthenticated visitors.
8. **[CRITICAL] `composer.json` / `composer.lock` are gitignored** — PHP dependencies are not version-controlled; no reproducible builds, no CVE audits.
9. **[HIGH] IDOR on collaborator profile update** — `CollaboratorController::updateProfile()` accepts `user_id` from the POST body; any collaborator can overwrite any user's account.
10. **[HIGH] All product upload validation is commented out** — No MIME type, extension, or size validation on uploaded images in both Admin and Collaborator product controllers.

---

## 2. Architecture Overview

### Stack

| Layer | Technology |
|---|---|
| Backend | Laravel (PHP), Fortify for auth |
| Frontend | Blade + Alpine.js + Tailwind CSS 3, Chart.js |
| Database | SQLite (dev default); no `composer.json` so exact package versions are unknown |
| Payments | Stripe Checkout Sessions |
| Shipping | Shippo API |
| Video | Vimeo (embeds) |
| Email | Laravel Mailable; SMTP config stored in `SiteSetting` DB row |
| Queue | Database driver (`.env.example`) |
| Cache | Database driver (`.env.example`) |
| Auth | Laravel Fortify + custom `LoginController`; `RoleMiddleware` on routes |

### Directory Map

```
app/
├── Actions/Fortify/          # Auth actions (CreateNewUser, ResetPassword, etc.)
├── Console/Commands/         # TestShippoIntegration (1 command)
├── Http/
│   ├── Controllers/
│   │   ├── Admin/            # 18 admin controllers
│   │   ├── Collaborator/     # 3 collaborator controllers
│   │   ├── Front/            # 10 public + auth controllers
│   │   ├── Cart/             # CartController
│   │   ├── Dashboard/        # DashboardController + DashboardService
│   │   └── Product/          # ProductController (unused)
│   ├── Middleware/           # RoleMiddleware, UserTypeMiddleware
│   └── Requests/             # RegisterRequest (appears unused)
├── Mail/                     # 12 mailables
├── Models/                   # 30 Eloquent models
├── Providers/                # AppServiceProvider, FortifyServiceProvider
├── Services/                 # AddressValidationService, ShippingService, ShippoService, ZoomService
└── Traits/                   # ZoomMeetingTrait
database/
├── migrations/               # 50+ migrations, spanning 2024–2026
├── seeders/                  # 4 seeders
└── factories/                # UserFactory only
routes/
└── web.php                   # All routes in one file (~400 lines)
resources/views/
├── admin/                    # ~55 blade files
├── collaborator/             # ~15 blade files
├── member/                   # ~12 blade files
├── front/                    # ~35 blade files (public site)
├── components/               # ~50 blade components
└── emails/                   # ~12 email templates
tests/
├── Feature/ExampleTest.php   # Placeholder only
└── Unit/ExampleTest.php      # Placeholder only
```

### Role System

Roles (`admin`, `collaborator`, `user`) stored directly in `users.role` column — **not** in a separate `user_roles` table as the spec requires.

### Auth Flow

- Members login via `/auth` → `LoginController::login()` (AJAX, returns JSON)
- Collaborators login via `/collaborator` → `CollaboratorController::collaboratorLogin()`
- Admins login via `/admin` → `LoginController::adminLogin()`
- All portals protected by `RoleMiddleware` which checks `Auth::user()->role`
- No Fortify routes are registered (Fortify is installed but the service provider disables default routes)

---

## 3. Critical Issues

> Must be fixed before production deployment.

---

### C-01 · IDOR — Collaborator can access any product

**File:** `app/Http/Controllers/Collaborator/CollaboratorProductController.php` — lines 143–265

`edit()`, `show()`, `update()`, `destroy()`, `updateStatus()`, and `removeImage()` all call `Product::findOrFail($id)` with no `where('user_id', Auth::id())` guard. Any authenticated collaborator can view, edit, delete, or change the status of any other user's product — including Institute products owned by admin.

```diff
// In each method:
-$product = Product::findOrFail($id);
+$product = Product::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
```

Same fix applies to image removal:

```diff
// removeImage()
-$image = ProductImage::findOrFail($request->image_id);
+$image = ProductImage::whereHas('product', fn($q) => $q->where('user_id', Auth::id()))
+          ->findOrFail($request->image_id);
```

---

### C-02 · IDOR — Collaborator can overwrite any user's profile

**File:** `app/Http/Controllers/Collaborator/CollaboratorController.php` — line 187

`updateProfile()` takes `user_id` from the request body and fetches `User::findOrFail($request->user_id)`. An attacker submits any user ID to overwrite name, phone, speciality, etc. on any account.

```diff
-$collaboratorDetail = User::findOrFail($request->user_id);
+$collaboratorDetail = User::findOrFail(Auth::id()); // always use authenticated user
```

---

### C-03 · Dead `exit()` breaks collaborator update entirely

**File:** `app/Http/Controllers/Admin/AdminCollaboratorController.php` — lines 178 & 184

```php
public function update(Request $request, string $id)
{
    exit('updateCollaborator');   // ← kills every request here
    ...
    exit($profileImageName);      // ← second kill switch
```

This means admin can never edit a collaborator. Remove both `exit()` calls and complete the implementation, or replace the method body with the logic from `updateCollaborator()` which is correctly implemented.

---

### C-04 · Payment success/cancel use a global most-recent order

**File:** `app/Http/Controllers/Front/CheckoutController.php` — lines 472–619

```php
// success() AND cancel()
$order = Order::limit(1)->orderBy('id','desc')->first();
```

Under concurrent load, User A's completion flow can grab User B's freshly created order — exposing User B's PII (name, email, address) to User A. `cancel()` marks User B's successfully paid order as `failed`.

```diff
-$order = Order::limit(1)->orderBy('id','desc')->first();
+// Retrieve via the Stripe session metadata
+$session = \Stripe\Checkout\Session::retrieve($request->get('session_id'));
+$order = Order::findOrFail($session->metadata->order_id);
+// Ownership guard:
+abort_if($order->user_id && $order->user_id !== auth()->id(), 403);
```

---

### C-05 · No Stripe webhook — payment confirmation not reliable

**Files:** `app/Http/Controllers/Front/CheckoutController.php`, `routes/web.php`

The entire post-payment flow (order status update, stock decrement, emails, `PaymentHistory` record) runs only if the user's browser successfully redirects to `GET /checkout/success`. Stripe webhooks are absent. If the user closes the browser, the order stays `pending` forever. Worse, a user can hit `/checkout/success?session_id=cs_any_valid_id` and trigger fulfilment for a session that has nothing to do with their order.

**Fix:** Add a webhook endpoint with signature verification:

```php
// routes/web.php
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);
```

```php
// In the webhook controller
$payload = $request->getContent();
$sig     = $request->header('Stripe-Signature');
$event   = \Stripe\Webhook::constructEvent(
    $payload, $sig, config('services.stripe.webhook_secret')
);
```

Move all order-fulfilment logic into the `checkout.session.completed` webhook handler.

---

### C-06 · Stripe keys in the database

**Files:**
- `app/Http/Controllers/Front/CheckoutController.php` — lines 820–833
- `app/Http/Controllers/Front/MemberController.php` — lines 963–976
- `app/Http/Controllers/Front/IndexController.php` — line 235

`SiteSetting::first()` is called to retrieve `stripe_sandbox_secret` / `stripe_production_secret`. Storing live Stripe secret keys in the database means:

- A DB dump exposes production credentials.
- An admin-panel vulnerability gives full Stripe API access.
- Keys cannot be rotated without touching the database.

**Fix:** Move keys to `.env` / `config/services.php`. Remove `stripe_sandbox_secret` / `stripe_production_secret` columns from `site_settings`.

---

### C-07 · Plaintext passwords emailed; hardcoded default passwords

| File | Line | Issue |
|---|---|---|
| `app/Http/Controllers/Front/CheckoutController.php` | 122 | Guest register → hardcoded `'12345678'`, emailed in plaintext |
| `app/Http/Controllers/Admin/AdminCollaboratorController.php` | 121 | Admin creates collaborator → hardcoded `'12345678'`, emailed |
| `app/Http/Controllers/Collaborator/CollaboratorController.php` | 228 | Public collaborator signup → user's real password emailed |
| `app/Http/Controllers/UserRegister.php` | 35 | Member signup → user's real password emailed |

**Fix:** Use a password-reset token flow instead of sending the plaintext password. Never send `$request->password` in an email; send a signed `password/reset` link instead.

---

### C-08 · `ShopController::filter()` exposes member-exclusive products

**File:** `app/Http/Controllers/Front/ShopController.php` — lines 35–61

`index()` correctly limits to `['collaborator','institute']` but `filter()` omits this guard. Passing `?category=member_exclusive` returns gated products to any unauthenticated visitor.

```diff
// filter()
 $products = Product::when($search, ...)->when($category, ...)
+    ->whereIn('category', ['collaborator', 'institute'])
     ->where('status', 'active')
```

---

### C-09 · `composer.json` and `composer.lock` are gitignored

**File:** `.gitignore`

Without the lock file in version control:

- Dependency versions are unpinned → security patches may not apply.
- There is no way to audit PHP dependencies for CVEs.
- Automated deploys are broken without a local `vendor/` directory.

**Fix:** Remove `composer.json` and `composer.lock` from `.gitignore` immediately. Commit both files. Run `composer install --no-dev` on every deployment.

---

### C-10 · IDOR — Collaborator can view and update any order

**File:** `app/Http/Controllers/Collaborator/CollaboratorController.php` — lines 334–363

`orderDetails($id)` fetches `Order::with('user')->where('id', $id)->first()` with no ownership check. `updateOrder()` does the same. Any collaborator can view or change the status of any order on the platform.

```diff
// orderDetails
-$orderDetail = Order::with('user')->where('id', $id)->first();
+$collaboratorProductIds = Product::where('user_id', Auth::id())->pluck('id');
+$orderDetail = Order::with('user')
+    ->whereHas('items', fn($q) => $q->whereIn('product_id', $collaboratorProductIds))
+    ->findOrFail($id);
```

---

### C-11 · No MIME/extension validation on product image uploads

**Files:**
- `app/Http/Controllers/Admin/AdminProductController.php` — lines 43–153
- `app/Http/Controllers/Collaborator/CollaboratorProductController.php` — lines 29–139

The entire validation block in both `store()` methods is commented out. Images are moved to `public/product_images/` using `getClientOriginalExtension()` with no type check. An attacker can upload a `.php` file, bypassing the extension filter.

```php
// Both controllers – restore minimal validation:
$request->validate([
    'product_name'     => 'required|string|max:255',
    'price'            => 'required|numeric|min:0',
    'stock_quantity'   => 'required|integer|min:0',
    'product_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
]);
```

Images should also be stored in `storage/app/private/product_images/` and served through a controller, not placed directly in `public/`.

---

## 4. High Priority Issues

---

### H-01 · `MigrationController` exposes raw DDL execution from the browser

**File:** `app/Http/Controllers/Admin/MigrationController.php` — lines 27–99

`runMigration()` executes a hardcoded `CREATE TABLE` DDL statement and `rollbackMigration()` can `DROP` the table — all triggered from the web. The action routes are not wired in `web.php` today, but the controller and view are ready and waiting. This entire controller should be deleted; use `php artisan migrate` in your deploy pipeline.

---

### H-02 · No rate limiting on authentication endpoints

**File:** `routes/web.php` — lines 47, 273, 337–338

`/admin/login`, `/collaborator/login`, `/login`, and `/auth` have no `throttle` middleware. Brute-force attacks are completely unrestricted.

```diff
Route::post('/admin/login', [LoginController::class, 'adminLogin'])
+    ->middleware('throttle:5,1')
     ->name('admin.login');
```

Apply `throttle:5,1` (5 attempts per minute per IP) to all three login routes.

---

### H-03 · Session not regenerated on member AJAX login

**File:** `app/Http/Controllers/Front/Auth/LoginController.php` — lines 73–82

`adminLogin()` calls `$request->session()->regenerate()` ✓  
`collaboratorLogin()` calls `$request->session()->regenerate()` ✓  
`login()` (member) never regenerates — session fixation attack is possible.

```diff
if (!Auth::attempt(...)) { return ...; }
+$request->session()->regenerate();
 return response()->json(['message' => 'Login successful']);
```

---

### H-04 · Membership tier not enforced after login

**Files:** `app/Http/Controllers/Front/MemberController.php`, `routes/web.php` — line 379

All `/member/*` routes are protected only by `role === 'user'`. A Standard-tier member can access Premium-only video library content. The spec states Standard < Premium < Lifetime should gate content access.

---

### H-05 · Zoom sessions exposed to all members with no tier filter

**File:** `app/Http/Controllers/Front/MemberController.php` — lines 34–37

```php
$upcomingSessions = ZoomSession::all();
$recordedSessions = ZoomSessionRecordedLink::with('zoomSession')->get();
```

Every session and every recording is returned to every member regardless of tier or expiry date.

---

### H-06 · No DB transaction wrapping order creation and Stripe call

**File:** `app/Http/Controllers/Front/CheckoutController.php` — lines 650–748

`placeOrder()` creates `Order`, `OrderItem`s, and `SubOrder`s before creating the Stripe session. If Stripe fails, orphaned records remain. If Stripe succeeds but a DB write fails, no order exists to fulfil.

```diff
+DB::transaction(function () use ($request, $cart, $shipping, $delivery, $payment, $billing) {
     $order = Order::create([...]);
     // create items, sub-orders
     $session = \Stripe\Checkout\Session::create([...]);
     return redirect($session->url, 303);
+});
```

---

### H-07 · `LoginController::signUp()` redirects to the collaborator route

**File:** `app/Http/Controllers/Front/Auth/LoginController.php` — line 196

The member signup handler at `POST /auth` redirects new members to `route('become.collaborator.store')` on success. Members end up on the collaborator application page.

---

### H-08 · `env()` called directly in view layer — breaks config cache

**File:** `app/Http/Controllers/Front/IndexController.php` — line 34

```php
'thumbnail' => env('APP_URL') . 'testimonial_images/'.$item->thumbnail,
```

Calling `env()` outside `config/*.php` files returns `null` when `php artisan config:cache` is run in production.

```diff
-'thumbnail' => env('APP_URL') . 'testimonial_images/'.$item->thumbnail,
+'thumbnail' => config('app.url') . '/testimonial_images/'.$item->thumbnail,
```

---

### H-09 · Duplicate `getStripeSecret()` method in three controllers

**Files:**
- `app/Http/Controllers/Front/CheckoutController.php` — line 820
- `app/Http/Controllers/Front/MemberController.php` — line 963
- `app/Http/Controllers/Front/IndexController.php` — line 232

Identical Stripe initialisation logic copy-pasted across three controllers. Extract to a `StripeService` class or a `HasStripeConfig` trait.

---

### H-10 · Audit log table exists but nothing is ever written to it

**File:** `app/Http/Controllers/Admin/AdminController.php` — lines 31–38

`auditLogs()` renders an empty view — there are no `AuditLog::create(...)` calls anywhere in the codebase. The spec requires all admin actions to be audit-logged.

---

### H-11 · Duplicate `/admin/` prefix inside the admin route group

**File:** `routes/web.php` — line 144

```php
// Inside prefix('admin') group:
Route::post('/admin/zoom-sessions/{id}/status', ...)
// Resolves to: /admin/admin/zoom-sessions/{id}/status  ← unreachable
```

```diff
-Route::post('/admin/zoom-sessions/{id}/status', [ZoomSessionController::class, 'updateStatus'])
+Route::post('/zoom-sessions/{id}/status', [ZoomSessionController::class, 'updateStatus'])
```

---

### H-12 · `UserTypeMiddleware` checks non-existent field `$user->type`

**File:** `app/Http/Middleware/UserTypeMiddleware.php` — line 16

```php
if (! $user || ! in_array($user->type, $types)) {
```

The `User` model has a `role` column, not `type`. This middleware silently aborts 403 for every request. It is not registered in `web.php` today, but its existence is misleading.

---

## 5. Medium Priority Issues

---

### M-01 · N+1 queries in `success()` and `getCartTotal()`

**File:** `app/Http/Controllers/Front/CheckoutController.php` — lines 476–516

```php
foreach($orderItems as $orderItem){
    $product = Product::find($orderItem->product_id); // N individual queries
```

**Fix:** Eager-load products once: `$orderItems->load('product.user')`.

---

### M-02 · `ShopController::filter()` missing pagination

**File:** `app/Http/Controllers/Front/ShopController.php` — lines 35–60

`->get()` with no limit loads all matching products into memory. Add `->paginate(24)`.

---

### M-03 · Membership fields stored redundantly on `users` table

**File:** `app/Models/User.php` — lines 28–35

`plan_id`, `plan_name`, `plan_price`, `plan_period`, and `plan_expiry` stored directly on the `users` table. Upgrading overwrites the previous plan data — there is no purchase history. A `user_memberships` join table is the correct model.

---

### M-04 · `SiteSetting::$fillable` does not include Stripe fields

**File:** `app/Models/SiteSetting.php` — lines 11–20

`stripe_mode`, `stripe_sandbox_secret`, `stripe_production_secret`, `stripe_sandbox_key`, and `stripe_production_key` are used throughout the application but are NOT in `$fillable`. Saving via `->update([...])` silently drops these fields, causing "settings appear to save but Stripe stops working" bugs.

---

### M-05 · Old/unused blade files still committed

Several files indicate abandoned work:

- `resources/views/admin/dashboard/websettings_old.blade.php`
- `resources/views/front/pages/home.old.blade.php`
- `resources/views/components/dashboard/sidebar/header_old.blade.php`
- `resources/views/components/form/input_old.blade.php`
- `resources/views/product/index_old.blade.php`

Delete them. Old code in version control creates confusion about what is live.

---

### M-06 · DOMPDF `isRemoteEnabled: true` allows SSRF in PDF generation

**File:** `app/Http/Controllers/Front/MemberController.php` — lines 708–710

`isRemoteEnabled: true` allows the PDF renderer to make outbound HTTP requests. If any product description or user content contains a crafted `<img src="http://attacker.com/...">`, the server will fetch that URL during rendering.

```diff
-$options->set('isRemoteEnabled', true);
+$options->set('isRemoteEnabled', false);
```

---

### M-07 · Guest checkout missing `$request->validate()`

**File:** `app/Http/Controllers/Front/CheckoutController.php` — lines 62–153

The guest checkout path assigns `$request->first_name`, `$request->email`, etc. directly with no validation. Malformed or oversized input is stored in session data and subsequently into the database.

---

### M-08 · Email uniqueness not checked in `LoginController::signUp()`

**File:** `app/Http/Controllers/Front/Auth/LoginController.php` — line 162

The validation checks `required|email` but not `unique:users,email`. Registering twice with the same email throws an unhandled `Illuminate\Database\QueryException` with a raw stack trace visible to the user.

---

### M-09 · No FK constraints between related tables

Key relationships — `orders.user_id`, `order_items.order_id`, `order_items.product_id`, `sub_orders.order_id`, `sub_order_items.sub_order_id` — have no `->constrained()` on the FK columns. Orphaned records accumulate silently on delete.

---

### M-10 · Collaborator `updateSubOrder()` accepts arbitrary status value

**File:** `app/Http/Controllers/Collaborator/CollaboratorController.php` — line 318

```php
$subOrder->status = $request->input('status');
```

No validation. Any string can be stored.

```diff
+$request->validate(['status' => 'required|in:pending,processing,shipped,delivered,cancelled']);
```

---

### M-11 · Stock decrement runs in `success()` without idempotency

**File:** `app/Http/Controllers/Front/CheckoutController.php` — lines 476–485

Stock is decremented inside the success callback route. There is no guard against double-decrement — a user refreshing the success page decrements stock again. The `PaymentHistory` dedup only protects the payment record, not the stock.

---

### M-12 · Two separate `create_testimonials_table` migrations

**Files:**
- `database/migrations/2025_11_19_073157_create_testimonials_table.php`
- `database/migrations/2025_12_30_072038_create_testimonials_table.php`

Duplicate migration names will cause `php artisan migrate` to fail on a fresh install.

---

## 6. Low Priority / Nice-to-Have

| # | File | Line | Issue |
|---|---|---|---|
| L-01 | `app/Http/Controllers/Admin/AdminCollaboratorController.php` | 276 | `// echo '<pre>';print_r($collaboratorCourses); exit;` debug artifact |
| L-02 | `app/Http/Controllers/Admin/AdminProductController.php` | 275 | `//echo '<pre>';print_r($product);exit;` left in `destroy()` |
| L-03 | `routes/web.php` | 153 | Non-English inline comment `// Yahan aur admin routes add kar sakte ho` |
| L-04 | `routes/web.php` | 380 | Commented-out `//Route::prefix('member')->group(...)` bypass |
| L-05 | `app/Http/Controllers/Admin/WebSettingsController.php` | 15 | `// dd($request->all());` left in production code |
| L-06 | `app/Http/Middleware/UserTypeMiddleware.php` | — | Registered but never used; checks wrong field (`type` vs `role`) |
| L-07 | `app/Http/Controllers/Front/IndexController.php` | 54–86 | Empty stub methods `create()`, `store()`, `show()`, `edit()`, `update()`, `destroy()` |
| L-08 | `app/Http/Controllers/Front/Auth/LoginController.php` | 110 | Entire `collaboratorLogin()` method commented out |
| L-09 | `app/Http/Controllers/Collaborator/CollaboratorController.php` | 169 | Non-English inline comment |
| L-10 | `app/Http/Controllers/Front/MemberController.php` | 450–453 | Course categories hardcoded in PHP array; should be DB-driven or config |
| L-11 | `.env.example` | — | `SHIPPO_API_KEY` contains what appears to be an actual test key value |
| L-12 | `app/Models/User.php` | 98–171 | ~70 lines of commented-out relationships and scopes |
| L-13 | `app/Http/Controllers/Admin/AdminCollaboratorController.php` | 64 | All validation commented out in `store()` |
| L-14 | `app/Http/Controllers/Front/MemberController.php` | 180–188 | Hardcoded test card `'4242424242424242'` — dead code with inline comment "This won't work" |
| L-15 | Multiple | — | `RegisterRequest.php` exists but is never used on any route |

---

## 7. Per-file Findings Table

| File:Line | Severity | Category | Issue | Suggested Fix |
|---|---|---|---|---|
| `CollaboratorProductController.php:143` | CRITICAL | IDOR | No ownership check on edit/show/update/destroy | Add `where('user_id', Auth::id())` |
| `CollaboratorController.php:187` | CRITICAL | IDOR | Accepts arbitrary `user_id` from POST body | Always use `Auth::id()` |
| `AdminCollaboratorController.php:178` | CRITICAL | Broken code | `exit()` kills all collaborator updates | Remove both `exit()` calls |
| `CheckoutController.php:473` | CRITICAL | IDOR | Most-recent order fetched globally in success/cancel | Scope to current user via Stripe session metadata |
| `routes/web.php` | CRITICAL | Payments | No Stripe webhook endpoint | Add webhook + signature verification |
| `CheckoutController.php:820` | CRITICAL | Security | Stripe secrets retrieved from database | Move to `.env` / config |
| `UserRegister.php:37` | CRITICAL | Security | Plaintext password emailed at signup | Use password reset token |
| `CheckoutController.php:122` | CRITICAL | Security | Hardcoded `12345678` default password | Generate random password + reset link |
| `ShopController.php:43` | CRITICAL | Business Rule | filter() leaks member_exclusive products | Add `whereIn('category', ['collaborator','institute'])` |
| `.gitignore` | CRITICAL | Ops | `composer.json`/`composer.lock` gitignored | Remove from `.gitignore`, commit both files |
| `CollaboratorController.php:344` | HIGH | IDOR | `orderDetails` — no ownership check | Filter by collaborator's product IDs |
| `CollaboratorController.php:352` | HIGH | IDOR | `updateOrder` — no ownership check | Same as above |
| `MigrationController.php:27` | HIGH | Security | DDL execution accessible from web browser | Delete this controller |
| `LoginController.php:73` | HIGH | Auth | No session regeneration on member login | Add `$request->session()->regenerate()` |
| `routes/web.php:47,337` | HIGH | Auth | No rate limiting on login routes | Add `throttle:5,1` middleware |
| `IndexController.php:34` | HIGH | Config | `env()` called outside config files | Use `config('app.url')` |
| `LoginController.php:196` | HIGH | Bug | `signUp()` redirects to collaborator route | Fix redirect target |
| `routes/web.php:144` | HIGH | Bug | Double `/admin/` prefix on zoom status route | Remove leading `/admin/` inside the group |
| `CheckoutController.php:650` | HIGH | Reliability | No DB transaction around order creation + Stripe | Wrap in `DB::transaction()` |
| `MemberController.php:34` | HIGH | Business Rule | Zoom sessions not filtered by membership tier | Filter by user's active membership |
| `SiteSetting.php:11` | MEDIUM | Bug | Stripe fields not in `$fillable` | Add to `$fillable` |
| `CollaboratorController.php:318` | MEDIUM | Validation | Sub-order status not validated | Add `in:pending,...` rule |
| `CheckoutController.php:62` | MEDIUM | Validation | Guest checkout missing `$request->validate()` | Add validation block |
| `LoginController.php:162` | MEDIUM | Validation | Email uniqueness not checked on signup | Add `unique:users,email` |
| `AdminProductController.php:43` | MEDIUM | Security | All image upload validation commented out | Restore MIME/size validation |
| `MemberController.php:708` | MEDIUM | Security | DOMPDF `isRemoteEnabled: true` | Set to `false` |
| `User.php:28` | MEDIUM | Design | Role stored on `users` table, not `user_roles` | Spec requires separate `user_roles` table |
| `tests/Feature/ExampleTest.php` | MEDIUM | Testing | Only placeholder tests exist | Add auth, payment, and RBAC tests |
| `UserTypeMiddleware.php:16` | LOW | Bug | Checks `$user->type` instead of `$user->role` | Fix field name or delete middleware |
| `IndexController.php:54` | LOW | Code quality | Empty stub methods in production controller | Delete empty stubs |

---

## 8. Quick Wins

> Each of the following can be fixed in under one hour and materially improves the application.

1. **Remove `exit()` from `AdminCollaboratorController::update()`** — 2-line delete; restores collaborator editing for admin.
2. **Add `whereIn('category', ['collaborator','institute'])` to `ShopController::filter()`** — 1 line; fixes the member-exclusive product data leak.
3. **Fix the double-prefix zoom status route** in `routes/web.php` line 144.
4. **Fix the wrong redirect** in `LoginController::signUp()` line 196.
5. **Add `throttle:5,1` to all three login routes** in `routes/web.php`.
6. **Add `$request->session()->regenerate()`** to `LoginController::login()` (member login).
7. **Replace `env('APP_URL')` with `config('app.url')`** in `IndexController.php` line 34.
8. **Add `status` ownership scope** to `CollaboratorProductController::updateStatus()`.
9. **Remove `composer.json` / `composer.lock` from `.gitignore`** and commit both files.
10. **Delete `_old` and `.old` blade files** — no logic impact; reduces confusion.

---

## 9. Recommended Refactor Roadmap

### Phase 1 — Security & Correctness (Sprint 1, ~3 days)

| Task | Effort |
|---|---|
| Fix all IDOR issues (C-01, C-02, C-10) — add ownership guards to collaborator controllers | 4 h |
| Remove `exit()` from `AdminCollaboratorController` (C-03) | 0.5 h |
| Fix order fetching in `success()` / `cancel()` (C-04) | 2 h |
| Add Stripe webhook + signature verification (C-05) | 4 h |
| Move Stripe keys to `.env` (C-06) | 1 h |
| Replace plaintext-password emails with reset-token links (C-07) | 3 h |
| Fix `ShopController::filter()` member-exclusive leak (C-08) | 0.5 h |
| Restore image upload MIME validation in both product controllers (C-11) | 1 h |
| Add login rate limiting + session regeneration (H-02, H-03) | 1 h |
| Wrap order creation + Stripe in a DB transaction (H-06) | 1 h |

### Phase 2 — Business Logic & Data Integrity (Sprint 2, ~3 days)

| Task | Effort |
|---|---|
| Implement membership tier gating on video library and Zoom sessions | 4 h |
| Add FK constraints (`->constrained()`) to all relationship columns | 2 h |
| Implement `AuditLog` writes for admin actions | 3 h |
| Fix stock decrement idempotency on order success | 1 h |
| Move membership subscription data to `user_memberships` table | 4 h |
| Replace all `env()` calls outside config files with `config()` | 2 h |

### Phase 3 — Code Quality & Testing (Sprint 3, ~5 days)

| Task | Effort |
|---|---|
| Write Feature tests: auth flows, RBAC enforcement, payment, IDOR prevention | 8 h |
| Extract `StripeService` — deduplicate `getStripeSecret()` from three controllers | 2 h |
| Add eager loading to all identified N+1 query loops | 2 h |
| Delete dead code (commented-out blocks, `_old` files, empty stubs) | 2 h |
| Migrate to separate `user_roles` table (spec requirement) | 4 h |
| Add missing fields to `SiteSetting::$fillable` | 1 h |
| Move uploaded files out of `public/` into `storage/` with access-controlled serving | 3 h |

---

*Report generated by Claude Code — Institute for Living a Longer Life audit, 2026-05-13.*
