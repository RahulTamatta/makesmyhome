<?php $__env->startSection('title', translate('Booking_List')); ?>

<?php $__env->startSection('content'); ?>
    <div class="filter-aside">
        <div class="filter-aside__header d-flex justify-content-between align-items-center">
            <h3 class="filter-aside__title"><?php echo e(translate('Filter_your_Booking')); ?></h3>
            <button type="button" class="btn-close p-2"></button>
        </div>
        <form action="<?php echo e(route('admin.booking.list', ['booking_status' => $queryParams['booking_status'], 'service_type' => $queryParams['service_type'], 'booking_type' => $queryParams['booking_type'], 'provider_assigned' => $queryParams['provider_assigned']])); ?>" method="POST"
            enctype="multipart/form-data" id="filter-form">
            <?php echo csrf_field(); ?>
            <div class="filter-aside__body d-flex flex-column">
                <div class="filter-aside__date_range">
                    <h4 class="fw-normal mb-4"><?php echo e(translate('Select_Date_Range')); ?></h4>
                    <div class="mb-30">
                        <div class="form-floating">
                            <input type="date" class="form-control" placeholder="<?php echo e(translate('start_date')); ?>"
                                name="start_date" value="<?php echo e($queryParams['start_date']); ?>">
                            <label for="floatingInput"><?php echo e(translate('Start_Date')); ?></label>
                        </div>
                    </div>
                    <div class="fw-normal mb-30">
                        <div class="form-floating">
                            <input type="date" class="form-control" placeholder="<?php echo e(translate('end_date')); ?>"
                                name="end_date" value="<?php echo e($queryParams['end_date']); ?>">
                            <label for="floatingInput"><?php echo e(translate('End_Date')); ?></label>
                        </div>
                    </div>
                </div>

                <div class="filter-aside__category_select">
                    <h4 class="fw-normal mb-2"><?php echo e(translate('Select_Categories')); ?></h4>
                    <div class="mb-30">
                        <select class="category-select theme-input-style w-100" name="category_ids[]" multiple="multiple"
                            id="category_selector__select">
                            <option value="all"><?php echo e(translate('Select All')); ?></option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>"
                                    <?php echo e(in_array($category->id, $queryParams['category_ids'] ?? []) ? 'selected' : ''); ?>>
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
                            multiple="multiple" id="sub_category_selector__select">
                            <option value="all"><?php echo e(translate('Select All')); ?></option>
                            <?php $__currentLoopData = $subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($subCategory->id); ?>"
                                    <?php echo e(in_array($subCategory->id, $queryParams['sub_category_ids'] ?? []) ? 'selected' : ''); ?>>
                                    <?php echo e($subCategory->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="filter-aside__zone_select">
                    <h4 class="mb-2 fw-normal"><?php echo e(translate('Select_Zones')); ?></h4>
                    <div class="mb-30">
                        <select class="zone-select theme-input-style w-100" name="zone_ids[]" multiple="multiple"
                            id="zone_selector__select">
                            <option value="all"><?php echo e(translate('Select All')); ?></option>
                            <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($zone->id); ?>"
                                    <?php echo e(in_array($zone->id, $queryParams['zone_ids'] ?? []) ? 'selected' : ''); ?>>
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
                    <div
                        class="page-title-wrap d-flex flex-wrap justify-content-between align-items-center border-bottom pb-2">
                        <h2 class="page-title"><?php echo e(translate('Booking_Request')); ?></h2>
                        <div class="d-flex gap-2 fw-medium">
                            <span class="opacity-75"><?php echo e(translate('Total_Request')); ?>:</span>
                            <span class="title-color"><?php echo e($bookings->total()); ?></span>
                        </div>
                    </div>
                    
                    <div class="mt-30 mb-30">
                        <ul class="nav nav--tabs nav--tabs__style2">
                            <li class="nav-item">
                                <a class="nav-link <?php echo e(request('service_type') === 'all' || !request('service_type') ? 'active' : ''); ?>"
                                   href="<?php echo e(url()->current()); ?>?booking_status=<?php echo e($queryParams['booking_status']); ?>&service_type=all">
                                    <?php echo e(translate('All Booking')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e(request('service_type') === 'regular' ? 'active' : ''); ?>"
                                   href="<?php echo e(url()->current()); ?>?booking_status=<?php echo e($queryParams['booking_status']); ?>&service_type=regular">
                                    <?php echo e(translate('Regular Booking')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e(request('service_type') === 'repeat' ? 'active' : ''); ?>"
                                   href="<?php echo e(url()->current()); ?>?booking_status=<?php echo e($queryParams['booking_status']); ?>&service_type=repeat">
                                    <?php echo e(translate('Repeat Booking')); ?>

                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between">

                                <form
                                    action="<?php echo e(url()->current()); ?>?booking_status=<?php echo e($queryParams['booking_status']); ?>&service_type=<?php echo e($queryParams['service_type']); ?>"
                                    class="search-form search-form_style-two" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="input-group search-form__input_group">
                                        <span class="search-form__icon">
                                            <span class="material-icons">search</span>
                                        </span>
                                        <input type="search" class="theme-input-style search-form__input"
                                            value="<?php echo e($queryParams['search'] ?? ''); ?>" name="search"
                                            placeholder="<?php echo e(translate('search_here')); ?>">
                                    </div>
                                    <button type="submit"
                                        class="btn btn--primary"><?php echo e(translate('search')); ?></button>
                                </form>
                                <div class="d-flex flex-wrap align-items-center gap-3">
                                    <?php if(request()->booking_status != 'ongoing' && request()->booking_status != 'accepted' && request()->booking_status != 'completed'): ?>
                                        <div>
                                            <select class="custom-select form-select" name="provider_assigned" id="providerAssigned">
                                                <option value="all" <?php echo e(request('provider_assigned') == 'all' ? 'selected' : ''); ?>><?php echo e(translate('All Booking')); ?></option>
                                                <option value="assigned" <?php echo e(request('provider_assigned') == 'assigned' ? 'selected' : ''); ?>><?php echo e(translate('Assigned')); ?></option>
                                                <option value="unassigned" <?php echo e(request('provider_assigned') == 'unassigned' ? 'selected' : ''); ?>><?php echo e(translate('Unassigned')); ?></option>
                                            </select>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('booking_export')): ?>
                                        <div class="dropdown">
                                            <button type="button"
                                                class="btn btn--secondary text-capitalize dropdown-toggle h-45"
                                                data-bs-toggle="dropdown">
                                                <span class="material-icons">file_download</span>
                                                <?php echo e(translate('download')); ?>

                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                                <li><a class="dropdown-item"
                                                        href="<?php echo e(route('admin.booking.download', $queryParams)); ?>"><?php echo e(translate('excel')); ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                    <button type="button" class="btn text-capitalize filter-btn border px-3">
                                        <span class="material-icons">filter_list</span> <?php echo e(translate('Filter')); ?>

                                        <span class="count"><?php echo e($filterCounter ?? 0); ?></span>
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="example" class="table align-middle tr-hover">
                                    <thead class="text-nowrap">
                                        <tr>
                                            <th><?php echo e(translate('SL')); ?></th>
                                            <th><?php echo e(translate('Booking_ID')); ?></th>
                                            <th><?php echo e(translate('Booking_Date')); ?></th>
                                            <th><?php echo e(translate('Where_Service_will_be_Provided')); ?></th>
                                            <th><?php echo e(translate('Schedule_Date')); ?></th>
                                            <th><?php echo e(translate('Customer_Info')); ?></th>
                                            <th><?php echo e(translate('Provider_Info')); ?></th>
                                            <th><?php echo e(translate('Total_Amount')); ?></th>
                                            <th><?php echo e(translate('Payment_Status')); ?></th>
                                            <th><?php echo e(translate('Action')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td
                                                    <?php if($booking->is_repeated): ?>
                                                        data-bs-custom-class="review-tooltip custom"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-html="true"
                                                        data-bs-placement="bottom"
                                                        data-bs-title="<?php echo e(translate('This is a repeat booking.')); ?> <br> <?php echo e(translate('Customer has requested total ')); ?> <?php echo e(count($booking->repeat)); ?><br> <?php echo e(translate('bookings under this Bookings.')); ?> <br> <?php echo e(translate('Check the details')); ?>"
                                                    <?php endif; ?>
                                                ><?php echo e($key + $bookings?->firstItem()); ?></td>
                                                <td
                                                    <?php if($booking->is_repeated): ?>
                                                        data-bs-custom-class="review-tooltip custom"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-html="true"
                                                        data-bs-placement="bottom"
                                                        data-bs-title="<?php echo e(translate('This is a repeat booking.')); ?> <br> <?php echo e(translate('Customer has requested total ')); ?> <?php echo e(count($booking->repeat)); ?><br> <?php echo e(translate('bookings under this Bookings.')); ?> <br> <?php echo e(translate('Check the details')); ?>"
                                                    <?php endif; ?>
                                                >
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
                                                <td
                                                    <?php if($booking->is_repeated): ?>
                                                        data-bs-custom-class="review-tooltip custom"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-html="true"
                                                        data-bs-placement="bottom"
                                                        data-bs-title="<?php echo e(translate('This is a repeat booking.')); ?> <br> <?php echo e(translate('Customer has requested total ')); ?> <?php echo e(count($booking->repeat)); ?><br> <?php echo e(translate('bookings under this Bookings.')); ?> <br> <?php echo e(translate('Check the details')); ?>"
                                                    <?php endif; ?>
                                                >
                                                    <div><?php echo e(date('d-M-Y', strtotime($booking->created_at))); ?></div>
                                                    <div><?php echo e(date('h:ia', strtotime($booking->created_at))); ?></div>
                                                </td>
                                                <td>
                                                    <?php if($booking->service_location == 'provider'): ?>
                                                        <?php echo e(translate('Provider Location')); ?>

                                                    <?php else: ?>
                                                        <?php echo e(translate('Customer Location')); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td
                                                    <?php if($booking->is_repeated): ?>
                                                        data-bs-custom-class="review-tooltip custom"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-html="true"
                                                        data-bs-placement="bottom"
                                                        data-bs-title="<?php echo e(translate('This is a repeat booking.')); ?> <br> <?php echo e(translate('Customer has requested total ')); ?> <?php echo e(count($booking->repeat)); ?><br> <?php echo e(translate('bookings under this Bookings.')); ?> <br> <?php echo e(translate('Check the details')); ?>"
                                                    <?php endif; ?>
                                                >
                                                    <?php if($booking->is_repeated): ?>
                                                        <?php if(empty($booking->nextService)): ?>
                                                            <div><?php echo e(date('d-M-Y', strtotime($booking?->lastRepeat?->service_schedule))); ?></div>
                                                            <div><?php echo e(date('h:ia', strtotime($booking?->lastRepeat?->service_schedule))); ?></div>
                                                        <?php else: ?>
                                                            <span><?php echo e(translate('Next upcoming')); ?></span>
                                                            <div><?php echo e(date('d-M-Y', strtotime($booking?->nextService?->service_schedule))); ?></div>
                                                            <div><?php echo e(date('h:ia', strtotime($booking?->nextService?->service_schedule))); ?></div>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <div><?php echo e(date('d-M-Y', strtotime($booking->service_schedule))); ?></div>
                                                        <div><?php echo e(date('h:ia', strtotime($booking->service_schedule))); ?></div>
                                                    <?php endif; ?>
                                                </td>
                                                <td
                                                    <?php if($booking->is_repeated): ?>
                                                        data-bs-custom-class="review-tooltip custom"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-html="true"
                                                        data-bs-placement="bottom"
                                                        data-bs-title="<?php echo e(translate('This is a repeat booking.')); ?> <br> <?php echo e(translate('Customer has requested total ')); ?> <?php echo e(count($booking->repeat)); ?><br> <?php echo e(translate('bookings under this Bookings.')); ?> <br> <?php echo e(translate('Check the details')); ?>"
                                                    <?php endif; ?>
                                                >
                                                    <div>
                                                        <?php if($booking->customer): ?>
                                                            <a
                                                                href="<?php echo e(route('admin.customer.detail', [$booking?->customer?->id, 'web_page' => 'overview'])); ?>">
                                                                <?php
                                                                    $fullName =
                                                                        ($booking?->customer?->first_name ?? '') .
                                                                        ' ' .
                                                                        ($booking?->customer?->last_name ?? '');
                                                                    $limitedFullName = Str::limit($fullName, 30);
                                                                ?>

                                                                <?php echo e($limitedFullName); ?>

                                                            </a>
                                                        <?php else: ?>
                                                            <span>
                                                                <?php echo e(Str::limit($booking?->service_address?->contact_person_name, 30)); ?>

                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php echo e($booking->customer ? $booking?->customer?->phone : $booking?->service_address?->contact_person_number); ?>

                                                </td>
                                                <td
                                                    <?php if($booking->is_repeated): ?>
                                                        data-bs-custom-class="review-tooltip custom"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-html="true"
                                                        data-bs-placement="bottom"
                                                        data-bs-title="<?php echo e(translate('This is a repeat booking.')); ?> <br> <?php echo e(translate('Customer has requested total ')); ?> <?php echo e(count($booking->repeat)); ?><br> <?php echo e(translate('bookings under this Bookings.')); ?> <br> <?php echo e(translate('Check the details')); ?>"
                                                    <?php endif; ?>
                                                >
                                                    <?php if(isset($booking->provider)): ?>
                                                        <div>
                                                            <a href="<?php echo e(route('admin.provider.details',[$booking->provider_id, 'web_page'=>'overview'])); ?>"><?php echo e($booking->provider->company_name); ?></a>
                                                        </div>
                                                        <span class="text-light-gray"><?php echo e($booking->provider->company_phone); ?></span>
                                                    <?php else: ?>
                                                        <span class="badge badge badge-danger radius-50">
                                                            <?php echo e(translate('unassigned')); ?>

                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td
                                                    <?php if($booking->is_repeated): ?>
                                                        data-bs-custom-class="review-tooltip custom"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-html="true"
                                                        data-bs-placement="bottom"
                                                        data-bs-title="<?php echo e(translate('This is a repeat booking.')); ?> <br> <?php echo e(translate('Customer has requested total ')); ?> <?php echo e(count($booking->repeat)); ?><br> <?php echo e(translate('bookings under this Bookings.')); ?> <br> <?php echo e(translate('Check the details')); ?>"
                                                    <?php endif; ?>
                                                ><?php echo e(with_currency_symbol($booking->total_booking_amount)); ?></td>
                                                <td
                                                    <?php if($booking->is_repeated): ?>
                                                        data-bs-custom-class="review-tooltip"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-html="true"
                                                        data-bs-placement="bottom"
                                                        data-bs-title="<?php echo e(translate('This is a repeat booking.')); ?> <br> <?php echo e(translate('Customer has requested total ')); ?> <?php echo e(count($booking->repeat)); ?><br> <?php echo e(translate('bookings under this Bookings.')); ?> <br> <?php echo e(translate('Check the details')); ?>"
                                                    <?php endif; ?>
                                                >
                                                    <span
                                                        class="badge badge badge-<?php echo e($booking->is_paid ? 'success' : 'danger'); ?> radius-50">
                                                        <span class="dot"></span>
                                                        <?php echo e($booking->is_paid ? translate('paid') : translate('unpaid')); ?>

                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="table-actions d-flex gap-2">
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
                                                                    <?php if($booking->nextServiceId && $booking['booking_status'] != 'pending'): ?>
                                                                    <li class="mx-2"><a
                                                                            class="dropdown-item d-flex align-items-center gap-1"
                                                                            href="<?php echo e(route('admin.booking.repeat_single_details', [$booking->nextServiceId, 'web_page' => 'details'])); ?>">
                                                                                <span
                                                                                    class="material-icons">visibility</span>
                                                                            <?php echo e(translate('Ongoing_Booking_Details')); ?>

                                                                        </a>
                                                                    </li>
                                                                    <?php endif; ?>
                                                                </ul>
                                                            </div>
                                                            <div class="dropdown">
                                                                <button type="button"
                                                                        class="action-btn btn--light-primary fw-medium text-capitalize fz-14"
                                                                        style="--size: 30px" data-bs-toggle="dropdown">
                                                                    <span class="material-icons">download</span>
                                                                </button>
                                                                <ul
                                                                    class="dropdown-menu border-none dropdown-menu-lg dropdown-menu-right">
                                                                    <li class="mx-2"><a
                                                                            class="dropdown-item d-flex align-items-center gap-1"
                                                                            target="_blank"
                                                                            href="<?php echo e(route('admin.booking.full_repeat_invoice', [$booking->id])); ?>">
                                                                                <span
                                                                                    class="material-icons">download</span>
                                                                            <?php echo e(translate('Full invoice')); ?>

                                                                        </a>
                                                                    </li>
                                                                    <?php if($booking->nextServiceId && $booking['booking_status'] != 'pending'): ?>
                                                                        <li class="mx-2">
                                                                            <a
                                                                                class="dropdown-item d-flex align-items-center gap-1"
                                                                                target="_blank"
                                                                                href="<?php echo e(route('admin.booking.single_invoice', [$booking->nextServiceId])); ?>">
                                                                                    <span
                                                                                        class="material-icons">download</span>
                                                                                <?php echo e(translate('Ongoing Booking invoice')); ?>

                                                                            </a>
                                                                        </li>
                                                                    <?php endif; ?>
                                                                </ul>
                                                            </div>
                                                        <?php else: ?>
                                                            <a href="<?php echo e(route('admin.booking.details', [$booking->id, 'web_page' => 'details'])); ?>"
                                                                type="button"
                                                                class="action-btn tooltip-hide btn--light-primary fw-medium text-capitalize fz-14"
                                                                style="--size: 30px">
                                                                <span class="material-icons">visibility</span>
                                                            </a>
                                                            <a href="<?php echo e(route('admin.booking.invoice', [$booking->id])); ?>"
                                                                type="button" target="_blank"
                                                                class="action-btn tooltip-hide btn--light-primary fw-medium text-capitalize fz-14"
                                                                style="--size: 30px">
                                                                <span class="material-icons">download</span>
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr class="text-center">
                                                <td colspan="8"><?php echo e(translate('no data available')); ?></td>
                                            </tr>
                                        <?php endif; ?>
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
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";

            $('#category_selector__select').on('change', function() {
                var selectedValues = $(this).val();
                if (selectedValues !== null && selectedValues.includes('all')) {
                    $(this).find('option').not(':disabled').prop('selected', 'selected');
                    $(this).find('option[value="all"]').prop('selected', false);
                }
            });

            $('#sub_category_selector__select').on('change', function() {
                var selectedValues = $(this).val();
                if (selectedValues !== null && selectedValues.includes('all')) {
                    $(this).find('option').not(':disabled').prop('selected', 'selected');
                    $(this).find('option[value="all"]').prop('selected', false);
                }
            });

            $('#zone_selector__select').on('change', function() {
                var selectedValues = $(this).val();
                if (selectedValues !== null && selectedValues.includes('all')) {
                    $(this).find('option').not(':disabled').prop('selected', 'selected');
                    $(this).find('option[value="all"]').prop('selected', false);
                }
            });

            $('.category-select').select2({
                placeholder: "<?php echo e(translate('Select Category')); ?>"
            });
            $('.subcategory-select').select2({
                placeholder: "<?php echo e(translate('Select Subcategory')); ?>"
            });
            $('.zone-select').select2({
                placeholder: "<?php echo e(translate('Select Zone')); ?>"
            })

            $('#providerAssigned').change(function() {
                var bookingStatus = '<?php echo e($queryParams['booking_status']); ?>';
                var serviceType = '<?php echo e($queryParams['service_type']); ?>';

                <?php if(isset($queryParams['search'])): ?>
                var search = '<?php echo e($queryParams['search']); ?>';
                <?php endif; ?>

                var providerAssigned = $(this).val();

                var baseUrl = '<?php echo e(route('admin.booking.list')); ?>';

                var params = new URLSearchParams({
                    provider_assigned: providerAssigned,
                    booking_status: bookingStatus,
                    service_type: serviceType,
                    <?php if(isset($queryParams['search'])): ?>
                    search: search,
                    <?php endif; ?>
                });

                var urlWithParams = baseUrl + '?' + params.toString();
                window.location.href = urlWithParams;
            });




        })(jQuery);
    </script>

    <script>
        $(document).ready(function() {
            // $('#reset-btn').on('click', function() {
            //     $('#filter-form')[0].reset();
            //     $('.subcategory-select').val([]).trigger('change');
            //     $('.category-select').val([]).trigger('change');
            //     $('.zone-select').val([]).trigger('change');
            // });

            $('#reset-btn').on('click', function() {
                let bookingStatus = '<?php echo e(request()->booking_status); ?>';
                let serviceType = '<?php echo e(request()->service_type); ?>';

                window.location.href = `<?php echo e(route('admin.booking.list')); ?>?booking_status=${bookingStatus}&service_type=${serviceType}`;
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/BookingModule/Resources/views/admin/booking/list.blade.php ENDPATH**/ ?>