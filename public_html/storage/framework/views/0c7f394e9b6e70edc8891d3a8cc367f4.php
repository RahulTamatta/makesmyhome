<?php $__env->startSection('title', translate('role_settings')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/select.dataTables.min.css"/>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap d-flex justify-content-between gap-2 mb-3">
                        <h2 class="page-title"><?php echo e(translate('Employee_Role_Setup')); ?></h2>
                    </div>

                    <div class="card mb-30">
                        <div class="card-header shadow-none border-bottom">
                            <h4 class="mb-1"><?php echo e(translate('create_New_Role')); ?></h4>
                            <p class="fs-12"><?php echo e(translate('Create new role with access')); ?> </p>
                        </div>

                        <div class="card-body p-30">
                            <form action="<?php echo e(route('admin.role.store')); ?>" method="POST" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-lg-6 mb-4 mb-lg-0">
                                        <div class="form-floating form-floating__icon form-input-val-check">
                                            <input type="text" class="form-control" name="role_name" value="<?php echo e(old('role_name')); ?>"
                                                   placeholder="<?php echo e(translate('role_name')); ?> *" required="">
                                            <label><?php echo e(translate('role_name')); ?> *</label>
                                            <span class="material-icons">subtitles</span>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-4 mt-30">
                                            <div class="d-flex gap-4 align-items-center mb-1">
                                                <h4><?php echo e(translate('Permissions / Accesses')); ?></h4>

                                                <div
                                                    class="bg--secondary px-2 py-1 rounded d-flex gap-1 align-items-center">
                                                    <input class="" type="checkbox" value="" id="select_all">
                                                    <label class="user-select-none"
                                                           for="select_all"><?php echo e(translate('Select_All')); ?></label>
                                                </div>
                                            </div>
                                            <p><?php echo e(translate('Select the  options you want to give access to this role')); ?></p>
                                        </div>

                                        <div class="access-checkboxes">
                                            <div class="row gy-3">
                                                <?php $__currentLoopData = SYSTEM_MODULES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if(!isset($module['submodules']) && empty($module['submodules'])): ?>
                                                        <div class="col-sm-6 col-lg-3">
                                                            <div
                                                                class="bg--secondary px-3 py-2 rounded d-flex gap-1 align-items-center">
                                                                <label class="user-select-none flex-grow-1"
                                                                    for="<?php echo e($module['key']); ?>"><?php echo e($module['value']); ?></label>
                                                                <input type="checkbox" name="modules[<?php echo e($module['key']); ?>]"
                                                                    id="<?php echo e($module['key']); ?>">
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>

                                            <hr class="my-4">

                                            <div class="row g-4 mb-4">
                                                <?php $__currentLoopData = SYSTEM_MODULES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if(isset($module['submodules']) && !empty($module['submodules'])): ?>
                                                        <div class="col-md-6">
                                                            <div class="card checkbox_card overflow-hidden">
                                                                <div
                                                                    class="checkbox_card__head bg--secondary p-3 d-flex gap-1 align-items-center">
                                                                    <label class="user-select-none flex-grow-1"
                                                                        for="<?php echo e($module['key']); ?>"><?php echo e($module['value']); ?></label>
                                                                    <input class="" type="checkbox"
                                                                        name="section_modules[<?php echo e($module['key']); ?>]"
                                                                        id="<?php echo e($module['key']); ?>">
                                                                </div>

                                                                <div class="card-body">
                                                                    <div class="grid-columns">
                                                                        <?php $__currentLoopData = $module['submodules']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submodule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <div class="d-flex gap-1 align-items-center">
                                                                                <input class="mb-1" type="checkbox"
                                                                                    name="modules[<?php echo e($submodule['key']); ?>]"
                                                                                    id="<?php echo e($submodule['key']); ?>">
                                                                                <label class="user-select-none flex-grow-1"
                                                                                    for="<?php echo e($submodule['key']); ?>"><?php echo e($submodule['value']); ?></label>
                                                                            </div>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="col-12 mb-3 mt-4"><?php echo e(translate('Manage Access')); ?></h4>
                                    <div class="table-responsive">
                                        <table class="table align-middle border-bottom">
                                            <thead class="text-nowrap">
                                            <tr>
                                                <th class="text-center"><?php echo e(translate('Add')); ?></th>
                                                <th class="text-center"><?php echo e(translate('Update')); ?></th>
                                                <th class="text-center"><?php echo e(translate('Delete')); ?></th>
                                                <th class="text-center"><?php echo e(translate('Export')); ?></th>
                                                <th class="text-center"><?php echo e(translate('Status on/Off')); ?></th>
                                                <th class="text-center"><?php echo e(translate('Approve or Deny')); ?></th>
                                                <th class="text-center"><?php echo e(translate('Assign Serviceman')); ?></th>
                                                <th class="text-center"><?php echo e(translate('Give FeedBack')); ?></th>
                                                <th class="text-center"><?php echo e(translate('Take Backup')); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <label class="switcher mx-auto">
                                                        <input class="switcher_input" name="add" type="checkbox"
                                                               checked>
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="switcher mx-auto">
                                                        <input class="switcher_input" name="update" type="checkbox"
                                                               checked>
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="switcher mx-auto">
                                                        <input class="switcher_input" name="delete" type="checkbox"
                                                               checked>
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                </td>

                                                <td>
                                                    <label class="switcher mx-auto">
                                                        <input class="switcher_input" name="export" type="checkbox"
                                                               checked>
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="switcher mx-auto">
                                                        <input class="switcher_input" name="status" type="checkbox"
                                                               checked>
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="switcher mx-auto">
                                                        <input class="switcher_input" name="approve_or_deny" type="checkbox"
                                                               checked>
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="switcher mx-auto">
                                                        <input class="switcher_input" name="assign_serviceman" type="checkbox"
                                                               checked>
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="switcher mx-auto">
                                                        <input class="switcher_input" name="give_feedback" type="checkbox"
                                                               checked>
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="switcher mx-auto">
                                                        <input class="switcher_input" name="take_backup" type="checkbox"
                                                               checked>
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="alert-show">
                                        <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show mt-3 mb-0" role="alert">
                                            <div class="media gap-2">
                                                <img src="<?php echo e(asset('public/assets/admin-module/img/WarningOctagon.svg')); ?>" class="svg" alt="">
                                                <div class="media-body">
                                                    <?php echo e(translate('If no access is selected, employees with this role can only view the section for which permissions are granted; they cannot perform any actions.')); ?>

                                                </div>
                                            </div>
                                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    </div>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role_add')): ?>
                                        <div class="col-12">
                                            <div class="d-flex justify-content-end gap-20 mt-5">
                                                <button class="btn btn--secondary"
                                                        type="reset"><?php echo e(translate('reset')); ?></button>
                                                <button class="btn btn--primary" id="formSubmit"
                                                        type="submit"><?php echo e(translate('submit')); ?></button>
                                            </div>
                                        </div>
                                    <?php endif; ?>
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
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/js/custom.js"></script>
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/jquery.dataTables.min.js"></script>
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/dataTables.select.min.js"></script>
    <script>
        "use strict";

        $('#formSubmit').on('click', function (e) {
            if($('[name="role_name"]').val() === '') {
                e.preventDefault();
                if ($('.multi_image_picker_warning').length === 0) {
                    $('.form-input-val-check').after('<small class="text-danger d-flex mt-1 multi_image_picker_warning"><?php echo e(translate('Please fill out this field')); ?>.</small>');
                }
            }
        });

        $('#select_all').on('change', function () {
            $('.access-checkboxes input[type="checkbox"]').prop('checked', this.checked);
        });
        $('.access-checkboxes input[type="checkbox"]').on('change', function () {
            let allChecked = $('.access-checkboxes input[type="checkbox"]').length === $('.access-checkboxes input[type="checkbox"]:checked').length;
            $('#select_all').prop('checked', allChecked);
        });

        $('.checkbox_card__head input[type="checkbox"]').on('change', function () {
            $(this).closest('.checkbox_card').find('input[type="checkbox"]').prop('checked', this.checked);
        });
        $('.checkbox_card input[type="checkbox"]').on('change', function () {
            let allChecked = true;
            $(this).closest('.checkbox_card').find('.card-body input[type="checkbox"]').each(function () {
                if (!$(this).prop('checked')) {
                    allChecked = false;
                    return false;
                }
            });
            $(this).closest('.checkbox_card').find('.checkbox_card__head input[type="checkbox"]').prop('checked', allChecked);
        });


        function areAllInputsUnchecked() {
            var checkboxes = document.querySelectorAll('.table .switcher_input');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    return false;
                }
            }
            return true;
        }

        function toggleAlertShow() {
            var alertShowDiv = document.querySelector('.alert-show');
            if (areAllInputsUnchecked()) {
                alertShowDiv.style.display = 'block';
            } else {
                alertShowDiv.style.display = 'none';
            }
        }

        var checkboxes = document.querySelectorAll('.table .switcher_input');
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                toggleAlertShow();
            });
        });
        toggleAlertShow();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/AdminModule/Resources/views/admin/employee/role-create.blade.php ENDPATH**/ ?>