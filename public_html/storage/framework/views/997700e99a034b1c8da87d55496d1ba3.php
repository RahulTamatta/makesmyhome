<?php if($trialDuration != 0 && $sameDate && !$modalClosed): ?>
    <div class="trial-notification active c1-bg p-3 p-lg-4">
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex flex-wrap justify-content-between flex-grow-1 gap-3">
                <div class="media gap-3 align-items-center">
                    <div class="img-circle" style="--size: 40px">
                        <span class="material-icons c1 opacity-50">extension</span>
                    </div>
                    <div class="media-body">
                        <h4 class="text-white mb-1 fs-18"><?php echo e(translate('Get the best experience of on demand service business')); ?></h4>
                        <p class="text-white opacity-75 fz-16"><?php echo e(translate('Run your on demand business with the most popular platform')); ?></p>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-white-light text-capitalize d-flex gap-2" data-bs-toggle="modal" data-bs-target="#subscriptionPlanModal">
                        <span class="position-relative">
                            <span class="days_count absolute-centered"><?php echo e($isPackageEnded); ?></span>
                            <svg width="24" height="24" viewBox="0 0 24 24" class="circular-progress">
                                <circle class="bg"></circle>
                                <circle class="fg"></circle>
                            </svg>
                        </span>
                        <span><?php echo e(translate('Days left in free trial')); ?></span>
                    </button>
                    <button type="button" class="btn btn-white text-capitalize d-flex gap-2" data-bs-toggle="modal" data-bs-target="#priceModal">
                        <span><?php echo e(translate('Choose Subscription Plan')); ?></span>
                        <span class="material-symbols-outlined"> arrow_right_alt</span>
                    </button>
                </div>
            </div>
            <button class="bg-transparent border-0 lh-1">
                <span class="material-icons trial-notification-close text-white">cancel</span>
            </button>
        </div>
    </div>
<?php elseif($trialDuration == 0 && $isPackageEnded <= 0 && !$modalClosed && $sameDate && $packageSubscriber != null): ?>
    <div class="trial-notification active bg-danger p-3 p-lg-4">
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex flex-wrap justify-content-between flex-grow-1 gap-3">
                <div class="media gap-3 align-items-center">
                    <div class="text-white">
                        <img src="<?php echo e(asset('public/assets/provider-module')); ?>/img/icons/time_bottom.svg" class="svg" alt="">
                    </div>
                    <div class="media-body">
                        <h4 class="text-white mb-1 fs-18"><?php echo e(translate('Your Subscription has been expired on ')); ?> <?php echo e(\Carbon\Carbon::parse($endDate)->format('d M Y')); ?></h4>
                        <p class="text-white opacity-75 fz-16"><?php echo e(translate('Purchase a subscription plan or contact with the admin to settle the payment and unblock the access to service')); ?></p>
                    </div>
                </div>
                <div class="d-flex">
                    <button type="button" class="btn btn-white text-capitalize d-flex gap-2" data-bs-toggle="modal" data-bs-target="#priceModal">
                        <span><?php echo e(translate('Choose Subscription Plan')); ?></span>
                        <span class="material-symbols-outlined"> arrow_right_alt</span>
                    </button>
                </div>
            </div>
            <button class="bg-transparent border-0 lh-1">
                <span class="material-icons trial-notification-close text-white">cancel</span>
            </button>
        </div>
    </div>
