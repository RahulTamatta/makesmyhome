<?php $__env->startSection('title',translate('provider_details')); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-title-wrap mb-3">
                <h2 class="page-title"><?php echo e(translate('Bank_Information')); ?></h2>
            </div>

            <div class="mb-3">
                <ul class="nav nav--tabs nav--tabs__style2">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='overview'?'active':''); ?>"
                           href="<?php echo e(url()->current()); ?>?web_page=overview"><?php echo e(translate('Overview')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='subscribed_services'?'active':''); ?>"
                           href="<?php echo e(url()->current()); ?>?web_page=subscribed_services"><?php echo e(translate('Subscribed_Services')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='bookings'?'active':''); ?>"
                           href="<?php echo e(url()->current()); ?>?web_page=bookings"><?php echo e(translate('Bookings')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='serviceman_list'?'active':''); ?>"
                           href="<?php echo e(url()->current()); ?>?web_page=serviceman_list"><?php echo e(translate('Service_Man_List')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='settings'?'active':''); ?>"
                           href="<?php echo e(url()->current()); ?>?web_page=settings"><?php echo e(translate('Settings')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='bank_information'?'active':''); ?>"
                           href="<?php echo e(url()->current()); ?>?web_page=bank_information"><?php echo e(translate('Bank_Information')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='reviews'?'active':''); ?>"
                           href="<?php echo e(url()->current()); ?>?web_page=reviews"><?php echo e(translate('Reviews')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='subscription'?'active':''); ?>"
                           href="<?php echo e(url()->current()); ?>?web_page=subscription&provider_id=<?php echo e(request()->id); ?>"><?php echo e(translate('Business Plan')); ?></a>
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="border-bottom d-flex gap-3 flex-wrap justify-content-between align-items-center px-4 py-3">
                    <div class="d-flex gap-2 align-items-center">
                        <span class="material-symbols-outlined">account_balance</span>

                        <h3><?php echo e(translate('Bank_Information')); ?></h3>
                    </div>
                    <div class="d-flex gap-2 align-items-center">
                    </div>
                </div>
                <div class="card-body p-30">
                    <div class="row justify-content-center">
                        <div class="col-sm-6 col-md-8 col-lg-6 col-xl-5">
                            <div class="card bank-info-card bg-bottom bg-contain bg-img"
                                 style="background-image: url('<?php echo e(asset('public/assets/admin-module')); ?>/img/media/bank-info-card-bg.png');">
                                <div class="border-bottom p-3">
                                    <h4 class="fw-semibold"><?php echo e(translate('Holder_Name')); ?>:
                                        <strong><?php echo e(Str::limit($provider->bank_detail->acc_holder_name ?? translate('Unavailable'), 50)); ?></strong>
                                    </h4>
                                </div>
                                <div class="card-body position-relative">
                                    <img class="bank-card-img"
                                         src="<?php echo e(asset('public/assets/admin-module')); ?>/img/media/bank-card.png" alt="">
                                    <ul class="list-unstyled d-flex flex-column gap-4">
                                        <li>
                                            <h3 class="mb-2"><?php echo e(translate('Bank_Name')); ?>:</h3>
                                            <div><?php echo e($provider->bank_detail->bank_name ?? translate('Unavailable')); ?></div>
                                        </li>
                                        <li>
                                            <h3 class="mb-2"><?php echo e(translate('Branch_Name')); ?>:</h3>
                                            <div><?php echo e($provider->bank_detail->branch_name ?? translate('Unavailable')); ?></div>
                                        </li>
                                        <li>
                                            <h3 class="mb-2"><?php echo e(translate('Account_Number')); ?>:</h3>
                                            <div><?php echo e($provider->bank_detail->acc_no ?? translate('Unavailable')); ?></div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateBankInfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?php echo e(route('admin.provider.account.update',[$provider->id])); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="changeScheduleModalLabel"><?php echo e(translate('Update_Account_Information')); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-30">
                            <input type="text" class="form-control" name="bank_name"
                                   value="<?php echo e($provider->bank_detail->bank_name??''); ?>"
                                   placeholder="<?php echo e(translate('Bank_Name')); ?>" required>
                            <label><?php echo e(translate('Bank_Name')); ?></label>
                        </div>
                        <div class="form-floating mb-30">
                            <input type="text" class="form-control" name="branch_name"
                                   value="<?php echo e($provider->bank_detail->branch_name??''); ?>"
                                   placeholder="<?php echo e(translate('Branch_Name')); ?>" required>
                            <label><?php echo e(translate('Branch_Name')); ?></label>
                        </div>
                        <div class="form-floating mb-30">
                            <input type="text" class="form-control" name="acc_no"
                                   value="<?php echo e($provider->bank_detail->acc_no??''); ?>"
                                   placeholder="<?php echo e(translate('Acc_No')); ?>" required>
                            <label><?php echo e(translate('Acc._No.')); ?></label>
                        </div>
                        <div class="form-floating mb-30">
                            <input type="text" class="form-control" name="acc_holder_name"
                                   value="<?php echo e($provider->bank_detail->acc_holder_name??''); ?>"
                                   placeholder="<?php echo e(translate('Acc._Holder_Name')); ?>" required>
                            <label><?php echo e(translate('Acc._Holder_Name')); ?></label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--secondary"
                                data-bs-dismiss="modal"><?php echo e(translate('Close')); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo e(translate('Submit')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/ProviderManagement/Resources/views/admin/provider/detail/bank-information.blade.php ENDPATH**/ ?>