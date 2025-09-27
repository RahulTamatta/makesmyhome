<?php $__env->startSection('title',translate('Request_Details')); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-wrap mb-3 d-flex justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <h2 class="page-title"><?php echo e(translate('request_Details')); ?></h2>

                        <span class="material-icons ripple-animation" data-bs-toggle="tooltip" data-bs-placement="top"
                              data-bs-title="<?php echo e(translate('This booking request includes custom instruction by the customer. Please read all the detailed requirements before accepting the request')); ?>"
                              type="button">info</span>
                    </div>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('booking_delete')): ?>
                    <a type="button" class="action-btn btn--danger rounded-circle" style="--size: 30px"
                       data-bs-toggle="modal"
                       data-bs-target="#exampleModal--<?php echo e($post['id']); ?>">
                        <span class="material-symbols-outlined">delete</span>
                    </a>
                        <?php endif; ?>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <div class="card bg-primary-light shadow-none">
                                    <div class="card-body pb-5">
                                        <div class="media flex-wrap gap-3">
                                            <img width="140" class="radius-10"
                                                 src="<?php echo e($post?->customer?->profile_image_full_path); ?>"
                                                 alt="<?php echo e(translate('profile_image')); ?>">
                                            <div class="media-body">
                                                <div class="d-flex align-items-center gap-2 mb-3">
                                                    <span class="material-icons text-primary">person</span>
                                                    <h4><?php echo e(translate('Customer Information')); ?></h4>
                                                </div>
                                                <h5 class="text-primary mb-2"><?php echo e($post?->customer?->first_name.' '.$post?->customer?->last_name); ?></h5>

                                                <div class="fs-12 text-muted">0.8km away from you</div>

                                                <p class="text-muted fs-12">
                                                    <?php if($distance): ?>
                                                        <?php echo e($distance); ?> <?php echo e(translate('away from you')); ?>

                                                    <?php endif; ?>
                                                </p>
                                                <div class="d-flex align-items-center gap-2 mb-2">
                                                    <span class="material-icons">phone_iphone</span>
                                                    <a href="tel:<?php echo e($post?->customer?->phone); ?>"><?php echo e($post?->customer?->phone); ?></a>
                                                </div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="material-icons">map</span>
                                                    <p><?php echo e(Str::limit($post?->service_address?->address??translate('not_available'), 100)); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card bg-primary-light shadow-none">
                                    <div class="card-body pb-5">
                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            <img width="18"
                                                 src="<?php echo e(asset('public/assets/provider-module')); ?>/img/media/more-info.png"
                                                 alt="">
                                            <h4><?php echo e(translate('Service Information')); ?></h4>
                                        </div>
                                        <div class="media gap-2 mb-4">
                                            <img width="30"
                                                 src="<?php echo e($post?->sub_category?->image_full_path); ?>"
                                                 alt="<?php echo e(translate('sub_category')); ?>">
                                            <div class="media-body">
                                                <h5><?php echo e($post?->service?->name); ?></h5>
                                                <div class="text-muted fs-12"><?php echo e($post?->sub_category?->name); ?></div>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-column gap-2">
                                            <div class="fw-medium"><?php echo e(translate('Booking Request Time')); ?> : <span
                                                    class="fw-bold"><?php echo e($post->created_at->format('d/m/Y h:ia')); ?></span>
                                            </div>
                                            <div class="fw-medium"><?php echo e(translate('Service Time')); ?> : <span
                                                    class="fw-bold"><?php echo e(date('d/m/Y h:ia',strtotime($post->booking_schedule))); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card">
                                    <div
                                        class="card-header d-flex align-items-center gap-2 bg-primary-light shadow-none">
                                        <img width="18"
                                             src="<?php echo e(asset('public/assets/provider-module')); ?>/img/icons/instruction.png"
                                             alt="">
                                        <h5 class="text-uppercase"><?php echo e(translate('Additional Instruction')); ?></h5>
                                    </div>
                                    <div class="card-body pb-4">
                                        <ul class="d-flex flex-column gap-3 px-3 instruction-details">
                                            <?php $__empty_1 = true; $__currentLoopData = $post?->addition_instructions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <li><?php echo e($item->details); ?></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <span><?php echo e(translate('No_Addition_Instructions')); ?></span>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card h-100">
                                    <div
                                        class="card-header d-flex align-items-center gap-2 bg-primary-light shadow-none">
                                        <img width="18"
                                             src="<?php echo e(asset('public/assets/provider-module')); ?>/img/icons/edit-info.png"
                                             alt="">
                                        <h5 class="text-uppercase"><?php echo e(translate('Service Description')); ?></h5>
                                    </div>
                                    <div class="card-body pb-4">
                                        <p><?php echo e($post->service_description); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card h-100">
                                    <div
                                        class="card-header d-flex align-items-center gap-2 bg-primary-light shadow-none">
                                        <img width="18"
                                             src="<?php echo e(asset('public/assets/provider-module')); ?>/img/icons/provider.png"
                                             alt="">
                                        <h5 class="text-uppercase"><?php echo e(translate('other_provider_offering')); ?></h5>
                                    </div>
                                    <div class="card-body pb-4">
                                        <?php $__empty_1 = true; $__currentLoopData = $post->bids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <div class="d-flex align-items-center justify-content-between gap-3 mb-4">
                                                <div class="media gap-3">
                                                    <div class="avatar avatar-lg">
                                                        <img class="rounded"
                                                             src="<?php echo e(onErrorImage(
                                                                    $item?->provider?->logo,
                                                                    asset('storage/app/public/provider/logo').'/' . $item?->provider?->logo,
                                                                    asset('public/assets/placeholder.png') ,
                                                                    'provider/logo/')); ?>"
                                                             alt="<?php echo e(translate('provider-logo')); ?>">
                                                    </div>
                                                    <div class="media-body">
                                                        <h5><?php echo e($item?->provider?->company_name); ?></h5>
                                                        <div
                                                            class="fs-12 d-flex flex-wrap align-items-center gap-2 mt-1">
                                                        <span class="common-list_rating d-flex gap-1">
                                                            <span class="material-icons text-primary fs-12">star</span>
                                                            <?php echo e($item?->provider?->avg_rating??0); ?>

                                                        </span>
                                                            <span><?php echo e($item?->provider?->rating_count??0); ?> <?php echo e(translate('Reviews')); ?></span>
                                                        </div>
                                                        <div
                                                            class="d-flex gap-2 flex-wrap align-items-center fs-12 mt-1">
                                                                    <span
                                                                        class="text-danger"><?php echo e(translate('price offered')); ?></span>
                                                            <h4 class="text-primary"><?php echo e(with_currency_symbol($item->offered_price??0)); ?></h4>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <button class="dropdown-item d-flex gap-2" data-bs-toggle="modal"
                                                            data-bs-target="#providerInformationModal--<?php echo e($item?->provider?->id); ?>">
                                                        <?php echo e(translate('View Details')); ?>

                                                        <span class="material-symbols-outlined">chevron_right</span>
                                                    </button>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <div class="d-flex justify-content-between gap-3 mb-4">
                                                <span><?php echo e(translate('No provider offering for the post')); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header pb-0 border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-sm-5">
                    <div class="d-flex flex-column align-items-center gap-2 text-center">
                        <img src="<?php echo e(asset('public/assets/provider-module')); ?>/img/icons/alert.png" alt="">
                        <h3><?php echo e(translate('Alert')); ?>!</h3>
                        <p class="fw-medium">
                            <?php echo e(translate('This request is with customized instructions. Please read the customer description and instructions thoroughly and place your pricing according to this')); ?>

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal--<?php echo e($post['id']); ?>"
         tabindex="-1"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body pt-5 p-md-5">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    <div class="d-flex justify-content-center mb-4">
                        <img width="75" height="75" src="<?php echo e(asset('public/assets/admin-module/img/media/delete.png')); ?>"
                             class="rounded-circle" alt="">
                    </div>

                    <h3 class="text-center mb-1 fw-medium"><?php echo e(translate('Are you sure you want to delete the post?')); ?></h3>
                    <p class="text-center fs-12 fw-medium text-muted"><?php echo e(translate('You will lost the customer booking request?')); ?></p>
                    <form method="post"
                          action="<?php echo e(route('admin.booking.post.delete', [$post->id])); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="form-floating">
                            <textarea class="form-control resize-none" placeholder="<?php echo e(translate('Cancellation Note')); ?>"
                                      name="post_delete_note" required id="add-your-notes"></textarea>

                            <label for="add-your-notes" class="d-flex align-items-center gap-1">
                                <?php echo e(translate('Cancellation Note')); ?>

                            </label>
                        </div>
                        <div class="d-flex justify-content-center gap-3 mt-3">
                            <button type="button" class="btn btn--secondary"
                                    data-bs-dismiss="modal"><?php echo e(translate('cancel')); ?></button>
                            <button type="submit" class="btn btn-danger"><?php echo e(translate('Delete')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php $__currentLoopData = $post->bids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="providerInformationModal--<?php echo e($item?->provider?->id); ?>" tabindex="-1"
             aria-labelledby="alertModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header pb-0 border-0">
                        <h3><?php echo e(translate('Provider Information')); ?></h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5">
                        <div class="d-flex justify-content-between gap-3 mb-4">
                            <div class="media gap-3">
                                <div class="avatar avatar-lg">
                                    <img class="rounded"
                                         src="<?php echo e(onErrorImage(
                                              $item?->provider?->logo,
                                              asset('storage/app/public/provider/logo').'/' . $item?->provider?->logo,
                                              asset('public/assets/placeholder.png') ,
                                              'provider/logo/')); ?>"
                                         alt="<?php echo e(translate('provider-logo')); ?>">
                                </div>
                                <div class="media-body">
                                    <div class="d-flex justify-content-between">
                                        <h5><?php echo e($item?->provider?->company_name); ?></h5>
                                        <div><?php echo e($item->created_at->format('Y-m-d h:ia')); ?></div>
                                    </div>
                                    <div class="fs-12 d-flex flex-wrap align-items-center gap-2 mt-1">
                                            <span class="common-list_rating d-flex gap-1">
                                                <span class="material-icons text-primary fs-12">star</span>
                                                <?php echo e($item?->provider?->avg_rating??0); ?>

                                            </span>
                                        <span><?php echo e($item?->provider?->rating_count??0); ?> <?php echo e(translate('Reviews')); ?></span>
                                    </div>
                                    <div class="d-flex gap-2 flex-wrap align-items-center fs-12 mt-1">
                                        <span class="text-danger"><?php echo e(translate('price offered')); ?></span>
                                        <h4 class="text-primary"><?php echo e(with_currency_symbol($item->offered_price??0)); ?></h4>
                                    </div>
                                    <?php if($item->provider_note): ?>
                                        <div>
                                            <span><?php echo e(translate('Description')); ?>:</span>
                                            <p><?php echo e($item->provider_note); ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/BidModule/Resources/views/admin/details.blade.php ENDPATH**/ ?>