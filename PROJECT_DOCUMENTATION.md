# E-Commerce Platform Documentation

## Project Overview

This is a **multi-tenant e-commerce platform** built with Laravel 11, featuring a modular architecture that separates concerns between Admin, Organization, and Website functionalities. The platform allows multiple organizations to manage their own e-commerce stores with independent product catalogs, employees, and settings.

---

## Technology Stack

### Backend
- **PHP**: ^8.2
- **Laravel Framework**: ^11.31
- **Database**: MySQL/PostgreSQL (configurable)

### Key Laravel Packages
- **spatie/laravel-permission**: ^6.21 - Role & permission management
- **spatie/laravel-medialibrary**: ^11.13 - Media file handling
- **astrotomic/laravel-translatable**: ^11.16 - Multi-language support
- **mcamara/laravel-localization**: ^2.3 - Localization routing
- **maatwebsite/excel**: ^3.1 - Excel import/export
- **barryvdh/laravel-dompdf**: ^3.1 - PDF generation

### Frontend
- **Vite**: ^6.0.11 - Build tool
- **Tailwind CSS**: ^3.4.13 - Styling framework
- **Axios**: ^1.7.4 - HTTP client

### Development Tools
- **PHPUnit**: ^11.0.1 - Testing framework
- **Laravel Pint**: ^1.13 - Code formatter
- **Laravel Sail**: ^1.26 - Docker development environment
- **Laravel Boost**: ^1.1 - MCP server for development

---

## Architecture

### Modular Structure

The application follows a **modular monolith** architecture with four main modules:

#### 1. **Base Module** (`app/Modules/Base/`)
Foundation module providing shared functionality:
- **BaseModel**: Extends Eloquent with media handling, soft deletes, and activation traits
- **TenantScope**: Global scope for multi-tenancy filtering
- **SetOrganizationContext**: Middleware for setting organization context
- **Shared Traits**: `HasActivation` for enabling/disabling records

#### 2. **Admin Module** (`app/Modules/Admin/`)
Super admin functionality for platform management:

**Models:**
- `Admin` - Platform administrators
- `Organization` - Tenant organizations
- `Employee` - Organization staff members
- `Plan` - Subscription plans
- `Feature` - Plan features
- `HomeSection` - Homepage customization

**Key Features:**
- Admin authentication (`admin` guard)
- Organization management (CRUD)
- Subscription plan management
- Employee oversight
- Dashboard analytics

**Routes:** `/admins/*` (localized)

#### 3. **Organization Module** (`app/Modules/Organization/`)
Organization/tenant-specific e-commerce management:

**Core Models:**
- `Product` - Products with variations
- `ProductVariation` - SKU-level inventory
- `Category` - Hierarchical product categories
- `Brand` - Product brands
- `Option` & `OptionItem` - Product attributes (size, color, etc.)
- `Order`, `OrderItem`, `Payment` - Order management
- `Review`, `Wishlist` - Customer engagement
- `OrganizationSetting` - Store configuration
- `PaymentMethod` - Payment gateway settings

**Content Models:**
- `Header` - Store header settings
- `About`, `Why`, `Term` - Content pages
- `OurTeam` - Team member profiles
- `Question` - FAQ management

**Location Models:**
- `Country`, `City` - Geographic data
- `Address` - Customer addresses

**Key Features:**
- Multi-tenant scoping (TenantScope)
- Translatable content (Arabic & English)
- Media library integration
- Product import/export (Excel)
- Order processing workflow
- Payment gateway integration

**Routes:** `/organizations/*` (localized)

#### 4. **Website Module** (`app/Modules/Website/`)
Public-facing storefront (minimal implementation detected):

**Purpose:**
- Customer shopping interface
- Product browsing and search
- Checkout process
- Customer accounts

**Routes:** `/admin/*` prefix (needs review - may be incorrect)

---

## Multi-Tenancy Implementation

