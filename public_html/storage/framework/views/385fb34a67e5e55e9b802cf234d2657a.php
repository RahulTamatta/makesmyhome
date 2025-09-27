<?php $__env->startSection('title',translate('newsletter_list')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module/plugins/dataTables/jquery.dataTables.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module/plugins/dataTables/select.dataTables.min.css')); ?>"/>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap d-flex justify-content-between flex-wrap align-items-center gap-3 mb-3">
                        <h2 class="page-title"><?php echo e(translate('subscriber_list')); ?></h2>
                    </div>

                    <div class="card">
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

                                    <div class="col-12 d-flex justify-content-end mt-3">
                                        <button type="submit" class="btn btn--primary btn-sm"><?php echo e(translate('filter')); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap justify-content-between align-items-center border-bottom mb-10 gap-3 mt-4">
                        <h4 class="page-title mb-2"><?php echo e(translate('mail_list')); ?></h4>
                        <div class="d-flex gap-2 fw-medium mb-2">
                            <span class="opacity-75"><?php echo e(translate('Total_Subscribers')); ?>:</span>
                            <span class="title-color"><?php echo e($newsletters->total()); ?></span>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="all-tab-pane">
                            <div class="card">
                                <div class="card-body">
                                    <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between">
                                        <form action="<?php echo e(url()->current()); ?>"
                                              class="search-form search-form_style-two"
                                              method="GET">
                                            <div class="input-group search-form__input_group">
                                                <span class="search-form__icon">
                                                    <span class="material-icons">search</span>
                                                </span>
                                                <input type="search" class="theme-input-style search-form__input"
                                                       value="<?php echo e(array_key_exists('search', $queryParam)?$queryParam['search']:''); ?>" name="search"
                                                       placeholder="<?php echo e(translate('search_here')); ?>">
                                            </div>

                                            <!-- Preserve all other filters -->
                                            <input type="hidden" name="from" value="<?php echo e($queryParam['from'] ?? ''); ?>">
                                            <input type="hidden" name="to" value="<?php echo e($queryParam['to'] ?? ''); ?>">
                                            <input type="hidden" name="sort_by" value="<?php echo e($queryParam['sort_by'] ?? ''); ?>">
                                            <input type="hidden" name="limit" value="<?php echo e($queryParam['limit'] ?? ''); ?>">

                                            <button type="submit" class="btn btn--primary"><?php echo e(translate('search')); ?></button>
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
                                                               href="<?php echo e(env('APP_ENV') !='demo' ? route('admin.customer.newsletter.download').
                                                                         '?search='. ($queryParam['search'] ?? '') .
                                                                         '&from='. ($queryParam['from'] ?? '') .
                                                                         '&to='. ($queryParam['to'] ?? '') .
                                                                         '&limit='. ($queryParam['limit'] ?? '') .
                                                                         '&sort_by='. ($queryParam['sort_by'] ?? '') : 'javascript:demo_mode()'); ?>">
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
                                                <th><?php echo e(translate('email')); ?></th>
                                                <th><?php echo e(translate('subscribe_at')); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                                $count= 0;
                                            ?>

                                            <?php $__empty_1 = true; $__currentLoopData = $newsletters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $newsletter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr>
                                                    <td><?php echo e((request()->get('limit') ?  $count++ : $key  )+ $newsletters->firstItem()); ?></td>
                                                    <td><a href="mailto:<?php echo e($newsletter->email); ?>"><?php echo e($newsletter->email); ?></a></td>
                                                    <td><?php echo e(date('d M Y h:i A ', strtotime($newsletter->created_at))); ?></td>
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
                                        <?php echo $newsletters->links(); ?>

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
    <script src="<?php echo e(asset('public/assets/admin-module/plugins/dataTables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/admin-module/plugins/dataTables/dataTables.select.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/CustomerModule/Resources/views/admin/newsletter/list.blade.php ENDPATH**/ ?>