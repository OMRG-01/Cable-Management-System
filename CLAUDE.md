# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Cable Management System — a LAMP stack web application for managing cable TV customers, subscriptions, payments, staff, complaints, connection requests, and STB inventory.

## Running the Application

1. Install XAMPP and start Apache + MySQL services
2. Place project in `htdocs/` folder
3. Import `responsiveform.sql` into MySQL (creates the `responsiveform` database)
4. **Then run `schema_update.sql`** in phpMyAdmin to add the `complaints`, `connection_requests`, and `stb_inventory` tables and fix missing primary keys
5. Open `http://localhost/<project-folder>/1.customer.php` in browser

**Database connection** is configured in [`connection.php`](connection.php) — defaults to `localhost`, user `root`, empty password, database `responsiveform`.

No build step, no test suite, no linter.

## Architecture

### Entry Points

| URL | Role | Session key |
|-----|------|-------------|
| [`1.customer.php`](1.customer.php) | Customer login | `$_SESSION['user_name']` |
| [`operator.php`](operator.php) | Admin login | `$_SESSION['admin_name']` |
| [`connection_request.php`](connection_request.php) | New connection application | (no login required) |

**Logout:** [`logout.php`](logout.php) (customer) · [`adminlogout.php`](adminlogout.php) (admin)

### Database Tables

| Table | Purpose |
|-------|---------|
| `form1` | Customer profiles (email, STB-ID, phone, area, subscription, username, password) |
| `form2` | SD (Gold Pack) channel list |
| `form3` | Unused legacy credential table |
| `form4` | Admin credentials |
| `form5` | HD (Premium Pack) channel list |
| `form6` | Workers/technicians (sname=name, uname=phone, dname=designation, hname=salary) |
| `form7` | Legacy unused table |
| `form8` | Payment/invoice records (FK → form1) |
| `complaints` | Customer complaint tickets (FK → form1) — added by schema_update.sql |
| `connection_requests` | New connection applications — added by schema_update.sql |
| `stb_inventory` | Set-top box inventory (FK → form1 nullable) — added by schema_update.sql |

### Customer Flow

```
1.customer.php → CustomerPage.php
  ├── customerdetails.php  (view profile)
  ├── upcustomer.php       (update profile)
  ├── editplanC.php        (view subscription → displayplan1.php / displayplan3.php)
  ├── pay.php → ment.php   (payment submission + receipt)
  ├── complaints.php       (raise complaint)
  └── viewcomplaints.php   (view own complaints + admin replies)
```

### Admin Flow

```
operator.php → dashboard.php
  ├── displaycustomer.php        (read-only customer list)
  ├── updatecustomer.php         (CRUD → update_design.php, delete.php)
  ├── PP.php → plans.php / plans2.php         (add channels)
  ├── Editplans.php → displayplan.php / displayplan2.php → update_plan.php / update_plan2.php
  ├── adinvoice.php → finalinvoice.php        (mark paid, print invoice)
  ├── worker.php → addworker.php, editworker.php, deleteworker.php
  ├── admincomplaints.php        (reply + resolve complaints)
  ├── admin_connections.php      (approve/reject connection requests)
  └── stb.php → addstb.php, editstb.php       (STB inventory)
```

### Code Patterns

- **Session guard — customer pages:** `session_start(); if (!isset($_SESSION['user_name'])) { header('Location: 1.customer.php'); exit; }`
- **Session guard — admin pages:** `session_start(); if (!isset($_SESSION['admin_name'])) { header('Location: operator.php'); exit; }`
- **SQL:** All queries use `mysqli_prepare` + `mysqli_stmt_bind_param`. Integer IDs are cast with `(int)` before use.
- **XSS:** All database output is wrapped in `htmlspecialchars()`.
- **Redirects:** All use relative `header('Location: file.php')` — no hard-coded localhost URLs.
- **Column naming in form6:** confusing legacy names — `sname`=name, `uname`=phone, `dname`=designation, `hname`=salary.
- **Column naming in form5:** `mname`=channel name, `aname`=code, `yname`=price, `uname`=quality.
- **Stylesheets:** Customer pages use `style4.css` (forms) or `css/style7.css` (sidebar). Admin pages use `css/style8.css` (sidebar). New module pages use inline styles.
- **Subscription prices:** Hard-coded — Premium Pack = Rs. 650, Gold Pack = Rs. 450 (in `pay.php` and `ment.php`).
- **Admin credentials:** Stored plain-text in `form4` table. Default: `Admin@123` / `Admin@123`.
