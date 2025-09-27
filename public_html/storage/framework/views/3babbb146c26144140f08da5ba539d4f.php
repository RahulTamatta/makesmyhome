<?php $__env->startSection('title', translate('system_addons')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module/swiper/swiper-bundle.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module/css/addon-module.css')); ?>"/>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <div class="page-header d-flex justify-content-between">
            <h1 class="page-header-title mb-3">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/business-setup.png')); ?>" class="w--22" alt="">
                </span>
                <span><?php echo e(translate('system_addons')); ?></span>
            </h1>
            <div class="text-primary d-flex align-items-center gap-3 font-weight-bolder">
                <?php echo e(translate('How_the_Setting_Works')); ?>

                <div class="ripple-animation" data-bs-toggle="modal" data-bs-target="#settingModal" type="button">
                    <img src="<?php echo e(asset('/public/assets/admin-module/img/info.svg')); ?>" class="svg" alt="">
                </div>
            </div>
        </div>


        <div class="modal fade" id="settingModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="settingModal"
             aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0 d-flex justify-content-end">
                        <button
                            type="button"
                            class="btn-close border-0"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ><i class="tio-clear"></i></button>
                    </div>
                    <div class="modal-body px-4 px-sm-5 pt-0 text-center">
                        <div class="row g-2 g-sm-3 mt-lg-0">
                            <div class="col-12">
                                <div class="swiper mySwiper pb-3">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="d-flex flex-column align-items-center mx-w450 mx-auto">
                                                <img src="<?php echo e(asset('public/assets/admin-module/img/addon-setting.png')); ?>"
                                                     loading="lazy"
                                                     alt="" class="dark-support rounded mb-4">
                                            </div>

                                            <div class="d-flex flex-column align-items-start">
                                                <h3 class="mb-4"><?php echo e(translate('To Integrate add-on to your system please follow the instruction below')); ?></h3>

                                                <ol class="text-start">
                                                    <li><?php echo e(translate('After purchasing the Payment & SMS Module from Codecanyon, you will find a file download option.')); ?></li>
                                                    <li><?php echo e(translate('Download the file. It will be downloaded as Zip format Filename.Zip.')); ?></li>
                                                    <li><?php echo e(translate('Extract the file and you will get another file name payment.zip.')); ?></li>
                                                    <li><?php echo e(translate('Upload the file here and your Addon uploading is complete !')); ?></li>
                                                    <li><?php echo e(translate('Then active the Addon and setup all the options. you are good to go !')); ?></li>
                                                </ol>
                                            </div>

                                            <div class="d-flex flex-column align-items-end mx-w450 mx-auto">
                                                <button class="btn btn-primary px-10 mt-3"
                                                        data-bs-dismiss="modal"><?php echo e(translate('Got_It')); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-5">
            <div class="card-body pl-md-10">
                <h4 class="mb-3 text-capitalize d-flex align-items-center"><?php echo e(translate('upload_Payment_Module')); ?></h4>
                <form enctype="multipart/form-data" id="theme_form">
                    <div class="row g-3">
                        <div class="col-sm-6 col-lg-5 col-xl-4 col-xxl-3">
                            <div class="uploadDnD">
                                <div class="form-group inputDnD">
                                    <input type="file" name="file_upload"
                                           class="form-control-file text--primary font-weight-bold"
                                           id="inputFile" onchange="readUrl(this)" accept=".zip"
                                           data-title="<?php echo e(translate('Drag & drop file or Browse file')); ?>">
                                </div>
                            </div>

                            <div class="mt-5 card px-3 py-2 d--none" id="progress-bar">
                                <div class="d-flex flex-wrap align-items-center gap-3">
                                    <div class="">
                                        <img width="24" src="<?php echo e(asset('/public/assets/admin/img/zip.png')); ?>" alt="">
                                    </div>
                                    <div class="flex-grow-1 text-start">
                                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                                            <span id="name_of_file" class="text-truncate fz-12"></span>
                                            <span class="text-muted fz-12" id="progress-label">0%</span>
                                        </div>
                                        <progress id="uploadProgress" class="w-100" value="0" max="100"></progress>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php ($condition_one=str_replace('MB','',ini_get('upload_max_filesize'))>=20 && str_replace('MB','',ini_get('upload_max_filesize'))>=20); ?>
                        <?php ($condition_two=str_replace('MB','',ini_get('post_max_size'))>=20 && str_replace('MB','',ini_get('post_max_size'))>=20); ?>

                        <div class="col-sm-6 col-lg-5 col-xl-4 col-xxl-9">
                            <div class="pl-sm-5">
                                <h5 class="mb-3 d-flex"><?php echo e(translate('instructions')); ?></h5>
                                <ul class="pl-3 d-flex flex-column gap-2 instructions-list">
                                    <li class="list-unstyled">
                                        1. <?php echo e(translate('please_make_sure')); ?>, <?php echo e(translate('your_server_php')); ?>

                                        "upload_max_filesize" <?php echo e(translate('value_is_grater
                                   _or_equal_to_20MB')); ?>. <?php echo e(translate('current_value_is')); ?>

                                        - <?php echo e(ini_get('upload_max_filesize')); ?>B
                                    </li>
                                    <li class="list-unstyled">
                                        2. <?php echo e(translate('please_make_sure')); ?>, <?php echo e(translate('your_server_php')); ?>

                                        "post_max_size"
                                        <?php echo e(translate('value_is_grater_or_equal_to_20MB')); ?>

                                        . <?php echo e(translate('current_value_is')); ?> - <?php echo e(ini_get('post_max_size')); ?>B
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('addon_add')): ?>
                            <div class="col-12">
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button"
                                            class="btn btn--primary px-4"
                                            id="upload_theme"><?php echo e(translate('upload')); ?></button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <div class="row g-1 g-sm-2">
            <?php $__currentLoopData = $addons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php ($data= include $addon.'/Addon/info.php'); ?>
                <div class="col-6 col-md-5 col-xxl-3">
                    <div class="card theme-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title m-0">
                                <?php echo e($data['name']); ?>

                            </h3>

                            <div class="d-flex align-items-center">
                                <?php if($data['is_published'] == 0): ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('addon_delete')): ?>
                                        <button class="text-danger bg-transparent p-0 border-0 me-2"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteThemeModal_<?php echo e($key); ?>"><img
                                                src="<?php echo e(asset('public/assets/admin-module/img/delete.svg')); ?>" class="svg"
                                                alt=""></button>
                                    <?php endif; ?>

                                    <div class="modal fade" id="deleteThemeModal_<?php echo e($key); ?>" tabindex="-1"
                                         aria-labelledby="deleteThemeModal_<?php echo e($key); ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header border-0 pb-0 d-flex justify-content-end">
                                                    <button
                                                        type="button"
                                                        class="btn-close border-0"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close"
                                                    ><i class="tio-clear"></i></button>
                                                </div>
                                                <div class="modal-body px-4 px-sm-5 text-center">
                                                    <div class="mb-3 text-center">
                                                        <img width="75"
                                                             src="<?php echo e(asset('public/assets/admin-module/img/delete.png')); ?>"
                                                             alt="">
                                                    </div>

                                                    <h3><?php echo e(translate('are_you_sure_you_want_to_delete_the_payment_module')); ?>

                                                        ?</h3>
                                                    <p class="mb-5"><?php echo e(translate('once_you_delete')); ?>

                                                        , <?php echo e(translate('you_will_lost_the_this_payment_module')); ?></p>
                                                    <div class="d-flex justify-content-center gap-3 mb-3">
                                                        <button type="button" class="fs-16 btn btn-secondary px-sm-5"
                                                                data-bs-dismiss="modal"><?php echo e(translate('cancel')); ?></button>
                                                        <button type="submit"
                                                                class="fs-16 btn btn-danger px-sm-5 delete-addon"
                                                                data-bs-dismiss="modal"
                                                                data-value="<?php echo e($addon); ?>"><?php echo e(translate('delete')); ?></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('addon_manage_status')): ?>
                                    <button
                                        class="<?php echo e($data['is_published'] == 1 ? 'checkbox-color-primary' : 'text-muted'); ?> bg-transparent p-0 border-0"
                                        data-bs-toggle="modal" data-bs-target="#shiftThemeModal_<?php echo e($key); ?>"><img
                                            src="<?php echo e(asset('public/assets/admin-module/img/check.svg')); ?>" class="svg"
                                            alt="">
                                    </button>
                                <?php endif; ?>
                                <div class="modal fade" id="shiftThemeModal_<?php echo e($key); ?>" tabindex="-1"
                                     aria-labelledby="shiftThemeModalLabel_<?php echo e($key); ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header border-0 pb-0 d-flex justify-content-end">
                                                <button
                                                    type="button"
                                                    class="btn-close border-0"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Close"
                                                ><i class="tio-clear"></i></button>
                                            </div>
                                            <div class="modal-body px-4 px-sm-5 text-center">
                                                <div class="mb-3 text-center">
                                                    <img width="75"
                                                         src="<?php echo e(asset('public/assets/admin-module/img/shift.png')); ?>"
                                                         alt="">
                                                </div>

                                                <h3 class="mb-3"><?php echo e(translate('are_you_sure?')); ?></h3>
                                                <?php if($publishedStatus): ?>
                                                    <p class="mb-5"><?php echo e(translate('want_to_change_status')); ?></p>
                                                <?php else: ?>
                                                    <p class="mb-5"><?php echo e(translate('want_to_active_this_payment_module')); ?></p>
                                                <?php endif; ?>
                                                <div class="d-flex justify-content-center gap-3 mb-3">
                                                    <button type="button" class="fs-16 btn btn-secondary px-sm-5"
                                                            data-bs-dismiss="modal"><?php echo e(translate('no')); ?></button>
                                                    <button type="button"
                                                            class="fs-16 btn btn--primary px-sm-5 publish-addon"
                                                            data-publish="<?php echo e($addon); ?>"
                                                            data-bs-dismiss="modal"
                                                    ><?php echo e(translate('yes')); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-2 p-sm-3">
                            <div class="mb-2 d-none" id="activate_<?php echo e($key); ?>">
                                <form action="" method="post">
                                    <?php echo csrf_field(); ?>
                                    <div class="form-group">
                                        <input type="text" name="username" value=""
                                               class="form-control"
                                               placeholder="<?php echo e(translate('codecanyon_username')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="purchase_code" value=""
                                               class="form-control" placeholder="<?php echo e(translate('purchase_code')); ?>">
                                        <input type="text" name="path" class="form-control" value="" hidden>
                                    </div>

                                    <div>
                                        <input type="hidden" value="key" name="theme">
                                        <button type="submit"
                                                class="btn btn--primary radius-button text-end"><?php echo e(translate('activate')); ?></button>
                                    </div>
                                </form>
                            </div>

                            <div class="aspect-ration-3:2 border border-color-primary-light radius-10">
                                <img class="img-fit radius-10"
                                     onerror='this.src="<?php echo e(asset('public/assets/admin/img/placeholder.png')); ?>"'
                                     src="<?php echo e(asset($addon.'/public/addon.png')); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php echo $__env->make('addonmodule::addon.partials.activation-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script href="<?php echo e(asset('public/assets/admin-module/swiper/swiper-bundle.min.js')); ?>"></script>

    <script>
        'use strict';

        $("img.svg").each(function () {
            var $img = jQuery(this);
            var imgID = $img.attr("id");
            var imgClass = $img.attr("class");
            var imgURL = $img.attr("src");

            jQuery.get(
                imgURL,
                function (data) {
                    var $svg = jQuery(data).find("svg");

                    if (typeof imgID !== "undefined") {
                        $svg = $svg.attr("id", imgID);
                    }

                    if (typeof imgClass !== "undefined") {
                        $svg = $svg.attr("class", imgClass + " replaced-svg");
                    }


                    $svg = $svg.removeAttr("xmlns:a");


                    if (
                        !$svg.attr("viewBox") &&
                        $svg.attr("height") &&
                        $svg.attr("width")
                    ) {
                        $svg.attr(
                            "viewBox",
                            "0 0 " + $svg.attr("height") + " " + $svg.attr("width")
                        );
                    }

                    $img.replaceWith($svg);
                },
                "xml"
            );
        });

        function readUrl(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    let imgData = e.target.result;
                    let imgName = input.files[0].name;
                    input.setAttribute("data-title", imgName);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#upload_theme').on('click', function () {
            zip_upload()
        })

        function zip_upload() {
            var fileInput = document.getElementById('inputFile');
            let maxFileSize = "<?php echo e($condition_one); ?>";
            let maxPostSize = "<?php echo e($condition_two); ?>";

            if (!fileInput.files || !fileInput.files[0]) {
                toastr.warning('Please choose a file for upload.');
                return;
            }

            if (!maxFileSize) {
                toastr.warning('Your server php "upload_max_filesize" is must be grater or equal to 20MB');
                return;
            }

            if (!maxPostSize) {
                toastr.warning('Your server php "post_max_size" is must be grater or equal to 20MB');
                return;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData(document.getElementById('theme_form'));
            $.ajax({
                type: 'POST',
                url: "<?php echo e(route('admin.addon.upload')); ?>",
                data: formData,
                processData: false,
                contentType: false,
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    $('#progress-bar').show();


                    xhr.upload.addEventListener("progress", function (e) {
                        if (e.lengthComputable) {
                            var percentage = Math.round((e.loaded * 100) / e.total);
                            $("#uploadProgress").val(percentage);
                            $("#progress-label").text(percentage + "%");
                        }
                    }, false);

                    return xhr;
                },
                beforeSend: function () {
                    $('#upload_theme').attr('disabled');
                },
                success: function (response) {
                    if (response.status == 'error') {
                        $('#progress-bar').hide();
                        toastr.error(response.message, {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    } else if (response.status == 'success') {
                        toastr.success(response.message, {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        location.reload();
                    }
                },
                complete: function () {
                    $('#upload_theme').removeAttr('disabled');
                },
            });
        }

        $('.publish-addon').on('click', function () {
            let filePath = $(this).data('publish')
            publish_addon(filePath)
        })

        function publish_addon(path) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('admin.addon.publish')); ?>',
                data: {
                    'path': path
                },
                success: function (data) {
                    if (data.flag === 'inactive') {
                        $('#activatedThemeModal').modal('show');
                        $('#activateData').empty().html(data.view);
                    } else {
                        if (data.errors) {
                            for (var i = 0; i < data.errors.length; i++) {
                                toastr.error(data.errors[i].message, {
                                    CloseButton: true,
                                    ProgressBar: true
                                });
                            }
                        } else {
                            toastr.success('<?php echo e(translate("updated successfully!")); ?>', {
                                CloseButton: true,
                                ProgressBar: true
                            });
                            setTimeout(function () {
                                location.reload()
                            }, 2000);
                        }
                    }
                }
            });
        }

        $('.delete-addon').on('click', function () {
            let path = $(this).data('value')
            theme_delete(path)
        })

        function theme_delete(path) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('admin.addon.delete')); ?>',
                data: {
                    path
                },
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    if (data.status === 'success') {
                        setTimeout(function () {
                            location.reload()
                        }, 2000);

                        toastr.success(data.message, {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    } else if (data.status === 'error') {
                        toastr.error(data.message, {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        }

        var swiper = new Swiper(".mySwiper", {
            pagination: {
                el: ".swiper-pagination",
                dynamicBullets: true,
            },
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/AddonModule/Resources/views/addon/index.blade.php ENDPATH**/ ?>