<?php elseif($trialDuration != 0 && !$modalClosed): ?>
    <div class="trial-notification active bg-danger p-3 p-lg-4">
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex flex-wrap justify-content-between flex-grow-1 gap-3">
                <div class="media gap-3 align-items-center">
                    <div class="text-white">
                        <img src="<?php echo e(asset('public/assets/provider-module')); ?>/img/icons/time_bottom.svg" class="svg" alt="">
                    </div>
                    <div class="media-body">
                        <h4 class="text-white mb-1 fs-18"><?php echo e(translate('Free Trial Has Been Ended')); ?></h4>
                        <p class="text-white opacity-75 fz-16"><?php echo e(translate('Get a subscription plan to continue with your business')); ?></p>
                    </div>
                </div>
                <div class="d-flex">
                    <button type="button" class="btn btn-white text-capitalize d-flex gap-2" data-bs-toggle="modal" data-bs-target="#priceModal">
                        <span><?php echo e(translate('Choose Subscription Plan')); ?></span>
                        <span class="material-symbols-outlined"> arrow_right_alt</span>
                    </button>
                </div>
            </div>
            <button class="bg-transparent border-0 lh-1">
                <span class="material-icons trial-notification-close text-white">cancel</span>
            </button>
        </div>
    </div>

    <div class="modal fade" id="subscriptionPlanModal" tabindex="-1"
         aria-labelledby="subscriptionPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content overflow-hidden">
                <button type="button" class="btn-close position-absolute top-8 right-8" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="d-flex">
                    <div class="modal-body d-flex align-items-center flex-grow-1 p-3 p-md-4 p-lg-5">
                        <div class="my-auto">
                            <h3 class="mb-2"><?php echo e(translate('Your Free Trial Has Been Ended')); ?></h3>
                            <p><?php echo e(translate('Purchase a subscription plan or contact with the admin to settle the payment and unblock the access to service.')); ?></p>
                            <button class="btn btn--primary d-flex gap-2" data-bs-toggle="modal" data-bs-target="#priceModal">
                                <span><?php echo e(translate('Choose Subscription Plan')); ?></span>
                                <span class="material-symbols-outlined"> arrow_right_alt</span>
                            </button>

                            <div class="mt-30">
                                <div class="cancellantion-note border-0 d-flex gap-2 align-items-center text-danger rounded">
                                    <img src="<?php echo e(asset('public/assets/provider-module')); ?>/img/icons/warning.svg" alt="">
                                    <?php echo e(translate('All Access to service has been blocked due to no active subscription.')); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-right-bg max-w260 d-none d-sm-block">
                        <img class="w-100 h-100 object-cover" src="<?php echo e(asset('public/assets/provider-module')); ?>/img/media/subscription_plan_modal_bg.png " alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php elseif($canceled && !$modalClosed): ?>
    <div class="trial-notification active bg-danger p-3 p-lg-4">
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex flex-wrap justify-content-between flex-grow-1 gap-3">
                <div class="media gap-3 align-items-center">
                    <div class="img-circle" style="--size: 40px">
                        <span class="material-icons c1 opacity-50">extension</span>
                    </div>
                    <div class="media-body">
                        <h4 class="text-white mb-1 fs-18"><?php echo e(translate('Your_Subscription_Has_Been_Canceled')); ?></h4>
                        <p class="text-white opacity-75 fz-16"><?php echo e(translate('You_can_not_consume_your_subscription_after')); ?> <?php echo e($endDate); ?> </p>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-white text-capitalize d-flex gap-2" data-bs-toggle="modal" data-bs-target="#priceModal">
                        <span><?php echo e(translate('Choose Subscription Plan')); ?></span>
                        <span class="material-symbols-outlined"> arrow_right_alt</span>
                    </button>
                </div>
            </div>
            <button class="bg-transparent border-0 lh-1">
                <span class="material-icons trial-notification-close text-white">cancel</span>
            </button>
        </div>
    </div>
