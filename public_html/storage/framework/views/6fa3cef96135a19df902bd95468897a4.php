<?php $__env->startSection('title',translate('service_list')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/select.dataTables.min.css"/>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-wrap d-flex justify-content-between flex-wrap align-items-center gap-3 mb-3">
                        <h2 class="page-title"><?php echo e(translate('service_list')); ?></h2>
                        <div>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('service_add')): ?>
                                <a href="<?php echo e(route('admin.service.create')); ?>" class="btn btn--primary">
                                    <span class="material-icons">add</span>
                                    <?php echo e(translate('add_service')); ?>

                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div
                        class="d-flex flex-wrap justify-content-between align-items-center border-bottom mx-lg-4 mb-10 gap-3">
                        <ul class="nav nav--tabs">
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($status=='all'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?status=all">
                                    <?php echo e(translate('all')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($status=='active'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?status=active">
                                    <?php echo e(translate('active')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($status=='inactive'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?status=inactive">
                                    <?php echo e(translate('inactive')); ?>

                                </a>
                            </li>
                        </ul>

                        <div class="d-flex gap-2 fw-medium">
                            <span class="opacity-75"><?php echo e(translate('Total_Services')); ?>:</span>
                            <span class="title-color"><?php echo e($services->total()); ?></span>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="all-tab-pane">
                            <div class="card">
                                <div class="card-body">
                                    <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between">
                                        <form action="<?php echo e(url()->current()); ?>?status=<?php echo e($status); ?>"
                                              class="search-form search-form_style-two"
                                              method="POST">
                                            <?php echo csrf_field(); ?>
                                            <div class="input-group search-form__input_group">
                                            <span class="search-form__icon">
                                                <span class="material-icons">search</span>
                                            </span>
                                                <input type="search" class="theme-input-style search-form__input"
                                                       value="<?php echo e($search); ?>" name="search"
                                                       placeholder="<?php echo e(translate('search_here')); ?>">
                                            </div>
                                            <button type="submit"
                                                    class="btn btn--primary"><?php echo e(translate('search')); ?></button>
                                        </form>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="example" class="table align-middle">
                                            <thead>
                                            <tr>
                                                <th><?php echo e(translate('SL')); ?></th>
                                                <th><?php echo e(translate('name')); ?></th>
                                                <th><?php echo e(translate('category')); ?></th>
                                                <th><?php echo e(translate('zones')); ?></th>
                                                <th><?php echo e(translate('Minimum Bidding Price')); ?></th>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('service_manage_status')): ?>
                                                    <th><?php echo e(translate('status')); ?></th>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['service_delete', 'service_update'])): ?>
                                                    <th><?php echo e(translate('action')); ?></th>
                                                <?php endif; ?>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr>
                                                    <td><?php echo e($services->firstitem()+$key); ?></td>
                                                    <td>
                                                        <a href="<?php echo e(route('admin.service.detail',[$service->id])); ?>">
                                                            <?php echo e(Str::limit($service->name, 50)); ?>

                                                        </a>
                                                    </td>
                                                    <td>
                                                        <?php if($service->category): ?>
                                                            <?php echo e($service->category->name); ?>

                                                        <?php else: ?>
                                                            <div class="d-flex">
                                                                <span><?php echo e(translate('Unavailable')); ?></span>
                                                                <i class="material-icons" data-bs-toggle="tooltip"
                                                                   data-bs-placement="top"
                                                                   title="<?php echo e(translate('Update the service category')); ?>">info
                                                                </i>
                                                            </div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if($service->category): ?>
                                                            <?php if(count($service->category->zonesBasicInfo) > 0): ?>
                                                             <?php echo e(implode(', ',$service->category->zonesBasicInfo->pluck('name')->toArray())); ?>

                                                            <?php else: ?>
                                                                <i class="material-icons" data-bs-toggle="tooltip"
                                                                   data-bs-placement="top"
                                                                   title="<?php echo e(translate('This category is not under any zone. Kindly update the category with zone')); ?>">info
                                                                </i>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo e(with_currency_symbol($service->min_bidding_price)); ?>


                                                        <?php if($service->min_bidding_price == 0): ?>
                                                            <i class="text-warning material-icons px-1"
                                                               data-bs-toggle="tooltip" data-bs-placement="top"
                                                               title="<?php echo e(translate('Update the minimum bidding price')); ?>"
                                                            >warning</i>
                                                        <?php endif; ?>
                                                    </td>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('service_manage_status')): ?>
                                                        <td>
                                                            <label class="switcher" data-bs-toggle="modal"
                                                                   data-bs-target="#deactivateAlertModal">
                                                                <input class="switcher_input route-alert"
                                                                       data-route="<?php echo e(route('admin.service.status-update',[$service->id])); ?>"
                                                                       data-message="<?php echo e(translate('want_to_update_status')); ?>"
                                                                       type="checkbox" <?php echo e($service->is_active?'checked':''); ?>>
                                                                <span class="switcher_control"></span>
                                                            </label>
                                                        </td>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['service_delete', 'service_update'])): ?>
                                                        <td>
                                                            <div class="d-flex gap-2">
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('service_update')): ?>
                                                                    <a href="<?php echo e(route('admin.service.edit',[$service->id])); ?>"
                                                                       class="action-btn btn--light-primary demo_check"
                                                                       style="--size: 30px">
                                                                        <span class="material-icons">edit</span>
                                                                    </a>
                                                                <?php endif; ?>
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('service_delete')): ?>
                                                                    <button type="button"
                                                                            data-id="delete-<?php echo e($service->id); ?>"
                                                                            data-message="<?php echo e(translate('want_to_delete_this_service')); ?>?"
                                                                            class="action-btn btn--danger <?php echo e(env('APP_ENV')!='demo' ? 'form-alert' : 'demo_check'); ?>"
                                                                            style="--size: 30px">
                                                                    <span
                                                                        class="material-symbols-outlined">delete</span>
                                                                    </button>
                                                                    <form
                                                                        action="<?php echo e(route('admin.service.delete',[$service->id])); ?>"
                                                                        method="post" id="delete-<?php echo e($service->id); ?>"
                                                                        class="hidden">
                                                                        <?php echo csrf_field(); ?>
                                                                        <?php echo method_field('DELETE'); ?>
                                                                    </form>
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr class="text-center">
                                                    <td colspan="8"><?php echo e(translate('no data available')); ?></td>
                                                </tr>
                                            <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <?php echo $services->links(); ?>

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
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/select2/select2.min.js"></script>
    <script>
        "use strict"

        $(document).ready(function () {
            $('.js-select').select2();
        });
    </script>
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/jquery.dataTables.min.js"></script>
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/dataTables.select.min.js"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/ServiceManagement/Resources/views/admin/list.blade.php ENDPATH**/ ?>