<?php $__env->startSection('title',translate('Send Notification')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/select2/select2.min.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/select.dataTables.min.css"/>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap mb-3">
                        <h2 class="page-title"><?php echo e(translate('push_notification')); ?></h2>
                    </div>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('push_notification_add')): ?>
                        <div class="card mb-30">
                            <div class="card-body p-30">
                                <form action="<?php echo e(route('admin.push-notification.store')); ?>" method="POST"
                                      enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <div class="row">
                                        <div class="col-lg-6 mb-4 mb-lg-0">
                                            <div class="form-floating form-floating__icon mb-30">
                                                <input type="text" class="form-control" id="floatingInput" name="title"
                                                       placeholder="Title" maxlength="191" required="">
                                                <label for="floatingInput"><?php echo e(translate('title')); ?></label>
                                                <span class="material-icons">title</span>
                                            </div>
                                            <div class="form-floating mb-30">
                                            <textarea class="form-control resize-none" id="floatingInput2"
                                                      placeholder="<?php echo e(translate('description')); ?>"
                                                      name="description"></textarea>
                                                <label for="floatingInput2"><?php echo e(translate('description')); ?></label>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-30">
                                                        <select class="select-zone theme-input-style w-100"
                                                                name="zone_ids[]" id="zone_selector__select"
                                                                multiple="multiple">
                                                            <option value="all"><?php echo e(translate('Select All')); ?></option>
                                                            <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($zone->id); ?>"><?php echo e($zone->name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-30">
                                                        <select class="select-user theme-input-style w-100"
                                                                name="to_users[]" id="user_selector__select"
                                                                multiple="multiple">
                                                            <option value="all"><?php echo e(translate('all')); ?></option>
                                                            <option value="customer"><?php echo e(translate('customer')); ?></option>
                                                            <option value="provider-admin">
                                                                <?php echo e(translate('provider')); ?>

                                                            </option>
                                                            <option value="provider-serviceman">
                                                                <?php echo e(translate('serviceman')); ?>

                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="d-flex flex-column align-items-center gap-3">
                                                <p class="title-color mb-0"><?php echo e(translate('upload_cover_image')); ?></p>

                                                <div class="upload-file">
                                                    <input type="file" class="upload-file__input" name="cover_image"
                                                           accept=".<?php echo e(implode(',.', array_column(IMAGEEXTENSION, 'key'))); ?>, |image/*">
                                                    <div class="upload-file__img upload-file__img_banner">
                                                        <img
                                                            src="<?php echo e(asset('public/assets/admin-module/img/media/banner-upload-file.png')); ?>"
                                                            alt="<?php echo e(translate('notification')); ?>">
                                                    </div>
                                                    <span class="upload-file__edit">
                                                    <span class="material-icons">edit</span>
                                                </span>
                                                </div>

                                                <p class="opacity-75 max-w220 mx-auto"><?php echo e(translate('Image format - jpg,
                                                png, jpeg, gif Image Size - maximum size 2 MB Image
                                                Ratio - 2:1')); ?></p>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex justify-content-end gap-20 mt-30">
                                                <button class="btn btn--secondary"
                                                        type="reset"><?php echo e(translate('reset')); ?></button>
                                                <button class="btn btn--primary demo_check"
                                                        type="submit"><?php echo e(translate('submit')); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div
                        class="d-flex flex-wrap justify-content-between align-items-center border-bottom mx-lg-4 mb-10 gap-3">
                        <ul class="nav nav--tabs">
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($toUserType=='all'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?to_user_type=all">
                                    <?php echo e(translate('all')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($toUserType=='customer'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?to_user_type=customer">
                                    <?php echo e(translate('customer')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($toUserType=='provider-admin'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?to_user_type=provider-admin">
                                    <?php echo e(translate('provider')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($toUserType=='provider-serviceman'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?to_user_type=provider-serviceman">
                                    <?php echo e(translate('serviceman')); ?>

                                </a>
                            </li>
                        </ul>

                        <div class="d-flex gap-2 fw-medium">
                            <span class="opacity-75"><?php echo e(translate('Push_Notifications')); ?>:</span>
                            <span class="title-color"><?php echo e($pushNotification->total()); ?></span>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="all-tab-pane">
                            <div class="card">
                                <div class="card-body">
                                    <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between">
                                        <form action="<?php echo e(url()->current()); ?>?to_user_type=<?php echo e($toUserType); ?>"
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
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('push_notification_export')): ?>
                                                <div class="dropdown">
                                                    <button type="button"
                                                            class="btn btn--secondary text-capitalize dropdown-toggle"
                                                            data-bs-toggle="dropdown">
                                                    <span
                                                        class="material-icons">file_download</span> <?php echo e(translate('download')); ?>

                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                           href="<?php echo e(route('admin.push-notification.download')); ?>?search=<?php echo e($search); ?>">
                                                            <?php echo e(translate('excel')); ?>

                                                        </a>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="example" class="table align-middle">
                                            <thead class="text-nowrap">
                                            <tr>
                                                <th><?php echo e(translate('Sl')); ?></th>
                                                <th><?php echo e(translate('title')); ?></th>
                                                <th><?php echo e(translate('cover_image')); ?></th>
                                                <th><?php echo e(translate('send_to')); ?></th>
                                                <th><?php echo e(translate('zones')); ?></th>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('push_notification_manage_status')): ?>
                                                    <th><?php echo e(translate('status')); ?></th>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['push_notification_delete', 'push_notification_update'])): ?>
                                                    <th><?php echo e(translate('action')); ?></th>
                                                <?php endif; ?>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $__currentLoopData = $pushNotification; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($key+$pushNotification->firstItem()); ?></td>
                                                    <td><?php echo e($item->title); ?></td>
                                                    <td>
                                                        <img src="<?php echo e($item->cover_image_full_path); ?>" class="table-cover-img" alt="">
                                                    </td>
                                                    <td>
                                                        <?php $__currentLoopData = $item->to_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php echo e($user); ?><?php echo e($key+1==count($item->to_users)?'':','); ?>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </td>
                                                    <td>
                                                        <?php $__currentLoopData = $item->zone_ids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php echo e($zone['name']); ?><?php echo e($key+1==count($item->zone_ids)?'':','); ?>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </td>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('push_notification_manage_status')): ?>
                                                        <td>
                                                            <label class="switcher">
                                                                <input class="switcher_input"
                                                                       data-status="<?php echo e($item->id); ?>"
                                                                       type="checkbox" <?php echo e($item->is_active?'checked':''); ?>>
                                                                <span class="switcher_control"></span>
                                                            </label>
                                                        </td>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['push_notification_delete', 'push_notification_update'])): ?>
                                                        <td>
                                                            <div class="d-flex gap-2">
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('push_notification_update')): ?>
                                                                    <a href="<?php echo e(route('admin.push-notification.edit',[$item->id])); ?>"
                                                                       class="action-btn btn--light-primary">
                                                                        <span class="material-icons">edit</span>
                                                                    </a>
                                                                <?php endif; ?>
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('push_notification_delete')): ?>
                                                                    <button type="button"
                                                                            data-id="<?php echo e($item->id); ?>"
                                                                            class="action-btn btn--danger delete_section">
                                                                        <span class="material-icons">delete</span>
                                                                    </button>
                                                                    <form
                                                                        action="<?php echo e(route('admin.push-notification.delete',[$item->id])); ?>"
                                                                        method="post" id="delete-<?php echo e($item->id); ?>"
                                                                        class="hidden">
                                                                        <?php echo csrf_field(); ?>
                                                                        <?php echo method_field('DELETE'); ?>
                                                                    </form>
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <?php echo $pushNotification->links(); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/select2/select2.min.js"></script>
    <script>
        "use Strict";

        $('#user_selector__select').on('change', function () {
            var selectedValues = $(this).val();
            if (selectedValues !== null && selectedValues.includes('all')) {
                $(this).find('option').not(':disabled').prop('selected', 'selected');
                $(this).find('option[value="all"]').prop('selected', false);
            }
        });

        $('#zone_selector__select').on('change', function () {
            var selectedValues = $(this).val();
            if (selectedValues !== null && selectedValues.includes('all')) {
                $(this).find('option').not(':disabled').prop('selected', 'selected');
                $(this).find('option[value="all"]').prop('selected', false);
            }
        });

        $('.switcher_input').on('click', function () {
            let itemId = $(this).data('status');
            let route = '<?php echo e(route('admin.push-notification.status-update', ['id' => ':itemId'])); ?>';
            route = route.replace(':itemId', itemId);
            route_alert(route, '<?php echo e(translate('want_to_update_status')); ?>');
        })

        $('.delete_section').on('click', function () {
            let itemId = $(this).data('id');
            form_alert('delete-' + itemId, '<?php echo e(translate('want_to_delete_this')); ?>');
        })

        $(document).ready(function () {
            $('.js-select').select2();
        });

        $(document).ready(function () {
            $('.js-select').select2({
                placeholder: "<?php echo e(translate('select_items')); ?>",
            });
            $('.select-zone').select2({
                placeholder: "<?php echo e(translate('select_zones')); ?>",
            });
            $('.select-user').select2({
                placeholder: "<?php echo e(translate('select_users')); ?>",
            });
        });

    </script>
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/jquery.dataTables.min.js"></script>
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/dataTables.select.min.js"></script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/PromotionManagement/Resources/views/admin/push-notification/create.blade.php ENDPATH**/ ?>