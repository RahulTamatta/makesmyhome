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

            <div class="card">
                <div class="card-body p-30">
                    <?php echo e($servicemen->count() == 0 ? translate('Provider_has_no_serviceman_yet') : ''); ?>

                    <div class="service-man-list">
                        <?php $__currentLoopData = $servicemen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $serviceman): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="service-man-list__item">
                                <div class="service-man-list__item_header">
                                    <img src="<?php echo e($serviceman?->user->profile_image_full_path); ?>"
                                        alt="<?php echo e(translate('profile_image')); ?>">
                                    <h4 class="service-man-name"><?php echo e(Str::limit($serviceman->user ? $serviceman->user->first_name.' '.$serviceman->user->last_name:'', 30)); ?></h4>
                                    <a class="service-man-phone"
                                       href="tel:+880372786552"><?php echo e($serviceman->user->phone); ?></a>
                                </div>
                                <div class="service-man-list__item_body">
                                    <a class="service-man-mail"
                                       href="mailto:example@email.com"><?php echo e($serviceman->user->email); ?></a>
                                    <p class="service-man-address">
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/ProviderManagement/Resources/views/admin/provider/detail/serviceman-list.blade.php ENDPATH**/ ?>