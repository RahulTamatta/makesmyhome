<?php $__env->startSection('title',translate('promotional_banner_update')); ?>

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
                        <h2 class="page-title"><?php echo e(translate('promotional_banner_update')); ?></h2>
                    </div>
                    <div class="card mb-30">
                        <div class="card-body p-30">
                            <form action="<?php echo e(route('admin.banner.update',[$banner->id])); ?>" method="POST"
                                  enctype="multipart/form-data">
                                <?php echo method_field('PUT'); ?>
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-lg-6 mb-4 mb-lg-0">
                                        <div class="form-floating form-floating__icon mb-30">
                                            <input type="text" class="form-control" name="banner_title"
                                                   value="<?php echo e($banner->banner_title); ?>"
                                                   placeholder="<?php echo e(translate('title')); ?> *" maxlength="190"
                                                   required="">
                                            <label><?php echo e(translate('title')); ?> *</label>
                                            <span class="material-icons">title</span>
                                        </div>

                                        <div class="mb-3"><?php echo e(translate('resource_type')); ?></div>
                                        <div class="d-flex flex-wrap align-items-center gap-4 mb-30">
                                            <div class="custom-radio">
                                                <input type="radio" id="category" name="resource_type" value="category"
                                                    <?php echo e($banner->resource_type=='category'?'checked':''); ?>>
                                                <label for="category"><?php echo e(translate('category_wise')); ?></label>
                                            </div>
                                            <div class="custom-radio">
                                                <input type="radio" id="service" name="resource_type" value="service"
                                                    <?php echo e($banner->resource_type=='service'?'checked':''); ?>>
                                                <label for="service"><?php echo e(translate('service_wise')); ?></label>
                                            </div>
                                            <div class="custom-radio">
                                                <input type="radio" id="redirect_link" name="resource_type"
                                                       value="link" <?php echo e($banner->resource_type=='link'?'checked':''); ?>>
                                                <label for="redirect_link"><?php echo e(translate('redirect_link')); ?></label>
                                            </div>
                                        </div>

                                        <div class="mb-30" id="category_selector"
                                             style="display: <?php echo e($banner->resource_type=='category'?'block':'none'); ?>">
                                            <select class="js-select theme-input-style w-100" name="category_id">
                                                <option value="" selected disabled>---<?php echo e(translate('Select_Category')); ?>

                                                    ---
                                                </option>
                                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option
                                                        value="<?php echo e($category->id); ?>" <?php echo e($category->id==$banner->resource_id?'selected':''); ?>>
                                                        <?php echo e($category->name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="mb-30" id="service_selector"
                                             style="display: <?php echo e($banner->resource_type=='service'?'block':'none'); ?>">
                                            <select class="js-select theme-input-style w-100" name="service_id">
                                                <option value="" selected disabled>---<?php echo e(translate('Select_Service')); ?>

                                                    ---
                                                </option>
                                                <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option
                                                        value="<?php echo e($service->id); ?>" <?php echo e($service->id==$banner->resource_id?'selected':''); ?>>
                                                        <?php echo e($service->name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="form-floating form-floating__icon mb-30"
                                             style="display: <?php echo e($banner->resource_type=='link'?'block':'none'); ?>"
                                             id="link_selector">
                                            <input type="url" class="form-control" name="redirect_link"
                                                   placeholder="<?php echo e(translate('redirect_link')); ?>"
                                                   value="<?php echo e($banner->redirect_link); ?>">
                                            <label><?php echo e(translate('redirect_link')); ?></label>
                                            <span class="material-icons">link</span>
                                        </div>

                                    </div>
                                    <div class="col-lg-6">
                                        <div class="d-flex flex-column align-items-center gap-3">
                                            <p class="title-color mb-0"><?php echo e(translate('upload_cover_image')); ?></p>
                                            <div>
                                                <div class="upload-file">
                                                    <input type="file" class="upload-file__input" name="banner_image">
                                                    <div class="upload-file__img upload-file__img_banner">
                                                        <img src="<?php echo e($banner->banner_image_full_path); ?>"
                                                            alt="<?php echo e(translate('banner')); ?>">
                                                    </div>
                                                    <span class="upload-file__edit">
                                                        <span class="material-icons">edit</span>
                                                    </span>
                                                </div>
                                            </div>

                                            <p class="opacity-75 max-w220 mx-auto"><?php echo e(translate('Image format - jpg,
                                                png, jpeg, gif Image Size - maximum size 2 MB Image
                                                Ratio - 2:1')); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end gap-20 mt-30">
                                            <button class="btn btn--secondary"
                                                    type="reset"><?php echo e(translate('reset')); ?></button>
                                            <button class="btn btn--primary"
                                                    type="submit"><?php echo e(translate('update')); ?></button>
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
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/select2/select2.min.js"></script>
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/jquery.dataTables.min.js"></script>
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/dataTables.select.min.js"></script>
    <script>
        "use Strict";

        $('#category').on('click', function () {
            $('#category_selector').show();
            $('#service_selector').hide();
            $('#link_selector').hide();
        });

        $('#service').on('click', function () {
            $('#category_selector').hide();
            $('#service_selector').show();
            $('#link_selector').hide();
        });

        $('#redirect_link').on('click', function () {
            $('#category_selector').hide();
            $('#service_selector').hide();
            $('#link_selector').show();
        });

        $(document).ready(function () {
            $('.js-select').select2();
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/PromotionManagement/Resources/views/admin/promotional-banners/edit.blade.php ENDPATH**/ ?>