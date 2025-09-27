<?php $__env->startSection('title',translate('customer_list')); ?>

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
                        <h2 class="page-title"><?php echo e(translate('customer_list')); ?></h2>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer_add')): ?>
                            <div>
                                <a href="<?php echo e(route('admin.customer.create')); ?>" class="btn btn--primary">
                                    <span class="material-icons">add</span>
                                    <?php echo e(translate('add_customer')); ?>

                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="mb-3 fz-16"><?php echo e(translate('Search_Filter')); ?></div>

                            <form action="<?php echo e(url()->current()); ?>" method="GET">
                                <div class="row">
                                    <input type="hidden" name="search" value="<?php echo e(array_key_exists('search', $queryParam)?$queryParam['search']:''); ?>">
                                    <div class="col-lg-3 col-sm-6" id="from-filter__div">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="from" name="from" value="<?php echo e(array_key_exists('from', $queryParam)?$queryParam['from']:''); ?>">
                                            <label for="from"><?php echo e(translate('start_date')); ?></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6" id="to-filter__div">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="to" name="to" value="<?php echo e(array_key_exists('to', $queryParam)?$queryParam['to']:''); ?>">
                                            <label for="to"><?php echo e(translate('end_date')); ?></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="form-floating">
                                            <select class="js-select" name="sort_by">
                                                <option value="" selected><?php echo e(translate('Select option')); ?></option>
                                                <option value="latest" <?php echo e(array_key_exists('sort_by', $queryParam) && $queryParam['sort_by'] == 'latest' ? 'selected' : ''); ?>><?php echo e(translate('latest')); ?></option>
                                                <option value="oldest" <?php echo e(array_key_exists('sort_by', $queryParam) && $queryParam['sort_by'] == 'oldest' ? 'selected' : ''); ?>><?php echo e(translate('oldest')); ?></option>
                                                <option value="ascending" <?php echo e(array_key_exists('sort_by', $queryParam) && $queryParam['sort_by'] == 'ascending' ? 'selected' : ''); ?>><?php echo e(translate('ascending')); ?></option>
                                                <option value="descending" <?php echo e(array_key_exists('sort_by', $queryParam) && $queryParam['sort_by'] == 'descending' ? 'selected' : ''); ?>><?php echo e(translate('descending')); ?></option>
                                            </select>
                                            <label class="mb-2"><?php echo e(translate('sort_by')); ?></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-sm-6">
                                        <div class="form-floating">
                                            <input class="form-control" type="number" name="limit" value="<?php echo e(array_key_exists('limit', $queryParam)?$queryParam['limit']:''); ?>">
                                            <label class="mb-2"><?php echo e(translate('choose_first')); ?></label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="status" value="<?php echo e($status); ?>">

                                    <div class="col-12 d-flex justify-content-end mt-3">
                                        <button type="submit" class="btn btn--primary btn-sm"><?php echo e(translate('filter')); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap justify-content-between align-items-center border-bottom mx-lg-4 mb-10 gap-3">
                        <?php
                            $baseQuery = $queryParam;
                        ?>

                        <ul class="nav nav--tabs">
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($status == 'all' ? 'active' : ''); ?>"
                                   href="<?php echo e(url()->current() . '?' . http_build_query(array_merge($baseQuery, ['status' => 'all']))); ?>">
                                    <?php echo e(translate('all')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($status == 'active' ? 'active' : ''); ?>"
                                   href="<?php echo e(url()->current() . '?' . http_build_query(array_merge($baseQuery, ['status' => 'active']))); ?>">
                                    <?php echo e(translate('active')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($status == 'inactive' ? 'active' : ''); ?>"
                                   href="<?php echo e(url()->current() . '?' . http_build_query(array_merge($baseQuery, ['status' => 'inactive']))); ?>">
                                    <?php echo e(translate('inactive')); ?>

                                </a>
                            </li>
                        </ul>
                        <div class="d-flex gap-2 fw-medium">
                            <span class="opacity-75"><?php echo e(translate('Total_Customers')); ?>:</span>
                            <span class="title-color"><?php echo e($customers->total()); ?></span>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="all-tab-pane">
                            <div class="card">
                                <div class="card-body">
                                    <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between">
                                        <form action="<?php echo e(url()->current()); ?>?status=<?php echo e($status); ?>"
                                              class="search-form search-form_style-two"
                                              method="GET">
                                            <div class="input-group search-form__input_group">
                                            <span class="search-form__icon">
                                                <span class="material-icons">search</span>
                                            </span>
                                                <input type="search" class="theme-input-style search-form__input"
                                                       value="<?php echo e($search); ?>" name="search"
                                                       placeholder="<?php echo e(translate('search_here')); ?>">
                                            </div>

                                            <!-- Preserve all other filters -->
                                            <input type="hidden" name="from" value="<?php echo e($queryParam['from'] ?? ''); ?>">
                                            <input type="hidden" name="to" value="<?php echo e($queryParam['to'] ?? ''); ?>">
                                            <input type="hidden" name="sort_by" value="<?php echo e($queryParam['sort_by'] ?? ''); ?>">
                                            <input type="hidden" name="limit" value="<?php echo e($queryParam['limit'] ?? ''); ?>">
                                            <input type="hidden" name="status" value="<?php echo e($queryParam['status'] ?? ''); ?>">

                                            <button type="submit"
                                                    class="btn btn--primary"><?php echo e(translate('search')); ?></button>
                                        </form>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer_export')): ?>
                                            <div class="d-flex flex-wrap align-items-center gap-3">
                                                <div class="dropdown">
                                                    <button type="button"
                                                            class="btn btn--secondary text-capitalize dropdown-toggle"
                                                            data-bs-toggle="dropdown">
                                                        <span class="material-icons">file_download</span> download
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                                        <li>
                                                            <a class="dropdown-item"
                                                               href="<?php echo e(env('APP_ENV') !='demo' ?route('admin.customer.download', '?search='. ($queryParam['search'] ?? '') .
                                                                         '&from='. ($queryParam['from'] ?? '') .
                                                                         '&to='. ($queryParam['to'] ?? '') .
                                                                         '&limit='. ($queryParam['limit'] ?? '') .
                                                                         '&status='. ($queryParam['status'] ?? '') .
                                                                         '&sort_by='. ($queryParam['sort_by'] ?? '') ).'?search='.$search:'javascript:demo_mode()'); ?>">
                                                                <?php echo e(translate('excel')); ?>

                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="example" class="table align-middle">
                                            <thead>
                                            <tr>
                                                <th><?php echo e(translate('Sl')); ?></th>
                                                <th><?php echo e(translate('Customer_Name')); ?></th>
                                                <th class="text-center"><?php echo e(translate('Contact_Info')); ?></th>
                                                <th class="text-center"><?php echo e(translate('Total_Bookings')); ?></th>
                                                <th class="text-center"><?php echo e(translate('Joined')); ?></th>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer_manage_status')): ?>
                                                    <th class="text-center"><?php echo e(translate('status')); ?></th>
                                                <?php endif; ?>
                                                <th class="text-center"><?php echo e(translate('action')); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                $count= 0;
                                            ?>

                                            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e((request()->get('limit') ?  $count++ : $key  )+ $customers->firstItem()); ?></td>
                                                    <td>
                                                        <a href="<?php echo e(route('admin.customer.detail',[$customer->id, 'web_page'=>'overview'])); ?>">
                                                            <?php echo e($customer->first_name); ?> <?php echo e($customer->last_name); ?>

                                                        </a>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column align-items-center gap-1">
                                                            <?php if(env('APP_ENV')=='demo'): ?>
                                                                <label class="badge badge-primary">
                                                                    <?php echo e(translate('protected')); ?>

                                                                </label>
                                                            <?php else: ?>
                                                                <a href="mailto:<?php echo e($customer->email); ?>"
                                                                   class="fz-12 fw-medium">
                                                                    <?php echo e($customer->email); ?>

                                                                </a>
                                                                <a href="tel:<?php echo e($customer->phone); ?>"
                                                                   class="fz-12 fw-medium">
                                                                    <?php echo e($customer->phone); ?>

                                                                </a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                    <td class="text-center"><?php echo e($customer->bookings_count); ?></td>
                                                    <td class="text-center"><?php echo e(date('d M, Y',strtotime($customer->created_at))); ?></td>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer_manage_status')): ?>
                                                        <td>
                                                            <label class="switcher mx-auto" data-bs-toggle="modal"
                                                                   data-bs-target="#deactivateAlertModal">
                                                                <input class="switcher_input"
                                                                       type="checkbox"
                                                                       <?php echo e($customer->is_active?'checked':''); ?> data-status="<?php echo e($customer->id); ?>">
                                                                <span class="switcher_control"></span>
                                                            </label>
                                                        </td>
                                                    <?php endif; ?>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer_update')): ?>
                                                                <a href="<?php echo e(env('APP_ENV') !='demo' ?route('admin.customer.edit',[$customer->id]):'javascript:demo_mode()'); ?>"
                                                                   class="action-btn btn--light-primary"
                                                                   style="--size: 30px">
                                                                    <span class="material-icons">edit</span>
                                                                </a>
                                                            <?php endif; ?>
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer_delete')): ?>
                                                                <button type="button" data-delete="<?php echo e($customer->id); ?>"
                                                                        data-id="delete-<?php echo e($customer->id); ?>"
                                                                        data-message="<?php echo e(translate('want_to_delete_this_customer')); ?>?"
                                                                        class="action-btn btn--danger <?php echo e(env('APP_ENV') != 'demo' ? 'form-alert' : 'demo_check'); ?>"
                                                                        style="--size: 30px">
                                                                    <span
                                                                        class="material-symbols-outlined">delete</span>
                                                                </button>
                                                            <?php endif; ?>
                                                            <a href="<?php echo e(route('admin.customer.detail',[$customer->id, 'web_page'=>'overview'])); ?>"
                                                               class="action-btn btn--light-primary"
                                                               style="--size: 30px">
                                                                <span class="material-icons">visibility</span>
                                                            </a>
                                                        </div>
                                                        <form
                                                            action="<?php echo e(route('admin.customer.delete',[$customer->id])); ?>"
                                                            method="post" id="delete-<?php echo e($customer->id); ?>" class="hidden">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <?php echo $customers->links(); ?>

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

        $('.switcher_input').on('click', function () {
            let itemId = $(this).data('status');
            let route = '<?php echo e(route('admin.customer.status-update', ['id' => ':itemId'])); ?>';
            route = route.replace(':itemId', itemId);
            route_alert(route, '<?php echo e(translate('want_to_update_status')); ?>');
        })
    </script>
    <script src="<?php echo e(asset('public/assets/admin-module/plugins/dataTables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/admin-module/plugins/dataTables/dataTables.select.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/CustomerModule/Resources/views/admin/list.blade.php ENDPATH**/ ?>