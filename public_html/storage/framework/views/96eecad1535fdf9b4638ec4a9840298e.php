<?php $__env->startSection('title',translate('Serviceman_List')); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap mb-3">
                        <h2 class="page-title"><?php echo e(translate('Serviceman_List')); ?></h2>
                    </div>

                    <div
                        class="d-flex flex-wrap justify-content-between align-items-center border-bottom mx-lg-4 mb-10 gap-3">
                        <ul class="nav nav--tabs">
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($status=='all'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?status=all"><?php echo e(translate('All')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($status=='active'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?status=active"><?php echo e(translate('Active')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($status=='inactive'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?status=inactive"><?php echo e(translate('Inactive')); ?></a>
                            </li>
                        </ul>

                        <div class="d-flex gap-2 fw-medium">
                            <span class="opacity-75"><?php echo e(translate('Total_Serviceman')); ?>:</span>
                            <span class="title-color"><?php echo e($servicemen->total()); ?></span>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="">
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
                                            <button type="submit" class="btn btn--primary"><?php echo e(translate('search')); ?></button>
                                        </form>

                                        <div class="d-flex flex-wrap align-items-center gap-3">
                                            <div class="dropdown">
                                                <button type="button"
                                                        class="btn btn--secondary text-capitalize dropdown-toggle"
                                                        data-bs-toggle="dropdown">
                                                    <span
                                                        class="material-icons">file_download</span> <?php echo e(translate('download')); ?>

                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                                    <li>
                                                        <a class="dropdown-item" href="<?php echo e(route('provider.serviceman.download',['status' => $status, 'search'=>$search])); ?>">
                                                            <?php echo e(translate('excel')); ?>

                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="example" class="table align-middle">
                                            <thead>
                                            <tr>
                                                <th><?php echo e(translate('SL')); ?></th>
                                                <th><?php echo e(translate('Name')); ?></th>
                                                <th><?php echo e(translate('Contact_Info')); ?></th>
                                                <th><?php echo e(translate('Status')); ?></th>
                                                <th><?php echo e(translate('Action')); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $__currentLoopData = $servicemen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$serviceman): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($servicemen->firstitem()+$key); ?></td>
                                                    <td>
                                                        <a href="<?php echo e(route('provider.serviceman.show', [$serviceman->serviceman->id])); ?>">
                                                            <?php echo e(Str::limit($serviceman->first_name, 25)); ?> <?php echo e(Str::limit($serviceman->last_name, 15)); ?>

                                                        </a>
                                                    </td>
                                                    <td>
                                                        <?php echo e($serviceman->email); ?> <br/>
                                                        <?php echo e($serviceman->phone); ?>

                                                    </td>
                                                    <td>
                                                        <label class="switcher">
                                                            <input class="switcher_input route-alert"
                                                                   data-route="<?php echo e(route('provider.serviceman.status-update',[$serviceman->id])); ?>"
                                                                   data-message="<?php echo e(translate('want_to_update_status')); ?>"
                                                                   type="checkbox" <?php echo e($serviceman->is_active?'checked':''); ?>>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="table-actions">
                                                            <a href="<?php echo e(route('provider.serviceman.edit', [$serviceman->serviceman->id])); ?>"
                                                               class="action-btn btn--light-primary fw-medium text-capitalize fz-14" style="--size: 30px">
                                                                <span class="material-icons">edit</span>
                                                            </a>
                                                            <a href="<?php echo e(route('provider.serviceman.show', [$serviceman->serviceman->id])); ?>"
                                                               class="action-btn btn--light-primary" style="--size: 30px">
                                                                <span class="material-icons">visibility</span>
                                                            </a>
                                                            <button type="button"
                                                                    data-id="delete-<?php echo e($serviceman->serviceman->id); ?>"
                                                                    data-message="<?php echo e(translate('want_to_delete_this_serviceman')); ?>?"
                                                                    class="action-btn btn--danger form-alert" style="--size: 30px">
                                                                <span class="material-symbols-outlined">delete</span>
                                                            </button>
                                                            <form
                                                                action="<?php echo e(route('provider.serviceman.delete', [$serviceman->serviceman->id])); ?>"
                                                                method="post"
                                                                id="delete-<?php echo e($serviceman->serviceman->id); ?>"
                                                                class="hidden">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('DELETE'); ?>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <?php echo $servicemen->links(); ?>

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

<?php echo $__env->make('providermanagement::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/ServicemanModule/Resources/views/Provider/Serviceman/list.blade.php ENDPATH**/ ?>