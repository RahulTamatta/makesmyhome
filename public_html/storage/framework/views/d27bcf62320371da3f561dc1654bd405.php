<?php $__env->startSection('title',translate('transaction_list')); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-wrap d-flex justify-content-between flex-wrap align-items-center gap-3 mb-3">
                        <h2 class="page-title"><?php echo e(translate('transaction_list')); ?></h2>
                    </div>

                    <div
                        class="d-flex flex-wrap justify-content-between align-items-center border-bottom mx-lg-4 mb-10 gap-3">
                        <ul class="nav nav--tabs">
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($trxType=='all'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?trx_type=all">
                                    <?php echo e(translate('all')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($trxType=='debit'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?trx_type=debit">
                                    <?php echo e(translate('debit')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($trxType=='credit'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?trx_type=credit   ">
                                    <?php echo e(translate('credit')); ?>

                                </a>
                            </li>
                        </ul>

                        <div class="d-flex gap-2 fw-medium">
                            <span class="opacity-75"><?php echo e(translate('Total_Transactions')); ?>:</span>
                            <span class="title-color"><?php echo e($transactions->total()); ?></span>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="all-tab-pane">
                            <div class="card">
                                <div class="card-body">
                                    <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between">
                                        <form action="<?php echo e(url()->current()); ?>?trx_type=<?php echo e($trxType); ?>"
                                              class="search-form search-form_style-two"
                                              method="POST">
                                            <?php echo csrf_field(); ?>
                                            <div class="input-group search-form__input_group">
                                            <span class="search-form__icon">
                                                <span class="material-icons">search</span>
                                            </span>
                                                <input type="search" class="theme-input-style search-form__input"
                                                       value="<?php echo e($search); ?>" name="search"
                                                       placeholder="<?php echo e(translate('search_by_trx_id')); ?>">
                                            </div>
                                            <button type="submit"
                                                    class="btn btn--primary"><?php echo e(translate('search')); ?></button>
                                        </form>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transaction_export')): ?>
                                            <div class="d-flex flex-wrap align-items-center gap-3">
                                                <div class="dropdown">
                                                    <button type="button"
                                                            class="btn btn--secondary text-capitalize dropdown-toggle"
                                                            data-bs-toggle="dropdown">
                                                        <span
                                                            class="material-icons">file_download</span> <?php echo e(translate('download')); ?>

                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                           href="<?php echo e(route('admin.transaction.download')); ?>?search=<?php echo e($search); ?>&trx_type=<?php echo e($trxType); ?>">
                                                            <?php echo e(translate('excel')); ?>

                                                        </a>
                                                    </ul>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="example" class="table align-middle">
                                            <thead class="text-nowrap">
                                            <tr>
                                                <th><?php echo e(translate('Sl')); ?></th>
                                                <th><?php echo e(translate('Transaction_ID')); ?></th>
                                                <th><?php echo e(translate('Transaction_Date')); ?></th>
                                                <th><?php echo e(translate('Transaction_From')); ?></th>
                                                <th><?php echo e(translate('Transaction_To')); ?></th>
                                                <th><?php echo e(translate('Transaction Type')); ?></th>
                                                <th><?php echo e(translate('Debit')); ?></th>
                                                <th><?php echo e(translate('Credit')); ?></th>
                                                <th><?php echo e(translate('Balance')); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr>
                                                    <td><?php echo e($key+$transactions->firstItem()); ?></td>
                                                    <td><?php echo e($transaction->id); ?></td>
                                                    <td><?php echo e(date('d-M-y H:iA', strtotime($transaction->created_at))); ?></td>
                                                    <td>
                                                        <?php if($transaction?->from_user?->provider): ?>
                                                            <?php echo e(Str::limit($transaction->from_user->provider->company_name, 30)); ?>

                                                            <br/>
                                                            <small
                                                                class="opacity-75"><?php echo e(translate($transaction?->from_user_account)); ?></small>
                                                        <?php else: ?>
                                                            <?php echo e(Str::limit($transaction?->from_user?->first_name.' '.$transaction?->from_user?->last_name, 30)); ?>

                                                            <br/>
                                                            <small
                                                                class="opacity-75"><?php echo e(translate($transaction?->from_user_account)); ?></small>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if($transaction?->to_user?->provider): ?>
                                                            <?php echo e(Str::limit($transaction->to_user->provider->company_name, 30)); ?>

                                                            <br/>
                                                            <small
                                                                class="opacity-75"><?php echo e(translate($transaction->to_user_account)); ?></small>
                                                        <?php else: ?>
                                                            <?php echo e(Str::limit($transaction?->to_user?->first_name.' '.$transaction?->to_user?->last_name, 30)); ?>

                                                            <br/>
                                                            <small
                                                                class="opacity-75"><?php echo e(translate($transaction->to_user_account)); ?></small>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo e(translate($transaction->trx_type)); ?></td>
                                                    <td><?php echo e(with_currency_symbol($transaction->debit)); ?></td>
                                                    <td><?php echo e(with_currency_symbol($transaction->credit)); ?></td>
                                                    <td><?php echo e(with_currency_symbol($transaction->balance)); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr class="text-center">
                                                    <td colspan="7"><?php echo e(translate('No data available')); ?></td>
                                                </tr>
                                            <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <?php echo $transactions->links(); ?>

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


<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/TransactionModule/Resources/views/admin/list.blade.php ENDPATH**/ ?>