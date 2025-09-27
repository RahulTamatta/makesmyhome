<?php $__env->startSection('title',translate('privacy_policy')); ?>

<?php $__env->startSection('content'); ?>
    <?php ($image = getDataSettingsImageFullPath(key: 'privacy_policy_image', settingType: 'pages_setup_image', path: 'page-setup/', defaultPath: asset('public/assets/admin-module/img/page-default.png'))); ?>
    <div class="container pt-3">
        <section class="page-header bg__img" data-img="<?php echo e($image); ?>">
            <h3 class="title"><?php echo e(translate('privacy_policy')); ?></h3>
        </section>
    </div>
    <section class="privacy-section py-5">
        <div class="container">
            <?php echo bs_data_text($dataSettings,'privacy_policy', 1); ?>

        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.landing.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/resources/views/privacy-policy.blade.php ENDPATH**/ ?>