<?php $__env->startSection('title',translate('Booking_List')); ?>

<?php $__env->startSection('content'); ?>
    <div class="filter-aside">
        <div class="filter-aside__header d-flex justify-content-between align-items-center">
            <h3 class="filter-aside__title"><?php echo e(translate('Filter_your_Booking')); ?></h3>
            <button type="button" class="btn-close p-2"></button>
        </div>
        <form action="<?php echo e(url()->current()); ?>?booking_status=<?php echo e($queryParams['booking_status']); ?>&type=<?php echo e($queryParams['type']); ?>" method="POST"
              enctype="multipart/form-data" id="filter-form">
            <?php echo csrf_field(); ?>
            <div class="filter-aside__body d-flex flex-column">
                <div class="filter-aside__date_range">
                    <h4 class="fw-normal mb-4"><?php echo e(translate('Select_Date_Range')); ?></h4>
                    <div class="mb-30">
                        <div class="form-floating">
                            <input type="date" class="form-control" placeholder="<?php echo e(translate('start_date')); ?>"
                                   name="start_date"
                                   value="<?php echo e($queryParams['start_date']); ?>">
                            <label for="floatingInput"><?php echo e(translate('Start_Date')); ?></label>
                        </div>
                    </div>
                    <div class="fw-normal mb-30">
                        <div class="form-floating">
                            <input type="date" class="form-control" placeholder="<?php echo e(translate('end_date')); ?>"
                                   name="end_date"
                                   value="<?php echo e($queryParams['end_date']); ?>">
                            <label for="floatingInput"><?php echo e(translate('End_Date')); ?></label>
                        </div>
                    </div>
                </div>

                <div class="filter-aside__category_select">
                    <h4 class="fw-normal mb-2"><?php echo e(translate('Select_Categories')); ?></h4>
                    <div class="mb-30">
                        <select class="category-select theme-input-style w-100" name="category_ids[]"
                                multiple="multiple">
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option
                                    value="<?php echo e($category->id); ?>" <?php echo e(in_array($category->id,$queryParams['category_ids']??[])?'selected':''); ?>>
                                    <?php echo e($category->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="filter-aside__category_select">
                    <h4 class="fw-normal mb-2"><?php echo e(translate('Select_Sub_Categories')); ?></h4>
                    <div class="mb-30">
                        <select class="subcategory-select theme-input-style w-100" name="sub_category_ids[]"
                                multiple="multiple">
                            <?php $__currentLoopData = $subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option
                                    value="<?php echo e($subCategory->id); ?>" <?php echo e(in_array($subCategory->id,$queryParams['sub_category_ids']??[])?'selected':''); ?>>
                                    <?php echo e($subCategory->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="filter-aside__zone_select">
                    <h4 class="mb-2 fw-normal"><?php echo e(translate('Select_Zones')); ?></h4>
                    <div class="mb-30">
                        <select class="zone-select theme-input-style w-100" name="zone_ids[]" multiple="multiple">
                            <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option
                                    value="<?php echo e($zone->id); ?>" <?php echo e(in_array($zone->id,$queryParams['zone_ids']??[])?'selected':''); ?>>
                                    <?php echo e($zone->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="filter-aside__bottom_btns p-20">
                <div class="d-flex justify-content-center gap-20">
                    <button class="btn btn--secondary text-capitalize" id="reset-btn"
                            type="reset"><?php echo e(translate('Clear_all_Filter')); ?></button>
                    <button class="btn btn--primary text-capitalize" type="submit"><?php echo e(translate('Filter')); ?></button>
                </div>
            </div>
        </form>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap d-flex align-items-center justify-content-between gap-2 mb-3">
                        <h2 class="page-title"><?php echo e(translate('Verify_Request')); ?></h2>
                        <div class="ripple-animation" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php echo e(translate('This booking verification list is for verifying bookings whose total amount exceeds the maximum booking amount for cash on delivery
')); ?>" type="button">
                            <img src="<?php echo e(asset('/public/assets/admin-module/img/info.svg')); ?>" class="svg" alt="">
                        </div>
                    </div>

                    <div
                        class="d-flex flex-wrap justify-content-between align-items-center border-bottom mx-lg-4 mb-10 gap-3">
                        <ul class="nav nav--tabs">
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($type=='pending'?'active':''); ?>"
                                   href="<?php echo e(route('admin.booking.list.verification', ['booking_status'=>'pending', 'type' => 'pending'])); ?>">
                                    <?php echo e(translate('pending')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($type=='denied'?'active':''); ?>"
                                   href="<?php echo e(route('admin.booking.list.verification', ['booking_status'=>'pending', 'type' => 'denied'])); ?>">
                                    <?php echo e(translate('denied')); ?>

                                </a>
                            </li>
                        </ul>

                        <div class="d-flex gap-2 fw-medium">
                            <span class="opacity-75"><?php echo e(translate('Total_Request')); ?>:</span>
                            <span class="title-color"><?php echo e($bookings->total()); ?></span>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between">

                                <form action="<?php echo e(url()->current()); ?>?booking_status=<?php echo e($queryParams['booking_status']); ?>&type=<?php echo e($queryParams['type']); ?>"
                                      class="search-form search-form_style-two"
                                      method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="input-group search-form__input_group">
                                            <span class="search-form__icon">
                                                <span class="material-icons">search</span>
                                            </span>
                                        <input type="search" class="theme-input-style search-form__input"
                                               value="<?php echo e($queryParams['search']??''); ?>" name="search"
                                               placeholder="<?php echo e(translate('search_here')); ?>">
                                    </div>
                                    <button type="submit"
                                            class="btn btn--primary"><?php echo e(translate('search')); ?></button>
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
                                                   href="<?php echo e(route('admin.booking.download',$queryParams)); ?>"><?php echo e(translate('excel')); ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <?php endif; ?>

                                    <button type="button" class="btn text-capitalize filter-btn border px-3">
                                        <span class="material-icons">filter_list</span> <?php echo e(translate('Filter')); ?>

                                        <span class="count"><?php echo e($filterCounter??0); ?></span>
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="example" class="table align-middle tr-hover">
                                    <thead class="text-nowrap">
                                    <tr>
                                        <th><?php echo e(translate('SL')); ?></th>
                                        <th><?php echo e(translate('Booking_ID')); ?></th>
                                        <th><?php echo e(translate('Where_Service_will_be_Provided')); ?></th>
                                        <th><?php echo e(translate('Customer_Info')); ?></th>
                                        <th><?php echo e(translate('Total_Amount')); ?></th>
                                        <th><?php echo e(translate('Payment_Status')); ?></th>
                                        <th><?php echo e(translate('Schedule_Date')); ?></th>
                                        <th><?php echo e(translate('Booking_Date')); ?></th>
                                        <th><?php echo e(translate('Status')); ?></th>
                                        <th><?php echo e(translate('Action')); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr
                                            <?php if($booking->is_repeated): ?>
                                                data-bs-custom-class="review-tooltip custom"
                                            data-bs-toggle="tooltip"
                                            data-bs-html="true"
                                            data-bs-placement="bottom"
                                            data-bs-title="<?php echo e(translate('This is a repeat booking.')); ?> <br> <?php echo e(translate('Customer has requested total ')); ?> <?php echo e(count($booking->repeat)); ?><br> <?php echo e(translate('bookings under this Bookings.')); ?> <br> <?php echo e(translate('Check the details')); ?>"
                                            <?php endif; ?>
                                        >
                                            <td><?php echo e($key+$bookings?->firstItem()); ?></td>
                                            <td>
                                                <?php if($booking->is_repeated): ?>
                                                    <a href="<?php echo e(route('admin.booking.repeat_details', [$booking->id, 'web_page' => 'details'])); ?>">
                                                        <?php echo e($booking->readable_id); ?>

                                                    </a>
                                                    <img width="34" height="34"
                                                         src="<?php echo e(asset('public/assets/admin-module/img/icons/repeat.svg')); ?>"
                                                         class="rounded-circle repeat-icon"
                                                         alt="<?php echo e(translate('repeat')); ?>">
                                                <?php else: ?>
                                                    <a href="<?php echo e(route('admin.booking.details', [$booking->id, 'web_page' => 'details'])); ?>">
                                                        <?php echo e($booking->readable_id); ?></a>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($booking->service_location == 'provider'): ?>
                                                    <?php echo e(translate('Provider Location')); ?>

                                                <?php else: ?>
                                                    <?php echo e(translate('Customer Location')); ?>

                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column gap-1">
                                                    <?php if($booking->customer): ?>
                                                        <a href="<?php echo e(route('admin.customer.detail',[$booking?->customer?->id, 'web_page'=>'overview'])); ?>">
                                                            <?php
                                                                $fullName = ($booking?->customer?->first_name ?? '') . ' ' . ($booking?->customer?->last_name ?? '');
                                                                $limitedFullName = Str::limit($fullName, 30);
                                                            ?>

                                                            <?php echo e($limitedFullName); ?>

                                                        </a>
                                                    <?php else: ?>
                                                        <span>
                                                            <?php echo e(Str::limit($booking?->service_address?->contact_person_name, 30)); ?>

                                                        </span>
                                                    <?php endif; ?>
                                                    <a href="tel:<?php echo e($booking->customer ? $booking?->customer?->phone : $booking?->service_address?->contact_person_number); ?>"><?php echo e($booking->customer ? $booking?->customer?->phone : $booking?->service_address?->contact_person_number); ?></a>
                                                </div>
                                            </td>
                                            <td><?php echo e(with_currency_symbol($booking->total_booking_amount)); ?></td>
                                            <td>
                                                <span
                                                    class="badge badge badge-<?php echo e($booking->is_paid?'success':'danger'); ?> radius-50">
                                                    <span class="dot"></span>
                                                    <?php echo e($booking->is_paid?translate('paid'):translate('unpaid')); ?>

                                                </span>
                                            </td>
                                            <td>
                                                <?php if($booking->is_repeated): ?>
                                                    <span><?php echo e(translate('Next upcoming')); ?></span>
                                                    <div><?php echo e(date('d-M-Y', strtotime($booking?->nextService?->service_schedule))); ?></div>
                                                    <div><?php echo e(date('h:ia', strtotime($booking?->nextService?->service_schedule))); ?></div>
                                                <?php else: ?>
                                                    <div><?php echo e(date('d-M-Y', strtotime($booking->service_schedule))); ?></div>
                                                    <div><?php echo e(date('h:ia', strtotime($booking->service_schedule))); ?></div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column gap-1">
                                                    <div><?php echo e(date('d-M-Y',strtotime($booking->created_at))); ?></div>
                                                    <div><?php echo e(date('h:ia',strtotime($booking->created_at))); ?></div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if($booking->is_verified == '0'): ?>
                                                    <label class="badge badge-info bg-transparent p-0">
                                                        <span class="dot"></span>
                                                        <?php echo e(translate('pending')); ?>

                                                    </label>
                                                <?php elseif($booking->is_verified == '1'): ?>
                                                    <label class="badge badge-success bg-transparent p-0">
                                                        <span class="dot"></span>
                                                        <?php echo e(translate('verified')); ?>

                                                    </label>
                                                <?php else: ?>
                                                    <label class="badge badge-danger bg-transparent p-0">
                                                        <span class="dot"></span>
                                                        <?php echo e(translate('denied')); ?>

                                                    </label>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex gap-2">
                                                    <?php if($booking->is_repeated): ?>
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                    class="action-btn btn--light-primary fw-medium text-capitalize fz-14"
                                                                    style="--size: 30px" data-bs-toggle="dropdown">
                                                                <span class="material-icons">visibility</span>
                                                            </button>
                                                            <ul
                                                                class="dropdown-menu border-none dropdown-menu-lg dropdown-menu-right">
                                                                <li class="mx-2"><a
                                                                        class="dropdown-item d-flex align-items-center gap-1"
                                                                        href="<?php echo e(route('admin.booking.repeat_details', [$booking->id, 'web_page' => 'details'])); ?>">
                                                                                <span
                                                                                    class="material-icons">visibility</span>
                                                                        <?php echo e(translate('Full_Booking_Details')); ?>

                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    <?php else: ?>
                                                        <a href="<?php echo e(route('admin.booking.details', [$booking->id, 'web_page' => 'details'])); ?>"
                                                           type="button"
                                                           class="action-btn btn--light-primary fw-medium text-capitalize fz-14"
                                                           style="--size: 30px">
                                                            <span class="material-icons">visibility</span>
                                                        </a>
                                                    <?php endif; ?>
                                                    <?php if($booking->is_verified == '0'): ?>
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('booking_can_approve_or_deny')): ?>
                                                        <button type="button" data-verify="<?php echo e($booking->id); ?>" class="action-btn btn--success booking-verify" style="--size: 30px">
                                                            <span class="material-icons m-0">done_outline</span>
                                                        </button>

                                                        <button type="button" data-deny="<?php echo e($booking->id); ?>" style="--size: 30px"
                                                                class="action-btn btn--danger booking-deny"
                                                                data-bs-toggle="modal" data-bs-target="#exampleModal--<?php echo e($booking->id); ?>">
                                                            <span class="material-icons m-0">close</span>
                                                        </button>

                                                        <?php endif; ?>

                                                        <div class="modal fade" id="exampleModal--<?php echo e($booking->id); ?>" tabindex="-1"
                                                             aria-labelledby="exampleModalLabel--<?php echo e($booking->id); ?>" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-body pt-5 p-md-5">
                                                                        <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>

                                                                        <div class="d-flex justify-content-center mb-4">
                                                                            <img width="75" height="75" src="<?php echo e(asset('public/assets/admin-module/img/delete2.png')); ?>" class="rounded-circle" alt="">
                                                                        </div>

                                                                        <h3 class="text-start mb-1 fw-medium text-center"><?php echo e(translate('Are you sure you want to cancel the request?')); ?></h3>
                                                                        <p class="text-start fs-12 fw-medium text-muted text-center"><?php echo e(translate('You will lost the custom booking request?')); ?></p>
                                                                        <form method="post"
                                                                              action="<?php echo e(route('admin.booking.verification-status',[$booking->id])); ?>">
                                                                            <?php echo csrf_field(); ?>
                                                                            <div class="form-floating">
                                                                                <textarea class="form-control h-69px"
                                                                                          placeholder="<?php echo e(translate('Cancellation Note')); ?>"
                                                                                          name="booking_deny_note"
                                                                                          id="add-your-note" required></textarea>
                                                                                <label for="add-your-note"
                                                                                       class="d-flex align-items-center gap-1">
                                                                                    <?php echo e(translate('Cancellation Note')); ?>

                                                                                </label>
                                                                                <input type="hidden" value="deny" name="status">
                                                                                <div class="d-flex justify-content-center mt-3 gap-3">
                                                                                    <button type="button" data-bs-dismiss="modal"
                                                                                            aria-label="Close" class="btn btn--secondary min-w-92px px-2"><?php echo e(translate('Not Now')); ?></button>
                                                                                    <button type="submit" class="btn btn--danger min-w-92px"><?php echo e(translate('Yes')); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                <?php echo $bookings->links(); ?>

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
        (function ($) {
            "use strict";

            $('.category-select').select2({
                placeholder: "<?php echo e(translate('Select Category')); ?>"
            });
            $('.subcategory-select').select2({
                placeholder: "<?php echo e(translate('Select Subcategory')); ?>"
            });
            $('.zone-select').select2({
                placeholder: "<?php echo e(translate('Select Zone')); ?>"
            })

            $('.booking-verify').on('click', function () {
                let itemId = $(this).data('verify');
                let route = '<?php echo e(route('admin.booking.verification_status_update', [':itemId'])); ?>';
                route = route.replace(':itemId', itemId);
                route_alert_reload(route, '<?php echo e(translate('want_to_verified_this_booking')); ?>', true);
            })

        })(jQuery);
    </script>

    <script>
        $(document).ready(function() {
            $('#reset-btn').on('click', function() {
                $('#filter-form')[0].reset();
                $('.subcategory-select').val([]).trigger('change');
                $('.category-select').val([]).trigger('change');
                $('.zone-select').val([]).trigger('change');
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/BookingModule/Resources/views/admin/booking/verification-list.blade.php ENDPATH**/ ?>