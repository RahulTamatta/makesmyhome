<?php $__env->startSection('title', translate('employee_list')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/select.dataTables.min.css"/>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap d-flex justify-content-between flex-wrap align-items-center gap-3 mb-3">
                        <h2 class="page-title"><?php echo e(translate('employee_list')); ?></h2>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('employee_add')): ?>
                            <div>
                                <a href="<?php echo e(route('admin.employee.create')); ?>" class="btn btn--primary">
                                    <span class="material-icons">add</span>
                                    <?php echo e(translate('add_employee')); ?>

                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div
                        class="d-flex flex-wrap justify-content-between align-items-center border-bottom mx-lg-4 mb-10 gap-3">
                        <ul class="nav nav--tabs">
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($status=='all'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?status=all">
                                    <?php echo e(translate('all')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($status=='active'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?status=active">
                                    <?php echo e(translate('active')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($status=='inactive'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?status=inactive">
                                    <?php echo e(translate('inactive')); ?>

                                </a>
                            </li>
                        </ul>

                        <div class="d-flex gap-2 fw-medium">
                            <span class="opacity-75"><?php echo e(translate('Total_Employees')); ?>:</span>
                            <span class="title-color"><?php echo e($employees->total()); ?></span>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between">
                                <form action="<?php echo e(url()->current()); ?>?status=<?php echo e($status); ?>"
                                      class="search-form search-form_style-two"
                                      method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="input-group search-form__input_group">
                                    <span class="search-form__icon">
                                        <span class="material-icons">search</span>
                                    </span>
                                        <input type="search" class="theme-input-style search-form__input"
                                               value="<?php echo e($search); ?>" name="search"
                                               placeholder="<?php echo e(translate('search_here')); ?>">
                                    </div>
                                    <button type="submit"
                                            class="btn btn--primary"><?php echo e(translate('search')); ?></button>
                                </form>

                                <div class="d-flex flex-wrap align-items-center gap-3">
                                    <div class="dropdown">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('employee_export')): ?>
                                            <button type="button"
                                                    class="btn btn--secondary text-capitalize dropdown-toggle"
                                                    data-bs-toggle="dropdown">
                                                <span class="material-icons">file_download</span> download
                                            </button>
                                        <?php endif; ?>
                                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                            <a class="dropdown-item"
                                               href="<?php echo e(route('admin.employee.download')); ?>?search=<?php echo e($search); ?>">
                                                <?php echo e(translate('excel')); ?>

                                            </a>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="example" class="table align-middle">
                                    <thead>
                                    <tr>
                                        <th><?php echo e(translate('SL')); ?></th>
                                        <th><?php echo e(translate('Employee_Name')); ?></th>
                                        <th><?php echo e(translate('Employee_ID')); ?></th>
                                        <th><?php echo e(translate('Role')); ?></th>
                                        <th><?php echo e(translate('Permission')); ?>

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('employee_manage_status')): ?>
                                            <th class="text-center"><?php echo e(translate('status')); ?></th>
                                        <?php endif; ?>
                                        <th class="text-center"><?php echo e(translate('action')); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td data-bs-target="#exampleModal--<?php echo e($employee['id']); ?>"
                                                data-bs-toggle="modal"><?php echo e($key+$employees?->firstItem()); ?></td>
                                            <td>
                                                <div data-bs-target="#exampleModal--<?php echo e($employee['id']); ?>"
                                                     data-bs-toggle="modal"><?php echo e($employee->first_name); ?> <?php echo e($employee->last_name); ?></div>
                                                <a href="mailto:<?php echo e($employee->email); ?>"
                                                   class="fz-12 fw-medium"><?php echo e($employee->email); ?></a>

                                                <div class="modal fade cursor-auto" tabindex="-1"
                                                     id="exampleModal--<?php echo e($employee['id']); ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <div
                                                                    class="d-flex justify-content-between gap-3 mb-4">
                                                                    <h3 class="text-primary"><?php echo e(translate('Employee Details')); ?></h3>
                                                                    <div class="d-flex gap-3 align-items-center">
                                                                        <p class="text-primary font-weight-bold mb-0"><?php echo e($employee->is_active? translate('Active'): translate('Inactive')); ?></p>
                                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('employee_manage_status')): ?>
                                                                            <label class="switcher">
                                                                                <input class="switcher_input"
                                                                                       type="checkbox"
                                                                                       <?php echo e($employee->is_active?'checked':''); ?> data-status="<?php echo e($employee->id); ?>">
                                                                                <span class="switcher_control"></span>
                                                                            </label>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>

                                                                <form>
                                                                    <div class="row gy-3">
                                                                        <div class="col-lg-8">
                                                                            <div
                                                                                class="media align-items-center flex-wrap gap-xl-5 gap-4">
                                                                                <img width="260" src="<?php echo e($employee->profile_image_full_path); ?>"
                                                                                     class="dark-support shadow rounded"
                                                                                     alt="<?php echo e(translate('profile image')); ?>">
                                                                                <div class="media-body">
                                                                                    <h3 class="mb-2"><?php echo e($employee->first_name . ' ' .  $employee->last_name); ?></h3>
                                                                                    <div
                                                                                        class="fs-12 fw-medium text-primary mb-4">
                                                                                        <?php echo e(isset($employee?->roles[0]) ? $employee?->roles[0]['role_name'] : ''); ?>

                                                                                    </div>

                                                                                    <ul class="list-info">
                                                                                        <li>
                                                                                            <span
                                                                                                class="material-symbols-outlined">assignment_ind</span>
                                                                                            ID:
                                                                                            #<?php echo e($employee->id); ?>

                                                                                        </li>
                                                                                        <li>
                                                                                            <span
                                                                                                class="material-symbols-outlined">phone_iphone</span>
                                                                                            <a href="tel:<?php echo e($employee->phone); ?>"><?php echo e($employee->phone); ?></a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <span
                                                                                                class="material-symbols-outlined">mail</span>
                                                                                            <a href="mailto:<?php echo e($employee->email); ?>"><?php echo e($employee->email); ?></a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <span
                                                                                                class="material-symbols-outlined">map</span>
                                                                                            <?php echo e($employee->addresses->value('address') ??  'not found'); ?>

                                                                                        </li>
                                                                                        <li class="text-uppercase">
                                                                                            <span
                                                                                                class="material-symbols-outlined">credit_card</span>
                                                                                            <?php echo e(str_replace('_', " " , $employee->identification_type)); ?>

                                                                                            - <?php echo e($employee->identification_number); ?>

                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <div class="p-3 bg-light rounded scrollY" style="--mh:70dvh;">
                                                                                <div class="card border-0 mb-3">
                                                                                    <div
                                                                                        class="card-body d-flex align-items-center gap-2">
                                                                                        <span
                                                                                            class="material-symbols-outlined text-primary">calendar_month</span>
                                                                                        Join: <?php echo e($employee->created_at); ?>

                                                                                    </div>
                                                                                </div>
                                                                                <?php $__currentLoopData = SYSTEM_MODULES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roleName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                    <?php
                                                                                        $buttonPermission = ['can_add', 'can_update', 'can_delete', 'can_export', 'can_manage_status','can_download','can_assign_serviceman','can_give_feedback','can_take_backup'];
                                                                                            $matchedRoleSectionName = Modules\UserManagement\Entities\EmployeeRoleAccess::where('employee_id', $employee['id'])->where('section_name', $roleName['key'])->first();
                                                                                            $matchingSubmodules = false;
                                                                                    ?>
                                                                                    <?php if(isset($roleName['submodules'])): ?>
                                                                                        <?php $__currentLoopData = $roleName['submodules']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submodule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                            <?php
                                                                                                $matchedRoleSection = Modules\UserManagement\Entities\EmployeeRoleAccess::where('employee_id', $employee['id'])->where('section_name', $submodule['key'])->first();
                                                                                                if($matchedRoleSection) {
                                                                                                    $matchingSubmodules = true;
                                                                                                    break;
                                                                                                }
                                                                                            ?>
                                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                                        <?php if($matchingSubmodules): ?>
                                                                                            <?php $tableRendered = false; ?>
                                                                                            <div class="card border-0  mb-3">
                                                                                                <div class="card-body">
                                                                                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                                                                                                        <div class="d-flex align-items-center gap-2">
                                                                                                            <h4><?php echo e($roleName['value']); ?></h4>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                        <?php $__currentLoopData = $roleName['submodules']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submodule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                                            <?php
                                                                                                                $matchedRoleSection = Modules\UserManagement\Entities\EmployeeRoleAccess::where('employee_id', $employee['id'])->where('section_name', $submodule['key'])->first();
                                                                                                            ?>
                                                                                                            <?php if($matchedRoleSection): ?>
                                                                                                            <div class="">
                                                                                                                <h4 class="mt-4"><?php echo e($submodule['value']); ?></h4>
                                                                                                            </div>
                                                                                                                <?php if($matchingSubmodules): ?>
                                                                                                                    <?php
                                                                                                                        $showManageAccess = false;

                                                                                                                        foreach ($buttonPermission as $permission) {
                                                                                                                            if ($permission === 'can_view') {
                                                                                                                                continue;
                                                                                                                            }

                                                                                                                            if (isset($matchedRoleSection[$permission]) && $matchedRoleSection[$permission] === 1) {
                                                                                                                                $showManageAccess = true;
                                                                                                                                break;
                                                                                                                            }
                                                                                                                        }
                                                                                                                    ?>
                                                                                                                    <?php if($showManageAccess): ?>
                                                                                                                        <div class="">
                                                                                                                            <h5 class="mb-3 mt-2"><?php echo e(translate('Manage Access')); ?></h5>
                                                                                                                            <div class="d-flex flex-wrap gap-2 align-items-center scrollY">

                                                                                                                                <?php $tableRendered = true; ?>
                                                                                                                                <?php $__currentLoopData = $buttonPermission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                                                                    <?php if($matchedRoleSection->$permission): ?>
                                                                                                                                        <?php
                                                                                                                                            $permissionWords = explode('_', $permission);
                                                                                                                                            $formattedPermission = implode(' ', $permissionWords);
                                                                                                                                        ?>
                                                                                                                                        <span class="badge bg-custom title-color"><?php echo e(ucwords($formattedPermission)); ?></span>
                                                                                                                                    <?php endif; ?>
                                                                                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    <?php endif; ?>
                                                                                                                <?php endif; ?>
                                                                                                            <?php endif; ?>
                                                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        <?php endif; ?>
                                                                                    <?php elseif($matchedRoleSectionName): ?>
                                                                                        <div class="card border-0  mb-3">
                                                                                            <div class="card-body">
                                                                                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                                                                                                    <div class="d-flex align-items-center gap-2">
                                                                                                        <h4><?php echo e($roleName['value']); ?></h4>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <?php
                                                                                                    $showManageAccess = false;

                                                                                                    foreach ($buttonPermission as $permission) {
                                                                                                        if ($permission === 'can_view') {
                                                                                                            continue;
                                                                                                        }

                                                                                                        if (isset($matchedRoleSectionName[$permission]) && $matchedRoleSectionName[$permission] === 1) {
                                                                                                            $showManageAccess = true;
                                                                                                            break;
                                                                                                        }
                                                                                                    }
                                                                                                ?>
                                                                                                <?php if($showManageAccess): ?>
                                                                                                    <h5 class="mb-3 mt-4"><?php echo e(translate('Manage Access')); ?></h5>
                                                                                                    <div class="d-flex flex-wrap gap-2 align-items-center scrollY">
                                                                                                        <?php $__currentLoopData = $buttonPermission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                                            <?php if($matchedRoleSectionName->$permission): ?>
                                                                                                                <?php
                                                                                                                    $permissionWords = explode('_', $permission);
                                                                                                                    $formattedPermission = implode(' ', $permissionWords);
                                                                                                                ?>
                                                                                                                <span class="badge bg-custom title-color"><?php echo e(ucwords($formattedPermission)); ?></span>
                                                                                                            <?php endif; ?>
                                                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                                                    </div>
                                                                                                <?php endif; ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php endif; ?>
                                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div
                                                                                class="d-flex justify-content-end gap-3">
                                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('employee_delete')): ?>
                                                                                    <button type="button"
                                                                                            data-remove="<?php echo e($employee->id); ?>"
                                                                                            class="btn btn--danger remove">
                                                                                        <?php echo e(translate('Delete')); ?></button>

                                                                                    <form
                                                                                        action="<?php echo e(route('admin.employee.delete',[$employee->id])); ?>"
                                                                                        method="post"
                                                                                        id="delete-<?php echo e($employee->id); ?>"
                                                                                        class="hidden">
                                                                                        <?php echo csrf_field(); ?>
                                                                                        <?php echo method_field('DELETE'); ?>
                                                                                    </form>
                                                                                <?php endif; ?>
                                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('employee_update')): ?>
                                                                                    <a type="text"
                                                                                       href="<?php echo e(route('admin.employee.edit', [$employee->id])); ?>"
                                                                                       class="btn btn-primary"><?php echo e(translate('edit')); ?></a>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo e($employee->id); ?></td>
                                            <td data-bs-target="#exampleModal--<?php echo e($employee['id']); ?>"
                                                data-bs-toggle="modal">
                                                <?php echo e(isset($employee?->roles[0]) ? $employee?->roles[0]['role_name'] : ''); ?>

                                            </td>
                                            <td>
                                                <?php
                                                    $output = '';
                                                ?>

                                                <?php $__currentLoopData = SYSTEM_MODULES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $matchedRoleBtn = Modules\UserManagement\Entities\EmployeeRoleAccess::where('employee_id', $employee['id'])->where('section_name', $module['key'])->first();
                                                        $hasMatchingSubmodules = false;
                                                    ?>

                                                    <?php if(isset($module['submodules'])): ?>
                                                        <?php $__currentLoopData = $module['submodules']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submodule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $matchedRoleSection = Modules\UserManagement\Entities\EmployeeRoleAccess::where('employee_id', $employee['id'])->where('section_name', $submodule['key'])->first();
                                                                if($matchedRoleSection) {
                                                                    $hasMatchingSubmodules = true;
                                                                    break;
                                                                }
                                                            ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                        <?php if($hasMatchingSubmodules): ?>
                                                            <?php
                                                                $output .= $module['value'] . ' (';
                                                                $submodulesOutput = '';
                                                            ?>

                                                            <?php $__currentLoopData = $module['submodules']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submodule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php
                                                                    $matchedRoleSection = Modules\UserManagement\Entities\EmployeeRoleAccess::where('employee_id', $employee['id'])->where('section_name', $submodule['key'])->first();
                                                                ?>
                                                                <?php if($matchedRoleSection): ?>
                                                                    <?php
                                                                        $submodulesOutput .= $submodule['value'] . ', ';
                                                                    ?>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                            <?php
                                                                $output .= rtrim($submodulesOutput, ', ') . '), ';
                                                            ?>
                                                        <?php endif; ?>
                                                    <?php elseif($matchedRoleBtn): ?>
                                                        <?php
                                                            $output .= $module['value'] . ', ';
                                                        ?>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                <h5><?php echo e(Str::limit(rtrim($output, ', '), 170)); ?></h5>
                                                <?php if(!empty($output)): ?>
                                                    <div class="fs-12"><?php echo e(translate('Edit/Delete/Export')); ?></div>
                                                <?php endif; ?>
                                            </td>

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('employee_manage_status')): ?>
                                                <td>
                                                    <label class="switcher mx-auto" data-bs-toggle="modal"
                                                           data-bs-target="#deactivateAlertModal">
                                                        <input class="switcher_input"
                                                               type="checkbox"
                                                               <?php echo e($employee->is_active?'checked':''); ?> data-status="<?php echo e($employee->id); ?>">
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                </td>
                                            <?php endif; ?>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <div class="dropdown dropdown__style--two">
                                                        <button type="button" class="bg-transparent border-0 title-color"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="material-symbols-outlined">more_vert</span>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('employee_view')): ?>
                                                                <a data-bs-target="#exampleModal--<?php echo e($employee['id']); ?>"
                                                                   data-bs-toggle="modal" class="dropdown-item"
                                                                   href="#"><?php echo e(translate('View Profile')); ?></a>
                                                            <?php endif; ?>
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('employee_update')): ?>
                                                                <a class="dropdown-item"
                                                                   href="<?php echo e(route('admin.employee.edit',[$employee->id])); ?>"><?php echo e(translate('Edit Employee')); ?></a>
                                                            <?php endif; ?>
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('employee_update')): ?>
                                                                <a class="dropdown-item"
                                                                   href="<?php echo e(route('admin.employee.set.permission',[$employee->id])); ?>"><?php echo e(translate('Set Permission')); ?></a>
                                                            <?php endif; ?>
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('employee_delete')): ?>
                                                                <button type="button" data-delete="<?php echo e($employee->id); ?>"
                                                                        class="dropdown-item delete-action"><?php echo e(translate('Delete Employee')); ?>

                                                                </button>
                                                                <form
                                                                    action="<?php echo e(route('admin.employee.delete',[$employee->id])); ?>"
                                                                    method="post" id="delete-<?php echo e($employee->id); ?>"
                                                                    class="hidden">
                                                                    <?php echo csrf_field(); ?>
                                                                    <?php echo method_field('DELETE'); ?>
                                                                </form>
                                                            <?php endif; ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="14"><p
                                                    class="text-center"><?php echo e(translate('no_data_available')); ?></p></td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                <?php echo $employees->links(); ?>

                            </div>
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
    <script>
        "use strict";

        $('.switcher_input').on('click', function () {
            let itemId = $(this).data('status');
            let route = '<?php echo e(route('admin.employee.status-update', ['id' => ':itemId'])); ?>';
            route = route.replace(':itemId', itemId);
            route_alert_reload(route, '<?php echo e(translate('want_to_update_status')); ?>');
        })

        $('.delete-action').on('click', function (event) {
            event.stopPropagation();
            let itemId = $(this).data('delete');
            <?php if(env('APP_ENV')!='demo'): ?>
            form_alert('delete-' + itemId, '<?php echo e(translate('want_to_delete_this_employee')); ?>?')
            <?php endif; ?>
        })

        $('.remove').on('click', function (event) {
            event.stopPropagation();
            let itemId = $(this).data('remove');
            <?php if(env('APP_ENV')!='demo'): ?>
            form_alert('delete-' + itemId, '<?php echo e(translate('want_to_delete_this_employee')); ?>?')
            <?php endif; ?>
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/AdminModule/Resources/views/admin/employee/list.blade.php ENDPATH**/ ?>