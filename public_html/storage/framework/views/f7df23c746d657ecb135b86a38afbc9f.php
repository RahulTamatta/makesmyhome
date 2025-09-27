<?php $__env->startSection('title',translate('add_new_campaign')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <style>
        .service_selector{
            display: none;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap mb-3">
                        <h2 class="page-title"><?php echo e(translate('add_new_campaign')); ?></h2>
                    </div>
                    <div class="card">
                        <div class="card-body p-30">
                            <form action="<?php echo e(route('admin.campaign.store')); ?>" method="POST" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="discount-type">
                                    <div class="row">
                                        <div class="col-lg-6 mb-30">
                                            <div class="form-floating form-floating__icon">
                                                <input type="text" class="form-control" name="campaign_name"
                                                       placeholder="<?php echo e(translate('campaign_name')); ?> *"
                                                       required="">
                                                <label><?php echo e(translate('campaign_name')); ?> *</label>
                                                <span class="material-icons">badge</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-30">
                                                <div class="d-flex flex-column align-items-center gap-3">
                                                    <p class="title-color mb-0"><?php echo e(translate('upload_cover_image')); ?></p>

                                                    <div>
                                                        <div class="upload-file">
                                                            <input type="file" class="upload-file__input" name="cover_image" accept=".<?php echo e(implode(',.', array_column(IMAGEEXTENSION, 'key'))); ?>, |image/*" required>
                                                            <div class="upload-file__img upload-file__img_banner">
                                                                <img src="<?php echo e(asset('public/assets/admin-module')); ?>/img/media/banner-upload-file.png"
                                                                     alt="<?php echo e(translate('campaign')); ?>">
                                                            </div>
                                                            <span class="upload-file__edit">
                                                                <span class="material-icons">edit</span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <p class="opacity-75 max-w220"><?php echo e(translate('Image format -')); ?> <?php echo e(implode(', ', array_column(IMAGEEXTENSION, 'key'))); ?> <?php echo e(translate("Image Size - maximum size 2 MB Image Ratio -
                                                        2:1")); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-30">
                                                <div class="d-flex flex-column align-items-center gap-3">

                                                    <p class="title-color mb-0"><?php echo e(translate('upload_thumbnail')); ?></p>
                                                    <div class="d-flex flex-column align-items-center">
                                                        <div class="upload-file">
                                                            <input type="file" class="upload-file__input" name="thumbnail" accept=".<?php echo e(implode(',.', array_column(IMAGEEXTENSION, 'key'))); ?>, |image/*" required>
                                                            <div class="upload-file__img">
                                                                <img src="<?php echo e(asset('public/assets/admin-module')); ?>/img/media/upload-file.png" alt="">
                                                            </div>
                                                            <span class="upload-file__edit">
                                                                <span class="material-icons">edit</span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <p class="opacity-75 max-w220"><?php echo e(translate('Image format -')); ?> <?php echo e(implode(', ', array_column(IMAGEEXTENSION, 'key'))); ?> <?php echo e(translate("Image Size - maximum size 2 MB Image Ratio -
                                                        1:1")); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3"><?php echo e(translate('discount_type')); ?></div>
                                    <div class="d-flex flex-wrap align-items-center gap-4 mb-30">
                                        <div class="custom-radio">
                                            <input type="radio" id="category" name="discount_type" value="category"
                                                   checked>
                                            <label for="category"><?php echo e(translate('category_wise')); ?></label>
                                        </div>
                                        <div class="custom-radio">
                                            <input type="radio" id="service" name="discount_type" value="service">
                                            <label for="service"><?php echo e(translate('service_wise')); ?></label>
                                        </div>
                                        <div class="custom-radio">
                                            <input type="radio" id="mixed" name="discount_type" value="mixed">
                                            <label for="mixed"><?php echo e(translate('mixed')); ?></label>
                                        </div>
                                    </div>

                                    <div class="mb-30">
                                        <div class="form-floating form-floating__icon">
                                            <input type="text" class="form-control" name="discount_title"
                                                   placeholder="<?php echo e(translate('discount_title')); ?> *"
                                                   required="">
                                            <label><?php echo e(translate('discount_title')); ?> *</label>
                                            <span class="material-icons">title</span>
                                        </div>
                                    </div>
                                    <div class="mb-30" id="category_selector">
                                        <select class="category-select theme-input-style w-100" name="category_ids[]"
                                                multiple="multiple" id="category_selector__select" required>
                                            <option value="all"><?php echo e(translate('Select All')); ?></option>
                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="mb-30 service_selector" id="service_selector">
                                        <select class="service-select theme-input-style w-100" name="service_ids[]"
                                                multiple="multiple" id="service_selector__select">
                                            <option value="all"><?php echo e(translate('Select All')); ?></option>
                                            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($service->id); ?>"><?php echo e($service->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="mb-30">
                                        <select class="zone-select theme-input-style w-100" name="zone_ids[]"
                                                multiple="multiple" id="zone_selector__select" required>
                                            <option value="0" disabled><?php echo e(translate('Select Zone')); ?></option>
                                            <option value="all"><?php echo e(translate('Select All')); ?></option>
                                            <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($zone->id); ?>"><?php echo e($zone->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="discount-amount-type">
                                    <div class="mb-3"><?php echo e(translate('discount_amount_type')); ?></div>
                                    <div class="d-flex flex-wrap align-items-center gap-4 mb-30">
                                        <div class="custom-radio">
                                            <input type="radio" id="percentage" name="discount_amount_type"
                                                   value="percent" checked>
                                            <label for="percentage"><?php echo e(translate('percentage')); ?></label>
                                        </div>
                                        <div class="custom-radio">
                                            <input type="radio" id="fixed_amount" name="discount_amount_type"
                                                   value="amount">
                                            <label for="fixed_amount"><?php echo e(translate('fixed_amount')); ?></label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="mb-30">
                                                <div class="form-floating form-floating__icon">
                                                    <input type="number" class="form-control" name="discount_amount"
                                                           placeholder="<?php echo e(translate('amount')); ?>" id="discount_amount"
                                                           min="0.01" max="100" value="0" step="any">
                                                    <label id="discount_amount__label"><?php echo e(translate('amount')); ?> (%)</label>
                                                    <span class="material-icons">price_change</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-30">
                                                <div class="form-floating">
                                                    <input type="date" class="form-control" name="start_date"
                                                           value="<?php echo e(now()->format('Y-m-d')); ?>">
                                                    <label><?php echo e(translate('Start_Date')); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-30">
                                                <div class="form-floating">
                                                    <input type="date" class="form-control" name="end_date"
                                                           value="<?php echo e(now()->addDays(2)->format('Y-m-d')); ?>">
                                                    <label><?php echo e(translate('End_Date')); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-30">
                                                <div class="form-floating form-floating__icon">
                                                    <input type="number" class="form-control" step="any"
                                                           name="min_purchase"
                                                           placeholder="<?php echo e(translate('min_purchase')); ?> (<?php echo e(currency_symbol()); ?>) *"
                                                           min="0" value="0">
                                                    <label><?php echo e(translate('min_purchase')); ?> (<?php echo e(currency_symbol()); ?>)
                                                        *</label>
                                                    <span class="material-icons">price_change</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4" id="max_discount_amount">
                                            <div class="mb-30">
                                                <div class="form-floating form-floating__icon">
                                                    <input type="number" class="form-control" step="any"
                                                           name="max_discount_amount"
                                                           placeholder="<?php echo e(translate('max_discount')); ?> (<?php echo e(currency_symbol()); ?>) *"
                                                           min="0" value="0">
                                                    <label><?php echo e(translate('max_discount')); ?> (<?php echo e(currency_symbol()); ?>)
                                                        *</label>
                                                    <span class="material-icons">price_change</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end gap-3">
                                    <button type="reset" class="btn btn--secondary"><?php echo e(translate('reset')); ?></button>
                                    <button type="submit" class="btn btn--primary"><?php echo e(translate('submit')); ?></button>
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
    <script>
        "use Strict"

        $('#category_selector__select').on('change', function() {
            var selectedValues = $(this).val();
            if (selectedValues !== null && selectedValues.includes('all')) {
                $(this).find('option').not(':disabled').prop('selected', 'selected');
                $(this).find('option[value="all"]').prop('selected', false);
            }
        });

        $('#service_selector__select').on('change', function() {
            var selectedValues = $(this).val();
            if (selectedValues !== null && selectedValues.includes('all')) {
                $(this).find('option').not(':disabled').prop('selected', 'selected');
                $(this).find('option[value="all"]').prop('selected', false);
            }
        });

        $('#zone_selector__select').on('change', function() {
            var selectedValues = $(this).val();
            if (selectedValues !== null && selectedValues.includes('all')) {
                $(this).find('option').not(':disabled').prop('selected', 'selected');
                $(this).find('option[value="all"]').prop('selected', false);
            }
        });

        $('#category').on('click', function () {
            $('#category_selector').show();
            $('#service_selector').hide();

            $('#category_selector__select').prop('required',true);
            $('#service_selector__select').prop('required',false);
        });

        $('#service').on('click', function () {
            $('#category_selector').hide();
            $('#service_selector').show();

            $('#service_selector__select').prop('required',true);
            $('#category_selector__select').prop('required',false);
        });

        $('#mixed').on('click', function () {
            $('#category_selector').show();
            $('#service_selector').show();

            $('#service_selector__select').prop('required',true);
            $('#category_selector__select').prop('required',true);
        });

        $('#percentage').on('click', function () {
            $('#max_discount_amount').show();

            //Attribute Update
            $('#discount_amount').attr({"max" : 100});
            $('#discount_amount__label').html('<?php echo e(translate('amount')); ?> (%)');
        });

        $('#fixed_amount').on('click', function () {
            $('#max_discount_amount').hide();

            //Attribute Update
            $('#discount_amount').removeAttr('max');
            $('#discount_amount__label').html('<?php echo e(translate('amount')); ?> (<?php echo e(currency_symbol()); ?>)');
        });

        //Select 2
        $(".category-select").select2({
            placeholder: "<?php echo e(translate('Select Category')); ?>",
        });
        $(".service-select").select2({
            placeholder: "<?php echo e(translate('Select Service')); ?>",
        });
        $(".zone-select").select2({
            placeholder: "<?php echo e(translate('Select Zone')); ?>",
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/PromotionManagement/Resources/views/admin/campaigns/create.blade.php ENDPATH**/ ?>