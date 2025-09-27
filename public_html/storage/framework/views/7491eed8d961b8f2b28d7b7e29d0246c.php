<?php $__env->startSection('title',translate('Business_overview_Report')); ?>

<?php $__env->startPush('css_or_js'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-title-wrap mb-3">
                <h2 class="page-title"><?php echo e(translate('Business_Reports')); ?></h2>
            </div>

            <div class="mb-4">
                <ul class="nav nav--tabs nav--tabs__style2">
                    <li class="nav-item">
                        <a href="<?php echo e(route('admin.report.business.overview')); ?>"
                           class="nav-link active"><?php echo e(translate('Overview')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('admin.report.business.earning')); ?>"
                           class="nav-link"><?php echo e(translate('Earning_Report')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('admin.report.business.expense')); ?>"
                           class="nav-link"><?php echo e(translate('Expense_Report')); ?></a>
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="mb-3 fz-16"><?php echo e(translate('Search_Data')); ?></div>

                    <form action="<?php echo e(route('admin.report.business.overview')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-lg-4 col-sm-6 mb-30">
                                <label class="mb-2"><?php echo e(translate('zone')); ?></label>
                                <select class="js-select zone__select" name="zone_ids[]" id="zone_selector__select"
                                        multiple>
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
                                    <?php $__currentLoopData = $sub_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option
                                            value="<?php echo e($sub_category['id']); ?>" <?php echo e(array_key_exists('sub_category_ids', $queryParams) && in_array($sub_category['id'], $queryParams['sub_category_ids']) ? 'selected' : ''); ?>><?php echo e($sub_category['name']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-lg-4 col-sm-6 mb-30">
                                <label class="mb-2"><?php echo e(translate('date_range')); ?></label>
                                <select class="js-select" id="date-range" name="date_range">
                                    <option value="0" disabled selected><?php echo e(translate('Date_Range')); ?></option>
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
                                class="col-lg-4 col-sm-6 <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='custom_date'?'':'d-none'); ?> align-self-end"
                                id="from-filter__div">
                                <div class="mb-30">
                                    <label for="from" class="mb-2"><?php echo e(translate('From')); ?></label>
                                    <input type="date" class="form-control h-45" id="from" name="from" value="<?php echo e(array_key_exists('from', $queryParams)?$queryParams['from']:''); ?>">
                                </div>
                            </div>
                            <div
                                class="col-lg-4 col-sm-6 <?php echo e(array_key_exists('date_range', $queryParams) && $queryParams['date_range']=='custom_date'?'':'d-none'); ?> align-self-end"
                                id="to-filter__div">
                                <div class="mb-30">
                                    <label for="to" class="mb-2"><?php echo e(translate('To')); ?></label>
                                    <input type="date" class="form-control h-45" id="to" name="to" value="<?php echo e(array_key_exists('to', $queryParams)?$queryParams['to']:''); ?>">
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn--primary btn-sm"><?php echo e(translate('Filter')); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row gy-3 pt-4">
                <div class="col-lg-4">
                    <div class="d-flex flex-column gap-3">
                        <div class="card flex-row gap-4 p-30 flex-wrap align-items-center">
                            <img width="35" class="avatar"
                                 src="<?php echo e(asset('public/assets/admin-module')); ?>/img/icons/net_profit.png" alt="">
                            <div class="">
                                <h2 class="fz-26"><?php echo e(with_currency_symbol(array_sum($chart_data['earnings']) - array_sum($chart_data['expenses']))); ?></h2>
                                <span class="fz-12"><?php echo e(translate('Net_Profit')); ?></span>
                            </div>
                            <div class="ms--auto align-self-start" data-bs-toggle="modal"
                                 data-bs-target="#formulaModal">
                                <img src="<?php echo e(asset('public/assets/admin-module')); ?>/img/icons/info.svg"
                                     class="svg" alt="">
                            </div>
                        </div>
                        <div class="card flex-row gap-4 p-30 flex-wrap align-items-center">
                            <img width="35" class="avatar"
                                 src="<?php echo e(asset('public/assets/admin-module')); ?>/img/icons/commission_earning.png"
                                 alt="">
                            <div class="">
                                <h2 class="fz-26"><?php echo e(with_currency_symbol(array_sum($chart_data['earnings']))); ?></h2>
                                <span class="fz-12"><?php echo e(translate('total_earning')); ?></span>
                            </div>
                        </div>
                        <div class="card flex-row gap-4 p-30 flex-wrap align-items-center">
                            <img width="35" class="avatar"
                                 src="<?php echo e(asset('public/assets/admin-module')); ?>/img/icons/expense-bonus.png" alt="">
                            <div class="">
                                <h2 class="fz-26"><?php echo e(with_currency_symbol(array_sum($chart_data['expenses']))); ?></h2>
                                <span class="fz-12"><?php echo e(translate('total_expense')); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body ps-0">
                            <h4 class="ps-20"><?php echo e(translate('Earning_Statistics')); ?></h4>
                            <div id="apex_line-chart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between">
                        <div></div>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report_export')): ?>
                            <div class="d-flex flex-wrap align-items-center gap-3">
                                <div class="dropdown">
                                    <button type="button"
                                            class="btn btn--secondary text-capitalize dropdown-toggle"
                                            data-bs-toggle="dropdown">
                                        <span class="material-icons">file_download</span> <?php echo e(translate('download')); ?>

                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                        <li><a class="dropdown-item"
                                               href="<?php echo e(route('admin.report.business.overview.download').'?'.http_build_query($queryParams)); ?>"><?php echo e(translate('Excel')); ?></a>
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
                                <th><?php echo e(translate('Duration')); ?></th>
                                <th><?php echo e(translate('Commission_Earnings')); ?></th>
                                <th><?php echo e(translate('Total_Expenses')); ?></th>
                                <th><?php echo e(translate('Net_Profit')); ?></th>
                                <th class="text--end"><?php echo e(translate('Net_Profit_Rate')); ?> </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $amounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php ($total_earning = $item['admin_commission']); ?>
                                <?php ($total_expense = $item['discount_by_admin'] + $item['coupon_discount_by_admin'] + $item['campaign_discount_by_admin']); ?>

                                <?php ($net_profit = $total_earning-$total_expense); ?>
                                <?php ($net_profit_rate = $total_earning!=0 ? ($net_profit*100)/$total_earning : $net_profit*100); ?>

                                <tr>
                                    <td><?php echo e($key+1); ?></td>
                                    <td>
                                        <?php if($deterministic == 'month'): ?>
                                            <?php echo e(DateTime::createFromFormat('!m', $item['month'])->format('F')); ?>

                                        <?php elseif($deterministic == 'week'): ?>
                                            <?php echo e($chart_data['timeline'][$key]??''); ?>

                                        <?php else: ?>
                                            <?php echo e($item[$deterministic]); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e(with_currency_symbol($item['admin_commission'])); ?></td>
                                    <td><?php echo e(with_currency_symbol($total_expense)); ?></td>
                                    <td><?php echo e(with_currency_symbol($net_profit)); ?></td>
                                    <td class="text--end"><span class="text-success"><?php echo e(with_currency_symbol($net_profit_rate)); ?> %</span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td class="text-center" colspan="6"><?php echo e(translate('Data_not_available')); ?></td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="formulaModal" tabindex="-1" aria-labelledby="formulaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="<?php echo e(asset('public/assets/admin-module')); ?>/img/media/net_profit.png" class="dark-support"
                         alt="">
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


        $(document).ready(function () {
            $('.zone__select').select2({
                placeholder: "<?php echo e(translate('Select_zone')); ?>",
            });
            $('.category__select').select2({
                placeholder: "<?php echo e(translate('Select_category')); ?>",
            });
            $('.sub-category__select').select2({
                placeholder: "<?php echo e(translate('Select_sub_category')); ?>",
            });

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

        var options = {
            series: [
                {
                    name: "<?php echo e(translate('Earnings')); ?>",
                    data: <?php echo e(json_encode($chart_data['earnings'])); ?>

                },
                {
                    name: "<?php echo e(translate('Expenses')); ?>",
                    data: <?php echo e(json_encode($chart_data['expenses'])); ?>

                }
            ],
            chart: {
                height: 290,
                type: 'line',
                dropShadow: {
                    enabled: true,
                    color: '#000',
                    top: 18,
                    left: 7,
                    blur: 10,
                    opacity: 0.2
                },
                toolbar: {
                    show: true
                }
            },
            colors: ['#6F8AED', '#CAD2FF'],
            dataLabels: {
                enabled: true,
            },
            stroke: {
                curve: 'smooth',
            },
            grid: {
                xaxis: {
                    lines: {
                        show: true
                    }
                },
                yaxis: {
                    lines: {
                        show: true
                    }
                },
                borderColor: '#CAD2FF',
                strokeDashArray: 5,
            },
            markers: {
                size: 1
            },
            theme: {
                mode: 'light',
            },
            xaxis: {
                categories: <?php echo e(json_encode($chart_data['timeline'])); ?>

            },
            legend: {
                position: 'top',
                horizontalAlign: 'center',
                floating: true,
                offsetY: 0,
                offsetX: 0
            },
            padding: {
                top: 0,
                right: 0,
                bottom: 200,
                left: 10
            },
        };

        var chart = new ApexCharts(document.querySelector("#apex_line-chart"), options);
        chart.render();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/AdminModule/Resources/views/admin/report/business/overview.blade.php ENDPATH**/ ?>