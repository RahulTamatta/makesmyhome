<header class="header fixed-top">
    <div class="container-fluid">
        <div class="d-flex gap-3 align-items-center justify-content-between">
            <div class="">
                <div class="header-toogle-menu">
                    <button class="toggle-menu-button aside-toggle border-0 bg-transparent p-0 dark-color">
                        <span class="material-icons">menu</span>
                    </button>
                </div>
            </div>
            <div class="d-flex align-items-center gap-4 flex-grow-1">
                <?php if($trialDuration == 0 && $packageSubscriber != null && $isPackageEnded > 0 && $isPackageEnded < $deadlineWarning): ?>
                <div class="cancellantion-note cancellantion-note__header border-0 flex-grow-1 d-flex justify-content-between gap-2 align-items-center text-danger rounded">
                        <div class="media gap-2 align-items-center w-0 flex-grow-1">
                            <img src="<?php echo e(asset('public/assets/provider-module')); ?>/img/icons/time_bottom.svg" class="svg text-danger wh-20" alt="">
                                <div class="media-body line-clamp-1" data-bs-toggle="tooltip" title="<?php echo e($deadlineWarningMessage); ?>">
                                    <?php echo e($deadlineWarningMessage); ?>

                                </div>
                        </div>
                        <button class="btn btn-danger text-capitalize py-2 px-3" data-bs-toggle="modal" data-bs-target="#priceModal"><?php echo e(translate('Renew')); ?></button>
                    </div>
                <?php endif; ?>
                <div class="header-right ms--auto">
                    <ul class="nav justify-content-end align-items-center gap-3 gap-md-4">
                        <li class="nav-item max-sm-m-0">
                            <button type="button" id="modalOpener" class="title-color bg--secondary border-0 rounded align-items-center py-2 px-2 px-md-3 d-flex gap-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                <span class="material-symbols-outlined">search</span>
                                <span class="d-none d-md-block"><?php echo e(translate('Search')); ?></span>
                                <span class="bg-card text-muted border rounded-3 p-1 fs-12 fw-bold lh-1 ms-1 ctrlplusk d-none d-md-block">Ctrl+K</span>
                            </button>
                        </li>
                        <li class="nav-item max-sm-m-0">
                            <div class="hs-unfold">
                                <div>
                                    <?php ( $local = session()->has('provider_local')?session('provider_local'):'en'); ?>
                                    <?php ($lang = Modules\BusinessSettingsModule\Entities\BusinessSettings::where('key_name','system_language')->first()); ?>
                                    <?php if($lang): ?>
                                        <div class="topbar-text dropdown d-flex">
                                            <a class="topbar-link dropdown-toggle d-flex align-items-center title-color gap-1 justify-content-between lagn-drop-btn"
                                               href="#" role="button" data-bs-toggle="dropdown"
                                               data-bs-offset="0,20"
                                               aria-expanded="false">
                                                <div class="d-flex align-items-center gap-1">
                                                    <?php $__currentLoopData = $lang['live_values']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($data['code']==$local): ?>
                                                            <?php ($language = collect(LANGUAGES)->where('code', $data['code'])->first()); ?>
                                                            <span class="material-icons">language</span>
                                                            <?php if($language): ?>
                                                                <span class="d-none d-md-block"><?php echo e($language['nativeName']); ?></span>
                                                                <span class="fz-10 d-none d-md-block">(<?php echo e($data['code']); ?>)</span>
                                                            <?php else: ?>
                                                                <span class="fz-10 d-none d-md-block">(<?php echo e($data['code']); ?>)</span>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </a>
                                            <ul class="dropdown-menu lang-menu min-w120">
                                                <?php $__currentLoopData = $lang['live_values']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($data['status']==1): ?>
                                                        <?php ($language = collect(LANGUAGES)->where('code', $data['code'])->first()); ?>
                                                        <li>
                                                            <a class="dropdown-item d-flex gap-2 align-items-center py-2 justify-content-between"
                                                               href="<?php echo e(route('provider.lang',[$data['code']])); ?>">
                                                                <?php if($language): ?>
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <span class="text-capitalize"><?php echo e($language['nativeName']); ?></span>
                                                                        <span class="fz-10">(<?php echo e($data['code']); ?>)</span>
                                                                    </div>
                                                                    <?php if($local == $data['code']): ?>
                                                                        <span class="material-symbols-outlined text-muted">check_circle</span>
                                                                    <?php endif; ?>
                                                                <?php else: ?>
                                                                    <span class="text-capitalize"><?php echo e($data['code']); ?></span>
                                                                <?php endif; ?>

                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="messages pe--12">
                                <a href="<?php echo e(route('provider.chat.index', ['user_type' => 'super_admin'])); ?>" class="header-icon count-btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Message">
                                    <span class="material-icons">sms</span>
                                    <span class="count" id="message_count">0</span>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="notification update-notification pe--12">
                                <a href="#" class="header-icon count-btn notification-icon" data-bs-toggle="dropdown">
                                   <div data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo e(translate('Notifications')); ?>">
                                        <span class="material-icons">notifications</span>
                                        <span class="count" id="notification_count">0</span>
                                   </div>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="show-notification-list" id="show-notification-list"></div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="user mt-n1">
                                <a href="#" class="header-icon user-icon" data-bs-toggle="dropdown">
                                    <div>
                                        <img width="30" height="30" src="<?php echo e(auth()->user()->provider->logo_full_path); ?>"
                                            class="rounded-circle aspect-square object-fit-cover" alt="<?php echo e(translate('logo')); ?>">
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="<?php echo e(route('provider.profile_update')); ?>"
                                       class="dropdown-item-text media gap-3 align-items-center">
                                        <div class="avatar">
                                            <img class="avatar-img rounded-circle aspect-square object-fit-cover" width="50" height="50" src="<?php echo e(auth()->user()->provider->logo_full_path); ?>"
                                                 alt="<?php echo e(translate('logo')); ?>">
                                        </div>
                                        <div class="media-body ">
                                            <h5 class="card-title"><?php echo e(Str::limit(auth()->user()->provider->company_name, 15)); ?></h5>
                                            <span class="card-text"><?php echo e(Str::limit(auth()->user()->email, 20)); ?></span>
                                        </div>
                                    </a>
                                    <a class="dropdown-item" href="<?php echo e(route('provider.profile_update')); ?>">
                                        <span class="text-truncate" title="Settings"><?php echo e(translate('Settings')); ?></span>
                                    </a>
                                    <a class="dropdown-item provider-logout cursor-pointer">
                                        <span class="text-truncate" title="Sign Out"><?php echo e(translate('Sign_Out')); ?></span>
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="modal fade removeSlideDown" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-content__search border-0 <?php echo e(env('APP_ENV') == 'demo' ? 'mt-5' : ''); ?>">
            <div class="d-flex flex-column gap-3">
                <div class="d-flex gap-2 align-items-center rounded bg-card py-2 px-3">
                    <form class="flex-grow-1" id="searchForm" method="post" action="<?php echo e(route('provider.search.routing')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="d-flex align-items-center global-search-container">
                            <span class="material-symbols-outlined">search</span>
                            <input class="form-control flex-grow-1 border-0 search-input" name="search" id="searchInput" type="search" placeholder="Search" aria-label="Search" autocomplete="off">
                        </div>
                    </form>
                    <button class="border-0 rounded-3 px-2 py-1" type="button" data-bs-dismiss="modal">Esc</button>
                </div>

                <div class="bg-card p-4 rounded-3 min-h-350">
                    <div class="search-result" id="searchResults">
                        <div class="text-center text-muted py-5"><?php echo e(translate('It appears that you have not yet searched.')); ?>.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/housecraft/public_html/Modules/ProviderManagement/Resources/views/layouts/partials/_header.blade.php ENDPATH**/ ?>