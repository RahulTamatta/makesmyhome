<?php $__env->startSection('title',translate('Ads List')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <style>
        .alert--container .alert:not(.active) {
            display: none;
        }

        .alert--message-2 {
            border-left: 3px solid var(--success-color);
            border-radius: 6px;
            position: fixed;
            right: 20px;
            top: 80px;
            z-index: 9999;
            background: var(--white-color);
            width: 80vw;
            display: flex;
            max-width: 380px;
            align-items: center;
            gap: 12px;
            padding: 16px;
            font-size: 12px;
            transition: all ease 0.5s;
            box-shadow: 0 0 2rem rgba(0, 0, 0, 0.15);
        }

        .alert--message-2 h6 {
            font-size: 1rem;
        }

        .alert--message-2:not(.active) {
            transform: translateX(calc(100% + 40px));
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="main-content">
        <?php if(session('ads-store')): ?>
            <div class="d-flex align-items-center gap-2 alert--message-2 fade show active">
                <img width="28" class="align-self-start image"
                     src="<?php echo e(asset('public/assets/admin-module/img/icons/CircleWavyCheck.svg')); ?>" alt="">
                <div class="">
                    <h6 class="title mb-2 text-truncate"><?php echo e(translate('Ad Created Successfully')); ?>!</h6>
                    <p class="message"><?php echo e(translate('It will be live in time. To view the ad go to')); ?> <a
                            href="<?php echo e(route('admin.advertisements.ads-list')); ?>"
                            class="c1"><?php echo e(translate('Advertisement List')); ?></a>
                    </p>
                </div>
                <button type="button" class="btn-close position-relative p-0" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap d-flex align-items-center justify-content-between gap-2 mb-3">
                        <h2 class="page-title"><?php echo e(translate('Ads List')); ?></h2>
                        <div class="ripple-animation" data-bs-toggle="tooltip" data-bs-placement="top"
                             data-bs-title="<?php echo e(translate('View advertisement history here. You can see status wise advertisement history and adjust priority. Edit, pause, resume, resubmit, or delete as needed.')); ?>"
                             type="button">
                            <img src="<?php echo e(asset('/public/assets/admin-module/img/info.svg')); ?>" class="svg" alt="">
                        </div>
                    </div>

                    <?php if($advertisements->count() > 0): ?>
                        <div
                            class="d-flex flex-wrap justify-content-between align-items-center border-bottom mx-lg-4 mb-10 gap-3">
                            <ul class="nav nav--tabs">
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e($queryParams['status'] == 'all' ? 'active' : ''); ?>"
                                       href="<?php echo e(route('admin.advertisements.ads-list', ['status' => 'all'])); ?>">
                                        <?php echo e(translate('All')); ?>

                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link <?php echo e($queryParams['status'] == 'approved' ? 'active' : ''); ?>"
                                       href="<?php echo e(route('admin.advertisements.ads-list', ['status' => 'approved'])); ?>">
                                        <?php echo e(translate('Approved')); ?>

                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e($queryParams['status'] == 'running' ? 'active' : ''); ?>"
                                       href="<?php echo e(route('admin.advertisements.ads-list', ['status' => 'running'])); ?>">
                                        <?php echo e(translate('Running')); ?>

                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e($queryParams['status'] == 'expired' ? 'active' : ''); ?>"
                                       href="<?php echo e(route('admin.advertisements.ads-list', ['status' => 'expired'])); ?>">
                                        <?php echo e(translate('Expired')); ?>

                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e($queryParams['status'] == 'denied' ? 'active' : ''); ?>"
                                       href="<?php echo e(route('admin.advertisements.ads-list', ['status' => 'denied'])); ?>">
                                        <?php echo e(translate('Denied')); ?>

                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e($queryParams['status'] == 'paused' ? 'active' : ''); ?>"
                                       href="<?php echo e(route('admin.advertisements.ads-list', ['status' => 'paused'])); ?>">
                                        <?php echo e(translate('Paused')); ?>

                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between">

                                    <form
                                        action="<?php echo e(route('admin.advertisements.ads-list', ['status' => $queryParams['status']])); ?>"
                                        class="search-form search-form_style-two"
                                        method="get">
                                        <?php echo csrf_field(); ?>
                                        <div class="input-group search-form__input_group">
                                            <span class="search-form__icon">
                                                <span class="material-icons">search</span>
                                            </span>
                                            <input type="search" class="theme-input-style search-form__input"
                                                   value="<?php echo e($queryParams['search']); ?>" name="search"
                                                   placeholder="<?php echo e(translate('search_here')); ?>">
                                            <input type="hidden"
                                                   value="<?php echo e($queryParams['status']); ?>" name="status"
                                                   placeholder="<?php echo e(translate('search_here')); ?>">
                                        </div>
                                        <button type="submit"
                                                class="btn btn--primary"><?php echo e(translate('search')); ?></button>
                                    </form>

                                    <div class="d-flex flex-wrap align-items-center gap-3">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advertisement_add')): ?>
                                            <div
                                                class="page-title-wrap d-flex justify-content-between flex-wrap align-items-center gap-3">
                                                <a href="<?php echo e(route('admin.advertisements.ads-create')); ?>"
                                                   class="btn btn--primary"><?php echo e(translate('create_ads')); ?></a>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advertisement_export')): ?>
                                            <div class="dropdown">
                                                <button type="button"
                                                        class="btn btn--secondary text-capitalize dropdown-toggle"
                                                        data-bs-toggle="dropdown">
                                                <span class="material-icons">file_download</span> <?php echo e(translate('download')); ?>

                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                                    <li><a class="dropdown-item"
                                                           href="<?php echo e(route('admin.advertisements.download', ['status' => $queryParams['status'], 'search' => $queryParams['search']])); ?>"><?php echo e(translate('excel')); ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="example" class="table align-middle">
                                        <thead class="text-nowrap">
                                        <tr>
                                            <th><?php echo e(translate('SL')); ?></th>
                                            <th><?php echo e(translate('Title')); ?></th>
                                            <th><?php echo e(translate('Advertisement ID')); ?></th>
                                            <th><?php echo e(translate('Provider Info')); ?></th>
                                            <th><?php echo e(translate('Ads Type')); ?></th>
                                            <th><?php echo e(translate('Duration')); ?></th>
                                            <?php if($queryParams['status'] == 'all' || $queryParams['status'] == 'expired'): ?>
                                                <th class="text-center"><?php echo e(translate('Status')); ?></th>
                                            <?php endif; ?>
                                            <th class="text-center"><?php echo e(translate('Priority')); ?></th>
                                            <th class="text-center"><?php echo e(translate('Action')); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $advertisements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $advertisement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td><?php echo e($advertisements->firstitem()+$key); ?></td>
                                                <td>
                                                    <a href="<?php echo e(route('admin.advertisements.details',[$advertisement->id])); ?>"><?php echo e(Str::limit($advertisement->title, 40)); ?></a>
                                                </td>
                                                <td>
                                                    <a href="<?php echo e(route('admin.advertisements.details',[$advertisement->id])); ?>"><?php echo e($advertisement->readable_id); ?></a>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column gap-1">
                                                        <span><?php echo e($advertisement?->provider?->company_name); ?></span>
                                                        <a href="mailto:<?php echo e($advertisement?->provider?->company_email); ?>"
                                                           class="fs-12"><?php echo e($advertisement?->provider?->company_email); ?></a>
                                                    </div>
                                                </td>
                                                <td><?php echo e(ucwords(str_replace('_', ' ', $advertisement->type))); ?></td>
                                                <td>
                                                    <div class="d-flex flex-column gap-1 fs-12">
                                                        <span><?php echo e($advertisement->start_date->format('Y-m-d')); ?></span>
                                                        <span><?php echo e($advertisement->end_date->format('Y-m-d')); ?></span>
                                                    </div>
                                                </td>
                                                <?php if($queryParams['status'] == 'all' || $queryParams['status'] == 'expired'): ?>
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <?php if($advertisement->status == 'pending'): ?>
                                                                <label
                                                                    class="badge badge-info"><?php echo e($advertisement->status); ?></label>
                                                            <?php elseif(($advertisement->status == 'approved' || $advertisement->status == 'resumed') && ($advertisement->start_date <= \Carbon\Carbon::today() && $advertisement->end_date >= \Carbon\Carbon::today() ) ): ?>
                                                                <label
                                                                    class="badge badge-primary"><?php echo e(translate('Running')); ?>

                                                                    <?php elseif($advertisement->status == 'approved'): ?>
                                                                        <label
                                                                            class="badge badge-success"><?php echo e(translate('Approved')); ?>

                                                                            <?php elseif($advertisement->status == 'paused'): ?>
                                                                                <label
                                                                                    class="badge badge-success"><?php echo e(translate('Paused')); ?></label>
                                                                            <?php elseif($advertisement->status == 'resumed'): ?>
                                                                                <label
                                                                                    class="badge badge-success"><?php echo e(translate('Resumed')); ?></label>
                                                                            <?php elseif($advertisement->status == 'running'): ?>
                                                                                <label
                                                                                    class="badge badge-primary"><?php echo e(translate('running')); ?></label>
                                                                            <?php elseif($advertisement->status == 'expired'): ?>
                                                                                <label
                                                                                    class="badge badge-secondary"><?php echo e(translate('Expired')); ?></label>
                                                                            <?php elseif($advertisement->status == 'denied' || $advertisement->status == 'canceled'): ?>
                                                                                <label
                                                                                    class="badge badge-danger"><?php echo e($advertisement->status); ?></label>
                                                            <?php endif; ?>
                                                        </div>
                                                        <?php
                                                            $end_date = \Carbon\Carbon::parse($advertisement->end_date)->startOfDay();
                                                            $today = \Carbon\Carbon::today();
                                                        ?>
                                                        <?php if($end_date < $today): ?>
                                                            <div class="text-center">
                                                                <small class="text-muted text-center">(<?php echo e(translate('Expired')); ?>)</small>
                                                            </div>
                                                        <?php endif; ?>
                                                    </td>
                                                <?php endif; ?>
                                                <td>
                                                    <div class="d-flex justify-content-center set-priority"
                                                         data-id="<?php echo e($advertisement->id); ?>"
                                                         data-action="<?php echo e(route('admin.advertisements.set-priority', [$advertisement->id])); ?>"
                                                         data-bs-toggle="modal" data-bs-target="#setPriorityModal">
                                                        <?php if($advertisement->priority == null): ?>
                                                            <div class="text-muted d-flex gap-1 align-items-center">
                                                                <span class="lh-1 mt-1">N/A</span>
                                                                <span data-bs-toggle="tooltip"
                                                                      title="Priority isn't set yet!">
                                                                <img
                                                                    src="<?php echo e(asset('public/assets/admin-module')); ?>/img/icons/info-hexa.svg"
                                                                    alt="">
                                                            </span>
                                                            </div>
                                                        <?php else: ?>
                                                            <span><?php echo e($advertisement->priority); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center">
                                                        <div class="dropdown dropdown__style--two">
                                                            <button type="button" class="bg-transparent border-0 title-color"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                <span class="material-symbols-outlined">more_vert</span>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advertisement_view')): ?>
                                                                    <a class="dropdown-item d-flex gap-2 align-items-center"
                                                                       href="<?php echo e(route('admin.advertisements.details',[$advertisement->id])); ?>">
                                                                <span
                                                                    class="material-icons">visibility</span>
                                                                        <?php echo e(translate('View Ads')); ?>

                                                                    </a>
                                                                <?php endif; ?>
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advertisement_update')): ?>
                                                                    <a class="dropdown-item d-flex gap-2 align-items-center"
                                                                       href="<?php echo e(route('admin.advertisements.edit',[$advertisement->id])); ?>">
                                                                        <span
                                                                            class="material-icons">edit</span>
                                                                        <?php echo e(translate('Edit Ads')); ?>

                                                                    </a>
                                                                <?php endif; ?>
                                                                <?php if($advertisement->status == 'pending'): ?>
                                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advertisement_approve_or_deny')): ?>
                                                                        <a class="dropdown-item d-flex gap-2 align-items-center"
                                                                           href="<?php echo e(route('admin.advertisements.status-update',[$advertisement->id, 'approved'])); ?>">
                                                                        <span
                                                                            class="material-icons">done</span>
                                                                            <?php echo e(translate('Approve Ads')); ?>

                                                                        </a>

                                                                        <a class="dropdown-item d-flex gap-2 align-items-center"
                                                                           href="#" data-bs-toggle="modal"
                                                                           data-bs-target="#deniedModal-<?php echo e($advertisement->id); ?>">
                                                                        <span
                                                                            class="material-icons">close</span>
                                                                            <?php echo e(translate('Deny Ads')); ?>

                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                                <?php if((!in_array($advertisement->status, ['pending', 'paused', 'denied', 'canceled']) || !$advertisement->where('end_date', '<', Carbon\Carbon::today()))): ?>
                                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advertisement_manage_status')): ?>
                                                                        <a class="dropdown-item d-flex gap-2 align-items-center set-priority"
                                                                           data-id="<?php echo e($advertisement->id); ?>"
                                                                           data-action="<?php echo e(route('admin.advertisements.set-priority', [$advertisement->id])); ?>"
                                                                           data-bs-toggle="modal"
                                                                           data-bs-target="#setPriorityModal">
                                                                            <span class="material-icons">format_list_bulleted</span>
                                                                            <?php echo e(translate('Set Priority')); ?>

                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                                <?php if($advertisement->whereIn('status', ['approved', 'resumed'])->where('start_date', '<=', Carbon\Carbon::today())->where('end_date', '>', Carbon\Carbon::today()) && in_array($advertisement->status, ['approved', 'resumed'])): ?>
                                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advertisement_manage_status')): ?>
                                                                        <a class="dropdown-item d-flex gap-2 align-items-center"
                                                                           href="#" data-bs-toggle="modal"
                                                                           data-bs-target="#pausedModal-<?php echo e($advertisement->id); ?>">
                                                                    <span
                                                                        class="material-icons">pause_circle</span>
                                                                            <?php echo e(translate('Pause Ads')); ?>

                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                                <?php if($advertisement->status == 'paused'): ?>
                                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advertisement_manage_status')): ?>
                                                                        <a class="dropdown-item d-flex gap-2 align-items-center"
                                                                           href="#" data-bs-toggle="modal"
                                                                           data-bs-target="#resumeModal-<?php echo e($advertisement->id); ?>">
                                                                    <span
                                                                        class="material-icons">play_arrow</span>
                                                                            <?php echo e(translate('Resume Ads')); ?>

                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                                <?php if((($advertisement->where('end_date', '<', Carbon\Carbon::today()) || $advertisement->status == 'denied')) && ($advertisement->status != 'approved' &&  !$advertisement->whereIn('status', ['approved', 'resumed'])->where('start_date', '<=', Carbon\Carbon::today())->where('end_date', '>', Carbon\Carbon::today()))): ?>
                                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advertisement_update')): ?>
                                                                        <a class="dropdown-item d-flex gap-2 align-items-center"
                                                                           href="<?php echo e(route('admin.advertisements.re-submit',[$advertisement->id])); ?>">
                                                                    <span
                                                                        class="material-icons">history</span>
                                                                            <?php echo e(translate('Re-submit Ads')); ?>

                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>

                                                                    <?php if(($advertisement->status == 'denied')): ?>
                                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advertisement_update')): ?>
                                                                            <a class="dropdown-item d-flex gap-2 align-items-center"
                                                                               href="<?php echo e(route('admin.advertisements.re-submit',[$advertisement->id])); ?>">
                                                                <span
                                                                    class="material-symbols-outlined">history</span>
                                                                                <?php echo e(translate('Re-submit Ads')); ?>

                                                                            </a>
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>

                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advertisement_delete')): ?>
                                                                        <?php if(($advertisement->status == 'approved' || $advertisement->status == 'resumed') && ($advertisement->start_date <= \Carbon\Carbon::today() && $advertisement->end_date > \Carbon\Carbon::today() )): ?>
                                                                        <a class="dropdown-item d-flex gap-2 align-items-center"
                                                                           data-bs-toggle="modal"
                                                                           data-bs-target="#adDeleteModal-<?php echo e($advertisement->id); ?>">
                                                                    <span class="material-icons">delete</span>
                                                                            <?php echo e(translate('Delete Ads')); ?>

                                                                        </a>
                                                                    <?php else: ?>
                                                                        <a class="dropdown-item d-flex gap-2 align-items-center delete_section"
                                                                           href="#" data-id="<?php echo e($advertisement->id); ?>">
                                                                    <span
                                                                        class="material-icons">delete</span>
                                                                            <?php echo e(translate('Delete Ads')); ?>

                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                                <form
                                                                    action="<?php echo e(route('admin.advertisements.delete',[$advertisement->id])); ?>"
                                                                    method="post" id="delete-<?php echo e($advertisement->id); ?>"
                                                                    class="hidden">
                                                                    <?php echo csrf_field(); ?>
                                                                    <?php echo method_field('DELETE'); ?>
                                                                </form>
                                                            </ul>
                                                        </div>

                                                        <div class="modal fade" id="deniedModal-<?php echo e($advertisement->id); ?>"
                                                             tabindex="-1"
                                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-body pt-5 p-md-5">
                                                                        <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        <div class="d-flex justify-content-center mb-4">
                                                                            <img width="75" height="75"
                                                                                 src="<?php echo e(asset('public/assets/admin-module/img/delete2.png')); ?>"
                                                                                 class="rounded-circle" alt="">
                                                                        </div>

                                                                        <h3 class="text-start mb-1 fw-medium text-center"><?php echo e(translate('Are you sure you want to deny the request?')); ?></h3>
                                                                        <p class="text-start fs-12 fw-medium text-muted text-center"><?php echo e(translate('You will lost the provider ads request')); ?></p>
                                                                        <form method="post"
                                                                              action="<?php echo e(route('admin.advertisements.status-update',[$advertisement->id, 'denied'])); ?>">
                                                                            <?php echo csrf_field(); ?>
                                                                            <div class="form-floating">
                                                                            <textarea class="form-control h-69px"
                                                                                      placeholder="<?php echo e(translate('Denied Note')); ?>"
                                                                                      name="note" id="add-your-note"
                                                                                      required></textarea>
                                                                                <label for="add-your-note"
                                                                                       class="d-flex align-items-center gap-1"><?php echo e(translate('Deny Note')); ?></label>
                                                                                <div
                                                                                    class="d-flex justify-content-center mt-3 gap-3">
                                                                                    <button type="button"
                                                                                            class="btn btn--secondary min-w-92px px-2"
                                                                                            data-bs-dismiss="modal"
                                                                                            aria-label="Close"><?php echo e(translate('Not Now')); ?></button>
                                                                                    <button type="submit"
                                                                                            class="btn btn--danger min-w-92px"><?php echo e(translate('Yes')); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        
                                                        <div class="modal fade"
                                                             id="adDeleteModal-<?php echo e($advertisement->id); ?>"
                                                             tabindex="-1"
                                                             aria-labelledby="adDeleteModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-body pt-5 p-md-5">
                                                                        <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        <div class="d-flex justify-content-center mb-4">
                                                                            <img width="75" height="75"
                                                                                 src="<?php echo e(asset('public/assets/admin-module/img/ad_delete.svg')); ?>"
                                                                                 class="rounded-circle" alt="">
                                                                        </div>

                                                                        <h3 class="text-start mb-1 fw-medium text-center"><?php echo e(translate('You can’t delete the ad')); ?></h3>
                                                                        <p class="text-start fs-12 fw-medium text-muted text-center"><?php echo e(translate('Your ad is running, To delete this ad from the list, please change its status first. Once the status is updated, you can proceed with deletion')); ?></p>                                                                        <div
                                                                            class="d-flex justify-content-center mt-3 gap-3">
                                                                            <button type="button"
                                                                                    class="btn btn--danger min-w-92px px-2"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close"><?php echo e(translate('Okay')); ?></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="modal fade" id="pausedModal-<?php echo e($advertisement->id); ?>"
                                                             tabindex="-1"
                                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-body pt-5 p-md-5">
                                                                        <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        <div class="d-flex justify-content-center mb-4">
                                                                            <img width="75" height="75"
                                                                                 src="<?php echo e(asset('public/assets/admin-module/img/paused.png')); ?>"
                                                                                 class="rounded-circle" alt="">
                                                                        </div>

                                                                        <h3 class="text-start mb-1 fw-medium text-center"><?php echo e(translate('Are you sure you want to Pause the request??')); ?></h3>
                                                                        <p class="text-start fs-12 fw-medium text-muted text-center"><?php echo e(translate('This ad will be pause and not show in the app or web')); ?></p>
                                                                        <form method="post"
                                                                              action="<?php echo e(route('admin.advertisements.status-update',[$advertisement->id, 'paused'])); ?>">
                                                                            <?php echo csrf_field(); ?>
                                                                            <div class="form-floating">
                                                                            <textarea class="form-control h-69px"
                                                                                      placeholder="<?php echo e(translate('Paused Note')); ?>"
                                                                                      name="note" id="add-paused-note"
                                                                                      required></textarea>
                                                                                <label for="add-your-note"
                                                                                       class="d-flex align-items-center gap-1"><?php echo e(translate('Paused Note')); ?></label>
                                                                                <div
                                                                                    class="d-flex justify-content-center mt-3 gap-3">
                                                                                    <button type="button"
                                                                                            class="btn btn--secondary min-w-92px px-2"
                                                                                            data-bs-dismiss="modal"
                                                                                            aria-label="Close"><?php echo e(translate('Not Now')); ?></button>
                                                                                    <button type="submit"
                                                                                            class="btn btn--danger min-w-92px"><?php echo e(translate('Yes')); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal fade" id="resumeModal-<?php echo e($advertisement->id); ?>"
                                                             tabindex="-1"
                                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-body pt-5 p-md-5">
                                                                        <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        <div class="d-flex justify-content-center mb-4">
                                                                            <img width="75" height="75"
                                                                                 src="<?php echo e(asset('public/assets/admin-module/img/resume.svg')); ?>"
                                                                                 class="rounded-circle" alt="">
                                                                        </div>

                                                                        <h3 class="text-start mb-1 fw-medium text-center"><?php echo e(translate('Are you sure you want to Resume the request???')); ?></h3>
                                                                        <p class="text-start fs-12 fw-medium text-muted text-center"><?php echo e(translate('This ad will be run again and will show in the app or web')); ?></p>
                                                                        <form method="post"
                                                                              action="<?php echo e(route('admin.advertisements.status-update',[$advertisement->id, 'resumed'])); ?>">
                                                                            <?php echo csrf_field(); ?>
                                                                            <div class="form-floating">
                                                                                <div
                                                                                    class="d-flex justify-content-center mt-3 gap-3">
                                                                                    <button type="button"
                                                                                            class="btn btn--secondary min-w-92px px-2"
                                                                                            data-bs-dismiss="modal"
                                                                                            aria-label="Close"><?php echo e(translate('Not Now')); ?></button>
                                                                                    <button type="submit"
                                                                                            class="btn btn--primary min-w-92px"><?php echo e(translate('Yes')); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr class="text-center">
                                                <td colspan="8"><?php echo e(translate('No_data_available')); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <?php echo $advertisements->links(); ?>

                                </div>
                            </div>
                        </div>
                    <?php elseif($queryParams['status'] == 'all' && $advertisements->count() == 0): ?>
                        <div class="card mt-5">
                            <div class="card-body">
                                <div class="d-flex flex-column gap-2 align-items-center text-center">
                                    <img width="140" class="mb-2"
                                         src="<?php echo e(asset('public/assets/provider-module')); ?>/img/media/create-ads.png"
                                         alt="">
                                    <h4><?php echo e(translate('Advertisement List')); ?></h4>
                                    <p><?php echo e(translate("Uh oh! there is not advertisement created by provider!")); ?></p>
                                </div>
                                <hr class="my-4">
                                <div class="row justify-content-center rounded mb-5">
                                    <div class="col-xl-6 col-lg-7 col-md-8 col-sm-9">
                                        <div
                                            class="bg-light d-flex flex-column gap-2 align-items-center text-center py-4 px-4 px-xl-5">
                                            <h4 class="mb-2"><?php echo e(translate('Create Advertisement to Promote Provider’s Services')); ?></h4>
                                            <p><?php echo e(translate('Here, Provider can showcase their services or profile to a wider audience through targeted ad campaigns. You can create ad on behalf of a provider.')); ?></p>
                                            <a class="text-white btn btn--primary"
                                               href="<?php echo e(route('admin.advertisements.ads-create')); ?>"><?php echo e(translate('Create Ads')); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div
                            class="d-flex flex-wrap justify-content-between align-items-center border-bottom mx-lg-4 mb-10 gap-3">
                            <ul class="nav nav--tabs">
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e($queryParams['status'] == 'all' ? 'active' : ''); ?>"
                                       href="<?php echo e(route('admin.advertisements.ads-list', ['status' => 'all'])); ?>">
                                        <?php echo e(translate('All')); ?>

                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link <?php echo e($queryParams['status'] == 'approved' ? 'active' : ''); ?>"
                                       href="<?php echo e(route('admin.advertisements.ads-list', ['status' => 'approved'])); ?>">
                                        <?php echo e(translate('Approved')); ?>

                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e($queryParams['status'] == 'running' ? 'active' : ''); ?>"
                                       href="<?php echo e(route('admin.advertisements.ads-list', ['status' => 'running'])); ?>">
                                        <?php echo e(translate('Running')); ?>

                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e($queryParams['status'] == 'expired' ? 'active' : ''); ?>"
                                       href="<?php echo e(route('admin.advertisements.ads-list', ['status' => 'expired'])); ?>">
                                        <?php echo e(translate('Expired')); ?>

                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e($queryParams['status'] == 'denied' ? 'active' : ''); ?>"
                                       href="<?php echo e(route('admin.advertisements.ads-list', ['status' => 'denied'])); ?>">
                                        <?php echo e(translate('Denied')); ?>

                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e($queryParams['status'] == 'paused' ? 'active' : ''); ?>"
                                       href="<?php echo e(route('admin.advertisements.ads-list', ['status' => 'paused'])); ?>">
                                        <?php echo e(translate('Paused')); ?>

                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between">

                                    <form
                                        action="<?php echo e(route('admin.advertisements.ads-list', ['status' => $queryParams['status']])); ?>"
                                        class="search-form search-form_style-two"
                                        method="get">
                                        <?php echo csrf_field(); ?>
                                        <div class="input-group search-form__input_group">
                                            <span class="search-form__icon">
                                                <span class="material-icons">search</span>
                                            </span>
                                            <input type="search" class="theme-input-style search-form__input"
                                                   value="<?php echo e($queryParams['search']); ?>" name="search"
                                                   placeholder="<?php echo e(translate('search_here')); ?>">
                                            <input type="hidden"
                                                   value="<?php echo e($queryParams['status']); ?>" name="status"
                                                   placeholder="<?php echo e(translate('search_here')); ?>">
                                        </div>
                                        <button type="submit"
                                                class="btn btn--primary"><?php echo e(translate('search')); ?></button>
                                    </form>

                                    <div class="d-flex flex-wrap align-items-center gap-3">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advertisement_add')): ?>
                                            <div
                                                class="page-title-wrap d-flex justify-content-between flex-wrap align-items-center gap-3">
                                                <a href="<?php echo e(route('admin.advertisements.ads-create')); ?>"
                                                   class="btn btn--primary"><?php echo e(translate('create_ads')); ?></a>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advertisement_export')): ?>
                                            <div class="dropdown">
                                                <button type="button"
                                                        class="btn btn--secondary text-capitalize dropdown-toggle"
                                                        data-bs-toggle="dropdown">
                                                <span
                                                    class="material-icons">file_download</span> <?php echo e(translate('download')); ?>

                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                                    <li><a class="dropdown-item"
                                                           href="<?php echo e(route('admin.advertisements.download', ['status' => $queryParams['status'], 'search' => $queryParams['search']])); ?>"><?php echo e(translate('excel')); ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="example" class="table align-middle">
                                        <thead class="text-nowrap">
                                        <tr>
                                            <th><?php echo e(translate('SL')); ?></th>
                                            <th><?php echo e(translate('Title')); ?></th>
                                            <th><?php echo e(translate('Advertisement ID')); ?></th>
                                            <th><?php echo e(translate('Provider Info')); ?></th>
                                            <th><?php echo e(translate('Ads Type')); ?></th>
                                            <th><?php echo e(translate('Duration')); ?></th>
                                            <?php if($queryParams['status'] == 'all' || $queryParams['status'] == 'expired'): ?>
                                                <th class="text-center"><?php echo e(translate('Status')); ?></th>
                                            <?php endif; ?>
                                            <th class="text-center"><?php echo e(translate('Priority')); ?></th>
                                            <th class="text-center"><?php echo e(translate('Action')); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $advertisements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $advertisement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td><?php echo e($advertisements->firstitem()+$key); ?></td>
                                                <td>
                                                    <a href="<?php echo e(route('admin.advertisements.details',[$advertisement->id])); ?>"><?php echo e(Str::limit($advertisement->title, 40)); ?></a>
                                                </td>
                                                <td>
                                                    <a href="<?php echo e(route('admin.advertisements.details',[$advertisement->id])); ?>"><?php echo e($advertisement->readable_id); ?></a>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column gap-1">
                                                        <span><?php echo e($advertisement?->provider?->company_name); ?></span>
                                                        <a href="mailto:<?php echo e($advertisement?->provider?->company_email); ?>"
                                                           class="fs-12"><?php echo e($advertisement?->provider?->company_email); ?></a>
                                                    </div>
                                                </td>
                                                <td><?php echo e(ucwords(str_replace('_', ' ', $advertisement->type))); ?></td>
                                                <td>
                                                    <div class="d-flex flex-column gap-1 fs-12">
                                                        <span><?php echo e($advertisement->start_date->format('Y-m-d')); ?></span>
                                                        <span><?php echo e($advertisement->end_date->format('Y-m-d')); ?></span>
                                                    </div>
                                                </td>
                                                <?php if($queryParams['status'] == 'all' || $queryParams['status'] == 'expired'): ?>
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <?php if($advertisement->status == 'pending'): ?>
                                                                <label class="badge badge-info"><?php echo e($advertisement->status); ?></label>
                                                            <?php elseif(($advertisement->status == 'approved' || $advertisement->status == 'resumed') && ($advertisement->start_date <= \Carbon\Carbon::today() && $advertisement->end_date >= \Carbon\Carbon::today() ) ): ?>
                                                                <label class="badge badge-primary"><?php echo e(translate('Running')); ?>

                                                            <?php elseif($advertisement->status == 'approved'): ?>
                                                                 <label class="badge badge-success"><?php echo e(translate('Approved')); ?>

                                                            <?php elseif($advertisement->status == 'paused'): ?>
                                                                 <label class="badge badge-success"><?php echo e(translate('Paused')); ?></label>
                                                            <?php elseif($advertisement->status == 'resumed'): ?>
                                                                <label class="badge badge-success"><?php echo e(translate('Resumed')); ?></label>
                                                            <?php elseif($advertisement->status == 'running'): ?>
                                                                <label class="badge badge-primary"><?php echo e(translate('running')); ?></label>
                                                            <?php elseif($advertisement->status == 'expired'): ?>
                                                                <label class="badge badge-secondary"><?php echo e(translate('Expired')); ?></label>
                                                            <?php elseif($advertisement->status == 'denied'): ?>
                                                                 <label class="badge badge-danger"><?php echo e(translate('Denied')); ?></label>
                                                            <?php elseif($advertisement->status == 'canceled'): ?>
                                                                  <label class="badge badge-danger"><?php echo e(translate('canceled')); ?></label>
                                                            <?php endif; ?>
                                                             <?php
                                                                 $end_date = \Carbon\Carbon::parse($advertisement->end_date)->startOfDay();
                                                                 $today = \Carbon\Carbon::today();
                                                             ?>
                                                             <?php if($end_date < $today): ?>
                                                                 <div class="text-center">
                                                                     <small class="text-muted text-center">(<?php echo e(translate('Expired')); ?>)</small>
                                                                 </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                <?php endif; ?>
                                                <td>
                                                    <div class="d-flex justify-content-center set-priority"
                                                         data-id="<?php echo e($advertisement->id); ?>"
                                                         data-action="<?php echo e(route('admin.advertisements.set-priority', [$advertisement->id])); ?>"
                                                         data-bs-toggle="modal" data-bs-target="#setPriorityModal">
                                                        <?php if($advertisement->priority == null): ?>
                                                            <div class="text-muted d-flex gap-1 align-items-center">
                                                                <span class="lh-1 mt-1">N/A</span>
                                                                <span data-bs-toggle="tooltip"
                                                                      title="Priority isn't set yet!">
                                                                <img
                                                                    src="<?php echo e(asset('public/assets/admin-module')); ?>/img/icons/info-hexa.svg"
                                                                    alt="">
                                                            </span>
                                                            </div>
                                                        <?php endif; ?>
                                                        <span><?php echo e($advertisement->priority); ?></span>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center">
                                                        <div class="dropdown dropdown__style--two">
                                                            <button type="button" class="bg-transparent border-0"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                <span class="material-symbols-outlined">more_vert</span>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advertisement_view')): ?>
                                                                    <a class="dropdown-item d-flex gap-2 align-items-center"
                                                                       href="<?php echo e(route('admin.advertisements.details',[$advertisement->id])); ?>">
                                                                <span
                                                                    class="material-symbols-outlined">visibility</span>
                                                                        <?php echo e(translate('View Ads')); ?>

                                                                    </a>
                                                                <?php endif; ?>
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advertisement_update')): ?>
                                                                    <a class="dropdown-item d-flex gap-2 align-items-center"
                                                                       href="<?php echo e(route('admin.advertisements.edit',[$advertisement->id])); ?>">
                                                                        <span
                                                                            class="material-symbols-outlined">edit</span>
                                                                        <?php echo e(translate('Edit Ads')); ?>

                                                                    </a>
                                                                <?php endif; ?>
                                                                <?php if($advertisement->status == 'pending'): ?>
                                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advertisement_approve_or_deny')): ?>
                                                                        <a class="dropdown-item d-flex gap-2 align-items-center"
                                                                           href="<?php echo e(route('admin.advertisements.status-update',[$advertisement->id, 'approved'])); ?>">
                                                                        <span
                                                                            class="material-symbols-outlined">done</span>
                                                                            <?php echo e(translate('Approve Ads')); ?>

                                                                        </a>

                                                                        <a class="dropdown-item d-flex gap-2 align-items-center"
                                                                           href="#" data-bs-toggle="modal"
                                                                           data-bs-target="#deniedModal-<?php echo e($advertisement->id); ?>">
                                                                        <span
                                                                            class="material-symbols-outlined">close</span>
                                                                            <?php echo e(translate('Deny Ads')); ?>

                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                                <?php if((!in_array($advertisement->status, ['pending', 'paused', 'denied', 'canceled']) || !$advertisement->where('end_date', '<', Carbon\Carbon::today()))): ?>
                                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advertisement_manage_status')): ?>
                                                                        <a class="dropdown-item d-flex gap-2 align-items-center set-priority"
                                                                           data-id="<?php echo e($advertisement->id); ?>"
                                                                           data-action="<?php echo e(route('admin.advertisements.set-priority', [$advertisement->id])); ?>"
                                                                           data-bs-toggle="modal"
                                                                           data-bs-target="#setPriorityModal">
                                                                            <span class="material-symbols-outlined">format_list_bulleted</span>
                                                                            <?php echo e(translate('Set Priority')); ?>

                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                                <?php if($advertisement->whereIn('status', ['approved', 'resumed'])->where('start_date', '<=', Carbon\Carbon::today())->where('end_date', '>', Carbon\Carbon::today()) && in_array($advertisement->status, ['approved', 'resumed'])): ?>
                                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advertisement_manage_status')): ?>
                                                                        <a class="dropdown-item d-flex gap-2 align-items-center"
                                                                           href="#" data-bs-toggle="modal"
                                                                           data-bs-target="#pausedModal-<?php echo e($advertisement->id); ?>">
                                                                    <span
                                                                        class="material-symbols-outlined">pause_circle</span>
                                                                            <?php echo e(translate('Pause Ads')); ?>

                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                                <?php if($advertisement->status == 'paused'): ?>
                                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advertisement_manage_status')): ?>
                                                                        <a class="dropdown-item d-flex gap-2 align-items-center"
                                                                           href="#" data-bs-toggle="modal"
                                                                           data-bs-target="#resumeModal-<?php echo e($advertisement->id); ?>">
                                                                    <span
                                                                        class="material-symbols-outlined">play_arrow</span>
                                                                            <?php echo e(translate('Resume Ads')); ?>

                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                                <?php if((($advertisement->where('end_date', '<', Carbon\Carbon::today()) || $advertisement->status == 'denied')) && ($advertisement->status != 'approved' &&  !$advertisement->whereIn('status', ['approved', 'resumed'])->where('start_date', '<=', Carbon\Carbon::today())->where('end_date', '>', Carbon\Carbon::today()))): ?>
                                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advertisement_update')): ?>
                                                                        <a class="dropdown-item d-flex gap-2 align-items-center"
                                                                           href="<?php echo e(route('admin.advertisements.re-submit',[$advertisement->id])); ?>">
                                                                    <span
                                                                        class="material-symbols-outlined">history</span>
                                                                            <?php echo e(translate('Re-submit Ads')); ?>

                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>

                                                                <?php if(($advertisement->status == 'denied')): ?>
                                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advertisement_update')): ?>
                                                                        <a class="dropdown-item d-flex gap-2 align-items-center"
                                                                           href="<?php echo e(route('admin.advertisements.re-submit',[$advertisement->id])); ?>">
                                                                <span
                                                                    class="material-symbols-outlined">history</span>
                                                                            <?php echo e(translate('Re-submit Ads')); ?>

                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>

                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advertisement_delete')): ?>
                                                                        <?php if(($advertisement->status == 'approved' || $advertisement->status == 'resumed') && ($advertisement->start_date <= \Carbon\Carbon::today() && $advertisement->end_date > \Carbon\Carbon::today() )): ?>
                                                                        <a class="dropdown-item d-flex gap-2 align-items-center"
                                                                           data-bs-toggle="modal"
                                                                           data-bs-target="#adDeleteModal-<?php echo e($advertisement->id); ?>">
                                                                    <span
                                                                        class="material-symbols-outlined">delete</span>
                                                                            <?php echo e(translate('Delete Ads')); ?>

                                                                        </a>
                                                                    <?php else: ?>
                                                                        <a class="dropdown-item d-flex gap-2 align-items-center delete_section"
                                                                           href="#" data-id="<?php echo e($advertisement->id); ?>">
                                                                    <span
                                                                        class="material-symbols-outlined">delete</span>
                                                                            <?php echo e(translate('Delete Ads')); ?>

                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                                <form
                                                                    action="<?php echo e(route('admin.advertisements.delete',[$advertisement->id])); ?>"
                                                                    method="post" id="delete-<?php echo e($advertisement->id); ?>"
                                                                    class="hidden">
                                                                    <?php echo csrf_field(); ?>
                                                                    <?php echo method_field('DELETE'); ?>
                                                                </form>
                                                            </ul>
                                                        </div>

                                                        <div class="modal fade" id="deniedModal-<?php echo e($advertisement->id); ?>"
                                                             tabindex="-1"
                                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-body pt-5 p-md-5">
                                                                        <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        <div class="d-flex justify-content-center mb-4">
                                                                            <img width="75" height="75"
                                                                                 src="<?php echo e(asset('public/assets/admin-module/img/delete2.png')); ?>"
                                                                                 class="rounded-circle" alt="">
                                                                        </div>

                                                                        <h3 class="text-start mb-1 fw-medium text-center"><?php echo e(translate('Are you sure you want to deny the request?')); ?></h3>
                                                                        <p class="text-start fs-12 fw-medium text-muted text-center"><?php echo e(translate('You will lost the provider ads request')); ?></p>
                                                                        <form method="post"
                                                                              action="<?php echo e(route('admin.advertisements.status-update',[$advertisement->id, 'denied'])); ?>">
                                                                            <?php echo csrf_field(); ?>
                                                                            <div class="form-floating">
                                                                            <textarea class="form-control h-69px"
                                                                                      placeholder="<?php echo e(translate('Denied Note')); ?>"
                                                                                      name="note" id="add-your-note"
                                                                                      required></textarea>
                                                                                <label for="add-your-note"
                                                                                       class="d-flex align-items-center gap-1"><?php echo e(translate('Deny Note')); ?></label>
                                                                                <div
                                                                                    class="d-flex justify-content-center mt-3 gap-3">
                                                                                    <button type="button"
                                                                                            class="btn btn--secondary min-w-92px px-2"
                                                                                            data-bs-dismiss="modal"
                                                                                            aria-label="Close"><?php echo e(translate('Not Now')); ?></button>
                                                                                    <button type="submit"
                                                                                            class="btn btn--danger min-w-92px"><?php echo e(translate('Yes')); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        
                                                        <div class="modal fade"
                                                             id="adDeleteModal-<?php echo e($advertisement->id); ?>"
                                                             tabindex="-1"
                                                             aria-labelledby="adDeleteModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-body pt-5 p-md-5">
                                                                        <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        <div class="d-flex justify-content-center mb-4">
                                                                            <img width="75" height="75"
                                                                                 src="<?php echo e(asset('public/assets/admin-module/img/ad_delete.svg')); ?>"
                                                                                 class="rounded-circle" alt="">
                                                                        </div>

                                                                        <h3 class="text-start mb-1 fw-medium text-center"><?php echo e(translate('You can’t delete the ad')); ?></h3>
                                                                        <p class="text-start fs-12 fw-medium text-muted text-center"><?php echo e(translate('This ad is running, To delete this ad from the list, please change its status first. Once the status is updated, you can proceed with deletion')); ?></p>
                                                                        <div
                                                                            class="d-flex justify-content-center mt-3 gap-3">
                                                                            <button type="button"
                                                                                    class="btn btn--danger min-w-92px px-2"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close"><?php echo e(translate('Okay')); ?></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="modal fade" id="pausedModal-<?php echo e($advertisement->id); ?>"
                                                             tabindex="-1"
                                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-body pt-5 p-md-5">
                                                                        <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        <div class="d-flex justify-content-center mb-4">
                                                                            <img width="75" height="75"
                                                                                 src="<?php echo e(asset('public/assets/admin-module/img/paused.png')); ?>"
                                                                                 class="rounded-circle" alt="">
                                                                        </div>

                                                                        <h3 class="text-start mb-1 fw-medium text-center"><?php echo e(translate('Are you sure you want to Pause the request??')); ?></h3>
                                                                        <p class="text-start fs-12 fw-medium text-muted text-center"><?php echo e(translate('This ad will be pause and not show in the app or web')); ?></p>
                                                                        <form method="post"
                                                                              action="<?php echo e(route('admin.advertisements.status-update',[$advertisement->id, 'paused'])); ?>">
                                                                            <?php echo csrf_field(); ?>
                                                                            <div class="form-floating">
                                                                            <textarea class="form-control h-69px"
                                                                                      placeholder="<?php echo e(translate('Paused Note')); ?>"
                                                                                      name="note" id="add-paused-note"
                                                                                      required></textarea>
                                                                                <label for="add-your-note"
                                                                                       class="d-flex align-items-center gap-1"><?php echo e(translate('Paused Note')); ?></label>
                                                                                <div
                                                                                    class="d-flex justify-content-center mt-3 gap-3">
                                                                                    <button type="button"
                                                                                            class="btn btn--secondary min-w-92px px-2"
                                                                                            data-bs-dismiss="modal"
                                                                                            aria-label="Close"><?php echo e(translate('Not Now')); ?></button>
                                                                                    <button type="submit"
                                                                                            class="btn btn--danger min-w-92px"><?php echo e(translate('Yes')); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal fade" id="resumeModal-<?php echo e($advertisement->id); ?>"
                                                             tabindex="-1"
                                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-body pt-5 p-md-5">
                                                                        <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        <div class="d-flex justify-content-center mb-4">
                                                                            <img width="75" height="75"
                                                                                 src="<?php echo e(asset('public/assets/admin-module/img/resume.svg')); ?>"
                                                                                 class="rounded-circle" alt="">
                                                                        </div>

                                                                        <h3 class="text-start mb-1 fw-medium text-center"><?php echo e(translate('Are you sure you want to Resume the request???')); ?></h3>
                                                                        <p class="text-start fs-12 fw-medium text-muted text-center"><?php echo e(translate('This ad will be run again and will show in the app or web')); ?></p>
                                                                        <form method="post"
                                                                              action="<?php echo e(route('admin.advertisements.status-update',[$advertisement->id, 'resumed'])); ?>">
                                                                            <?php echo csrf_field(); ?>
                                                                            <div class="form-floating">
                                                                                <div
                                                                                    class="d-flex justify-content-center mt-3 gap-3">
                                                                                    <button type="button"
                                                                                            class="btn btn--secondary min-w-92px px-2"
                                                                                            data-bs-dismiss="modal"
                                                                                            aria-label="Close"><?php echo e(translate('Not Now')); ?></button>
                                                                                    <button type="submit"
                                                                                            class="btn btn--primary min-w-92px"><?php echo e(translate('Yes')); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr class="text-center">
                                                <td colspan="8"><?php echo e(translate('No_data_available')); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <?php echo $advertisements->links(); ?>

                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="modal fade" id="setPriorityModal" tabindex="-1" aria-labelledby="setPriorityModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 pb-sm-5">
                        <h4 class="mb-2"><?php echo e(translate('Set Priority')); ?></h4>
                        <p><?php echo e(translate('Customize Ad Placement for Enhanced Visibility')); ?></p>
                        <form>
                            <?php echo csrf_field(); ?>
                            <div class="mb-30">
                                <label for="priority" class="form-label"><?php echo e(translate('Priority')); ?></label>
                                <select class="form-select" name="priority" id="priority" aria-label="priority setup">
                                    <?php for($i=1; $i<=\Modules\PromotionManagement\Entities\Advertisement::where('priority', '!=', null)->count()+1; $i++): ?>
                                        <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <div class="d-flex">
                                <button type="submit"
                                        class="btn btn--primary flex-grow-1"><?php echo e(translate('Set')); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        "use strict";

        $('.delete_section').on('click', function () {
            let itemId = $(this).data('id');
            form_alert('delete-' + itemId, '<?php echo e(translate('want_to_delete_this')); ?>?');
        })

        $('.set-priority').on('click', function () {
            const editModal = $('#setPriorityModal');
            editModal.find('input[name=priority]').val($(this).data('priority'));
            editModal.find('form').attr('action', $(this).data('action'));
        })

        $(document).ready(function () {
            let alert = $('.alert--message-2');

            setTimeout(function () {
                alert.removeClass('show active').addClass('fade');
            }, 5000);

            alert.find('.btn-close').on('click', function () {
                alert.removeClass('show active').addClass('fade');
            });
        });

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/PromotionManagement/Resources/views/admin/advertisements/ads-list.blade.php ENDPATH**/ ?>