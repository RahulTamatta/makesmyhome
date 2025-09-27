<?php $__env->startSection('title',translate('notification_setup')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/select2/select2.min.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/select.dataTables.min.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/swiper/swiper-bundle.min.css"/>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-title-wrap d-flex justify-content-between align-items-center mb-3">
                <div class="">
                    <h2 class="page-title"><?php echo e(translate('Notification Channels Setup')); ?></h2>
                    <p class="mt-1">
                        <?php echo e(translate('From here Admins can configure which notifications users receive and through which channels (e.g., Email, SMS, Push notification)')); ?>

                    </p>
                </div>
            </div>
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-3">
                <ul class="nav nav--tabs nav--tabs__style2">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->get('notification_type') == 'provider' ? 'active' : ''); ?>" href="<?php echo e(url()->current()); ?>?notification_type=provider">
                            Provider
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->get('notification_type') == 'serviceman' ? 'active' : ''); ?>" href="<?php echo e(url()->current()); ?>?notification_type=serviceman">
                            Serviceman
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between align-items-center">
                        <div class="d-flex gap-2 fw-medium me-auto">

                        </div>
                        <form action="<?php echo e(url()->current()); ?>" class="search-form search-form_style-two" method="get">
                            <div class="input-group search-form__input_group">
                            <span class="search-form__icon">
                                <span class="material-icons">search</span>
                            </span>
                                <input type="search" class="theme-input-style search-form__input" name="search" value="<?php echo e(request()->search); ?>" placeholder="<?php echo e(translate('search_here')); ?>">
                            </div>
                            <input type="hidden" name="notification_type" value="<?php echo e(request()->get('notification_type')); ?>">

                            <button type="submit" class="btn btn--primary"><?php echo e(translate('search')); ?></button>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="text-nowrap">
                            <tr>
                                <th><?php echo e(translate('Sl')); ?></th>
                                <th><?php echo e(translate('Topics')); ?></th>
                                <th><?php echo e(translate('Push Notification')); ?></th>
                                <th><?php echo e(translate('Mail')); ?></th>
                                <th><?php echo e(translate('SMS')); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $notificationSetup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $adminSettings = json_decode($notification->value);
                                    $providerSettings = $notification->providerNotifications->first();
                                    $providerSettings = $providerSettings ? json_decode($providerSettings->value) : null;

                                    $email = $providerSettings->email ?? $adminSettings->email;
                                    $notificationSetting = $providerSettings->notification ?? $adminSettings->notification;
                                    $sms = $providerSettings->sms ?? $adminSettings->sms;
                                ?>
                                <tr>
                                    <td><?php echo e($key+1); ?></td>
                                    <td class="py-3">
                                        <h5 class="mb-1"><?php echo e(translate($notification->title)); ?></h5>
                                        <p class="text-secondary"><?php echo e(translate($notification->sub_title)); ?></p>
                                    </td>
                                    <td>
                                        <?php if(is_null($adminSettings->notification)): ?>
                                            N/A
                                        <?php else: ?>
                                            <label class="switcher">
                                                <input class="switcher_input"
                                                       data-id="<?php echo e($notification->id); ?>"
                                                       data-type="notification"
                                                       type="checkbox"
                                                    <?php echo e($notificationSetting && $adminSettings->notification != 0 ? 'checked' : ''); ?>

                                                    <?php echo e($adminSettings->notification == 0 ? 'disabled' : ''); ?>>
                                                <span class="switcher_control"></span>
                                            </label>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if(is_null($adminSettings->email)): ?>
                                            N/A
                                        <?php else: ?>
                                            <label class="switcher">
                                                <input class="switcher_input" data-id="<?php echo e($notification->id); ?>" data-type="email" type="checkbox" <?php echo e($email && $adminSettings->email != 0  ? 'checked' : ''); ?> <?php echo e($adminSettings->email == 0 ? 'disabled': ''); ?>>
                                                <span class="switcher_control"></span>
                                            </label>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if(is_null($adminSettings->sms)): ?>
                                            N/A
                                        <?php else: ?>
                                            <label class="switcher">
                                                <input class="switcher_input" data-id="<?php echo e($notification->id); ?>" data-type="sms" type="checkbox" <?php echo e($sms && $adminSettings->sms != 0 ? 'checked' : ''); ?> <?php echo e($adminSettings->sms == 0 ? 'disabled': ''); ?>>
                                                <span class="switcher_control"></span>
                                            </label>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        $(document).ready(function() {
            $('.switcher_input').change(function() {
                var notificationId = $(this).data('id');
                var type = $(this).data('type');
                var status = $(this).is(':checked') ? 1 : 0;

                $.ajax({
                    url: '<?php echo e(route("provider.configuration.updateProviderNotification")); ?>',
                    type: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        notification_id: notificationId,
                        type: type,
                        status: status
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success('<?php echo e(translate('successfully_updated')); ?>')
                        } else {
                            toastr.error('<?php echo e(translate('something worng')); ?>')
                        }
                    }
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('providermanagement::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/BusinessSettingsModule/Resources/views/provider/notification.blade.php ENDPATH**/ ?>