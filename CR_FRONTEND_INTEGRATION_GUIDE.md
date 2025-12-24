# CR Module Frontend Integration Guide & Testing

## Overview

The Flutter frontend is **already partially integrated** with CR mode. This guide explains the current integration and provides comprehensive testing instructions.

---

## Current Frontend Integration Status

### ✅ Already Implemented

1. **CrModeController** (`lib/feature/cr_mode/controller/cr_mode_controller.dart`)
   - Manages CR mode toggle state
   - Server-side enabled flag + user-side local toggle
   - Persists state in SharedPreferences

2. **CartController Updates** (`lib/feature/cart/controller/cart_controller.dart`)
   - CR mode detection in `updateQuantity()` - caps quantity to 1 for CR
   - `setInitialCartList()` handles CR services with fallback pricing
   - `addToCartApi()` sends variant_key='default' for services without variations
   - Provider auto-selection implemented

3. **Service Center Dialog** (`lib/common/widgets/service_center_dialog.dart`)
   - Auto-selects first variation for CR services
   - Handles zero-price CR services (get_quote flow)

4. **API Constants** (`lib/utils/app_constants.dart`)
   - CR endpoints configured:
     - `/api/v1/customer/cr/service` - List all CR services
     - `/api/v1/customer/cr/service/search` - Search CR services
     - `/api/v1/customer/cr/service/sub-category/{id}` - Services by subcategory
     - `/api/v1/customer/cr/service/detail/{id}` - Service details

5. **Cart API Endpoints**
   - `/api/v1/customer/cart/add` - Add items (works for both Service and CR)
   - `/api/v1/customer/cart/list` - Get cart items
   - Provider auto-selection fallback in backend

---

## Frontend Code Flow

### 1. CR Mode Toggle Flow

```dart
// In any screen, toggle CR mode:
Get.find<CrModeController>().toggleCrMode();

// Check if CR mode is active:
bool isCrMode = Get.find<CrModeController>().isCrMode;

// Check if CR is enabled on server:
bool isEnabled = Get.find<CrModeController>().isEnabled;
```

### 2. Service List Flow (CR vs Regular)

```dart
// Service list automatically filters based on CR mode
// ServiceController handles this internally

// When CR mode is ON:
// - Fetches from /api/v1/customer/cr/service
// - Shows CR services only

// When CR mode is OFF:
// - Fetches from /api/v1/customer/service
// - Shows regular services only
```

### 3. Add to Cart Flow (CR Service)

```
User selects CR service
  ↓
ServiceCenterDialog opens
  ↓
CartController.setInitialCartList(service)
  - Checks for variations
  - Falls back to crBasePrice
  - Falls back to defaultPrice
  - Falls back to 0 (get_quote)
  ↓
User sets quantity (max 1 for CR)
  ↓
User taps "Add to Cart"
  ↓
CartController.addMultipleCartToServer(providerId)
  - Gets provider if not selected
  - Calls addToCartApi() for each item
  ↓
CartController.addToCartApi()
  - Sends: service_id, provider_id, variant_key='default', quantity
  ↓
Backend: POST /api/v1/customer/cart/add
  - Finds service in cr_services table
  - Auto-selects provider if empty
  - Returns success
  ↓
Frontend: Shows "successfully_added_to_cart"
```

---

## Testing Guide

### Prerequisites

1. **Backend Running**
   ```bash
   cd /Users/MyWork/GitHub/Companies/makemyhome/makehome\ 2/makesmyhome/public_html
   php artisan serve
   ```

2. **Migrations & Seeds Run**
   ```bash
   php artisan migrate
   php artisan db:seed --class=CrModuleDatabaseSeeder
   ```

3. **Caches Cleared**
   ```bash
   php artisan optimize:clear
   ```

4. **Flutter App Running**
   ```bash
   cd /Users/MyWork/GitHub/Companies/makemyhome/makehome\ 2/makesmyhome
   flutter run
   ```

---

## Test Cases

### Test 1: CR Mode Toggle

**Objective**: Verify CR mode can be toggled on/off

**Steps**:
1. Open app
2. Navigate to home/services screen
3. Look for CR mode toggle (usually in settings or header)
4. Toggle CR mode ON
5. Verify services list changes to show CR services
6. Toggle CR mode OFF
7. Verify services list changes back to regular services

**Expected Result**: ✅ Services list updates based on CR mode toggle

**Debug Logs to Check**:
```
[CART_ADD_API] isLoggedIn: true/false
[CART_ADD_API] service_id: {uuid}
[CART_ADD_API] provider_id: {uuid}
```

---

### Test 2: CR Service List (Logged In)

**Objective**: Verify CR services load correctly for logged-in user

