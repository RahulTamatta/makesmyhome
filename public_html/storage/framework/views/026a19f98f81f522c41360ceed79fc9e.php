<?php $__env->startSection('title',translate('customer_update')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module/plugins/swiper/swiper-bundle.min.css')); ?>">

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap mb-3">
                        <h2 class="page-title"><?php echo e(translate('customer_update')); ?></h2>
                    </div>

                    <div class="card">
                        <div class="card-body p-30">
                            <form action="<?php echo e(route('admin.customer.update',[$customer['id']])); ?>" method="post"
                                  enctype="multipart/form-data"
                                  id="customer-update-form">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('put'); ?>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-30">
                                            <div class="form-floating form-floating__icon">
                                                <input type="text" class="form-control" name="first_name"
                                                       placeholder="<?php echo e(translate('first_name')); ?> *"
                                                       required="" value="<?php echo e($customer['first_name']); ?>">
                                                <label><?php echo e(translate('first_name')); ?> *</label>
                                                <span class="material-icons">account_circle</span>
                                            </div>
                                        </div>

                                        <div class="mb-30">
                                            <div class="form-floating form-floating__icon">
                                                <input type="text" class="form-control" name="last_name"
                                                       placeholder="<?php echo e(translate('last_name')); ?> *"
                                                       required="" value="<?php echo e($customer['last_name']); ?>">
                                                <label><?php echo e(translate('last_name')); ?> *</label>
                                                <span class="material-icons">account_circle</span>
                                            </div>
                                        </div>

                                        <div class="mb-30">
                                            <div class="form-floating form-floating__icon">
                                                <input type="email" class="form-control" name="email"
                                                       placeholder="<?php echo e(translate('ex: abc@email.com')); ?> *"
                                                       required="" value="<?php echo e($customer['email']); ?>">
                                                <label><?php echo e(translate('email')); ?> *</label>
                                                <span class="material-icons">mail</span>
                                            </div>
                                        </div>

                                        <div class="mb-30">
                                            <div class="form-floating">
                                                <input type="tel" class="form-control company_phone phone-input-with-country-picker iti__tel-input" name="phone"
                                                       placeholder="<?php echo e(translate('phone')); ?> *" id="phone"
                                                       oninput="this.value = this.value.replace(/[^+\d]+$/g, '').replace(/(\..*)\./g, '$1');"
                                                       required="" value="<?php echo e($customer['phone']); ?>">
                                            </div>
                                            <input type="text" class="country-picker-phone-number w-50" value="<?php echo e(old('phone')); ?>" name="phone" hidden  readonly>

                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="d-flex flex-column align-items-center gap-3">
                                            <p class="mb-0"><?php echo e(translate('profile_image')); ?></p>
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="upload-file">
                                                    <input type="file" class="upload-file__input" name="profile_image" accept=".<?php echo e(implode(',.', array_column(IMAGEEXTENSION, 'key'))); ?>, |image/*">
                                                    <div class="upload-file__img">
                                                        <img src="<?php echo e($customer->profile_image_full_path); ?>" alt="<?php echo e(translate('image')); ?>">
                                                    </div>
                                                    <span class="upload-file__edit">
                                                        <span class="material-icons">edit</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <p class="opacity-75 max-w220 mx-auto">
                                                <?php echo e(translate('Image format - jpg, png,jpeg,gif Image Size -maximum size 2 MB Image Ratio - 1:1')); ?>

                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-flex justify-content-end gap-20 mt-30">
                                            <button class="btn btn--secondary"
                                                    type="reset"><?php echo e(translate('reset')); ?></button>
                                            <button class="btn btn--primary" type="submit">
                                                <?php echo e(translate('submit')); ?>

                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/CustomerModule/Resources/views/admin/edit.blade.php ENDPATH**/ ?>