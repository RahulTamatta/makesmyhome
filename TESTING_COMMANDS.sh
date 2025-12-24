#!/bin/bash

# CR Module Frontend Integration - Testing Commands
# Run these commands to test CR module functionality

BASE_URL="https://housecraft.online"
TOKEN="your_auth_token_here"
GUEST_ID="your_guest_id_here"
ZONE_ID="426a43e6-ce60-4126-b582-86203af07747"

echo "=========================================="
echo "CR Module Testing Commands"
echo "=========================================="
echo ""

# Test 1: Get CR Services (Authenticated)
echo "Test 1: Get CR Services (Authenticated)"
echo "Command:"
echo "curl -H \"Authorization: Bearer $TOKEN\" \\"
echo "  \"$BASE_URL/api/v1/customer/cr/service\""
echo ""
curl -H "Authorization: Bearer $TOKEN" \
  "$BASE_URL/api/v1/customer/cr/service" | jq '.'
echo ""
echo ""

# Test 2: Get CR Services (Guest)
echo "Test 2: Get CR Services (Guest)"
echo "Command:"
echo "curl \"$BASE_URL/api/v1/customer/cr/service?guest_id=$GUEST_ID\""
echo ""
curl "$BASE_URL/api/v1/customer/cr/service?guest_id=$GUEST_ID" | jq '.'
echo ""
echo ""

# Test 3: Search CR Services
echo "Test 3: Search CR Services"
echo "Command:"
echo "curl -X POST \\"
echo "  -H \"Authorization: Bearer $TOKEN\" \\"
echo "  -H \"Content-Type: application/json\" \\"
echo "  -d '{\"search\":\"renovation\"}' \\"
echo "  \"$BASE_URL/api/v1/customer/cr/service/search\""
echo ""
curl -X POST \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"search":"renovation"}' \
  "$BASE_URL/api/v1/customer/cr/service/search" | jq '.'
echo ""
echo ""

# Test 4: Get CR Service Details
echo "Test 4: Get CR Service Details"
echo "Note: Replace {service_id} with actual CR service ID from Test 1"
echo "Command:"
echo "curl -H \"Authorization: Bearer $TOKEN\" \\"
echo "  \"$BASE_URL/api/v1/customer/cr/service/detail/{service_id}\""
echo ""
echo ""

# Test 5: Add CR Service to Cart
echo "Test 5: Add CR Service to Cart"
echo "Note: Replace values with actual IDs from Test 1"
echo "Command:"
echo "curl -X POST \\"
echo "  -H \"Authorization: Bearer $TOKEN\" \\"
echo "  -H \"Content-Type: application/json\" \\"
echo "  -d '{"
echo "    \"service_id\": \"{service_id}\","
echo "    \"category_id\": \"{category_id}\","
echo "    \"sub_category_id\": \"{sub_category_id}\","
echo "    \"variant_key\": \"default\","
echo "    \"quantity\": \"1\","
echo "    \"provider_id\": \"{provider_id}\""
echo "  }' \\"
echo "  \"$BASE_URL/api/v1/customer/cart/add\""
echo ""
echo ""

# Test 6: Get Cart List
echo "Test 6: Get Cart List"
echo "Command:"
echo "curl -H \"Authorization: Bearer $TOKEN\" \\"
echo "  \"$BASE_URL/api/v1/customer/cart/list?limit=100&offset=1\""
echo ""
curl -H "Authorization: Bearer $TOKEN" \
  "$BASE_URL/api/v1/customer/cart/list?limit=100&offset=1" | jq '.'
echo ""
echo ""

# Test 7: Get Providers by Subcategory
echo "Test 7: Get Providers by Subcategory"
echo "Command:"
echo "curl -H \"Authorization: Bearer $TOKEN\" \\"
echo "  \"$BASE_URL/api/v1/customer/provider/list-by-sub-category?sub_category_id={sub_category_id}\""
echo ""
echo ""

# Test 8: Check CR Services in Database
echo "Test 8: Check CR Services in Database"
echo "Command (run on server):"
echo "mysql -u root -p -e \"SELECT COUNT(*) as cr_service_count FROM cr_services;\""
echo ""
echo ""

# Test 9: Check Active Providers in Zone
echo "Test 9: Check Active Providers in Zone"
echo "Command (run on server):"
echo "mysql -u root -p -e \"SELECT id, name, zone_id FROM providers WHERE zone_id = '$ZONE_ID' AND is_active = 1 LIMIT 5;\""
echo ""
echo ""

# Test 10: Check Cart Items
echo "Test 10: Check Cart Items in Database"
echo "Command (run on server):"
echo "mysql -u root -p -e \"SELECT id, service_id, provider_id, quantity, service_cost FROM cart LIMIT 10;\""
echo ""
echo ""

# Test 11: View Backend Logs
echo "Test 11: View Backend Logs"
echo "Command (run on server):"
echo "tail -f /tmp/cart_debug.log"
echo ""
echo ""

# Test 12: Clear Laravel Caches
echo "Test 12: Clear Laravel Caches"
echo "Command (run on server):"
echo "cd /Users/MyWork/GitHub/Companies/makemyhome/makehome\\ 2/makesmyhome/public_html"
echo "php artisan optimize:clear"
echo ""
echo ""

echo "=========================================="
echo "Testing Complete!"
echo "=========================================="
echo ""
echo "Next Steps:"
echo "1. Replace placeholders (TOKEN, GUEST_ID, service_id, etc.) with actual values"
echo "2. Run each test command individually"
echo "3. Check responses for errors"
echo "4. Review backend logs for debugging"
echo "5. Refer to CR_FRONTEND_INTEGRATION_GUIDE.md for detailed test cases"
echo ""
