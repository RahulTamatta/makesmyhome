# Add any project specific Keep Rules and ProGuard rules here.
# By default, the flags in this file are appended to flags specified in:
#   /Users/MyWork/Library/Android/sdk/tools/proguard/proguard-android.txt
#   /Users/MyWork/Library/Android/sdk/tools/proguard/proguard-rules.pro

# Ignore Kotlin metadata warnings
-dontwarn kotlinx.metadata.**

# Keep all classes that are referenced from native code
-keepclasseswithmembernames class * {
    native <methods>;
}

# Keep all Flutter related classes
-keep class io.flutter.app.** { *; }
-keep class io.flutter.plugin.**  { *; }
-keep class io.flutter.util.**  { *; }
-keep class io.flutter.view.**  { *; }
-keep class io.flutter.**  { *; }
-keep class io.flutter.plugins.**  { *; }

# Keep the Application class
-keep public class * extends android.app.Application
-keep public class * extends android.app.Service
-keep public class * extends android.content.BroadcastReceiver
-keep public class * extends android.content.ContentProvider
-keep public class * extends android.app.backup.BackupAgentHelper
-keep public class * extends android.preference.Preference
-keep public class com.google.android.gms.ads.** { public *; }

# Ignore missing Google Play Core classes (deferred components not used)
-dontwarn com.google.android.play.core.**
-dontnote com.google.android.play.core.**
