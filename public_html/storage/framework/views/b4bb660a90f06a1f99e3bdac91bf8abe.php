<select class="js-select theme-input-style w-100" name="sub_category_id">
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($category->id); ?>" <?php echo e(isset($subCategoryId) && $subCategoryId == $category->id ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>

<script>
    $(document).ready(function () {
        $('.js-select').select2();
    });
</script>
<?php /**PATH /home/housecraft/public_html/Modules/CategoryManagement/Resources/views/admin/partials/_childes-selector.blade.php ENDPATH**/ ?>