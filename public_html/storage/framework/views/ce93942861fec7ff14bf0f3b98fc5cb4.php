<?php $__env->startSection('title',translate('promotional_banners')); ?>

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
                        <h2 class="page-title"><?php echo e(translate('promotional_banners')); ?></h2>
                    </div>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('banner_add')): ?>
                        <div class="card mb-30">
                            <div class="card-body p-30">
                                <form action="<?php echo e(route('admin.banner.store')); ?>" method="POST"
                                      enctype="multipart/form-data"
                                      onSubmit="return validate();">
                                    <?php echo csrf_field(); ?>
                                    <div class="row">
                                        <div class="col-lg-6 mb-4 mb-lg-0">
                                            <div class="form-floating form-floating__icon mb-30">
                                                <input type="text" class="form-control" name="banner_title"
                                                       placeholder="<?php echo e(translate('title')); ?> *" maxlength="190"
                                                       required="">
                                                <label><?php echo e(translate('title')); ?> *</label>
                                                <span class="material-icons">title</span>
                                            </div>

                                            <div class="mb-3"><?php echo e(translate('resource_type')); ?></div>
                                            <div class="d-flex flex-wrap align-items-center gap-4 mb-30">
                                                <div class="custom-radio">
                                                    <input type="radio" id="category" name="resource_type"
                                                           value="category"
                                                           checked>
                                                    <label for="category"><?php echo e(translate('category_wise')); ?></label>
                                                </div>
                                                <div class="custom-radio">
                                                    <input type="radio" id="service" name="resource_type"
                                                           value="service">
                                                    <label for="service"><?php echo e(translate('service_wise')); ?></label>
                                                </div>
                                                <div class="custom-radio">
                                                    <input type="radio" id="redirect_link" name="resource_type"
                                                           value="link">
                                                    <label for="redirect_link"><?php echo e(translate('redirect_link')); ?></label>
                                                </div>
                                            </div>

                                            <div class="mb-30" id="category_selector">
                                                <select class="js-select theme-input-style w-100" name="category_id">
                                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            <div class="mb-30 service_selector" id="service_selector">
                                                <select class="js-select theme-input-style w-100" name="service_id">
                                                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($service->id); ?>"><?php echo e($service->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            <div class="form-floating form-floating__icon mb-30 link_selector"
                                                 id="link_selector">
                                                <input type="url" class="form-control"
                                                       placeholder="<?php echo e(translate('redirect_link')); ?>"
                                                       name="redirect_link">
                                                <label><?php echo e(translate('redirect_link')); ?></label>
                                                <span class="material-icons">link</span>
                                            </div>

                                        </div>
                                        <div class="col-lg-6">
                                            <div class="d-flex flex-column align-items-center gap-3">
                                                <p class="title-color mb-0"><?php echo e(translate('upload_cover_image')); ?></p>
                                                <div>
                                                    <div class="upload-file">
                                                        <input type="file" class="upload-file__input"
                                                               name="banner_image"
                                                               accept=".<?php echo e(implode(',.', array_column(IMAGEEXTENSION, 'key'))); ?>, |image/*">
                                                        <div class="upload-file__img upload-file__img_banner">
                                                            <img
                                                                src="<?php echo e(asset('public/assets/admin-module/img/media/banner-upload-file.png')); ?>"
                                                                alt="<?php echo e(translate('banner')); ?>">
                                                        </div>
                                                        <span class="upload-file__edit">
                                                        <span class="material-icons">edit</span>
                                                    </span>
                                                    </div>
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
                                                <button class="btn btn--primary"
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
                                <a class="nav-link <?php echo e($resourceType=='all'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?resource_type=all">
                                    <?php echo e(translate('all')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($resourceType=='category'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?resource_type=category">
                                    <?php echo e(translate('category_wise')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($resourceType=='service'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?resource_type=service">
                                    <?php echo e(translate('service_wise')); ?>

                                </a>
                            </li>
                        </ul>

                        <div class="d-flex gap-2 fw-medium">
                            <span class="opacity-75"><?php echo e(translate('Total_Banners')); ?>:</span>
                            <span class="title-color"><?php echo e($banners->total()); ?></span>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between">
                                <form action="<?php echo e(url()->current()); ?>?resource_type=<?php echo e($resourceType); ?>"
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
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('banner_export')): ?>
                                        <div class="dropdown">
                                            <button type="button"
                                                    class="btn btn--secondary text-capitalize dropdown-toggle"
                                                    data-bs-toggle="dropdown">
                                            <span
                                                class="material-icons">file_download</span> <?php echo e(translate('download')); ?>

                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                                <a class="dropdown-item"
                                                   href="<?php echo e(route('admin.banner.download')); ?>?search=<?php echo e($search); ?>">
                                                    <?php echo e(translate('excel')); ?>

                                                </a>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="example" class="table align-middle">
                                    <thead>
                                    <tr>
                                        <th><?php echo e(translate('sl')); ?></th>
                                        <th><?php echo e(translate('title')); ?></th>
                                        <th><?php echo e(translate('type')); ?></th>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('banner_manage_status')): ?>
                                            <th><?php echo e(translate('status')); ?></th>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['banner_delete', 'banner_update'])): ?>
                                            <th><?php echo e(translate('action')); ?></th>
                                        <?php endif; ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($key+$banners->firstItem()); ?></td>
                                            <td><?php echo e($item->banner_title); ?></td>
                                            <td><?php echo e($item->resource_type); ?></td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('banner_manage_status')): ?>
                                                <td>
                                                    <label class="switcher">
                                                        <input class="switcher_input"
                                                               data-status="<?php echo e($item->id); ?>"
                                                               type="checkbox" <?php echo e($item->is_active?'checked':''); ?>>
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                </td>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['banner_delete', 'banner_update'])): ?>
                                                <td>
                                                    <div class="table-actions">
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('banner_update')): ?>
                                                            <a href="<?php echo e(route('admin.banner.edit',[$item->id])); ?>"
                                                               class="action-btn btn--light-primary">
                                                                <span class="material-icons">edit</span>
                                                            </a>
                                                        <?php endif; ?>
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('banner_delete')): ?>
                                                            <button type="button"
                                                                    data-id="<?php echo e($item->id); ?>"
                                                                    class="action-btn btn--danger delete_section">
                                                                <span class="material-icons">delete</span>
                                                            </button>
                                                            <form action="<?php echo e(route('admin.banner.delete',[$item->id])); ?>"
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
                                <?php echo $banners->links(); ?>

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
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/jquery.dataTables.min.js"></script>
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/dataTables.select.min.js"></script>
    <script>
        "use Strict";

        $('.switcher_input').on('click', function () {
            let itemId = $(this).data('status');
            let route = '<?php echo e(route('admin.banner.status-update', ['id' => ':itemId'])); ?>';
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

        $('#category').on('click', function () {
            $('#category_selector').show();
            $('#service_selector').hide();
            $('#link_selector').hide();
        });

        $('#service').on('click', function () {
            $('#category_selector').hide();
            $('#service_selector').show();
            $('#link_selector').hide();
        });

        $('#redirect_link').on('click', function () {
            $('#category_selector').hide();
            $('#service_selector').hide();
            $('#link_selector').show();
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/PromotionManagement/Resources/views/admin/promotional-banners/create.blade.php ENDPATH**/ ?>