<?php $__env->startSection('title',translate('provider_details')); ?>

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

            <div class="card mb-30">
                <div class="card-body p-30">
                    <form action="<?php echo e(route('admin.provider.commission_update', [$provider->id])); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3"><?php echo e(translate('Commission_Settings')); ?></div>
                        <div class="d-flex flex-wrap align-items-center gap-4 mb-30">
                            <div class="custom-radio">
                                <input type="radio" name="commission_status" id="default_commission"
                                       value="default" <?php echo e($provider->commission_status == 0 ? 'checked' : ''); ?>>
                                <label for="default_commission"><?php echo e(translate('Use Default')); ?></label>
                            </div>
                            <div class="custom-radio">
                                <input type="radio" name="commission_status" id="custom_commission"
                                       value="custom" <?php echo e($provider->commission_status == 1 ? 'checked' : ''); ?>>
                                <label for="custom_commission"><?php echo e(translate('Set_Custom_Commission')); ?></label>
                            </div>
                        </div>

                        <div class="form-floating <?php echo e($provider->commission_status == 0 ? 'd-none' : ''); ?>"
                             id="percentage">
                            <input type="number" min="0" max="100" step="any" class="form-control"
                                   placeholder="<?php echo e(translate('Percentage')); ?>"
                                   id="percentage__input" name="custom_commission_value"
                                   value="<?php echo e($provider->commission_percentage); ?>"
                                <?php echo e($provider->commission_status == 1 ? 'required' : ''); ?>>
                            <label><?php echo e(translate('Percentage')); ?></label>
                        </div>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('provider_manage_status')): ?>
                            <div class="d-flex justify-content-end mt-30">
                                <button type="submit" class="btn btn--primary"><?php echo e(translate('Save')); ?></button>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>

    <script>
        "use strict";

        $('#default_commission').click(function () {
            if ($('#default_commission').is(':checked')) {
                $('#percentage').addClass('d-none');
                $('#percentage__input').removeAttr('required');
            }
        });

        $('#custom_commission').click(function () {
            if ($('#custom_commission').is(':checked')) {
                $('#percentage').removeClass('d-none');
                $('#percentage__input').prop('required', true);
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/ProviderManagement/Resources/views/admin/provider/detail/settings.blade.php ENDPATH**/ ?>