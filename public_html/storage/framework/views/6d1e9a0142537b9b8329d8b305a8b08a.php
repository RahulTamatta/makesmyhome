<?php $__env->startSection('title',translate('Transaction_Report')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap mb-3">
                        <h2 class="page-title"><?php echo e(translate('Transaction_Reports')); ?></h2>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-lg-4 col-md-6">
                                    <div class="statistics-card statistics-card__primary border flex-grow-1 d-flex gap-2 justify-content-between h-100 align-items-center">
                                        <div>
                                            <h2><?php echo e(with_currency_symbol($adminTotalEarning ?? 0)); ?></h2>
                                            <h3><?php echo e(translate('Admin_earning')); ?></h3>
                                        </div>
                                        <div class="absolute-img position-static align-self-start"  data-bs-toggle="tooltip" data-bs-title="<?php echo e(translate('Admin balance means total Earning of the admin')); ?>">
                                            <img src="<?php echo e(asset('public/assets/admin-module')); ?>/img/icons/info.svg" class="svg" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="statistics-card statistics-card__info border flex-grow-1 d-flex gap-2 justify-content-between h-100 align-items-center">
                                        <div>
                                            <h2><?php echo e(with_currency_symbol($commission_earning??0)); ?></h2>
                                            <h3><?php echo e(translate('Admin_commission')); ?></h3>
                                        </div>
                                        <div class="absolute-img position-static align-self-start"  data-bs-toggle="tooltip" data-bs-title="<?php echo e(translate('Admin balance means total Earning of the admin')); ?>">
                                            <img src="<?php echo e(asset('public/assets/admin-module')); ?>/img/icons/info.svg" class="svg" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="statistics-card statistics-card__ongoing border flex-grow-1 flex-grow-1 d-flex gap-2 justify-content-between h-100 align-items-center">
                                        <div>
                                            <h2><?php echo e(with_currency_symbol($extra_fee)); ?></h2>
                                            <h3><?php echo e(translate('extra_fee')); ?></h3>
                                        </div>
                                        <div class="absolute-img position-static align-self-start"  data-bs-toggle="tooltip" data-bs-title="<?php echo e(translate('extra fee means the earning from booking extra fee')); ?>">
                                            <img src="<?php echo e(asset('public/assets/admin-module')); ?>/img/icons/info.svg" class="svg" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="statistics-card statistics-card__subscribed-providers border flex-grow-1 flex-grow-1 d-flex gap-2 justify-content-between h-100 align-items-center">
                                        <div>
                                            <h2><?php echo e(with_currency_symbol(($adminAccount->balance_pending??0))); ?></h2>
                                            <h3><?php echo e(translate('Pending_Balance')); ?></h3>
                                        </div>
                                        <div class="absolute-img position-static align-self-start"  data-bs-toggle="tooltip" data-bs-title="<?php echo e(translate('Pending balance means digitally placed booking amount which is yet to disperse')); ?>">
                                            <img src="<?php echo e(asset('public/assets/admin-module')); ?>/img/icons/info.svg" class="svg" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="statistics-card statistics-card__canceled border flex-grow-1 flex-grow-1 d-flex gap-2 justify-content-between h-100 align-items-center">
                                        <div>
                                            <h2><?php echo e(with_currency_symbol($adminAccount->account_payable??0)); ?></h2>
                                            <h3><?php echo e(translate('Account_Payable')); ?></h3>
                                        </div>
                                        <div class="absolute-img position-static align-self-start"  data-bs-toggle="tooltip" data-bs-title="<?php echo e(translate('Account payable means the booking amount that the admin has to pay to the providers')); ?>">
                                            <img src="<?php echo e(asset('public/assets/admin-module')); ?>/img/icons/info.svg" class="svg" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="statistics-card statistics-card__purple border flex-grow-1 flex-grow-1 d-flex gap-2 justify-content-between h-100 align-items-center">
                                        <div>
                                            <h2><?php echo e(with_currency_symbol($adminAccount->account_receivable??0)); ?></h2>
                                            <h3><?php echo e(translate('Account_Receivable')); ?></h3>
                                        </div>
                                        <div class="absolute-img position-static align-self-start"  data-bs-toggle="tooltip" data-bs-title="<?php echo e(translate('Account receivable means the booking commission that the admin will get from the providers for Cash After the Services')); ?>">
                                            <img src="<?php echo e(asset('public/assets/admin-module')); ?>/img/icons/info.svg" class="svg" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="mb-3 fz-16"><?php echo e(translate('Search_Data')); ?></div>
                            <form action="<?php echo e(route('admin.report.transaction', ['transaction_type'=>$queryParams['transaction_type']])); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-lg-4 col-sm-6 mb-30">
                                        <label class="mb-2"><?php echo e(translate('zone')); ?></label>
                                        <select class="js-select zone__select" name="zone_ids[]"
                                                multiple="multiple" id="zone_selector__select">
                                            <option value="0" disabled><?php echo e(translate('Select Zone')); ?></option>
                                            <option value="all"><?php echo e(translate('Select All')); ?></option>
                                            <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($zone['id']); ?>" <?php echo e(array_key_exists('zone_ids', $queryParams) && in_array($zone['id'], $queryParams['zone_ids']) ? 'selected' : ''); ?>><?php echo e($zone['name']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 mb-30">
                                        <label class="mb-2"><?php echo e(translate('provider')); ?></label>
                                        <select class="js-select provider__select" name="provider_ids[]"  id="provider_selector__select"  multiple>
                                            <option value="all"><?php echo e(translate('Select All')); ?></option>
                                            <?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($provider['id']); ?>" <?php echo e(array_key_exists('provider_ids', $queryParams) && in_array($provider['id'], $queryParams['provider_ids']) ? 'selected' : ''); ?>><?php echo e($provider['company_name']); ?> (<?php echo e($provider['company_phone']); ?>)</option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 mb-30 d-none">
                                        <label class="mb-2"><?php echo e(translate('type')); ?></label>
                                        <select class="js-select type__select" id="filter-by" name="filter_by">
                                            <option value="all" <?php echo e(array_key_exists('filter_by', $queryParams) && $queryParams['filter_by']=='all'?'selected':''); ?>><?php echo e(translate('All')); ?></option>
                                            <option value="collect_cash" <?php echo e(array_key_exists('filter_by', $queryParams) && $queryParams['filter_by']=='collect_cash'?'selected':''); ?>><?php echo e(translate('Collect Cash')); ?></option>
                                            <option value="withdraw" <?php echo e(array_key_exists('filter_by', $queryParams) && $queryParams['filter_by']=='withdraw'?'selected':''); ?>><?php echo e(translate('withdraw')); ?></option>
                                            <option value="payment" <?php echo e(array_key_exists('filter_by', $queryParams) && $queryParams['filter_by']=='payment'?'selected':''); ?>><?php echo e(translate('payment')); ?></option>
                                            <option value="commission" <?php echo e(array_key_exists('filter_by', $queryParams) && $queryParams['filter_by']=='commission'?'selected':''); ?>><?php echo e(translate('commission')); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 mb-30">
                                        <label class="mb-2"><?php echo e(translate('date_range')); ?></label>
                                        <select class="js-select" id="date-range" name="date_range">
                                            <option value="0" disabled selected><?php echo e(translate('Select Date Range')); ?></option>
                                            <option value="all_time" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='all_time'?'selected':''); ?>><?php echo e(translate('All_Time')); ?></option>
                                            <option value="this_week" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='this_week'?'selected':''); ?>><?php echo e(translate('This_Week')); ?></option>
                                            <option value="last_week" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='last_week'?'selected':''); ?>><?php echo e(translate('Last_Week')); ?></option>
                                            <option value="this_month" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='this_month'?'selected':''); ?>><?php echo e(translate('This_Month')); ?></option>
                                            <option value="last_month" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='last_month'?'selected':''); ?>><?php echo e(translate('Last_Month')); ?></option>
                                            <option value="last_15_days" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='last_15_days'?'selected':''); ?>><?php echo e(translate('Last_15_Days')); ?></option>
                                            <option value="this_year" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='this_year'?'selected':''); ?>><?php echo e(translate('This_Year')); ?></option>
                                            <option value="last_year" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='last_year'?'selected':''); ?>><?php echo e(translate('Last_Year')); ?></option>
                                            <option value="last_6_month" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='last_6_month'?'selected':''); ?>><?php echo e(translate('Last_6_Month')); ?></option>
                                            <option value="this_year_1st_quarter" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='this_year_1st_quarter'?'selected':''); ?>><?php echo e(translate('This_Year_1st_Quarter')); ?></option>
                                            <option value="this_year_2nd_quarter" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='this_year_2nd_quarter'?'selected':''); ?>><?php echo e(translate('This_Year_2nd_Quarter')); ?></option>
                                            <option value="this_year_3rd_quarter" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='this_year_3rd_quarter'?'selected':''); ?>><?php echo e(translate('This_Year_3rd_Quarter')); ?></option>
                                            <option value="this_year_4th_quarter" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='this_year_4th_quarter'?'selected':''); ?>><?php echo e(translate('this_year_4th_quarter')); ?></option>
                                            <option value="custom_date" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='custom_date'?'selected':''); ?>><?php echo e(translate('Custom_Date')); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='custom_date'?'':'d-none'); ?>" id="from-filter__div">
                                        <div class="form-floating mb-30">
                                            <input type="date" class="form-control" id="from" name="from" value="<?php echo e(array_key_exists('from', $queryParams)?$queryParams['from']:''); ?>">
                                            <label for="from"><?php echo e(translate('From')); ?></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='custom_date'?'':'d-none'); ?>" id="to-filter__div">
                                        <div class="form-floating mb-30">
                                            <input type="date" class="form-control" id="to" name="to" value="<?php echo e(array_key_exists('to', $queryParams)?$queryParams['to']:''); ?>">
                                            <label for="to"><?php echo e(translate('To')); ?></label>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn--primary btn-sm"><?php echo e(translate('Filter')); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="d-flex flex-wrap justify-content-between align-items-center border-bottom mx-lg-4 mb-10 gap-3">
                                <ul class="nav nav--tabs">
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo e(!isset($queryParams['transaction_type']) || $queryParams['transaction_type']=='all'?'active':''); ?>"
                                                href="<?php echo e(url()->current()); ?>?transaction_type=all"><?php echo e(translate('All')); ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo e(isset($queryParams['transaction_type']) && $queryParams['transaction_type']=='debit'?'active':''); ?>"
                                                href="<?php echo e(url()->current()); ?>?transaction_type=debit"><?php echo e(translate('Debit')); ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo e(isset($queryParams['transaction_type']) && $queryParams['transaction_type']=='credit'?'active':''); ?>"
                                                href="<?php echo e(url()->current()); ?>?transaction_type=credit"><?php echo e(translate('Credit')); ?></a>
                                    </li>
                                </ul>

                                <div class="d-flex gap-2 fw-medium">
                                    <span class="opacity-75"><?php echo e(translate('Total_Transactions')); ?>: </span>
                                    <span class="title-color"><?php echo e($filteredTransactions->total()); ?></span>
                                </div>
                            </div>

                            <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between">
                                <form action="<?php echo e(url()->current()); ?>"
                                        class="search-form search-form_style-two"
                                        method="GET">
                                    <div class="input-group search-form__input_group">
                                    <span class="search-form__icon">
                                        <span class="material-icons">search</span>
                                    </span>
                                        <input type="search" class="theme-input-style search-form__input"
                                                value="<?php echo e($queryParams['search']??''); ?>" name="search"
                                                placeholder="<?php echo e(translate('search by transaction ID')); ?>">
                                    </div>
                                    <button type="submit"
                                            class="btn btn--primary"><?php echo e(translate('search')); ?></button>
                                </form>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report_export')): ?>
                                <div class="d-flex flex-wrap align-items-center gap-3">
                                    <div class="dropdown">
                                        <button type="button"
                                            class="btn btn--secondary text-capitalize dropdown-toggle"
                                            data-bs-toggle="dropdown">
                                            <span class="material-icons">file_download</span> <?php echo e(translate('download')); ?>

                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="<?php echo e(route('admin.report.transaction.download').'?'.http_build_query($queryParams)); ?>">
                                                    <?php echo e(translate('Excel')); ?>

                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead class="text-nowrap">
                                        <tr>
                                            <th><?php echo e(translate('SL')); ?></th>
                                            <th><?php echo e(translate('Transaction_ID')); ?></th>
                                            <th><?php echo e(translate('Transaction_Date')); ?></th>
                                            <th><?php echo e(translate('Transaction_To')); ?></th>
                                            <th><?php echo e(translate('Debit')); ?></th>
                                            <th><?php echo e(translate('Credit')); ?></th>
                                            <th><?php echo e(translate('Balance')); ?></th>
                                            <th><?php echo e(translate('Transaction Type')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $filteredTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td><?php echo e($filteredTransactions->firstitem()+$key); ?></td>
                                                <td><?php echo e($transaction->id); ?></td>
                                                <td>
                                                    <div>
                                                        <div><?php echo e(date('d-M-Y',strtotime($transaction->created_at))); ?></div>
                                                        <div><?php echo e(date('h:ia',strtotime($transaction->created_at))); ?></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if(isset($transaction->to_user) && isset($transaction->to_user->provider)): ?>
                                                        <a href="<?php echo e(route('admin.customer.detail',[$transaction->to_user->id, 'web_page'=>'overview'])); ?>">
                                                            <?php echo e($transaction->to_user->provider->company_name); ?>

                                                        </a>
                                                        <div class="d-flex fz-10"><?php echo e(translate($transaction->trx_type)); ?></div>
                                                    <?php elseif(isset($transaction->to_user)): ?>
                                                        <a href="<?php echo e(route('admin.customer.detail',[$transaction->to_user->id, 'web_page'=>'overview'])); ?>">
                                                            <?php echo e($transaction->to_user->first_name.' '.$transaction->to_user->last_name); ?>

                                                        </a>
                                                        <div class="d-flex fz-10"><?php echo e(translate($transaction->trx_type)); ?></div>
                                                    <?php else: ?>
                                                        <?php echo e(translate('User_Unavailable')); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td> -
                                                    <?php if($transaction->debit > 0): ?>
                                                        <span><?php echo e(with_currency_symbol($transaction->debit)); ?></span>
                                                    <?php else: ?>
                                                        <span class="disabled"><?php echo e(with_currency_symbol($transaction->debit)); ?></span>
                                                    <?php endif; ?></td>
                                                <td>+
                                                    <?php if($transaction->credit > 0): ?>
                                                        <span><?php echo e(with_currency_symbol($transaction->credit)); ?></span>
                                                    <?php else: ?>
                                                        <span class="disabled"><?php echo e(with_currency_symbol($transaction->credit)); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($transaction->balance > 0): ?>
                                                        <span><?php echo e(with_currency_symbol($transaction->balance)); ?></span>
                                                    <?php else: ?>
                                                        <span class="disabled"><?php echo e(with_currency_symbol($transaction->balance)); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span><?php echo e(str_replace('_', ' ', $transaction->trx_type)); ?></span>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr><td class="text-center" colspan="7"><?php echo e(translate('Data_not_available')); ?></td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                <?php echo $filteredTransactions->links(); ?>

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

        $('#zone_selector__select').on('change', function() {
            var selectedValues = $(this).val();
            if (selectedValues !== null && selectedValues.includes('all')) {
                $(this).find('option').not(':disabled').prop('selected', 'selected');
                $(this).find('option[value="all"]').prop('selected', false);
            }
        });

        $('#provider_selector__select').on('change', function() {
            var selectedValues = $(this).val();
            if (selectedValues !== null && selectedValues.includes('all')) {
                $(this).find('option').not(':disabled').prop('selected', 'selected');
                $(this).find('option[value="all"]').prop('selected', false);
            }
        });

        $(document).ready(function () {
            $('.zone__select').select2({
                placeholder: "<?php echo e(translate('Select_zone')); ?>",
            });
            $('.provider__select').select2({
                placeholder: "<?php echo e(translate('Select_provider')); ?>",
            });
            $('.type__select').select2({
                placeholder: "<?php echo e(translate('Select_Type')); ?>",
            });
        });

        $(document).ready(function () {
            $('#date-range').on('change', function() {
                if(this.value === 'custom_date') {
                    $('#from-filter__div').removeClass('d-none');
                    $('#to-filter__div').removeClass('d-none');
                }
                if(this.value !== 'custom_date') {
                    $('#from-filter__div').addClass('d-none');
                    $('#to-filter__div').addClass('d-none');
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/AdminModule/Resources/views/admin/report/transaction.blade.php ENDPATH**/ ?>