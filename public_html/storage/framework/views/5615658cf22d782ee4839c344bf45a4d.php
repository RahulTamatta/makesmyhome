<?php $__env->startSection('title',translate('3rd_party')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/swiper/swiper-bundle.min.css"/>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap mb-3">
                        <h2 class="page-title"><?php echo e(translate('3rd_party')); ?></h2>
                    </div>

                    <div class="mb-3">
                        <ul class="nav nav--tabs nav--tabs__style2">
                            <?php echo $__env->make('businesssettingsmodule::admin.partials.third-party-partial', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </ul>
                    </div>

                    <?php if($webPage == 'google_map'): ?>
                        <div class="tab-content">
                            <div class="tab-pane fade <?php echo e($webPage == 'google_map' ? 'show active' : ''); ?>"
                                 id="google-map">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="page-title"><?php echo e(translate('google_map_api_key_setup')); ?></h4>
                                    </div>
                                    <div class="card-body p-30">
                                        <div class="alert alert-danger mb-30">
                                            <p><i class="material-icons">info</i>
                                                <?php echo e(translate('Client Key Should Have Enable Map Javascript Api And You Can Restrict It With Http Refere. Server Key Should Have Enable Place Api Key And You Can Restrict It With Ip. You Can Use Same Api For Both Field Without Any Restrictions.')); ?>

                                            </p>
                                        </div>
                                        <form action="<?php echo e(route('admin.configuration.set-third-party-config')); ?>"
                                              method="POST"
                                              id="google-map-update-form" enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <div class="discount-type">
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="mb-30">
                                                            <div class="form-floating">
                                                                <input name="party_name" value="google_map"
                                                                       class="hide-div">
                                                                <input type="text" class="form-control"
                                                                       name="map_api_key_server"
                                                                       placeholder="<?php echo e(translate('map_api_key_server')); ?> *"
                                                                       required=""
                                                                       value="<?php echo e(bs_data($dataValues,'google_map')['map_api_key_server']??''); ?>">
                                                                <label><?php echo e(translate('map_api_key_server')); ?> *</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="mb-30">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control"
                                                                       name="map_api_key_client"
                                                                       placeholder="<?php echo e(translate('map_api_key_client')); ?> *"
                                                                       required=""
                                                                       value="<?php echo e(bs_data($dataValues,'google_map')['map_api_key_client']??''); ?>">
                                                                <label><?php echo e(translate('map_api_key_client')); ?> *</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('configuration_update')): ?>
                                                <div class="d-flex justify-content-end">
                                                    <button type="submit" class="btn btn--primary demo_check">
                                                        <?php echo e(translate('update')); ?>

                                                    </button>
                                                </div>
                                            <?php endif; ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($webPage == 'push_notification'): ?>
                        <div class="tab-content">
                            <div class="tab-pane fade <?php echo e($webPage == 'push_notification' ? 'show active' : ''); ?>"
                                 id="firebase-push-notification">
                                <div class="card">
                                    <div class="card-header">

                                        <div class="d-flex justify-content-between mb-5">
                                            <div class="page-header align-items-center">
                                                <h4><?php echo e(translate('Firebase_Notification_Setup')); ?></h4>
                                            </div>
                                            <div class="d-flex align-items-center gap-3 font-weight-bolder">
                                                <?php echo e(translate('Read Instructions')); ?>

                                                <div class="ripple-animation" data-bs-toggle="modal"
                                                     data-bs-target="#carouselModal" type="button">
                                                    <img src="<?php echo e(asset('/public/assets/admin-module/img/info.svg')); ?>"
                                                         class="svg"
                                                         alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-30">
                                        <form action="<?php echo e(route('admin.configuration.set-third-party-config')); ?>"
                                              method="POST"
                                              id="firebase-form" enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <div class="discount-type">
                                                <div class="row">
                                                    <div class="col-md-12 col-12 d--none">
                                                        <div class="mb-30">
                                                            <div class="form-floating">
                                                                <input name="party_name" value="push_notification"
                                                                       class="hide-div">
                                                                <input type="text" class="form-control"
                                                                       name="server_key"
                                                                       placeholder="<?php echo e(translate('server_key')); ?> *"
                                                                       value="<?php echo e(bs_data($dataValues,'push_notification')['server_key']??''); ?>">
                                                                <label><?php echo e(translate('server_key')); ?> *</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="d-flex align-items-center gap-4 gap-xl-5">
                                                            <div class="custom-radio">
                                                                <input type="radio" id="active" name="firebase_content_type"
                                                                       value="file" checked>
                                                                <label for="active"><?php echo e(translate('File Upload')); ?></label>
                                                            </div>
                                                            <div class="custom-radio">
                                                                <input type="radio" id="inactive" name="firebase_content_type"
                                                                       value="file_content">
                                                                <label for="inactive"><?php echo e(translate('File Content')); ?></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12 file-upload-div">
                                                        <div class="form-floating mb-30 mt-30">
                                                            <input type="file" accept=".json" class="form-control"
                                                                   name="service_file"
                                                                   value="">
                                                            <label><?php echo e(translate('service_file')); ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12 mt-4">
                                                        <?php
                                                            $serviceFile = bs_data($dataValues, 'push_notification')['service_file_content'] ?? '';
                                                            $serviceFileValue = is_array($serviceFile) ? json_encode($serviceFile) : $serviceFile;
                                                        ?>
                                                        <div class="mb-30">
                                                            <div class="form-floating">
                                                                <input name="party_name" value="push_notification"
                                                                       class="hide-div">
                                                                <textarea type="text" class="form-control"
                                                                       name="service_file_content"
                                                                       placeholder="<?php echo e(translate('service_file_content')); ?> *"
                                                                       required="" readonly rows="15"><?php echo e($serviceFileValue); ?></textarea>
                                                                <label><?php echo e(translate('service_file_content')); ?> *</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-floating">
                                                <label class="form-label">API Key</label><br>
                                                <input type="text" placeholder="Ex : " class="form-control" name="apiKey" value="<?php echo e(bs_data($dataValues,'firebase_message_config')['apiKey']??''); ?>" autocomplete="off">
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form-floating">
                                                        <label class="form-label">Project ID</label><br>
                                                        <input type="text" class="form-control" name="projectId" value="<?php echo e(bs_data($dataValues,'firebase_message_config')['projectId']??''); ?>" autocomplete="off" placeholder="Ex : ">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form-floating">
                                                        <label class="form-label">Auth Domain</label><br>
                                                        <input type="text" class="form-control" name="authDomain" value="<?php echo e(bs_data($dataValues,'firebase_message_config')['authDomain']??''); ?>" autocomplete="off" placeholder="Ex : ">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form-floating">
                                                        <label class="form-label">Storage Bucket</label><br>
                                                        <input type="text" class="form-control" name="storageBucket" value="<?php echo e(bs_data($dataValues,'firebase_message_config')['storageBucket']??''); ?>" autocomplete="off" placeholder="Ex : ">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form-floating">
                                                        <label class="form-label">Messaging Sender ID</label><br>
                                                        <input type="text" placeholder="Ex : " class="form-control" name="messagingSenderId" value="<?php echo e(bs_data($dataValues,'firebase_message_config')['messagingSenderId']??''); ?>" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form-floating">
                                                        <label class="form-label">App ID</label><br>
                                                        <input type="text" placeholder="Ex : " class="form-control" name="appId" value="<?php echo e(bs_data($dataValues,'firebase_message_config')['appId']??''); ?>" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form-floating">
                                                        <label class="form-label">Measurement ID</label><br>
                                                        <input type="text" placeholder="Ex : " class="form-control" name="measurementId" value="<?php echo e(bs_data($dataValues,'firebase_message_config')['measurementId']??''); ?>" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('configuration_update')): ?>
                                                <div class="d-flex justify-content-end pt-3">
                                                    <button type="submit" class="btn btn--primary demo_check">
                                                        <?php echo e(translate('update')); ?>

                                                    </button>
                                                </div>
                                            <?php endif; ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade firebase-modal" id="carouselModal" tabindex="-1"
                             aria-labelledby="carouselModal"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header border-0 pb-1">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body px-4 px-sm-5 pt-0">
                                        <div dir="ltr" class="swiper modalSwiper pb-4">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    <div class="d-flex flex-column align-items-center gap-2 fs-12">
                                                        <img width="80" class="mb-3"
                                                             src="<?php echo e(asset('public/assets/admin-module/img/media/firebase-console.png')); ?>"
                                                             alt="">
                                                        <h5 class="modal-title text-center mb-3">Go to Firebase
                                                            Console</h5>

                                                        <ul class="d-flex flex-column gap-2 px-3">
                                                            <li><?php echo e(translate('Open your web browser and go to the Firebase Console')); ?>

                                                                (
                                                                <a
                                                                    href="https://console.firebase.google.com">https://console.firebase.google.com/</a>
                                                                ).
                                                            </li>
                                                            <li><?php echo e(translate('Select the project for which you want to configure FCM
                                                                from the Firebase
                                                                Console dashboard')); ?>

                                                            </li>
                                                            <li><?php echo e(translate('If you don’t have any project before. Create one with
                                                                the website name')); ?>

                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide">
                                                    <div class="d-flex flex-column align-items-center gap-2 fs-12">
                                                        <img width="80" class="mb-3"
                                                             src="<?php echo e(asset('public/assets/admin-module/img/media/project-settings.png')); ?>"
                                                             alt="">
                                                        <h5 class="modal-title text-center mb-3"><?php echo e(translate('Navigate to Project
                                                            Settings')); ?></h5>

                                                        <ul class="d-flex flex-column gap-2 px-3">
                                                            <li><?php echo e(translate('In the left-hand menu, click on the')); ?>

                                                                <strong>"Settings"</strong> gear icon,
                                                                <?php echo e(translate('there you will vae a dropdown. and then select')); ?>

                                                                <strong>"Project
                                                                    settings"</strong> <?php echo e(translate('from the dropdown.')); ?>

                                                            </li>
                                                            <li><?php echo e(translate('In the Project settings page, click on the "Cloud
                                                                Messaging" tab from the
                                                                top menu.')); ?>

                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide">
                                                    <div class="d-flex flex-column align-items-center gap-2 fs-12">
                                                        <img width="80" class="mb-3"
                                                             src="<?php echo e(asset('public/assets/admin-module/img/media/cloud-message.png')); ?>"
                                                             alt="">
                                                        <h5 class="modal-title text-center mb-3"><?php echo e(translate('Cloud Messaging
                                                            API')); ?></h5>

                                                        <ul class="d-flex flex-column gap-2 px-3">
                                                            <li><?php echo e(translate('From Cloud Messaging Page there will be a section called
                                                                Cloud Messaging
                                                                API.')); ?>

                                                            </li>
                                                            <li><?php echo e(translate('Click on the menu icon and enable the API')); ?></li>
                                                            <li><?php echo e(translate('Refresh the Cloud Messaging Page - You will have your
                                                                server key. Just copy
                                                                the code and paste here')); ?>

                                                            </li>
                                                        </ul>

                                                        <div class="d-flex justify-content-center mt-2 w-100">
                                                            <button type="button" class="btn btn-primary w-100 max-w320"
                                                                    data-bs-dismiss="modal">Got It
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-pagination mb-2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($webPage == 'recaptcha'): ?>
                        <div class="tab-content">
                            <div class="tab-pane fade <?php echo e($webPage == 'recaptcha' ? 'show active' : ''); ?>" id="recaptcha">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="page-title"><?php echo e(translate('recaptcha_setup')); ?></h4>
                                    </div>
                                    <div class="card-body p-30">
                                        <form action="<?php echo e(route('admin.configuration.set-third-party-config')); ?>"
                                              method="POST"
                                              id="recaptcha-form" enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <div class="badge-soft-secondary rounded mb-4 p-3">
                                                <h5 class="m-0"><?php echo e(translate('V3 Version is available now. Must setup for ReCAPTCHA V3')); ?></h5>
                                                <p class="m-0"><?php echo e(translate('If you activate reCAPTCHA, please ensure that reCAPTCHA v3 is properly set up beforehand. Otherwise, you may not be able to access any panels.')); ?></p>
                                            </div>

                                            <div class="discount-type">
                                                <div class="d-flex align-items-center gap-4 gap-xl-5 mb-30">
                                                    <div class="custom-radio">
                                                        <input type="radio" id="active" name="status"
                                                               value="1" <?php echo e($dataValues->where('key_name','recaptcha')->first()->live_values['status']?'checked':''); ?>>
                                                        <label for="active"><?php echo e(translate('active')); ?></label>
                                                    </div>
                                                    <div class="custom-radio">
                                                        <input type="radio" id="inactive" name="status"
                                                               value="0" <?php echo e($dataValues->where('key_name','recaptcha')->first()->live_values['status']?'':'checked'); ?>>
                                                        <label for="inactive"><?php echo e(translate('inactive')); ?></label>
                                                    </div>
                                                </div>

                                                <br>

                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="mb-30">
                                                            <div class="form-floating">
                                                                <input name="party_name" value="recaptcha"
                                                                       class="hide-div">
                                                                <input type="text" class="form-control"
                                                                       name="site_key"
                                                                       placeholder="<?php echo e(translate('site_key')); ?> *"
                                                                       required=""
                                                                       value="<?php echo e(bs_data($dataValues,'recaptcha')['site_key']??''); ?>">
                                                                <label><?php echo e(translate('site_key')); ?> *</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-12">
                                                        <div class="mb-30">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control"
                                                                       name="secret_key"
                                                                       placeholder="<?php echo e(translate('secret_key')); ?> *"
                                                                       required=""
                                                                       value="<?php echo e(bs_data($dataValues,'recaptcha')['secret_key']??''); ?>">
                                                                <label><?php echo e(translate('secret_key')); ?> *</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('configuration_update')): ?>
                                                <div class="d-flex justify-content-end">
                                                    <button type="submit" class="btn btn--primary demo_check">
                                                        <?php echo e(translate('update')); ?>

                                                    </button>
                                                </div>
                                            <?php endif; ?>
                                        </form>

                                        <div class="mt-3">
                                            <h4 class="mb-3"><?php echo e(translate('Instructions')); ?></h4>
                                            <ol>
                                                <li><?php echo e(translate('To get site key and secret keyGo to the Credentials page')); ?>

                                                    (<a href="https://developers.google.com/recaptcha/docs/v3"
                                                        class="c1"><?php echo e(translate('Click
                                                        Here')); ?></a>)
                                                </li>
                                                <li><?php echo e(translate('Add a Label (Ex: abc company)')); ?></li>
                                                <li><?php echo e(translate('Select reCAPTCHA v3 as ReCAPTCHA Type')); ?></li>
                                                <li><?php echo e(translate('Select Sub type: I am not a robot Checkbox')); ?> </li>
                                                <li><?php echo e(translate('Add Domain')); ?> (For ex: demo.6amtech.com)</li>
                                                <li><?php echo e(translate('Check in “Accept the reCAPTCHA Terms of Service”')); ?> </li>
                                                <li><?php echo e(translate('Press Submit')); ?></li>
                                                <li><?php echo e(translate('Copy Site Key and Secret Key, Paste in the input filed below and
                                                    Save.')); ?>

                                                </li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php ($appleLogin = (business_config('apple_login', 'third_party'))->live_values); ?>

                    <?php if($webPage == 'apple_login'): ?>
                        <div class="tab-content">
                            <div class="tab-pane fade <?php echo e($webPage == 'apple_login' ? 'show active' : ''); ?>"
                                 id="apple_login">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="page-title">
                                            <img src="<?php echo e(asset('public/assets/admin-module/img/media/apple.png')); ?>"
                                                 alt="">
                                            <?php echo e(translate('Apple_login')); ?>

                                        </h4>
                                    </div>
                                    <div class="card-body p-30">
                                        <div class="row">
                                            <div class="col-12 col-md-12 mb-30">
                                                <form action="<?php echo e(route('admin.configuration.set-third-party-config')); ?>"
                                                      method="POST"
                                                      id="apple-login-form" enctype="multipart/form-data">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PUT'); ?>
                                                    <div class="discount-type">
                                                        <div class="d-flex align-items-center gap-4 gap-xl-5 mb-30">
                                                            <input name="party_name" value="apple_login"
                                                                   class="hide-div">
                                                            <div class="custom-radio">
                                                                <input type="radio" id="apple-login-active"
                                                                       name="status"
                                                                       value="1" <?php echo e($appleLogin['status']?'checked':''); ?>>
                                                                <label
                                                                    for="apple-login-active"><?php echo e(translate('active')); ?></label>
                                                            </div>
                                                            <div class="custom-radio">
                                                                <input type="radio" id="apple-login-inactive"
                                                                       name="status"
                                                                       value="0" <?php echo e($appleLogin['status']?'':'checked'); ?>>
                                                                <label
                                                                    for="apple-login-inactive"><?php echo e(translate('inactive')); ?></label>
                                                            </div>
                                                        </div>

                                                        <div class="form-floating mb-30 mt-30">
                                                            <input type="text" class="form-control" name="client_id"
                                                                   value="<?php echo e(env('APP_ENV')=='demo'?'':$appleLogin['client_id']); ?>">
                                                            <label><?php echo e(translate('client_id')); ?> *</label>
                                                        </div>

                                                        <div class="form-floating mb-30 mt-30">
                                                            <input type="text" class="form-control" name="team_id"
                                                                   value="<?php echo e(env('APP_ENV')=='demo'?'':$appleLogin['team_id']); ?>">
                                                            <label><?php echo e(translate('team_id')); ?> *</label>
                                                        </div>

                                                        <div class="form-floating mb-30 mt-30">
                                                            <input type="text" class="form-control" name="key_id"
                                                                   value="<?php echo e(env('APP_ENV')=='demo'?'':$appleLogin['key_id']); ?>">
                                                            <label><?php echo e(translate('key_id')); ?> *</label>
                                                        </div>

                                                        <div class="form-floating mb-30 mt-30">
                                                            <input type="file" accept=".p8" class="form-control"
                                                                   name="service_file"
                                                                   value="<?php echo e('storage/app/public/apple-login/'.$appleLogin['service_file']); ?>">
                                                            <label><?php echo e(translate('service_file')); ?> <?php echo e($appleLogin['service_file']? translate('(Already Exists)'):'*'); ?></label>
                                                        </div>
                                                    </div>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('configuration_update')): ?>
                                                        <div class="d-flex justify-content-end">
                                                            <button type="submit" class="btn btn--primary demo_check">
                                                                <?php echo e(translate('update')); ?>

                                                            </button>
                                                        </div>
                                                    <?php endif; ?>
                                                </form>
                                                <div class="mt-3">
                                                    <h4 class="mb-3"><?php echo e(translate('Instructions')); ?></h4>
                                                    <ol>
                                                        <li><?php echo e(translate('Go to Apple Developer page')); ?> (<a
                                                                href="https://developer.apple.com/account/resources/identifiers/list"
                                                                target="_blank"><?php echo e(translate('click_here')); ?></a>)
                                                        </li>
                                                        <li><?php echo e(translate('Here in top left corner you can see the')); ?>

                                                            <b><?php echo e(translate('Team ID')); ?></b> <?php echo e(translate('[Apple_Deveveloper_Account_Name - Team_ID]')); ?>

                                                        </li>
                                                        <li><?php echo e(translate('Click Plus icon -> select App IDs -> click on Continue')); ?></li>
                                                        <li><?php echo e(translate('Put a description and also identifier (identifier that used for app) and this is the')); ?>

                                                            <b><?php echo e(translate('Client ID')); ?></b></li>
                                                        <li><?php echo e(translate('Click Continue and Download the file in device named AuthKey_ID.p8 (Store it safely and it is used for push notification)')); ?> </li>
                                                        <li><?php echo e(translate('Again click Plus icon -> select Service IDs -> click on Continue')); ?> </li>
                                                        <li><?php echo e(translate('Push a description and also identifier and Continue')); ?> </li>
                                                        <li><?php echo e(translate('Download the file in device named')); ?>

                                                            <b><?php echo e(translate('AuthKey_KeyID.p8')); ?></b> <?php echo e(translate('[This is the Service Key ID file and also after AuthKey_ that is the Key ID]')); ?>

                                                        </li>
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($webPage == 'email_config'): ?>
                        <div class="tab-content">
                            <div class="tab-pane fade <?php echo e($webPage == 'email_config' ? 'show active' : ''); ?>"
                                 id="email_config">
                                <div class="card">
                                    <div class="card-body p-30">
                                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-40">
                                            <ul class="nav nav--tabs nav--tabs__style2" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active"
                                                       href="<?php echo e(url('admin/configuration/get-third-party-config')); ?>?web_page=email_config"><?php echo e(translate('Email Config')); ?></a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link"
                                                       href="<?php echo e(url('admin/configuration/get-third-party-config')); ?>?web_page=test_mail"><?php echo e(translate('Send Test Mail')); ?></a>
                                                </li>
                                            </ul>
                                            <?php ($emailStatus =\Modules\BusinessSettingsModule\Entities\BusinessSettings::where(['key_name' => 'email_config_status', 'settings_type' => 'email_config'])->first()); ?>
                                            <label class="switcher">
                                                <input class="switcher_input email-config-status"
                                                       id="email-config-status"
                                                    data-values="$(this).is(':checked')===true?1:0"
                                                    type="checkbox"
                                                    <?php echo e(isset($emailStatus) && $emailStatus->live_values ? 'checked' : ''); ?>>
                                                <span class="switcher_control"></span>
                                            </label>
                                        </div>
                                        <div class="col-12 col-md-12 mb-30">
                                            <form action="<?php echo e(route('admin.configuration.set-email-config')); ?>"
                                                  method="POST"
                                                  id="config-form" enctype="multipart/form-data">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <div class="discount-type">
                                                    <div class="row">
                                                        <div class="col-md-6 col-12 mb-30">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control"
                                                                       name="mailer_name"
                                                                       placeholder="<?php echo e(translate('mailer_name')); ?> *"
                                                                       value="<?php echo e(bs_data($dataValues,'email_config')['mailer_name']??''); ?>">
                                                                <label><?php echo e(translate('mailer_name')); ?> *</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12 mb-30">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" name="host"
                                                                       placeholder="<?php echo e(translate('host')); ?> *"
                                                                       value="<?php echo e(bs_data($dataValues,'email_config')['host']??''); ?>">
                                                                <label><?php echo e(translate('host')); ?> *</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12 mb-30">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control"
                                                                       name="driver"
                                                                       placeholder="<?php echo e(translate('driver')); ?> *"
                                                                       value="<?php echo e(bs_data($dataValues,'email_config')['driver']??''); ?>">
                                                                <label><?php echo e(translate('driver')); ?> *</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12 mb-30">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" name="port"
                                                                       placeholder="<?php echo e(translate('port')); ?> *"
                                                                       value="<?php echo e(bs_data($dataValues,'email_config')['port']??''); ?>">
                                                                <label><?php echo e(translate('port')); ?> *</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12 mb-30">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control"
                                                                       name="user_name"
                                                                       placeholder="<?php echo e(translate('user_name')); ?> *"
                                                                       value="<?php echo e(bs_data($dataValues,'email_config')['user_name']??''); ?>">
                                                                <label><?php echo e(translate('user_name')); ?> *</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12 mb-30">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control"
                                                                       name="email_id"
                                                                       placeholder="<?php echo e(translate('email_id')); ?> *"
                                                                       value="<?php echo e(bs_data($dataValues,'email_config')['email_id']??''); ?>">
                                                                <label><?php echo e(translate('email_id')); ?> *</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12 mb-30">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control"
                                                                       name="encryption"
                                                                       placeholder="<?php echo e(translate('encryption')); ?> *"
                                                                       value="<?php echo e(bs_data($dataValues,'email_config')['encryption']??''); ?>">
                                                                <label><?php echo e(translate('encryption')); ?> *</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12 mb-30">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control"
                                                                       name="password"
                                                                       placeholder="<?php echo e(translate('password')); ?> *"
                                                                       value="<?php echo e(bs_data($dataValues,'email_config')['password']??''); ?>">
                                                                <label><?php echo e(translate('password')); ?> *</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('configuration_update')): ?>
                                                    <div class="d-flex justify-content-end">
                                                        <button type="submit" class="btn btn--primary">
                                                            <?php echo e(translate('update')); ?>

                                                        </button>
                                                    </div>
                                                <?php endif; ?>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <?php endif; ?>

                <?php if($webPage == 'test_mail'): ?>
                    <div class="tab-content">
                        <div class="tab-pane fade <?php echo e($webPage == 'test_mail' ? 'show active' : ''); ?>"
                             id="email_config">
                            <div class="card">
                                <div class="card-body p-30">
                                    <div class="row">
                                        <div
                                            class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-30">
                                            <ul class="nav nav--tabs nav--tabs__style2" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link <?php echo e($webPage=='email_config' ? 'active':''); ?>"
                                                       href="<?php echo e(url('admin/configuration/get-third-party-config')); ?>?web_page=email_config"><?php echo e(translate('Email Config')); ?></a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link <?php echo e($webPage == 'test_mail' ?'active':''); ?>"
                                                       href="<?php echo e(url('admin/configuration/get-third-party-config')); ?>?web_page=test_mail"><?php echo e(translate('Send Test Mail')); ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-12 col-md-12 mb-30">
                                            <form action="javascript:" method="post">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="status" value="<?php echo e((isset($data)&& isset($data['status'])) ? $data['status']:0); ?>">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="tab-content">
                                                            <div class="tab-pane fade show active" id="test-mail">
                                                                <div class="row">
                                                                    <div class="col-lg-8">
                                                                        <form action="javascript:">
                                                                            <div class="row gx-3 gy-1">
                                                                                <div class="col-md-8 col-sm-7">
                                                                                    <div class="form-floating">
                                                                                        <input type="email"
                                                                                               class="form-control"
                                                                                               id="test-email"
                                                                                               name="email"
                                                                                               placeholder="<?php echo e(translate('ex: abc@email.com')); ?>"
                                                                                               required=""
                                                                                               value="<?php echo e(old('email')); ?>">
                                                                                        <label><?php echo e(translate('email')); ?>

                                                                                            *</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 col-sm-5">
                                                                                    <button type="button" id="send-mail"
                                                                                            class="btn btn--primary">
                                                                                        <span class='material-icons'>send</span>
                                                                                        <?php echo e(translate('send_mail')); ?>

                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($webPage == 'sms_config'): ?>
                    <div class="tab-content">
                        <div class="tab-pane fade <?php echo e($webPage == 'sms_config' ? 'show active' : ''); ?>"
                             id="sms_config">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="page-title">
                                        <?php echo e(translate('Sms Setup')); ?>

                                    </h4>
                                </div>
                                <div class="card-body p-30">
                                    <div class="row">
                                        <div class="col-12 col-md-12 mb-30">
                                            <?php if($publishedStatus == 1): ?>
                                                <div class="col-md-12 mb-3">
                                                    <div class="card">
                                                        <div class="card-body d-flex justify-content-around">
                                                            <h4 class="payment-module-warning">
                                                                <i class="tio-info-outined"></i>
                                                                <?php echo e(translate('Your current sms settings are disabled, because you
                                                                have enabled
                                                                sms gateway addon, To visit your currently active
                                                                sms gateway settings please follow
                                                                the link.')); ?></h4>

                                                            <a href="<?php echo e(!empty($paymentUrl) ? $paymentUrl : ''); ?>"
                                                               class="btn btn-outline-primary"><?php echo e(translate('settings')); ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>


                                            <div class="row">
                                                <?php ($isPublished = $publishedStatus == 1 ? 'disabled' : ''); ?>
                                                <?php $__currentLoopData = $dataValues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyValue => $gateway): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="col-12 col-md-6 mb-30">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h4 class="page-title"><?php echo e(translate($gateway->key_name)); ?></h4>
                                                            </div>
                                                            <div class="card-body p-30">
                                                                <form
                                                                    action="<?php echo e(route('admin.configuration.sms-set')); ?>"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    <?php echo csrf_field(); ?>
                                                                    <?php echo method_field('PUT'); ?>
                                                                    <div class="discount-type">
                                                                        <div
                                                                            class="d-flex align-items-center gap-4 gap-xl-5 mb-30">
                                                                            <div class="custom-radio">
                                                                                <input type="radio"
                                                                                       id="<?php echo e($gateway->key_name); ?>-active"
                                                                                       name="status"
                                                                                       value="1" <?php echo e($dataValues->where('key_name',$gateway->key_name)->first()->live_values['status']?'checked':''); ?> <?php echo e($isPublished); ?>>
                                                                                <label
                                                                                    for="<?php echo e($gateway->key_name); ?>-active"><?php echo e(translate('active')); ?></label>
                                                                            </div>
                                                                            <div class="custom-radio">
                                                                                <input type="radio"
                                                                                       id="<?php echo e($gateway->key_name); ?>-inactive"
                                                                                       name="status"
                                                                                       value="0" <?php echo e($dataValues->where('key_name',$gateway->key_name)->first()->live_values['status']?'':'checked'); ?> <?php echo e($isPublished); ?>>
                                                                                <label
                                                                                    for="<?php echo e($gateway->key_name); ?>-inactive"><?php echo e(translate('inactive')); ?></label>
                                                                            </div>
                                                                        </div>

                                                                        <input name="gateway"
                                                                               value="<?php echo e($gateway->key_name); ?>"
                                                                               class="hide-div">
                                                                        <input name="mode" value="live"
                                                                               class="hide-div">

                                                                        <?php ($skip=['gateway','mode','status']); ?>
                                                                        <?php $__currentLoopData = $dataValues->where('key_name',$gateway->key_name)->first()->live_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <?php if(!in_array($key,$skip)): ?>
                                                                                <div
                                                                                    class="form-floating mb-30 mt-30">
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           name="<?php echo e($key); ?>"
                                                                                           placeholder="<?php echo e(translate($key)); ?> *"
                                                                                           value="<?php echo e(env('APP_ENV')=='demo'?'':$value); ?>" <?php echo e($isPublished); ?>>
                                                                                    <label><?php echo e(translate($key)); ?>

                                                                                        *</label>
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </div>
                                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('configuration_update')): ?>
                                                                        <div class="d-flex justify-content-end">
                                                                            <button type="submit"
                                                                                    class="btn btn--primary demo_check" <?php echo e($isPublished); ?>>
                                                                                <?php echo e(translate('update')); ?>

                                                                            </button>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($webPage == 'payment_config' && $type == 'digital_payment'): ?>
                    <div class="tab-content">
                        <div
                            class="tab-pane fade <?php echo e($webPage == 'payment_config' && $type == 'digital_payment' ? 'show active' : ''); ?>"
                            id="digital_payment">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="page-title">
                                        <?php echo e(translate('Payment Gateway Configuration')); ?>

                                    </h4>
                                </div>
                                <div class="card-body p-30">
                                    <div class="row">
                                        <div class="col-12 col-md-12 mb-30">
                                            <div
                                                class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-3">
                                                <ul class="nav nav--tabs nav--tabs__style2" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link <?php echo e($type=='digital_payment'?'active':''); ?>"
                                                           href="<?php echo e(url('admin/configuration/get-third-party-config')); ?>?type=digital_payment&web_page=payment_config"><?php echo e(translate('Digital Payment Gateways')); ?></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link <?php echo e($type=='offline_payment'?'active':''); ?>"
                                                           href="<?php echo e(url('admin/configuration/offline-payment/list')); ?>?type=offline_payment&web_page=payment_config"><?php echo e(translate('Offline Payment')); ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <?php if($publishedStatus == 1): ?>
                                                <div class="col-12 mb-3">
                                                    <div class="card">
                                                        <div class="card-body d-flex justify-content-around">
                                                            <h4 class="text-danger pt-2">
                                                                <i class="tio-info-outined"></i>
                                                                <?php echo e(translate('Your current payment settings are disabled, because
                                                                you have enabled
                                                                payment gateway addon, To visit your currently
                                                                active payment gateway settings please follow
                                                                the link')); ?>.</h4>

                                                            <a href="<?php echo e(!empty($paymentUrl) ? $paymentUrl : ''); ?>"
                                                               class="btn btn-outline-primary"><?php echo e(translate('settings')); ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <div class="row">
                                                <?php ($isPublished = $publishedStatus == 1 ? 'disabled' : ''); ?>
                                                <?php $__currentLoopData = $dataValues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gateway): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="col-12 col-md-6 mb-30">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h4 class="page-title"><?php echo e(translate($gateway->key_name)); ?></h4>
                                                            </div>
                                                            <div class="card-body p-30">
                                                                <form
                                                                    action="<?php echo e(route('admin.configuration.payment-set')); ?>"
                                                                    method="POST"
                                                                    id="<?php echo e($gateway->key_name); ?>-form"
                                                                    enctype="multipart/form-data">
                                                                    <?php echo csrf_field(); ?>
                                                                    <?php echo method_field('PUT'); ?>
                                                                    <?php ($additional_data = $gateway['additional_data'] != null ? json_decode($gateway['additional_data']) : []); ?>
                                                                    <div class="discount-type">
                                                                        <div
                                                                            class="d-flex align-items-center gap-4 gap-xl-5 mb-30">
                                                                            <div class="custom-radio">
                                                                                <input type="radio"
                                                                                       id="<?php echo e($gateway->key_name); ?>-active"
                                                                                       name="status"
                                                                                       value="1" <?php echo e($dataValues->where('key_name',$gateway->key_name)->first()->live_values['status']?'checked':''); ?> <?php echo e($isPublished); ?>>
                                                                                <label
                                                                                    for="<?php echo e($gateway->key_name); ?>-active"><?php echo e(translate('active')); ?></label>
                                                                            </div>
                                                                            <div class="custom-radio">
                                                                                <input type="radio"
                                                                                       class="<?php echo e(checkCurrency($gateway->key_name, 'payment_gateway') === true && $gateway['is_active']  ? 'open-warning-modal' : ''); ?>"
                                                                                       data-gateway="<?php echo e($gateway->key_name); ?>" data-status="<?php echo e($gateway['is_active']); ?>"
                                                                                       id="<?php echo e($gateway->key_name); ?>-inactive"
                                                                                       name="status"
                                                                                       value="0" <?php echo e($dataValues->where('key_name',$gateway->key_name)->first()->live_values['status']?'':'checked'); ?> <?php echo e($isPublished); ?>>
                                                                                <label
                                                                                    for="<?php echo e($gateway->key_name); ?>-inactive"><?php echo e(translate('inactive')); ?></label>
                                                                            </div>
                                                                        </div>

                                                                        <?php ($gatewayImageFullPath = getPaymentGatewayImageFullPath(key: $gateway->key_name, settingsType: $gateway->settings_type, defaultPath: 'public/assets/admin-module/img/placeholder.png')); ?>
                                                                        <div class="payment--gateway-img justify-content-center d-flex align-items-center">
                                                                            <img class="payment-image-preview" id="<?php echo e($gateway->key_name); ?>-image-preview"
                                                                                 src="<?php echo e($gatewayImageFullPath); ?>" alt="<?php echo e(translate('image')); ?>">
                                                                        </div>

                                                                        <input name="gateway"
                                                                               value="<?php echo e($gateway->key_name); ?>"
                                                                               class="hide-div">

                                                                        <?php ($mode=$dataValues->where('key_name',$gateway->key_name)->first()->live_values['mode']); ?>
                                                                        <div class="form-floating mb-30 mt-30">
                                                                            <select
                                                                                class="js-select theme-input-style w-100"
                                                                                name="mode" <?php echo e($isPublished); ?>>
                                                                                <option
                                                                                    value="live" <?php echo e($mode=='live'?'selected':''); ?>><?php echo e(translate('live')); ?></option>
                                                                                <option
                                                                                    value="test" <?php echo e($mode=='test'?'selected':''); ?>><?php echo e(translate('test')); ?></option>
                                                                            </select>
                                                                        </div>

                                                                        <?php ($skip=['gateway','mode','status']); ?>
                                                                        <?php $__currentLoopData = $dataValues->where('key_name',$gateway->key_name)->first()->live_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <?php if(!in_array($key,$skip)): ?>
                                                                                <div
                                                                                    class="form-floating mb-30 mt-30">
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           name="<?php echo e($key); ?>"
                                                                                           placeholder="<?php echo e(translate($key)); ?> *"
                                                                                           value="<?php echo e(env('APP_ENV')=='demo'?'':$value); ?>" <?php echo e($isPublished); ?>>
                                                                                    <label><?php echo e(translate($key)); ?>

                                                                                        *</label>
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                                        <?php if($gateway['key_name'] == 'paystack'): ?>
                                                                            <div class="form-floating mb-30 mt-30">
                                                                                <input type="text"
                                                                                       class="form-control"
                                                                                       placeholder="<?php echo e(translate('Callback Url')); ?> *"
                                                                                       readonly
                                                                                       value="<?php echo e(env('APP_ENV')=='demo'?'': route('paystack.callback')); ?>" <?php echo e($isPublished); ?>>
                                                                                <label><?php echo e(translate('Callback Url')); ?>

                                                                                    *</label>
                                                                            </div>
                                                                        <?php endif; ?>

                                                                        <div class="form-floating gateway-title">
                                                                            <input type="text" class="form-control"
                                                                                   id="<?php echo e($gateway->key_name); ?>-title"
                                                                                   name="gateway_title"
                                                                                   placeholder="<?php echo e(translate('payment_gateway_title')); ?>"
                                                                                   value="<?php echo e($additional_data != null ? $additional_data->gateway_title : ''); ?>" <?php echo e($isPublished); ?>>
                                                                            <label
                                                                                for="<?php echo e($gateway->key_name); ?>-title"
                                                                                class="form-label"><?php echo e(translate('payment_gateway_title')); ?></label>
                                                                        </div>

                                                                        <div class="form-floating mb-3">
                                                                            <input type="file" class="form-control"
                                                                                   name="gateway_image"
                                                                                   accept=".jpg, .png, .jpeg|image/*"
                                                                                   id="<?php echo e($gateway->key_name); ?>-image">
                                                                        </div>

                                                                    </div>
                                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('configuration_update')): ?>
                                                                        <div class="d-flex justify-content-end">
                                                                            <button type="submit"
                                                                                    class="btn btn--primary demo_check" <?php echo e($isPublished); ?>>
                                                                                <?php echo e(translate('update')); ?>

                                                                            </button>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($webPage == 'payment_config' && $type == 'offline_payment'): ?>
                    <div class="tab-content">
                        <div
                            class="tab-pane fade <?php echo e($webPage == 'payment_config' && $type == 'offline_payment' ? 'show active' : ''); ?>"
                            id="offline_payment">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="page-title">
                                        <?php echo e(translate('Payment Config')); ?>

                                    </h4>
                                </div>
                                <div class="card-body p-30">
                                    <div class="row">
                                        <div class="col-12 col-md-12 mb-30">
                                            <div
                                                class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-3">
                                                <ul class="nav nav--tabs nav--tabs__style2" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link <?php echo e($type=='digital_payment'?'active':''); ?>"
                                                           href="<?php echo e(url()->current()); ?>?type=digital_payment&web_page=payment_config"><?php echo e(translate('Digital Payment Gateways')); ?></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link <?php echo e($type=='offline_payment'?'active':''); ?>"
                                                           href="<?php echo e(url()->current()); ?>?type=offline_payment&web_page=payment_config"><?php echo e(translate('Offline Payment')); ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <?php if($publishedStatus == 1): ?>
                                                <div class="col-12 mb-3">
                                                    <div class="card">
                                                        <div class="card-body d-flex justify-content-around">
                                                            <h4 class="text-danger pt-2">
                                                                <i class="tio-info-outined"></i>
                                                                <?php echo e(translate(' Your current payment settings are disabled, because
                                                                 you have enabled
                                                                 payment gateway addon, To visit your currently
                                                                 active payment gateway settings please follow
                                                                 the link.')); ?></h4>

                                                            <a href="<?php echo e(!empty($paymentUrl) ? $paymentUrl : ''); ?>"
                                                               class="btn btn-outline-primary"><?php echo e(translate('settings')); ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>


                                            <div class="row">
                                                <?php ($isPublished = $publishedStatus == 1 ? 'disabled' : ''); ?>
                                                <?php $__currentLoopData = $dataValues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gateway): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="col-12 col-md-6 mb-30">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h4 class="page-title"><?php echo e(translate($gateway->key_name)); ?></h4>
                                                            </div>
                                                            <div class="card-body p-30">
                                                                <form
                                                                    action="<?php echo e(route('admin.configuration.payment-set')); ?>"
                                                                    method="POST"
                                                                    id="<?php echo e($gateway->key_name); ?>-form"
                                                                    enctype="multipart/form-data">
                                                                    <?php echo csrf_field(); ?>
                                                                    <?php echo method_field('PUT'); ?>
                                                                    <?php ($additional_data = $gateway['additional_data'] != null ? json_decode($gateway['additional_data']) : []); ?>
                                                                    <div class="discount-type">
                                                                        <div
                                                                            class="d-flex align-items-center gap-4 gap-xl-5 mb-30">
                                                                            <div class="custom-radio">
                                                                                <input type="radio"
                                                                                       id="<?php echo e($gateway->key_name); ?>-active"
                                                                                       name="status"
                                                                                       value="1" <?php echo e($dataValues->where('key_name',$gateway->key_name)->first()->live_values['status']?'checked':''); ?> <?php echo e($isPublished); ?>>
                                                                                <label
                                                                                    for="<?php echo e($gateway->key_name); ?>-active"><?php echo e(translate('active')); ?></label>
                                                                            </div>
                                                                            <div class="custom-radio">
                                                                                <input type="radio"
                                                                                       id="<?php echo e($gateway->key_name); ?>-inactive"
                                                                                       name="status"
                                                                                       value="0" <?php echo e($dataValues->where('key_name',$gateway->key_name)->first()->live_values['status']?'':'checked'); ?> <?php echo e($isPublished); ?>>
                                                                                <label
                                                                                    for="<?php echo e($gateway->key_name); ?>-inactive"><?php echo e(translate('inactive')); ?></label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="payment--gateway-img justify-content-center d-flex align-items-center">
                                                                            <?php ($gatewayImageFullPath = getPaymentGatewayImageFullPath(key: $gateway->key_name, settingsType: $gateway->settings_type, defaultPath: 'public/assets/admin-module/img/placeholder.png')); ?>

                                                                            <img class="payment-image-preview" id="<?php echo e($gateway->key_name); ?>-image-preview"
                                                                                src="<?php echo e($gatewayImageFullPath); ?>" alt="<?php echo e(translate('image')); ?>">
                                                                        </div>

                                                                        <input name="gateway"
                                                                               value="<?php echo e($gateway->key_name); ?>"
                                                                               class="hide-div">

                                                                        <?php ($mode=$dataValues->where('key_name',$gateway->key_name)->first()->live_values['mode']); ?>
                                                                        <div class="form-floating mb-30 mt-30">
                                                                            <select
                                                                                class="js-select theme-input-style w-100"
                                                                                name="mode" <?php echo e($isPublished); ?>>
                                                                                <option
                                                                                    value="live" <?php echo e($mode=='live'?'selected':''); ?>><?php echo e(translate('live')); ?></option>
                                                                                <option
                                                                                    value="test" <?php echo e($mode=='test'?'selected':''); ?>><?php echo e(translate('test')); ?></option>
                                                                            </select>
                                                                        </div>

                                                                        <?php ($skip=['gateway','mode','status']); ?>
                                                                        <?php $__currentLoopData = $dataValues->where('key_name',$gateway->key_name)->first()->live_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <?php if(!in_array($key,$skip)): ?>
                                                                                <div
                                                                                    class="form-floating mb-30 mt-30">
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           name="<?php echo e($key); ?>"
                                                                                           placeholder="<?php echo e(translate($key)); ?> *"
                                                                                           value="<?php echo e(env('APP_ENV')=='demo'?'':$value); ?>" <?php echo e($isPublished); ?>>
                                                                                    <label><?php echo e(translate($key)); ?>

                                                                                        *</label>
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                                        <div class="form-floating gateway-title">
                                                                            <input type="text" class="form-control"
                                                                                   id="<?php echo e($gateway->key_name); ?>-title"
                                                                                   name="gateway_title"
                                                                                   placeholder="<?php echo e(translate('payment_gateway_title')); ?>"
                                                                                   value="<?php echo e($additional_data != null ? $additional_data->gateway_title : ''); ?>" <?php echo e($isPublished); ?>>
                                                                            <label
                                                                                for="<?php echo e($gateway->key_name); ?>-title"
                                                                                class="form-label"><?php echo e(translate('payment_gateway_title')); ?></label>
                                                                        </div>

                                                                        <div class="form-floating mb-3">
                                                                            <input type="file" class="form-control"
                                                                                   name="gateway_image"
                                                                                   accept=".jpg, .png, .jpeg|image/*"
                                                                                   id="<?php echo e($gateway->key_name); ?>-image">
                                                                        </div>

                                                                    </div>
                                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('configuration_update')): ?>
                                                                        <div class="d-flex justify-content-end">
                                                                            <button type="submit"
                                                                                    class="btn btn--primary demo_check" <?php echo e($isPublished); ?>>
                                                                                <?php echo e(translate('update')); ?>

                                                                            </button>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($webPage == 'storage_connection'): ?>
                    <div class="tab-content">
                        <div class="tab-pane fade <?php echo e($webPage == 'storage_connection' ? 'show active' : ''); ?>" id="storage_connection">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mb-3">
                                        <?php echo e(translate('storage Connection Setting')); ?>

                                    </h4>

                                    <div class="row g-4">
                                        <?php ($storageType = business_config('storage_connection_type', 'storage_settings')); ?>
                                        <div class="col-sm-6 col-lg-4">
                                            <div class="border p-3 rounded d-flex justify-content-between">
                                                <div class="d-flex gap-2">
                                                    <span class="text-capitalize"><?php echo e(translate('Local System')); ?></span>
                                                    <i class="material-symbols-outlined cursor-pointer" data-bs-toggle="tooltip" title="<?php echo e(translate('If enabled System will store all files and images to local storage')); ?>">info</i>
                                                </div>
                                                <label class="switcher">
                                                    <input class="switcher_input <?php if(env('app_env')!='demo'): ?> change-storage-connection-type <?php endif; ?>"
                                                           type="checkbox"
                                                           data-name="local"
                                                           data-value="$(this).is(':checked')===true?1:0"
                                                           <?php echo e(isset($storageType) && $storageType->live_values == 'local' ? 'checked' : ''); ?>

                                                           id="local_system">
                                                    <span class="switcher_control"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-4">
                                            <div class="border p-3 rounded d-flex justify-content-between">
                                                <div class="d-flex gap-2">
                                                    <span class="text-capitalize"><?php echo e(translate('3rd Party Storage')); ?></span>
                                                    <i class="material-symbols-outlined cursor-pointer" data-bs-toggle="tooltip" title="<?php echo e(translate('If enabled System will store all files and images to 3rd party storage')); ?>">info</i>
                                                </div>
                                                <label class="switcher">
                                                    <input class="switcher_input <?php if(env('app_env')!='demo'): ?> change-storage-connection-type <?php endif; ?>"
                                                           type="checkbox"
                                                           data-name="s3"
                                                           data-value="$(this).is(':checked')===true?1:0"
                                                           <?php echo e(isset($storageType) && $storageType->live_values == 's3' ? 'checked' : ''); ?>

                                                           id="3rd_party_storage" <?php if(env('app_env')=='demo'): ?> disabled <?php endif; ?>>
                                                    <span class="switcher_control"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                                $s3Credentials = business_config('s3_storage_credentials', 'storage_settings');
                                if ($s3Credentials !== null && isset($s3Credentials->live_values)) {
                                    $liveValues = json_decode($s3Credentials->live_values, true);
                                } else {
                                    $liveValues = [
                                        'key' => '',
                                        'secret' => '',
                                        'region' => '',
                                        'bucket' => '',
                                        'url' => '',
                                        'endpoint' => '',
                                        'use_path_style_endpoint' => ''
                                    ];
                                }
                            ?>
                            <form action="<?php echo e(route('admin.configuration.update-storage-connection')); ?>" id="update-storage-form" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>

                                <div class="card mt-3">
                                    <div class="card-body border-bottom">
                                        <h4 class="mb-2"><?php echo e(translate('S3 Credential')); ?></h4>
                                        <p class="fs-12">
                                            <?php echo e(translate('The Access Key ID is a publicly accessible identifier used to authenticate requests to S3.')); ?>

                                            <a href="https://aws.amazon.com/s3/" target="_blank" class="c1 text-decoration-underline" data-bs-toggle="tooltip" title=""><?php echo e(translate('Learn more')); ?></a>
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        <div class="border rounded p-30">
                                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                                <div class="min-w180"><strong><?php echo e(translate('Key')); ?></strong></div>
                                                <div class="d-flex flex-column gap-2 flex-grow-1">
                                                    <input type="text" name="key" class="form-control" value="<?php echo e($liveValues['key']); ?>" placeholder="<?php echo e(translate('Enter key')); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border rounded p-30 mt-3">
                                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                                <div class="min-w180"><strong><?php echo e(translate('Secret Credential')); ?></strong></div>
                                                <div class="d-flex flex-column gap-2 flex-grow-1">
                                                    <input type="text" name="secret" class="form-control" value="<?php echo e($liveValues['secret']); ?>" placeholder="<?php echo e(translate('Enter secret credential')); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border rounded p-30 mt-3">
                                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                                <div class="min-w180"><strong><?php echo e(translate('Region')); ?></strong></div>
                                                <div class="d-flex flex-column gap-2 flex-grow-1">
                                                    <input type="text" name="region" class="form-control" value="<?php echo e($liveValues['region']); ?>" placeholder="<?php echo e(translate('Enter region')); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border rounded p-30 mt-3">
                                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                                <div class="min-w180"><strong><?php echo e(translate('Bucket')); ?></strong></div>
                                                <div class="d-flex flex-column gap-2 flex-grow-1">
                                                    <input type="text" name="bucket" class="form-control" value="<?php echo e($liveValues['bucket']); ?>" placeholder="<?php echo e(translate('Enter bucket')); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border rounded p-30 mt-3">
                                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                                <div class="min-w180"><strong><?php echo e(translate('Url')); ?></strong></div>
                                                <div class="d-flex flex-column gap-2 flex-grow-1">
                                                    <input type="text" name="url" class="form-control" value="<?php echo e($liveValues['url']); ?>" placeholder="<?php echo e(translate('Enter url')); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border rounded p-30 mt-3">
                                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                                <div class="min-w180"><strong><?php echo e(translate('Endpoint')); ?></strong></div>
                                                <div class="d-flex flex-column gap-2 flex-grow-1">
                                                    <input type="text" name="endpoint" class="form-control" value="<?php echo e($liveValues['endpoint']); ?>" placeholder="<?php echo e(translate('Enter endpoint')); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <div class="d-flex justify-content-end gap-3">
                                                <button type="reset" class="btn btn--secondary"><?php echo e(translate('Reset')); ?></button>
                                                <button type="button" class="btn btn--primary demo_check" data-bs-toggle="modal" data-bs-target="#confirmation"><?php echo e(translate('Save Information')); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($webPage == 'app_settings'): ?>
                    <div class="tab-content">
                        <div class="tab-pane fade <?php echo e($webPage == 'app_settings' ? 'show active' : ''); ?>"
                             id="app_settings">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="page-title">
                                        <?php echo e(translate('Customer App Configuration')); ?>

                                    </h4>
                                </div>
                                <div class="card-body p-30">
                                    <div class="row">
                                        <div class="col-12 col-md-12 mb-30">
                                            <div class="mb-3">
                                                <ul class="nav nav--tabs nav--tabs__style2">
                                                    <li class="nav-item">
                                                        <button data-bs-toggle="tab" data-bs-target="#customer"
                                                                class="nav-link active">
                                                            <?php echo e(translate('Customer')); ?>

                                                        </button>
                                                    </li>
                                                    <li class="nav-item">
                                                        <button data-bs-toggle="tab" data-bs-target="#provider"
                                                                class="nav-link">
                                                            <?php echo e(translate('Provider')); ?>

                                                        </button>
                                                    </li>
                                                    <li class="nav-item">
                                                        <button data-bs-toggle="tab" data-bs-target="#serviceman"
                                                                class="nav-link">
                                                            <?php echo e(translate('Serviceman')); ?>

                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="tab-content">
                                                <div class="tab-pane fade show active" id="customer">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4 class="page-title"><?php echo e(translate('Customer_app_configuration')); ?></h4>
                                                        </div>
                                                        <div class="card-body p-30">
                                                            <div class="alert alert-danger mb-30">
                                                                <p>
                                                                    <i class="material-icons">info</i>
                                                                    <?php echo e(translate('If there is any update available in the admin panel and for that the previous app will not work. You can force the customer from here by providing the minimum version for force update. That means if a customer has an app below this version the customers must need to update the app first. If you do not need a force update just insert here zero (0) and ignore it.')); ?>

                                                                </p>
                                                            </div>
                                                            <form
                                                                action="<?php echo e(route('admin.configuration.set-app-settings')); ?>"
                                                                method="POST"
                                                                id="google-map-update-form"
                                                                enctype="multipart/form-data">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('PUT'); ?>
                                                                <div class="discount-type">
                                                                    <div class="row">
                                                                        <div class="col-md-6 col-12">
                                                                            <div class="mb-30">
                                                                                <div class="form-floating">
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           name="min_version_for_android"
                                                                                           placeholder="<?php echo e(translate('min_version_for_android')); ?> *"
                                                                                           required=""
                                                                                           value="<?php echo e($customerDataValues->min_version_for_android??''); ?>"
                                                                                           pattern="^\d+(\.\d+){0,2}$"
                                                                                           title="Please enter a version number like 1.0.0 with a maximum of two dots.">
                                                                                    <label><?php echo e(translate('min_version_for_android')); ?>

                                                                                        *</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 col-12">
                                                                            <div class="mb-30">
                                                                                <div class="form-floating">
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           name="min_version_for_ios"
                                                                                           placeholder="<?php echo e(translate('min_version_for_IOS')); ?> *"
                                                                                           required=""
                                                                                           value="<?php echo e($customerDataValues->min_version_for_ios??''); ?>"
                                                                                           pattern="^\d+(\.\d+){0,2}$"
                                                                                           title="Please enter a version number like 1.0.0 with a maximum of two dots.">
                                                                                    <label><?php echo e(translate('min_version_for_IOS')); ?>

                                                                                        *</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <input name="app_type" value="customer"
                                                                               class="hide-div">
                                                                    </div>
                                                                </div>
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('configuration_update')): ?>
                                                                    <div class="d-flex justify-content-end">
                                                                        <button type="submit"
                                                                                class="btn btn--primary demo_check">
                                                                            <?php echo e(translate('update')); ?>

                                                                        </button>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-content">
                                                <div class="tab-pane fade" id="provider">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4 class="page-title"><?php echo e(translate('Provider_app_configuration')); ?></h4>
                                                        </div>
                                                        <div class="card-body p-30">
                                                            <div class="alert alert-danger mb-30">
                                                                <p>
                                                                    <i class="material-icons">info</i>
                                                                    <?php echo e(translate('If there is any update available in the admin panel and for that the previous app will not work. You can force the user from here by providing the minimum version for force update. That means if a user has an app below this version the users must need to update the app first. If you do not need a force update just insert here zero (0) and ignore it.')); ?>

                                                                </p>
                                                            </div>
                                                            <form
                                                                action="<?php echo e(route('admin.configuration.set-app-settings')); ?>"
                                                                method="POST"
                                                                id="google-map-update-form"
                                                                enctype="multipart/form-data">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('PUT'); ?>
                                                                <div class="discount-type">
                                                                    <div class="row">
                                                                        <div class="col-md-6 col-12">
                                                                            <div class="mb-30">
                                                                                <div class="form-floating">
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           name="min_version_for_android"
                                                                                           placeholder="<?php echo e(translate('min_version_for_android')); ?> *"
                                                                                           required=""
                                                                                           value="<?php echo e($providerDataValues->min_version_for_android??''); ?>"
                                                                                           pattern="^\d+(\.\d+){0,2}$"
                                                                                           title="Please enter a version number like 1.0.0 with a maximum of two dots.">
                                                                                    <label><?php echo e(translate('min_version_for_android')); ?>

                                                                                        *</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 col-12">
                                                                            <div class="mb-30">
                                                                                <div class="form-floating">
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           name="min_version_for_ios"
                                                                                           placeholder="<?php echo e(translate('min_version_for_IOS')); ?> *"
                                                                                           required=""
                                                                                           value="<?php echo e($providerDataValues->min_version_for_ios??''); ?>"
                                                                                           pattern="^\d+(\.\d+){0,2}$"
                                                                                           title="Please enter a version number like 1.0.0 with a maximum of two dots.">
                                                                                    <label><?php echo e(translate('min_version_for_IOS')); ?>

                                                                                        *</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <input name="app_type" value="provider"
                                                                               class="hide-div">
                                                                    </div>
                                                                </div>
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('configuration_update')): ?>
                                                                    <div class="d-flex justify-content-end">
                                                                        <button type="submit"
                                                                                class="btn btn--primary demo_check">
                                                                            <?php echo e(translate('update')); ?>

                                                                        </button>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-content">
                                                <div class="tab-pane fade" id="serviceman">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4 class="page-title"><?php echo e(translate('Serviceman_app_configuration')); ?></h4>
                                                        </div>
                                                        <div class="card-body p-30">
                                                            <div class="alert alert-danger mb-30">
                                                                <p>
                                                                    <i class="material-icons">info</i>
                                                                    <?php echo e(translate('If there is any update available in the admin panel and for that the previous app will not work. You can force the user from here by providing the minimum version for force update. That means if a user has an app below this version the users must need to update the app first. If you do not need a force update just insert here zero (0) and ignore it.')); ?>

                                                                </p>
                                                            </div>
                                                            <form
                                                                action="<?php echo e(route('admin.configuration.set-app-settings')); ?>"
                                                                method="POST"
                                                                id="google-map-update-form"
                                                                enctype="multipart/form-data">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('PUT'); ?>
                                                                <div class="discount-type">
                                                                    <div class="row">
                                                                        <div class="col-md-6 col-12">
                                                                            <div class="mb-30">
                                                                                <div class="form-floating">
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           name="min_version_for_android"
                                                                                           placeholder="<?php echo e(translate('min_version_for_android')); ?> *"
                                                                                           required=""
                                                                                           value="<?php echo e($servicemanDataValues->min_version_for_android??''); ?>"
                                                                                           pattern="^\d+(\.\d+){0,2}$"
                                                                                           title="Please enter a version number like 1.0.0 with a maximum of two dots.">
                                                                                    <label><?php echo e(translate('min_version_for_android')); ?>

                                                                                        *</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 col-12">
                                                                            <div class="mb-30">
                                                                                <div class="form-floating">
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           name="min_version_for_ios"
                                                                                           placeholder="<?php echo e(translate('min_version_for_IOS')); ?> *"
                                                                                           required=""
                                                                                           value="<?php echo e($servicemanDataValues->min_version_for_ios??''); ?>"
                                                                                           pattern="^\d+(\.\d+){0,2}$"
                                                                                           title="Please enter a version number like 1.0.0 with a maximum of two dots.">
                                                                                    <label><?php echo e(translate('min_version_for_IOS')); ?>

                                                                                        *</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <input name="app_type" value="serviceman"
                                                                               class="hide-div">
                                                                    </div>
                                                                </div>
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('configuration_update')): ?>
                                                                    <div class="d-flex justify-content-end">
                                                                        <button type="submit"
                                                                                class="btn btn--primary demo_check">
                                                                            <?php echo e(translate('update')); ?>

                                                                        </button>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php ($firebaseOtpVerification = (business_config('firebase_otp_verification', 'third_party'))?->live_values ?? ['status' => 0, 'web_api_key' => '']); ?>
                <?php if($webPage == 'firebase_otp_verification'): ?>
                    <div class="tab-content">
                        <div class="tab-pane fade <?php echo e($webPage == 'firebase_otp_verification' ? 'show active' : ''); ?>"
                             id="firebase_otp_verification">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="page-title">
                                        <?php echo e(translate('Firebase_auth_setup')); ?>

                                    </h4>
                                </div>
                                <div class="card-body p-30">
                                    <form action="<?php echo e(route('admin.configuration.set-third-party-config')); ?>"
                                          method="POST"
                                          id="firebase-otp-verification-form" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <div class="d-flex align-items-center gap-4 gap-xl-5 mb-30">
                                            <div class="custom-radio">
                                                <input type="radio" id="firebase-login-active"
                                                       name="status"
                                                       value="1" <?php echo e($firebaseOtpVerification['status']?'checked':''); ?>>
                                                <label for="firebase-login-active"><?php echo e(translate('active')); ?></label>
                                            </div>
                                            <div class="custom-radio">
                                                <input type="radio" id="firebase-login-inactive"
                                                       name="status"
                                                       value="0" <?php echo e($firebaseOtpVerification['status']?'':'checked'); ?>>
                                                <label for="firebase-login-inactive"><?php echo e(translate('inactive')); ?></label>
                                            </div>
                                        </div>
                                        <label>
                                            <input name="party_name" value="firebase_otp_verification"
                                                   class="hide-div">
                                        </label>
                                        <div class="form-floating">
                                            <input type="text" class="form-control"
                                                   name="web_api_key"
                                                   placeholder="<?php echo e(translate('Web api key')); ?> *"
                                                   value="<?php echo e(env('APP_ENV') != 'demo' ? $firebaseOtpVerification['web_api_key'] : ''); ?>" required>
                                            <label><?php echo e(translate('Web api key')); ?> *</label>
                                        </div>

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('configuration_update')): ?>
                                            <div class="d-flex justify-content-end mt-4">
                                                <button type="submit" class="btn btn--primary demo_check">
                                                    <?php echo e(translate('update')); ?>

                                                </button>
                                            </div>
                                        <?php endif; ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirmation" tabindex="-1" aria-labelledby="confirmationLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-30">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="d-flex flex-column gap-2 align-items-center text-center">
                        <img class="mb-3" src="<?php echo e(asset('public/assets/admin-module')); ?>/img/ad_delete.svg" alt="">
                        <h3 class="mb-2"><?php echo e(translate('Are you sure you want save this information')); ?>?</h3>
                        <p><?php echo e(translate('Connecting to S3 server for storage means that only new data will be stored in the S3 server. Existing data saved in local storage will not be migrated to the S3 server.')); ?></p>
                        <div class="d-flex gap-3 justify-content-center flex-wrap">
                            <button type="button" class="btn btn--secondary"  data-bs-dismiss="modal"><?php echo e(translate('Cancel')); ?></button>
                            <?php if(env('APP_ENV') !='demo'): ?>
                            <button type="button" class="btn btn--primary" id="submit-storage-data"><?php echo e(translate('Continue')); ?></button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php ($currency = business_config('currency_code', 'business_information')->live_values); ?>
    <div class="modal fade" id="payment-gateway-warning-modal">
        <div class="modal-dialog modal-dialog-centered status-warning-modal">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body pb-5 pt-0">
                    <div class="max-349 mx-auto mb-20">
                        <div>
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="76" height="76" viewBox="0 0 76 76" fill="none">
                                    <path d="M38 0.5C17.3 0.5 0.5 17.3 0.5 38C0.5 58.7 17.3 75.5 38 75.5C58.7 75.5 75.5 58.7 75.5 38C75.5 17.3 58.7 0.5 38 0.5ZM38 60.5C35.25 60.5 33 58.25 33 55.5C33 52.75 35.25 50.5 38 50.5C40.75 50.5 43 52.75 43 55.5C43 58.25 40.75 60.5 38 60.5ZM43.725 21.725L42.05 41.775C41.875 43.875 40.125 45.5 38 45.5C35.875 45.5 34.125 43.875 33.95 41.775L32.275 21.725C32 18.375 34.625 15.5 38 15.5C41.2 15.5 43.75 18.1 43.75 21.25C43.75 21.4 43.75 21.575 43.725 21.725Z" fill="#FF6174"/>
                                </svg>
                                <h5 class="modal-title"></h5>
                            </div>
                            <div class="text-center" >
                                <h3 class="mb-4 mt-4"> <?php echo e(translate('Important Alert!')); ?></h3><span class="d-none" id="gateway_name"></span>
                                <div class="mb-4 mt-4"> <p><?php echo e(translate('You must activate at least one digital payment method that support your system currency (')); ?> <?php echo e($currency); ?> <?php echo e(translate(').Otherwise customer won’t see the digital payment option & won’t be able to pay via digitally from website and apps. ')); ?></h3></p></div>
                            </div>

                            <div class="text-center mb-4 mt-4" >
                                <a class="text-underline" href="<?php echo e(route('admin.business-settings.get-business-information')); ?>"> <?php echo e(translate('View_Currency_Settings.')); ?></a>
                            </div>
                        </div>

                        <div class="btn--container justify-content-center">
                            <button data-bs-dismiss="modal" id="confirm-currency-change" type="button"  class="btn btn--primary min-w-120"><?php echo e(translate('Turn Off')); ?></button>
                            <button data-bs-dismiss="modal" class="btn btn-secondary min-w-120" ><?php echo e(translate("Cancel")); ?></button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/swiper/swiper-bundle.min.js"></script>
    <script>
        "use strict";

        $(document).on('click', '.open-warning-modal', function(event) {
            const elements = document.querySelectorAll('.open-warning-modal');
            const count = elements.length;

            if(elements.length === 1){

                let gateway = $(this).data('gateway');
                if ($(this).val() == 0) {
                    event.preventDefault();
                    $('#payment-gateway-warning-modal').modal('show');
                    var formated_text=  gateway.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')
                    $('#gateway_name').attr('data-gateway_key', gateway).html(formated_text);
                    $(this).data('originalEvent', event);
                }
            }
        });

        $(document).on('click', '#confirm-currency-change', function() {
            var gatewayName =   $('#gateway_name').data('gateway_key');
            if (gatewayName) {
                $('#span_on_' + gatewayName).removeClass('checked');
            }

            var originalEvent = $('.open-warning-modal[data-gateway="' + gatewayName + '"]').data('originalEvent');
            if (originalEvent) {
                var newEvent = $.Event(originalEvent);
                $(originalEvent.target).trigger(newEvent);
            }

            $('#payment-gateway-warning-modal').modal('hide');
        });


        $('#submit-storage-data').on('click', function () {
            let isValid = true;
            $('#update-storage-form input').each(function() {
                let value = $(this).val();
                let fieldName = $(this).attr('name');
                if (value == '' || value == null || value.trim() === '' || /\s/.test(value)) {
                    isValid = false;
                    let errorMessage = "<?php echo e(translate('The ')); ?>" + fieldName;
                    if (value == '' || value == null || value.trim() === '') {
                        errorMessage += "<?php echo e(translate(' field is required')); ?>";
                    } else {
                        errorMessage += "<?php echo e(translate(' field cannot contain any kind of space')); ?>";
                    }
                    toastr.error(errorMessage);
                }
            });

            if (isValid) {
                $('#update-storage-form').submit();
            } else {
                $("#confirmation").modal("hide");
            }
        });

        $(document).ready(function ($) {
            $("#local_system").on('change', function () {
                const local = $(this).is(':checked') === true ? 1 : 0;

                if (local === 1) {
                    $("#3rd_party_storage").prop('checked', false);
                }
            });

            $("#3rd_party_storage").on('change', function () {
                const thirdParty = $(this).is(':checked') === true ? 1 : 0;

                if (thirdParty === 1) {
                    $("#local_system").prop('checked', false);
                }
            });
        });

        $('.change-storage-connection-type').on('click', function () {
            let name = $(this).data('name');
            let status = $(this).is(':checked') === true ? 1 : 0;

            Swal.fire({
                title: "<?php echo e(translate('are_you_sure')); ?>?",
                text: '<?php echo e(translate('You cannot activate both storage connection statuses at the same time. You must activate at least one status')); ?>',
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
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "<?php echo e(route('admin.configuration.change-storage-connection-type')); ?>",
                        data: {
                            name: name,
                            status: status,
                        },
                        type: 'put',
                        success: function (response) {
                            toastr.success('<?php echo e(translate('successfully_updated')); ?>')
                        },
                        error: function (error) {
                            toastr.error(error.responseJSON.message)
                        }
                    });
                }
            })
        });

        $('#google-map').on('submit', function (event) {
            event.preventDefault();
            let formData = new FormData(document.getElementById("google-map-update-form"));

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "<?php echo e(route('admin.configuration.set-third-party-config')); ?>",
                data: formData,
                processData: false,
                contentType: false,
                type: 'post',
                success: function (response) {
                    console.log(response)
                    toastr.success('<?php echo e(translate('successfully_updated')); ?>')
                },
                error: function () {

                }
            });
        });

        $('#firebase-form').on('submit', function (event) {
            event.preventDefault();

            let formData = new FormData(document.getElementById("firebase-form"));

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "<?php echo e(route('admin.configuration.set-third-party-config')); ?>",
                data: formData,
                processData: false,
                contentType: false,
                type: 'post',
                success: function (response) {
                    console.log(response)
                    toastr.success('<?php echo e(translate('successfully_updated')); ?>')
                },
                error: function () {

                }
            });
        });

        $('#recaptcha-form').on('submit', function (event) {
            event.preventDefault();

            let formData = new FormData(document.getElementById("recaptcha-form"));

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "<?php echo e(route('admin.configuration.set-third-party-config')); ?>",
                data: formData,
                processData: false,
                contentType: false,
                type: 'post',
                success: function (response) {
                    console.log(response)
                    toastr.success('<?php echo e(translate('successfully_updated')); ?>')
                },
                error: function () {

                }
            });
        });

        $('#apple-login-form').on('submit', function (event) {
            event.preventDefault();

            let formData = new FormData(document.getElementById("apple-login-form"));

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "<?php echo e(route('admin.configuration.set-third-party-config')); ?>",
                data: formData,
                processData: false,
                contentType: false,
                type: 'post',
                success: function (response) {
                    console.log(response)
                    toastr.success('<?php echo e(translate('successfully_updated')); ?>')
                },
                error: function () {

                }
            });
        });
        $('#firebase-otp-verification-form').on('submit', function (event) {
            event.preventDefault();

            let formData = new FormData(document.getElementById("firebase-otp-verification-form"));

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "<?php echo e(route('admin.configuration.set-third-party-config')); ?>",
                data: formData,
                processData: false,
                contentType: false,
                type: 'post',
                success: function (response) {
                    console.log(response)
                    toastr.success('<?php echo e(translate('successfully_updated')); ?>')
                },
                error: function () {

                }
            });
        });

        $('#config-form').on('submit', function (event) {
            event.preventDefault();
            if ('<?php echo e(env('APP_ENV')=='demo'); ?>') {
                demo_mode()
            } else {
                let formData = new FormData(document.getElementById("config-form"));

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "<?php echo e(route('admin.configuration.set-email-config')); ?>",
                    data: formData,
                    processData: false,
                    contentType: false,
                    type: 'post',
                    success: function (response) {
                        console.log(response)
                        if (response.response_code === 'default_400') {
                            toastr.error('<?php echo e(translate('all_fields_are_required')); ?>')
                        } else {
                            toastr.success('<?php echo e(translate('successfully_updated')); ?>')
                        }
                    },
                    error: function () {

                    }
                });
            }
        });

        let swiper = new Swiper(".modalSwiper", {
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
                dynamicBullets: true,
                autoHeight: true,
            },
        });
    </script>

    <script>
        "use strict";

        function ValidateEmail(inputText) {
            let mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            return !!inputText.match(mailformat);
        }

        $('#send-mail').on('click', function () {
            if (ValidateEmail($('#test-email').val())) {
                Swal.fire({
                    title: '<?php echo e(translate('Are you sure?')); ?>?',
                    text: "<?php echo e(translate('a_test_mail_will_be_sent_to_your_email')); ?>!",
                    showCancelButton: true,
                    cancelButtonColor: 'var(--c2)',
                    confirmButtonColor: 'var(--c1)',
                    confirmButtonText: '<?php echo e(translate('Yes')); ?>!'
                }).then((result) => {
                    if (result.value) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "<?php echo e(route('admin.configuration.send-mail')); ?>",
                            method: 'GET',
                            data: {
                                "email": $('#test-email').val()
                            },
                            beforeSend: function () {
                                $('#loading').show();
                            },
                            success: function (data) {
                                if (data.success === 2) {
                                    toastr.error(
                                        '<?php echo e(translate('email_configuration_error')); ?> !!'
                                    );
                                } else if (data.success === 1) {
                                    toastr.success(
                                        '<?php echo e(translate('email_configured_perfectly!')); ?>!'
                                    );
                                } else {
                                    toastr.info(
                                        '<?php echo e(translate('email_status_is_not_active')); ?>!'
                                    );
                                }
                            },
                            complete: function () {
                                $('#loading').hide();

                            }
                        });
                    }
                })
            } else {
                toastr.error('<?php echo e(translate('invalid_email_address')); ?> !!');
            }
        });

        $(document).ready(function () {
            $('input[name="firebase_content_type"]').change(function () {
                if ($(this).val() === 'file') {
                    $('.file-upload-div').show();

                    $('textarea[name="service_file_content"]').prop('readonly', true);
                } else if ($(this).val() === 'file_content') {
                    $('.file-upload-div').hide();
                    $('textarea[name="service_file_content"]').prop('readonly', false);
                }
            });
        });

        $(document).ready(function () {
            $('.email-config-status').on('click', function () {
                let status = $(this).is(':checked') === true ? 1 : 0;

                Swal.fire({
                    title: "<?php echo e(translate('are_you_sure')); ?>?",
                    text: '<?php echo e(translate('want_to_update_email_status')); ?>?',
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
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "<?php echo e(route('admin.configuration.email-status-update')); ?>",
                            data: {
                                value: status
                            },
                            type: 'put',
                            success: function (response) {
                                toastr.success('<?php echo e(translate('successfully_updated')); ?>')
                            },
                            error: function () {

                            }
                        });
                    } else {
                        if (status == 1) $(`#email-config-status`).prop('checked', false);
                        if (status == 0) $(`#email-config-status`).prop('checked', true);
                        Swal.fire('<?php echo e(translate('Changes are not saved')); ?>', '', 'info')
                    }
                })
            });
        });

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/BusinessSettingsModule/Resources/views/admin/third-party.blade.php ENDPATH**/ ?>