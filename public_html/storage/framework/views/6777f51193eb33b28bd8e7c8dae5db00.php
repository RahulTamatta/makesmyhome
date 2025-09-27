<?php $__env->startSection('title',translate('coupons')); ?>

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
                        <h2 class="page-title"><?php echo e(translate('coupons')); ?></h2>
                    </div>

                    <div
                        class="d-flex flex-wrap justify-content-between align-items-center border-bottom mx-lg-4 mb-10 gap-3">
                        <ul class="nav nav--tabs">
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($discountType=='all'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?discount_type=all">
                                    <?php echo e(translate('all')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($discountType=='service'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?discount_type=service">
                                    <?php echo e(translate('service_wise')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($discountType=='category'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?discount_type=category">
                                    <?php echo e(translate('category_wise')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($discountType=='mixed'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?discount_type=mixed">
                                    <?php echo e(translate('mixed')); ?>

                                </a>
                            </li>
                        </ul>

                        <div class="d-flex gap-2 fw-medium">
                            <span class="opacity-75"><?php echo e(translate('Total_Coupons')); ?>:</span>
                            <span class="title-color"><?php echo e($coupons->total()); ?></span>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between">
                                <form action="<?php echo e(url()->current()); ?>?discount_type=<?php echo e($discountType); ?>"
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

                                <div class="d-flex flex-wrap align-items-center gap-3">
                                    <div class="dropdown">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('coupon_export')): ?>
                                            <button type="button"
                                                    class="btn btn--secondary text-capitalize dropdown-toggle"
                                                    data-bs-toggle="dropdown">
                                            <span
                                                class="material-icons">file_download</span> <?php echo e(translate('download')); ?>

                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                                <a class="dropdown-item"
                                                   href="<?php echo e(route('admin.coupon.download')); ?>?search=<?php echo e($search); ?>">
                                                    <?php echo e(translate('excel')); ?>

                                                </a>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="example" class="table align-middle">
                                    <thead class="text-nowrap">
                                    <tr>
                                        <th><?php echo e(translate('SL')); ?></th>
                                        <th><?php echo e(translate('title')); ?></th>
                                        <th><?php echo e(translate('coupon_type')); ?></th>
                                        <th><?php echo e(translate('coupon_code')); ?></th>
                                        <th><?php echo e(translate('discount_type')); ?></th>
                                        <th><?php echo e(translate('zones')); ?></th>
                                        <th><?php echo e(translate('Limit_per_user')); ?></th>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('coupon_manage_status')): ?>
                                            <th><?php echo e(translate('status')); ?></th>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['coupon_delete', 'coupon_update'])): ?>
                                            <th><?php echo e(translate('action')); ?></th>
                                        <?php endif; ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($coupons->firstitem()+$key); ?></td>
                                            <td><?php echo e($item->discount->discount_title); ?></td>
                                            <td><?php echo e(str_replace('_',' ',$item->coupon_type)); ?></td>
                                            <td><?php echo e($item->coupon_code); ?></td>
                                            <td><?php echo e($item->discount->discount_type); ?></td>
                                            <td>
                                                <?php $__currentLoopData = $item->discount->zone_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php echo e($type->zone?$type->zone->name.',':''); ?>

                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </td>
                                            <td><?php echo e($item->discount?->limit_per_user); ?></td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('coupon_manage_status')): ?>
                                                <td>

                                                    <label class="switcher">
                                                        <input class="switcher_input"
                                                               data-status="<?php echo e($item->id); ?>"
                                                               type="checkbox" <?php echo e($item->is_active?'checked':''); ?>>
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                </td>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['coupon_delete', 'coupon_update'])): ?>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('coupon_update')): ?>
                                                            <a href="<?php echo e(route('admin.coupon.edit',[$item->id])); ?>"
                                                               class="action-btn btn--light-primary"
                                                               style="--size: 30px">
                                                                <span class="material-icons">edit</span>
                                                            </a>
                                                        <?php endif; ?>
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('coupon_delete')): ?>
                                                            <button type="button" data-id="<?php echo e($item->id); ?>"
                                                                    class="action-btn btn--danger  delete_section"
                                                                    style="--size: 30px">
                                                                <span class="material-symbols-outlined">delete</span>
                                                            </button>
                                                            <form action="<?php echo e(route('admin.coupon.delete',[$item->id])); ?>"
                                                                  method="post" id="delete-<?php echo e($item->id); ?>"
                                                                  class="hidden">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('DELETE'); ?>
                                                            </form>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                <?php echo $coupons->links(); ?>

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
        "use Strict";

        $('.switcher_input').on('click', function () {
            let itemId = $(this).data('status');
            let route = '<?php echo e(route('admin.coupon.status-update', ['id' => ':itemId'])); ?>';
            route = route.replace(':itemId', itemId);
            route_alert(route, '<?php echo e(translate('want_to_update_status')); ?>');
        })

        $('.delete_section').on('click', function () {
            let itemId = $(this).data('id');
            form_alert('delete-' + itemId, '<?php echo e(translate('want_to_delete_this')); ?>');
        })

        $(document).ready(function () {
            $('.js-select').select2();
        });
    </script>
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/jquery.dataTables.min.js"></script>
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/dataTables.select.min.js"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/PromotionManagement/Resources/views/admin/coupons/list.blade.php ENDPATH**/ ?>