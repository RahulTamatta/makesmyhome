<?php $__env->startSection('title', translate('Reset Password')); ?>

<?php $__env->startSection('content'); ?>
    <div class="register-form dark-support"
         data-bg-img="<?php echo e(asset('public/assets/provider-module')); ?>/img/media/login-bg.png">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    <form action="<?php echo e(route('provider.auth.reset-password.send-otp')); ?>" method="POST"
                          enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="card p-4">
                            <h4 class="mb-30"><?php echo e(translate('Forgot your password')); ?>?</h4>
                            <h6 class="mb-2"><?php echo e(translate('Change your password in three easy steps. This helps to keep your new password secure .')); ?></h6>
                            <ul>
                                <li><?php echo e(translate('Fill in your account email/phone below')); ?></li>
                                <li><?php echo e(translate('We will send you a temporary code ')); ?></li>
                                <li><?php echo e(translate('Use the code to change your password on our secure website')); ?></li>
                            </ul>

                            <div class="row">
                                <div class="col-10">
                                    <div class="mb-30">
                                        <?php ($forgetPasswordVerificationMetod = (business_config('forget_password_verification_method', 'business_information'))->live_values ?? 'email'); ?>

                                        <?php if($forgetPasswordVerificationMetod == 'email'): ?>
                                            <div class="form-floating">
                                                <input type="email" class="form-control" name="identity"
                                                       placeholder="<?php echo e(translate('Enter your email address')); ?> *"
                                                       required>
                                                <input type="hidden" name="identity_type" value="email">
                                                <label><?php echo e(translate('Enter your email address')); ?> *</label>
                                            </div>
                                        <?php elseif($forgetPasswordVerificationMetod == 'phone'): ?>
                                            <div class="form-floating">
                                                <label for="identity"><?php echo e(translate('Enter your phone number')); ?> *</label>
                                                <input type="tel" class="form-control" name="identity"
                                                       placeholder="<?php echo e(translate('Enter your phone number')); ?> *" id="identity"
                                                       required>
                                                <input type="hidden" name="identity_type" value="phone">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn--primary"><?php echo e(translate('Send OTP')); ?></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/Auth/Resources/views/reset-password/send-otp.blade.php ENDPATH**/ ?>