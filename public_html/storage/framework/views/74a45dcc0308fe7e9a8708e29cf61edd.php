<?php $__env->startSection('title',translate('service_update')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/select2/select2.min.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/select.dataTables.min.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/wysiwyg-editor/froala_editor.min.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/css/tags-input.min.css"/>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap mb-3">
                        <h2 class="page-title"><?php echo e(translate('update_service')); ?></h2>
                    </div>

                    <div class="card">
                        <div class="card-body p-30">
                            <form action="<?php echo e(route('admin.service.update',[$service->id])); ?>" method="post"
                                  enctype="multipart/form-data"
                                  id="service-add-form">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
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
                                <div id="form-wizard">
                                    <h3><?php echo e(translate('service_information')); ?></h3>
                                    <section>
                                        <div class="row">
                                            <div class="col-lg-5 mb-5 mb-lg-0">
                                                <?php if($language): ?>
                                                    <div class="form-floating form-floating__icon mb-30 lang-form" id="default-form">
                                                        <input type="text" name="name[]" class="form-control"
                                                               placeholder="<?php echo e(translate('service_name')); ?>"
                                                               value="<?php echo e($service?->getRawOriginal('name')); ?>" required>
                                                        <label><?php echo e(translate('service_name')); ?> (<?php echo e(translate('default')); ?>

                                                            )</label>
                                                        <span class="material-icons">subtitles</span>
                                                    </div>
                                                    <input type="hidden" name="lang[]" value="default">
                                                    <?php $__currentLoopData = $language?->live_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                            if (count($service['translations'])) {
                                                                $translate = [];
                                                                foreach ($service['translations'] as $t) {
                                                                    if ($t->locale == $lang['code'] && $t->key == "name") {
                                                                        $translate[$lang['code']]['name'] = $t->value;
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        <div class="form-floating form-floating__icon mb-30 d-none lang-form"
                                                             id="<?php echo e($lang['code']); ?>-form">
                                                            <input type="text" name="name[]" class="form-control"
                                                                   placeholder="<?php echo e(translate('service_name')); ?>"
                                                                   value="<?php echo e($translate[$lang['code']]['name']??''); ?>">
                                                            <label><?php echo e(translate('service_name')); ?>

                                                                (<?php echo e(strtoupper($lang['code'])); ?>)</label>
                                                            <span class="material-icons">subtitles</span>
                                                        </div>
                                                        <input type="hidden" name="lang[]" value="<?php echo e($lang['code']); ?>">
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <div class="lang-form">
                                                        <div class="mb-30">
                                                            <div class="form-floating form-floating__icon">
                                                                <input type="text" class="form-control" name="name[]"
                                                                       placeholder="<?php echo e(translate('service_name')); ?> *"
                                                                       required value="<?php echo e($service->name); ?>">
                                                                <label><?php echo e(translate('service_name')); ?> *</label>
                                                                <span class="material-icons">subtitles</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="lang[]" value="default">
                                                <?php endif; ?>
                                                <div class="mb-30">
                                                    <select class="js-select theme-input-style w-100" name="category_id"
                                                            id="category-id">
                                                        <option value="0" selected
                                                                disabled><?php echo e(translate('choose_category')); ?></option>
                                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option
                                                                value="<?php echo e($category->id); ?>" <?php echo e($category->id==$service->category_id?'selected':''); ?>>
                                                                <?php echo e($category->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                                <div class="mb-30" id="sub-category-selector">
                                                    <select class="js-select theme-input-style w-100"
                                                            name="sub_category_id"></select>
                                                </div>

                                                <div class="mb-30">
                                                    <div class="form-floating form-floating__icon">
                                                        <input type="text" class="form-control" name="tax" min="0"
                                                               max="100" step="0.01"
                                                               placeholder="<?php echo e(translate('add_tax_percentage')); ?> *"
                                                               required="" value="<?php echo e($service->tax); ?>">
                                                        <label><?php echo e(translate('add_tax_percentage')); ?> *</label>
                                                        <span class="material-icons">percent</span>
                                                    </div>
                                                </div>

                                                <div class="mb-30">
                                                    <div class="form-floating form-floating__icon">
                                                        <input type="number" class="form-control"
                                                               name="min_bidding_price" min="0"
                                                               max="100" step="any"
                                                               placeholder="<?php echo e(translate('min_bidding_price')); ?> *"
                                                               required="" value="<?php echo e($service->min_bidding_price); ?>">
                                                        <label><?php echo e(translate('min_bidding_price')); ?> *</label>
                                                        <span class="material-icons">price_change</span>
                                                    </div>
                                                </div>

                                                <div class="mb-30">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" name="tags"
                                                               placeholder="<?php echo e(translate('Enter tags')); ?>"
                                                               value="<?php echo e(implode(",",$tagNames)); ?>"
                                                               data-role="tagsinput">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-5 mb-5 mb-sm-0">
                                                <div class="d-flex flex-column align-items-center gap-3">
                                                    <p class="mb-0"><?php echo e(translate('thumbnail_image')); ?></p>
                                                    <div>
                                                        <div class="upload-file">
                                                            <input type="file" class="upload-file__input"
                                                                   name="thumbnail" accept=".<?php echo e(implode(',.', array_column(IMAGEEXTENSION, 'key'))); ?>, |image/*">
                                                            <div class="upload-file__img">
                                                                <img src="<?php echo e($service->thumbnail_full_path); ?>"
                                                                     alt="<?php echo e(translate('image')); ?>">
                                                            </div>
                                                            <span class="upload-file__edit">
                                                                <span class="material-icons">edit</span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <p class="opacity-75 max-w220 mx-auto"><?php echo e(translate('Image format - jpg, png,
                                                        jpeg,
                                                        gif Image
                                                        Size -
                                                        maximum size 2 MB Image Ratio - 1:1')); ?></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-7">
                                                <div class="d-flex flex-column align-items-center gap-3">
                                                    <p class="mb-0"><?php echo e(translate('cover_image')); ?></p>
                                                    <div>
                                                        <div class="upload-file">
                                                            <input type="file" class="upload-file__input"
                                                                   name="cover_image" accept=".<?php echo e(implode(',.', array_column(IMAGEEXTENSION, 'key'))); ?>, |image/*">
                                                            <div class="upload-file__img upload-file__img_banner">
                                                                <img alt="<?php echo e(translate('cover-image')); ?>"
                                                                     src="<?php echo e($service->cover_image_full_path); ?>">
                                                            </div>
                                                            <span class="upload-file__edit">
                                                                <span class="material-icons">edit</span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <p class="opacity-75 max-w220 mx-auto"><?php echo e(translate('Image format - jpg, png,
                                                        jpeg, gif Image Size - maximum size 2 MB Image Ratio - 3:1')); ?></p>
                                                </div>
                                            </div>
                                            <?php if($language): ?>
                                                <div class="lang-form2" id="default-form2">
                                                    <div class="col-lg-12 mt-5">
                                                        <div class="mb-30">
                                                            <div class="form-floating">
                                                                <textarea type="text" class="form-control" required
                                                                          name="short_description[]"><?php echo e($service?->getRawOriginal('short_description')); ?></textarea>
                                                                <label><?php echo e(translate('short_description')); ?>

                                                                    (<?php echo e(translate('default')); ?>) *</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mt-4 mt-md-5">
                                                        <label for="editor"
                                                               class="mb-2"><?php echo e(translate('long_Description')); ?>

                                                            (<?php echo e(translate('default')); ?>)
                                                            <span class="text-danger">*</span></label>
                                                        <section id="editor" class="dark-support">
                                                            <textarea class="ckeditor" required
                                                                      name="description[]"><?php echo $service?->getRawOriginal('description'); ?></textarea>
                                                        </section>
                                                    </div>
                                                </div>
                                                <?php $__currentLoopData = $language?->live_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                                        if (count($service['translations'])) {
                                                            $translate = [];
                                                            foreach ($service['translations'] as $t) {
                                                                if ($t->locale == $lang['code'] && $t->key == "short_description") {
                                                                    $translate[$lang['code']]['short_description'] = $t->value;
                                                                }

                                                                if ($t->locale == $lang['code'] && $t->key == "description") {
                                                                    $translate[$lang['code']]['description'] = $t->value;
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    <div class="d-none lang-form2" id="<?php echo e($lang['code']); ?>-form2">
                                                        <div class="col-lg-12 mt-5">
                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                        <textarea type="text" class="form-control"
                                                                  name="short_description[]"><?php echo e($translate[$lang['code']]['short_description']??''); ?></textarea>
                                                                    <label><?php echo e(translate('short_description')); ?>

                                                                        (<?php echo e(strtoupper($lang['code'])); ?>) *</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mt-4 mt-md-5">
                                                            <label for="editor"
                                                                   class="mb-2"><?php echo e(translate('long_Description')); ?>

                                                                (<?php echo e(strtoupper($lang['code'])); ?>)
                                                                <span class="text-danger">*</span></label>
                                                            <section id="editor" class="dark-support">
                                                                <textarea class="ckeditor"
                                                                          name="description[]"><?php echo $translate[$lang['code']]['description']??''; ?></textarea>
                                                            </section>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <div class="normal-form">
                                                    <div class="col-lg-12 mt-5">
                                                        <div class="mb-30">
                                                            <div class="form-floating">
                                                                <textarea type="text" class="form-control" required
                                                                          name="short_description[]"><?php echo e(old('short_description')); ?></textarea>
                                                                <label><?php echo e(translate('short_description')); ?> *</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mt-4 mt-md-5">
                                                        <label for="editor"
                                                               class="mb-2"><?php echo e(translate('long_Description')); ?>

                                                            <span class="text-danger">*</span></label>
                                                        <section id="editor" class="dark-support">
                                                            <textarea class="ckeditor" required
                                                                      name="description[]"><?php echo e(old('description')); ?></textarea>
                                                        </section>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </section>

                                    <h3><?php echo e(translate('price_variation')); ?></h3>
                                    <section>
                                        <div class="d-flex flex-wrap gap-20 mb-3">
                                            <div class="form-floating flex-grow-1">
                                                <input type="text" class="form-control" name="variant_name"
                                                       id="variant-name"
                                                       placeholder="<?php echo e(translate('add_variant')); ?> *" required="">
                                                <label><?php echo e(translate('add_variant')); ?> *</label>
                                            </div>
                                            <div class="form-floating flex-grow-1">
                                                <input type="number" class="form-control" name="variant_price"
                                                       id="variant-price"
                                                       placeholder="<?php echo e(translate('price')); ?> *" required="" value="0">
                                                <label><?php echo e(translate('price')); ?> *</label>
                                            </div>
                                            <button type="button" class="btn btn--primary" id="service-ajax-variation">
                                                <span class="material-icons">add</span>
                                                <?php echo e(translate('add')); ?>

                                            </button>
                                        </div>

                                        <div class="table-responsive p-01">
                                            <table class="table align-middle table-variation">
                                                <thead id="category-wise-zone" class="text-nowrap">
                                                <tr>
                                                    <th scope="col"><?php echo e(translate('variations')); ?></th>
                                                    <th scope="col"><?php echo e(translate('default_price')); ?></th>
                                                    <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <th scope="col"><?php echo e($zone->name); ?></th>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <th scope="col"><?php echo e(translate('action')); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody id="variation-update-table">
                                                <?php echo $__env->make('servicemanagement::admin.partials._update-variant-data',['variants'=>$service->variations,'zones'=>$zones], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </tbody>
                                            </table>

                                            <div id="new-variations-table"
                                                 class="<?php echo e(session()->has('variations') && count(session('variations'))>0?'':'hide-div'); ?>">
                                                <label
                                                    class="badge badge-primary mb-10"><?php echo e(translate('new_variations')); ?></label>
                                                <table class="table align-middle table-variation">
                                                    <tbody id="variation-table">
                                                    <?php echo $__env->make('servicemanagement::admin.partials._variant-data',['zones'=>$zones], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    </tbody>
                                                </table>
                                            </div>
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
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/js//tags-input.min.js"></script>
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/select2/select2.min.js"></script>
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/jquery-steps/jquery.steps.min.js"></script>
    <script src="<?php echo e(asset('public/assets/admin-module/plugins/tinymce/tinymce.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/ckeditor/jquery.js')); ?>"></script>
    <script>
        "use strict";

        $(document).ready(function () {
            $('.js-select').select2();
        });

        $("#form-wizard").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            autoFocus: true,
            onFinished: function (event, currentIndex) {
                event.preventDefault();

                let isValid = true;
                $(".desc-err").remove(); // Remove previous error messages

                let variationSections = $("#variation-update-table, #variation-table");

                // Loop through all number inputs
                variationSections.find('input[type="number"]').each(function () {
                    let value = parseFloat($(this).val());
                    let minValue = parseFloat($(this).attr('min'));

                    if (isNaN(value) || value === "") {
                        toastr.error('Please enter a valid number');
                        isValid = false;
                    } else if (value <= 0) {
                        toastr.error('Value must be greater than zero');
                        isValid = false;
                    } else if (!isNaN(minValue) && value < minValue) {
                        toastr.error(`Minimum allowed value is ${minValue}`);
                        isValid = false;
                    }
                });

                if (!isValid) {
                    return false; // Stop form submission if validation fails
                }

                $("#service-add-form")[0].submit();

            }
        });

        ajax_get('<?php echo e(url('/')); ?>/admin/category/ajax-childes-only/<?php echo e($service->category_id); ?>?sub_category_id=<?php echo e($service->sub_category_id); ?>', 'sub-category-selector')

        $("#service-ajax-variation").on('click', function () {
            let route = "<?php echo e(route('admin.service.ajax-add-variant')); ?>";
            let id = "variation-table";
            ajax_variation(route, id);
        })

        function ajax_variation(route, id) {

            let name = $('#variant-name').val();
            let price = $('#variant-price').val();

            if (name.length > 0 && price > 0) {
                $.get({
                    url: route,
                    dataType: 'json',
                    data: {
                        name: $('#variant-name').val(),
                        price: $('#variant-price').val(),
                    },
                    success: function (response) {
                        if (response.flag == 0) {
                            toastr.info('Already added');
                        } else {
                            $('#new-variations-table').show();
                            $('#' + id).html(response.template);
                            $('#variant-name').val("");
                            $('#variant-price').val(0);
                        }
                    },
                });
            } else {
                if(price <= 0){
                    toastr.warning('<?php echo e(translate('price can not be 0 or negative')); ?>');
                }else{
                    toastr.warning('<?php echo e(translate('fields_are_required')); ?>');
                }
            }
        }

        document.addEventListener('click', function(event) {
            if (event.target.closest('.service-ajax-remove-variant')) {
                var route = event.target.closest('.service-ajax-remove-variant').getAttribute('data-route');
                var id = event.target.closest('.service-ajax-remove-variant').getAttribute('data-id');
                ajax_remove_variant(route, id);
            }
        });


        function ajax_remove_variant(route, id) {
            Swal.fire({
                title: "<?php echo e(translate('are_you_sure')); ?>?",
                text: "<?php echo e(translate('want_to_remove_this_variation')); ?>",
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
                    $.get({
                        url: route,
                        dataType: 'json',
                        data: {},
                        beforeSend: function () {
                        },
                        success: function (response) {
                            console.log(response.template)
                            $('#' + id).html(response.template);
                        },
                        complete: function () {
                        },
                    });
                }
            })
        }


        $("#category-id").change(function () {
            let id = this.value;
            let route = "<?php echo e(url('/admin/category/ajax-childes/')); ?>/" + id;
            ajax_switch_category(route)
        });

        function ajax_switch_category(route) {
            $.get({
                url: route + '?service_id=<?php echo e($service->id); ?>',
                dataType: 'json',
                data: {},
                beforeSend: function () {
                },
                success: function (response) {
                    console.log(response);
                    $('#sub-category-selector').html(response.template);
                    $('#category-wise-zone').html(response.template_for_zone);
                    $('#variation-table').html(response.template_for_variant);
                    $('#variation-update-table').html(response.template_for_update_variant);
                },
                complete: function () {
                },
            });
        }

        $(document).ready(function () {
            tinymce.init({
                selector: 'textarea.ckeditor'
            });
        });

        $(".lang_link").on('click', function (e) {
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang-form").addClass('d-none');
            $(".lang-form2").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.substring(0, form_id.length - 5);
            console.log(lang);
            $("#" + lang + "-form").removeClass('d-none');
            $("#" + lang + "-form2").removeClass('d-none');

            if (lang == '<?php echo e($default_lang); ?>') {
                $(".from_part_2").removeClass('d-none');
            } else {
                $(".from_part_2").addClass('d-none');
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/ServiceManagement/Resources/views/admin/edit.blade.php ENDPATH**/ ?>