### Tenant Isolation Strategy
- **Organization-based tenancy**: Each organization operates independently
- **Global Scope**: `TenantScope` automatically filters queries by `organization_id`
- **Context Middleware**: `SetOrganizationContext` sets current organization from authenticated employee
- **Database Design**: Shared database with `organization_id` foreign keys

### Authentication Guards

The platform uses **multiple authentication guards**:

```php
- 'admin' → Admin users (super admin)
- 'organization_employee' → Organization employees
- 'web' → Default guard (customers)
```

---

## Internationalization (i18n)

### Supported Languages
- **English (en)** - Default
- **Arabic (ar)** - RTL support
- **Spanish (es)** - Available but not fully configured

### Translation Implementation
- **Route-based localization**: URLs prefixed with locale (`/en/`, `/ar/`)
- **Database translations**: Model content stored per language (via `astrotomic/laravel-translatable`)
- **Translation files**: Located in `lang/ar/` and `lang/en/`

### Translatable Models
Models implementing translations:
- Product, Category, Brand
- Plan, Feature
- About, Why, Term, Question
- OurTeam, HomeSection
- PaymentMethod

---

## Database Schema Overview

### Core Tables

**Admin Module:**
- `admins` - Platform administrators
- `organizations` - Tenant organizations
- `employees` - Organization staff
- `plans` - Subscription plans
- `features` - Plan features
- `feature_plans` - Plan-feature pivot
- `home_sections` - Homepage sections
- `home_section_products` - Section-product pivot

**Organization Module:**
- `categories` - Product categories (hierarchical)
- `brands` - Product brands
- `brand_categories` - Brand-category pivot
- `products` - Products (base info)
- `product_translations` - Product translations
- `product_variations` - SKU variants
- `options` - Product attributes (size, color)
- `option_items` - Attribute values
- `product_variation_option_items` - Variation attributes pivot
- `orders` - Customer orders
- `order_items` - Order line items
- `payments` - Payment transactions
- `reviews` - Product reviews
- `wishlists` - Customer wishlists
- `countries`, `cities` - Location data
- `addresses` - Customer addresses
- `organization_settings` - Store settings
- `payment_methods` - Available gateways
- `organization_payment_methods` - Org-specific gateway config
- `headers` - Store headers
- `header_images` - Header images
- `abouts`, `whys`, `terms`, `questions` - Content pages
- `our_teams` - Team members

**Laravel Standard:**
- `users` - Customers
- `user_otps` - OTP verification
- `permissions`, `roles` - Spatie permission tables
- `media` - Spatie media library
- `cache`, `jobs`, `sessions` - Laravel system tables

---

## Key Features

### 1. Product Management
- **Product Types**: Simple and variable products
- **Variations**: SKU-level inventory with options (size, color, etc.)
- **Categories**: Hierarchical organization
- **Brands**: Brand filtering
- **Media**: Multiple images and videos per product
- **Inventory**: Stock tracking with low stock thresholds
- **Translations**: Multi-language support
- **Bulk Operations**: Excel import/export

### 2. Order Management
- **Order States**: Status tracking workflow
- **Line Items**: Multiple products per order
- **Payment Processing**: Multiple payment gateway support
- **Address Management**: Shipping addresses
- **Order History**: Complete audit trail

### 3. Organization Settings
- **Store Configuration**: Name, logo, contact info
- **Payment Methods**: Gateway configuration per organization
- **Localization**: Language preferences
- **Header Customization**: Store branding

### 4. Content Management
- **About Pages**: Company information
- **FAQs**: Question management
- **Terms**: Legal pages
- **Team Pages**: Staff profiles
- **Homepage Sections**: Customizable homepage

### 5. Customer Features
- **Wishlists**: Save favorite products
- **Reviews**: Product ratings and reviews
- **Addresses**: Multiple shipping addresses

### 6. Admin Features
- **Organization Management**: Create and manage tenants
- **Subscription Plans**: Define features and pricing
- **Employee Management**: Organization staff oversight
- **Dashboard**: Platform analytics

---

## Authentication & Authorization

