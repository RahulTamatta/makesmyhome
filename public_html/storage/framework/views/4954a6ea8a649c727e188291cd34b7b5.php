<?php $__env->startSection('title',translate('update_discount')); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap mb-3 d-flex justify-content-between">
                        <h2 class="page-title"><?php echo e(translate('update_discount')); ?></h2>

                        <div><i class="material-icons" data-bs-toggle="modal" data-bs-target="#alertModal">info</i></div>
                    </div>
                    <div class="card mb-30">
                        <div class="card-body p-30">
                            <form action="<?php echo e(route('admin.discount.update',[$discount->id])); ?>" method="POST">
                                <?php echo method_field('PUT'); ?>
                                <?php echo csrf_field(); ?>
                                <div class="discount-type">
                                    <div class="mb-3"><?php echo e(translate('discount_type')); ?></div>
                                    <div class="d-flex flex-wrap align-items-center gap-4 mb-30">
                                        <div class="custom-radio">
                                            <input type="radio" id="category" name="discount_type"
                                                   value="category" <?php echo e($discount->discount_type=='category'?'checked':''); ?>>
                                            <label for="category"><?php echo e(translate('category_wise')); ?></label>
                                        </div>
                                        <div class="custom-radio">
                                            <input type="radio" id="service" name="discount_type" value="service"
                                                <?php echo e($discount->discount_type=='service'?'checked':''); ?>>
                                            <label for="service"><?php echo e(translate('service_wise')); ?></label>
                                        </div>
                                        <div class="custom-radio">
                                            <input type="radio" id="mixed" name="discount_type"
                                                   value="mixed" <?php echo e($discount->discount_type=='mixed'?'checked':''); ?>>
                                            <label for="mixed"><?php echo e(translate('mixed')); ?></label>
                                        </div>
                                    </div>

                                    <div class="mb-30">
                                        <div class="form-floating form-floating__icon">
                                            <input type="text" class="form-control" name="discount_title"
                                                   placeholder="<?php echo e(translate('discount_title')); ?> *" value="<?php echo e($discount->discount_title); ?>"
                                                   required="" maxlength="191">
                                            <label><?php echo e(translate('discount_title')); ?> *</label>
                                            <span class="material-icons">title</span>
                                        </div>
                                    </div>
                                    <div class="mb-30" id="category_selector"
                                         style="display: <?php echo e(($discount->discount_type=='category' || $discount->discount_type=='mixed')?'block':'none'); ?>">
                                        <select class="category-select theme-input-style w-100" name="category_ids[]"
                                                multiple="multiple" id="category_selector__select" <?php echo e(($discount->discount_type=='category' || $discount->discount_type=='mixed')?'required':''); ?>>
                                            <option value="all"><?php echo e(translate('Select All')); ?></option>
                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($category->id); ?>" <?php echo e(in_array($category->id,$discount->category_types->pluck('type_wise_id')->toArray())?'selected':''); ?>>
                                                    <?php echo e($category->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="mb-30" id="service_selector"
                                         style="display: <?php echo e(($discount->discount_type=='service' || $discount->discount_type=='mixed')?'block':'none'); ?>">
                                        <select class="service-select theme-input-style w-100" name="service_ids[]"
                                                multiple="multiple" id="service_selector__select">
                                            <option value="all"><?php echo e(translate('Select All')); ?></option>
                                            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($service->id); ?>" <?php echo e(in_array($service->id,$discount->service_types->pluck('type_wise_id')->toArray())?'selected':''); ?>>
                                                    <?php echo e($service->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="mb-30">
                                        <select class="zone-select theme-input-style w-100" name="zone_ids[]"
                                                multiple="multiple" id="zone_selector__select" required>
                                            <option value="all"><?php echo e(translate('Select All')); ?></option>
                                            <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($zone->id); ?>" <?php echo e(in_array($zone->id,$discount->zone_types->pluck('type_wise_id')->toArray())?'selected':''); ?>>
                                                    <?php echo e($zone->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="discount-amount-type">
                                    <div class="mb-3 text-capitalize"><?php echo e(translate('discount_amount_type')); ?> *</div>
                                    <div class="d-flex align-items-center gap-4 mb-30">
                                        <div class="custom-radio">
                                            <input type="radio" id="percentage" name="discount_amount_type" value="percent" <?php echo e($discount->discount_amount_type=='percent'?'checked':''); ?>>
                                            <label for="percentage"><?php echo e(translate('percentage')); ?></label>
                                        </div>
                                        <div class="custom-radio">
                                            <input type="radio" id="fixed_amount" name="discount_amount_type" value="amount" <?php echo e($discount->discount_amount_type=='amount'?'checked':''); ?>>
                                            <label for="fixed_amount"><?php echo e(translate('fixed_amount')); ?></label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="mb-30">
                                                <div class="form-floating form-floating__icon">
                                                    <input type="number" class="form-control" name="discount_amount" id="discount_amount"
                                                           value="<?php echo e($discount->discount_amount); ?>"
                                                           placeholder="<?php echo e(translate('amount')); ?> *" step="any"
                                                           min="0.01" <?php echo e($discount->discount_amount_type == 'percent'? 'max=100' : ''); ?>>
                                                    <label id="discount_amount__label"><?php echo e(translate('amount')); ?> (<?php echo e($discount->discount_amount_type == 'amount' ? currency_symbol() : '%'); ?>)</label>
                                                    <span class="material-icons">price_change</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-30">
                                                <div class="form-floating">
                                                    <input type="date" class="form-control" name="start_date" value="<?php echo e($discount->start_date); ?>">
                                                    <label><?php echo e(translate('start_date')); ?> *</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-30">
                                                <div class="form-floating">
                                                    <input type="date" class="form-control" name="end_date" value="<?php echo e($discount->end_date); ?>">
                                                    <label><?php echo e(translate('end_date')); ?> *</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-30">
                                                <div class="form-floating form-floating__icon">
                                                    <input type="number" class="form-control" step="any"
                                                           name="min_purchase"
                                                           placeholder="<?php echo e(translate('min_purchase')); ?> (<?php echo e(currency_symbol()); ?>) *"
                                                           value="<?php echo e($discount->min_purchase); ?>"
                                                           min="0">
                                                    <label><?php echo e(translate('min_purchase_amount')); ?> (<?php echo e(currency_symbol()); ?>) *</label>
                                                    <span class="material-icons">price_change</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4" id="max_discount_amount"
                                             style="display: <?php echo e($discount->discount_amount_type=='amount'?'none':'block'); ?>">
                                            <div class="mb-30">
                                                <div class="form-floating form-floating__icon">
                                                    <input type="number" class="form-control" step="any"
                                                           name="max_discount_amount"
                                                           placeholder="<?php echo e(translate('max_discount')); ?> (<?php echo e(currency_symbol()); ?>) *"
                                                           value="<?php echo e($discount->max_discount_amount); ?>"
                                                           min="0">
                                                    <label><?php echo e(translate('max_discount')); ?> (<?php echo e(currency_symbol()); ?>) *</label>
                                                    <span class="material-icons">price_change</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn--primary"><?php echo e(translate('update')); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header pb-0 border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-sm-5 px-sm-5">
                    <div class="d-flex flex-column align-items-center gap-2 text-center">
                        <h3><?php echo e(translate('Alert')); ?>!</h3>
                        <p class="fw-medium">
                            <?php echo e(translate('This request is with customized instructions. Please read the customer description and instructions thoroughly and place your pricing according to this')); ?>

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        "use Strict";


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

            $('#discount_amount').attr({"max" : 100});
            $('#discount_amount__label').html('<?php echo e(translate('amount')); ?> (%)');
        });

        $('#fixed_amount').on('click', function () {
            $('#max_discount_amount').hide();

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

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/PromotionManagement/Resources/views/admin/discounts/edit.blade.php ENDPATH**/ ?>