<?php endif; ?>
<!-- Price Modal -->
<div class="modal fade" id="priceModal" tabindex="-1" aria-labelledby="priceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-body p-lg-5">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="text-center mb-30">
                    <h3 class="mb-2 h5"><?php echo e(translate('Change/Renew Subscription Plan')); ?></h3>
                    <p class="text-muted"><?php echo e(translate('Renew or shift your plan to get better experience!')); ?></p>
                </div>

                <div class="overflow-x-auto price-box-wrap">
                    <?php if($packageSubscriber && $commissionStatus): ?>
                        <div class="price-box d-flex flex-column rounded-3 border">
                            <div class="price-box__top px-2 py-4 text-center mb-3">
                                <h5><?php echo e(translate('Commission Base')); ?></h5>
                            </div>

                            <div class="text-center min-h-62 d-flex flex-column justify-content-center">
                                <strong class="h3"><?php echo e($commission); ?>%</strong>
                            </div>

                            <div class="px-2">
                                <hr>
                            </div>

                            <div class="p-3 flex-grow-1 d-flex flex-column">
                                <div class="text-center mb-30 fs-12">
                                    <?php echo e(translate('Provider will pay ')); ?><?php echo e($commission); ?>% <?php echo e(translate('commission to admin from each booking. You will get access of all the features and options in provider panel, app and interaction with user.')); ?>

                                </div>

                                <div class="d-flex justify-content-center pb-2 mt-auto">
                                    <a href="#" class="btn btn--primary text-capitalize" data-bs-toggle="modal" data-bs-target="#shiftToCommission"><?php echo e(translate('Shift
                                        to this plan')); ?></a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php $__currentLoopData = $subscriptionPackages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $isMatch = $packageSubscriber?->subscription_package_id == $package->id;
                        ?>

                        <div class="price-box d-flex flex-column <?php echo e($isMatch ? 'active' : ''); ?> rounded-3 border">
                            <div class="price-box__top px-2 py-4 text-center mb-3">
                                <h5 class="line-clamp-1"><?php echo e($package->name); ?></h5>
                            </div>

                            <div class="text-center min-h-62 d-flex flex-column justify-content-center">
                                <strong class="h3"><?php echo e(with_currency_symbol($package->price)); ?></strong>
                                <div><?php echo e($package->duration); ?> <?php echo e(translate('Days')); ?></div>
                            </div>

                            <div class="px-2">
                                <hr>
                            </div>

                            <div class="p-3 flex-grow-1 d-flex flex-column">
                                <ul class="d-flex flex-column align-items-center gap-2 p-0 fs-12 mb-30">
                                    <?php $__currentLoopData = $package->feature_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($feature); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>

                                <?php if($digitalPayment): ?>
                                    <div class="d-flex justify-content-center pb-2 mt-auto">
                                        <?php if($isMatch && $packageSubscriber != null): ?>
                                            <a class="btn btn-warning text-capitalize renew-package" data-bs-toggle="modal" data-bs-target="#renewModal" data-id="<?php echo e($package->id); ?>"><?php echo e(translate('Renew
                                                Package')); ?></a>
                                        <?php elseif($packageSubscriber == null): ?>
                                            <a href="#" class="btn btn--primary text-capitalize purchase-package" data-bs-toggle="modal" data-bs-target="#purchaseModal" data-id="<?php echo e($package->id); ?>"><?php echo e(translate('Purchase
                                               to this plan')); ?></a>
                                        <?php else: ?>
                                           <a href="#" class="btn btn--primary text-capitalize shift-package" data-bs-toggle="modal" data-bs-target="#shiftModal" data-id="<?php echo e($package->id); ?>"><?php echo e(translate('Shift
                                               to this plan')); ?></a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Shift Modal -->
<div class="modal fade" id="shiftModal" tabindex="-1" aria-labelledby="shiftModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body p-lg-5">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="text-center mb-30">
                    <h3 class="mb-2 h5"><?php echo e(translate('Shift to New Subscription Plan')); ?></h3>
                </div>

                <form action="<?php echo e(route('provider.subscription-package.shift.payment')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="append-shift">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Renew Modal -->
<div class="modal fade" id="renewModal" tabindex="-1" aria-labelledby="renewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body p-lg-5">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="text-center mb-30">
                    <h3 class="mb-2 h5"><?php echo e(translate('Renew Subscription Plan')); ?></h3>
                </div>

                <form action="<?php echo e(route('provider.subscription-package.renew.payment')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="append-renew">

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Purchase Modal -->
<div class="modal fade" id="purchaseModal" tabindex="-1" aria-labelledby="renewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body p-lg-5">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="text-center mb-30">
                    <h3 class="mb-2 h5"><?php echo e(translate('Purchase Subscription Plan')); ?></h3>
                </div>

                <form action="<?php echo e(route('provider.subscription-package.purchase.payment')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="append-purchase">

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php if($packageSubscriber): ?>
<!-- Shit commission Modal -->
<div class="modal fade" id="shiftToCommission" tabindex="-1" aria-labelledby="renewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body p-lg-5">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="text-center mb-30">
                    <h3 class="mb-2 h5"><?php echo e(translate('Shift to commission base')); ?></h3>
                </div>

                <form action="<?php echo e(route('provider.subscription-package.to.commission')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="append-purchase">
                        <div class="d-flex gap-2 gap-sm-3 align-items-center max-w-600 mx-auto">
                            <div class="price-box d-flex flex-column rounded-3 border flex-grow-1">
                                <div class="price-box__top px-2 py-4 text-center mb-3">
                                    <h5><?php echo e($packageSubscriber?->package_name); ?></h5>
                                </div>

                                <div class="text-center min-h-62 d-flex flex-column justify-content-center pb-3">
                                    <strong class="h3"><?php echo e(with_currency_symbol($packageSubscriber->package_price)); ?></strong>
                                    <div><?php echo e($packageSubscriber?->package->duration); ?>  <?php echo e(translate('Days')); ?></div>
                                </div>
                            </div>

                            <div class="flex-shrink-0">
                                <img width="40" src="<?php echo e(asset('public/assets/admin-module/img/icons/shift.png')); ?>" alt="">
                            </div>

                            <div class="price-box d-flex flex-column active rounded-3 border flex-grow-1  w-25">
                                <div class="price-box__top px-2 py-4 text-center mb-3">
                                    <h5><?php echo e(('Commission Base')); ?></h5>
                                </div>

                                <div class="text-center min-h-62 d-flex flex-column justify-content-center pb-3">
                                    <strong class="h3"><?php echo e($commission); ?>%</strong>
                                    <div class="">
                                        <?php echo e(translate('Admin gets ')); ?><?php echo e($commission); ?>% <?php echo e(translate('from each booking.')); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 pt-3">
                        <div class="d-flex flex-wrap gap-3 justify-content-end">
                            <button type="button" class="btn btn--secondary text-capitalize" data-bs-dismiss="modal"><?php echo e(translate('Cancel')); ?></button>
                            <button type="submit" class="btn btn--primary text-capitalize">
                                <?php echo e(translate('Shift Plan')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="modal fade" id="paySubscriptionModal" tabindex="-1"
     aria-labelledby="paySubscriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content overflow-hidden">
            <button type="button" class="btn-close position-absolute top-8 right-8" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="d-flex">
                <div class="modal-body d-flex align-items-center flex-grow-1 p-3 p-md-4 p-lg-5">
                    <div class="my-auto">
                        <h3 class="mb-2"><?php echo e(translate('Pay due amount')); ?></h3>
                        <p><?php echo e(translate('Please complete your payment to unblock access to the service..')); ?></p>
                        <button class="btn btn--primary d-flex gap-2" data-bs-toggle="modal" data-bs-target="#priceModal">
                            <span><?php echo e(translate('Choose Subscription Plan')); ?></span>
                            <span class="material-symbols-outlined"> arrow_right_alt</span>
                        </button>

                        <div class="mt-30">
                            <div class="cancellantion-note border-0 d-flex gap-2 align-items-center text-danger rounded">
                                <img src="<?php echo e(asset('public/assets/provider-module')); ?>/img/icons/warning.svg" alt="">
                                <?php echo e(translate('All Access to service has been blocked due to incomplete payment.')); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-right-bg max-w260 d-none d-sm-block">
                    <img class="w-100 h-100 object-cover" src="<?php echo e(asset('public/assets/provider-module')); ?>/img/media/subscription_plan_modal_bg.png " alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/housecraft/public_html/Modules/ProviderManagement/Resources/views/layouts/partials/subscription-modal.blade.php ENDPATH**/ ?>