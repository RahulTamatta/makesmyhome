<?php $__env->startSection('title',translate('category_setup')); ?>

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
                        <h2 class="page-title"><?php echo e(translate('category_setup')); ?></h2>
                    </div>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category_add')): ?>
                        <div class="card category-setup mb-30">
                            <div class="card-body p-30">
                                <form action="<?php echo e(route('admin.category.store')); ?>" method="post"
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
                                                <?php if($language): ?>
                                                    <div class="form-floating form-floating__icon mb-30 lang-form"
                                                         id="default-form">
                                                        <input type="text" name="name[]" class="form-control" required
                                                               placeholder="<?php echo e(translate('category_name')); ?>"
                                                               value="<?php echo e(old('name.0')); ?>">
                                                        <label><?php echo e(translate('category_name')); ?>(<?php echo e(translate('default')); ?>)</label>
                                                        <span class="material-icons">subtitles</span>
                                                    </div>
                                                    <input type="hidden" name="lang[]" value="default">
                                                    <?php $__currentLoopData = $language?->live_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div
                                                            class="form-floating form-floating__icon mb-30 d-none lang-form"
                                                            id="<?php echo e($lang['code']); ?>-form">
                                                            <input type="text" name="name[]" class="form-control"
                                                                   placeholder="<?php echo e(translate('category_name')); ?>"
                                                                   value="<?php echo e(old('name.' . ($index + 1))); ?>">
                                                            <label><?php echo e(translate('category_name')); ?>(<?php echo e(strtoupper($lang['code'])); ?>)</label>
                                                            <span class="material-icons">subtitles</span>
                                                        </div>
                                                        <input type="hidden" name="lang[]" value="<?php echo e($lang['code']); ?>">
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <div class="form-floating form-floating__icon mb-30">
                                                        <input type="text" name="name[]" class="form-control"
                                                               placeholder="<?php echo e(translate('category_name')); ?>" required
                                                               value="<?php echo e(old('name.0')); ?>">
                                                        <label><?php echo e(translate('category_name')); ?></label>
                                                        <span class="material-icons">subtitles</span>
                                                    </div>
                                                    <input type="hidden" name="lang[]" value="default">
                                                <?php endif; ?>

                                                <select class="select-zone theme-input-style w-100" name="zone_ids[]" multiple="multiple" id="zone_selector__select" required>
                                                    <option value="all"  <?php echo e((old('zone_ids') && in_array('all', old('zone_ids'))) ? 'selected' : ''); ?>><?php echo e(translate('Select All')); ?></option>
                                                    <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($zone['id']); ?>" <?php echo e((old('zone_ids') && in_array($zone['id'], old('zone_ids'))) ? 'selected' : ''); ?>><?php echo e($zone->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="d-flex  gap-3 gap-xl-5">
                                                <p class="opacity-75 max-w220"><?php echo e(translate('image_format_-_jpg,_png,_jpeg,_gif_image
                                                size_-_
                                                maximum_size_2_MB_Image_Ratio_-_1:1')); ?></p>
                                                <div class="d-flex align-items-center flex-column">
                                                    <div class="upload-file">
                                                        <input type="file" class="upload-file__input" name="image" required
                                                               accept=".<?php echo e(implode(',.', array_column(IMAGEEXTENSION, 'key'))); ?>, |image/*">
                                                        <div class="upload-file__img">
                                                            <img
                                                                src="<?php echo e(asset('public/assets/admin-module/img/media/upload-file.png')); ?>"
                                                                alt="<?php echo e(translate('image')); ?>">
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
                                                <button class="btn btn--secondary" type="reset"><?php echo e(translate('reset')); ?></button>
                                                <button class="btn btn--primary" type="submit"><?php echo e(translate('submit')); ?>

                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="d-flex flex-wrap justify-content-between align-items-center border-bottom mx-lg-4 mb-10 gap-3">
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
                            <span class="opacity-75"><?php echo e(translate('Total_Categories')); ?>:</span>
                            <span class="title-color" id="totalListCount"><?php echo e($categories->total()); ?></span>
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
                                                               href="<?php echo e(route('admin.category.download')); ?>?search=<?php echo e($search); ?>"><?php echo e(translate('excel')); ?></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div id="ListTableContainer">
                                        <?php echo $__env->make('categorymanagement::admin.partials._table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="offset" value="<?php echo e(request()->page); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/select2/select2.min.js"></script>
    <script src="<?php echo e(asset('public/assets/category-module')); ?>/js/category/create.js"></script>
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/jquery.dataTables.min.js"></script>
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/dataTables.select.min.js"></script>

    <script>
        "use strict"

        $('#zone_selector__select').on('change', function () {
            var selectedValues = $(this).val();
            if (selectedValues !== null && selectedValues.includes('all')) {
                $(this).find('option').not(':disabled').prop('selected', 'selected');
                $(this).find('option[value="all"]').prop('selected', false);
            }
        });

        $('.feature-update').on('change', function (event) {
            event.preventDefault();
            let $this = $(this);
            let initialState = $this.prop('checked'); // Save initial state
            let itemId = $(this).data('featured');
            let route = '<?php echo e(route('admin.category.featured-update',['id' => ':itemId'])); ?>';
            route = route.replace(':itemId', itemId);
            route_alert(route, '<?php echo e(translate('want_to_update_feature_status')); ?>', $this, initialState);
        })

        $('button[type="reset"]').on('click', function () {
            $('#zone_selector__select option').prop('selected', false).trigger('change');
        });

        let selectedItem;
        let selectedRoute;
        let initialState;
        let currentStatus = "<?php echo e(request('status', 'all')); ?>"; // Keep the current tab status

        $('.nav-link').on('click', function () {
            const urlParams = new URLSearchParams($(this).attr('href').split('?')[1]);
            currentStatus = urlParams.get('status') || 'all';
        });

        // Attach event listener for status change with event delegation
        $(document).on('change', '.status-update', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            selectedItem = $(this);
            initialState = selectedItem.prop('checked');

            // Revert checkbox visual state until confirmation
            selectedItem.prop('checked', !initialState);

            let itemId = selectedItem.data('id');
            selectedRoute = '<?php echo e(route('admin.category.status-update', ['id' => ':itemId'])); ?>'.replace(':itemId', itemId);

            let confirmationTitleText = initialState
                ? '<?php echo e(translate('Are you sure to Turn On the Category Status')); ?>?'
                : '<?php echo e(translate('Are you sure to Turn Off the Category Status')); ?>?';

            $('.confirmation-title-text').text(confirmationTitleText);

            let confirmationDescriptionText = initialState
                ? '<?php echo e(translate('Once you turn on the Category Status, the user can find the Category and its service for selection')); ?>.'
                : '<?php echo e(translate('Once you turn off the Category Status, the Provider can’t subscribe to the services of that category and the Customer can’t find the category & its service when they want to book')); ?>.';

            $('.confirmation-description-text').text(confirmationDescriptionText);

            let imgSrc = initialState
                ? "<?php echo e(asset('public/assets/admin-module/img/icons/status-on.png')); ?>"
                : "<?php echo e(asset('public/assets/admin-module/img/icons/status-off.png')); ?>";

            $('#confirmChangeModal img').attr('src', imgSrc);

            showModal();
        });

        $('#confirmChange').on('click', function () {
            updateStatus(selectedRoute);
        });

        //  Cancel and reset checkbox state
        $('.cancel-change').on('click', function () {
            resetCheckboxState();
            hideModal();
        });

        $('#confirmChangeModal').on('hidden.bs.modal', function () {
            resetCheckboxState();
        });

        //  Show/hide modal functions
        function showModal() {
            $('#confirmChangeModal').modal('show');
        }
        function hideModal() {
            $('#confirmChangeModal').modal('hide');
        }

        //  Reset the checkbox if change canceled
        function resetCheckboxState() {
            if (selectedItem) {
                selectedItem.prop('checked', !initialState);
            }
        }

        //  Submit the status change with AJAX
        function updateStatus(route) {
            let page = $('#offset').val();
            $.ajax({
                url: route,
                type: 'POST',
                data: {_token: '<?php echo e(csrf_token()); ?>'},
                dataType: 'json',
                success: function (data) {
                    toastr.success(data.message, {
                        CloseButton: true,
                        ProgressBar: true
                    });
                    reloadTable(currentStatus, page);
                    hideModal();
                },
                error: function () {
                    resetCheckboxState();
                    toastr.error('Something went wrong! Please try again.');
                }
            });
        }

        // Reload the table after status update
        function reloadTable(status, page) {
            let search = $('input[name="search"]').val();

            $.ajax({
                url: "<?php echo e(route('admin.category.table')); ?>",
                type: "GET",
                data: {
                    status: status,
                    search: search,
                    page: page
                },
                success: function (response) {
                    if (response.page != page) {
                        updateBrowserUrl(status, search, response.page);
                        $('#offset').val((response.page - 1) * <?php echo e(pagination_limit()); ?>);
                    } else {
                        $('#offset').val(response.offset);
                        updateBrowserUrl(status, search, page);
                    }

                    $('#totalListCount').html(response.totalCategory)
                    $('#ListTableContainer').empty().html(response.view);
                },
                error: function () {
                    toastr.error('Failed to update table. Please reload the page.', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        }

        // ✅ Update browser URL
        function updateBrowserUrl(status, search, page) {
            const params = new URLSearchParams();
            if (search) params.set('search', search);
            if (status) params.set('status', status);
            if (page > 1) params.set('page', page);

            const newUrl = `${window.location.pathname}?${params.toString()}`;
            window.history.replaceState({}, '', newUrl);
        }

    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/CategoryManagement/Resources/views/admin/create.blade.php ENDPATH**/ ?>