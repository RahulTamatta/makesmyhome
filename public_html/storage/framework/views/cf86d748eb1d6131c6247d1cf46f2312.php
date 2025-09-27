<?php $__env->startSection('title',translate('chat_list')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module/plugins/select2/select2.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/css/lightbox.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-title-wrap mb-3">
                <h2 class="page-title d-flex gap-3 align-items-center">
                    <?php echo e(translate('Messages')); ?>

                    <span class="badge bg--secondary fs-6"><?php echo e($chatList->count()); ?></span>
                </h2>
            </div>

            <div class="row gx-1">
                <div class="col-xl-3 col-lg-4">
                    <div class="card card-body px-0 h-100">
                        <div class="media align-items-center px-3 gap-3 mb-2">
                            <div class="d-flex flex-wrap justify-content-between align-items-center border-bottom mx-lg-4 mb-10 gap-3">
                                <ul class="nav nav--tabs">
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo e($type=='customer'?'active':''); ?>"
                                           href="<?php echo e(url()->current()); ?>?user_type=customer">
                                            <?php echo e(translate('customer')); ?>

                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo e($type=='provider_serviceman'?'active':''); ?>"
                                           href="<?php echo e(url()->current()); ?>?user_type=provider_serviceman">
                                            <?php echo e(translate('Service Man')); ?>

                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo e($type=='provider_admin'?'active':''); ?>"
                                           href="<?php echo e(url()->current()); ?>?user_type=provider_admin">
                                            <?php echo e(translate('Provider')); ?>

                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="inbox_people">
                            <div class="d-flex gap-3 align-items-center mx-3 mb-3">
                                <div class="input-group search-form__input_group">
                                        <span class="search-form__icon">
                                            <span class="material-icons">search</span>
                                        </span>
                                    <input type="search" class="h-40 flex-grow-1 search-form__input" id="chat-search"
                                           placeholder="Search Here">
                                </div>

                                <div class="ripple-animation" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php echo e(translate('Search by name or phone number to start the conversation')); ?>" type="button">
                                    <img src="<?php echo e(asset('/public/assets/admin-module/img/info.svg')); ?>" class="svg" alt="">
                                </div>
                            </div>

                            <div class="inbox_chat d-flex flex-column mt-1">
                                <?php $__currentLoopData = $chatList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php ($fromUser=$chat->channelUsers->where('user_id','!=',auth()->id())->first()); ?>
                                    <div class="chat_list chat-list-class <?php echo e($chat->is_read==0?'active':''); ?>"
                                         id="chat-<?php echo e($chat->id); ?>"
                                         data-route="<?php echo e(route('admin.chat.ajax-conversation',['channel_id'=>$chat->id,'offset'=>1])); ?>"
                                         data-chat="<?php echo e($chat->id); ?>">
                                        <div class="chat_people media gap-10" id="chat_people">
                                            <div class="position-relative">
                                                <img
                                                    <?php if(isset($fromUser->user) && $fromUser->user->user_type == 'customer'): ?>
                                                        src="<?php echo e($fromUser->user->profile_image_full_path); ?>"
                                                    <?php elseif(isset($fromUser->user) && $fromUser->user->user_type == 'provider-admin'): ?>
                                                        src="<?php echo e($fromUser->user->provider->logo_full_path); ?>"
                                                    <?php elseif(isset($fromUser->user) && $fromUser->user->user_type == 'provider-serviceman'): ?>
                                                        src="<?php echo e($fromUser->user->profile_image_full_path); ?>"
                                                    <?php else: ?>
                                                        src="<?php echo e(onErrorImage(
                                                                'null',
                                                                asset('storage/app/public/serviceman/profile').'/',
                                                                asset('public/assets/admin-module/img/media/user.png') ,
                                                                'serviceman/profile/')); ?>"
                                                    <?php endif; ?>
                                                    class="avatar rounded-circle" alt="<?php echo e(translate('image')); ?>">
                                                <span class="avatar-status bg-success"></span>
                                            </div>
                                            <div class="chat_ib media-body">
                                                <h5 class=""><?php echo e(isset($fromUser->user) ? ($fromUser->user->provider ? $fromUser->user->provider->company_name : $fromUser->user->first_name . ' ' . $fromUser->user->last_name)  : translate('no_user_found')); ?></h5>
                                                <span
                                                    class="fz-12"><?php echo e(isset($fromUser->user) ? ($fromUser->user->provider ? $fromUser->user->provider->company_phone : $fromUser->user->phone) : ''); ?></span>
                                            </div>
                                        </div>
                                        <?php if($chat->is_read==0): ?>
                                            <div class="bg-info text-white radius-50 px-1 fz-12"
                                                 id="badge-<?php echo e($chat->id); ?>">
                                                <span class="material-symbols-outlined">swipe_up</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-9 col-lg-8 mt-4 mt-lg-0">
                    <div class="card-header radius-10 mb-1 d-flex justify-content-end">
                        <button class="btn btn--primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#modal-conversation-start">
                            <span class="material-icons">add</span>
                            <?php echo e(translate('start_conversation')); ?>

                        </button>
                    </div>
                    <div class="card card-body card-chat justify-content-between" id="set-conversation">
                        <h4 class="d-flex align-items-center justify-content-center my-auto gap-2">
                            <span class="material-icons">chat</span>
                            <?php echo e(translate('start_conversation')); ?>

                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-conversation-start" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <label for="with-user" class="d-flex gap-2 fw-semibold">
                        <span class="material-icons">chat</span>
                        <?php echo e(translate('with_user')); ?>

                    </label>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="<?php echo e(route('admin.chat.create-channel')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body p-30">
                        <div class="form-group mb-30">
                            <select class="form-control" name="user_type" id="user_type">
                                <option value="" selected disabled><?php echo e(translate('Select_User_Type')); ?></option>
                                <option value="customer"><?php echo e(translate('customer')); ?></option>
                                <option value="provider-admin"><?php echo e(translate('provider')); ?></option>
                                <option value="provider-serviceman"><?php echo e(translate('serviceman')); ?></option>
                            </select>
                        </div>

                        <div class="form-group mb-30" id="customer">
                            <select class="form-control chat-js-select" name="customer_id">
                                <option value="" selected disabled><?php echo e(translate('Select_Customer')); ?></option>
                                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>">
                                        <?php echo e($item->first_name); ?> <?php echo e($item->last_name); ?> (<?php echo e($item->phone); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="form-group mb-30 d--none" id="provider">
                            <select class="form-control chat-js-select" name="provider_id">
                                <option value="" selected disabled><?php echo e(translate('Select_Provider')); ?></option>
                                <?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($item->provider): ?>
                                        <option value="<?php echo e($item->id); ?>">
                                            <?php echo e($item->provider->company_name??''); ?> (<?php echo e($item->provider->company_phone); ?>)
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="form-group mb-30 d--none" id="serviceman">
                            <select class="form-control chat-js-select" name="serviceman_id">
                                <option value="" selected disabled><?php echo e(translate('Select_Serviceman')); ?></option>
                                <?php $__currentLoopData = $servicemen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>">
                                        <?php echo e($item->first_name); ?> <?php echo e($item->last_name); ?> (<?php echo e($item->phone); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--secondary" data-bs-dismiss="modal"
                                aria-label="Close"><?php echo e(translate('close')); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo e(translate('start')); ?></button>
                    </div>
                </form>

            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('public/assets/js/lightbox.min.js')); ?>"></script>
    <script>

        "use Strict";

        $('.chat-list-class').on('click', function () {
            let chatId = $(this).data('chat');
            let route = $(this).data('route');
            fetch_conversation(route, chatId)
        })

        function fetch_conversation(route, chat_id) {
            $.get({
                url: route,
                dataType: 'json',
                data: {},
                beforeSend: function () {
                },
                success: function (response) {
                    $('#set-conversation').empty().html(response.template);
                    document.getElementById('chat-' + chat_id).classList.remove("active");
                    document.getElementById('badge-' + chat_id).classList.add("hide-div");
                },
                error: function (jqXHR, exception) {
                    if (jqXHR.responseJSON && jqXHR.responseJSON.errors && jqXHR.responseJSON.errors.length > 0) {
                        var errorMessages = jqXHR.responseJSON.errors.map(function (error) {
                            return error.message;
                        });

                        errorMessages.forEach(function (errorMessage) {
                            toastr.error(errorMessage);
                        });
                    } else {
                        toastr.error("An error occurred.");
                    }
                },
                complete: function () {
                },
            });
        }

        $(document).ready(function () {
            $('.chat-js-select').select2({
                dropdownParent : $('#modal-conversation-start')
            });
        });

    </script>

    <script src="<?php echo e(asset('public/assets/chatting-module/js/custom.js')); ?>"></script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/ChattingModule/Resources/views/admin/index.blade.php ENDPATH**/ ?>