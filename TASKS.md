```markdown
# Spendly — Development Tasks

> **Project:** Spendly
> **Tagline:** Atur duit, biar nggak boncos.
> **Framework:** Laravel 13
> **Frontend:** Blade, Bootstrap 5, JavaScript
> **Database:** MySQL
> **Language:** Indonesian
> **Timezone:** Asia/Jakarta
> **Currency:** Indonesian Rupiah (IDR)
>
> This document is the development roadmap and progress tracker for Spendly. Use it as the source of truth when continuing development in a new conversation.

---

## Development Instructions

The coding assistant is responsible for implementing the application step by step.

- Follow the existing project structure and Laravel conventions.
- Provide complete code for files being created or modified.
- Explain where each file belongs and which commands to run.
- Avoid unnecessary abstractions, packages, and complicated architecture.
- Test each feature before moving to the next major feature.
- Update this checklist when tasks are completed or the implementation changes.
- Do not assume a task is complete just because its code has been written; verify it.
- Preserve existing working functionality when modifying the application.

### Technical conventions

- Use Laravel MVC.
- Use Eloquent ORM for database operations.
- Use Form Request classes for more involved validation.
- Use Blade for views.
- Use vanilla JavaScript where practical.
- Use Bootstrap 5 for responsive layouts and components.
- Use organized CSS and reusable Blade layouts/partials.
- Follow PSR-12 and Laravel naming conventions.
- Use database migrations and seeders.
- Use authentication middleware and user ownership checks.
- Use Laravel CSRF protection and password hashing.
- Use decimal-safe handling for financial amounts.
- Never trust client-submitted user IDs or ownership information.

---

# Project Progress

## Phase 1 — Project Setup

- [x] Create Laravel project.
- [x] Install PHP dependencies.
- [x] Install PhpSpreadsheet.
- [x] Install FPDF.
- [x] Install Bootstrap 5.
- [x] Install Popper.js.
- [x] Install Chart.js.
- [x] Install jQuery.
- [x] Install DataTables.
- [x] Install DataTables Bootstrap 5 integration.
- [x] Install DataTables Responsive.
- [x] Install TinyMCE.
- [x] Install Bootstrap Icons.
- [x] Configure MySQL database.
- [x] Configure application environment.
- [x] Generate application key.
- [x] Create storage symbolic link.
- [x] Run initial database migrations.
- [x] Verify frontend asset build.

**Status:** Initial setup completed.

## Phase 2 — Authentication

### Authentication foundation

- [x] Create `AuthController`.
- [x] Create login route.
- [x] Create registration route.
- [x] Create logout route.
- [x] Protect dashboard route with authentication middleware.
- [x] Create login Blade view.
- [x] Create registration Blade view.
- [x] Create temporary dashboard view.
- [x] Implement user registration.
- [x] Implement password hashing.
- [x] Implement login.
- [x] Regenerate session after successful login.
- [x] Implement logout and session invalidation.
- [x] Add basic authentication route throttling.

### Authentication testing and improvements

- [x] Test successful registration.
- [x] Test duplicate email validation.
- [x] Test password confirmation.
- [x] Test password hashing in the database.
- [x] Test successful login.
- [x] Test incorrect login credentials.
- [x] Test logout.
- [x] Test access to protected pages while logged out.
- [x] Test guest access to login and registration while authenticated.
- [x] Improve validation error presentation.
- [x] Add appropriate login and registration success feedback.
- [x] Review authentication security and session behavior.

**Status:** Initial implementation written; testing and refinement pending.

## Phase 3 — Database Design

### Database migrations

- [x] Review the default Laravel users migration.
- [x] Create `categories` migration.
- [x] Create `transactions` migration.
- [x] Add appropriate foreign keys.
- [x] Add database indexes where useful.
- [x] Use appropriate decimal precision for financial amounts.
- [x] Add transaction date and description fields.
- [x] Add transaction type: income or expense.
- [x] Add optional receipt image path.
- [x] Add timestamps and appropriate deletion behavior.

### Eloquent models

- [x] Configure `User` model.
- [x] Create `Category` model.
- [x] Create `Transaction` model.
- [x] Define User-to-Transaction relationship.
- [x] Define User-to-Category relationship.
- [x] Define Category-to-Transaction relationship.
- [x] Define appropriate casts.
- [x] Review mass assignment protection.

### Default categories

Expense categories:

- [x] Makan & Minum
- [x] Transportasi
- [x] Belanja
- [x] Tagihan
- [x] Hiburan
- [x] Kesehatan
- [x] Pendidikan
- [x] Kos & Tempat Tinggal
- [x] Lainnya

Income categories:

- [x] Gaji
- [x] Freelance
- [x] Bisnis
- [x] Uang Saku
- [x] Hadiah
- [x] Investasi
- [x] Lainnya

### Seeders

- [x] Create `CategorySeeder`.
- [x] Insert default Indonesian categories.
- [x] Ensure categories are available to users appropriately.
- [x] Avoid creating duplicate categories when seeding repeatedly.
- [x] Create realistic Indonesian sample transactions for development.

**Status:** Not started.

## Phase 4 — Application Layout and UI Foundation

- [x] Create the main Blade layout.
- [x] Create reusable navigation components.
- [x] Create sidebar or floating navigation.
- [x] Create reusable page header.
- [x] Create reusable alert and notification components.
- [x] Configure Bootstrap 5 styles.
- [x] Configure Bootstrap Icons.
- [x] Establish the application typography.
- [x] Establish the color palette.
- [x] Create responsive layouts for desktop and mobile.
- [x] Create consistent form and button styles.
- [ ] Create empty states and loading states.

### Design direction

Spendly should feel like a modern, friendly personal finance application.

- Use Indonesian language naturally.
- Keep the experience simple and approachable.
- Use asymmetrical layouts and interesting compositions where appropriate.
- Avoid generic dashboard templates.
- Avoid excessive gradients, glassmorphism, animations, and shadows.
- Keep financial information readable and easy to understand.

Suggested design tokens:

| Purpose        | Color     |
| -------------- | --------- |
| Primary        | `#536DFE` |
| Background     | `#F7F8FA` |
| Surface        | `#FFFFFF` |
| Main text      | `#202433` |
| Secondary text | `#777F91` |
| Income         | `#16A36A` |
| Expense        | `#E65C5C` |
| Border         | `#E8EAF0` |

