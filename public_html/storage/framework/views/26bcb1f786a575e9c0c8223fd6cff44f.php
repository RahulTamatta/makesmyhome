<?php $__env->startSection('title',translate('Update_Serviceman')); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-title-wrap mb-3">
                <h2 class="page-title"><?php echo e(translate('update_serviceman')); ?></h2>
            </div>

            <form action="<?php echo e(route('provider.serviceman.update',[$serviceman->id])); ?>" method="post"
                    enctype="multipart/form-data">
                <?php echo method_field('put'); ?>
                <?php echo csrf_field(); ?>

                <div class="card">
                    <div class="card-body">
                        <div class="row gx-xl-5">
                            <div class="col-md-6">
                                <h4 class="mb-20"><?php echo e(translate('General_Information')); ?></h4>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-floating form-floating__icon mb-30">
                                            <input type="text" class="form-control" name="first_name"
                                                    placeholder="<?php echo e(translate('First_name')); ?>"
                                                    value="<?php echo e($serviceman->user->first_name); ?>" required>
                                            <label><?php echo e(translate('First_name')); ?></label>
                                            <span class="material-icons">account_circle</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-floating form-floating__icon mb-30">
                                            <input type="text" class="form-control" name="last_name"
                                                    placeholder="<?php echo e(translate('Last_name')); ?>"
                                                    value="<?php echo e($serviceman->user->last_name); ?>" required>
                                            <label><?php echo e(translate('Last_name')); ?></label>
                                            <span class="material-icons">account_circle</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-30">
                                    <div class="input-wrap form-floating">
                                        <label for="phone"><?php echo e(translate('Phone_number')); ?></label>
                                        <input type="tel" class="form-control phone-input-with-country-picker"  name="phone"
                                                placeholder="<?php echo e(translate('Phone_number')); ?>"
                                                value="<?php echo e($serviceman->user->phone); ?>" required>
                                        <div class="">
                                            <input type="text" class="country-picker-phone-number w-50" value="<?php echo e(old('phone')); ?>" name="phone" hidden  readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex flex-column align-items-center gap-3 mb-30">
                                    <h3 class="mb-0"><?php echo e(translate('Serviceman_image')); ?> (1:1)</h3>
                                    <div>
                                        <div class="upload-file">
                                            <input type="file" class="upload-file__input"
                                                    name="profile_image" accept=".<?php echo e(implode(',.', array_column(IMAGEEXTENSION, 'key'))); ?>, |image/*">
                                            <div class="upload-file__img">
                                                <img
                                                    src="<?php echo e($serviceman->user->profile_image_full_path); ?>"
                                                    alt="<?php echo e(translate('serviceman')); ?>">
                                            </div>
                                            <span class="upload-file__edit">
                                                <span class="material-icons">edit</span>
                                            </span>
                                        </div>
                                    </div>
                                    <p class="opacity-75 max-w220 mx-auto text-center"><?php echo e(translate('Upload jpg png jpeg gif maximum 2 MB')); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row gx-xl-5">
                            <div class="col-md-6">
                                <h4 class="mb-20"><?php echo e(translate('Business_Information')); ?></h4>

                                <?php ($id_types=['passport','driving_license','nid','trade_license']); ?>
                                <select class="select-identity theme-input-style w-100 mb-30"
                                        name="identity_type" required>
                                    <option selected disabled><?php echo e(translate('Select_Identity_Type')); ?></option>
                                    <?php $__currentLoopData = $id_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option
                                            value="<?php echo e($type); ?>" <?php echo e($type==$serviceman->user->identification_type?'selected':''); ?>><?php echo e(translate($type)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <div class="form-floating form-floating__icon mb-30">
                                    <input type="text" class="form-control" name="identity_number"
                                            placeholder="<?php echo e(translate('Identity Number')); ?>"
                                            value="<?php echo e($serviceman->user->identification_number); ?>" required>
                                    <label><?php echo e(translate('Identity_Number')); ?></label>
                                    <span class="material-icons">badge</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex flex-column gap-3 mb-30">
                                    <h3 class="mb-0"><?php echo e(translate('Identification_Image')); ?></h3>
                                    <div id="multi_image_picker">
                                        <?php $__currentLoopData = $serviceman->user->identification_image_full_path; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <img src="<?php echo e($img); ?>" alt="<?php echo e(translate('identity-image')); ?>">
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <h4 class="c1 mb-30"><?php echo e(translate('Account_Information')); ?></h4>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-floating form-floating__icon mb-30">
                                    <input type="email" class="form-control" name="email"
                                            placeholder="<?php echo e(translate('Email_*')); ?>"
                                            value="<?php echo e($serviceman->user->email); ?>" required>
                                    <label><?php echo e(translate('Email_*')); ?></label>
                                    <span class="material-icons">mail</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-floating form-floating__icon mb-30">
                                    <input type="password" class="form-control" name="password"
                                            placeholder="<?php echo e(translate('Password')); ?>">
                                    <label><?php echo e(translate('Password')); ?></label>
                                    <span class="material-icons togglePassword">visibility_off</span>
                                    <span class="material-icons">lock</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-floating form-floating__icon mb-30">
                                    <input type="password" class="form-control"
                                            name="confirm_password"
                                            placeholder="<?php echo e(translate('Confirm_Password')); ?>">
                                    <label><?php echo e(translate('Confirm_Password')); ?></label>
                                    <span class="material-icons togglePassword">visibility_off</span>
                                    <span class="material-icons">lock</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-4 flex-wrap justify-content-end mt-4">
                    <button type="reset" class="btn btn--secondary"><?php echo e(translate('Reset')); ?></button>
                    <button type="submit" class="btn btn--primary"><?php echo e(translate('update')); ?></button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('public/assets/provider-module/js/spartan-multi-image-picker.js')); ?>"></script>
    <script>
        "use strict";

        $("#multi_image_picker").spartanMultiImagePicker({
                fieldName: 'identity_image[]',
                maxCount: 2,
                rowHeight: 'auto',
                groupClassName: 'multi_image_picker_item',
                dropFileLabel: "<?php echo e(translate('Drop_here')); ?>",
                placeholderImage: {
                    image: '<?php echo e(asset('public/assets/provider-module')); ?>/img/media/identity-img.png',
                    width: '100%',
                },

                onRenderedPreview: function (index) {
                    toastr.success('<?php echo e(translate('Image_added')); ?>', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onRemoveRow: function (index) {
                    console.log(index);
                },
                onExtensionErr: function (index, file) {
                    toastr.error('<?php echo e(translate('Please_only_input_png_or_jpg_type_file')); ?>', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('<?php echo e(translate('File_size_too_big')); ?>', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            }
        );
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('providermanagement::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/ServicemanModule/Resources/views/Provider/Serviceman/edit.blade.php ENDPATH**/ ?>