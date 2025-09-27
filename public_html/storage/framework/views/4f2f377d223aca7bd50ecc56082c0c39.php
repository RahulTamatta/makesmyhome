<?php $__env->startSection('title',translate('category_update')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/select2/select2.min.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/select.dataTables.min.css"/>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap mb-3">
                        <h2 class="page-title"><?php echo e(translate('category_update')); ?></h2>
                    </div>

                    <div class="card category-setup mb-30">
                        <div class="card-body p-30">
                            <form action="<?php echo e(route('admin.category.update',[$category->id])); ?>" method="post"
                                  enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('put'); ?>
                                <?php ($language= Modules\BusinessSettingsModule\Entities\BusinessSettings::where('key_name','system_language')->first()); ?>
                                <?php ($default_lang = str_replace('_', '-', app()->getLocale())); ?>
                                <?php if($language): ?>
                                    <ul class="nav nav--tabs border-color-primary mb-4">
                                        <li class="nav-item">
                                            <a class="nav-link lang_link active"
                                               href="#"
                                               id="default-link"><?php echo e(translate('default')); ?></a>
                                        </li>
                                        <?php $__currentLoopData = $language?->live_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="nav-item">
                                                <a class="nav-link lang_link"
                                                   href="#"
                                                   id="<?php echo e($lang['code']); ?>-link"><?php echo e(get_language_name($lang['code'])); ?></a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php endif; ?>
                                <div class="row">
                                    <div class="col-lg-8 mb-5 mb-lg-0">
                                        <div class="d-flex flex-column">
                                            <?php if($language): ?>
                                                <div class="form-floating form-floating__icon mb-30 lang-form" id="default-form">
                                                    <input type="text" name="name[]" class="form-control"
                                                           placeholder="<?php echo e(translate('category_name')); ?>"
                                                           value="<?php echo e($category?->getRawOriginal('name')); ?>" required>
                                                    <label><?php echo e(translate('category_name')); ?> (<?php echo e(translate('default')); ?>

                                                        )</label>
                                                    <span class="material-icons">subtitles</span>
                                                </div>
                                                <input type="hidden" name="lang[]" value="default">
                                                <?php $__currentLoopData = $language?->live_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                                        if (count($category['translations'])) {
                                                            $translate = [];
                                                            foreach ($category['translations'] as $t) {
                                                                if ($t->locale == $lang['code'] && $t->key == "name") {
                                                                    $translate[$lang['code']]['name'] = $t->value;
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    <div class="form-floating form-floating__icon mb-30 d-none lang-form"
                                                         id="<?php echo e($lang['code']); ?>-form">
                                                        <input type="text" name="name[]" class="form-control"
                                                               placeholder="<?php echo e(translate('category_name')); ?>"
                                                               value="<?php echo e($translate[$lang['code']]['name']??''); ?>">
                                                        <label><?php echo e(translate('category_name')); ?>

                                                            (<?php echo e(strtoupper($lang['code'])); ?>)</label>
                                                        <span class="material-icons">subtitles</span>
                                                    </div>
                                                    <input type="hidden" name="lang[]" value="<?php echo e($lang['code']); ?>">
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <div class="form-floating form-floating__icon mb-30">
                                                    <input type="text" name="name[]" class="form-control"
                                                           placeholder="<?php echo e(translate('category_name')); ?>"
                                                           value="<?php echo e($category['name']); ?>" required>
                                                    <label><?php echo e(translate('category_name')); ?></label>
                                                    <span class="material-icons">subtitles</span>
                                                </div>
                                                <input type="hidden" name="lang[]" value="default">
                                            <?php endif; ?>


                                            <select class="zone-select theme-input-style w-100" name="zone_ids[]" multiple="multiple" id="zone_selector__select">
                                                <option value="all"><?php echo e(translate('Select All')); ?></option>
                                                <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option
                                                        value="<?php echo e($zone['id']); ?>" <?php echo e(in_array($zone->id,$category->zones->pluck('id')->toArray())?'selected':''); ?>><?php echo e($zone->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="d-flex  gap-3 gap-xl-5">
                                            <p class="opacity-75 max-w220"><?php echo e(translate('image_format_-_jpg,_png,_jpeg,_gif_image
                                                size_-_
                                                maximum_size_2_MB_Image_Ratio_-_1:1')); ?></p>
                                            <div>
                                                <div class="upload-file">
                                                    <input type="file" class="upload-file__input" name="image" accept=".<?php echo e(implode(',.', array_column(IMAGEEXTENSION, 'key'))); ?>, |image/*">
                                                    <div class="upload-file__img">
                                                        <img src="<?php echo e($category->image_full_path); ?>" alt="<?php echo e(translate('category image')); ?>">
                                                    </div>
                                                    <span class="upload-file__edit">
                                                        <span class="material-icons">edit</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end gap-20 mt-30">
                                            <button class="btn btn--secondary"
                                                    type="reset"><?php echo e(translate('reset')); ?></button>
                                            <button class="btn btn--primary" type="submit"><?php echo e(translate('update')); ?>

                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('public/assets/admin-module/plugins/select2/select2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/category-module/js/category/edit.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/admin-module/plugins/dataTables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/admin-module/plugins/dataTables/dataTables.select.min.js')); ?>"></script>

    <script>
        "use strict"

        $('#zone_selector__select').on('change', function() {
            var selectedValues = $(this).val();
            if (selectedValues !== null && selectedValues.includes('all')) {
                $(this).find('option').not(':disabled').prop('selected', 'selected');
                $(this).find('option[value="all"]').prop('selected', false);
            }
        });

        $(document).ready(function () {
            let originalSelection = $('#zone_selector__select').val();

            $('button[type="reset"]').on('click', function (e) {
                $('#zone_selector__select').val(originalSelection).trigger('change');
            });
        });

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/CategoryManagement/Resources/views/admin/edit.blade.php ENDPATH**/ ?>