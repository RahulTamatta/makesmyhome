<?php $__env->startSection('title',translate('Offline payment list')); ?>

<?php $__env->startSection('content'); ?>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap mb-3">
                        <h2 class="page-title"><?php echo e(translate('Offline payment booking list')); ?></h2>
                    </div>
                    <div class="border border-danger-light bg-soft-danger rounded py-3 px-3 text-dark mb-3">
                        <span class="text-danger"># <?php echo e(translate('Note:')); ?> </span>
                            <span>
                            <?php echo e(translate('For offline payments please verify, If the payments are safely received to your account. Customer is not liable, If you confirm the bookings without checking payment transactions')); ?>

                        </span>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between">

                                <form action="<?php echo e(url()->current()); ?>?booking_status=<?php echo e($queryParams['booking_status']); ?>"
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
                                                   href="<?php echo e(route('admin.booking.download')); ?>?booking_status=<?php echo e($queryParams['booking_status']); ?>"><?php echo e(translate('excel')); ?></a>
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
                                <table id="example" class="table align-middle">
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
                                        <tr>
                                            <td><?php echo e($key+$bookings?->firstItem()); ?></td>
                                            <td>
                                                <a href="<?php echo e(route('admin.booking.details', [$booking->id,'web_page'=>'details'])); ?>">
                                                    <?php echo e($booking->readable_id); ?></a>
                                            </td>
                                            <td>
                                                <?php if($booking->service_location == 'provider'): ?>
                                                    <?php echo e(translate('Provider Location')); ?>

                                                <?php else: ?>
                                                    <?php echo e(translate('Customer Location')); ?>

                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div>
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
                                                </div>
                                                <?php echo e($booking->customer ? $booking?->customer?->phone : $booking?->service_address?->contact_person_number); ?>

                                            </td>
                                            <td><?php echo e(with_currency_symbol($booking->total_booking_amount)); ?></td>
                                            <td>
                                                <span
                                                    class="badge badge badge-<?php echo e($booking->is_paid?'success':'danger'); ?> radius-50">
                                                    <span class="dot"></span>
                                                    <?php echo e($booking->is_paid?translate('paid'):translate('unpaid')); ?>

                                                </span>
                                            </td>
                                            <td><?php echo e(date('d-M-Y h:ia',strtotime($booking->service_schedule))); ?></td>
                                            <td><?php echo e(date('d-M-Y h:ia',strtotime($booking->created_at))); ?></td>
                                            <td class="text-center">
                                                <label class="badge badge-info"><?php echo e(translate('pending')); ?></label>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex gap-2">
                                                    <a href="<?php echo e(route('admin.booking.details', [$booking->id,'web_page'=>'details'])); ?>"
                                                        type="button"
                                                        class="action-btn btn--light-primary fw-medium text-capitalize fz-14" style="--size: 30px">
                                                        <span class="material-icons m-0">visibility</span>
                                                    </a>
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
            <div class="filter-aside">
                <div class="filter-aside__header d-flex justify-content-between align-items-center">
                    <h3 class="filter-aside__title"><?php echo e(translate('Filter_your_Booking')); ?></h3>
                    <button type="button" class="btn-close p-2"></button>
                </div>
                <form action="<?php echo e(route('admin.booking.list', ['booking_status'=>$queryParams['booking_status']])); ?>" method="POST"
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

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/BookingModule/Resources/views/admin/booking/offline-payment-list.blade.php ENDPATH**/ ?>