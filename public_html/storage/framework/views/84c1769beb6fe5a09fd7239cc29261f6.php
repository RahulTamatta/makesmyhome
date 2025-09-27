<?php $__env->startSection('title',translate('Booking_Report')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap mb-3">
                        <h2 class="page-title"><?php echo e(translate('Booking_Reports')); ?></h2>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3 fz-16"><?php echo e(translate('Search_Data')); ?></div>

                            <form action="<?php echo e(route('admin.report.booking')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-lg-4 col-sm-6 mb-30">
                                        <label class="mb-2"><?php echo e(translate('zone')); ?></label>
                                        <select class="js-select zone__select" name="zone_ids[]"
                                                id="zone_selector__select" multiple>
                                            <option value="all"><?php echo e(translate('Select All')); ?></option>
                                            <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                    value="<?php echo e($zone['id']); ?>" <?php echo e(array_key_exists('zone_ids', $queryParams) && in_array($zone['id'], $queryParams['zone_ids']) ? 'selected' : ''); ?>><?php echo e($zone['name']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 mb-30">
                                        <label class="mb-2"><?php echo e(translate('category')); ?></label>
                                        <select class="js-select category__select" name="category_ids[]"
                                                id="category_selector__select" multiple>
                                            <option value="all"><?php echo e(translate('Select All')); ?></option>
                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                    value="<?php echo e($category['id']); ?>" <?php echo e(array_key_exists('category_ids', $queryParams) && in_array($category['id'], $queryParams['category_ids']) ? 'selected' : ''); ?>><?php echo e($category['name']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 mb-30">
                                        <label class="mb-2"><?php echo e(translate('sub_category')); ?></label>
                                        <select class="js-select sub-category__select" name="sub_category_ids[]"
                                                id="sub_category_selector__select"
                                                multiple>
                                            <option value="all"><?php echo e(translate('Select All')); ?></option>
                                            <?php $__currentLoopData = $subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                    value="<?php echo e($sub_category['id']); ?>" <?php echo e(array_key_exists('sub_category_ids', $queryParams) && in_array($sub_category['id'], $queryParams['sub_category_ids']) ? 'selected' : ''); ?>><?php echo e($sub_category['name']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 mb-30">
                                        <label class="mb-2"><?php echo e(translate('provider')); ?></label>
                                        <select class="js-select provider__select" name="provider_ids[]"
                                                id="provider_selector__select" multiple>
                                            <option value="all"><?php echo e(translate('Select All')); ?></option>
                                            <?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                    value="<?php echo e($provider['id']); ?>" <?php echo e(array_key_exists('provider_ids', $queryParams) && in_array($provider['id'], $queryParams['provider_ids']) ? 'selected' : ''); ?>><?php echo e($provider['company_name']); ?>

                                                    (<?php echo e($provider['company_phone']); ?>)
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 mb-30">
                                        <label class="mb-2"><?php echo e(translate('date_range')); ?></label>
                                        <select class="js-select" id="date-range" name="date_range">
                                            <option value="0" disabled
                                                    selected><?php echo e(translate('Select Date Range')); ?></option>
                                            <option
                                                value="all_time" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='all_time'?'selected':''); ?>><?php echo e(translate('All_Time')); ?></option>
                                            <option
                                                value="this_week" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='this_week'?'selected':''); ?>><?php echo e(translate('This_Week')); ?></option>
                                            <option
                                                value="last_week" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='last_week'?'selected':''); ?>><?php echo e(translate('Last_Week')); ?></option>
                                            <option
                                                value="this_month" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='this_month'?'selected':''); ?>><?php echo e(translate('This_Month')); ?></option>
                                            <option
                                                value="last_month" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='last_month'?'selected':''); ?>><?php echo e(translate('Last_Month')); ?></option>
                                            <option
                                                value="last_15_days" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='last_15_days'?'selected':''); ?>><?php echo e(translate('Last_15_Days')); ?></option>
                                            <option
                                                value="this_year" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='this_year'?'selected':''); ?>><?php echo e(translate('This_Year')); ?></option>
                                            <option
                                                value="last_year" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='last_year'?'selected':''); ?>><?php echo e(translate('Last_Year')); ?></option>
                                            <option
                                                value="last_6_month" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='last_6_month'?'selected':''); ?>><?php echo e(translate('Last_6_Month')); ?></option>
                                            <option
                                                value="this_year_1st_quarter" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='this_year_1st_quarter'?'selected':''); ?>><?php echo e(translate('This_Year_1st_Quarter')); ?></option>
                                            <option
                                                value="this_year_2nd_quarter" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='this_year_2nd_quarter'?'selected':''); ?>><?php echo e(translate('This_Year_2nd_Quarter')); ?></option>
                                            <option
                                                value="this_year_3rd_quarter" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='this_year_3rd_quarter'?'selected':''); ?>><?php echo e(translate('This_Year_3rd_Quarter')); ?></option>
                                            <option
                                                value="this_year_4th_quarter" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='this_year_4th_quarter'?'selected':''); ?>><?php echo e(translate('this_year_4th_quarter')); ?></option>
                                            <option
                                                value="custom_date" <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='custom_date'?'selected':''); ?>><?php echo e(translate('Custom_Date')); ?></option>
                                        </select>
                                    </div>
                                    <div
                                        class="col-lg-4 col-sm-6 <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='custom_date'?'':'d-none'); ?>"
                                        id="from-filter__div">
                                        <div class="form-floating mb-30">
                                            <input type="date" class="form-control" id="from" name="from"
                                                   value="<?php echo e(array_key_exists('from', $queryParams)?$queryParams['from']:''); ?>">
                                            <label for="from"><?php echo e(translate('From')); ?></label>
                                        </div>
                                    </div>
                                    <div
                                        class="col-lg-4 col-sm-6 <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='custom_date'?'':'d-none'); ?>"
                                        id="to-filter__div">
                                        <div class="form-floating mb-30">
                                            <input type="date" class="form-control" id="to" name="to"
                                                   value="<?php echo e(array_key_exists('to', $queryParams)?$queryParams['to']:''); ?>">
                                            <label for="to"><?php echo e(translate('To')); ?></label>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit"
                                                class="btn btn--primary btn-sm"><?php echo e(translate('Submit')); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row g-2 pt-2">
                        <div class="col-xl-3">
                            <div class="d-flex flex-wrap gap-2">
                                <div class="card p-30 flex-grow-1">
                                    <div class="d-flex gap-4 flex-wrap">
                                        <img width="35" class="avatar"
                                             src="<?php echo e(asset('public/assets/admin-module')); ?>/img/icons/total_booking.png"
                                             alt="">
                                        <div class="text-center">
                                            <h2 class="fz-26"><?php echo e($bookings_count['total_bookings']); ?></h2>
                                            <span class="fz-12"><?php echo e(translate('Total_Bookings')); ?></span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap justify-content-between gap-2 mt-30">
                                        <div class="d-flex flex-column align-items-center gap-2 fz-12">
                                            <span class="fw-semibold text-danger"><?php echo e($bookings_count['canceled']); ?></span>
                                            <span class="opacity-50"><?php echo e(translate('Canceled')); ?></span>
                                        </div>
                                        <div class="d-flex flex-column align-items-center gap-2 fz-12">
                                            <span
                                                class="fw-semibold text-success"><?php echo e($bookings_count['accepted']); ?></span>
                                            <span class="opacity-50"><?php echo e(translate('Accepted')); ?></span>
                                        </div>
                                        <div class="d-flex flex-column align-items-center gap-2 fz-12">
                                            <span class="c1 fw-semibold"><?php echo e($bookings_count['ongoing']); ?></span>
                                            <span class="opacity-50"><?php echo e(translate('On_Going')); ?></span>
                                        </div>
                                        <div class="d-flex flex-column align-items-center gap-2 fz-12">
                                            <span
                                                class="fw-semibold text-success"><?php echo e($bookings_count['completed']); ?></span>
                                            <span class="opacity-50"><?php echo e(translate('Completed')); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="card p-30 flex-grow-1">
                                    <div class="d-flex gap-4 flex-wrap">
                                        <img width="35" class="avatar"
                                             src="<?php echo e(asset('public/assets/admin-module')); ?>/img/icons/booking_amount.png"
                                             alt="">
                                        <div class="text-center">
                                            <h2 class="fz-26"><?php echo e(with_currency_symbol($booking_amount['total_booking_amount'])); ?></h2>
                                            <span class="fz-12"><?php echo e(translate('Total_Booking_Amount')); ?></span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap justify-content-between gap-2 mt-30">
                                        <div class="d-flex flex-column align-items-center gap-2 fz-12">
                                            <span
                                                class="text-danger fw-semibold"><?php echo e(with_currency_symbol($booking_amount['total_unpaid_booking_amount'])); ?></span>
                                            <span class="opacity-50 gap-1"><?php echo e(translate('Due_Amount')); ?>

                                                <i class="material-icons" data-bs-toggle="tooltip"
                                                   data-bs-placement="top"
                                                   title="<?php echo e(translate('Digitally paid but yet to disburse the amount')); ?>"
                                                >info</i>
                                            </span>
                                        </div>
                                        <div class="d-flex flex-column align-items-center gap-2 fz-12">
                                            <span
                                                class="text-success fw-semibold"><?php echo e(with_currency_symbol($booking_amount['total_paid_booking_amount'])); ?></span>
                                            <span class="opacity-50 gap-1"><?php echo e(translate('Already_Settled')); ?>

                                                <i class="material-icons" data-bs-toggle="tooltip"
                                                   data-bs-placement="top"
                                                   title="<?php echo e(translate('Digitally paid & already disbursed the amount')); ?>"
                                                >info</i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9">
                            <div class="card">
                                <div class="card-body ps-0">
                                    <h4 class="ps-20"><?php echo e(translate('Booking_Statistics')); ?></h4>
                                    <div id="apex_column-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-2">
                        <div class="card-body">
                            <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between">
                                <form action="<?php echo e(url()->current()); ?>"
                                      class="search-form search-form_style-two"
                                      method="GET">
                                    <div class="input-group search-form__input_group">
                                            <span class="search-form__icon">
                                                <span class="material-icons">search</span>
                                            </span>
                                        <input type="search" class="theme-input-style search-form__input"
                                               value="<?php echo e(request()->get('search')); ?>" name="search"
                                               placeholder="<?php echo e(translate('search_by_Booking_ID')); ?>">
                                    </div>
                                    <button type="submit"
                                            class="btn btn--primary"><?php echo e(translate('search')); ?></button>
                                </form>

                                <div class="d-flex flex-wrap align-items-center gap-3">
                                    <div>
                                        <select class="js-select booking-status__select" name="booking_status"
                                                id="booking-status">
                                            <option value="" selected disabled><?php echo e(translate('Booking_status')); ?></option>
                                            <option value="all"><?php echo e(translate('All')); ?></option>
                                            <?php $__currentLoopData = BOOKING_STATUSES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking_status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                    value="<?php echo e($booking_status['key']); ?>" <?php echo e($booking_status['key'] === request()->input('booking_status') ? 'selected' : ''); ?>><?php echo e($booking_status['value']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report_export')): ?>
                                        <div class="dropdown">
                                            <button type="button"
                                                    class="btn btn--secondary text-capitalize dropdown-toggle"
                                                    data-bs-toggle="dropdown">
                                                <span
                                                    class="material-icons">file_download</span> <?php echo e(translate('download')); ?>

                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                                <li><a class="dropdown-item"
                                                       href="<?php echo e(route('admin.report.booking.download').'?'.http_build_query(request()->all())); ?>"><?php echo e(translate('Excel')); ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead class="text-nowrap">
                                    <tr>
                                        <th><?php echo e(translate('SL')); ?></th>
                                        <th><?php echo e(translate('Booking_ID')); ?></th>
                                        <th><?php echo e(translate('Customer_Info')); ?></th>
                                        <th><?php echo e(translate('Provider_Info')); ?></th>
                                        <th><?php echo e(translate('Booking_Amount')); ?></th>
                                        <th><?php echo e(translate('Service_Discount')); ?></th>
                                        <th><?php echo e(translate('Coupon_Discount')); ?></th>
                                        <th><?php echo e(translate('VAT_/_Tax')); ?></th>
                                        <th><?php echo e(translate('Action')); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $filtered_bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($filtered_bookings->firstitem()+$key); ?></td>
                                            <td>
                                                <a href="<?php echo e(route('admin.booking.details', [$booking->id,'web_page'=>'details'])); ?>">
                                                    <?php echo e($booking['readable_id']); ?>

                                                </a>
                                            </td>
                                            <td>
                                                <?php if(isset($booking->customer)): ?>
                                                    <div class="fw-medium">
                                                        <a href="<?php echo e(route('admin.customer.detail',[$booking->customer->id, 'web_page'=>'overview'])); ?>">
                                                            <?php echo e($booking->customer->first_name . ' ' . $booking->customer->last_name); ?>

                                                        </a>
                                                    </div>
                                                    <a class="fz-12"
                                                       href="tel:<?php echo e($booking->customer->phone??''); ?>"><?php echo e($booking->customer->phone??''); ?></a>
                                                <?php else: ?>
                                                    <div
                                                        class="fw-medium badge badge badge-danger radius-50"><?php echo e(translate('Customer_not_available')); ?></div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if(isset($booking->provider) && isset($booking->provider->owner)): ?>
                                                    <div class="fw-medium">
                                                        <a href="<?php echo e(route('admin.provider.details',[$booking->provider->id, 'web_page'=>'overview'])); ?>">
                                                            <?php echo e($booking->provider->company_name); ?>

                                                        </a>
                                                    </div>
                                                    <a class="fz-12"
                                                       href="tel:<?php echo e($booking->provider->company_phone??''); ?>"><?php echo e($booking->provider->company_phone??''); ?></a>
                                                <?php else: ?>
                                                    <div
                                                        class="fw-medium badge badge badge-danger radius-50"><?php echo e(translate('Provider_not_available')); ?></div>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e(with_currency_symbol($booking['total_booking_amount'])); ?></td>
                                            <td>
                                                <?php if($booking['total_campaign_discount_amount'] > $booking['total_discount_amount']): ?>
                                                    <?php echo e(with_currency_symbol($booking['total_campaign_discount_amount'])); ?>

                                                    <label
                                                        class="fw-medium badge badge badge-info radius-50"><?php echo e(translate('Campaign')); ?></label>
                                                <?php else: ?>
                                                    <?php echo e(with_currency_symbol($booking['total_discount_amount'])); ?>

                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e(with_currency_symbol($booking['total_coupon_discount_amount'])); ?></td>
                                            <td><?php echo e(with_currency_symbol($booking['total_tax_amount'])); ?></td>
                                            <td>
                                                <?php if($booking->is_repeated): ?>
                                                    <a href="<?php echo e(route('admin.booking.repeat_details', [$booking->id, 'web_page' => 'details'])); ?>"
                                                       class="action-btn btn--light-primary" style="--size: 30px"><span
                                                            class="material-icons m-0">visibility</span>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?php echo e(route('admin.booking.details', [$booking->id,'web_page'=>'details'])); ?>"
                                                       class="action-btn btn--light-primary" style="--size: 30px"><span
                                                            class="material-icons m-0">visibility</span>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td class="text-center" colspan="9"><?php echo e(translate('Data_not_available')); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                <?php echo $filtered_bookings->links(); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>

    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/apex/apexcharts.min.js"></script>

    <script>
        "use strict";

        $('#zone_selector__select').on('change', function () {
            var selectedValues = $(this).val();
            if (selectedValues !== null && selectedValues.includes('all')) {
                $(this).find('option').not(':disabled').prop('selected', 'selected');
                $(this).find('option[value="all"]').prop('selected', false);
            }
        });

        $('#category_selector__select').on('change', function () {
            var selectedValues = $(this).val();
            if (selectedValues !== null && selectedValues.includes('all')) {
                $(this).find('option').not(':disabled').prop('selected', 'selected');
                $(this).find('option[value="all"]').prop('selected', false);
            }
        });

        $('#sub_category_selector__select').on('change', function () {
            var selectedValues = $(this).val();
            if (selectedValues !== null && selectedValues.includes('all')) {
                $(this).find('option').not(':disabled').prop('selected', 'selected');
                $(this).find('option[value="all"]').prop('selected', false);
            }
        });

        $('#provider_selector__select').on('change', function () {
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
            $('.category__select').select2({
                placeholder: "<?php echo e(translate('Select_category')); ?>",
            });
            $('.sub-category__select').select2({
                placeholder: "<?php echo e(translate('Select_sub_category')); ?>",
            });
            $('.booking-status__select').select2({
                placeholder: "<?php echo e(translate('Booking_status')); ?>",
            });
        });

        $(document).ready(function () {
            $('#date-range').on('change', function () {
                if (this.value === 'custom_date') {
                    $('#from-filter__div').removeClass('d-none');
                    $('#to-filter__div').removeClass('d-none');
                }


                if (this.value !== 'custom_date') {
                    $('#from-filter__div').addClass('d-none');
                    $('#to-filter__div').addClass('d-none');
                }
            });
        });

        $(document).ready(function () {
            $('#booking-status').on('change', function () {
                location.href = "<?php echo e(route('admin.report.booking')); ?>" + "?booking_status=" + this.value;
            });
        });

        var options = {
            series: [{
                name: '<?php echo e(translate('Total_Booking')); ?>',
                data: <?php echo e(json_encode($chart_data['booking_amount'])); ?>

            }, {
                name: '<?php echo e(translate('Commission')); ?>',
                data: <?php echo e(json_encode($chart_data['admin_commission'])); ?>

            }, {
                name: '<?php echo e(translate('VAT_/_Tax')); ?>',
                data: <?php echo e(json_encode($chart_data['tax_amount'])); ?>

            }],
            chart: {
                type: 'bar',
                height: 299
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55px',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: <?php echo e(json_encode($chart_data['timeline'])); ?>,
            },
            yaxis: {
                title: {
                    text: '<?php echo e(currency_symbol()); ?>'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return " " + val + " ";
                    }
                }
            },
            legend: {
                show: false
            },
        };

        var chart = new ApexCharts(document.querySelector("#apex_column-chart"), options);
        chart.render();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/AdminModule/Resources/views/admin/report/booking.blade.php ENDPATH**/ ?>