Suggested typography: Plus Jakarta Sans and Sora.

**Status:** Not started.

## Phase 5 — Dashboard

### Dashboard information

- [x] Display personalized greeting.
- [x] Display total income.
- [x] Display total expenses.
- [x] Display current balance.
- [x] Display transaction count.
- [x] Display recent transactions.
- [x] Display income versus expense visualization.
- [x] Display expense breakdown by category.
- [x] Display current month summary.
- [x] Add date or month filtering where appropriate.
- [x] Add useful empty states for new accounts.

### Dashboard functionality

- [x] Create dashboard controller.
- [x] Query financial data for the authenticated user.
- [x] Calculate totals using safe decimal handling.
- [x] Prepare chart data.
- [x] Render charts using Chart.js.
- [x] Ensure all dashboard queries respect user ownership.

**Status:** Not started.

## Phase 6 — Category Management (CRUD)

- [x] Create category listing page.
- [x] Create category form.
- [x] Implement category creation.
- [x] Implement category editing.
- [x] Implement category deletion.
- [x] Validate category name and type.
- [ ] Prevent inappropriate deletion of categories with existing transactions.
- [x] Restrict category operations to the appropriate user.
- [x] Add default category handling.
- [x] Test all CRUD operations.

**Status:** Not started.

## Phase 7 — Transaction Management (CRUD)

### Create transactions

- [ ] Create transaction listing page.
- [ ] Create transaction form.
- [ ] Implement income creation.
- [ ] Implement expense creation.
- [ ] Select a category.
- [ ] Enter amount.
- [ ] Enter transaction date.
- [ ] Enter description.
- [ ] Validate all submitted data.
- [ ] Save transactions for the authenticated user.

### Read transactions

- [ ] Display transaction history.
- [ ] Display income and expense labels.
- [ ] Format amounts in IDR.
- [ ] Format dates in Indonesian.
- [ ] Display associated categories.
- [ ] Add transaction detail view if useful.

### Update transactions

- [ ] Edit transaction details.
- [ ] Validate edited information.
- [ ] Ensure users can only edit their own transactions.

### Delete transactions

- [ ] Delete transactions.
- [ ] Add confirmation before deletion.
- [ ] Ensure users can only delete their own transactions.

### Transaction filters

- [ ] Filter by income or expense.
- [ ] Filter by category.
- [ ] Filter by date range.
- [ ] Search transaction descriptions.
- [ ] Add pagination or DataTables integration.

### Financial correctness

