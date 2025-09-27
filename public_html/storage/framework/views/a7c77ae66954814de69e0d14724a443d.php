<?php $__env->startSection('title',translate('service_details')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/select2/select2.min.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/select.dataTables.min.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/wysiwyg-editor/froala_editor.min.css"/>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-title-wrap mb-3">
                <h2 class="page-title"><?php echo e(translate('service_details')); ?></h2>
            </div>

            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="row mb-4 g-4">
                        <div class="col-lg-4 col-sm-12">
                            <div class="statistics-card statistics-card__total-orders">
                                <h2><?php echo e($service->bookings_count); ?></h2>
                                <h3><?php echo e(translate('total_bookings')); ?></h3>
                                <img src="<?php echo e(asset('public/assets/admin-module/img/icons/total-orders.png')); ?>"
                                     class="absolute-img" alt="<?php echo e(translate('total-orders')); ?>">
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="statistics-card statistics-card__ongoing">
                                <h2><?php echo e($service['ongoing_count']??0); ?></h2>
                                <h3><?php echo e(translate('ongoing')); ?></h3>
                                <img src="<?php echo e(asset('public/assets/admin-module/img/icons/ongoing.png')); ?>"
                                     class="absolute-img" alt="<?php echo e(translate('ongoing-orders')); ?>">
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="statistics-card statistics-card__canceled">
                                <h2><?php echo e($service['canceled_count']??0); ?></h2>
                                <h3><?php echo e(translate('canceled')); ?></h3>
                                <img src="<?php echo e(asset('public/assets/admin-module/img/icons/canceled.png')); ?>"
                                     class="absolute-img" alt="<?php echo e(translate('canceled-orders')); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <ul class="nav nav--tabs nav--tabs__style2">
                    <li class="nav-item">
                        <button class="nav-link <?php echo e(!isset($webPage) || $webPage=='general'?'active':''); ?>"
                                data-bs-toggle="tab"
                                data-bs-target="#general-tab-pane"><?php echo e(translate('general_info')); ?>

                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link <?php echo e(isset($webPage) && $webPage=='faq'?'active':''); ?>" data-bs-toggle="tab"
                                data-bs-target="#faq-tab-pane"><?php echo e(translate('faq')); ?></button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link <?php echo e(isset($webPage) && $webPage=='review'?'active':''); ?>"
                                data-bs-toggle="tab"
                                data-bs-target="#review-tab-pane"><?php echo e(translate('reviews')); ?>

                        </button>
                    </li>
                </ul>
            </div>

            <div class="tab-content">
                <div class="tab-pane fade <?php echo e(!isset($webPage) || $webPage=='general'?'show active':''); ?>"
                     id="general-tab-pane">
                    <div class="card">
                        <div class="card-body p-30">
                            <div class="media flex-column flex-md-row gap-3 mb-3">
                                <div class="">
                                    <img width="300"
                                         src="<?php echo e($service->cover_image_full_path); ?>">
                                </div>
                                <div class="media-body ">
                                    <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between mb-3">
                                        <h2 class="c1"><?php echo e($service->name); ?></h2>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('service_update')): ?>
                                            <a href="<?php echo e(route('admin.service.edit',[$service->id])); ?>"
                                               class="btn btn--primary">
                                                <span class="material-icons">border_color</span>
                                                <?php echo e(translate('edit')); ?>

                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <p class="text-secondary"><?php if($service?->category): ?>
                                            <?php echo e(translate('category')); ?>

                                            : <?php echo e($service?->category->name ?? translate('Unavailable')); ?> <?php if($service?->subCategory): ?>
                                                |
                                            <?php endif; ?>
                                        <?php endif; ?>  <?php if($service?->subCategory): ?>
                                            <?php echo e(translate('sub-category')); ?>

                                            : <?php echo e($service?->subCategory->name ?? translate('Unavailable')); ?>

                                        <?php endif; ?></p>
                                    <p><?php echo e($service->short_description); ?></p>
                                </div>
                            </div>

                            <div class="mb-3">
                                <ul class="nav nav--tabs">
                                    <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="tab"
                                                data-bs-target="#long-description-tab-pane"><?php echo e(translate('details')); ?>

                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab"
                                                data-bs-target="#price-table-tab-pane"><?php echo e(translate('price_table')); ?>

                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="long-description-tab-pane">
                                    <?php echo $service->description; ?>

                                </div>
                                <div class="tab-pane fade" id="price-table-tab-pane">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-10">
                                            <div class="mt-3 mb-4">
                                                <ul class="nav nav--tabs nav--tabs__style3">
                                                    <?php ($count=0); ?>
                                                    <?php if($service->category && $service->category->zones): ?>
                                                        <?php $__currentLoopData = $service->category->zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li class="nav-item">
                                                                <button class="nav-link <?php echo e($count==0?'active':''); ?>"
                                                                        data-bs-toggle="tab"
                                                                        data-bs-target="#tab-<?php echo e($zone->id); ?>"><?php echo e($zone->name??""); ?>

                                                                </button>
                                                            </li>
                                                            <?php ($count++); ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>

                                            <div class="tab-content">
                                                <?php ($count=0); ?>
                                                <?php if($service->category && $service->category->zones): ?>
                                                    <?php $__currentLoopData = $service->category->zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="tab-pane fade show <?php echo e($count==0?'active':''); ?>"
                                                             id="tab-<?php echo e($zone->id); ?>">
                                                            <p class="text-center"><strong
                                                                    class="c1 me-1"><?php echo e($service->variations->where('zone_id',$zone->id)->count()); ?></strong>
                                                                <?php echo e(translate('available_variants')); ?>

                                                            </p>
                                                            <div class="service-price-list">
                                                                <?php $__currentLoopData = $service->variations->where('zone_id',$zone->id)->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <div class="service-price-list-item">
                                                                        <p><?php echo e($variant->variant); ?> </p>
                                                                        <h3 class="c1"><?php echo e(with_currency_symbol($variant->price)); ?></h3>
                                                                    </div>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </div>
                                                        </div>
                                                        <?php ($count++); ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade <?php echo e(isset($webPage) && $webPage=='faq'?'show active':''); ?>" id="faq-tab-pane">
                    <div class="card mb-30">
                        <div class="card-body p-30">
                            <form action="javascript:void(0)" method="POST" class="mb-30" id="faq-form">
                                <?php echo csrf_field(); ?>
                                <div class="form-floating mb-30">
                                    <input type="text" class="form-control" placeholder="<?php echo e(translate('question')); ?>"
                                           name="question" required="">
                                    <label><?php echo e(translate('question')); ?></label>
                                </div>
                                <div class="form-floating mb-30">
                                    <textarea class="form-control" placeholder="<?php echo e(translate('answer')); ?>" name="answer"
                                              required=""></textarea>
                                    <label><?php echo e(translate('answer')); ?></label>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn--primary"><?php echo e(translate('add_faq')); ?></button>
                                </div>
                            </form>

                            <div class="text-center mb-30">
                                <div class="" id="faq-list">
                                    <?php echo $__env->make('servicemanagement::admin.partials._faq-list',['faqs'=>$faqs], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade <?php echo e(isset($webPage) && $webPage=='review'?'show active':''); ?>"
                     id="review-tab-pane">
                    <div class="card mb-30">
                        <div class="card-body p-30">
                            <div class="row align-items-center">
                                <div class="col-lg-5 mb-30 mb-lg-0 d-flex justify-content-center">
                                    <div class="rating-review">
                                        <h2 class="rating-review__title">
                                            <span class="rating-review__out-of"><?php echo e($service->avg_rating); ?></span>/5
                                        </h2>
                                        <div class="rating">
                                            <span
                                                class="<?php echo e($service->avg_rating>=1?'material-icons':'material-symbols-outlined'); ?>"><?php echo e($service->avg_rating>=1?'star':'grade'); ?></span>
                                            <span
                                                class="<?php echo e($service->avg_rating>=2?'material-icons':'material-symbols-outlined'); ?>"><?php echo e($service->avg_rating>=2?'star':'grade'); ?></span>
                                            <span
                                                class="<?php echo e($service->avg_rating>=3?'material-icons':'material-symbols-outlined'); ?>"><?php echo e($service->avg_rating>=3?'star':'grade'); ?></span>
                                            <span
                                                class="<?php echo e($service->avg_rating>=4?'material-icons':'material-symbols-outlined'); ?>"><?php echo e($service->avg_rating>=4?'star':'grade'); ?></span>
                                            <span
                                                class="<?php echo e($service->avg_rating>=5?'material-icons':'material-symbols-outlined'); ?>"><?php echo e($service->avg_rating>=5?'star':'grade'); ?></span>
                                        </div>
                                        <div class="rating-review__info d-flex flex-wrap gap-3">
                                            <?php ($total_review_count = $service->reviews->where('is_active', 1)->whereNotNull('review_rating')->whereNotNull('review_comment')->count()); ?>
                                            <?php ($totalReviews = $service->reviews->where('is_active', 1)->whereNotNull('review_rating')->count()); ?>
                                            <span><?php echo e($totalReviews); ?> <?php echo e(translate('ratings')); ?></span>
                                            <span><?php echo e($total_review_count); ?> <?php echo e(translate('reviews')); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <ul class="common-list common-list__style2 after-none gap-10">
                                        <li>
                                            <span class="review-name"><?php echo e(translate('excellent')); ?></span>
                                            <?php ($excellent_count=$service->reviews->where('is_active', 1)->where('review_rating',5)->count()); ?>
                                            <?php ($excellent=(divnum($excellent_count,$total_review_count))*100); ?>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"
                                                     style="width: <?php echo e($excellent); ?>%"
                                                     aria-valuenow="<?php echo e($excellent); ?>" aria-valuemin="0"
                                                     aria-valuemax="100">
                                                </div>
                                            </div>
                                            <span class="review-count"><?php echo e($excellent_count); ?></span>
                                        </li>
                                        <li>
                                            <span class="review-name"><?php echo e(translate('good')); ?></span>
                                            <?php ($good_count=$service->reviews->where('is_active', 1)->where('review_rating',4)->count()); ?>
                                            <?php ($good=(divnum($good_count,$total_review_count))*100); ?>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: <?php echo e($good); ?>%"
                                                     aria-valuenow="<?php echo e($good); ?>" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                            <span class="review-count"><?php echo e($good_count); ?></span>
                                        </li>
                                        <li>
                                            <span class="review-name"><?php echo e(translate('avarage')); ?></span>
                                            <?php ($average_count=$service->reviews->where('is_active', 1)->where('review_rating',3)->count()); ?>
                                            <?php ($average=(divnum($average_count,$total_review_count))*100); ?>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"
                                                     style="width: <?php echo e($average); ?>%"
                                                     aria-valuenow="<?php echo e($average); ?>" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                            <span class="review-count"><?php echo e($average_count); ?></span>
                                        </li>
                                        <li>
                                            <span class="review-name"><?php echo e(translate('below_avarage')); ?></span>
                                            <?php ($below_average_count=$service->reviews->where('is_active', 1)->where('review_rating',2)->count()); ?>
                                            <?php ($below_average=(divnum($below_average_count,$total_review_count))*100); ?>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"
                                                     style="width: <?php echo e($below_average); ?>%"
                                                     aria-valuenow="<?php echo e($below_average); ?>" aria-valuemin="0"
                                                     aria-valuemax="100">
                                                </div>
                                            </div>
                                            <span class="review-count"><?php echo e($below_average_count); ?></span>
                                        </li>
                                        <li>
                                            <span class="review-name"><?php echo e(translate('poor')); ?></span>
                                            <?php ($poor_count=$service->reviews->where('is_active', 1)->where('review_rating',1)->count()); ?>
                                            <?php ($poor=(divnum($poor_count,$total_review_count))*100); ?>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: <?php echo e($poor); ?>%"
                                                     aria-valuenow="<?php echo e($poor); ?>" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                            <span class="review-count"><?php echo e($poor_count); ?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end border-bottom pb-2 mb-10">
                        <div class="d-flex gap-2 fw-medium">
                            <span class="opacity-75"><?php echo e(translate('total_reviews')); ?>:</span>
                            <span class="title-color"><?php echo e($reviews->total()); ?></span>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between">
                                <form action="<?php echo e(url()->current()); ?>" class="search-form search-form_style-two"
                                      method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="input-group search-form__input_group">
                                            <span class="search-form__icon">
                                                <span class="material-icons">search</span>
                                            </span>
                                        <input type="search" class="theme-input-style search-form__input"
                                               value="<?php echo e($search); ?>" name="review_search"
                                               placeholder="<?php echo e(translate('search_review_id')); ?>">
                                    </div>
                                    <button type="submit" class="btn btn--primary">
                                        <?php echo e(translate('search')); ?>

                                    </button>
                                </form>
                                <div class="d-flex flex-wrap align-items-center gap-3">
                                    <div class="dropdown">
                                        <button type="button"
                                                class="btn btn--secondary text-capitalize dropdown-toggle"
                                                data-bs-toggle="dropdown">
                                            <span class="material-icons">file_download</span> <?php echo e(translate('download')); ?>

                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                            <li><a class="dropdown-item"
                                                   href="<?php echo e(route('admin.service.reviews.download',['review_search'=>$search, 'service_id' => request()->id])); ?>"><?php echo e(translate('excel')); ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="example" class="table align-middle">
                                    <thead class="text-capitalize">
                                        <tr>
                                            <th><?php echo e(translate('SL')); ?></th>
                                            <th class="text-nowrap"><?php echo e(translate('Review ID')); ?></th>
                                            <th><?php echo e(translate('reviewer')); ?></th>
                                            <th><?php echo e(translate('date')); ?></th>
                                            <th><?php echo e(translate('ratings')); ?></th>
                                            <th><?php echo e(translate('reviews')); ?></th>
                                            <th><?php echo e(translate('reply')); ?></th>
                                            <th><?php echo e(translate('status')); ?></th>
                                            <th><?php echo e(translate('action')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($key+$reviews?->firstItem()); ?></td>
                                            <td><?php echo e($review->readable_id == 0 ? 'N/A' : $review->readable_id); ?></td>
                                            <td>
                                                <?php if(isset($review->customer)): ?>
                                                    <span><?php echo e($review->customer->first_name . ' ' .$review->customer->last_name); ?></span><br>
                                                    <span><?php echo e(translate('Booking ID #') . $review?->booking?->readable_id); ?></span>
                                                <?php else: ?>
                                                    <span class="opacity-50"><?php echo e(translate('Customer_not_available')); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($review->created_at); ?></td>
                                            <td>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15" fill="none">
                                                    <path d="M7 1.81445L8.854 5.76398L13 6.4012L10 9.47376L10.708 13.8145L7 11.764L3.292 13.8145L4 9.47376L1 6.4012L5.146 5.76398L7 1.81445Z" fill="#FFB900" stroke="#FFB900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                <?php echo e($review->review_rating); ?>

                                            </td>
                                            <td data-bs-custom-class="review-tooltip" data-bs-toggle="tooltip" title="<?php echo e($review->review_comment); ?>"><?php echo e(Str::limit($review->review_comment, 100) ?? translate('No review yet')); ?></td>
                                            <td data-bs-custom-class="review-tooltip" data-bs-toggle="tooltip" title="<?php echo e($review->reviewReply?->reply); ?>"><?php echo e(Str::limit($review->reviewReply?->reply, 100) ?? translate('No reply yet')); ?></td>
                                            <td>
                                                <?php if(!empty($review->review_comment)): ?>
                                                <label class="switcher">
                                                    <input class="switcher_input route-alert"
                                                           data-route="<?php echo e(route('admin.service.review-status-update', $review->id)); ?>"
                                                           data-message="<?php echo e(translate('want_to_update_status')); ?>"
                                                           type="checkbox" <?php echo e($review->is_active ? 'checked' : ''); ?>>
                                                    <span class="switcher_control"></span>
                                                </label>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if(!empty($review->review_comment)): ?>
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <button class="action-btn btn--light-primary fw-medium text-capitalize fz-14" data-bs-toggle="modal" id="replyModalBtn"
                                                            data-bs-target="#replyModal"
                                                            data-booking_id ="<?php echo e($review->booking->readable_id); ?>"
                                                            data-readable_id ="<?php echo e($review->readable_id); ?>"
                                                            data-service_name="<?php echo e($review->service->name); ?>"
                                                            data-service_img="<?php echo e($review->service->cover_image_full_path); ?>"
                                                            data-review="<?php echo e($review->review_comment ?? translate('No review yet')); ?>"
                                                            data-review_reply="<?php echo e($review->reviewReply?->reply ?? translate('No reply yet')); ?>"
                                                            data-variant_key="<?php echo e($review->booking?->detail[0]?->variant_key); ?>"
                                                    >
                                                        <span class="material-icons">visibility</span>
                                                    </button>
                                                </div>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-end">
                                <?php echo $reviews->links(); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="p-3 pt-0">
                        <div class="d-flex gap-3">
                            <img src="" class="rounded aspect-square object-fit-cover" width="80" alt="Service Image">
                            <div class="w-0 flex-grow-1">
                                <div class="mb-2">
                                    <span><?php echo e(translate('Booking ID #')); ?></span> <label class="booking_id"></label>
                                </div>
                                <h5 class="service_name"></h5>
                                <div class="mt-2">
                                    <span class="variant_key"></span>
                                </div>
                            </div>
                        </div>
                        <div class="review_section mb-3 mt-3">
                            <h4 class="mb-2"><?php echo e(translate('Review')); ?></h4>
                            <div class="p-3 rounded bg--secondary">
                                <p class="review_content"></p>
                            </div>
                        </div>
                        <div class="reply_section">
                            <div>
                                <h4 class="mb-3"><?php echo e(translate('Reply')); ?></h4>
                                <div class="form-group">
                                    <textarea id="reply_content" class="form-control" name="reply_content" rows="4" readonly disabled></textarea>
                                    <input type="hidden" class="form-control" name="readable_id" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        "use strict"

        document.addEventListener('DOMContentLoaded', function () {
            var clickableRows = document.querySelectorAll('.clickable-row');
            clickableRows.forEach(function (row) {
                row.addEventListener('click', function () {
                    var target = row.getAttribute('data-target');
                    var collapseElement = document.querySelector(target);
                    collapseElement.classList.toggle('show');
                });
            });
        });


        $('#replyModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const modal = $(this);
            const serviceImg = button.data('service_img');
            const serviceName = button.data('service_name');
            const bookingID = button.data('booking_id');
            const readableID = button.data('readable_id');
            const review = button.data('review');
            const reviewReply = button.data('review_reply');
            const variantKey = button.data('variant_key');
            const action = button.data('action');

            modal.find('.service_name').text(serviceName);
            modal.find('.variant_key').text(variantKey);
            modal.find('.booking_id').text(bookingID);
            modal.find('.review_content').text(review);
            modal.find('img').attr('src', serviceImg);

            modal.find('textarea[name=reply_content]').val(reviewReply);
            modal.find('input[name=readable_id]').val(readableID);
            modal.find('form').attr('action',action);
        });

        $('#faq-form').on('submit', e => {
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#faq-form')[0];
            var data = new FormData(form);

            $.post({
                url: '<?php echo e(route('admin.faq.store',[$service->id])); ?>',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 800000,
                success: function (response) {
                    console.log(response.template);
                    $('#faq-list').empty().html(response.template);
                },
                complete: function () {
                    $("#faq-form")[0].reset();
                    toastr.success('<?php echo e(translate('successfully_added')); ?>')
                }
            });
        });

        $(".service-faq-update").on('click', function () {
            let id = $(this).data('id');
            ajax_post(id)
        })

        function ajax_post(form_id) {
            "use strict";

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#' + form_id)[0];
            var data = new FormData(form);
            let route = $('#' + form_id).attr('action');

            $.post({
                url: route,
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 800000,
                success: function (response) {
                    console.log(response.template);
                    $('#faq-list').empty().html(response.template);
                },
                complete: function () {
                    $("#faq-form")[0].reset();
                    toastr.success('<?php echo e(translate('successfully_updated')); ?>')
                }
            });
        }

        $(".faq-list-ajax-delete").on('click', function () {
            let route = $(this).data('route');
            ajax_delete(route)
        })

        function ajax_delete(route) {
            "use strict";

            Swal.fire({
                title: "<?php echo e(translate('are_you_sure')); ?>?",
                text: '<?php echo e(translate('want_to_delete_this_faq')); ?>',
                type: 'warning',
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
                            $('#faq-list').empty().html(response.template);
                            toastr.success('<?php echo e(translate('successfully_deleted')); ?>');
                        },
                        complete: function () {
                        },
                    });
                }
            })
        }

        $(".service-ajax-status-update").on('click', function () {
            let route = $(this).data('route');
            let id = $(this).data('id');
            ajax_status_update(route, id)
        })

        function ajax_status_update(route, id) {
            "use strict";
            Swal.fire({
                title: "<?php echo e(translate('are_you_sure')); ?>?",
                text: '<?php echo e(translate('want_to_update_status_of_this_faq')); ?>',
                type: 'warning',
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
                            toastr.success('<?php echo e(translate('successfully_updated')); ?>');
                        },
                        complete: function () {
                        },
                    });
                }
            })
        }

        $(".show-service-edit-section").on('click', function () {
            let id = $(this).data('id');
            $(`#edit-${id}`).toggle();
        })
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/ServiceManagement/Resources/views/admin/detail.blade.php ENDPATH**/ ?>