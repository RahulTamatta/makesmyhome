<?php $__env->startSection('title',translate('provider_details')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-title-wrap mb-3">
                <h2 class="page-title"><?php echo e(translate('Provider_Details')); ?></h2>
            </div>

            <div class="mb-3">
                <ul class="nav nav--tabs nav--tabs__style2">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='overview'?'active':''); ?>"
                           href="<?php echo e(url()->current()); ?>?web_page=overview"><?php echo e(translate('Overview')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='subscribed_services'?'active':''); ?>"
                           href="<?php echo e(url()->current()); ?>?web_page=subscribed_services"><?php echo e(translate('Subscribed_Services')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='bookings'?'active':''); ?>"
                           href="<?php echo e(url()->current()); ?>?web_page=bookings"><?php echo e(translate('Bookings')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='serviceman_list'?'active':''); ?>"
                           href="<?php echo e(url()->current()); ?>?web_page=serviceman_list"><?php echo e(translate('Service_Man_List')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='settings'?'active':''); ?>"
                           href="<?php echo e(url()->current()); ?>?web_page=settings"><?php echo e(translate('Settings')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='bank_information'?'active':''); ?>"
                           href="<?php echo e(url()->current()); ?>?web_page=bank_information"><?php echo e(translate('Bank_Information')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='reviews'?'active':''); ?>"
                           href="<?php echo e(url()->current()); ?>?web_page=reviews"><?php echo e(translate('Reviews')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='subscription'?'active':''); ?>"
                           href="<?php echo e(url()->current()); ?>?web_page=subscription&provider_id=<?php echo e(request()->id); ?>"><?php echo e(translate('Business Plan')); ?></a>
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="card-body p-30">
                    <?php if($provider->is_approved == 1): ?>
                        <div class="provider-details-overview mb-30">
                            <div class="provider-details-overview__collect-cash">
                                <div class="statistics-card statistics-card__collect-cash h-100">
                                    <h3><?php echo e(translate('Collect_Cash_From_Provider')); ?></h3>
                                    <h2><?php echo e(with_currency_symbol($provider->owner->account->account_payable)); ?></h2>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('provider_update')): ?>
                                        <a href="<?php echo e(route('admin.provider.collect_cash.list', [$provider->id])); ?>"
                                           class="btn btn--primary text-capitalize w-100 btn--lg mw-75"><?php echo e(translate('Collect_Cash')); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="provider-details-overview__statistics">

                                <div
                                    class="statistics-card statistics-card__style2 statistics-card__pending-withdraw">
                                    <h2><?php echo e(with_currency_symbol($provider->owner->account->balance_pending)); ?></h2>
                                    <h3><?php echo e(translate('Pending_Withdrawn')); ?></h3>
                                </div>

                                <div
                                    class="statistics-card statistics-card__style2 statistics-card__already-withdraw">
                                    <h2><?php echo e(with_currency_symbol($provider->owner->account->total_withdrawn)); ?></h2>
                                    <h3><?php echo e(translate('Already_Withdrawn')); ?></h3>
                                </div>

                                <div
                                    class="statistics-card statistics-card__style2 statistics-card__withdrawable-amount">
                                    <h2><?php echo e(with_currency_symbol($provider->owner->account->account_receivable)); ?></h2>
                                    <h3><?php echo e(translate('Withdrawable_Amount')); ?></h3>
                                </div>

                                <div
                                    class="statistics-card statistics-card__style2 statistics-card__total-earning">
                                    <h2><?php echo e(with_currency_symbol($provider->owner->account->received_balance + $provider->owner->account->total_withdrawn)); ?></h2>
                                    <h3><?php echo e(translate('Total_Earning')); ?></h3>
                                </div>
                            </div>
                            <div class="provider-details-overview__order-overview">
                                <div class="statistics-card statistics-card__order-overview h-100 pb-2">
                                    <h3 class="mb-0"><?php echo e(translate('Booking_Overview')); ?></h3>
                                    <div id="apex-pie-chart" class="d-flex justify-content-center"></div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="d-flex align-items-center flex-wrap-reverse justify-content-between gap-3 mb-3">
                        <h2><?php echo e(translate('Information_Details')); ?></h2>
                        <div class="d-flex align-items-center flex-wrap gap-3">
                            <?php if($provider->is_approved == 2): ?>
                                <a type="button"
                                   class="btn btn-soft--danger text-capitalize provider_approval"
                                   id="button-deny-<?php echo e($provider->id); ?>" data-approve="<?php echo e($provider->id); ?>"
                                   data-status="deny">
                                    <?php echo e(translate('Deny')); ?>

                                </a>
                            <?php endif; ?>
                            <?php if($provider->is_approved == 0 || $provider->is_approved == 2): ?>
                                <a type="button" class="btn btn--success text-capitalize approval_provider"
                                   id="button-<?php echo e($provider->id); ?>" data-approve="<?php echo e($provider->id); ?>"
                                   data-approve="approve">
                                    <?php echo e(translate('Accept')); ?>

                                </a>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('provider_update')): ?>
                                <a href="<?php echo e(route('admin.provider.edit',[$provider->id])); ?>" class="btn btn--primary">
                                    <span class="material-icons">border_color</span>
                                    <?php echo e(translate('Edit')); ?>

                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="information-details-box media flex-column flex-sm-row gap-20">
                                <img class="avatar-img radius-5" src="<?php echo e($provider->logoFullPath); ?>" alt="<?php echo e(translate('logo')); ?>">
                                <div class="media-body ">
                                    <h2 class="information-details-box__title"><?php echo e(Str::limit($provider->company_name, 30)); ?></h2>

                                    <ul class="contact-list">
                                        <li>
                                            <span class="material-symbols-outlined">phone_iphone</span>
                                            <a href="tel:<?php echo e($provider->company_phone); ?>"><?php echo e($provider->company_phone); ?></a>
                                        </li>
                                        <li>
                                            <span class="material-symbols-outlined">mail</span>
                                            <a href="mailto:<?php echo e($provider->company_email); ?>"><?php echo e($provider->company_email); ?></a>
                                        </li>
                                        <li>
                                            <span class="material-symbols-outlined">map</span>
                                            <?php echo e(Str::limit($provider->company_address, 100)); ?>

                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="information-details-box h-100">
                                <h2 class="information-details-box__title c1"><?php echo e(translate('Contact_Person_Information')); ?>

                                </h2>
                                <h3 class="information-details-box__subtitle"><?php echo e(Str::limit($provider->contact_person_name, 30)); ?></h3>

                                <ul class="contact-list">
                                    <li>
                                        <span class="material-symbols-outlined">phone_iphone</span>
                                        <a href="tel:<?php echo e($provider->contact_person_phone); ?>"><?php echo e($provider->contact_person_phone); ?></a>
                                    </li>
                                    <li>
                                        <span class="material-symbols-outlined">mail</span>
                                        <a href="mailto:<?php echo e($provider->contact_person_email); ?>"><?php echo e($provider->contact_person_email); ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="information-details-box">
                                <div class="row g-4">
                                    <div class="col-lg-3">
                                        <h2 class="information-details-box__title c1 mb-3"><?php echo e(translate('Business_Info')); ?>

                                        </h2>
                                        <p><strong
                                                class="text-capitalize"><?php echo e(translate($provider->owner->identification_type)); ?>

                                                -</strong> <?php echo e($provider->owner->identification_number); ?></p>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="d-flex flex-wrap gap-3 justify-content-lg-end">
                                            <?php $__currentLoopData = $provider->owner->identification_image_full_path; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <img class="max-w320" src="<?php echo e($image); ?>" alt="<?php echo e(translate('image')); ?>">
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
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

    <script src="<?php echo e(asset('public/assets/provider-module')); ?>/plugins/apex/apexcharts.min.js"></script>

    <script>
        "use strict";

        var options = {
            labels: ['accepted', 'ongoing', 'completed', 'canceled'],
            series: <?php echo e(json_encode($total)); ?>,
            chart: {
                width: 235,
                height: 160,
                type: 'donut',
            },
            dataLabels: {
                enabled: false
            },
            title: {
                text: "<?php echo e($provider->bookings_count); ?> Bookings",
                align: 'center',
                offsetX: 0,
                offsetY: 58,
                floating: true,
                style: {
                    fontSize: '12px',
                    fontWeight: 600,
                },
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    legend: {
                        show: true
                    }
                }
            }],
            legend: {
                position: 'bottom',
                offsetY: -5,
                height: 30,
            },
        };

        var chart = new ApexCharts(document.querySelector("#apex-pie-chart"), options);
        chart.render();

        $('.provider_approval').on('click', function () {
            let itemId = $(this).data('approve');
            let route = '<?php echo e(route('admin.provider.update-approval', ['id' => ':itemId', 'status' => 'deny'])); ?>';
            route = route.replace(':itemId', itemId);
            route_alert_reload(route, '<?php echo e(translate('want_to_deny_the_provider')); ?>');
        });

        $('.approval_provider').on('click', function () {
            let itemId = $(this).data('approve');
            let route = '<?php echo e(route('admin.provider.update-approval', ['id' => ':itemId', 'status' => 'approve'])); ?>';
            route = route.replace(':itemId', itemId);
            route_alert_reload(route, '<?php echo e(translate('want_to_approve_the_provider')); ?>');
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/ProviderManagement/Resources/views/admin/provider/detail/overview.blade.php ENDPATH**/ ?>