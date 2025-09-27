<?php $__env->startSection('title',translate('onboarding_requests')); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-title-wrap mb-3">
                <h2 class="page-title"><?php echo e(translate('Onboarding_Request')); ?></h2>
            </div>

            <div
                class="d-flex flex-wrap justify-content-between align-items-center border-bottom mx-lg-4 mb-10 gap-3">
                <ul class="nav nav--tabs">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($status=='onboarding'?'active':''); ?>"
                           href="<?php echo e(url()->current()); ?>?status=onboarding">
                            <?php echo e(translate('Onboarding_Requests')); ?>

                            <sup class="c2-bg py-1 px-2 radius-50 text-white"><?php echo e($providersCount['onboarding']); ?></sup>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($status=='denied'?'active':''); ?>"
                           href="<?php echo e(url()->current()); ?>?status=denied">
                            <?php echo e(translate('Denied_Requests')); ?>

                            <sup class="c2-bg py-1 px-2 radius-50 text-white"><?php echo e($providersCount['denied']); ?></sup>
                        </a>
                    </li>
                </ul>

                <div class="d-flex gap-2 fw-medium">
                    <span class="opacity-75"><?php echo e(translate('Total_Requests')); ?>:</span>
                    <span class="title-color"><?php echo e($providers->total()); ?></span>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between">
                        <form action="<?php echo e(url()->current()); ?>"
                              class="search-form search-form_style-two"
                              method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="input-group search-form__input_group">
                                            <span class="search-form__icon">
                                                <span class="material-icons">search</span>
                                            </span>
                                <input type="search" class="theme-input-style search-form__input"
                                       value="<?php echo e($search??''); ?>" name="search"
                                       placeholder="<?php echo e(translate('search_here')); ?>">
                            </div>
                            <button type="submit" class="btn btn--primary">
                                <?php echo e(translate('search')); ?>

                            </button>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table id="example" class="table align-middle">
                            <thead>
                            <tr>
                                <th><?php echo e(translate('SL')); ?></th>
                                <th><?php echo e(translate('Provider')); ?></th>
                                <th><?php echo e(translate('Contact_Info')); ?></th>
                                <th><?php echo e(translate('Zone')); ?></th>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('onboarding_request_approve_or_deny')): ?>
                                    <th class="text-center"><?php echo e(translate('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($providers->firstitem()+$key); ?></td>
                                    <td>
                                        <a class="media align-items-center gap-2"
                                           href="<?php echo e(route('admin.provider.onboarding_details',[$provider->id])); ?>">
                                            <img class="avatar avatar-lg radius-5"
                                                 alt="<?php echo e(translate('image')); ?>"
                                                 src="<?php echo e($provider->logo_full_path); ?>">
                                            <h5 class="media-body">
                                                <?php echo e(Str::limit($provider->company_name, 30)); ?>

                                            </h5>
                                        </a>
                                    </td>
                                    <td>
                                        <div>
                                            <h5 class="mb-2"><?php echo e($provider->contact_person_name); ?></h5>
                                            <a class="d-flex fz-12"
                                               href="tel:<?php echo e($provider->contact_person_phone); ?>"><?php echo e($provider->contact_person_phone); ?></a>
                                            <a class="d-flex fz-12"
                                               href="mailto:<?php echo e($provider->contact_person_email); ?>"><?php echo e($provider->contact_person_email); ?></a>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if($provider->zone): ?>
                                            <?php echo e($provider->zone->name); ?>

                                        <?php else: ?>
                                            <div
                                                class="fz-12 badge badge-danger opacity-50"><?php echo e(translate('Zone is not available')); ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('onboarding_request_approve_or_deny')): ?>
                                        <td>
                                            <div class="table-actions justify-content-center">
                                                <?php if($provider->is_approved != 0): ?>
                                                    <a type="button"
                                                       class="btn btn-soft--danger text-capitalize provider_approval"
                                                       id="button-deny-<?php echo e($provider->id); ?>"
                                                       data-approve="<?php echo e($provider->id); ?>"
                                                       data-status="deny">
                                                        <?php echo e(translate('Deny')); ?>

                                                    </a>
                                                <?php endif; ?>
                                                <a type="button"
                                                   class="btn btn--success text-capitalize approval_provider"
                                                   id="button-<?php echo e($provider->id); ?>" data-approve="<?php echo e($provider->id); ?>"
                                                   data-approve="approve">
                                                    <?php echo e(translate('Accept')); ?>

                                                </a>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        <?php echo $providers->links(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        "use strict";

        $('.provider_approval').on('click', function () {
            let itemId = $(this).data('approve');
            let route = '<?php echo e(route('admin.provider.update-approval', ['id' => ':itemId', 'status' => 'deny'])); ?>';
            route = route.replace(':itemId', itemId);
            route_alert_reload(route, '<?php echo e(translate('want_to_deny_the_provider')); ?>', true);
        });

        $('.approval_provider').on('click', function () {
            let itemId = $(this).data('approve');
            let route = '<?php echo e(route('admin.provider.update-approval', ['id' => ':itemId', 'status' => 'approve'])); ?>';
            route = route.replace(':itemId', itemId);
            route_alert_reload(route, '<?php echo e(translate('want_to_approve_the_provider')); ?>', true);
        });

    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/ProviderManagement/Resources/views/admin/provider/onboarding.blade.php ENDPATH**/ ?>