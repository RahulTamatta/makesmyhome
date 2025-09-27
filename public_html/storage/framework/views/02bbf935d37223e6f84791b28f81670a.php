<?php $__env->startSection('title',translate('campaigns')); ?>

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
                        <h2 class="page-title"><?php echo e(translate('campaigns')); ?></h2>
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
                            <span class="opacity-75"><?php echo e(translate('Total_Campaigns')); ?>:</span>
                            <span class="title-color"><?php echo e($campaigns->total()); ?></span>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="all-tab-pane">
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
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('campaign_view')): ?>
                                                <div class="dropdown">
                                                    <button type="button"
                                                            class="btn btn--secondary text-capitalize dropdown-toggle"
                                                            data-bs-toggle="dropdown">
                                                    <span
                                                        class="material-icons">file_download</span> <?php echo e(translate('download')); ?>

                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                           href="<?php echo e(route('admin.campaign.download')); ?>?search=<?php echo e($search); ?>">
                                                            <?php echo e(translate('excel')); ?>

                                                        </a>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="example" class="table align-middle">
                                            <thead class="text-nowrap">
                                            <tr>
                                                <th><?php echo e(translate('Sl')); ?></th>
                                                <th><?php echo e(translate('campaign_name')); ?></th>
                                                <th><?php echo e(translate('discount_type')); ?></th>
                                                <th><?php echo e(translate('discount_title')); ?></th>
                                                <th><?php echo e(translate('Applicable On')); ?></th>
                                                <th><?php echo e(translate('zones')); ?></th>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('campaign_manage_status')): ?>
                                                    <th><?php echo e(translate('status')); ?>

                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['campaign_delete', 'campaign_update'])): ?>
                                                    <th><?php echo e(translate('action')); ?></th>
                                                <?php endif; ?>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($key+$campaigns->firstItem()); ?></td>
                                                    <td><?php echo e($item->campaign_name); ?></td>
                                                    <td><?php echo e($item->discount->discount_type); ?></td>
                                                    <td><?php echo e($item->discount->discount_title); ?></td>
                                                    <td>
                                                        <?php if($item->discount->discount_type == 'category'): ?>
                                                            <?php if($item->discount->category_types && count($item->discount->category_types) > 0): ?>
                                                                <b><?php echo e(translate('Category') . ' : '); ?></b>
                                                                <?php $__currentLoopData = $item->discount->category_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <span
                                                                        class="opacity-75"><?php echo e($type->category?$type->category->name:''); ?></span>
                                                                    <?php echo e($key < count($item->discount->category_types)-1 ? ',' : null); ?>

                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        <?php elseif($item->discount->discount_type == 'service'): ?>
                                                            <?php if($item->discount->category_types && $item->discount->service_types): ?>
                                                                <br/>
                                                            <?php endif; ?>

                                                            <?php if($item->discount->service_types && count($item->discount->service_types) > 0): ?>
                                                                <b><?php echo e(translate('Service') . ' : '); ?></b>
                                                                <?php $__currentLoopData = $item->discount->service_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php if($type->service): ?>
                                                                        <a href="<?php echo e(route('admin.service.detail',[$type->service->id])); ?>"
                                                                           class="opacity-75"><?php echo e($type->service->name); ?></a>
                                                                        <?php echo e($key < count($item->discount->service_types)-1 ? ',' : null); ?>

                                                                    <?php endif; ?>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                            <?php if($item->discount->category_types && count($item->discount->category_types) > 0): ?>
                                                                <b><?php echo e(translate('Category') . ' : '); ?></b>
                                                                <?php $__currentLoopData = $item->discount->category_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <span
                                                                        class="opacity-75"><?php echo e($type->category?$type->category->name:''); ?></span>
                                                                    <?php echo e($key < count($item->discount->category_types)-1 ? ',' : null); ?>

                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>

                                                            <?php if($item->discount->category_types && $item->discount->service_types): ?>
                                                                <br/>
                                                            <?php endif; ?>

                                                            <?php if($item->discount->service_types && count($item->discount->service_types) > 0): ?>
                                                                <b><?php echo e(translate('Service') . ' : '); ?></b>
                                                                <?php $__currentLoopData = $item->discount->service_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php if($type->service): ?>
                                                                        <a href="<?php echo e(route('admin.service.detail',[$type->service->id])); ?>"
                                                                           class="opacity-75"><?php echo e($type->service->name); ?></a>
                                                                        <?php echo e($key < count($item->discount->service_types)-1 ? ',' : null); ?>

                                                                    <?php endif; ?>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php $__currentLoopData = $item->discount->zone_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php echo e($type->zone?$type->zone->name.',':''); ?>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </td>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('campaign_manage_status')): ?>
                                                        <td>
                                                            <label class="switcher">
                                                                <input class="switcher_input"
                                                                       data-status="<?php echo e($item->id); ?>"
                                                                       type="checkbox" <?php echo e($item->is_active?'checked':''); ?>>
                                                                <span class="switcher_control"></span>
                                                            </label>
                                                        </td>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['campaign_delete', 'campaign_update'])): ?>
                                                        <td>
                                                            <div class="d-flex gap-2">
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('campaign_update')): ?>
                                                                    <a href="<?php echo e(route('admin.campaign.edit',[$item->id])); ?>"
                                                                       class="action-btn btn--light-primary"
                                                                       style="--size: 30px">
                                                                        <span class="material-icons">edit</span>
                                                                    </a>
                                                                <?php endif; ?>
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('campaign_delete')): ?>
                                                                    <button type="button"
                                                                            data-id="<?php echo e($item->id); ?>"
                                                                            class="action-btn btn--danger delete_section"
                                                                            style="--size: 30px">
                                                                    <span
                                                                        class="material-symbols-outlined">delete</span>
                                                                    </button>
                                                                    <form
                                                                        action="<?php echo e(route('admin.campaign.delete',[$item->id])); ?>"
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
                                        <?php echo $campaigns->links(); ?>

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
        "use Strict";

        $('.switcher_input').on('click', function () {
            let itemId = $(this).data('status');
            let route = '<?php echo e(route('admin.campaign.status-update', ['id' => ':itemId'])); ?>';
            route = route.replace(':itemId', itemId);
            route_alert_reload(route, '<?php echo e(translate('want_to_update_status')); ?>');
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

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/PromotionManagement/Resources/views/admin/campaigns/list.blade.php ENDPATH**/ ?>