<?php $__env->startSection('title',translate('business_settings')); ?>

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
                        <h2 class="page-title"><?php echo e(translate('business_settings')); ?></h2>
                    </div>

                    <div class="mb-3">
                        <ul class="nav nav--tabs nav--tabs__style2">
                            <li class="nav-item">
                                <a href="<?php echo e(url()->current()); ?>?web_page=service_availability"
                                   class="nav-link <?php echo e($webPage=='service_availability'?'active':''); ?>">
                                    <?php echo e(translate('Service Availability')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url()->current()); ?>?web_page=bookings"
                                   class="nav-link <?php echo e($webPage=='bookings'?'active':''); ?>">
                                    <?php echo e(translate('bookings')); ?>

                                </a>
                            </li>
                        </ul>
                    </div>

                    <?php if($webPage=='service_availability'): ?>
                        <div class="tab-content">
                            <div class="tab-pane fade <?php echo e($webPage=='service_availability'?'active show':''); ?>">
                                <div class="card mb-3">
                                    <div class="card-body p-30">
                                        <div
                                            class="border border-primary rounded d-flex justify-content-between p-3 align-items-center">
                                            <div
                                                class="text-capitalize text-primary"><?php echo e(translate('Service Availability Mode')); ?></div>
                                            <label class="switcher m-0">
                                                <input class="switcher_input service-availability"
                                                       type="checkbox" <?php echo e(Auth::user()->provider->service_availability == '1' ? 'checked' : ''); ?>>
                                                <span class="switcher_control"></span>
                                            </label>
                                        </div>
                                        <span
                                            class="mt-2 d-block">* <?php echo e(translate('By turning off availability mode, you will not get any new booking request from customers and customer will that you are currently unavailable  to provide service')); ?> </span>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="subtitle text-body">
                                            <span class="material-icons translate-y-4px">event_note</span>
                                            <span
                                                class="mb-2"><?php echo e(translate('Service Provider Availability Schedules')); ?></span>
                                            <i class="material-icons px-1 translate-y-4px" data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="<?php echo e(translate('Using the current time slot, the system shows your availability to customers in app & web, enabling them to make successful bookings')); ?>">info</i>
                                        </h5>
                                    </div>
                                    <div class="card-body p-30">
                                        <form action="<?php echo e(route('provider.business-settings.availability-schedule')); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>

                                            <div class="__schedule-item">
                                                <div class="subtitle">
                                                    <?php echo e(translate('Service Providing Time')); ?>

                                                </div>
                                                <div class="__schedule-area">
                                                    <div class="clock">
                                                        <div class="clock__item">
                                                            <div class="clock__item__title">
                                                                <?php echo e(translate('From')); ?>

                                                            </div>
                                                            <div class="clock__item__input">
                                                                <input type="time" name="start_time" class="form-control" value="<?php echo e(isset($timeSchedule['start_time']) ? $timeSchedule['start_time'] : ''); ?>">
                                                            </div>
                                                        </div>
                                                        <div class="clock__item">
                                                            <div class="clock__item__title">
                                                                <?php echo e(translate('Till')); ?>

                                                            </div>
                                                            <div class="clock__item__input">
                                                                <input type="time" name="end_time" class="form-control" value="<?php echo e(isset($timeSchedule['end_time']) ? $timeSchedule['end_time'] : ''); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr class="__border"/>

                                            <div class="__schedule-item">
                                                <div class="subtitle">
                                                    <?php echo e(translate('Weekend')); ?>

                                                </div>
                                                <div class="__schedule-area">
                                                    <div class="d-flex flex-wrap gap-2">
                                                        <?php $__currentLoopData = ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <label class="form-check m-0 me-xl-3">
                                                                <input type="checkbox" class="form-check-input" name="day[]" value="<?php echo e($day); ?>" <?php echo e(in_array($day, $weekEnds ?? []) ? 'checked' : ''); ?>>
                                                                <span class="form-check-label"><?php echo e(translate(ucfirst($day))); ?></span>
                                                            </label>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex gap-2 justify-content-end mt-4">
                                                <button type="reset" class="btn btn-secondary"><?php echo e(translate('reset')); ?>

                                                </button>
                                                <button type="submit" class="btn btn--primary"><?php echo e(translate('update')); ?>

                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($webPage=='bookings'): ?>
                        <div class="tab-content">
                            <div class="tab-pane fade <?php echo e($webPage=='bookings'?'active show':''); ?>">
                                <div class="card">
                                    <div class="card-body p-30">
                                        <form action="<?php echo e(route('provider.business-settings.set-business-information')); ?>"
                                              method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <div class="row g-4">
                                                <?php ($servicemanCanBookingCancel = collect([ ['key' => 'provider_serviceman_can_cancel_booking','info_message' => 'Service Men Can Cancel Booking', 'title' => 'Cancel Booking Req'] ])); ?>
                                                <?php ($servicemanCanBookingEdit = collect([ ['key' => 'provider_serviceman_can_edit_booking','info_message' => 'Service Men Can Edit Booking', 'title' => 'Edit Booking Req'] ])); ?>

                                                <div class="col-md-6 col-12">
                                                    <div class="border p-3 rounded d-flex justify-content-between">
                                                        <div>
                                                            <span
                                                                class="text-capitalize"><?php echo e(translate($servicemanCanBookingCancel[0]['title'])); ?></span>
                                                            <i class="material-icons px-1" data-bs-toggle="tooltip"
                                                               data-bs-placement="top"
                                                               title="<?php echo e(translate($servicemanCanBookingCancel[0]['info_message'] ?? '')); ?>"
                                                            >info</i>
                                                        </div>
                                                        <label class="switcher">
                                                            <?php ($value = $dataValues->where('key_name', $servicemanCanBookingCancel[0]['key'])->where('settings_type', 'serviceman_config')->where('provider_id', $providerId)?->first()?->live_values ?? null); ?>
                                                            <input class="switcher_input switcher-btn"
                                                                   id="<?php echo e($servicemanCanBookingCancel[0]['key']); ?>"
                                                                   type="checkbox"
                                                                   name="<?php echo e($servicemanCanBookingCancel[0]['key']); ?>"
                                                                   value="1" <?php echo e($value ? 'checked' : ''); ?>

                                                                   data-id="<?php echo e($servicemanCanBookingCancel[0]['key']); ?>"
                                                                   data-message="<?php echo e(ucfirst(translate($servicemanCanBookingCancel[0]['key']))); ?>">
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="border p-3 rounded d-flex justify-content-between">
                                                        <div>
                                                            <span
                                                                class="text-capitalize"><?php echo e(translate($servicemanCanBookingEdit[0]['title'])); ?></span>
                                                            <i class="material-icons px-1" data-bs-toggle="tooltip"
                                                               data-bs-placement="top"
                                                               title="<?php echo e(translate($servicemanCanBookingEdit[0]['info_message'] ?? '')); ?>"
                                                            >info</i>
                                                        </div>
                                                        <label class="switcher">
                                                            <?php ($value = $dataValues->where('key_name', $servicemanCanBookingEdit[0]['key'])->where('settings_type', 'serviceman_config')->where('provider_id', $providerId)?->first()?->live_values ?? null); ?>
                                                            <input class="switcher_input switcher-btn"
                                                                   id="<?php echo e($servicemanCanBookingEdit[0]['key']); ?>"
                                                                   type="checkbox"
                                                                   name="<?php echo e($servicemanCanBookingEdit[0]['key']); ?>"
                                                                   value="1" <?php echo e($value ? 'checked' : ''); ?>

                                                                   data-id="<?php echo e($servicemanCanBookingEdit[0]['key']); ?>"
                                                                   data-message="<?php echo e(ucfirst(translate($servicemanCanBookingEdit[0]['key']))); ?>">
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php ($serviceAtProviderPlace = (int)((business_config('service_at_provider_place', 'provider_config'))->live_values ?? 0)); ?>
                                                <?php if($serviceAtProviderPlace): ?>
                                                    <div class="col-12">
                                                        <div class="p-3 rounded bg-light">
                                                            <div class="mb-3">
                                                                <h4 class="text-capitalize mb-1"><?php echo e(translate('Service Location')); ?></h4>
                                                                <p class="text-muted">
                                                                    <?php echo e(translate('Here you setup where you want to provide services at your business location or customer location')); ?>

                                                                </p>
                                                            </div>
                                                            <div class="p-3">
                                                                <div class="row border rounded p-3">
                                                                    <div class="col-md-6">
                                                                        <div class="custom-control custom-checkbox mr-4">
                                                                            <input type="checkbox" class="custom-control-input service-location" name="customer_location" id="customer_location"
                                                                                <?php echo e(in_array('customer', $serviceLocations) ? 'checked' : ''); ?>>
                                                                            <label class="custom-control-label font-weight-bold mb-1" for="customer_location">
                                                                                <?php echo e(translate('Customer Location')); ?>

                                                                            </label>
                                                                            <p class="text-muted mb-0 pl-20"><?php echo e(translate('By checking this option you will be able to provide service at customer location')); ?></p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input service-location" name="provider_location" id="provider_location"
                                                                                <?php echo e(in_array('provider', $serviceLocations) ? 'checked' : ''); ?>>
                                                                            <label class="custom-control-label font-weight-bold mb-1" for="provider_location">
                                                                                <?php echo e(translate('My Location')); ?>

                                                                            </label>
                                                                            <p class="text-muted mb-0 pl-20"><?php echo e(translate('By checking this option you will be able to provide service at your business location')); ?></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <div class="d-flex gap-2 justify-content-end mt-4">
                                                <button type="reset" class="btn btn-secondary"><?php echo e(translate('reset')); ?>

                                                </button>
                                                <button type="submit" class="btn btn--primary"><?php echo e(translate('update')); ?>

                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
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
        "use strict";

        $('.switcher-btn').on('click', function () {
            let id = $(this).data('id');
            let status = $(this).is(':checked') === true ? 1 : 0;
            let message = $(this).data('message');
            switch_alert(id, status, message)
        });

        $('.service-availability').on('click', function () {
            <?php if(env('APP_ENV')!='demo'): ?>
                updateAvailability($(this).is(':checked')===true?1:0)
            <?php endif; ?>
        });

        function switch_alert(id, status, message) {
            Swal.fire({
                title: "<?php echo e(translate('are_you_sure')); ?>?",
                text: message,
                type: 'warning',
                showDenyButton: true,
                showCancelButton: true,
                denyButtonColor: 'var(--c2)',
                confirmButtonColor: 'var(--c1)',
                confirmButtonText: 'Save',
                denyButtonText: `Don't save`,
            }).then((result) => {
                if (result.value) {
                } else {
                    if (status === 1) $(`#${id}`).prop('checked', false);
                    if (status === 0) $(`#${id}`).prop('checked', true);

                    Swal.fire('<?php echo e(translate('Changes are not saved')); ?>', '', 'info')
                }
            })
        }

        function updateAvailability(status) {
            Swal.fire({
                title: "<?php echo e(translate('are_you_sure')); ?>?",
                text: '<?php echo e(translate('want_to_update_status')); ?>',
                type: 'warning',
                showCloseButton: true,
                showCancelButton: true,
                cancelButtonColor: 'var(--c2)',
                confirmButtonColor: 'var(--c1)',
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "<?php echo e(route('provider.business-settings.availability-status')); ?>",
                        data: {
                            service_availability: status,
                        },
                        type: 'put',
                        success: function (response) {
                            toastr.success('<?php echo e(translate('successfully_updated')); ?>')
                        },
                        error: function () {

                        }
                    });
                }
            })
        }

        $(document).ready(function () {
            $('.js-select').select2();
        });

        $(document).ready(function () {
            $('.service-location').on('change', function () {
                let customerChecked = $('#customer_location').is(':checked');
                let providerChecked = $('#provider_location').is(':checked');

                if (!customerChecked && !providerChecked) {
                    // Prevent unchecking both
                    $(this).prop('checked', true);
                    toastr.error('At least one service location must be selected.');
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('providermanagement::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/BusinessSettingsModule/Resources/views/provider/business.blade.php ENDPATH**/ ?>