<?php $__env->startSection('title',translate('withdraw_request_list')); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-wrap d-flex justify-content-between flex-wrap align-items-center gap-3 mb-3">
                        <h2 class="page-title"><?php echo e(translate('withdraw_request_list')); ?></h2>
                    </div>

                    <div
                        class="d-flex flex-wrap justify-content-between align-items-center border-bottom mx-lg-4 mb-10 gap-3">
                        <ul class="nav nav--tabs">
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($status=='all'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?status=all">
                                    <?php echo e(translate('All')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($status=='pending'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?status=pending">
                                    <?php echo e(translate('Pending')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($status=='approved'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?status=approved">
                                    <?php echo e(translate('Approved')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($status=='denied'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?status=denied">
                                    <?php echo e(translate('Denied')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($status=='settled'?'active':''); ?>"
                                   href="<?php echo e(url()->current()); ?>?status=settled">
                                    <?php echo e(translate('Settled')); ?>

                                </a>
                            </li>
                        </ul>

                        <div class="d-flex gap-2 fw-medium">
                            <span class="opacity-75"><?php echo e(translate('total_withdraw')); ?>:</span>
                            <span class="title-color"><?php echo e($withdrawRequests->total()); ?></span>
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
                                                       placeholder="<?php echo e(translate('Search by provider')); ?>">
                                            </div>
                                            <button type="submit"
                                                    class="btn btn--primary"><?php echo e(translate('search')); ?></button>
                                        </form>

                                        <div class="d-flex flex-wrap align-items-center gap-3">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('withdraw_update')): ?>
                                                <button type="button" class="btn btn--success" data-bs-toggle="modal"
                                                        data-bs-target="#uploadFileModal"><?php echo e(translate('Bulk_Status_Update')); ?></button>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('withdraw_export')): ?>
                                                <div class="dropdown">
                                                    <button type="button"
                                                            class="btn btn--secondary text-capitalize dropdown-toggle"
                                                            data-bs-toggle="dropdown">
                                                    <span
                                                        class="material-icons">file_download</span> <?php echo e(translate('download')); ?>

                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                                        <li>
                                                            <a class="dropdown-item"
                                                               href="<?php echo e(route('admin.withdraw.request.download', ['status'=>$status])); ?>">
                                                                <?php echo e(translate('excel')); ?>

                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="select-table-wrap">
                                        <div
                                            class="multiple-select-actions gap-3 flex-wrap align-items-center justify-content-between">
                                            <div class="d-flex align-items-center flex-wrap gap-2 gap-lg-4">
                                                <div class="ms-sm-1">
                                                    <input type="checkbox" class="multi-checker">
                                                </div>
                                                <p><span class="checked-count">2</span> <?php echo e(translate('Item_Selected')); ?>

                                                </p>
                                            </div>

                                            <div class="d-flex align-items-center flex-wrap gap-3">
                                                <select class="js-select theme-input-style w-100"
                                                        id="multi-status__select" required>
                                                    <option selected disabled><?php echo e(translate('Update_status')); ?></option>
                                                    <option value="denied"><?php echo e(translate('Deny')); ?></option>
                                                    <option value="approved"><?php echo e(translate('Approve')); ?></option>
                                                    <option value="settled"><?php echo e(translate('Settle')); ?></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="table-responsive position-relative">
                                            <table id="example" class="table align-middle multi-select-table">
                                                <thead class="text-nowrap">
                                                <tr>
                                                    <th></th>
                                                    <th><?php echo e(translate('SL')); ?></th>
                                                    <th><?php echo e(translate('Provider')); ?></th>
                                                    <th><?php echo e(translate('Amount')); ?></th>
                                                    <th><?php echo e(translate('Provider_Note')); ?></th>
                                                    <th><?php echo e(translate('Admin_Note')); ?></th>
                                                    <th><?php echo e(translate('Request_Time')); ?></th>
                                                    <th class="text-center"><?php echo e(translate('Status')); ?></th>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('withdraw_manage_status')): ?>
                                                        <th class="text-center"><?php echo e(translate('Action')); ?></th>
                                                    <?php endif; ?>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $__currentLoopData = $withdrawRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$withdrawRequest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><input type="checkbox" class="multi-check"
                                                                   value="<?php echo e($withdrawRequest->id); ?>"></td>
                                                        <td><?php echo e($withdrawRequests->firstitem()+$key); ?></td>
                                                        <td class="text-capitalize">
                                                            <?php if($withdrawRequest?->user?->provider): ?>
                                                                <a href="<?php echo e(route('admin.provider.details',[$withdrawRequest->user->provider->id, 'web_page'=>'overview'])); ?>">
                                                                    <?php echo e(Str::limit($withdrawRequest->user->provider->company_name, 30)); ?>

                                                                </a>
                                                            <?php else: ?>
                                                                <?php echo e(translate('Not_available')); ?>

                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?php echo e(with_currency_symbol($withdrawRequest->amount)); ?></td>
                                                        <td>
                                                            <div class="max-w320 min-w120 text-two-line"
                                                                 data-bs-toggle="tooltip" data-bs-placement="top"
                                                                 <?php if($withdrawRequest->note): ?>
                                                                     data-bs-title="<?php echo e($withdrawRequest->note); ?>"
                                                                <?php endif; ?>>
                                                                <?php if($withdrawRequest->note): ?>
                                                                    <?php echo e(Str::limit($withdrawRequest->note, 100)); ?>

                                                                <?php else: ?>
                                                                    <span
                                                                        class="badge badge-primary"><?php echo e(translate('Not provided yet')); ?></span>
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="max-w320 min-w120 text-two-line"
                                                                 data-bs-toggle="tooltip" data-bs-placement="top"
                                                                 <?php if($withdrawRequest->admin_note): ?>
                                                                     data-bs-title="<?php echo e($withdrawRequest->admin_note); ?>"
                                                                <?php endif; ?>>
                                                                <?php if($withdrawRequest->admin_note): ?>
                                                                    <?php echo e(Str::limit($withdrawRequest->admin_note, 100)); ?>

                                                                <?php else: ?>
                                                                    <span
                                                                        class="badge badge-primary"><?php echo e(translate('Not provided yet')); ?></span>
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <div><?php echo e(date('d-M-y', strtotime($withdrawRequest->created_at))); ?></div>
                                                                <div><?php echo e(date('H:iA', strtotime($withdrawRequest->created_at))); ?></div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php if($withdrawRequest->request_status == 'pending'): ?>
                                                                <label
                                                                    class="badge badge-info"><?php echo e(translate('pending')); ?></label>
                                                            <?php elseif($withdrawRequest->request_status == 'approved'): ?>
                                                                <label
                                                                    class="badge badge-success"><?php echo e(translate('approved')); ?></label>
                                                            <?php elseif($withdrawRequest->request_status == 'settled'): ?>
                                                                <label
                                                                    class="badge badge-success"><?php echo e(translate('Settled')); ?></label>
                                                            <?php elseif($withdrawRequest->request_status == 'denied'): ?>
                                                                <label
                                                                    class="badge badge-danger"><?php echo e(translate('denied')); ?></label>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-2 justify-content-center">
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('withdraw_manage_status')): ?>
                                                                    <?php if($withdrawRequest->request_status=='pending'): ?>
                                                                        <button type="button"
                                                                                class="action-btn btn--danger"
                                                                                style="--size: 30px"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#denyModal-<?php echo e($withdrawRequest->id); ?>">
                                                                            <span
                                                                                class="material-icons m-0">close</span>
                                                                        </button>

                                                                        <div class="modal fade"
                                                                             id="denyModal-<?php echo e($withdrawRequest->id); ?>"
                                                                             tabindex="-1"
                                                                             aria-labelledby="exampleModalLabel"
                                                                             aria-hidden="true">
                                                                            <div class="modal-dialog modal-lg">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-body">
                                                                                        <form
                                                                                            action="<?php echo e(route('admin.withdraw.request.update_status',[$withdrawRequest->id, 'status'=>'denied'])); ?>"
                                                                                            method="POST">
                                                                                            <?php echo csrf_field(); ?>
                                                                                            <button type="button"
                                                                                                    class="btn-close"
                                                                                                    data-bs-dismiss="modal"
                                                                                                    aria-label="Close"></button>
                                                                                            <div class="text-center">
                                                                                                <img width="75"
                                                                                                     class="my-3"
                                                                                                     src="<?php echo e(asset('public/assets/admin-module/img/media/deny.png')); ?>"
                                                                                                     alt="<?php echo e(translate('deny')); ?>">
                                                                                                <h3 class="mb-3"><?php echo e(translate('Deny_this_request')); ?>

                                                                                                    ?</h3>
                                                                                            </div>

                                                                                            <div
                                                                                                class="py-3 d-flex flex-wrap flex-md-nowrap gap-3 mb-2">
                                                                                                <div
                                                                                                    class="c1-light-bg radius-10 py-3 px-4 flex-grow-1">
                                                                                                    <h4 class="mb-2"><?php echo e(translate('Provider_Information')); ?></h4>
                                                                                                    <?php if($withdrawRequest->provider): ?>
                                                                                                        <h5 class="c1 mb-2"><?php echo e($withdrawRequest->provider->company_name); ?></h5>
                                                                                                        <ul class="list-info">
                                                                                                            <li>
                                                                                                            <span
                                                                                                                class="material-icons">phone_iphone</span>
                                                                                                                <a href="tel:<?php echo e($withdrawRequest->provider->company_phone); ?>"><?php echo e($withdrawRequest->provider->company_phone); ?></a>
                                                                                                            </li>
                                                                                                            <li>
                                                                                                            <span
                                                                                                                class="material-icons">map</span>
                                                                                                                <p><?php echo e($withdrawRequest->provider->company_address); ?></p>
                                                                                                            </li>
                                                                                                        </ul>
                                                                                                    <?php endif; ?>
                                                                                                </div>

                                                                                                <div
                                                                                                    class="c1-light-bg radius-10 py-3 px-4 flex-grow-1">
                                                                                                    <h4 class="mb-2"><?php echo e(translate('Withdraw_Method_Information')); ?></h4>
                                                                                                    <ul class="list-info gap-1">
                                                                                                        <?php $__empty_1 = true; $__currentLoopData = $withdrawRequest->withdrawal_method_fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                                                            <li>
                                                                                                            <span
                                                                                                                class="font-weight-bold"><b><?php echo e(translate($key)); ?></b>: </span>
                                                                                                                <span><?php echo e($value); ?></span>
                                                                                                            </li>
                                                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                                                            <li>
                                                                                                                <span><?php echo e(translate('Information_unavailable')); ?></span>
                                                                                                            </li>
                                                                                                        <?php endif; ?>
                                                                                                    </ul>
                                                                                                </div>
                                                                                            </div>

                                                                                            <textarea
                                                                                                class="form-control h-140 resize-none"
                                                                                                placeholder="<?php echo e(translate('Note')); ?>"
                                                                                                name="note"></textarea>

                                                                                            <div
                                                                                                class="mb-3 mt-4 d-flex justify-content-center gap-3">
                                                                                                <button type="button"
                                                                                                        class="btn btn--secondary"
                                                                                                        data-bs-dismiss="modal"><?php echo e(translate('Cancel')); ?></button>
                                                                                                <button type="submit"
                                                                                                        class="btn btn--primary"><?php echo e(translate('Yes')); ?></button>
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <button type="button"
                                                                                class="action-btn btn--success"
                                                                                style="--size: 30px"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#approveModal-<?php echo e($withdrawRequest->id); ?>">
                                                                            <span
                                                                                class="material-icons">done_outline</span>
                                                                        </button>
                                                                        <div class="modal fade"
                                                                             id="approveModal-<?php echo e($withdrawRequest->id); ?>"
                                                                             tabindex="-1"
                                                                             aria-labelledby="exampleModalLabel"
                                                                             aria-hidden="true">
                                                                            <div class="modal-dialog modal-lg">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-body">
                                                                                        <form
                                                                                            action="<?php echo e(route('admin.withdraw.request.update_status',[$withdrawRequest->id, 'status'=>'approved'])); ?>"
                                                                                            method="POST">
                                                                                            <?php echo csrf_field(); ?>
                                                                                            <button type="button"
                                                                                                    class="btn-close"
                                                                                                    data-bs-dismiss="modal"
                                                                                                    aria-label="Close"></button>
                                                                                            <div class="text-center">
                                                                                                <img width="75"
                                                                                                     class="my-3"
                                                                                                     src="<?php echo e(asset('public/assets/admin-module/img/media/accept.png')); ?>"
                                                                                                     alt="<?php echo e(translate('accept')); ?>">
                                                                                                <h3 class="mb-3"><?php echo e(translate('Accept_this_request')); ?>

                                                                                                    ?</h3>
                                                                                            </div>

                                                                                            <div
                                                                                                class="py-3 d-flex flex-wrap flex-md-nowrap gap-3 mb-2">
                                                                                                <div
                                                                                                    class="c1-light-bg radius-10 py-3 px-4 flex-grow-1">
                                                                                                    <h4 class="mb-2"><?php echo e(translate('Provider_Information')); ?></h4>
                                                                                                    <?php if($withdrawRequest->provider): ?>
                                                                                                        <h5 class="c1 mb-2"><?php echo e($withdrawRequest->provider->company_name); ?></h5>
                                                                                                        <ul class="list-info">
                                                                                                            <li>
                                                                                                            <span
                                                                                                                class="material-icons">phone_iphone</span>
                                                                                                                <a href="tel:<?php echo e($withdrawRequest->provider->company_phone); ?>"><?php echo e($withdrawRequest->provider->company_phone); ?></a>
                                                                                                            </li>
                                                                                                            <li>
                                                                                                            <span
                                                                                                                class="material-icons">map</span>
                                                                                                                <p><?php echo e($withdrawRequest->provider->company_address); ?></p>
                                                                                                            </li>
                                                                                                        </ul>
                                                                                                    <?php endif; ?>
                                                                                                </div>

                                                                                                <div
                                                                                                    class="c1-light-bg radius-10 py-3 px-4 flex-grow-1">
                                                                                                    <h4 class="mb-2"><?php echo e(translate('Withdraw_Method_Information')); ?></h4>
                                                                                                    <ul class="list-info gap-1">
                                                                                                        <?php $__empty_1 = true; $__currentLoopData = $withdrawRequest->withdrawal_method_fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                                                            <li>
                                                                                                            <span
                                                                                                                class="font-weight-bold"><b><?php echo e(translate($key)); ?></b>: </span>
                                                                                                                <span><?php echo e($value); ?></span>
                                                                                                            </li>
                                                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                                                            <li>
                                                                                                                <span><?php echo e(translate('Information_unavailable')); ?></span>
                                                                                                            </li>
                                                                                                        <?php endif; ?>
                                                                                                    </ul>
                                                                                                </div>
                                                                                            </div>

                                                                                            <textarea
                                                                                                class="form-control h-140 resize-none"
                                                                                                placeholder="<?php echo e(translate('Note')); ?>"
                                                                                                name="note"></textarea>

                                                                                            <div
                                                                                                class="mb-3 mt-4 d-flex justify-content-center gap-3">
                                                                                                <button type="button"
                                                                                                        class="btn btn--secondary"
                                                                                                        data-bs-dismiss="modal"><?php echo e(translate('Cancel')); ?></button>
                                                                                                <button type="submit"
                                                                                                        class="btn btn--primary"><?php echo e(translate('Yes')); ?></button>
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    <?php elseif($withdrawRequest->request_status=='approved'): ?>
                                                                        <button type="button" class="btn btn--success"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#approveModal-<?php echo e($withdrawRequest->id); ?>">
                                                                            <?php echo e(translate('Settle')); ?>

                                                                        </button>
                                                                        <div class="modal fade"
                                                                             id="approveModal-<?php echo e($withdrawRequest->id); ?>"
                                                                             tabindex="-1"
                                                                             aria-labelledby="exampleModalLabel"
                                                                             aria-hidden="true">
                                                                            <div class="modal-dialog modal-lg">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-body">
                                                                                        <form
                                                                                            action="<?php echo e(route('admin.withdraw.request.update_status',[$withdrawRequest->id, 'status'=>'settled'])); ?>"
                                                                                            method="POST">
                                                                                            <?php echo csrf_field(); ?>
                                                                                            <button type="button"
                                                                                                    class="btn-close"
                                                                                                    data-bs-dismiss="modal"
                                                                                                    aria-label="Close"></button>
                                                                                            <div class="text-center">
                                                                                                <img width="75"
                                                                                                     class="my-3"
                                                                                                     src="<?php echo e(asset('public/assets/admin-module/img/media/settle.png')); ?>"
                                                                                                     alt="<?php echo e(translate('settle')); ?>">
                                                                                                <h3 class="mb-3"><?php echo e(translate('Settled_this_request')); ?>

                                                                                                    ?</h3>
                                                                                            </div>

                                                                                            <div
                                                                                                class="py-3 d-flex flex-wrap flex-md-nowrap gap-3 mb-2">
                                                                                                <div
                                                                                                    class="c1-light-bg radius-10 py-3 px-4 flex-grow-1">
                                                                                                    <h4 class="mb-2"><?php echo e(translate('Provider_Information')); ?></h4>
                                                                                                    <?php if($withdrawRequest->provider): ?>
                                                                                                        <h5 class="c1 mb-2"><?php echo e($withdrawRequest->provider->company_name); ?></h5>
                                                                                                        <ul class="list-info">
                                                                                                            <li>
                                                                                                            <span
                                                                                                                class="material-icons">phone_iphone</span>
                                                                                                                <a href="tel:<?php echo e($withdrawRequest->provider->company_phone); ?>"><?php echo e($withdrawRequest->provider->company_phone); ?></a>
                                                                                                            </li>
                                                                                                            <li>
                                                                                                            <span
                                                                                                                class="material-icons">map</span>
                                                                                                                <p><?php echo e($withdrawRequest->provider->company_address); ?></p>
                                                                                                            </li>
                                                                                                        </ul>
                                                                                                    <?php endif; ?>
                                                                                                </div>

                                                                                                <div
                                                                                                    class="c1-light-bg radius-10 py-3 px-4 flex-grow-1">
                                                                                                    <h4 class="mb-2"><?php echo e(translate('Withdraw_Method_Information')); ?></h4>
                                                                                                    <ul class="list-info gap-1">
                                                                                                        <?php $__empty_1 = true; $__currentLoopData = $withdrawRequest->withdrawal_method_fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                                                            <li>
                                                                                                            <span
                                                                                                                class="font-weight-bold"><b><?php echo e(translate($key)); ?></b>: </span>
                                                                                                                <span><?php echo e($value); ?></span>
                                                                                                            </li>
                                                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                                                            <li>
                                                                                                                <span><?php echo e(translate('Information_unavailable')); ?></span>
                                                                                                            </li>
                                                                                                        <?php endif; ?>
                                                                                                    </ul>
                                                                                                </div>
                                                                                            </div>

                                                                                            <textarea
                                                                                                class="form-control h-140 resize-none"
                                                                                                placeholder="<?php echo e(translate('Note')); ?>"
                                                                                                name="note"></textarea>

                                                                                            <div
                                                                                                class="mb-3 mt-4 d-flex justify-content-center gap-3">
                                                                                                <button type="button"
                                                                                                        class="btn btn--secondary"
                                                                                                        data-bs-dismiss="modal"><?php echo e(translate('Cancel')); ?></button>
                                                                                                <button type="submit"
                                                                                                        class="btn btn--primary"><?php echo e(translate('Yes')); ?></button>
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php elseif($withdrawRequest->request_status=='denied'): ?>
                                                                        <label
                                                                            class="badge badge-danger"><?php echo e(translate('already_denied')); ?></label>
                                                                    <?php elseif($withdrawRequest->request_status=='settled'): ?>
                                                                        <label
                                                                            class="badge badge-success"><?php echo e(translate('already_settled')); ?></label>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <?php echo $withdrawRequests->links(); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uploadFileModal" tabindex="-1" aria-labelledby="uploadFileModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body py-5">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mw-340 mx-auto">
                        <h3 class="text-uppercase text-center mb-4"><?php echo e(translate('Upload_files')); ?> </h3>
                        <ul class="text-start text-muted d-flex flex-column gap-2">
                            <li><?php echo e(translate('Download Excel File From Withdraw list')); ?></li>
                            <li><?php echo e(translate('Update  the request status column with the request status (approved, denied, settled)')); ?></li>
                        </ul>
                        <p class="title-color fz-12 mb-5"><?php echo e(translate('NB: Do not modify the initial row of the excel file')); ?></p>
                        <form action="<?php echo e(route('admin.withdraw.request.import')); ?>" id="uploadProgressForm" method="post"
                              enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="d-flex justify-content-center">
                                <div class="upload-file w-auto">
                                    <input type="file" id="fileInput" class="upload-file__input"
                                           name="withdraw_request_file" accept=".xlsx" required>
                                    <div class="upload-file__img">
                                        <img src="<?php echo e(asset('public/assets/admin-module/img/media/upload-file.png')); ?>"
                                             alt="<?php echo e(translate('image')); ?>">
                                    </div>
                                    <span class="upload-file__edit">
                                        <span class="material-icons">edit</span>
                                    </span>
                                </div>
                            </div>

                            <div class="mt-5 card p-3">
                                <div class="d-flex flex-wrap align-items-center gap-3">
                                    <div class="">
                                        <img width="24"
                                             src="<?php echo e(asset('public/assets/admin-module')); ?>/img/media/excel.png"
                                             alt="">
                                    </div>
                                    <div class="flex-grow-1 text-start">
                                        <div
                                            class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-1">
                                            <span id="name_of_file"
                                                  class="text-truncate"><?php echo e(translate('file_name')); ?></span>
                                            <span class="text-muted" id="progress-label">0%</span>
                                        </div>
                                        <progress id="uploadProgress" class="w-100" value="0" max="100"></progress>
                                    </div>
                                    <button type="reset"
                                            class="btn-close position-static border rounded-circle border-secondary p-2 fz-10"
                                            aria-label="Close"></button>
                                </div>
                            </div>
                            <button type="submit" class="btn btn--primary mt-4 w-100"><?php echo e(translate('Submit')); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        "use strict"

        $('#multi-status__select').change(function () {
            var request_ids = [];
            $('input:checkbox.multi-check').each(function () {
                if (this.checked) {
                    request_ids.push($(this).val());
                }
            });

            Swal.fire({
                title: "<?php echo e(translate('are_you_sure')); ?>?",
                text: '',
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
                        url: "<?php echo e(route('admin.withdraw.request.update_multiple_status')); ?>",
                        data: {
                            request_ids: request_ids,
                            status: $(this).val()
                        },
                        type: 'put',
                        success: function (response) {
                            toastr.success(response.message)
                            setTimeout(location.reload.bind(location), 1000);
                        },
                        error: function () {

                        }
                    });
                }
            })

        });

        $(window).on('load', function () {
            $(".upload-file__input").on("change", function () {
                if (this.files && this.files[0]) {
                    let reader = new FileReader();
                    let img = $(this).siblings(".upload-file__img").find('img');

                    let file = this.files[0];
                    let isImage = file['type'].split('/')[0] == 'image';

                    if (isImage) {
                        reader.onload = function (e) {
                            img.attr("src", e.target.result);
                        };
                    } else {
                        reader.onload = function (e) {
                            img.attr("src", "<?php echo e(asset('public/assets/admin-module/img/media/excel.png')); ?>");
                        };
                    }

                    reader.readAsDataURL(file);

                    reader.addEventListener('progress', (event) => {
                        if (event.loaded && event.total) {
                            const percent = (event.loaded / event.total) * 100;
                            $('#uploadProgress').val(percent);
                            $('#progress-label').html(Math.round(percent) + '%');
                            $('#name_of_file').html(file.name);
                        }
                    });
                }
            });
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/TransactionModule/Resources/views/admin/withdraw/request/list.blade.php ENDPATH**/ ?>