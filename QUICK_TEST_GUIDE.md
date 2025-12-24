# CR Module - Quick Testing Guide (5 Minutes)

## One-Minute Setup

```bash
# Terminal 1: Backend
cd /Users/MyWork/GitHub/Companies/makemyhome/makehome\ 2/makesmyhome/public_html
php artisan migrate
php artisan db:seed --class=CrModuleDatabaseSeeder
php artisan optimize:clear
php artisan serve

# Terminal 2: Frontend
cd /Users/MyWork/GitHub/Companies/makemyhome/makehome\ 2/makesmyhome
flutter run
```

---

## Test Scenario (5 Minutes)

### Step 1: Login (1 min)
- Open app
- Login with valid credentials
- Verify home screen loads

### Step 2: Toggle CR Mode (1 min)
- Find CR mode toggle (settings or header)
- Toggle ON
- Verify services list changes to show CR services
- You should see: "Basic Home Renovation", "Kitchen Remodeling", "Bathroom Renovation"

### Step 3: Add to Cart (2 min)
- Tap on "Basic Home Renovation"
- ServiceCenterDialog opens
- Verify price shows (e.g., ₹5000)
- Quantity should be 1 (capped)
- Tap "Add to Cart"
- Verify "successfully_added_to_cart" message appears ✅

### Step 4: Verify Cart (1 min)
- Navigate to cart screen
- Verify CR item shows with:
  - Service name: "Basic Home Renovation"
  - Price: ₹5000
  - Quantity: 1
  - Provider name (auto-selected)

---

## Expected Logs

### Frontend Console
```
[CART_ADD_API] service_id: 8ca6be58-cb7a-4f47-a4ec-b2cde243dd27
[CART_ADD_API] provider_id: 6b6fd709-f361-459d-8f08-a9c20a814ce9
[CART_ADD_API] variant_key: default
[CART_ADD_API] quantity: 1
[CART_ADD_API] response_code: 200, body: {response_code: 200, ...}
[CART_ADD_API] success: true
```

### Backend Logs
```bash
tail -f /tmp/cart_debug.log

# Should show:
[CART_ADD] Service not found: ... (if service doesn't exist)
[CART_ADD] Auto-selected provider: 6b6fd709-f361-459d-8f08-a9c20a814ce9
[CART_ADD] No variation found, using service price: 5000
[CART_ADD] Success - service_id: 8ca6be58-..., customer_id: ebb0b576-..., price: 5000
```

---

## Quick Verification

### If ✅ Success
- CR services appear when CR mode ON
- CR service adds to cart successfully
- Cart shows CR item with correct details
- "successfully_added_to_cart" message appears
- **Status**: Ready for full testing suite

### If ❌ Failed
- Check backend logs: `tail -f /tmp/cart_debug.log`
- Verify CR services in DB: `SELECT COUNT(*) FROM cr_services;`
- Verify providers exist: `SELECT * FROM providers WHERE is_active = 1 LIMIT 1;`
- Test API directly: See `TESTING_COMMANDS.sh`

---

## Next: Full Testing

Once quick test passes, run full 15-test suite:
- See `CR_FRONTEND_INTEGRATION_GUIDE.md` for detailed tests
- See `TESTING_COMMANDS.sh` for cURL commands
- See `CR_TESTING_SUMMARY.md` for complete guide

---

## Key Files

- **Backend**: `/Modules/CrModule/` (complete module)
- **Frontend**: `/lib/feature/cr_mode/` (CR mode controller)
- **Cart Logic**: `/lib/feature/cart/controller/cart_controller.dart`
- **API Constants**: `/lib/utils/app_constants.dart`

---

## Success = ✅

If you see "successfully_added_to_cart" message and CR item in cart, the integration is working!

Proceed to full testing suite for comprehensive validation.
