<tr>
    <th scope="col"><?php echo e(translate('variations')); ?></th>
    <th scope="col"><?php echo e(translate('default_price')); ?></th>
    <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <th scope="col"><?php echo e($zone->name); ?></th>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <th scope="col"><?php echo e(translate('action')); ?></th>
</tr>
<?php /**PATH /home/housecraft/public_html/Modules/ServiceManagement/Resources/views/admin/partials/_category-wise-zone.blade.php ENDPATH**/ ?>