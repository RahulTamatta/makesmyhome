<?php $__env->startSection('title', translate('employee_add')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module/plugins/select2/select2.min.css')); ?>"/>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap mb-3">
                        <h2 class="page-title"><?php echo e(translate('Add_New_employee')); ?></h2>
                    </div>

                    <div class="card">
                        <div class="card-body py-4">
                            <form id="add-new-employee-form" action="<?php echo e(route('admin.employee.store')); ?>" method="post" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div>
                                    <div>
                                        <div class="d-flex gap-1 flex-column">
                                            <h4>Employee Info</h4>
                                            <p class="fs-12">Give employee’s basic and account info</p>
                                        </div>
                                    </div>
                                    <section>
                                            <div class="d-flex flex-column gap-1 mb-20">
                                                <h4><?php echo e(translate('General_Information')); ?></h4>
                                                <p>Fill an employee’s general info such as name, address number and set role</p>
                                            </div>

                                            <hr class="mb-30">

                                            <div class="row mb-5">
                                                <div class="col-lg-8">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-30">
                                                            <div class="input-wrap form-floating form-floating__icon">
                                                                <input type="text" class="form-control" name="first_name"
                                                                        placeholder="<?php echo e(translate('First_name')); ?>"
                                                                        value="<?php echo e(old('first_name')); ?>" required>
                                                                <label><?php echo e(translate('First_name')); ?></label>
                                                                <span class="material-icons">account_circle</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-30">
                                                            <div class="input-wrap form-floating form-floating__icon">
                                                                <input type="text" class="form-control" name="last_name"
                                                                        placeholder="<?php echo e(translate('Last_name')); ?>"
                                                                        value="<?php echo e(old('last_name')); ?>" required>
                                                                <label><?php echo e(translate('Last_name')); ?></label>
                                                                <span class="material-icons">account_circle</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-30">
                                                            <div class="input-wrap form-floating">
                                                                <label for="phone"><?php echo e(translate('Phone_number')); ?></label>
                                                                <input type="tel" class="form-control phone-input-with-country-picker"  name="phone"
                                                                        placeholder="<?php echo e(translate('Phone_number')); ?>"
                                                                        value="<?php echo e(old('phone')); ?>" required>
                                                                <div class="">
                                                                    <input type="text" class="country-picker-phone-number w-50" value="<?php echo e(old('phone')); ?>" name="phone" hidden  readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-30">
                                                            <div class="input-wrap form-floating form-floating__icon">
                                                                <input type="text" class="form-control" id="address" name="address"
                                                                        placeholder="<?php echo e(translate('address')); ?>"
                                                                        value="<?php echo e(old('address')); ?>" required>
                                                                <label><?php echo e(translate('Address')); ?></label>
                                                                <span class="material-icons">home</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-30">
                                                            <div class="input-wrap">
                                                                <select class="select-identity theme-input-style role-btn" name="role_id" required>
                                                                    <option selected disabled><?php echo e(translate('Select_role')); ?></option>
                                                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($role->id); ?>" <?php echo e(old('role_id') == $role->id ? 'selected' : ''); ?>><?php echo e($role->role_name); ?></option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-30">
                                                            <div class="input-wrap">
                                                                <select class="zone-select theme-input-style"
                                                                        name="zone_ids[]" id="zone_selector__select" multiple required>
                                                                    <option value="all"><?php echo e(translate('Select All')); ?></option>
                                                                    <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($zone->id); ?>" <?php echo e(in_array($zone->id, old('zone_ids', [])) ? 'selected' : ''); ?>><?php echo e($zone->name); ?></option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="d-flex flex-column gap-1 align-items-center">
                                                        <div class="input-wrap">
                                                            <div class="d-flex flex-column align-items-center gap-3">
                                                                <div class="text-muted"><?php echo e(translate('Employee Image')); ?> (1:1) <span class="text-danger">*</span></div>
                                                                <div class="d-flex flex-column align-items-center">
                                                                    <div class="upload-file">
                                                                        <span class="upload-file__edit">
                                                                            <span class="material-icons">edit</span>
                                                                        </span>
                                                                        <input type="file" id="uploadImage" class="upload-file__input"
                                                                                name="profile_image" required accept=".<?php echo e(implode(',.', array_column(IMAGEEXTENSION, 'key'))); ?>, |image/*">
                                                                        <div class="upload-file__img">
                                                                            <img
                                                                                src="<?php echo e(asset('public/assets/admin-module')); ?>/img/media/upload-file.png"
                                                                                alt="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <p class="opacity-75 max-w220 mx-auto text-center fs-12">
                                                                    <?php echo e(translate('Upload jpg, png, jpeg, gif maximum 2 MB')); ?>

                                                                </p>
                                                            </div>
                                                            <div class="file_error">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-column gap-1 mb-20">
                                                <h4><?php echo e(translate('Business_Information')); ?></h4>
                                                <p>Give verified information to verify a employee</p>
                                            </div>

                                            <hr class="mb-30">

                                            <div class="row">
                                                <div class="col-lg-6 mb-30">
                                                    <div class="input-wrap">
                                                        <select class="select-identity theme-input-style" name="identity_type" required>
                                                            <option value="0" disabled><?php echo e(translate('Select_Identity_Type')); ?></option>
                                                            <option value="passport" <?php echo e(old('identity_type') == 'passport' ? 'selected' : ''); ?>><?php echo e(translate('Passport')); ?></option>
                                                            <option value="driving_license" <?php echo e(old('identity_type') == 'driving_license' ? 'selected' : ''); ?>><?php echo e(translate('Driving_License')); ?></option>
                                                            <option value="nid" <?php echo e(old('identity_type') == 'nid' ? 'selected' : ''); ?>><?php echo e(translate('nid')); ?></option>
                                                            <option value="trade_license" <?php echo e(old('identity_type') == 'trade_license' ? 'selected' : ''); ?>><?php echo e(translate('Trade_License')); ?></option>
                                                        </select>
                                                    </div>
                                                    <div class="input-wrap form-floating form-floating__icon mt-30">
                                                        <input type="text" class="form-control" name="identity_number"
                                                                placeholder="<?php echo e(translate('Identity Number')); ?>"
                                                                value="<?php echo e(old('identity_number')); ?>" required>
                                                        <label><?php echo e(translate('Identity_Number')); ?></label>
                                                        <span class="material-icons">badge</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-30">
                                                    <div class="input-wrap">
                                                        <div class="d-flex flex-column align-items-center gap-3">
                                                            <div class="text-muted"><?php echo e(translate('Identification_Image')); ?> (2:1) <span class="text-danger">*</span></div>
                                                            <div class="d-flex" id="multi_image_picker"></div>
                                                            <p class="opacity-75 max-w220 mx-auto text-center fs-12">
                                                                <?php echo e(translate('Upload jpg, png, jpeg, gif maximum 2 MB')); ?>

                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-column gap-1 mb-20">
                                                <h4><?php echo e(translate('Account_Information')); ?></h4>
                                                <p>This info will need for employee’s future login</p>
                                            </div>

                                            <hr class="mb-30">

                                            <div class="row">
                                                <div class="col-lg-4 mb-30">
                                                    <div class="input-wrap form-floating form-floating__icon">
                                                        <input type="email" class="form-control" name="email"
                                                                placeholder="<?php echo e(translate('Email_*')); ?>"
                                                                value="<?php echo e(old('email')); ?>" required>
                                                        <label><?php echo e(translate('Email_*')); ?></label>
                                                        <span class="material-icons">mail</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 mb-30">
                                                    <div class="input-wrap form-floating form-floating__icon">
                                                        <input type="password" class="form-control" name="password" value="password"
                                                                placeholder="<?php echo e(translate('Password')); ?>" id="pass" required>
                                                        <label><?php echo e(translate('Password')); ?></label>
                                                        <span class="material-icons togglePassword">visibility_off</span>
                                                        <span class="material-icons">lock</span>
                                                    </div>
                                                    <small class="text-danger d-flex mb-30 mt-1"><?php echo e(translate('Password_Must_be_at_Least_8_Digits')); ?></small>
                                                </div>
                                                <div class="col-lg-4 mb-30">
                                                    <div class="input-wrap form-floating form-floating__icon">
                                                        <input type="password" class="form-control" name="confirm_password"
                                                                value="password"
                                                                placeholder="<?php echo e(translate('Confirm_Password')); ?>" id="confirm_password"
                                                                required>
                                                        <label><?php echo e(translate('Confirm_Password')); ?></label>
                                                        <span class="material-icons togglePassword">visibility_off</span>
                                                        <span class="material-icons">lock</span>
                                                    </div>
                                                </div>
                                            </div>
                                    </section>
                                    <div>
                                        <div class="d-flex gap-1 flex-column">
                                            <h4>Set Permissions</h4>
                                            <p class="fs-12">Set what individuals on this role can do</p>
                                        </div>
                                    </div>
                                    <section>
                                        <div class="d-flex flex-column gap-1 mb-20">
                                            <h4><?php echo e(translate('Set_Permission')); ?></h4>
                                            <p>Modify what individuals on this role can do</p>
                                        </div>
                                        <div class="role-access-permission">
                                        </div>
                                    </section>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('public/assets/provider-module')); ?>/plugins/jquery-steps/jquery.steps.min.js"></script>
    <script src="<?php echo e(asset('public/assets/provider-module')); ?>/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script>
        "use strict";

        $(document).ready(function() {
            $('.role-btn').change(function() {
                var roleId = $(this).val();

                $.ajax({
                    url: '<?php echo e(route('admin.employee.ajax.role.access')); ?>',
                    method: 'GET',
                    data: { role_id: roleId },
                    success: function(response) {
                        $('.role-access-permission').html(response.html);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });

        var form = $("#add-new-employee-form");
        form.validate({
            errorPlacement: function errorPlacement(error, element) { element.parents('.input-wrap').after(error); },
            rules: {
                password: {
                    minlength: 8,
                },
                confirm_password: {
                    minlength: 8,
                    equalTo: "#pass"
                }
            }
        });
        form.children("div").steps({
            headerTag: "div",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            onStepChanging: function (event, currentIndex, newIndex) {
                form.validate().settings.ignore = ":disabled,:hidden";
                if($('.spartan_image_input').val() === "") {
                    if($('.multi_image_picker_warning').length === 0) {
                        $(this).find('#multi_image_picker').after('<small class="text-danger d-flex mb-30 mt-1 multi_image_picker_warning">Please upload Identification image</small>');
                        return false;
                    }
                } else {
                    $('.multi_image_picker_warning').remove();
                }

                const oFile = document.getElementById("uploadImage").files[0];

                if (oFile.size > 2097152)
                {
                    return false;
                }
                return form.valid();
            },
            onFinishing: function (event, currentIndex) {
                form.submit();
            },
            onFinished: function (event, currentIndex) {
                form.submit();
            }
        });
    </script>

    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/js/spartan-multi-image-picker.js"></script>
    <script>
        "use strict";

        $('#zone_selector__select').on('change', function() {
            var selectedValues = $(this).val();
            if (selectedValues !== null && selectedValues.includes('all')) {
                $(this).find('option').not(':disabled').prop('selected', 'selected');
                $(this).find('option[value="all"]').prop('selected', false);
            }
        });

        $("#multi_image_picker").spartanMultiImagePicker({
                fieldName: 'identity_images[]',
                maxCount: 2,
                rowHeight: '170px',
                groupClassName: 'item',
                maxFileSize: '2097152',
                dropFileLabel: "<?php echo e(translate('Drop_here')); ?>",
                placeholderImage: {
                    image: '<?php echo e(asset('public/assets/admin-module')); ?>/img/media/banner-upload-file.png',
                    width: '100%',
                },

                onRenderedPreview: function (index) {
                    toastr.success('<?php echo e(translate('Image_added')); ?>', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onRemoveRow: function (index) {
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

    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/select2/select2.min.js"></script>
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/js/section/employee/custom.js"></script>


<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/AdminModule/Resources/views/admin/employee/create.blade.php ENDPATH**/ ?>