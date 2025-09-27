<?php $__env->startSection('title',translate('contact_us')); ?>

<?php $__env->startSection('content'); ?>
    <div class="container pt-3">
        <section class="page-header bg__img" data-img="<?php echo e(asset('public/assets/landing')); ?>/img/page-header.png">
            <h3 class="title"><?php echo e(translate('contact_us')); ?></h3>
        </section>
    </div>
    <section class="contact-section pb-60 pt-30">
        <div class="container">
            <div class="row g-4">

                <div class="col-6">
                    <div class="contact__item h-100">
                        <div class="contact__item-icon">
                            <i class="las la-map-marker-alt"></i>
                        </div>
                        <h3 class="contact__item-title"><?php echo e(translate('address')); ?></h3>
                        <ul>
                            <li>
                                <?php echo e(bs_data($settings,'business_address', 1)); ?>

                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-6">
                    <div class="contact__item h-100">
                        <div class="contact__item-icon">
                            <i class="las la-phone-volume"></i>
                        </div>
                        <h3 class="contact__item-title"><?php echo e(translate('call_us')); ?></h3>
                        <ul>
                            <li>
                                <a href="Tel:<?php echo e(bs_data($settings,'business_phone', 1)); ?>"><?php echo e(bs_data($settings,'business_phone', 1)); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-6">
                    <div class="contact__item h-100">
                        <div class="contact__item-icon">
                            <i class="las la-envelope-open-text"></i>
                        </div>
                        <h3 class="contact__item-title"><?php echo e(translate('email')); ?></h3>
                        <ul>
                            <li>
                                <a href="mailto:<?php echo e(bs_data($settings,'business_email', 1)); ?>"><?php echo e(bs_data($settings,'business_email', 1)); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.landing.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/resources/views/contact-us.blade.php ENDPATH**/ ?>