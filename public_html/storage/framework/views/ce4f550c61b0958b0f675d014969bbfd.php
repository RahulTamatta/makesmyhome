<?php $__env->startSection('title',translate('add_new_coupon')); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap mb-3">
                        <h2 class="page-title"><?php echo e(translate('add_new_coupon')); ?></h2>
                    </div>
                    <div class="card">
                        <div class="card-body p-30">
                            <form action="<?php echo e(route('admin.coupon.store')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php ($language= Modules\BusinessSettingsModule\Entities\BusinessSettings::where('key_name','system_language')->first()); ?>
                                <?php ($default_lang = str_replace('_', '-', app()->getLocale())); ?>
                                <?php if($language): ?>
                                    <ul class="nav nav-tabs mb-4">
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
                                <div class="discount-type">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-30">
                                                <select class="js-select theme-input-style w-100" name="coupon_type"
                                                        id="coupon-type" required>
                                                    <option selected
                                                            disabled><?php echo e(translate('select_coupon_type')); ?></option>
                                                    <?php $__currentLoopData = COUPON_TYPES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$coupon_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($index); ?>"><?php echo e($coupon_type); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-30">
                                                <div class="form-floating form-floating__icon">
                                                    <input type="text" class="form-control" name="coupon_code"
                                                           placeholder="<?php echo e(translate('coupon_code')); ?>" required>
                                                    <label><?php echo e(translate('coupon_code')); ?></label>
                                                    <span class="material-icons">subtitles</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 d-none" id="customer-select__div">
                                            <div class="mb-30">
                                                <select class="js-select theme-input-style w-100" id="customer-select"
                                                        name="customer_user_ids[]" multiple>
                                                    <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option
                                                            value="<?php echo e($customer->id); ?>"><?php echo e($customer->first_name .' '. $customer->last_name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
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
                                    <?php if($language): ?>
                                        <div class="form-floating form-floating__icon mb-30 lang-form" id="default-form">
                                            <input type="text" name="discount_title[]" class="form-control"
                                                   placeholder="<?php echo e(translate('discount_title')); ?>" required>
                                            <label><?php echo e(translate('discount_title')); ?> (<?php echo e(translate('default')); ?>)</label>
                                            <span class="material-icons">title</span>
                                        </div>
                                        <input type="hidden" name="lang[]" value="default">
                                        <?php $__currentLoopData = $language?->live_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="form-floating form-floating__icon mb-30 d-none lang-form" id="<?php echo e($lang['code']); ?>-form">
                                                <input type="text" name="discount_title[]" class="form-control"
                                                       placeholder="<?php echo e(translate('discount_title')); ?>">
                                                <label><?php echo e(translate('discount_title')); ?> (<?php echo e(strtoupper($lang['code'])); ?>)</label>
                                                <span class="material-icons">title</span>
                                            </div>
                                            <input type="hidden" name="lang[]" value="<?php echo e($lang['code']); ?>">
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <div class="form-floating form-floating__icon mb-30">
                                            <input type="text" name="discount_title[]" class="form-control"
                                                   placeholder="<?php echo e(translate('discount_title')); ?>" required>
                                            <label><?php echo e(translate('discount_title')); ?></label>
                                            <span class="material-icons">title</span>
                                        </div>
                                        <input type="hidden" name="lang[]" value="default">
                                    <?php endif; ?>
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
                                                           min="0.01" max="100" step="any" value="0">
                                                    <label id="discount_amount__label"><?php echo e(translate('amount')); ?>

                                                        (%)</label>
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
                                                           placeholder="<?php echo e(translate('min_purchase')); ?> (<?php echo e(currency_symbol()); ?>)"
                                                           min="0" value="0">
                                                    <label><?php echo e(translate('min_purchase')); ?> (<?php echo e(currency_symbol()); ?>)</label>
                                                    <span class="material-icons">price_change</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4" id="max_discount_amount">
                                            <div class="mb-30">
                                                <div class="form-floating form-floating__icon">
                                                    <input type="number" class="form-control" step="any"
                                                           name="max_discount_amount"
                                                           placeholder="<?php echo e(translate('max_discount')); ?> (<?php echo e(currency_symbol()); ?>)"
                                                           min="0" value="0">
                                                    <label><?php echo e(translate('max_discount')); ?> (<?php echo e(currency_symbol()); ?>)</label>
                                                    <span class="material-icons">price_change</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4" id="limit_per_user__div">
                                            <div class="mb-30">
                                                <div class="form-floating form-floating__icon">
                                                    <input type="number" class="form-control" name="limit_per_user"
                                                           id="limit_per_user" placeholder="1" required>
                                                    <label><?php echo e(translate('Limit For Same User')); ?></label>
                                                    <span class="material-icons">person</span>
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

            $('#category_selector__select').prop('required', true);
            $('#service_selector__select').prop('required', false);
        });

        $('#service').on('click', function () {
            $('#category_selector').hide();
            $('#service_selector').show();

            $('#service_selector__select').prop('required', true);
            $('#category_selector__select').prop('required', false);
        });

        $('#mixed').on('click', function () {
            $('#category_selector').show();
            $('#service_selector').show();

            $('#service_selector__select').prop('required', true);
            $('#category_selector__select').prop('required', true);
        });

        $('#percentage').on('click', function () {
            $('#max_discount_amount').show();

            //Attribute Update
            $('#discount_amount').attr({"max": 100});
            $('#discount_amount__label').html('<?php echo e(translate('amount')); ?> (%)');
        });

        $('#fixed_amount').on('click', function () {
            $('#max_discount_amount').hide();

            //Attribute Update
            $('#discount_amount').removeAttr('max');
            $('#discount_amount__label').html('<?php echo e(translate('amount')); ?> (<?php echo e(currency_symbol()); ?>)');

        });

        $('#coupon-type').change(function () {
            if ($(this).val() === 'customer_wise') {
                $("#customer-select__div").removeClass('d-none');
                $("#customer-select").prop('required', true);

            } else {
                $("#customer-select__div").addClass('d-none');
                $("#customer-select").prop('required', false);
            }

            if ($(this).val() === 'first_booking') {
                $("#limit_per_user__div").addClass('d-none');
                $("#limit_per_user").prop('required', false);
            } else {
                $("#limit_per_user__div").removeClass('d-none');
                $("#limit_per_user").prop('required', true);
            }
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

        $(document).ready(function () {
            $("#customer-select").select2({
                placeholder: "<?php echo e(translate('Select_customer')); ?>",
            });
        });

        $(".lang_link").on('click', function (e) {
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang-form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.substring(0, form_id.length - 5);
            $("#" + lang + "-form").removeClass('d-none');
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/PromotionManagement/Resources/views/admin/coupons/create.blade.php ENDPATH**/ ?>