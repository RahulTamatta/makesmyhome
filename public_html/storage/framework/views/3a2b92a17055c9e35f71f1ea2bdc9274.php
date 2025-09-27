<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>

    <?php
    $favIcon = getBusinessSettingsImageFullPath(key: 'business_favicon', settingType: 'business_information', path: 'business/',  defaultPath : 'public/assets/placeholder.png')
    ?>
    <link rel="shortcut icon" href="<?php echo e($favIcon); ?>"/>

    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap"
        rel="stylesheet"/>

    <link href="<?php echo e(asset('public/assets/provider-module')); ?>/css/material-icons.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/provider-module')); ?>/css/bootstrap.min.css"/>
    <link rel="stylesheet"
          href="<?php echo e(asset('public/assets/provider-module')); ?>/plugins/perfect-scrollbar/perfect-scrollbar.min.css"/>

    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module/plugins/intl-tel-input/css/intlTelInput.min.css')); ?>">
    
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/provider-module')); ?>/css/style.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/provider-module')); ?>/css/toastr.css">
    <?php echo $__env->yieldPushContent('css_or_js'); ?>
</head>

<body>

<div class="preloader"></div>

<?php
$logo = getBusinessSettingsImageFullPath(key: 'business_logo', settingType: 'business_information', path: 'business/',  defaultPath : 'public/assets/placeholder.png');
?>

<?php echo $__env->yieldContent('content'); ?>

<script src="<?php echo e(asset('public/assets/provider-module')); ?>/js/jquery-3.6.0.min.js"></script>
<script src="<?php echo e(asset('public/assets/provider-module')); ?>/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo e(asset('public/assets/provider-module')); ?>/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?php echo e(asset('public/assets/provider-module')); ?>/js/main.js"></script>

<script src="<?php echo e(asset('public/assets/provider-module')); ?>/js/sweet_alert.js"></script>
<script src="<?php echo e(asset('public/assets/provider-module')); ?>/js/toastr.js"></script>
<?php echo Toastr::message(); ?>


<?php if($errors->any()): ?>
    <script>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        toastr.error('<?php echo e($error); ?>', Error, {
            CloseButton: true,
            ProgressBar: true
        });
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </script>
<?php endif; ?>
<script src="<?php echo e(asset('public/assets/admin-module/plugins/intl-tel-input/js/intlTelInput.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/admin-module/js/country-picker-init.js')); ?>"></script>
<?php echo $__env->yieldPushContent('script'); ?>
</body>
</html>
<?php /**PATH /home/housecraft/public_html/Modules/Auth/Resources/views/layouts/master.blade.php ENDPATH**/ ?>