# CR (Construction & Renovation) Module Rebuild Plan

## Overview
Rebuild CR as a first-class, independent clone of Service Management with identical behavior, separate naming, schema, routes, policies, and UI.

## Current State Analysis

### Existing Modules
- **ServiceManagement**: Full-featured module with 10 entities, admin UI, APIs, discounts, reviews
- **ConstructionManagement**: Partial legacy implementation with 6 entities, limited APIs, no admin UI
- **CartModule**: Handles both Service and CR items (recently fixed for CR support)

### Service Management Structure
```
ServiceManagement/
├── Entities/ (10 files)
│   ├── Service.php (main)
│   ├── Variation.php
│   ├── Faq.php
│   ├── ServiceTag.php
│   ├── Tag.php
│   ├── FavoriteService.php
│   ├── RecentSearch.php
│   ├── RecentView.php
│   ├── VisitedService.php
│   └── ServiceRequest.php
├── Http/Controllers/
│   ├── Api/V1/Admin/ (ServiceController, FAQController)
│   ├── Api/V1/Provider/ (ServiceController, ServiceRequestController, FAQController)
│   ├── Api/V1/Serviceman/ (ServiceController)
│   ├── Api/V1/Customer/ (ServiceController, FavoriteServiceController)
│   └── Web/Admin/ (ServiceController, FAQController, etc.)
├── Http/Requests/ (validation)
├── Http/Resources/ (API responses)
├── Database/Migrations/ (15 migrations)
├── Database/Seeders/
├── Routes/
│   ├── api/v1/api.php
│   └── web.php
├── Traits/
├── Resources/ (Blade views)
└── Providers/

### Current CR Implementation (ConstructionManagement)
```
ConstructionManagement/
├── Entities/ (6 files)
│   ├── CrService.php
│   ├── CrVariation.php
│   ├── CrFaq.php
│   ├── CrBooking.php
│   ├── CrBookingDetail.php
│   └── CrCart.php
├── Http/Controllers/
│   ├── Api/V1/Customer/ (ServiceController, CartController)
│   └── Web/Admin/ (partial)
├── Database/ (9 migrations)
├── Routes/
│   ├── api/v1/api.php (limited)
│   └── web.php
└── Providers/
```

## Naming & Mapping Rules

### Entities (Service → Cr)
| Service | CR |
|---------|-----|
| Service | CrService |
| Variation | CrVariation |
| Faq | CrFaq |
| ServiceTag | CrServiceTag |
| Tag | CrTag |
| FavoriteService | CrFavoriteService |
| RecentSearch | CrRecentSearch |
| RecentView | CrRecentView |
| VisitedService | CrVisitedService |
| ServiceRequest | CrServiceRequest |

### Tables (services → cr_services)
| Service | CR |
|---------|-----|
| services | cr_services |
| variations | cr_variations |
| faqs | cr_faqs |
| service_tags | cr_service_tags |
| tags | cr_tags |
| favorite_services | cr_favorite_services |
| recent_searches | cr_recent_searches |
| recent_views | cr_recent_views |
| visited_services | cr_visited_services |
| service_requests | cr_service_requests |

### Routes
- `/api/v1/service/*` → `/api/v1/cr/*`
- Route names: `service.` → `cr.`
- Policies: `service.*` → `cr.*`

### Events & Queues
- `ServiceCreated` → `CrServiceCreated`
- `service-queue` → `cr-queue`

## Implementation Phases

### Phase 1: Audit & Planning ✓
- [x] Document Service Management structure
- [x] Identify all components to clone
- [x] Create this plan

### Phase 2: Archive Legacy CR
**Goal**: Safely preserve old CR code, start fresh

**Steps**:
1. Create archive branch:
   ```bash
   git checkout -b archive/cr-legacy
   git push origin archive/cr-legacy
   ```

2. Create feature branch:
   ```bash
   git checkout -b feat/cr-rebuild
   ```

3. In feat/cr-rebuild, remove legacy CR:
   - Delete `/Modules/ConstructionManagement` (keep for reference)
   - Remove CR routes from main route loader
   - Remove CR menu items from admin config
   - Clear caches

### Phase 3: Clone Service Module
**Goal**: Create CrModule as exact copy of ServiceManagement with renamed symbols

**Steps**:
1. Copy entire ServiceManagement to CrModule:
   ```bash
   cp -r Modules/ServiceManagement Modules/CrModule
   ```

2. Systematic renaming (use IDE find-replace):
   - Namespaces: `Modules\ServiceManagement` → `Modules\CrModule`
   - Classes: `Service` → `CrService`, `Variation` → `CrVariation`, etc.
   - Tables: `services` → `cr_services`, etc.
   - Route names: `service.` → `cr.`
   - Policies: `service.*` → `cr.*`
   - Events: `ServiceCreated` → `CrServiceCreated`
   - Blade components: `service-` → `cr-`
   - Translation keys: `service.` → `cr.`

3. Update module.json:
   ```json
   {
     "name": "CrModule",
     "alias": "crmodule",
     "description": "Construction & Renovation Management",
     "providers": ["Modules\\CrModule\\Providers\\CrModuleServiceProvider"]
   }
   ```

4. Update composer.json PSR-4:
   ```json
   "Modules\\CrModule\\": "Modules/CrModule/"
   ```

5. Run:
   ```bash
   composer dump-autoload
   ```

### Phase 4: Database
**Goal**: Create CR tables and seed initial data

**Steps**:
1. Create migrations for CR tables (copy Service migrations, rename):
   - `2022_03_06_092202_create_cr_services_table.php`
   - `2022_03_06_094413_create_cr_variations_table.php`
   - `2022_05_12_100348_create_cr_faqs_table.php`
   - etc.

2. Update foreign keys in migrations:
   - `services` → `cr_services`
   - Ensure zone/category references remain unchanged

3. Create CrPermissionsSeeder:
   - Seed `cr.view`, `cr.create`, `cr.update`, `cr.delete`
   - Attach to same roles as `service.*`

4. Create CrDataSeeder:
   - Seed sample CR categories, subcategories, services, variations

5. Run:
   ```bash
   php artisan migrate
   php artisan db:seed --class=CrPermissionsSeeder
   php artisan db:seed --class=CrDataSeeder
   ```

### Phase 5: API Routes
**Goal**: Expose /api/v1/cr/* endpoints mirroring /api/v1/service/*

**Steps**:
1. Update `Modules/CrModule/Routes/api/v1/api.php`:
   - Change prefix from `customer/cr/service` to `cr/service`
   - Change prefix from `customer/cr/cart` to `cr/cart`
   - Update namespaces to `Modules\CrModule\Http\Controllers\Api\V1\*`
   - Add admin routes: `admin/cr/service`, `admin/cr/faq`
   - Add provider routes: `provider/cr/service`, `provider/cr/faq`

2. Register routes in main route loader (if needed)

3. Test endpoints:
   ```bash
   curl http://localhost/api/v1/cr/service
   curl http://localhost/api/v1/cr/service/detail/{id}
   ```

### Phase 6: Cart Integration
**Goal**: Wire CR items into cart with auto-provider selection

**Steps**:
1. Update CartModule to recognize `service_type`:
   - Add `service_type` enum: `service`, `cr_service`
   - Repository resolves item by type

2. Update cart item creation:
   - When adding CR service, set `service_type = 'cr_service'`
   - Auto-select provider if missing (already implemented)

3. Update cart calculations:
   - Use shared discount/tax calculators
   - Apply identical logic for both types

4. Test:
   ```bash
   POST /api/v1/customer/cart/add
   {
     "service_id": "cr-service-uuid",
     "service_type": "cr_service",
     "quantity": 1,
     "variant_key": "default"
   }
   ```

### Phase 7: Admin UI
**Goal**: Create CR admin pages and menu group

**Steps**:
1. Create admin controllers (copy from Service):
   - `Modules/CrModule/Http/Controllers/Web/Admin/ServiceController.php`
   - `Modules/CrModule/Http/Controllers/Web/Admin/FAQController.php`
   - `Modules/CrModule/Http/Controllers/Web/Admin/CategoryController.php`
   - `Modules/CrModule/Http/Controllers/Web/Admin/SubCategoryController.php`

2. Create admin views (copy from Service):
   - `Modules/CrModule/Resources/views/admin/service/`
   - `Modules/CrModule/Resources/views/admin/faq/`
   - `Modules/CrModule/Resources/views/admin/category/`
   - `Modules/CrModule/Resources/views/admin/subcategory/`

3. Register admin menu:
   - Add menu group: "Construction & Renovation"
   - Add menu items: Zones, Categories, SubCategories, Services, Discounts, Reports
   - Guard with `cr.view` policy

4. Update web routes:
   - Add admin routes for CRUD operations
   - Namespace: `Modules\CrModule\Http\Controllers\Web\Admin`

### Phase 8: Testing & Validation
**Goal**: Ensure CR works identically to Service

**Steps**:
1. Unit Tests:
   - Models: CrService, CrVariation, CrFaq
   - Repositories
   - Policies

2. Feature Tests:
   - API endpoints (list, detail, search, etc.)
   - Admin CRUD (create, read, update, delete)
   - Cart integration

3. Browser Tests:
   - Admin UI flows
   - Customer API flows

4. Performance:
   - List endpoints respond within SLO
   - No N+1 queries

5. Smoke Tests:
   - Full flow: list → detail → add to cart → checkout → order

## File Structure After Rebuild

```
Modules/CrModule/
├── Config/
├── Database/
│   ├── Migrations/
│   │   ├── 2022_03_06_092202_create_cr_services_table.php
│   │   ├── 2022_03_06_094413_create_cr_variations_table.php
│   │   ├── 2022_05_12_100348_create_cr_faqs_table.php
│   │   └── ... (all CR migrations)
│   └── Seeders/
│       ├── CrPermissionsSeeder.php
│       ├── CrDataSeeder.php
│       └── CrModuleDatabaseSeeder.php
├── Entities/
│   ├── CrService.php
│   ├── CrVariation.php
│   ├── CrFaq.php
│   ├── CrServiceTag.php
│   ├── CrTag.php
│   ├── CrFavoriteService.php
│   ├── CrRecentSearch.php
│   ├── CrRecentView.php
│   ├── CrVisitedService.php
│   └── CrServiceRequest.php
├── Http/
│   ├── Controllers/
│   │   ├── Api/
│   │   │   └── V1/
│   │   │       ├── Admin/
│   │   │       │   ├── ServiceController.php
│   │   │       │   └── FAQController.php
│   │   │       ├── Provider/
│   │   │       │   ├── ServiceController.php
│   │   │       │   ├── ServiceRequestController.php
│   │   │       │   └── FAQController.php
│   │   │       ├── Serviceman/
│   │   │       │   └── ServiceController.php
│   │   │       └── Customer/
│   │   │           ├── ServiceController.php
│   │   │           └── FavoriteServiceController.php
│   │   └── Web/
│   │       └── Admin/
│   │           ├── ServiceController.php
│   │           ├── FAQController.php
│   │           ├── CategoryController.php
│   │           └── SubCategoryController.php
│   ├── Requests/
│   │   ├── StoreCrServiceRequest.php
│   │   ├── UpdateCrServiceRequest.php
│   │   └── ... (all validation requests)
│   └── Resources/
│       ├── CrServiceResource.php
│       ├── CrVariationResource.php
│       └── ... (all API resources)
├── Providers/
│   └── CrModuleServiceProvider.php
├── Resources/
│   └── views/
│       ├── admin/
│       │   ├── service/
│       │   ├── faq/
│       │   ├── category/
│       │   └── subcategory/
│       └── components/
├── Routes/
│   ├── api/
│   │   └── v1/
│   │       └── api.php
│   └── web.php
├── Traits/
├── module.json
└── composer.json
```

## Deployment Checklist

- [ ] Create archive/cr-legacy branch
- [ ] Create feat/cr-rebuild branch
- [ ] Copy ServiceManagement to CrModule
- [ ] Rename all symbols systematically
- [ ] Update composer.json PSR-4
- [ ] Run composer dump-autoload
- [ ] Create CR migrations
- [ ] Create CR seeders
- [ ] Run migrations and seeders
- [ ] Update API routes
- [ ] Create admin controllers and views
- [ ] Register admin menu
- [ ] Wire cart integration
- [ ] Run unit tests
- [ ] Run feature tests
- [ ] Run browser tests
- [ ] Smoke test full flow
- [ ] Deploy to staging
- [ ] Deploy to production

## Rollout Strategy

1. **Staging**: Deploy with feature flag `features.cr_module=true`
2. **Validation**: Run smoke tests, verify admin UI, test customer flows
3. **Production**: Deploy with flag enabled
4. **Monitoring**: Track metrics, monitor error logs
5. **Rollback**: If issues, disable flag or revert commit

## Success Criteria

- ✅ All CRUD for CR entities work in Admin with identical UX to Service
- ✅ Public APIs under /api/v1/cr/* return same shapes as Service endpoints
- ✅ Cart can add CR items with auto-provider selection
- ✅ Discounts and tax calculations match Service
- ✅ Policies enforce cr.* abilities correctly
- ✅ Postman tests pass for full CR flow
- ✅ No references to legacy CR code remain
- ✅ Feature flag controls CR visibility

## Notes

- **No new business logic**: CR must mirror Service exactly
- **No coupling**: CR and Service data models are independent
- **Shared utilities**: Discount/tax calculators used by both
- **Backward compatibility**: Existing Service functionality unchanged
- **Performance**: CR endpoints respond within same SLO as Service

## References

- Service Management: `/Modules/ServiceManagement/`
- Current CR: `/Modules/ConstructionManagement/`
- Cart Integration: `/Modules/CartModule/Http/Controllers/Api/V1/Customer/CartController.php`
- Admin Module: `/Modules/AdminModule/`