- [ ] Verify income calculations.
- [ ] Verify expense calculations.
- [ ] Verify balance calculations.
- [ ] Test zero and large amounts.
- [ ] Ensure amounts are not calculated using unsafe floating-point arithmetic.

**Status:** Not started.

## Phase 8 — DataTables Integration

- [ ] Integrate DataTables with Bootstrap 5.
- [ ] Apply DataTables to transaction history.
- [ ] Configure pagination.
- [ ] Configure searching.
- [ ] Configure sorting.
- [ ] Configure responsive behavior.
- [ ] Localize DataTables interface into Indonesian.
- [ ] Verify that transaction data is scoped to the authenticated user.
- [ ] Test with a larger set of transactions.

**Status:** Not started.

## Phase 9 — Profile and Image Processing

### Profile management

- [ ] Create profile page.
- [ ] Display user information.
- [ ] Allow users to update their name.
- [ ] Allow users to update their email.
- [ ] Validate profile changes.
- [ ] Handle duplicate email validation.

### Profile picture

- [ ] Allow profile picture uploads.
- [ ] Validate image type and file size.
- [ ] Store images using Laravel storage.
- [ ] Display profile pictures.
- [ ] Allow replacing existing pictures.
- [ ] Remove old images safely.
- [ ] Prevent unsafe file uploads.

### Receipt images

- [ ] Allow optional receipt image uploads on transactions.
- [ ] Validate receipt images.
- [ ] Store receipt images securely.
- [ ] Display receipt images where appropriate.
- [ ] Allow receipt replacement and deletion.
- [ ] Ensure users cannot access other users' private receipt files.

**Status:** Not started.

## Phase 10 — Currency API Integration

- [ ] Select a suitable public exchange-rate API.
- [ ] Review API availability and usage limits.
- [ ] Create `CurrencyService.php`.
- [ ] Retrieve exchange-rate information.
- [ ] Handle API failures and timeouts.
- [ ] Cache exchange-rate responses where appropriate.
- [ ] Display exchange-rate information on the dashboard.
- [ ] Clearly indicate that currency conversion is informational only.
- [ ] Keep all Spendly transaction amounts in IDR.

**Status:** Not started.

## Phase 11 — PDF Processing (FPDF)

- [ ] Create `ReportService.php`.
- [ ] Prepare report data from the authenticated user's transactions.
- [ ] Generate PDF reports using FPDF.
- [ ] Include user information.
- [ ] Include report period.
- [ ] Include income summary.
- [ ] Include expense summary.
- [ ] Include balance summary.
- [ ] Include transaction details.
- [ ] Format financial amounts in IDR.
- [ ] Add a download PDF action.
- [ ] Validate report date filters.
- [ ] Ensure users can only export their own data.
- [ ] Test PDF layout and generated content.

**Status:** Not started.

## Phase 12 — Excel Processing (PhpSpreadsheet)

- [ ] Create `SpreadsheetService.php`.
- [ ] Create Excel export functionality.
- [ ] Export transaction history.
- [ ] Include appropriate column headings.
- [ ] Include dates, categories, types, descriptions, and amounts.
- [ ] Format spreadsheet columns and currency values.
- [ ] Create Excel import functionality.
- [ ] Validate uploaded spreadsheet files.
- [ ] Validate imported rows and required columns.
- [ ] Handle invalid rows with understandable error messages.
- [ ] Prevent importing transactions belonging to another user.
- [ ] Add duplicate handling where appropriate.
- [ ] Test export and import with realistic data.

**Status:** Not started.

## Phase 13 — WYSIWYG Editor

- [ ] Integrate TinyMCE.
- [ ] Create report notes or financial journal notes.
- [ ] Allow rich-text editing.
- [ ] Save editor content.
- [ ] Sanitize submitted HTML.
- [ ] Display saved content safely.
- [ ] Ensure users can only edit their own content.

**Status:** Not started.

## Phase 14 — Localization and Final UX

- [ ] Set Indonesian application locale.
- [ ] Set Asia/Jakarta timezone.
- [ ] Format dates in Indonesian.
- [ ] Format currency as IDR (`Rp`).
- [ ] Review all interface text.
- [ ] Add helpful validation messages in Indonesian.
- [ ] Add success and error notifications.
- [ ] Review responsive behavior.
- [ ] Review accessibility and form labels.
- [ ] Ensure consistent navigation and page layouts.

**Status:** Not started.

## Phase 15 — Testing and Security

