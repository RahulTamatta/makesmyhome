<?php $__env->startSection('title',translate('Service_Request_List')); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap mb-3 d-flex justify-content-between">
                        <h2 class="page-title"><?php echo e(translate('Service_Request_List')); ?></h2>
                    </div>

                    <div class="d-flex flex-wrap justify-content-end align-items-center border-bottom mx-lg-4 mb-10 gap-3">
                        <div class="d-flex gap-2 fw-medium mb-1">
                            <span class="opacity-75"><?php echo e(translate('Total Service Requests')); ?>:</span>
                            <span class="title-color"><?php echo e($requests->total()); ?></span>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body pb-5">
                            <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between">
                                <form action="<?php echo e(url()->current()); ?>"
                                      class="search-form search-form_style-two"
                                      method="GET">
                                    <div class="input-group search-form__input_group">
                                            <span class="search-form__icon">
                                                <span class="material-icons">search</span>
                                            </span>
                                        <input type="search" class="theme-input-style search-form__input"
                                               value="<?php echo e($search??''); ?>" name="search"
                                               placeholder="<?php echo e(translate('search_by_Category')); ?>">
                                    </div>
                                    <button type="submit" class="btn btn--primary"><?php echo e(translate('search')); ?></button>
                                </form>
                            </div>

                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead class="text-nowrap">
                                        <tr>
                                            <th><?php echo e(translate('SL')); ?></th>
                                            <th><?php echo e(translate('Category')); ?></th>
                                            <th><?php echo e(translate('User')); ?></th>
                                            <th><?php echo e(translate('Service Name')); ?></th>
                                            <th><?php echo e(translate('Service Description')); ?></th>
                                            <th><?php echo e(translate('Given feedback')); ?></th>
                                            <th><?php echo e(translate('Action')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td><?php echo e($requests->firstitem()+$key); ?></td>
                                                <td>
                                                    <?php if($item->category): ?>
                                                        <span><?php echo e(translate($item->category->name)); ?></span>
                                                    <?php else: ?>
                                                        <span><?php echo e(translate('Not available')); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($item->user && !$item->user->provider): ?>
                                                        <a href="<?php echo e(route('admin.customer.detail',[$item->user->id, 'web_page'=>'overview'])); ?>">
                                                            <?php echo e($item->user->first_name); ?> <?php echo e($item->user->last_name); ?> <span class="badge-pill badge-info p-1 rounded"><?php echo e(translate('Customer')); ?></span>
                                                        </a>
                                                    <?php endif; ?>

                                                    <?php if($item->user && $item->user->provider): ?>
                                                        <a href="<?php echo e(route('admin.provider.details',[$item->user->provider->id, 'web_page'=>'overview'])); ?>">
                                                            <?php echo e($item->user->provider->company_name); ?> <span class="badge-pill badge-info p-1 rounded"><?php echo e(translate('Provider')); ?></span>
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e($item->service_name); ?></td>
                                                <td>
                                                    <div class="max-w320 min-w180 text-justify" data-bs-toggle="modal" data-bs-target="#serviceRequestModal--<?php echo e($item['id']); ?>">
                                                        <?php echo e(Str::limit($item->service_description, 150)); ?>

                                                    </div>
                                                    <div class="modal fade" id="serviceRequestModal--<?php echo e($item['id']); ?>" tabindex="-1" aria-labelledby="serviceRequestModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-body p-sm-4">
                                                                    <div class="mb-4">
                                                                        <h3 class="text-center"><?php echo e(translate('service_Request_List')); ?></h3>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>

                                                                    <div class="d-flex flex-column gap-2">
                                                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                                                            <span><?php echo e(translate('category')); ?> </span>:
                                                                            <?php if($item->category): ?>
                                                                                <span><?php echo e(translate($item->category->name)); ?></span>
                                                                            <?php else: ?>
                                                                                <span><?php echo e(translate('Not available')); ?></span>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                                                            <?php if($item->user && $item->user->provider): ?>
                                                                                <span><?php echo e(translate('user_Name')); ?> </span>:
                                                                                <span> <?php echo e($item->user->provider->company_name); ?></span>
                                                                                <span class="badge-pill badge-info p-1 rounded"><?php echo e(translate('provider')); ?></span>
                                                                            <?php endif; ?>

                                                                            <?php if($item->user && !$item->user->provider): ?>
                                                                                <span><?php echo e(translate('user_Name')); ?> </span>:
                                                                                <span> <?php echo e($item->user->first_name); ?> <?php echo e($item->user->last_name); ?></span>
                                                                                <span class="badge-pill badge-info p-1 rounded"><?php echo e(translate('Customer')); ?></span>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                                                            <span><?php echo e(translate('service_Name')); ?> </span>:
                                                                            <span> <?php echo e($item->service_name); ?> </span>
                                                                        </div>
                                                                    </div>

                                                                    <div class="c1-light-bg rounded py-2 px-3 mt-4 mb-3">
                                                                        <h5 class="fw-medium"><?php echo e(translate('service_Description')); ?></h5>
                                                                    </div>

                                                                    <p><?php echo e($item->service_description); ?></p>

                                                                    <div class="c1-light-bg rounded py-2 px-3 mt-4 mb-3">
                                                                        <h5 class="fw-medium"><?php echo e(translate('given_Feedback')); ?></h5>
                                                                    </div>

                                                                    <p><?php echo e($item->admin_feedback); ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="max-w320 min-w180 text-justify" data-bs-toggle="modal" data-bs-target="#serviceRequestModal--<?php echo e($item['id']); ?>">
                                                        <?php echo e(Str::limit($item->admin_feedback, 150)); ?>

                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="table-actions">
                                                        <?php if($item->status == 'approved'): ?>
                                                            <span class="badge badge-pill badge-success"><?php echo e(translate('Feedback Sent')); ?></span>
                                                        <?php elseif($item->status == 'denied'): ?>
                                                                <span class="badge badge-pill badge-danger"><?php echo e(translate('Feedback Sent')); ?></span>
                                                        <?php elseif($item->status == 'pending'): ?>
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('service_manage_status')): ?>
                                                            <button type="button" class="btn btn--primary" data-bs-toggle="modal" data-bs-target="#review-modal--<?php echo e($key); ?>">
                                                                <?php echo e(translate('Give Feedback')); ?>

                                                            </button>
                                                            <?php endif; ?>

                                                            <div class="modal fade" id="review-modal--<?php echo e($key); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header align-items-start">
                                                                            <div class="d-flex flex-column gap-1">
                                                                                <h4 class="modal-title"><?php echo e(translate('Admin Feedback')); ?></h4>
                                                                                <div class="d-flex gap-1">
                                                                                    <h5 class="text-muted"><?php echo e(translate('Category Name')); ?> : </h5>
                                                                                    <div class="fs-12"><?php echo e(translate($item->category->name??'')); ?> </div>
                                                                                </div>
                                                                                <div class="d-flex gap-1">
                                                                                    <h5 class="text-muted"><?php echo e(translate('Service Name')); ?> : </h5>
                                                                                    <div class="fs-12"><?php echo e($item->service_name); ?> </div>
                                                                                </div>
                                                                            </div>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>

                                                                        <form action="<?php echo e(route('admin.service.request.update', [$item->id])); ?>" class="mt-4" method="POST">
                                                                            <?php echo csrf_field(); ?>
                                                                            <div class="modal-body">
                                                                                <div class="form-floating mb-30">
                                                                                    <textarea class="form-control" placeholder="<?php echo e(translate('Give feedback')); ?>" name="admin_feedback"></textarea>
                                                                                    <label for="floatingTextarea"><?php echo e(translate('Give feedback')); ?> <small><?php echo e(translate('(optional)')); ?></small></label>
                                                                                </div>

                                                                                <div class="d-flex justify-content-start">
                                                                                    <div class="form-check p-0">
                                                                                        <input class="form-check-input" type="radio" name="review_status" id="flexRadioDefault<?php echo e($key); ?>" value="1" checked required>
                                                                                        <label class="form-check-label" for="flexRadioDefault<?php echo e($key); ?>"><?php echo e(translate('Review')); ?></label>
                                                                                    </div>
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input" type="radio" name="review_status" id="flexRadioDefault2<?php echo e($key); ?>" value="0" required>
                                                                                        <label class="form-check-label" for="flexRadioDefault2<?php echo e($key); ?>"><?php echo e(translate('Reject')); ?></label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn--secondary" data-bs-dismiss="modal"><?php echo e(translate('Close')); ?></button>
                                                                                <button type="submit" class="btn btn--primary"><?php echo e(translate('Submit')); ?></button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr class="text-center">
                                                <td colspan="6"><?php echo e(translate('No data available')); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                     </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                <?php echo $requests->links(); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/ServiceManagement/Resources/views/admin/service/request-list.blade.php ENDPATH**/ ?>