### Guards Configuration
```php
'admin' => Admin users (super admins)
'organization_employee' => Organization staff
'web' => Customers
```

### Middleware Stack
- `localeSessionRedirect` - Locale management
- `localizationRedirect` - Locale URL redirects
- `localeViewPath` - Localized view paths
- `redirect.admin` - Redirect admins to dashboard
- `set.organization.context` - Multi-tenancy context

### Permissions
Using **Spatie Laravel Permission**:
- Role-based access control
- Permission assignment
- Guard-specific permissions

---

## File Structure

```
app/
├── Exports/
│   └── ProductsExport.php
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Resources/
├── Models/
│   ├── User.php
│   └── UserOtp.php
├── Modules/
│   ├── Admin/
│   │   ├── app/
│   │   │   ├── DTO/
│   │   │   ├── Http/
│   │   │   ├── Models/
│   │   │   └── Services/
│   │   ├── Database/
│   │   │   ├── Migrations/
│   │   │   └── Seeders/
│   │   ├── Enums/
│   │   ├── Helpers/
│   │   ├── Providers/
│   │   ├── Resources/
│   │   └── Routes/
│   ├── Base/
│   │   ├── app/
│   │   │   ├── Models/
│   │   │   ├── Http/Middleware/
│   │   │   └── Scopes/
│   │   └── Traits/
│   ├── Organization/
│   │   ├── app/
│   │   │   ├── DTO/
│   │   │   ├── Http/
│   │   │   ├── Models/
│   │   │   └── Services/
│   │   ├── Config/
│   │   ├── Database/
│   │   ├── Enums/
│   │   ├── Helpers/
│   │   ├── Providers/
│   │   ├── Resources/
│   │   └── Routes/
│   └── Website/
│       ├── app/
│       │   ├── Enums/
│       │   ├── Http/
│       │   ├── Models/
│       │   ├── Services/
│       │   └── View/
│       ├── Database/
│       ├── Providers/
│       ├── Resources/
│       └── Routes/
└── Providers/
    └── AppServiceProvider.php
```

---

## Development Workflow

### Setup Commands
```bash
# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan db:seed

# Build assets
npm run build

# Start development
composer run dev  # Starts server, queue, logs, and vite
```

### Development Script
The `composer run dev` command runs concurrently:
1. **PHP Server**: `php artisan serve`
2. **Queue Worker**: `php artisan queue:listen --tries=1`
3. **Log Viewer**: `php artisan pail --timeout=0`
4. **Vite Dev Server**: `npm run dev`

### Code Quality
```bash
# Format code
vendor/bin/pint

# Run tests
php artisan test

# Run specific tests
php artisan test --filter=testName
php artisan test tests/Feature/ExampleTest.php
```

---

## API Structure

### Admin Routes
- Base: `/admins/*` (localized)
- Authentication: `admin` guard
- Features: Organizations, plans, features, admins

### Organization Routes
- Base: `/organizations/*` (localized)
- Authentication: `organization_employee` guard
- Features: Products, orders, categories, brands, settings

### Website Routes
- Base: `/` (public)
- Authentication: `web` guard
- Features: Shopping, checkout, account

---

## Design Patterns

### Used Patterns
1. **Repository Pattern**: Service classes abstract business logic
2. **DTO Pattern**: Data Transfer Objects for clean data handling
3. **Factory Pattern**: Model factories for testing
4. **Observer Pattern**: Model events and listeners
5. **Strategy Pattern**: Multiple payment gateways
6. **Scope Pattern**: Global scopes for multi-tenancy

### Laravel 11 Features
- **Streamlined structure**: No `app/Console/Kernel.php`
- **Slim middleware**: Defined in `bootstrap/app.php`
- **Modern routing**: Health checks, API routes
- **Casts method**: Using `casts()` method instead of `$casts` property

---

## Testing

### Test Structure
```
tests/
├── Feature/  # Integration tests
├── Unit/     # Unit tests
└── TestCase.php
```

