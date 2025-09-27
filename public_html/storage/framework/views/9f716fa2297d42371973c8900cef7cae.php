<?php $__env->startSection('title',translate('Collect_Cash')); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-title-wrap mb-3">
                <h2 class="page-title"><?php echo e(translate('Provider_Details')); ?></h2>
            </div>

            <div class="mb-3">
                <ul class="nav nav--tabs nav--tabs__style2">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='overview'?'active':''); ?>"
                           href="<?php echo e(route('admin.provider.details',[$provider_id, 'web_page'=>'overview'])); ?>"><?php echo e(translate('Overview')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='subscribed_services'?'active':''); ?>"
                           href="<?php echo e(route('admin.provider.details',[$provider_id, 'web_page'=>'subscribed_services'])); ?>"><?php echo e(translate('Subscribed_Services')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='bookings'?'active':''); ?>"
                           href="<?php echo e(route('admin.provider.details',[$provider_id, 'web_page'=>'bookings'])); ?>"><?php echo e(translate('Bookings')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='serviceman_list'?'active':''); ?>"
                           href="<?php echo e(route('admin.provider.details',[$provider_id, 'web_page'=>'serviceman_list'])); ?>"><?php echo e(translate('Service_Man_List')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='settings'?'active':''); ?>"
                           href="<?php echo e(route('admin.provider.details',[$provider_id, 'web_page'=>'settings'])); ?>"><?php echo e(translate('Settings')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='bank_info'?'active':''); ?>"
                           href="<?php echo e(route('admin.provider.details',[$provider_id, 'web_page'=>'bank_information'])); ?>"><?php echo e(translate('Bank_Information')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='reviews'?'active':''); ?>"
                           href="<?php echo e(route('admin.provider.details',[$provider_id, 'web_page'=>'reviews'])); ?>"><?php echo e(translate('Reviews')); ?></a>
                    </li>
                </ul>
            </div>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="overview-tab-pane">
                    <div class="card mb-30">
                        <div class="card-body p-30">
                            <form action="<?php echo e(route('admin.provider.collect_cash.store')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="row g-4">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="number" class="form-control"
                                                   placeholder="<?php echo e(translate('Amount')); ?>"
                                                   name="amount" min="1" step="any" required>
                                            <input type="hidden" class="form-control" name="provider_id"
                                                   value="<?php echo e($provider_id); ?>">
                                            <label><?php echo e(translate('Amount_*')); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('onboarding_request_update')): ?>
                                    <div class="d-flex justify-content-end mt-30">
                                        <button type="submit" class="btn btn--primary"><?php echo e(translate('Submit')); ?></button>
                                    </div>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between">
                                <form action="<?php echo e(url()->current()); ?>"
                                      class="search-form search-form_style-two"
                                      method="GET">
                                    <?php echo csrf_field(); ?>
                                    <div class="input-group search-form__input_group">
                                            <span class="search-form__icon">
                                                <span class="material-icons">search</span>
                                            </span>
                                        <input type="search" class="theme-input-style search-form__input"
                                               value="<?php echo e($search); ?>" name="search"
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
                                        <th><?php echo e(translate('Transaction_Id')); ?></th>
                                        <th><?php echo e(translate('Transaction_Date')); ?></th>
                                        <th><?php echo e(translate('Transaction_From')); ?></th>
                                        <th><?php echo e(translate('Transaction_To')); ?></th>
                                        <th><?php echo e(translate('Debit')); ?></th>
                                        <th><?php echo e(translate('Credit')); ?></th>
                                        <th><?php echo e(translate('Balance')); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($transaction->id); ?></td>
                                            <td><?php echo e($transaction->created_at); ?></td>
                                            <td><?php echo e(Str::limit($transaction->from_user?$transaction->from_user->first_name.' '.$transaction->from_user->last_name:'', 30)); ?></td>
                                            <td><?php echo e(Str::limit($transaction->to_user?$transaction->to_user->first_name.' '.$transaction->to_user->last_name:'', 30)); ?></td>
                                            <td><?php echo e(with_currency_symbol($transaction->debit)); ?></td>
                                            <td><?php echo e(with_currency_symbol($transaction->credit)); ?></td>
                                            <td><?php echo e(with_currency_symbol($transaction->balance)); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/ProviderManagement/Resources/views/admin/account/collect-cash.blade.php ENDPATH**/ ?>