### Functional testing

- [ ] Test authentication.
- [ ] Test category CRUD.
- [ ] Test transaction CRUD.
- [ ] Test dashboard calculations.
- [ ] Test transaction filters.
- [ ] Test DataTables.
- [ ] Test image uploads.
- [ ] Test currency API.
- [ ] Test PDF generation.
- [ ] Test Excel import and export.
- [ ] Test WYSIWYG content.

### Security review

- [ ] Verify authentication middleware.
- [ ] Verify user ownership on every private resource.
- [ ] Verify request validation.
- [ ] Verify CSRF protection.
- [ ] Verify password hashing.
- [ ] Verify file upload restrictions.
- [ ] Verify safe HTML rendering.
- [ ] Verify no sensitive information is exposed.
- [ ] Verify users cannot manipulate transaction ownership.
- [ ] Verify API credentials are not exposed in frontend code.

### Quality checks

- [ ] Run Laravel tests.
- [ ] Fix application errors.
- [ ] Check route definitions.
- [ ] Check database migrations.
- [ ] Check frontend build.
- [ ] Check browser console.
- [ ] Review code consistency.
- [ ] Remove unnecessary development files and debug code.

**Status:** Not started.

## Phase 16 — Git and Hosting

### Git

- [ ] Initialize Git repository if not already initialized.
- [ ] Review `.gitignore`.
- [ ] Ensure `.env` is not committed.
- [ ] Create initial project commit.
- [ ] Commit each major feature.
- [ ] Push repository to GitHub.
- [ ] Write a useful `README.md`.

### Deployment

- [ ] Choose hosting provider.
- [ ] Prepare production environment.
- [ ] Configure production database.
- [ ] Configure environment variables.
- [ ] Install Composer dependencies for production.
- [ ] Build frontend assets.
- [ ] Run production migrations.
- [ ] Configure storage permissions.
- [ ] Configure application URL and HTTPS.
- [ ] Disable debug mode.
- [ ] Verify deployed application.
- [ ] Test authentication and core functionality in production.

**Status:** Not started.

---

# Important Technical Decisions

| Area          | Decision                   |
| ------------- | -------------------------- |
| Backend       | Laravel 13                 |
| Architecture  | Laravel MVC                |
| Database      | MySQL                      |
| Frontend      | Blade                      |
| CSS framework | Bootstrap 5                |
| JavaScript    | Vanilla JS where practical |
| Charts        | Chart.js                   |
| Tables        | DataTables                 |
| Rich text     | TinyMCE                    |
| PDF           | FPDF (`setasign/fpdf`)     |
| Excel         | PhpSpreadsheet             |
| Currency API  | Public exchange-rate API   |
| Currency      | IDR                        |
| Locale        | Indonesian                 |
| Timezone      | Asia/Jakarta               |

### Important implementation files

These are planned service classes, not necessarily files that already exist:

- `app/Services/CurrencyService.php`
- `app/Services/ReportService.php`
- `app/Services/SpreadsheetService.php`

Use services when they make external integrations or substantial processing easier to maintain. Do not create services for every small operation.

---

# Project Scope Boundaries

Spendly is a personal expense tracker, not a full accounting system.

Do not introduce these features unless explicitly requested:

- Bank account integrations.
- Payment gateways.
- Cryptocurrency.
- Investment portfolio management.
- Shared financial accounts.
- Subscription billing.
- Complex accounting or bookkeeping.
- AI financial advisor.
- Unnecessary enterprise-level architecture.

Keep the application focused on tracking income, expenses, categories, and personal financial summaries.

---

# Instructions for Continuing in a New Conversation

If the conversation context runs out, upload this `TASKS.md` and provide the following instruction:

> We are continuing development of Spendly, a Laravel 13 personal expense tracker. Read TASKS.md carefully and use it as the project roadmap and progress tracker. Follow the existing architecture and technical decisions. Continue from the first incomplete task, inspect any existing code or files I provide, and implement the next feature step by step. You are responsible for writing the code, explaining file locations, and providing commands and tests. Update TASKS.md as we complete tasks. Do not restart the project or unnecessarily rewrite working features.

**Current development position:**

1. Project dependencies and initial setup are complete.
2. Authentication routes, controller, and basic Blade pages have been written.
3. Authentication testing and refinement are the immediate next tasks.
4. After authentication is verified, proceed to database design and migrations.

**Last completed development milestone:** Initial authentication implementation for Spendly.
