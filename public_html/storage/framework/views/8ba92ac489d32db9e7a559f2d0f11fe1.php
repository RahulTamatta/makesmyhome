<?php $__env->startSection('title',translate('Dashboard')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <img width="20"
                                 src="<?php echo e(asset('public/assets/provider-module')); ?>/img/media/business_analytics.png"
                                 alt="">
                            <h4><?php echo e(translate('Business Analytics')); ?></h4>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-lg-3 col-sm-6">
                            <div class="business-summary business-summary-earning">
                                <h2><?php echo e(with_currency_symbol($data[0]['top_cards']['total_earning'])); ?></h2>
                                <h3><?php echo e(translate('total_earning')); ?></h3>
                                <img src="<?php echo e(asset('public/assets/provider-module')); ?>/img/icons/total-earning.png"
                                     class="absolute-img" alt="">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="business-summary business-summary-customers">
                                <h2><?php echo e($data[0]['top_cards']['total_subscribed_services']); ?></h2>
                                <h3><?php echo e(translate('total_subscription')); ?></h3>
                                <img src="<?php echo e(asset('public/assets/provider-module')); ?>/img/icons/customers.png"
                                     class="absolute-img"
                                     alt="">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="business-summary business-summary-providers">
                                <h2><?php echo e($data[0]['top_cards']['total_service_man']); ?></h2>
                                <h3><?php echo e(translate('total_service_man')); ?></h3>
                                <img src="<?php echo e(asset('public/assets/provider-module')); ?>/img/icons/providers.png"
                                     class="absolute-img"
                                     alt="">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="business-summary business-summary-services">
                                <h2><?php echo e($data[0]['top_cards']['total_booking_served']); ?></h2>
                                <h3><?php echo e(translate('total_booking_served')); ?></h3>
                                <img src="<?php echo e(asset('public/assets/provider-module')); ?>/img/icons/services.png"
                                     class="absolute-img"
                                     alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3" data-bg-img="<?php echo e(asset('public/assets/provider-module')); ?>/img/media/create-ads-bg.png">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div class="media align-items-center gap-3">
                            <img width="84" src="<?php echo e(asset('public/assets/provider-module')); ?>/img/media/create-ads.png"
                                 alt="">
                            <div class="media-body">
                                <h4 class="mb-2"><?php echo e(translate('Want To Get Highlighted?')); ?></h4>
                                <p><?php echo e(translate('Create ads to get highlighted on the app and web browser')); ?></p>
                            </div>
                        </div>

                        <a class="text-white btn btn--primary" href="<?php echo e(route('provider.advertisements.ads-create')); ?>"><?php echo e(translate('Create Ads')); ?></a>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-9">
                    <div class="card earning-statistics h-100">
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <h4 class="c1"><?php echo e(translate('Earning_Statistics')); ?></h4>
                                <div
                                    class="position-relative index-2 d-flex flex-wrap gap-3 align-items-center justify-content-between">
                                    <ul class="option-select-btn">
                                        <li>
                                            <label>
                                                <input type="radio" name="statistics" hidden checked>
                                                <span><?php echo e(translate('Yearly')); ?></span>
                                            </label>
                                        </li>
                                    </ul>

                                    <div class="select-wrap d-flex flex-wrap gap-10">
                                        <select class="js-select" onchange="update_chart(this.value)">
                                            <?php ($from_year=date('Y')); ?>
                                            <?php ($to_year=$from_year-10); ?>
                                            <?php while($from_year!=$to_year): ?>
                                                <option
                                                    value="<?php echo e($from_year); ?>" <?php echo e(session()->has('dashboard_earning_graph_year') && session('dashboard_earning_graph_year') == $from_year?'selected':''); ?>>
                                                    <?php echo e($from_year); ?>

                                                </option>
                                                <?php ($from_year--); ?>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="apex-line-chart-container">
                                <div id="apex_line-chart">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card recent-transactions h-100">
                        <div class="card-body">
                            <h4 class="mb-3 c1"><?php echo e(translate('Recent_Transactions')); ?></h4>
                            <?php if(isset($data[6]['recent_transactions']) && count($data[6]['recent_transactions']) > 0): ?>
                                <div class="d-flex align-items-center gap-3 mb-4">
                                    <img src="<?php echo e(asset('public/assets/provider-module')); ?>/img/icons/arrow-up.png" alt="">
                                    <p class="opacity-75"><?php echo e($data[6]['this_month_trx_count']); ?> <?php echo e(translate('transactions_this_month')); ?></p>
                                </div>
                            <?php endif; ?>
                            <div class="events">
                                <?php if($data[6]['this_month_trx_count'] > 0): ?>
                                    <?php $__currentLoopData = $data[6]['recent_transactions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="event">
                                            <div class="knob"></div>
                                            <div class="title">
                                                <?php if($transaction->debit>0): ?>
                                                    <h5><?php echo e(with_currency_symbol($transaction->debit)); ?> <?php echo e(translate('debited')); ?></h5>
                                                <?php else: ?>
                                                    <h5><?php echo e(with_currency_symbol($transaction->credit)); ?> <?php echo e(translate('credited')); ?></h5>
                                                <?php endif; ?>
                                            </div>
                                            <div class="description">
                                                <p><?php echo e(date('d M H:i a',strtotime($transaction->created_at))); ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                                <div class="line"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card top-providers h-100">
                        <div class="card-header d-flex justify-content-between gap-10 pb-0">
                            <div class="">
                                <h5 class="c1 mb-3"><?php echo e(translate('Recent_Bookings_Activity')); ?></h5>

                                <ul class="nav nav--tabs custom-activate-tab gap-2 gap-sm-4">
                                    <li class="nav-item cursor-pointer">
                                        <a class="nav-link px-0 active" data-bs-toggle="tab" id="normal-tab"
                                           data-bs-target="#normal-bookings"><?php echo e(translate('Normal_Bookings')); ?></a>
                                    </li>
                                    <li class="nav-item cursor-pointer">
                                        <a class="nav-link px-0" data-bs-toggle="tab" id="customize-tab"
                                           data-bs-target="#customize-bookings"><?php echo e(translate('Customize_Booking')); ?></a>
                                    </li>
                                </ul>
                            </div>
                            <a href="<?php echo e(route('provider.booking.list', ['booking_status'=>'pending'])); ?>" id="view-all-link"
                               class="btn-link c1"><?php echo e(translate('View all')); ?></a>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="normal-bookings">
                                <div class="card-body">
                                    <div class="row gy-5">
                                        <div class="<?php if(count($data[3]['recent_bookings']) < 1): ?> col-lg-12 <?php else: ?> col-lg-6 <?php endif; ?>">
                                            <ul class="common-list pe-xl-3">
                                                <?php if(count($data[3]['recent_bookings']) < 1): ?>
                                                <div class="py-5 text-center">
                                                    <div class="opacity-75"><?php echo e(translate('No_recent_bookings_are_available')); ?></div>
                                                </div>
                                                <?php endif; ?>
                                                <?php $__currentLoopData = $data[3]['recent_bookings']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li class="<?php if($key==0): ?> pt-0 <?php endif; ?> d-flex flex-wrap gap-2 align-items-center justify-content-between cursor-pointer booking-item"
                                                        data-route="<?php if($booking->is_repeated): ?> <?php echo e(route('provider.booking.repeat_details', [$booking->id])); ?>?web_page=details <?php else: ?> <?php echo e(route('provider.booking.details', [$booking->id])); ?>?web_page=details <?php endif; ?>">
                                                        <div class="media align-items-center gap-3">
                                                            <div class="avatar avatar-lg">
                                                                <img class="avatar-img rounded"
                                                                     src="<?php echo e($booking->detail[0]->service?->thumbnail_full_path); ?>"
                                                                     alt="<?php echo e(translate('booking thumbnail')); ?>">
                                                            </div>
                                                            <div class="media-body ">
                                                                <h5><?php echo e(translate('Booking')); ?>

                                                                    # <?php echo e($booking['readable_id']); ?>

                                                                    <?php if($booking['is_repeated']): ?>
                                                                        <img width="17" height="17"
                                                                             src="<?php echo e(asset('public/assets/admin-module/img/icons/repeat.svg')); ?>"
                                                                             class="rounded-circle repeat-icon" alt="<?php echo e(translate('repeat')); ?>">
                                                                    <?php endif; ?>
                                                                </h5>
                                                                <p><?php echo e(date('d-M-y H:iA', strtotime($booking->created_at))); ?></p>
                                                            </div>
                                                        </div>
                                                        <span
                                                            class="badge py-2 px-3 badge-info"><?php echo e(translate($booking['booking_status'])); ?></span>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                        <?php if(count($data[3]['recent_bookings']) > 0): ?>
                                        <div class="col-lg-6 border-lg-start">
                                            <div class="d-flex justify-content-center">
                                                <div id="apex-donut-chart"></div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane fade" id="customize-bookings">
                                <div class="card-body">
                                    <div class="row gy-5">
                                        <div class="<?php if(count($data[7]['customized_bookings']) < 1): ?> col-lg-12 <?php else: ?> col-lg-6 <?php endif; ?>">
                                            <ul class="common-list pe-xl-3">
                                                <?php if(count($data[7]['customized_bookings']) < 1): ?>
                                                <div class="py-5 text-center">
                                                    <div class="opacity-75"><?php echo e(translate('No_recent_customized_bookings_are_available')); ?></div>
                                                </div>
                                                <?php endif; ?>
                                                <?php $__currentLoopData = $data[7]['customized_bookings']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$customBooking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li class="<?php if($key==0): ?> pt-0 <?php endif; ?> d-flex flex-wrap gap-2 align-items-center justify-content-between cursor-pointer">
                                                        <div class="media align-items-center gap-3">
                                                            <div class="avatar avatar-lg">
                                                                <img class="avatar-img rounded"
                                                                     src="<?php echo e($customBooking?->service?->thumbnail_full_path); ?>"
                                                                     alt="<?php echo e(translate('booking thumbnail')); ?>">
                                                            </div>
                                                            <div class="media-body ">
                                                                <h5><?php echo e($customBooking?->service?->name); ?></h5>
                                                                <span><?php echo e($customBooking?->sub_category?->name); ?></span>
                                                                <p><?php echo e(date('d-M-y H:iA', strtotime($customBooking->created_at))); ?></p>
                                                            </div>
                                                        </div>
                                                        <span
                                                            class="badge py-2 px-3 badge-info"><?php echo e(translate($customBooking['booking_status'])); ?></span>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                        <?php if(count($data[7]['customized_bookings']) > 0): ?>
                                        <div class="col-lg-6 border-lg-start">
                                            <div class="d-flex justify-content-center">
                                                <div id="apex-donut-chart2"></div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card recent-activities h-100">
                        <div class="card-header d-flex justify-content-between gap-10">
                            <h5 class="c1"><?php echo e(translate('My_Subscriptions')); ?></h5>
                            <a href="<?php echo e(route('provider.sub_category.subscribed', ['status' => 'all'])); ?>"
                               class="btn-link c1"><?php echo e(translate('View all')); ?></a>
                        </div>
                        <div class="card-body">
                            <ul class="common-list">
                                <?php if(count($data[4]['subscriptions']) < 1): ?>
                                    <span
                                        class="opacity-75"><?php echo e(translate('No_subscribed_services_are_available')); ?></span>
                                <?php endif; ?>
                                <?php $__currentLoopData = $data[4]['subscriptions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="<?php if($key==0): ?> pt-0 <?php endif; ?> d-flex flex-wrap gap-2 align-items-center justify-content-between cursor-auto">
                                        <div class="media gap-10">
                                            <div class="avatar avatar-lg">
                                                <img class="avatar-img rounded"
                                                     src="<?php echo e($subscription->sub_category->image_full_path); ?>"
                                                     alt="">
                                            </div>
                                            <div class="media-body">
                                                <h5><?php echo e(Str::limit($subscription->sub_category?$subscription->sub_category->name:'', 20)); ?></h5>
                                                <p><?php echo e($subscription['services_count'] . ' ' . translate('Services')); ?></p>
                                            </div>
                                        </div>
                                        <span
                                            class=""><?php echo e($subscription['completed_booking_count'] . ' ' . translate('Bookings Completed')); ?></span>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card top-providers h-100">
                        <div class="card-header d-flex justify-content-between gap-10">
                            <h5 class="c1"><?php echo e(translate('Serviceman_List')); ?></h5>
                            <a href="<?php echo e(route('provider.serviceman.list')); ?>?status=all"
                               class="btn-link c1"><?php echo e(translate('View all')); ?></a>
                        </div>
                        <div class="card-body">
                            <ul class="common-list">
                                <?php if(count($data[5]['serviceman_list']) < 1): ?>
                                    <span class="opacity-75"><?php echo e(translate('No_active_servicemen_are_available')); ?></span>
                                <?php endif; ?>
                                <?php $__currentLoopData = $data[5]['serviceman_list']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$serviceman): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="<?php if($key==0): ?> pt-0 <?php endif; ?>">
                                        <div class="media gap-3">
                                            <div class="avatar avatar-lg">
                                                <a href="<?php echo e(route('provider.serviceman.show', [$serviceman['id']])); ?>">
                                                    <img class="object-fit rounded-circle"
                                                         src="<?php echo e($serviceman->user['profile_image_full_path']); ?>"
                                                         alt="">
                                                </a>
                                            </div>
                                            <div class="media-body ">
                                                <a href="<?php echo e(route('provider.serviceman.show', [$serviceman['id']])); ?>">
                                                    <h5><?php echo e(Str::limit($serviceman->user['first_name'],30)); ?></h5>
                                                </a>
                                                <p><?php echo e(Str::limit($serviceman->user['phone'],30)); ?></p>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('public/assets/provider-module')); ?>/plugins/apex/apexcharts.min.js"></script>
    <script>
        "use strict";

        var options = {
            series: [
                {
                    name: "<?php echo e(translate('total_earnings')); ?>",
                    data: <?php echo json_encode($chart_data['total_earning'], 15, 512) ?>
                }
            ],
            chart: {
                height: 386,
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
                    show: false
                }
            },
            yaxis: {
                labels: {
                    offsetX: 0,
                    formatter: function (value) {
                        return value;
                    }
                },
            },
            colors: ['#82C662', '#4FA7FF'],
            dataLabels: {
                enabled: false,
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
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                floating: true,
                offsetY: -10,
                offsetX: 0
            },
            padding: {
                top: 0,
                right: 0,
                bottom: 200,
                left: 10
            },
        };

        if (localStorage.getItem('dir') === 'rtl') {
            options.yaxis.labels.offsetX = -20;
        }

        var chart = new ApexCharts(document.querySelector("#apex_line-chart"), options);
        chart.render();

        function update_chart(year) {
            var chartElement = document.querySelector('#apex_line-chart');
            if (chartElement) {
                chartElement.remove();
            }

            var container = document.querySelector('.apex-line-chart-container');
            var newChartElement = document.createElement('div');
            newChartElement.id = 'apex_line-chart';
            container.appendChild(newChartElement);

            var url = '<?php echo e(route('provider.update-dashboard-earning-graph')); ?>?year=' + year;

            $.getJSON(url, function (response) {
                var options = {
                    series: [{
                        name: "<?php echo e(translate('total_earnings')); ?>",
                        data: response.total_earning
                    }],
                    chart: {
                        height: 386,
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
                            show: false
                        }
                    },
                    yaxis: {
                        labels: {
                            offsetX: 0,
                            formatter: function (value) {
                                return value;
                            }
                        }
                    },
                    colors: ['#82C662', '#4FA7FF'],
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth'
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
                        strokeDashArray: 5
                    },
                    markers: {
                        size: 1
                    },
                    theme: {
                        mode: 'light'
                    },
                    xaxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                    },
                    legend: {
                        position: 'bottom',
                        horizontalAlign: 'center',
                        floating: true,
                        offsetY: -10,
                        offsetX: 0
                    },
                    padding: {
                        top: 0,
                        right: 0,
                        bottom: 200,
                        left: 10
                    }
                };

                // Recreate the chart with the new data
                var chart = new ApexCharts(document.querySelector('#apex_line-chart'), options);
                chart.render();  // Render the chart
            });
        }

        $(document).ready(function () {
            let routeName = '<?php echo e(route('provider.booking.details', ['id' => ':id'])); ?>';

            $(".booking-item").on('click', function(){
                location.href = $(this).data('route');
            });

            $('.custom-activate-tab li a').on('click', function (e) {
                e.preventDefault();
                $('.custom-activate-tab li a').removeClass('active');
                $(this).addClass('active');
            })
        });
    </script>
    <script>
        var options = {
            series: [<?php echo e($booking_counts['normal_booking_count']); ?>, <?php echo e($booking_counts['post_count']); ?>],
            chart: {
                type: 'donut',
                // width: '200',
            },
            labels: ["Total Normal Bookings", "Total Customized Bookings"],
            colors: ['#2A95FF', '#00C8A4'],
            legend: {
                position: 'bottom'
            },
        };

        var chart = new ApexCharts(document.querySelector("#apex-donut-chart"), options);
        var chart2 = new ApexCharts(document.querySelector("#apex-donut-chart2"), options);
        chart.render();
        chart2.render();
    </script>
    <script>
        $(document).ready(function() {
            $('#normal-tab').click(function() {
                var target = $(this).attr('data-bs-target');
                $('#view-all-link').attr('href', "<?php echo e(route('provider.booking.list', ['booking_status'=>'pending'])); ?>");
            });
        });
        $(document).ready(function() {
            $('#customize-tab').click(function() {
                var target = $(this).attr('data-bs-target');
                $('#view-all-link').attr('href', "<?php echo e(route('provider.booking.post.list', ['type'=>'all'])); ?>");
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('providermanagement::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/ProviderManagement/Resources/views/dashboard.blade.php ENDPATH**/ ?>