### Testing Tools
- **PHPUnit 11**: Test runner
- **Factories**: Model factories for test data
- **Faker**: Fake data generation
- **Seeders**: Database seeding for tests

---

## Deployment Considerations

### Requirements
- PHP >= 8.2
- MySQL/PostgreSQL
- Node.js >= 18
- Composer
- Redis (optional, for caching)

### Production Checklist
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure database credentials
- [ ] Run `composer install --optimize-autoloader --no-dev`
- [ ] Run `npm run build`
- [ ] Run `php artisan migrate --force`
- [ ] Configure queue worker (Laravel Horizon recommended)
- [ ] Set up task scheduler (cron job)
- [ ] Configure mail driver
- [ ] Set up backup strategy
- [ ] Configure SSL certificates
- [ ] Optimize configurations: `php artisan config:cache`, `php artisan route:cache`

---

## Module Service Providers

Each module auto-registers via `AppServiceProvider`:

```php
// Auto-discovers and registers module service providers
$featuresPath = app_path('Modules');
$features = File::directories($featuresPath);

foreach ($features as $feature) {
    $featureName = basename($feature);
    $providerClass = "App\\Modules\\{$featureName}\\Providers\\{$featureName}ServiceProvider";
    // Registers provider dynamically
}
```

---

## Security Features

1. **Multi-guard authentication**: Separate authentication per user type
2. **Permission system**: Role-based access control
3. **Tenant isolation**: Automatic data scoping
4. **CSRF protection**: Laravel default
5. **SQL injection prevention**: Eloquent ORM
6. **XSS protection**: Blade templating
7. **Password hashing**: Bcrypt by default
8. **OTP verification**: User OTP system

---

## Extensibility

### Adding New Modules
1. Create module directory in `app/Modules/`
2. Add `Providers/{ModuleName}ServiceProvider.php`
3. Create module structure (Models, Controllers, Routes, etc.)
4. Provider auto-registers via `AppServiceProvider`

### Adding New Languages
1. Add locale to `config/laravellocalization.php`
2. Create language directory in `lang/`
3. Add translation files
4. Update translatable model configurations

### Adding Payment Gateways
1. Create gateway service in `Organization/app/Services/`
2. Add configuration to `payment_methods` table
3. Implement payment interface
4. Update checkout flow

---

## Known Issues & TODOs

### Website Module
- Routes use `/admin` prefix (likely incorrect)
- Minimal implementation detected
- Needs full storefront development

### Localization
- Spanish (es) configured but not fully implemented
- Some translation files may be incomplete

### Documentation Needs
- API documentation
- Deployment guide
- User manuals

---

## Support & Resources

### Laravel Documentation
- [Laravel 11 Docs](https://laravel.com/docs/11.x)
- [Spatie Media Library](https://spatie.be/docs/laravel-medialibrary)
- [Spatie Permission](https://spatie.be/docs/laravel-permission)

### Package Documentation
- [Laravel Localization](https://github.com/mcamara/laravel-localization)
- [Laravel Translatable](https://github.com/astrotomic/laravel-translatable)
- [Laravel Excel](https://laravel-excel.com)
- [DomPDF](https://github.com/barryvdh/laravel-dompdf)

---

## Contributing Guidelines

### Code Standards
- Follow PSR-12 coding standards
- Use Laravel Pint for formatting: `vendor/bin/pint`
- Write descriptive variable and method names
- Add PHPDoc blocks for complex methods
- Use type hints for all parameters and return types

### Git Workflow
1. Create feature branch from `main`
2. Make changes following conventions
3. Run tests: `php artisan test`
4. Format code: `vendor/bin/pint`
5. Commit with descriptive messages
6. Create pull request

### Testing Requirements
- Write feature tests for new features
- Maintain test coverage
- All tests must pass before merging

---

## License

This project is proprietary. All rights reserved.

---

**Last Updated**: October 2025  
**Laravel Version**: 11.31  
**PHP Version**: 8.2+