**Steps**:
1. Login with valid credentials
2. Toggle CR mode ON
3. Navigate to services/home screen
4. Wait for services to load
5. Verify CR services appear in list

**Expected Result**: ✅ CR services load and display correctly

**Debug Logs**:
```
I/flutter: [CART_ADD_API] isLoggedIn: true
```

**cURL Test** (from terminal):
```bash
curl -H "Authorization: Bearer {token}" \
  https://housecraft.online/api/v1/customer/cr/service
```

---

### Test 3: CR Service List (Guest)

**Objective**: Verify CR services load correctly for guest user

**Steps**:
1. Don't login (guest mode)
2. Toggle CR mode ON
3. Navigate to services/home screen
4. Wait for services to load
5. Verify CR services appear in list

**Expected Result**: ✅ CR services load for guest user

**Debug Logs**:
```
I/flutter: [CART_ADD_API] isLoggedIn: false
I/flutter: [CART_ADD_API] guestId: {uuid}
```

**cURL Test**:
```bash
curl "https://housecraft.online/api/v1/customer/cr/service?guest_id={guest_id}"
```

---

### Test 4: Add CR Service to Cart (Logged In)

**Objective**: Verify CR service can be added to cart by logged-in user

**Steps**:
1. Login with valid credentials
2. Toggle CR mode ON
3. Navigate to CR services
4. Tap on a CR service
5. ServiceCenterDialog opens
6. Verify price displays (or "Get Quote" for zero-price)
7. Set quantity to 1
8. Tap "Add to Cart"
9. Verify "successfully_added_to_cart" message

**Expected Result**: ✅ CR service added to cart successfully

**Debug Logs to Check**:
```
[CART_ADD_API] START - providerId: {uuid}, cartList length: 1
[CART_ADD_API] service_id: {uuid}, provider_id: {uuid}, variant_key: default, quantity: 1
[CART_ADD_API] response_code: 200, body: {response_code: 200, ...}
[CART_ADD_API] success: true
[CART_ADD_MULTI] After refresh - allSuccess: true, cartList length: 1
```

---

### Test 5: Add CR Service to Cart (Guest)

**Objective**: Verify CR service can be added to cart by guest user

**Steps**:
1. Don't login (guest mode)
2. Toggle CR mode ON
3. Navigate to CR services
4. Tap on a CR service
5. ServiceCenterDialog opens
6. Set quantity to 1
7. Tap "Add to Cart"
8. Verify "successfully_added_to_cart" message

**Expected Result**: ✅ CR service added to cart successfully (guest)

**Debug Logs**:
```
[CART_ADD_API] isLoggedIn: false
[CART_ADD_API] guestId: {uuid}
[CART_ADD_API] success: true
```

---

### Test 6: CR Service with Variations

**Objective**: Verify CR service with multiple variations displays correctly

**Steps**:
1. Login
2. Toggle CR mode ON
3. Navigate to CR services
4. Find a service with variations (Standard, Premium, Luxury)
5. Tap on service
6. Verify all variations display
7. Select different variations
8. Verify price updates
9. Add to cart

**Expected Result**: ✅ Variations display and prices update correctly

**Debug Logs**:
```
[CART_ADD_API] variant_key: standard
[CART_ADD_API] variant_key: premium
[CART_ADD_API] variant_key: luxury
```

---

### Test 7: CR Service Without Variations (Zero Price)

**Objective**: Verify CR service without price/variations shows "Get Quote"

**Steps**:
1. Login
2. Toggle CR mode ON
3. Navigate to CR services
4. Find a zero-price service (if exists)
5. Tap on service
6. Verify "Get Quote" or similar message
7. Quantity should be 1
8. Add to cart

**Expected Result**: ✅ Zero-price service handled gracefully

**Debug Logs**:
```
[CART_ADD_API] variant_key: default
[CART_ADD_API] quantity: 1
```

---

### Test 8: Quantity Cap for CR Services

**Objective**: Verify CR services are capped at quantity 1

