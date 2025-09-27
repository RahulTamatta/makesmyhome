<?php $__env->startSection('title',translate('Add Fund Bonus')); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between mb-3 mt-3">
                        <h2 class="page-title"><?php echo e(translate('Wallet Bonus Setup')); ?></h2>
                        <div class="d-flex gap-2 justify-content-end text-primary fw-bold">
                            <?php echo e(translate('How_it_Works')); ?> <i class="material-icons" data-bs-toggle="tooltip"
                                                             title="Info" id="hoverButton">info</i>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <form action="<?php echo e(route('admin.bonus.store')); ?>" method="post">
                                <?php echo csrf_field(); ?>
                                <?php ($language= Modules\BusinessSettingsModule\Entities\BusinessSettings::where('key_name','system_language')->first()); ?>
                                <?php ($defaultLanguage = str_replace('_', '-', app()->getLocale())); ?>
                                <?php if($language): ?>
                                    <ul class="nav nav--tabs border-color-primary">
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
                                <?php if($language): ?>
                                    <div class="lang-form" id="default-form">
                                        <div class="row">

                                            <div class="col-lg-4">
                                                <div class="form-floating form-floating__icon mb-30 mt-30">
                                                    <input type="text" name="bonus_title[]" class="form-control"
                                                           placeholder="<?php echo e(translate('bonus_title')); ?>" required
                                                    >
                                                    <label><?php echo e(translate('bonus_title')); ?>

                                                        (<?php echo e(translate('default')); ?>)</label>
                                                    <span class="material-icons">title</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-floating form-floating__icon mb-30 mt-30">
                                                    <input type="text" name="short_description[]" class="form-control"
                                                           placeholder="<?php echo e(translate('short_description')); ?>" required
                                                    >
                                                    <label><?php echo e(translate('short_description')); ?>

                                                        (<?php echo e(translate('default')); ?>)</label>
                                                    <span class="material-icons">subtitles</span>
                                                </div>
                                            </div>
                                            <input type="hidden" name="lang[]" value="default">
                                        </div>
                                    </div>
                                    <?php $__currentLoopData = $language?->live_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="lang-form d-none" id="<?php echo e($lang['code']); ?>-form">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-floating form-floating__icon mb-30 mt-30">
                                                        <input type="text" name="bonus_title[]" class="form-control"
                                                               placeholder="<?php echo e(translate('bonus_title')); ?> ">
                                                        <label><?php echo e(translate('bonus_title')); ?>

                                                            (<?php echo e(strtoupper($lang['code'])); ?>)</label>
                                                        <span class="material-icons">title</span>
                                                    </div>
                                                </div>

                                                <div class="col-lg-8">
                                                    <div class="form-floating form-floating__icon mb-30 mt-30">
                                                        <input type="text" name="short_description[]"
                                                               class="form-control"
                                                               placeholder="<?php echo e(translate('short_description')); ?> ">
                                                        <label><?php echo e(translate('short_description')); ?>

                                                            (<?php echo e(strtoupper($lang['code'])); ?>)</label>
                                                        <span class="material-icons">subtitles</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="lang[]" value="<?php echo e($lang['code']); ?>">
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <div class="lang-form">
                                        <div class="col-lg-4">
                                            <div class="form-floating form-floating__icon mb-30 mt-30">
                                                <input type="text" name="bonus_title[]" class="form-control"
                                                       value="<?php echo e(old('name')); ?>"
                                                       placeholder="<?php echo e(translate('bonus_title')); ?>" required>
                                                <label><?php echo e(translate('bonus_title')); ?>

                                                    (<?php echo e(translate('default')); ?>)</label>
                                                <span class="material-icons">title</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="form-floating form-floating__icon mb-30 mt-30 lang-form">
                                                <input type="text" name="short_description[]" class="form-control"
                                                       value="<?php echo e(old('name')); ?>"
                                                       placeholder="<?php echo e(translate('short_description')); ?>" required>
                                                <label><?php echo e(translate('short_description')); ?>

                                                    (<?php echo e(translate('default')); ?>)</label>
                                                <span class="material-icons">subtitles</span>
                                            </div>
                                        </div>
                                        <input type="hidden" name="lang[]" value="default">
                                    </div>
                                <?php endif; ?>


                                <div class="row">
                                    <div class="col-lg-4 mb-30">
                                        <select class="select-amount theme-input-style" id="amount_type"
                                                name="bonus_amount_type" required>
                                            <option value="percent"><?php echo e(translate('percentage')); ?></option>
                                            <option value="amount"><?php echo e(translate('fixed_amount')); ?></option>
                                        </select>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-floating form-floating__icon mb-30">
                                            <input class="form-control" name="bonus_amount" id="amount"
                                                   placeholder="Ex: 50%" step="any" min="0"
                                                   value="0" type="number" required>
                                            <label id="amount_label"><?php echo e(translate('bonus')); ?> (%)</label>
                                            <span class="material-icons">price_change</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-floating form-floating__icon mb-30">
                                            <input class="form-control" name="minimum_add_amount"
                                                   placeholder="<?php echo e(translate('minimum_add_amount')); ?>"
                                                   value="0" type="number" step="any" required>
                                            <label><?php echo e(translate('minimum_add_amount')); ?></label>
                                            <span class="material-icons">price_change</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4" id="maximum_bonus_amount_div">
                                        <div class="form-floating form-floating__icon mb-30">
                                            <input class="form-control" name="maximum_bonus_amount"
                                                   placeholder="<?php echo e(translate('maximum_bonus_amount')); ?>"
                                                   value="0" min="0" type="number" step="any" required
                                                   id="max_amount">
                                            <label><?php echo e(translate('maximum_bonus_amount')); ?></label>
                                            <span class="material-icons">price_change</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-30">
                                            <div class="form-floating">
                                                <input type="date" class="form-control" name="start_date"
                                                       value="<?php echo e(now()->format('Y-m-d')); ?>" id="start_date">
                                                <label><?php echo e(translate('Start_Date')); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-30">
                                            <div class="form-floating">
                                                <input type="date" class="form-control" name="end_date"
                                                       value="<?php echo e(now()->addDays(2)->format('Y-m-d')); ?>"
                                                       id="end_date">
                                                <label><?php echo e(translate('End_Date')); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex gap-4 flex-wrap justify-content-end">
                                    <button type="reset" class="btn btn--secondary"><?php echo e(translate('Reset')); ?></button>
                                    <button type="submit" class="btn btn--primary"><?php echo e(translate('Submit')); ?></button>
                                </div>
                            </form>
                        </div>
                        <div class="modal fade" id="addFundModal" tabindex="-1" aria-labelledby="addFundModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header border-0 pb-0">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body pb-5 px-xl-5 text-center">
                                        <img width="80" class="mb-4 pb-3"
                                             src="<?php echo e(asset('public/assets/admin-module/img/add_fund.png')); ?>" alt="">
                                        <h4 class="mb-3"><?php echo e(translate('Wallet bonus is only applicable when a customer add fund to
                                            wallet via outside payment gateway')); ?> !</h4>
                                        <p><?php echo e(translate('Customer will get extra amount to his / her wallet additionally with the
                                            amount he / she added from other payment gateways. The bonus amount will
                                            consider as admin expense')); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        "use strict"
        $(document).ready(function () {
            $('.select-amount').select2({});

            $('#hoverButton').hover(function () {

                $('#addFundModal').modal('show');
            });

            const amountType = $('#amount_type');
            amountType.on('change', function () {
                if (amountType.val() == 'amount') {
                    $("#amount_label").text("Bonus (<?php echo e(currency_symbol()); ?>)");
                    $('#max_amount').prop("disabled", true);
                    $('#max_amount').val(0);

                } else {
                    $("#amount_label").text("Bonus (%)")
                    $('#max_amount').removeAttr("disabled");
                }
            });

            const startInput = document.getElementById('start_date');
            const endInput = document.getElementById('end_date');
            const today = new Date();
            const formattedToday = today.toISOString().split('T')[0];

            startInput.setAttribute('min', formattedToday);
            endInput.setAttribute('min', formattedToday);
        });
    </script>

    <script>
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

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/PaymentModule/Resources/views/admin/bonus/create.blade.php ENDPATH**/ ?>