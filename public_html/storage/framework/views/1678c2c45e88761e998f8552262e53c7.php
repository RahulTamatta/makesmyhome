<?php $__env->startSection('title',translate('database_backup')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between gap-2">
                <div class="page-title-wrap mb-3">
                    <h3 class="mb-2"><?php echo e(translate('database_Backup')); ?></h3>
                    <p class="text-muted"><?php echo e(translate('Safe guard Your Information with Database Backups')); ?></p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="bg-light p-30 rounded">
                        <div class="d-flex flex-column gap-2 align-items-start text-start mb-4">
                            <h4><?php echo e(translate('Update DUMP_BINARY_PATH')); ?>

                                <i class="material-icons" data-bs-toggle="tooltip"
                                   data-bs-placement="top"
                                   title="<?php echo e(translate('Find your mysqldump location and update here. Most of the time it is /usr/bin/. In case you are using differently, find your mysqldump by running command which mysqldump or locate mysqldump from your terminal, or ask your server provider')); ?>"
                                >info</i>
                            </h4>
                            <div class="">
                                <strong class="text-danger">Note:</strong> If your server's DUMP BINARY PATH does not match the following input field path, you must update it. To learn how to find the path <a href="" class="text-primary text-underline c1">Click Here</a> .
                            </div>
                        </div>
                        <form action="<?php echo e(route('admin.business-settings.database-backup.update-binary-path')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <div class="d-flex flex-wrap gap-3">
                                <input type="text" name="binary_path" value="<?php echo e(env('DUMP_BINARY_PATH')); ?>" class="form-control w-0 flex-grow-1" placeholder="<?php echo e(translate('/usr/bin')); ?>">
                                <button type="submit" class="btn px-xl-5 btn--primary radius-button text-end demo_check"><?php echo e(translate('Update')); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="bg-light p-30 rounded">
                        <div class="d-flex flex-column gap-3 align-items-center text-center mb-4 max-w360 mx-auto">
                            <h4><?php echo e(translate('Take database Backup')); ?></h4>
                            <p>
                                <strong class="text-danger"><?php echo e(translate('Attention')); ?>:</strong>
                                <?php echo e(translate('Must have to configure DUMP_BINARY_PATH before taking backup of the database.')); ?>

                            </p>
                        </div>
                        <div class="d-flex flex-wrap gap-3 justify-content-center">
                            <a class="btn btn--secondary text-capitalize <?php echo e(env('APP_ENV') != 'demo' ? 'db-backup' : 'demo_check'); ?> db-download"
                               data-route="<?php echo e(route('admin.business-settings.backup-database-backup', ['download' => 1])); ?>"
                               data-message="<?php echo e(translate('Want to take new backup').'?'); ?>">
                                <span class="material-icons">backup</span>
                                <?php echo e(translate('Backup to Server & Download')); ?>

                            </a>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('backup_view')): ?>
                                <a class="btn btn--primary <?php echo e(env('APP_ENV') != 'demo' ? 'db-backup' : 'demo_check'); ?> text-capitalize"
                                data-route="<?php echo e(route('admin.business-settings.backup-database-backup', ['download' => 0])); ?>"
                                data-message="<?php echo e(translate('Want to take new backup').'?'); ?>">
                                    <span class="material-icons">backup</span> <?php echo e(translate('Take a New Backup On your Server')); ?>

                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-wrap justify-content-end align-items-center border-bottom mx-lg-4 mb-10 gap-3">
                <div class="d-flex gap-2 fw-medium mb-1">
                    <span class="opacity-75"><?php echo e(translate('Total_Backup_Databases')); ?>:</span>
                    <span class="title-color"><?php echo e(count($fileNames)); ?></span>
                </div>
            </div>

            <div class="card mb-30">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table align-middle">
                            <thead>
                            <tr>
                                <th><?php echo e(translate('SL')); ?></th>
                                <th><?php echo e(translate('File_Name')); ?></th>
                                <th><?php echo e(translate('Backup Time')); ?></th>
                                <th><?php echo e(translate('File Size')); ?></th>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['backup_delete', 'backup_export', 'backup_add'])): ?>
                                    <th class="text-center"><?php echo e(translate('action')); ?></th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $fileNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($key+1); ?></td>
                                    <td><?php echo e($file['name']); ?></td>
                                    <td><?php echo e($file['last_modified']); ?></td>
                                    <td><?php echo e($file['size']); ?></td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['backup_delete', 'backup_export', 'backup_add'])): ?>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-center">
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('backup_add')): ?>
                                                    <button type="button" class="action-btn btn--light-primary db-restore demo_check"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="<?php echo e(env('APP_ENV') != 'demo' ? '#restoreModal_' . $key : ''); ?>"
                                                            title="<?php echo e(translate('Restore')); ?>">
                                                        <span class="material-icons">settings_backup_restore</span>
                                                    </button>
                                                    <div class="modal fade" id="restoreModal_<?php echo e($key); ?>" tabindex="-1" aria-labelledby="restoreModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-body p-30">
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    <div class="d-flex flex-column gap-2 align-items-center text-center">
                                                                        <img class="mb-3" src="<?php echo e(asset('public/assets/admin-module')); ?>/img/ad_delete.svg" alt="">
                                                                        <h3 class="mb-2"><?php echo e(translate('Are you sure you want to restore this backup')); ?>?</h3>
                                                                        <p><?php echo e(translate('This action will replace the current database with the selected backup. Any unsaved changes made after the backup date will be lost.')); ?></p>
                                                                        <div class="d-flex gap-3 justify-content-center flex-wrap">
                                                                            <button type="button" class="btn btn--secondary text-capitalize" class="btn-close" data-bs-dismiss="modal"><?php echo e(translate('Cancel')); ?></button>
                                                                            <a class="btn btn--primary text-capitalize demo_check" href="<?php echo e(route('admin.business-settings.restore-database-backup',[$file['name']])); ?>"><?php echo e(translate('Restore Backup')); ?></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('backup_export')): ?>
                                                        <button type="button" class="action-btn btn--success <?php echo e(env('APP_ENV') != 'demo' ? 'db-backup' : 'demo_check'); ?>" title="<?php echo e(translate('Download')); ?>"
                                                                data-route="<?php echo e(route('admin.business-settings.download-database-backup',[$file['name']])); ?>"
                                                                data-message="<?php echo e(translate('Do you really want to download the database locally')); ?>">
                                                            <span class="material-icons">download</span>
                                                        </button>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('backup_export')): ?>
                                                        <button type="button" class="action-btn btn--danger <?php echo e(env('APP_ENV') != 'demo' ? 'db-backup' : 'demo_check'); ?>" title="<?php echo e(translate('Remove')); ?>"
                                                                data-route="<?php echo e(route('admin.business-settings.delete-database-backup',[$file['name']])); ?>"
                                                                data-message="<?php echo e(translate('Do you really want to delete this file')); ?>">
                                                            <span class="material-icons">delete</span>
                                                        </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td class="text-center"
                                        colspan="5"><?php echo e(translate('No backup of the database has been taken yet')); ?></td>
                                </tr>
                            <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        "use strict";

        $('.db-download').on('click', function () {
            setTimeout(function() {
                location.reload();
            }, 5000);
        });

        $('.db-backup').on('click', function () {
            let route = $(this).data('route');
            let message = $(this).data('message');
            database_backup_modification(route, message)
        });

        function database_backup_modification(route, message) {
            Swal.fire({
                title: "<?php echo e(translate('are_you_sure')); ?>?",
                text: message,
                type: 'warning',
                showCloseButton: true,
                showCancelButton: true,
                cancelButtonColor: 'var(--c2)',
                confirmButtonColor: 'var(--c1)',
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    location.href = route;
                }
            })
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/BusinessSettingsModule/Resources/views/admin/database-backup.blade.php ENDPATH**/ ?>