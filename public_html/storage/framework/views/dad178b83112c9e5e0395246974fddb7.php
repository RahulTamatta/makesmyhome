<?php $__env->startSection('title', translate('Request_List')); ?>
<?php $__env->startPush('css_or_js'); ?>
    <style>
        .filter-aside__body {
            block-size: auto;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="filter-aside">
        <div class="filter-aside__header d-flex justify-content-between align-items-center">
            <h3 class="filter-aside__title"><?php echo e(translate('Filter_customized_booking')); ?></h3>
            <button type="button" class="btn-close p-2"></button>
        </div>
        <form action="<?php echo e(url()->current()); ?>?type=<?php echo e($type); ?>" method="POST" enctype="multipart/form-data" id="filter-form">
            <?php echo csrf_field(); ?>
            <div class="filter-aside__body d-flex flex-column">
                <div class="filter-aside__category_select">
                    <h4 class="fw-normal mb-2"><?php echo e(translate('Select_Categories')); ?></h4>
                    <div class="mb-30">
                        <select class="category-select theme-input-style w-100" name="category_id" id="category_selector__select">
                            <option value=""><?php echo e(translate('select_category')); ?></option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php echo e(($category->id == ($queryParams['category_id'] ?? '')) ? 'selected' : ''); ?>>
                                    <?php echo e($category->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="filter-aside__date_range">
                    <div class="filter-aside__zone_select">
                        <h4 class="mb-2 fw-normal"><?php echo e(translate('Select_Date_Range')); ?></h4>
                        <div class="mb-30">
                            <select class="date-select theme-input-style w-100" name="select_date" id="select_date">
                                <option value=""><?php echo e(translate('Select date')); ?></option>
                                <option value="today" <?php echo e((isset($queryParams['select_date']) && $queryParams['select_date'] == 'today') ? 'selected' : ''); ?>> <?php echo e(translate('Today')); ?></option>
                                <option value="this_week" <?php echo e((isset($queryParams['select_date']) && $queryParams['select_date'] == 'this_week') ? 'selected' : ''); ?>> <?php echo e(translate('This week')); ?></option>
                                <option value="this_month" <?php echo e((isset($queryParams['select_date']) && $queryParams['select_date'] == 'this_month') ? 'selected' : ''); ?>> <?php echo e(translate('This Month')); ?></option>
                                <option value="custom_range" <?php echo e((isset($queryParams['select_date']) && $queryParams['select_date'] == 'custom_range') ? 'selected' : ''); ?>> <?php echo e(translate('Custom Range')); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-30 custom-date-range" style="display: none;">
                        <div class="form-floating">
                            <input type="date" class="form-control" placeholder="<?php echo e(translate('start_date')); ?>" name="start_date" value="<?php echo e($queryParams['start_date'] ?? ''); ?>">
                            <label for="start_date"><?php echo e(translate('Start_Date')); ?></label>
                        </div>
                    </div>
                    <div class="fw-normal mb-30 custom-date-range" style="display: none;">
                        <div class="form-floating">
                            <input type="date" class="form-control" placeholder="<?php echo e(translate('end_date')); ?>" name="end_date" value="<?php echo e($queryParams['end_date'] ?? ''); ?>">
                            <label for="end_date"><?php echo e(translate('End_Date')); ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="filter-aside__bottom_btns">
                <div class="d-flex justify-content-center gap-20">
                    <button class="btn btn--secondary text-capitalize" id="reset-btn" type="reset"><?php echo e(translate('Clear_all_Filter')); ?></button>
                    <button class="btn btn--primary text-capitalize" type="submit"><?php echo e(translate('Filter')); ?></button>
                </div>
            </div>
        </form>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-wrap mb-3">
                    <h2 class="page-title"><?php echo e(translate('Customized Booking Requests')); ?></h2>
                </div>

                <div
                    class="d-flex flex-wrap justify-content-between align-items-center border-bottom mx-lg-4 mb-10 gap-3">
                    <ul class="nav nav--tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link <?php echo e($type=='all'?'active':''); ?>"
                               href="<?php echo e(url()->current()); ?>?type=all"><?php echo e(translate('All')); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e($type=='new_booking_request'?'active':''); ?>"
                               href="<?php echo e(url()->current()); ?>?type=new_booking_request"><?php echo e(translate('No-Bid Request Yet')); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e($type=='placed_offer'?'active':''); ?>"
                               href="<?php echo e(url()->current()); ?>?type=placed_offer"><?php echo e(translate('Already Bid Requested')); ?></a>
                        </li>
                    </ul>

                    <div class="d-flex gap-2 fw-medium">
                        <span class="opacity-75"><?php echo e(translate('Total Customized Booking')); ?> : </span>
                        <span class="title-color"><?php echo e($posts->total()); ?></span>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between">
                            <form action="<?php echo e(url()->current()); ?>?type=<?php echo e($type); ?>" method="POST"
                                  class="search-form search-form_style-two">
                                <?php echo csrf_field(); ?>
                                <div class="input-group search-form__input_group">
                                        <span class="search-form__icon">
                                            <span class="material-icons">search</span>
                                        </span>
                                    <input type="search" class="theme-input-style search-form__input fz-10"
                                           name="search"
                                           value="<?php echo e($search??''); ?>"
                                           placeholder="<?php echo e(translate('Search by customer info')); ?>">
                                </div>
                                <button type="submit" class="btn btn--primary text-capitalize">
                                    <?php echo e(translate('Search')); ?></button>
                            </form>
                            <div class="d-flex flex-wrap align-items-center gap-3">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('booking_export')): ?>
                                <div class="dropdown">
                                    <button type="button"
                                            class="btn btn--secondary text-capitalize dropdown-toggle"
                                            data-bs-toggle="dropdown">
                                        <span class="material-icons">file_download</span> <?php echo e(translate('download')); ?>

                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                        <li><a class="dropdown-item"
                                               href="<?php echo e(route('admin.booking.post.export', [
                                                    'type' => $type ?? '',
                                                    'search' => $search ?? '',
                                                    'category_id' => $category_id ?? '',
                                                    'select_date' => $select_date ?? '',
                                                    'start_date' => $start_date ?? '',
                                                    'end_date' => $end_date ?? ''
                                                ])); ?>">
                                                <?php echo e(translate('Excel')); ?>

                                            </a></li>

                                    </ul>
                                </div>
                                <?php endif; ?>
                                <button type="button" class="btn text-capitalize filter-btn border px-3">
                                    <span class="material-icons">filter_list</span> <?php echo e(translate('Filter')); ?>

                                    <span class="count"><?php echo e($filterCounter??0); ?></span>
                                </button>
                            </div>
                        </div>

                        <div class="select-table-wrap">
                            <div
                                class="multiple-select-actions gap-3 flex-wrap align-items-center justify-content-between">
                                <div class="d-flex align-items-center flex-wrap gap-2 gap-lg-4">
                                    <div class="ms-sm-1">
                                        <input type="checkbox" class="multi-checker">
                                    </div>
                                    <p><span class="checked-count">2</span> <?php echo e(translate('Item_Selected')); ?></p>
                                </div>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('booking_delete')): ?>
                                    <div class="d-flex align-items-center flex-wrap gap-3">
                                        <button class="btn btn--danger"
                                                id="multi-remove"><?php echo e(translate('Delete')); ?></button>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="table-responsive position-relative">
                                <table class="table align-middle multi-select-table multi-select-table-booking">
                                    <thead>
                                    <tr>
                                        <?php if($type == 'new_booking_request'): ?>
                                            <th></th>
                                        <?php endif; ?>
                                        <?php if($type != 'new_booking_request'): ?>
                                            <th><?php echo e(translate('Booking ID')); ?></th>
                                        <?php endif; ?>
                                        <th><?php echo e(translate('Customer Info')); ?></th>
                                        <th><?php echo e(translate('Booking Request Time')); ?></th>
                                        <th><?php echo e(translate('Service Time')); ?></th>
                                        <th><?php echo e(translate('Category')); ?></th>
                                        <th><?php echo e(translate('Provider Offering')); ?></th>
                                        <th class="text-center"><?php echo e(translate('Action')); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <?php if($type == 'new_booking_request'): ?>
                                                <td><input type="checkbox" class="multi-check" value="<?php echo e($post->id); ?>">
                                                </td>
                                            <?php endif; ?>
                                            <?php if($type != 'new_booking_request'): ?>
                                                <?php if($post->booking): ?>
                                                    <td>
                                                        <a href="<?php echo e(route('admin.booking.details', [$post?->booking->id,'web_page'=>'details'])); ?>"><?php echo e($post?->booking->readable_id); ?></a>
                                                    </td>
                                                <?php else: ?>
                                                    <td><small
                                                            class="badge-pill badge-primary"><?php echo e(translate('Not Booked Yet')); ?></small>
                                                    </td>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <td>
                                                <?php if($post->customer): ?>
                                                    <div>
                                                        <div class="customer-name fw-medium">
                                                            <?php echo e($post->customer?->first_name.' '.$post->customer?->last_name); ?>

                                                        </div>
                                                        <a href="tel:<?php echo e($post->customer?->phone); ?>"
                                                           class="fs-12"><?php echo e($post->customer?->phone); ?></a>
                                                    </div>
                                                <?php else: ?>
                                                    <div><small
                                                            class="disabled"><?php echo e(translate('Customer not available')); ?></small>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div>
                                                    <div><?php echo e($post->created_at->format('Y-m-d')); ?></div>
                                                    <div><?php echo e($post->created_at->format('h:ia')); ?></div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <div><?php echo e(date('d-m-Y',strtotime($post->booking_schedule))); ?></div>
                                                    <div><?php echo e(date('h:ia',strtotime($post->booking_schedule))); ?></div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if($post->category): ?>
                                                    <?php echo e($post->category?->name); ?>

                                                <?php else: ?>
                                                    <div><small
                                                            class="disabled"><?php echo e(translate('Category not available')); ?></small>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <?php ($bids = $post->bids); ?>
                                            <td>
                                                <div class="dropdown-hover">
                                                    <div class="dropdown-hover-toggle"
                                                         data-bs-toggle="dropdown">
                                                        <?php echo e($bids->count() ?? 0); ?> <?php echo e(translate('Providers')); ?>

                                                    </div>

                                                    <?php if($bids->count() > 0): ?>
                                                        <ul class="dropdown-hover-menu">
                                                            <?php $__currentLoopData = $bids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <li>
                                                                    <div class="media gap-3">
                                                                        <div class="avatar border rounded"
                                                                             data-bs-toggle="modal"
                                                                             data-bs-target="#providerInfoModal--<?php echo e($bid->id); ?>">
                                                                            <img class="rounded"
                                                                                 src="<?php echo e(onErrorImage(
                                                                                            $bid->provider?->logo,
                                                                                            asset('storage/app/public/provider/logo').'/' . $bid->provider?->logo,
                                                                                            asset('public/assets/admin-module/img/placeholder.png') ,
                                                                                            'provider/logo/')); ?>"
                                                                                 alt="<?php echo e(translate('logo')); ?>">
                                                                        </div>
                                                                        <div class="media-body">
                                                                            <?php if($bid->provider): ?>
                                                                                <h5 data-bs-toggle="modal"
                                                                                    data-bs-target="#providerInfoModal--<?php echo e($bid->id); ?>"><?php echo e($bid->provider->company_name); ?></h5>
                                                                            <?php else: ?>
                                                                                <small><?php echo e(translate('Provider not available')); ?></small>
                                                                            <?php endif; ?>
                                                                            <div
                                                                                class="d-flex gap-2 flex-wrap align-items-center fs-12 mt-1">
                                                                                            <span
                                                                                                class="text-danger"><?php echo e(translate('price offered')); ?></span>
                                                                                <h5 class="text-primary"><?php echo e(with_currency_symbol($bid->offered_price)); ?></h5>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </ul>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td class="d-flex gap-2 justify-content-center">
                                                <a href="<?php echo e(route('admin.booking.post.details', [$post->id])); ?>"
                                                   type="button"
                                                   class="action-btn btn--light-primary fw-medium text-capitalize fz-14"
                                                   style="--size: 30px">
                                                    <span class="material-icons">visibility</span>
                                                </a>

                                                <?php if(!$post->booking): ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('booking_delete')): ?>
                                                    <a type="button" class="action-btn btn--danger booking-deny"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#exampleModal--<?php echo e($post['id']); ?>"
                                                       style="--size: 30px">
                                                        <span class="material-symbols-outlined">delete</span>
                                                    </a>
                                                    <?php endif; ?>
                                                    <div class="modal fade" id="exampleModal--<?php echo e($post['id']); ?>"
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
                                                                             src="<?php echo e(asset('public/assets/admin-module/img/media/delete.png')); ?>"
                                                                             class="rounded-circle" alt="">
                                                                    </div>

                                                                    <h3 class="text-center mb-1 fw-medium"><?php echo e(translate('Are you sure you want to delete the post?')); ?></h3>
                                                                    <p class="text-center fs-12 fw-medium text-muted"><?php echo e(translate('You will lost the custom booking request?')); ?></p>
                                                                    <form method="post"
                                                                          action="<?php echo e(route('admin.booking.post.delete', [$post->id])); ?>">
                                                                        <?php echo csrf_field(); ?>
                                                                        <div class="form-floating">
                                                                            <textarea class="form-control h-69px"
                                                                                      placeholder="<?php echo e(translate('Cancellation Note')); ?>"
                                                                                      name="post_delete_note" required
                                                                                      id="add-your-notes"></textarea>
                                                                            <label for="add-your-notes"
                                                                                   class="d-flex align-items-center gap-1">
                                                                                <?php echo e(translate('Cancellation Note')); ?>

                                                                            </label>
                                                                        </div>
                                                                        <div
                                                                            class="d-flex justify-content-center gap-3 mt-3">
                                                                            <button type="button"
                                                                                    class="btn btn--secondary"
                                                                                    data-bs-dismiss="modal"><?php echo e(translate('cancel')); ?></button>
                                                                            <button type="submit"
                                                                                    class="btn btn-danger"><?php echo e(translate('Delete')); ?></button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                        </tr>

                                        <?php $__currentLoopData = $bids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="modal fade"
                                                 id="providerInfoModal--<?php echo e($bid->id); ?>" tabindex="-1"
                                                 aria-labelledby="providerInfoModalLabel"
                                                 aria-hidden="true">
                                                <div class="modal-dialog modal-lg bs-modal-width">
                                                    <div class="modal-content">
                                                        <div class="modal-header px-sm-4">
                                                            <h4 class="modal-title text-primary"
                                                                id="providerInfoModalLabel"><?php echo e(translate('Provider Information')); ?></h4>
                                                            <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body pb-4 px-lg-4">
                                                            <div
                                                                class="media flex-column flex-sm-row flex-wrap gap-3">
                                                                <img width="173" class="radius-10"
                                                                     src="<?php echo e(onErrorImage(
                                                                            $bid?->provider?->logo,
                                                                            asset('storage/app/public/provider/logo').'/' . $bid?->provider?->logo,
                                                                            asset('public/assets/placeholder.png') ,
                                                                            'provider/logo/')); ?>"
                                                                     alt="<?php echo e(translate('provider-logo')); ?>">
                                                                <div class="media-body">
                                                                    <h5 class="fw-medium mb-1"><?php echo e($bid->provider?->company_name); ?></h5>
                                                                    <div
                                                                        class="fs-12 d-flex flex-wrap align-items-center gap-2 mt-1">
                                                                            <span
                                                                                class="common-list_rating d-flex gap-1">
                                                                                <span
                                                                                    class="material-icons text-primary fs-12">star</span>
                                                                                <?php echo e($bid->provider?->avg_rating); ?>

                                                                            </span>
                                                                        <span><?php echo e($bid->provider?->rating_count); ?> <?php echo e(translate('Reviews')); ?></span>
                                                                    </div>

                                                                    <div
                                                                        class="d-flex gap-2 flex-wrap align-items-center fs-12 mt-1 mb-3">
                                                                            <span
                                                                                class="text-danger"><?php echo e(translate('Price Offered')); ?></span>
                                                                        <h4 class="text-primary"><?php echo e(with_currency_symbol($bid->offered_price)); ?></h4>
                                                                    </div>
                                                                    <?php if($bid->provider_note): ?>
                                                                        <h3 class="text-muted mb-2"><?php echo e(translate('Description')); ?>

                                                                            :</h3>
                                                                        <p><?php echo e($bid->provider_note); ?></p>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr class="text-center">
                                            <td colspan="7"><?php echo e(translate('No data available')); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <?php echo $posts->links(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function ($) {
            "use strict";

            $('#category_selector__select').on('change', function() {
                var selectedValues = $(this).val();
                if (selectedValues !== null && selectedValues.includes('all')) {
                    $(this).find('option').not(':disabled').prop('selected', 'selected');
                    $(this).find('option[value="all"]').prop('selected', false);
                }
            });

            $('.category-select').select2({
                placeholder: "<?php echo e(translate('Select Category')); ?>"
            });
            $('.date-select').select2({
                placeholder: "<?php echo e(translate('Select date range')); ?>"
            })

            $('#multi-remove').on('click', function () {
                var request_ids = [];
                $('input:checkbox.multi-check').each(function () {
                    if (this.checked) {
                        request_ids.push($(this).val());
                    }
                });

                Swal.fire({
                    title: "<?php echo e(translate('are_you_sure')); ?>?",
                    text: "<?php echo e(translate('Do you really want to remove the selected requests')); ?>?",
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
                            url: "<?php echo e(route('admin.booking.post.multi-remove')); ?>",
                            data: {
                                post_ids: request_ids,
                            },
                            type: 'post',
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

            $('#reset-btn').on('click', function() {
                $('#filter-form')[0].reset();
                $('.date-select').val([]).trigger('change');
                $('.category-select').val([]).trigger('change');
            });

            function toggleDateFields() {
                const selectedValue = $('#select_date').val();
                if (selectedValue === 'custom_range') {
                    $('.custom-date-range').show();
                } else {
                    $('.custom-date-range').hide();
                }
            }

            toggleDateFields();

            $('#select_date').change(function() {
                toggleDateFields();
            });

            $('#filter-form').on('submit', function(e) {

                if (selectDateValue === 'custom_range') {
                    const startDate = $('[name="start_date"]').val();
                    const endDate = $('[name="end_date"]').val();
                    if (!startDate || !endDate) {
                        e.preventDefault();
                        alert("Please select both a start date and an end date for the custom range.");
                    }
                }
            });

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/BidModule/Resources/views/admin/customize-list.blade.php ENDPATH**/ ?>