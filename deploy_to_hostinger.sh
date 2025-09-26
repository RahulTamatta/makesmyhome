#!/bin/bash

echo "🚀 Deploying MakesMyHome to Hostinger..."

# Clean and build
echo "📦 Building Flutter web app..."
flutter clean
flutter pub get
flutter build web --release --base-href "/"

# Check if build was successful
if [ ! -d "build/web" ]; then
    echo "❌ Build failed! build/web directory not found."
    exit 1
fi

echo "✅ Build completed successfully!"

# Show build contents
echo "📁 Build contents:"
ls -la build/web/

echo ""
echo "📋 Files to upload to Hostinger public_html/:"
echo "   • index.html ($(stat -f%z build/web/index.html 2>/dev/null || echo "N/A") bytes)"
echo "   • main.dart.js ($(stat -f%z build/web/main.dart.js 2>/dev/null || echo "N/A") bytes) - CRITICAL"
echo "   • flutter_bootstrap.js ($(stat -f%z build/web/flutter_bootstrap.js 2>/dev/null || echo "N/A") bytes)"
echo "   • flutter_service_worker.js ($(stat -f%z build/web/flutter_service_worker.js 2>/dev/null || echo "N/A") bytes)"
echo "   • manifest.json"
echo "   • favicon.png"
echo "   • .htaccess"
echo "   • assets/ folder (with all contents)"
echo "   • icons/ folder (with all contents)"
if [ -d "build/web/canvaskit" ]; then
    echo "   • canvaskit/ folder"
fi

echo ""
echo "🔧 Next steps:"
echo "1. Upload ALL files from build/web/ to your Hostinger public_html/ folder"
echo "2. Ensure main.dart.js (the largest file) uploads completely"
echo "3. Set file permissions: 644 for files, 755 for folders"
echo "4. Clear browser cache and visit https://makesmyhome.com"

echo ""
echo "🐛 If still white screen:"
echo "1. Check browser console (F12) for errors"
echo "2. Verify main.dart.js loads: https://makesmyhome.com/main.dart.js"
echo "3. Upload debug.html and visit: https://makesmyhome.com/debug.html"

echo ""
echo "✅ Deployment package ready in build/web/"
