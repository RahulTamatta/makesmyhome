
<hr class="mb-30">
<?php $__currentLoopData = SYSTEM_MODULES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $buttonPermission = ['can_add', 'can_update', 'can_delete', 'can_export', 'can_manage_status','can_approve_or_deny','can_assign_serviceman','can_give_feedback','can_take_backup'];
        $matchedRoleBtn = $roleAccess->where('section_name', $module['key'])->first();
        $hasMatchingSubmodules = false;
    ?>
    <?php if(isset($module['submodules'])): ?>
        <?php $__currentLoopData = $module['submodules']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submodule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $matchedRoleSection = $roleAccess->where('section_name', $submodule['key'])->first();
                if($matchedRoleSection) {
                    $hasMatchingSubmodules = true;
                    break;
                }
            ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php if($hasMatchingSubmodules): ?>
            <div class="rounded border mb-3">
                <div class="card-body">
                    <h4><?php echo e($module['value']); ?></h4>
                    <hr>
                    <div class="grid-columns mt-4 pb-2">
                        <?php $tableRendered = false; ?>
                        <?php $__currentLoopData = $module['submodules']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submodule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $matchedRoleSection = $roleAccess->where('section_name', $submodule['key'])->first();
                            ?>
                                <div class="d-flex gap-1 align-items-center">
                                    <input class="mb-1" type="checkbox" name="modules[<?php echo e($module['key']); ?>][access_role][<?php echo e($submodule['key']); ?>]" id="<?php echo e($submodule['key']); ?>" <?php if($matchedRoleSection): ?> checked <?php endif; ?>>
                                    <label class="user-select-none flex-grow-1" for="<?php echo e($submodule['key']); ?>"><?php echo e($submodule['value']); ?></label>
                                </div>
                                <?php if($hasMatchingSubmodules && !$tableRendered): ?>
                                    <div class="span-full">
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
                                            <h4 class="mb-3 mt-4"><?php echo e(translate('Manage Access')); ?></h4>
                                            <div class="table-responsive">
                                                <table class="table align-middle border-bottom">
                                                    <thead class="text-nowrap">
                                                    <tr>
                                                        <?php $__currentLoopData = $buttonPermission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $permissionWords = explode('_', $permission);
                                                                $lastWord = end($permissionWords);
                                                            ?>
                                                            <th class="text-center"><?php echo e(translate(ucfirst(str_replace('_', ' ', $lastWord)))); ?></th>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <?php $__currentLoopData = $buttonPermission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <td>
                                                                <label class="switcher mx-auto">
                                                                    <input class="switcher_input" name="modules[<?php echo e($module['key']); ?>][<?php echo e($permission); ?>]" type="checkbox" <?php if($matchedRoleSection->$permission): ?> checked <?php endif; ?>> 
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </td>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php $tableRendered = true; ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php elseif($matchedRoleBtn): ?>
        <div class="rounded border mb-3">
            <div class="card-body">
                <h4><?php echo e($module['value']); ?></h4>
                <input type="hidden" name="modules[<?php echo e($module['key']); ?>][access_role][<?php echo e($module['key']); ?>]">
                <hr>
                <h4 class="mb-3 mt-4"><?php echo e(translate('Manage Access')); ?></h4>
                <div class="table-responsive">
                    <table class="table align-middle border-bottom">
                        <thead class="text-nowrap">
                        <tr>
                            <?php $__currentLoopData = $buttonPermission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $permissionWords = explode('_', $permission);
                                        $lastWord = end($permissionWords);
                                    ?>
                                    <th class="text-center"><?php echo e(translate(ucfirst(str_replace('_', ' ', $lastWord)))); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <?php $__currentLoopData = $buttonPermission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td>
                                    <label class="switcher mx-auto">
                                        <input class="switcher_input" name="modules[<?php echo e($module['key']); ?>][<?php echo e($permission); ?>]" type="checkbox" <?php if($matchedRoleBtn->$permission): ?> checked <?php endif; ?>>
                                        <span class="switcher_control"></span>
                                    </label>
                                </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/housecraft/public_html/Modules/AdminModule/Resources/views/layouts/partials/employee-update-access.blade.php ENDPATH**/ ?>