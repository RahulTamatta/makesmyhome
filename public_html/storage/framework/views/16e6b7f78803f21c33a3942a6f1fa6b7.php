
<?php if(session()->has('variations')): ?>
    <?php $__currentLoopData = session('variations'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <th scope="row">
                <?php echo e($item['variant']); ?>

                <input name="variants[]" value="<?php echo e(str_replace(' ','-',$item['variant'])); ?>" class="hide-div">
            </th>
            <td>
                <input type="number" value="<?php echo e($item['price']); ?>" class="theme-input-style" id="default-set-<?php echo e($key); ?>"
                       onkeyup="set_values('<?php echo e($key); ?>')" min="0.00001" step="any" required>
            </td>
            <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <td>
                    <input type="number" name="<?php echo e($item['variant_key']); ?>_<?php echo e($zone->id); ?>_price" value="<?php echo e($item['price']); ?>"
                           class="theme-input-style default-get-<?php echo e($key); ?>" min="0.00001" step="any" required>
                </td>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <td>
                <a class="btn btn--danger service-ajax-remove-variant"
                   data-id="variation-table"
                   data-route="<?php echo e(route('admin.service.ajax-remove-variant',[$item['variant_key']])); ?>">
                    <span class="material-icons m-0">delete</span>
                </a>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<script>
    "use strict";

    // Equivalent JavaScript code
    document.querySelectorAll('.service-ajax-remove-variant').forEach(function(element) {
        element.addEventListener('click', function() {
            var route = this.getAttribute('data-route');
            var id = this.getAttribute('data-id');
            ajax_remove_variant(route, id);
        });
    });

    function set_values(key) {
        document.querySelectorAll('.default-get-' + key).forEach(function(element) {
            element.value = document.getElementById('default-set-' + key).value;
        });
    }

</script>
<?php /**PATH /home/housecraft/public_html/Modules/ServiceManagement/Resources/views/admin/partials/_variant-data.blade.php ENDPATH**/ ?>