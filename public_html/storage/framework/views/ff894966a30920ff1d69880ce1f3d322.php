<?php $__env->startSection('title',bs_data($settings,'business_name', 1)); ?>

<?php $__env->startSection('content'); ?>

    <?php ($image = getDataSettingsImageFullPath(key: 'about_us_image', settingType: 'pages_setup_image', path: 'page-setup/', defaultPath: asset('public/assets/admin-module/img/page-default.png'))); ?>
    <div class="container pt-3">
        <section class="page-header bg__img" data-img="<?php echo e($image); ?>">
            <h3 class="title"><?php echo e(translate('about_us')); ?></h3>
        </section>
    </div>
    <section class="privacy-section py-5">
        <div class="container">
            <?php echo bs_data_text($dataSettings,'about_us', 1); ?>

        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.landing.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/resources/views/about-us.blade.php ENDPATH**/ ?>