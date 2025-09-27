<?php $__env->startSection('content'); ?>
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: <?php echo config('subscriptionmodule.name'); ?>

    </p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('subscriptionmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/SubscriptionModule/Resources/views/index.blade.php ENDPATH**/ ?>