<?php $__env->startSection('title',translate('bonus_list')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module/plugins/dataTables/jquery.dataTables.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module/plugins/dataTables/select.dataTables.min.css')); ?>"/>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-wrap d-flex justify-content-between flex-wrap align-items-center gap-3 mb-3">
                        <h2 class="page-title"><?php echo e(translate('bonus_list')); ?></h2>
                        <div class="d-flex gap-3 justify-content-end text-primary fw-bold">
                            <?php echo e(translate('How_it_Works')); ?>

                            <i class="material-icons" data-bs-toggle="tooltip" title="Info" id="hoverButton">info</i>
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
                            <span class="opacity-75"><?php echo e(translate('total_bonuses')); ?>:</span>
                            <span class="title-color"><?php echo e($bonuses->total()); ?></span>
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

                                        <div class="d-flex flex-wrap align-items-center gap-3">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bonus_export')): ?>
                                                <div class="dropdown">
                                                    <button type="button"
                                                            class="btn btn--secondary text-capitalize dropdown-toggle"
                                                            data-bs-toggle="dropdown">
                                                        <span class="material-icons">file_download</span> download
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                           href="<?php echo e(route('admin.bonus.download')); ?>?search=<?php echo e($search); ?>">
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
                                                <th><?php echo e(translate('bonus_Title')); ?></th>
                                                <th><?php echo e(translate('bonus_Info')); ?></th>
                                                <th><?php echo e(translate('bonus_Amount')); ?></th>
                                                <th><?php echo e(translate('started_On')); ?></th>
                                                <th><?php echo e(translate('expires_On')); ?></th>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bonus_manage_status')): ?>
                                                    <th><?php echo e(translate('status')); ?></th>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['bonus_delete', 'bonus_update'])): ?>
                                                    <th><?php echo e(translate('action')); ?></th>
                                                <?php endif; ?>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $__currentLoopData = $bonuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $bonus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($bonuses->firstitem()+$key); ?></td>
                                                    <td>
                                                        <?php echo e($bonus?->bonus_title ?? ''); ?>

                                                    </td>
                                                    <td>
                                                        <p><?php echo e(translate('minimum_Add_Amount')); ?>

                                                            - <?php echo e($bonus?->minimum_add_amount ?? 0); ?></p>
                                                        <?php if($bonus->bonus_amount_type == 'percent'): ?>
                                                            <p><?php echo e(translate('minimum_Bonus')); ?>

                                                                - <?php echo e($bonus?->maximum_bonus_amount ?? 0); ?></p>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo e($bonus->bonus_amount_type == 'percent' ? $bonus->bonus_amount . '%' : currency_symbol() . $bonus->bonus_amount); ?>

                                                    </td>
                                                    <td>
                                                        <?php echo e($bonus?->start_date ?? ''); ?>

                                                    </td>
                                                    <td>
                                                        <?php echo e($bonus?->end_date ?? ''); ?>

                                                    </td>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bonus_manage_status')): ?>
                                                        <td>
                                                            <label class="switcher mx-auto" data-bs-toggle="modal"
                                                                   data-bs-target="#deactivateAlertModal">
                                                                <input class="switcher_input"
                                                                       type="checkbox"
                                                                       <?php echo e($bonus->is_active?'checked':''); ?> data-status="<?php echo e($bonus->id); ?>">
                                                                <span class="switcher_control"></span>
                                                            </label>
                                                        </td>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['bonus_delete', 'bonus_update'])): ?>
                                                        <td>
                                                            <div class="d-flex gap-2">
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bonus_update')): ?>
                                                                    <a href="<?php echo e(route('admin.bonus.edit',[$bonus->id])); ?>"
                                                                       class="action-btn btn--light-primary"
                                                                       style="--size: 30px">
                                                                        <span class="material-icons">edit</span>
                                                                    </a>
                                                                <?php endif; ?>
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bonus_delete')): ?>
                                                                    <button type="button" data-delete="<?php echo e($bonus->id); ?>"
                                                                            class="action-btn btn--danger"
                                                                            style="--size: 30px">
                                                                    <span
                                                                        class="material-symbols-outlined">delete</span>
                                                                    </button>
                                                                <?php endif; ?>
                                                            </div>
                                                            <form
                                                                action="<?php echo e(route('admin.bonus.delete',[$bonus->id])); ?>"
                                                                method="post" id="delete-<?php echo e($bonus->id); ?>"
                                                                class="hidden">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('DELETE'); ?>
                                                            </form>
                                                        </td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <?php echo $bonuses->links(); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addFundModal" tabindex="-1" aria-labelledby="addFundModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-xl-5 text-center">
                    <img width="80" class="mb-4 pb-3" src="<?php echo e(asset('public/assets/admin-module/img/add_fund.png')); ?>"
                         alt="">
                    <h4 class="mb-3"><?php echo e(translate('Wallet bonus is only applicable when a customer add fund to wallet via outside
                        payment gateway ')); ?>!</h4>
                    <p><?php echo e(translate('Customer will get extra amount to his')); ?>

                        / <?php echo e(translate('her wallet additionally with the amount he')); ?> / <?php echo e(translate('she added
                        from other payment gateways. The bonus amount will consider as admin expense')); ?></p>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('public/assets/admin-module/plugins/select2/select2.min.js')); ?>"></script>
    <script>
        "use strict"
        $(document).ready(function () {
            $('.js-select').select2();

            $('#hoverButton').hover(function () {
                $('#addFundModal').modal('show');
            });
        });

        $('.switcher_input').on('click', function () {
            let itemId = $(this).data('status');
            let route = '<?php echo e(route('admin.bonus.status-update', ['id' => ':itemId'])); ?>';
            route = route.replace(':itemId', itemId);
            route_alert(route, '<?php echo e(translate('want_to_update_status')); ?>');
        })

        $('.action-btn.btn--danger').on('click', function () {
            let itemId = $(this).data('delete');
            <?php if(env('APP_ENV')!='demo'): ?>
            form_alert('delete-' + itemId, '<?php echo e(translate('want_to_delete_this')); ?>?')
            <?php endif; ?>
        })
    </script>
    <script src="<?php echo e(asset('public/assets/admin-module/plugins/dataTables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/admin-module/plugins/dataTables/dataTables.select.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/PaymentModule/Resources/views/admin/bonus/list.blade.php ENDPATH**/ ?>