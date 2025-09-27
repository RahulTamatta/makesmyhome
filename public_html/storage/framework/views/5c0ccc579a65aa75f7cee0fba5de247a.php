
<?php if(isset($variants)): ?>
    <?php ($variant_keys = $variants->pluck('variant_key')->unique()->toArray()); ?>
    <?php $__currentLoopData = $variant_keys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <th scope="row">
                <?php echo e(str_replace('-',' ',$item)); ?>

                <input name="variants[]" value="<?php echo e($item); ?>" class="hide-div">
            </th>
            <td>
                <input type="number"
                       value="<?php echo e($variants->where('price','>',0)->where('variant_key',$item)->first()->price??0); ?>"
                       class="theme-input-style" id="default-set-<?php echo e($key); ?>-update"
                       onkeyup="set_update_values('<?php echo e($key); ?>')">
            </td>
            <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <td>
                    <input type="number" name="<?php echo e($item); ?>_<?php echo e($zone->id); ?>_price"
                           value="<?php echo e($variants->where('zone_id',$zone->id)->where('variant_key',$item)->first()->price??0); ?>"
                           class="theme-input-style default-get-<?php echo e($key); ?>-update">
                </td>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <td>
                <a class="btn btn-sm btn--danger service-ajax-remove-variant"
                   data-route="<?php echo e(route('admin.service.ajax-delete-db-variant',[$item,$variants->first()->service_id])); ?>"
                   data-id="variation-update-table">
                    <span class="material-icons m-0">delete</span>
                </a>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<script>
    "use strict";
    document.addEventListener('DOMContentLoaded', function () {
        var elements = document.querySelectorAll('.service-ajax-remove-variant');
        elements.forEach(function (element) {
            element.addEventListener('click', function () {
                var route = this.getAttribute('data-route');
                var id = this.getAttribute('data-id');
                ajax_remove_variant(route, id);
            });
        });

        function set_update_values(key) {
            var updateElements = document.querySelectorAll('.default-get-' + key + '-update');
            var setValue = document.getElementById('default-set-' + key + '-update').value;
            updateElements.forEach(function (element) {
                element.value = setValue;
            });
        }
    });
</script>
<?php /**PATH /home/housecraft/public_html/Modules/ServiceManagement/Resources/views/admin/partials/_update-variant-data.blade.php ENDPATH**/ ?>