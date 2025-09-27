<?php $__env->startSection('title',translate('sub_category_setup')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module/plugins/select2/select2.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module/plugins/dataTables/jquery.dataTables.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module/plugins/dataTables/select.dataTables.min.css')); ?>"/>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap mb-3">
                        <h2 class="page-title"><?php echo e(translate('sub_category_setup')); ?></h2>
                    </div>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category_add')): ?>
                        <div class="card category-setup mb-30">
                            <div class="card-body p-30">
                                <form action="<?php echo e(route('admin.sub-category.store')); ?>" method="post"
                                      enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <?php ($language= Modules\BusinessSettingsModule\Entities\BusinessSettings::where('key_name','system_language')->first()); ?>
                                    <?php ($default_lang = str_replace('_', '-', app()->getLocale())); ?>
                                    <?php if($language): ?>
                                        <ul class="nav nav--tabs border-color-primary mb-4">
                                            <li class="nav-item">
                                                <a class="nav-link lang_link active"
                                                   href="#"
                                                   id="default-link"><?php echo e(translate('default')); ?></a>
                                            </li>
                                            <?php $__currentLoopData = $language?->live_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="nav-item">
                                                    <a class="nav-link lang_link"
                                                       href="#"
                                                       id="<?php echo e($lang['code']); ?>-link"><?php echo e(get_language_name($lang['code'])); ?></a>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    <?php endif; ?>
                                    <div class="row">
                                        <div class="col-lg-8 mb-5 mb-lg-0">
                                            <div class="d-flex flex-column">
                                                <select class="js-select theme-input-style w-100" name="parent_id" id="category_selector" required>
                                                    <option value="" selected
                                                            disabled><?php echo e(translate('Select_Category_Name')); ?></option>
                                                    <?php $__currentLoopData = $mainCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($item['id']); ?>"><?php echo e($item->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>

                                                <?php if($language): ?>
                                                    <div class="lang-form" id="default-form">
                                                        <div class="form-floating form-floating__icon mb-30 mt-30">
                                                            <input type="text" name="name[]" class="form-control"
                                                                   placeholder="<?php echo e(translate('sub_category_name')); ?>" value="<?php echo e(old('name.0')); ?>"
                                                                   required>
                                                            <label><?php echo e(translate('sub_category_name')); ?>(<?php echo e(translate('default')); ?>)</label>
                                                            <span class="material-icons">subtitles</span>
                                                        </div>

                                                        <div class="form-floating mb-30">
                                                            <textarea type="text" name="short_description[]" class="form-control resize-none" required><?php echo e(old('short_description.0')); ?></textarea>
                                                            <label><?php echo e(translate('short_description')); ?>(<?php echo e(translate('default')); ?>)</label>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="lang[]" value="default">
                                                    <?php $__currentLoopData = $language?->live_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="lang-form d-none" id="<?php echo e($lang['code']); ?>-form">
                                                            <div class="form-floating form-floating__icon mb-30 mt-30">
                                                                <input type="text" name="name[]" class="form-control"
                                                                       placeholder="<?php echo e(translate('sub_category_name')); ?>" value="<?php echo e(old('name.' . ($index + 1))); ?>">
                                                                <label><?php echo e(translate('sub_category_name')); ?>(<?php echo e(strtoupper($lang['code'])); ?>)</label>
                                                                <span class="material-icons">subtitles</span>
                                                            </div>

                                                            <div class="form-floating mb-30">
                                                            <textarea type="text" name="short_description[]"
                                                                      class="form-control resize-none"><?php echo e(old('short_description.' . ($index + 1))); ?></textarea>
                                                                <label><?php echo e(translate('short_description')); ?>

                                                                    (<?php echo e(strtoupper($lang['code'])); ?>)</label>
                                                            </div>
                                                            <input type="hidden" name="lang[]"
                                                                   value="<?php echo e($lang['code']); ?>">
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <div class="form-floating mb-30 mt-30 lang-form">
                                                        <input type="text" name="name[]" class="form-control"
                                                               value="<?php echo e(old('name.0')); ?>"
                                                               placeholder="<?php echo e(translate('sub_category_name')); ?>"
                                                               required>
                                                        <label><?php echo e(translate('sub_category_name')); ?>

                                                            (<?php echo e(translate('default')); ?>)</label>
                                                        <span class="material-icons">subtitles</span>
                                                    </div>

                                                    <div class="form-floating form-floating__icon mb-30">
                                                <textarea type="text" name="short_description[]"
                                                          class="form-control resize-none"
                                                          required></textarea>
                                                        <label><?php echo e(translate('short_description')); ?>

                                                            (<?php echo e(translate('default')); ?>)</label>
                                                    </div>

                                                    <input type="hidden" name="lang[]" value="default">
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="d-flex  gap-3 gap-xl-5">
                                                <p class="opacity-75 max-w220"><?php echo e(translate('image_format_-_jpg,_png,_jpeg,_gif_image
                                                size_-_
                                                maximum_size_2_MB_Image_Ratio_-_1:1')); ?></p>
                                                <div class="d-flex flex-column align-items-center">
                                                    <div class="upload-file">
                                                        <input type="file" class="upload-file__input" name="image"
                                                               accept=".<?php echo e(implode(',.', array_column(IMAGEEXTENSION, 'key'))); ?>, |image/*" required>
                                                        <div class="upload-file__img">
                                                            <img
                                                                src="<?php echo e(asset('public/assets/admin-module')); ?>/img/media/upload-file.png"
                                                                alt="">
                                                        </div>
                                                        <span class="upload-file__edit">
                                                        <span class="material-icons">edit</span>
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex justify-content-end gap-20 mt-30">
                                                <button class="btn btn--secondary"
                                                        type="reset"><?php echo e(translate('reset')); ?></button>
                                                <button class="btn btn--primary" type="submit"><?php echo e(translate('submit')); ?>

                                                </button>
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
                            <span class="opacity-75"><?php echo e(translate('Total_Sub_Categories')); ?>:</span>
                            <span class="title-color"><?php echo e($subCategories->total()); ?></span>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="all-tab-pane">
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

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category_export')): ?>
                                            <div class="d-flex flex-wrap align-items-center gap-3">
                                                <div class="dropdown">
                                                    <button type="button"
                                                            class="btn btn--secondary text-capitalize dropdown-toggle"
                                                            data-bs-toggle="dropdown">
                                                        <span class="material-icons">file_download</span> download
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo e(route('admin.sub-category.download')); ?>?search=<?php echo e($search); ?>"><?php echo e(translate('excel')); ?></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="example" class="table align-middle">
                                            <thead class="text-nowrap">
                                            <tr>
                                                <th><?php echo e(translate('SL')); ?></th>
                                                <th><?php echo e(translate('name')); ?></th>
                                                <th><?php echo e(translate('parent_category')); ?></th>
                                                <th><?php echo e(translate('service_count')); ?></th>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category_manage_status')): ?>
                                                    <th><?php echo e(translate('status')); ?></th>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['category_delete', 'category_update'])): ?>
                                                    <th><?php echo e(translate('action')); ?></th>
                                                <?php endif; ?>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $__currentLoopData = $subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($subCategories->firstitem()+$key); ?></td>
                                                    <td><?php echo e($category->name); ?></td>
                                                    <td><?php echo e($category->parent->name??translate('not_found')); ?></td>
                                                    <td><?php echo e($category->services_count); ?></td>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category_manage_status')): ?>
                                                        <td>
                                                            <label class="switcher" data-bs-toggle="modal"
                                                                   data-bs-target="#deactivateAlertModal">
                                                                <input class="switcher_input status-update"
                                                                       type="checkbox"
                                                                       <?php echo e($category->is_active?'checked':''); ?> data-status="<?php echo e($category->id); ?>">
                                                                <span class="switcher_control"></span>
                                                            </label>
                                                        </td>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['category_delete', 'category_update'])): ?>
                                                        <td>
                                                            <div class="d-flex gap-2">
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category_update')): ?>
                                                                    <a href="<?php echo e(route('admin.sub-category.edit',[$category->id])); ?>"
                                                                       class="action-btn btn--light-primary demo_check"
                                                                       style="--size: 30px">
                                                                        <span class="material-icons">edit</span>
                                                                    </a>
                                                                <?php endif; ?>
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category_delete')): ?>
                                                                    <button type="button"
                                                                            class="action-btn btn--danger demo_check"
                                                                            data-delete="<?php echo e($category->id); ?>"
                                                                            style="--size: 30px">
                                                                    <span
                                                                        class="material-symbols-outlined">delete</span>
                                                                    </button>
                                                                    <form
                                                                        action="<?php echo e(route('admin.sub-category.delete',[$category->id])); ?>"
                                                                        method="post" id="delete-<?php echo e($category->id); ?>"
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
                                        <?php echo $subCategories->links(); ?>

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
    <script src="<?php echo e(asset('public/assets/admin-module/plugins/select2/select2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/category-module/js/sub-category/create.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/admin-module/plugins/dataTables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/admin-module/plugins/dataTables/dataTables.select.min.js')); ?>"></script>
    <script>
        "use strict"

        $('.status-update').on('click', function () {
            let itemId = $(this).data('status');
            let route = '<?php echo e(route('admin.sub-category.status-update',['id' => ':itemId'])); ?>';
            route = route.replace(':itemId', itemId);
            route_alert(route, '<?php echo e(translate('want_to_update_status')); ?>');
        })

        $('.action-btn.btn--danger').on('click', function () {
            let itemId = $(this).data('delete');
            <?php if(env('APP_ENV')!='demo'): ?>
            form_alert('delete-' + itemId, '<?php echo e(translate('want_to_delete_this')); ?>?')
            <?php endif; ?>
        })

        $('button[type="reset"]').on('click', function (e) {
            $('#category_selector').val('').trigger('change');
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/CategoryManagement/Resources/views/admin/sub-category/create.blade.php ENDPATH**/ ?>