**Steps**:
1. Login
2. Toggle CR mode ON
3. Add CR service to cart (quantity 1)
4. In ServiceCenterDialog, try to increment quantity
5. Verify quantity stays at 1 (doesn't go to 2)

**Expected Result**: ✅ Quantity capped at 1 for CR services

**Code Location**: `lib/feature/cart/controller/cart_controller.dart` line 187

---

### Test 9: Provider Auto-Selection

**Objective**: Verify provider is auto-selected if not provided

**Steps**:
1. Login
2. Toggle CR mode ON
3. Add CR service to cart WITHOUT selecting provider
4. Verify cart item has provider assigned
5. Check cart list shows provider

**Expected Result**: ✅ Provider auto-selected from active providers in zone

**Debug Logs**:
```
[CART_ADD_API] Auto-selected provider: {uuid}
```

---

### Test 10: Cart List Shows CR Items

**Objective**: Verify cart list displays CR items correctly

**Steps**:
1. Login
2. Toggle CR mode ON
3. Add multiple CR services to cart
4. Navigate to cart screen
5. Verify all CR items display
6. Verify prices, quantities, and providers show

**Expected Result**: ✅ Cart list shows all CR items with correct details

**cURL Test**:
```bash
curl -H "Authorization: Bearer {token}" \
  "https://housecraft.online/api/v1/customer/cart/list?limit=100&offset=1"
```

---

### Test 11: Mixed Cart (Regular + CR)

**Objective**: Verify cart can contain both regular and CR services

**Steps**:
1. Login
2. Toggle CR mode OFF
3. Add regular service to cart
4. Toggle CR mode ON
5. Add CR service to cart
6. Navigate to cart
7. Verify both items show

**Expected Result**: ✅ Cart shows both regular and CR items

**Note**: Backend should handle both service types in cart

---

### Test 12: Search CR Services

**Objective**: Verify CR service search works

**Steps**:
1. Login
2. Toggle CR mode ON
3. Navigate to search
4. Search for CR service (e.g., "renovation")
5. Verify results show CR services only

**Expected Result**: ✅ Search returns CR services

**cURL Test**:
```bash
curl -X POST \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{"search":"renovation"}' \
  https://housecraft.online/api/v1/customer/cr/service/search
```

---

### Test 13: CR Service Details

**Objective**: Verify CR service detail page loads correctly

**Steps**:
1. Login
2. Toggle CR mode ON
3. Navigate to CR services
4. Tap on a service
5. Verify detail page loads
6. Check all info displays (name, description, price, variations, etc.)

**Expected Result**: ✅ Service detail page loads and displays correctly

**cURL Test**:
```bash
curl -H "Authorization: Bearer {token}" \
  "https://housecraft.online/api/v1/customer/cr/service/detail/{service_id}"
```

---

### Test 14: Checkout with CR Items

**Objective**: Verify checkout works with CR items in cart

**Steps**:
1. Login
2. Toggle CR mode ON
3. Add CR service to cart
4. Navigate to checkout
5. Verify CR item shows in order summary
6. Verify price calculation is correct
7. Complete checkout

**Expected Result**: ✅ Checkout completes successfully with CR items

---

### Test 15: Order Confirmation with CR

**Objective**: Verify order confirmation shows CR items

**Steps**:
1. Complete checkout with CR items (Test 14)
2. Verify order confirmation page shows
3. Verify CR item details in order summary
4. Navigate to "My Orders"
5. Verify CR order appears in list

**Expected Result**: ✅ Order confirmation and history show CR items

---

## Debug Logging Locations

### Frontend Logs

**Cart Controller** (`lib/feature/cart/controller/cart_controller.dart`):
```dart
print('[CART_ADD_API] START - providerId: $providerId, cartList length: ${_cartList.length}');
print('[CART_ADD_API] service_id: ${cartModel.service!.id}, provider_id: $pid, variant_key: $variantKeyToSend, quantity: ${cartModel.quantity}');
print('[CART_ADD_API] isLoggedIn: $isLoggedIn, guestId: $guestId');
print('[CART_ADD_API] response_code: ${resp.statusCode}, body: ${resp.body}');
print('[CART_ADD_API] success: $success');
print('[CART_ADD_MULTI] After refresh - allSuccess: $allSuccess, cartList length: ${_cartList.length}');
```

**CR Mode Controller** (`lib/feature/cr_mode/controller/cr_mode_controller.dart`):
- Toggle state changes
- Server enable/disable

### Backend Logs

**CartController** (`/Modules/CartModule/Http/Controllers/Api/V1/Customer/CartController.php`):
```php
error_log("[CART_ADD] Service not found: {$request['service_id']}");
error_log("[CART_ADD] Auto-selected provider: {$providerId}");
error_log("[CART_ADD] No variation found, using service price: {$price}");
error_log("[CART_ADD] Success - service_id: {$request['service_id']}, customer_id: {$customerUserId}, price: {$price}");
```

**Log File**: `/tmp/cart_debug.log` (on server)

---

## Common Issues & Solutions

### Issue 1: "failed_to_add_to_cart" Message

**Symptoms**: Add to cart fails with error message

**Possible Causes**:
1. Provider not found/auto-selected
2. Service not found in database
3. Variation lookup failed
4. Tax calculation error

**Solution**:
1. Check backend logs: `tail -f /tmp/cart_debug.log`
2. Verify CR service exists in database: `SELECT * FROM cr_services;`
3. Verify provider exists in zone: `SELECT * FROM providers WHERE zone_id = '{zone_id}' AND is_active = 1;`
4. Check CartController logs for specific error

---

### Issue 2: CR Services Not Showing

**Symptoms**: CR mode ON but no services appear

**Possible Causes**:
1. CR mode not enabled on server
2. No CR services in database
3. Zone filtering issue
4. API endpoint not responding

**Solution**:
1. Verify CR services exist: `SELECT COUNT(*) FROM cr_services;`
2. Test API directly:
   ```bash
   curl https://housecraft.online/api/v1/customer/cr/service
   ```
3. Check zone configuration
4. Verify CrModule routes registered: `php artisan route:list | grep cr`

---

### Issue 3: Quantity Not Capped at 1

**Symptoms**: CR service quantity goes above 1

**Possible Causes**:
1. CrModeController not registered
2. CR mode flag not set correctly
3. updateQuantity() logic issue

**Solution**:
1. Verify CrModeController is initialized
2. Check CR mode toggle state
3. Add debug log in updateQuantity():
   ```dart
   print('isCr: $isCr, quantity: ${_initialCartList[index].quantity}');
   ```

---

### Issue 4: Provider Not Auto-Selected

**Symptoms**: Cart item has no provider

**Possible Causes**:
1. No active providers in zone
2. Provider lookup failed
3. Backend auto-selection not working

**Solution**:
1. Verify active providers: `SELECT * FROM providers WHERE zone_id = '{zone_id}' AND is_active = 1;`
2. Check CartController auto-selection logic
3. Test provider API: `curl https://housecraft.online/api/v1/customer/provider/list-by-sub-category`

---

## Testing Checklist

- [ ] Test 1: CR Mode Toggle
- [ ] Test 2: CR Service List (Logged In)
- [ ] Test 3: CR Service List (Guest)
- [ ] Test 4: Add CR Service to Cart (Logged In)
- [ ] Test 5: Add CR Service to Cart (Guest)
- [ ] Test 6: CR Service with Variations
- [ ] Test 7: CR Service Without Variations
- [ ] Test 8: Quantity Cap for CR Services
- [ ] Test 9: Provider Auto-Selection
- [ ] Test 10: Cart List Shows CR Items
- [ ] Test 11: Mixed Cart (Regular + CR)
- [ ] Test 12: Search CR Services
- [ ] Test 13: CR Service Details
- [ ] Test 14: Checkout with CR Items
- [ ] Test 15: Order Confirmation with CR

---

## Performance Considerations

1. **Service List Pagination**: CR services paginated (limit=20, offset=1)
2. **Variation Loading**: Lazy load variations only when needed
3. **Provider Lookup**: Cached after first request
4. **Cart Sync**: Debounced to avoid excessive API calls

---

## API Response Examples

### CR Service List Response

```json
{
  "response_code": "200",
  "message": "success",
  "content": [
    {
      "id": "uuid",
      "name": "Basic Home Renovation",
      "short_description": "Complete home renovation package",
      "description": "Professional home renovation services...",
      "category_id": "uuid",
      "sub_category_id": "uuid",
      "tax": 10.0,
      "is_active": 1,
      "rating_count": 0,
      "avg_rating": 0,
      "thumbnail_full_path": "url",
      "cover_image_full_path": "url",
      "variations": [
        {
          "id": "uuid",
          "variant": "Standard",
          "variant_key": "standard",
          "price": 5000,
          "zone_id": "uuid"
        }
      ]
    }
  ]
}
```

### Add to Cart Request

```json
{
  "service_id": "uuid",
  "category_id": "uuid",
  "sub_category_id": "uuid",
  "variant_key": "default",
  "quantity": "1",
  "provider_id": "uuid",
  "guest_id": null
}
```

### Add to Cart Response (Success)

```json
{
  "response_code": "200",
  "message": "Item added to cart successfully",
  "content": null,
  "errors": []
}
```

---

## Next Steps

1. **Run all 15 test cases** above
2. **Document any failures** with logs
3. **Fix issues** identified during testing
4. **Deploy to staging** for QA testing
5. **Enable feature flag** in production: `features.cr_module=true`

---

## References

- **Frontend Cart Controller**: `/lib/feature/cart/controller/cart_controller.dart`
- **CR Mode Controller**: `/lib/feature/cr_mode/controller/cr_mode_controller.dart`
- **Service Center Dialog**: `/lib/common/widgets/service_center_dialog.dart`
- **Backend CartController**: `/Modules/CartModule/Http/Controllers/Api/V1/Customer/CartController.php`
- **CrModule Routes**: `/Modules/CrModule/Routes/api/v1/api.php`
