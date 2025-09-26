# Hostinger Web Deployment Guide for MakesMyHome Flutter App

## Root Cause of White Screen Issue

The white screen on Hostinger is typically caused by:
1. **Base href misconfiguration** - Fixed by setting `<base href="/">`
2. **Missing service worker registration** - Fixed with proper Flutter bootstrap
3. **Routing issues** - Fixed with `.htaccess` for Apache servers
4. **Missing loading screen** - Fixed with custom loading indicator

## Step-by-Step Deployment Process

### 1. Build the Flutter Web App
```bash
flutter clean
flutter pub get
flutter build web --release --web-renderer html
```

**Important**: Use `--web-renderer html` for better compatibility with older browsers and hosting providers.

### 2. Upload Files to Hostinger

Upload the entire contents of the `build/web/` directory to your Hostinger public_html folder:

**Required Files:**
- `index.html` (modified with proper base href and loading screen)
- `.htaccess` (for proper routing)
- `manifest.json`
- `favicon.png`
- `flutter_bootstrap.js`
- `main.dart.js`
- `flutter_service_worker.js`
- `icons/` folder
- `assets/` folder
- `canvaskit/` folder (if using CanvasKit renderer)

### 3. Hostinger-Specific Configuration

#### File Structure in public_html:
```
public_html/
├── index.html
├── .htaccess
├── manifest.json
├── favicon.png
├── flutter_bootstrap.js
├── main.dart.js
├── flutter_service_worker.js
├── icons/
│   ├── Icon-192.png
│   └── Icon-512.png
├── assets/
│   └── (all your app assets)
└── canvaskit/
    └── (CanvasKit files if needed)
```

### 4. Verify Domain Configuration

Make sure your domain `makesmyhome.com` is properly configured in Hostinger:
1. Domain should point to public_html
2. SSL certificate should be enabled
3. HTTPS redirect should be enabled

### 5. Test the Deployment

1. Clear browser cache completely
2. Visit `https://makesmyhome.com`
3. Check browser developer console for any errors
4. Verify all assets are loading correctly

## Common Issues and Solutions

### Issue 1: Still Getting White Screen
**Solution**: Check browser console for errors. Common causes:
- Missing `main.dart.js` file
- CORS errors (check API endpoints)
- JavaScript errors during initialization

### Issue 2: 404 Errors on Page Refresh
**Solution**: The `.htaccess` file should handle this, but verify:
- `.htaccess` is uploaded to public_html
- Apache mod_rewrite is enabled (usually enabled on Hostinger)

### Issue 3: Assets Not Loading
**Solution**: Check file paths in browser network tab:
- All assets should load from your domain
- No mixed content warnings (HTTP vs HTTPS)

### Issue 4: API Calls Failing
**Solution**: Check CORS configuration:
- Backend API should allow requests from your domain
- Check if API endpoints are accessible from production

## Performance Optimization

The deployment includes:
- GZIP compression via `.htaccess`
- Proper cache headers for static assets
- Optimized loading screen
- Security headers

## Debugging Steps

If the app still shows white screen:

1. **Check Browser Console**:
   - Press F12 → Console tab
   - Look for JavaScript errors
   - Check Network tab for failed requests

2. **Verify File Upload**:
   - Ensure all files from `build/web/` are uploaded
   - Check file permissions (should be 644 for files, 755 for folders)

3. **Test API Connectivity**:
   - Open browser console
   - Try: `fetch('https://housecraft.online/api/v1/config')`
   - Should return JSON response

4. **Check Service Worker**:
   - In browser DevTools → Application → Service Workers
   - Should show registered service worker

## Contact Support

If issues persist:
1. Check Hostinger error logs in cPanel
2. Contact Hostinger support for server-specific issues
3. Verify DNS propagation is complete

## Build Command Summary
```bash
# Clean and build for production
flutter clean
flutter pub get
flutter build web --release --web-renderer html --base-href "/"

# Upload contents of build/web/ to public_html/
```

The app should now load properly on https://makesmyhome.com with proper loading indicators and error handling.
