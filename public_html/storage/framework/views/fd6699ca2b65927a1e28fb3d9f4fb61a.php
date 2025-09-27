<?php $__env->startSection('title',translate('provider_details')); ?>

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

            <div class="tab-content">
                <div class="tab-pane fade show active" id="subscribed-tab-pane">
                    <div
                        class="d-flex flex-wrap justify-content-between align-items-center border-bottom mx-lg-4 mb-10 gap-3">
                        <ul class="nav nav--tabs">
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($status=='all'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?web_page=subscribed_services&status=all"><?php echo e(translate('All')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($status=='subscribed'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?web_page=subscribed_services&status=subscribed"><?php echo e(translate('Subscribed')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($status=='unsubscribed'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?web_page=subscribed_services&status=unsubscribed"><?php echo e(translate('Unsubscribed')); ?></a>
                            </li>
                        </ul>

                        <div class="d-flex gap-2 fw-medium">
                            <span class="opacity-75"><?php echo e(translate('Total_Sub_Categories')); ?>:</span>
                            <span class="title-color"><?php echo e($subCategories->total()); ?></span>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="all-tab-pane">
                            <div class="card">
                                <div class="card-body">
                                    <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between">
                                        <form
                                            action="<?php echo e(url()->current()); ?>?web_page=subscribed_services&status=<?php echo e($status); ?>"
                                            class="search-form search-form_style-two"
                                            method="POST">
                                            <?php echo csrf_field(); ?>
                                            <div class="input-group search-form__input_group">
                                            <span class="search-form__icon">
                                                <span class="material-icons">search</span>
                                            </span>
                                                <input type="search" class="theme-input-style search-form__input"
                                                       value="<?php echo e($search??''); ?>" name="search"
                                                       placeholder="<?php echo e(translate('search_here')); ?>">
                                            </div>
                                            <button type="submit" class="btn btn--primary">
                                                <?php echo e(translate('search')); ?>

                                            </button>
                                        </form>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="example" class="table align-center align-middle">
                                            <thead>
                                            <tr>
                                                <th><?php echo e(translate('Sub_Category_Name')); ?></th>
                                                <th><?php echo e(translate('Services')); ?></th>
                                                <th><?php echo e(translate('Subscribe_/_Unsubscribe')); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $__currentLoopData = $subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>
                                                        <div data-bs-toggle="modal"
                                                             data-bs-target="#showServiceModal"><?php echo e(Str::limit($sub_category->sub_category?$sub_category->sub_category->name:'', 30)); ?></div>
                                                    </td>
                                                    <td><?php echo e($sub_category->sub_category?$sub_category->sub_category->services_count:0); ?></td>
                                                    <td>
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('provider_manage_status')): ?>
                                                            <label class="switcher" data-bs-toggle="modal"
                                                                   data-bs-target="#deactivateAlertModal">
                                                                <input class="switcher_input route-alert"
                                                                       data-route="<?php echo e(route('admin.provider.sub_category.update_subscription',[$sub_category->id])); ?>"
                                                                       data-message="<?php echo e(translate('want_to_update_status')); ?>"
                                                                       type="checkbox" <?php echo e($sub_category->is_subscribed == 1 ? 'checked' : ''); ?>>
                                                                <span class="switcher_control"></span>
                                                            </label>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <?php echo $subCategories->links(); ?>

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

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/ProviderManagement/Resources/views/admin/provider/detail/subscribed-services.blade.php ENDPATH**/ ?>