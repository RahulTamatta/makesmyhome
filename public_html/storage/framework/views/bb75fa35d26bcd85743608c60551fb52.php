<?php $__env->startSection('title',translate('withdrawal_method_list')); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-wrap d-flex justify-content-between flex-wrap align-items-center gap-3 mb-3">
                        <h2 class="page-title"><?php echo e(translate('Withdrawal_method_List')); ?></h2>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('withdraw_add')): ?>
                            <a href="<?php echo e(route('admin.withdraw.method.create')); ?>"
                               class="btn btn--primary">+ <?php echo e(translate('Add_method')); ?></a>
                        <?php endif; ?>
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
                                            <thead class="text-nowrap">
                                            <tr>
                                                <th><?php echo e(translate('SL')); ?></th>
                                                <th><?php echo e(translate('Method_name')); ?></th>
                                                <th><?php echo e(translate('Method_Fields')); ?></th>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('withdraw_manage_status')): ?>
                                                    <th><?php echo e(translate('Active_Status')); ?></th>
                                                    <th><?php echo e(translate('Default_Method')); ?></th>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['withdraw_delete', 'withdraw_update'])): ?>
                                                    <th><?php echo e(translate('Action')); ?></th>
                                                <?php endif; ?>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $__currentLoopData = $withdrawalMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$withdrawalMethod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($withdrawalMethods->firstitem()+$key); ?></td>
                                                    <td><?php echo e($withdrawalMethod['method_name']); ?></td>
                                                    <td>
                                                        <?php $__currentLoopData = $withdrawalMethod['method_fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$methodField): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <span
                                                                class="badge badge-success opacity-75 fz-12 border border-white">
                                                            <b><?php echo e(translate('Name')); ?>:</b> <?php echo e(translate($methodField['input_name'])); ?> |
                                                            <b><?php echo e(translate('Type')); ?>:</b> <?php echo e($methodField['input_type']); ?> |
                                                            <b><?php echo e(translate('Placeholder')); ?>:</b> <?php echo e($methodField['placeholder']); ?> |
                                                            <b><?php echo e(translate('Is Required')); ?>:</b> <?php echo e($methodField['is_required'] ? translate('yes') : translate('no')); ?>

                                                        </span><br/>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </td>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('withdraw_manage_status')): ?>
                                                        <td>
                                                            <label class="switcher">
                                                                <input class="switcher_input route-alert-reload"
                                                                       data-route="<?php echo e(route('admin.withdraw.method.status-update',[$withdrawalMethod->id])); ?>"
                                                                       data-message="<?php echo e(translate('want_to_update_status')); ?>"
                                                                       type="checkbox" <?php echo e($withdrawalMethod->is_active?'checked':''); ?>>
                                                                <span class="switcher_control"></span>
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <label class="switcher">
                                                                <input class="switcher_input route-alert-reload"
                                                                       data-route="<?php echo e(route('admin.withdraw.method.default-status-update',[$withdrawalMethod->id])); ?>"
                                                                       data-message="<?php echo e(translate('want_to_make_default_method')); ?>"
                                                                       type="checkbox" <?php echo e($withdrawalMethod->is_default?'checked':''); ?>>
                                                                <span class="switcher_control"></span>
                                                            </label>
                                                        </td>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['withdraw_delete', 'withdraw_update'])): ?>
                                                        <td>
                                                            <div class="d-flex gap-2">
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('withdraw_update')): ?>
                                                                    <a href="<?php echo e(route('admin.withdraw.method.edit',[$withdrawalMethod->id])); ?>"
                                                                       class="action-btn btn--light-primary demo_check"
                                                                       style="--size: 30px">
                                                                        <span class="material-icons">edit</span>
                                                                    </a>
                                                                <?php endif; ?>

                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('withdraw_delete')): ?>
                                                                    <?php if(!$withdrawalMethod->is_default): ?>
                                                                        <button type="button"
                                                                                class="action-btn btn--danger demo_check form-alert"
                                                                                style="--size: 30px"
                                                                                data-id="delete-<?php echo e($withdrawalMethod->id); ?>"
                                                                                data-message="<?php echo e(translate('want_to_delete_this_method')); ?>?"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#deleteAlertModal"
                                                                        >
                                                                    <span
                                                                        class="material-symbols-outlined">delete</span>
                                                                        </button>
                                                                        <form
                                                                            action="<?php echo e(route('admin.withdraw.method.delete',[$withdrawalMethod->id])); ?>"
                                                                            method="post"
                                                                            id="delete-<?php echo e($withdrawalMethod->id); ?>"
                                                                            class="hidden">
                                                                            <?php echo csrf_field(); ?>
                                                                            <?php echo method_field('DELETE'); ?>
                                                                        </form>
                                                                    <?php endif; ?>
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
                                        <?php echo $withdrawalMethods->links(); ?>

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


<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/TransactionModule/Resources/views/admin/withdraw/method/list.blade.php ENDPATH**/ ?>