<?php $__env->startSection('title', translate('Booking_Details')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module/plugins/swiper/swiper-bundle.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-title-wrap mb-3">
                <h2 class="page-title"><?php echo e(translate('Booking_Details')); ?> </h2>
            </div>

            <div class="pb-3 d-flex justify-content-between align-items-center gap-3 flex-wrap">
                <div>
                    <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                        <h3 class="c1 fw-bold"><?php echo e(translate('Booking')); ?> # <?php echo e($booking['readable_id']); ?></h3>
                        <span class="badge badge-<?php echo e($booking->booking_status == 'ongoing' ? 'warning' :
                            ($booking->booking_status == 'completed' ? 'success' :
                            ($booking->booking_status == 'canceled' ? 'danger' : 'info'))); ?>">
                            <?php echo e(ucwords($booking->booking_status)); ?>

                        </span>
                    </div>
                    <p class="opacity-75 fz-12"><?php echo e(translate('Booking_Placed')); ?>

                        : <?php echo e(date('d-M-Y h:ia', strtotime($booking->created_at))); ?></p>
                </div>
                <div class="d-flex flex-wrap flex-xxl-nowrap gap-3">
                    <div class="d-flex flex-wrap gap-3">
                        <?php ($maxBookingAmount = business_config('max_booking_amount', 'booking_setup')->live_values); ?>
                        <?php if(
                            $booking['payment_method'] == 'cash_after_service' &&
                                $booking->is_verified == '0' &&
                                $booking->total_booking_amount >= $maxBookingAmount): ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('booking_can_approve_or_deny')): ?>
                                <span class="btn btn--primary verify-booking-request" data-id="<?php echo e($booking->id); ?>"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal--<?php echo e($booking->id); ?>">
                                    <span class="material-icons">done</span>
                                    <?php echo e(translate('verify booking request')); ?>

                                </span>
                            <?php endif; ?>

                            <div class="modal fade" id="exampleModal--<?php echo e($booking->id); ?>" tabindex="-1"
                                aria-labelledby="exampleModalLabel--<?php echo e($booking->id); ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body p-4 py-5">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                            <div class="text-center mb-4 pb-3">
                                                <div class="text-center">
                                                    <img class="mb-4"
                                                        src="<?php echo e(asset('/public/assets/admin-module/img/booking-req-status.png')); ?>"
                                                        alt="">
                                                </div>
                                                <h3 class="mb-1 fw-medium">
                                                    <?php echo e(translate('Verify the booking request status?')); ?></h3>
                                                <p class="fs-12 fw-medium text-muted">
                                                    <?php echo e(translate('Need verification for max booking amount')); ?></p>
                                            </div>
                                            <form method="post"
                                                action="<?php echo e(route('admin.booking.verification-status', [$booking->id])); ?>">
                                                <?php echo csrf_field(); ?>
                                                <div class="c1-light-bg p-4 rounded">
                                                    <h5 class="mb-3"><?php echo e(translate('Request Status')); ?></h5>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        <div class="form-check-inline">
                                                            <input
                                                                class="form-check-input approve-request check-approve-status"
                                                                checked type="radio" name="status" id="inlineRadio1"
                                                                value="approve">
                                                            <label class="form-check-label"
                                                                for="inlineRadio1"><?php echo e(translate('Approve the Request')); ?></label>
                                                        </div>
                                                        <div class="form-check-inline">
                                                            <input class="form-check-input deny-request" type="radio"
                                                                name="status" id="inlineRadio2" value="deny">
                                                            <label class="form-check-label"
                                                                for="inlineRadio2"><?php echo e(translate('Deny the Request')); ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="mt-4 cancellation-note" style="display: none;">
                                                        <textarea class="form-control h-69px" placeholder="<?php echo e(translate('Cancellation Note ...')); ?>" name="booking_deny_note"
                                                            id="add-your-note"></textarea>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-center mt-4">
                                                    <button type="submit"
                                                        class="btn btn--primary"><?php echo e(translate('submit')); ?></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(
                            $booking['payment_method'] == 'cash_after_service' &&
                                $booking->is_verified == '2' &&
                                $booking->total_booking_amount >= $maxBookingAmount): ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('booking_can_manage_status')): ?>
                                <span class="btn btn--primary change-booking-request" data-id="<?php echo e($booking->id); ?>"
                                    data-bs-toggle="modal" data-bs-target="#exampleModals--<?php echo e($booking->id); ?>">
                                    <span class="material-icons">done</span><?php echo e(translate('Change Request Status')); ?>

                                </span>
                            <?php endif; ?>

                            <div class="modal fade" id="exampleModals--<?php echo e($booking->id); ?>" tabindex="-1"
                                aria-labelledby="exampleModalLabels--<?php echo e($booking->id); ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body pt-5 p-md-5">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                            <div class="text-center mb-4 pb-3">
                                                <img class="mb-4"
                                                    src="<?php echo e(asset('/public/assets/admin-module/img/booking-req-status.png')); ?>"
                                                    alt="">
                                                <h3 class="mb-1 fw-medium">
                                                    <?php echo e(translate('Verify the booking request status?')); ?></h3>
                                                <p class="text-start fs-12 fw-medium text-muted">
                                                    <?php echo e(translate('Need verification for max booking amount')); ?></p>
                                            </div>
                                            <form method="post"
                                                action="<?php echo e(route('admin.booking.verification-status', [$booking->id])); ?>">
                                                <?php echo csrf_field(); ?>

                                                <div class="c1-light-bg p-4 rounded">
                                                    <h5 class="mb-3"><?php echo e(translate('Request Status')); ?></h5>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        <div class="form-check-inline">
                                                            <input class="form-check-input approve-request" checked
                                                                type="radio" name="status" id="inlineRadio1"
                                                                value="approve">
                                                            <label class="form-check-label"
                                                                for="inlineRadio1"><?php echo e(translate('Approve the Request')); ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-center mt-4">
                                                    <button type="submit"
                                                        class="btn btn--primary"><?php echo e(translate('submit')); ?></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if(in_array($booking['booking_status'], ['accepted', 'ongoing']) && $booking->booking_partial_payments->isEmpty() && empty($booking->customizeBooking)): ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('booking_edit')): ?>
                                <button class="btn btn--primary" data-bs-toggle="modal"
                                    data-bs-target="#serviceUpdateModal--<?php echo e($booking['id']); ?>" data-toggle="tooltip"
                                    title="<?php echo e(translate('Add or remove services')); ?>">
                                    <span class="material-symbols-outlined">edit</span><?php echo e(translate('Edit Services')); ?>

                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                        <a href="<?php echo e(route('admin.booking.invoice', [$booking->id])); ?>" class="btn btn-primary"
                            target="_blank">
                            <span class="material-icons">description</span><?php echo e(translate('Invoice')); ?>

                        </a>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-wrap justify-content-between align-items-center flex-xxl-nowrap gap-3 mb-4">
                <ul class="nav nav--tabs nav--tabs__style2">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage == 'details' ? 'active' : ''); ?>"
                            href="<?php echo e(url()->current()); ?>?web_page=details"><?php echo e(translate('details')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage == 'status' ? 'active' : ''); ?>"
                            href="<?php echo e(url()->current()); ?>?web_page=status"><?php echo e(translate('status')); ?></a>
                    </li>
                </ul>
                <?php ($max_booking_amount = business_config('max_booking_amount', 'booking_setup')->live_values ?? 0); ?>

                <?php if($booking->is_verified == 2 && $booking->payment_method == 'cash_after_service' && $max_booking_amount <= $booking->total_booking_amount): ?>
                    <div class="border border-danger-light bg-soft-danger rounded py-3 px-3 text-dark">
                        <span class="text-danger"># <?php echo e(translate('Note: ')); ?></span>
                        <span><?php echo e($booking?->bookingDeniedNote?->value); ?></span>
                    </div>
                <?php endif; ?>

                <?php if($booking->is_verified == 0 && $booking->payment_method == 'cash_after_service' && $max_booking_amount <= $booking->total_booking_amount): ?>
                    <div class="border border-danger-light bg-soft-danger rounded py-3 px-3 text-dark">
                        <span class="text-danger"># <?php echo e(translate('Note: ')); ?></span>
                        <span>
                            <?php echo e(translate('You have to verify the booking because of maximum amount exceed')); ?>

                        </span>
                        <span><?php echo e($booking?->bookingDeniedNote?->value); ?></span>
                    </div>
                <?php endif; ?>

                <?php if($booking->booking_offline_payments->isNotEmpty() && $booking->payment_method == 'offline_payment' && $booking?->booking_offline_payments?->first()?->payment_status != 'approved'): ?>
                    <div class="border border-danger-light bg-soft-danger rounded py-3 px-3 text-dark">
                        <?php if($booking?->booking_offline_payments?->first()?->payment_status == 'pending'): ?>
                            <span>
                                <span class="text-danger fw-semibold"> # <?php echo e(translate('Note: ')); ?> </span>
                                <?php echo e(translate('Please Check & Verify the payment information weather it is correct or not before confirm the booking. ')); ?>

                            </span>
                        <?php endif; ?>
                            <?php if($booking?->booking_offline_payments?->first()?->payment_status == 'denied'): ?>
                                <span>
                                <span class="text-danger fw-semibold"> # <?php echo e(translate('Denied Note: ')); ?> </span>
                                <?php echo e($booking?->booking_offline_payments?->first()?->denied_note); ?>

                            </span>
                            <?php endif; ?>

                    </div>
                <?php endif; ?>

            </div>

            <div class="row gy-3">
                <div class="col-lg-8">
                    <div class="card mb-3">
                        <div class="card-body pb-5">
                            <div class="border-bottom pb-3 mb-3">
                                <div
                                    class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center gap-3 flex-wrap mb-40">
                                    <div>
                                        <h4 class="mb-2"><?php echo e(translate('Payment_Method')); ?></h4>
                                        <h5 class="c1 mb-2 fw-bold"><span
                                                class="text-capitalize"><?php echo e(str_replace(['_', '-'], ' ', $booking->payment_method)); ?>

                                                <?php if($booking->payment_method == 'offline_payment' && $booking?->booking_offline_payments?->first()?->method_name): ?>
                                                    (<?php echo e($booking?->booking_offline_payments?->first()?->method_name); ?>)
                                                <?php endif; ?>
                                            </span>
                                        </h5>
                                        <p>
                                            <span><?php echo e(translate('Amount')); ?> : </span>
                                            <span
                                                class="c1"><?php echo e(with_currency_symbol($booking->total_booking_amount)); ?></span>
                                        </p>
                                    </div>
                                    <div class="text-start text-sm-end">
                                        <?php if($booking->payment_method == 'offline_payment' && $booking->booking_offline_payments->isNotEmpty()): ?>
                                            <p class="mb-2"><span><?php echo e(translate('Request Verify Status')); ?> :</span>
                                                <?php if($booking->booking_offline_payments?->first()?->payment_status == 'pending'): ?>
                                                    <span class="text-info text-capitalize fw-bold"><?php echo e(translate('Pending')); ?></span>
                                                <?php endif; ?>
                                                <?php if($booking->booking_offline_payments?->first()?->payment_status == 'denied'): ?>
                                                    <span class="text-danger text-capitalize fw-bold"><?php echo e(translate('Denied')); ?></span>
                                                <?php endif; ?>
                                                <?php if($booking->booking_offline_payments?->first()?->payment_status == 'approved'): ?>
                                                    <span class="text-primary text-capitalize fw-bold"><?php echo e(translate('Approved')); ?></span>
                                                <?php endif; ?>
                                            </p>
                                        <?php endif; ?>

                                        <?php if(
                                            $booking->is_verified == '0' &&
                                                $booking->payment_method == 'cash_after_service' &&
                                                $booking->total_booking_amount >= $maxBookingAmount): ?>
                                            <p class="mb-2"><span><?php echo e(translate('Request Verify Status:')); ?> :</span>
                                                <span class="c1 text-capitalize"><?php echo e(translate('Pending')); ?></span>
                                            </p>
                                        <?php elseif(
                                            $booking->is_verified == '2' &&
                                                $booking->payment_method == 'cash_after_service' &&
                                                $booking->total_booking_amount >= $maxBookingAmount): ?>
                                            <p class="mb-2"><span><?php echo e(translate('Request Verify Status:')); ?> :</span>
                                                <span class="text-danger text-capitalize"
                                                    id="booking_status__span"><?php echo e(translate('Denied')); ?></span>
                                            </p>
                                        <?php endif; ?>

                                        <p class="mb-2">
                                            <span><?php echo e(translate('Payment_Status')); ?> : </span>
                                            <span class="ms-3 badge badge-<?php echo e($booking->is_paid ? 'success' : 'danger'); ?>"
                                                id="payment_status__span"><?php echo e($booking->is_paid ? translate('Paid') : translate('Unpaid')); ?></span>
                                            <?php if(!$booking->is_paid && $booking->booking_partial_payments->isNotEmpty()): ?>
                                                <span
                                                    class="small badge badge-info text-success p-1 fz-10"><?php echo e(translate('Partially paid')); ?></span>
                                            <?php endif; ?>
                                        </p>
                                        <p class="mb-2"><span><?php echo e(translate('Booking_Otp')); ?> :</span> <span
                                                class="c1 text-capitalize"><?php echo e($booking?->booking_otp ?? ''); ?></span></p>
                                        <h5 class="d-flex gap-1 flex-wrap align-items-center">
                                            <div><?php echo e(translate('Schedule_Date')); ?> :</div>
                                            <div id="service_schedule__span">
                                                <div><?php echo e(date('d-M-Y h:ia', strtotime($booking->service_schedule))); ?> <span
                                                        class="text-secondary"><?php echo e($booking?->schedule_histories->count() > 1 ? '(' . translate('Edited') . ')' : ''); ?></span>
                                                </div>

                                                <div class="timeline-container">
                                                    <ul class="timeline-sessions">
                                                        <p class="fs-14"><?php echo e(translate('Schedule Change Log')); ?></p>
                                                        <?php $__currentLoopData = $booking?->schedule_histories()->orderBy('created_at', 'desc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li
                                                                class="<?php echo e($booking->service_schedule == $history->schedule ? 'active' : ''); ?>">
                                                                <div class="timeline-date">
                                                                    <?php echo e(\Carbon\Carbon::parse($history->schedule)->format('d-M-Y')); ?>

                                                                </div>
                                                                <div class="timeline-time">
                                                                    <?php echo e(\Carbon\Carbon::parse($history->schedule)->format('h:i A')); ?>

                                                                </div>
                                                            </li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-start gap-2">
                                <h3 class="mb-3"><?php echo e(translate('Booking_Summary')); ?></h3>
                            </div>

                            <div class="table-responsive border-bottom">
                                <table class="table text-nowrap align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th class="ps-lg-3"><?php echo e(translate('Service')); ?></th>
                                            <th><?php echo e(translate('Price')); ?></th>
                                            <th><?php echo e(translate('Qty')); ?></th>
                                            <th><?php echo e(translate('Discount')); ?></th>
                                            <th><?php echo e(translate('Vat')); ?></th>
                                            <th class="text--end"><?php echo e(translate('Total')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php ($subTotal = 0); ?>
                                        <?php $__currentLoopData = $booking->detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="text-wrap ps-lg-3">
                                                    <?php if(isset($detail->service)): ?>
                                                        <div class="d-flex flex-column">
                                                            <a href="<?php echo e(route('admin.service.detail', [$detail->service->id])); ?>"
                                                                class="fw-bold"><?php echo e(Str::limit($detail->service->name, 30)); ?></a>
                                                            <div class="text-capitalize">
                                                                <?php echo e(Str::limit($detail ? $detail->variant_key : '', 50)); ?>

                                                            </div>
                                                            <?php if($detail->overall_coupon_discount_amount > 0): ?>
                                                                <small
                                                                    class="fz-10 text-capitalize"><?php echo e(translate('coupon_discount')); ?>

                                                                    :
                                                                    -<?php echo e(with_currency_symbol($detail->overall_coupon_discount_amount)); ?></small>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php else: ?>
                                                        <span
                                                            class="badge badge-pill badge-danger"><?php echo e(translate('Service_unavailable')); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e(with_currency_symbol($detail->service_cost)); ?></td>
                                                <td>
                                                    <span><?php echo e($detail->quantity); ?></span>
                                                </td>
                                                <td>
                                                    <?php if($detail?->discount_amount > 0): ?>
                                                        <?php echo e(with_currency_symbol($detail->discount_amount)); ?>

                                                    <?php elseif($detail?->campaign_discount_amount > 0): ?>
                                                        <?php echo e(with_currency_symbol($detail->campaign_discount_amount)); ?>

                                                        <br><span
                                                            class="fz-12 text-capitalize"><?php echo e(translate('campaign')); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e(with_currency_symbol($detail->tax_amount)); ?></td>
                                                <td class="text--end"><?php echo e(with_currency_symbol($detail->total_cost)); ?></td>
                                            </tr>
                                            <?php ($subTotal += $detail->service_cost * $detail->quantity); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row justify-content-end mt-3">
                                <div class="col-sm-10 col-md-6 col-xl-5">
                                    <div class="table-responsive">
                                        <table class="table-md title-color align-right w-100">
                                            <tbody>
                                                <tr>
                                                    <td class="text-capitalize"><?php echo e(translate('service_amount')); ?> <small
                                                            class="fz-12">(<?php echo e(translate('Vat_Excluded')); ?>)</small></td>
                                                    <td class="text--end pe--4"><?php echo e(with_currency_symbol($subTotal)); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize"><?php echo e(translate('service_discount')); ?></td>
                                                    <td class="text--end pe--4">
                                                        <?php echo e(with_currency_symbol($booking->total_discount_amount)); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize"><?php echo e(translate('coupon_discount')); ?></td>
                                                    <td class="text--end pe--4">
                                                        <?php echo e(with_currency_symbol($booking->total_coupon_discount_amount)); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize"><?php echo e(translate('campaign_discount')); ?></td>
                                                    <td class="text--end pe--4">
                                                        <?php echo e(with_currency_symbol($booking->total_campaign_discount_amount)); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize"><?php echo e(translate('Referral Discount')); ?></td>
                                                    <td class="text--end pe--4">
                                                        <?php echo e(with_currency_symbol($booking->total_referral_discount_amount)); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize"><?php echo e(translate('vat_/_tax')); ?></td>
                                                    <td class="text--end pe--4">
                                                        <?php echo e(with_currency_symbol($booking->total_tax_amount)); ?></td>
                                                </tr>
                                                <?php if($booking->extra_fee > 0): ?>
                                                    <?php ($additional_charge_label_name = business_config('additional_charge_label_name', 'booking_setup')->live_values ?? 'Fee'); ?>
                                                    <tr>
                                                        <td class="text-capitalize"><?php echo e($additional_charge_label_name); ?>

                                                        </td>
                                                        <td class="text--end pe--4">
                                                            <?php echo e(with_currency_symbol($booking->extra_fee)); ?></td>
                                                    </tr>
                                                <?php endif; ?>

                                                <tr>
                                                    <td><strong><?php echo e(translate('Grand_Total')); ?></strong></td>
                                                    <td class="text--end pe--4">
                                                        <strong><?php echo e(with_currency_symbol($booking->total_booking_amount)); ?></strong>
                                                    </td>
                                                </tr>

                                                <?php if($booking->booking_partial_payments->isNotEmpty()): ?>
                                                    <?php $__currentLoopData = $booking->booking_partial_payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e(translate('Paid_by')); ?>

                                                                <?php echo e(str_replace('_', ' ', $partial->paid_with)); ?></td>
                                                            <td class="text--end pe--4">
                                                                <?php echo e(with_currency_symbol($partial->paid_amount)); ?></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>

                                                <?php
                                                $dueAmount = 0;

                                                if (!$booking->is_paid && $booking?->booking_partial_payments?->count() == 1) {
                                                    $dueAmount = $booking->booking_partial_payments->first()?->due_amount;
                                                }

                                                if (in_array($booking->booking_status, ['pending', 'accepted', 'ongoing']) && $booking->payment_method != 'cash_after_service' && $booking->additional_charge > 0) {
                                                    $dueAmount += $booking->additional_charge;
                                                }

                                                if (!$booking->is_paid && $booking->payment_method == 'cash_after_service') {
                                                    $dueAmount = $booking->total_booking_amount;
                                                }
                                                ?>

                                                <?php if($dueAmount > 0): ?>
                                                    <tr>
                                                        <td><?php echo e(translate('Due_Amount')); ?></td>
                                                        <td class="text--end pe--4">
                                                            <?php echo e(with_currency_symbol($dueAmount)); ?></td>
                                                    </tr>
                                                <?php endif; ?>

                                                <?php if($booking->payment_method != 'cash_after_service' && $booking->additional_charge < 0): ?>
                                                    <tr>
                                                        <td><?php echo e(translate('Refund')); ?></td>
                                                        <td class="text--end pe--4">
                                                            <?php echo e(with_currency_symbol(abs($booking->additional_charge))); ?>

                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="c1"><?php echo e(translate('Booking Setup')); ?></h3>
                            <hr>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('booking_can_manage_status')): ?>
                                <div class="d-flex justify-content-between align-items-center gap-10 form-control h-45">
                                    <span class="title-color"><?php echo e(translate('Payment Status')); ?></span>

                                    <div class="on-off-toggle">
                                        <input class="on-off-toggle__input switcher_input"
                                            value="<?php echo e($booking['is_paid'] ? '1' : '0'); ?>"
                                            <?php echo e($booking['is_paid'] ? 'checked' : ''); ?> type="checkbox"
                                            id="payment_status" />
                                        <label for="payment_status" class="on-off-toggle__slider">
                                            <span class="on-off-toggle__on">
                                                <span class="on-off-toggle__text"><?php echo e(translate('Paid')); ?></span>
                                                <span class="on-off-toggle__circle"></span>
                                            </span>
                                            <span class="on-off-toggle__off">
                                                <span class="on-off-toggle__circle"></span>
                                                <span class="on-off-toggle__text"><?php echo e(translate('Unpaid')); ?></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('booking_can_manage_status')): ?>
                                <div class="mt-3">
                                    <?php if($booking->booking_status != 'pending'): ?>
                                        <select class="js-select without-search" id="booking_status">
                                            <option value="0" disabled
                                                <?php echo e($booking['booking_status'] == 'accepted' ? 'selected' : ''); ?>>
                                                <?php echo e(translate('Booking_Status')); ?>: <?php echo e(translate('Accepted')); ?></option>
                                            <option value="ongoing"
                                                <?php echo e($booking['booking_status'] == 'ongoing' ? 'selected' : ''); ?>>
                                                <?php echo e(translate('Booking_Status')); ?>: <?php echo e(translate('Ongoing')); ?></option>
                                            <option value="completed"
                                                <?php echo e($booking['booking_status'] == 'completed' ? 'selected' : ''); ?>>
                                                <?php echo e(translate('Booking_Status')); ?>: <?php echo e(translate('Completed')); ?></option>
                                            <?php if($booking->booking_status != 'completed'): ?>
                                            <option value="canceled"
                                                <?php echo e($booking['booking_status'] == 'canceled' ? 'selected' : ''); ?>>
                                                <?php echo e(translate('Booking_Status')); ?>: <?php echo e(translate('Canceled')); ?></option>
                                            <?php endif; ?>
                                        </select>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <div class="mt-3">
                                <?php if(!in_array($booking->booking_status, ['ongoing', 'completed'])): ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('booking_can_manage_status')): ?>
                                        <input type="datetime-local" class="form-control h-45" name="service_schedule"
                                            value="<?php echo e($booking->service_schedule); ?>" id="service_schedule"
                                            onchange="service_schedule_update()">
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>


                            <?php if($booking->payment_method == 'offline_payment'): ?>
                                <div class="mt-3 border border-color-primary">
                                    <div class="card text-center">
                                        <div class="card-header">
                                            <h5 class="font-weight-bold"><?php echo e(translate('Verification of Offline Payment')); ?></h5>
                                        </div>
                                        <div class="card-body">
                                            <?php if($booking->booking_offline_payments->isNotEmpty()): ?>
                                                <div class="d-flex gap-1 flex-column">
                                                    <?php ($offlinePaymentNote = ''); ?>
                                                    <?php $__currentLoopData = $booking?->booking_offline_payments?->first()?->customer_information ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="d-flex gap-2">
                                                            <?php if($key != 'payment_note' ): ?>
                                                                <span class="w-100px d-flex justify-content-start"><?php echo e(translate($key)); ?></span>
                                                                <span>: <?php echo e(translate($item)); ?></span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <?php
                                                            if ($key == 'payment_note' ){
                                                                $offlinePaymentNote = $item;
                                                            }
                                                        ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                                <?php if($offlinePaymentNote != ''): ?>
                                                    <div class="badge-warning px-3 py-3 rounded title-color mt-3">
                                                        <span>
                                                            <span class="fw-semibold"> # <?php echo e(translate('Payment Note')); ?>:  </span>
                                                            <?php echo e($offlinePaymentNote); ?>

                                                        </span>
                                                    </div>
                                               <?php endif; ?>

                                                <?php if($booking->booking_offline_payments?->first()?->payment_status == 'pending'): ?>
                                                    <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
                                                        <button class="btn badge-danger flex-grow-1 py-3" data-bs-toggle="modal"
                                                                data-bs-target="#deniedModal-<?php echo e($booking->id); ?>"><?php echo e(translate('deny')); ?></button>
                                                        <button class="btn badge-info flex-grow-1 py-3 offline-payment"><?php echo e(translate('approve')); ?></button>
                                                    </div>
                                                <?php elseif($booking->booking_offline_payments?->first()?->payment_status == 'denied'): ?>
                                                    <?php if($booking['booking_status'] != 'canceled'): ?>
                                                        <div class="d-flex flex-column gap-2 mt-4">
                                                            <button class="btn badge-info w-100 py-3 switch-to-cash-after-service"><?php echo e(translate('Switch to Cash after Service')); ?></button>
                                                            <button class="btn badge-danger w-100 py-3 change-booking-status"><?php echo e(translate('Cancel Booking')); ?></button>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endif; ?>

                                            <?php else: ?>
                                                <img src="<?php echo e(asset('public/assets/admin-module/img/offline-payment.png')); ?>" alt="Payment Icon" class="mb-3">
                                                <p class="text-muted"><?php echo e(translate('Customer did not submit any payment information yet')); ?></p>
                                                <?php if($booking['booking_status'] != 'canceled'): ?>
                                                    <div class="d-flex flex-column gap-2 mt-4">
                                                        <button class="btn badge-info w-100 py-3 switch-to-cash-after-service"><?php echo e(translate('Switch to Cash after Service')); ?></button>
                                                        <button class="btn badge-danger w-100 py-3 change-booking-status"><?php echo e(translate('Cancel Booking')); ?></button>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="py-3 d-flex flex-column gap-3 mb-2">
                                <?php if($booking->evidence_photos): ?>
                                    <div class="c1-light-bg radius-10 py-3 px-4">
                                        <div class="d-flex justify-content-start gap-2">
                                            <h4 class="mb-2"><?php echo e(translate('uploaded_Images')); ?></h4>
                                        </div>

                                        <div class="py-3 px-4">
                                            <div class="d-flex flex-wrap gap-3 justify-content-lg-start">
                                                <?php $__currentLoopData = $booking->evidence_photos_full_path ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <img width="100" class="max-height-100"
                                                        src="<?php echo e($img); ?>"
                                                        alt="<?php echo e(translate('evidence-photo')); ?>" <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php ($serviceAtProviderPlace = (int)((business_config('service_at_provider_place', 'provider_config'))->live_values ?? 0)); ?>
                                <div class="c1-light-bg radius-10">
                                    <div class="border-bottom d-flex align-items-center justify-content-between gap-2 py-3 px-4 mb-2">
                                        <h4 class="d-flex align-items-center gap-2">
                                            <span class="material-icons title-color">map</span>
                                            <?php echo e(translate('Service_location')); ?>

                                        </h4>
                                        <?php if($serviceAtProviderPlace == 1): ?>
                                            <?php if($booking->provider_id): ?>
                                                <?php ($serviceLocation = getProviderSettings(providerId: $booking->provider_id, key: 'service_location', type: 'provider_config')); ?>
                                                <?php if(in_array('customer', $serviceLocation) && in_array('provider', $serviceLocation)): ?>
                                                    <div class="btn-group">
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('booking_edit')): ?>
                                                            <div data-bs-toggle="modal"
                                                                 data-bs-target="#serviceLocationModal--<?php echo e($booking['id']); ?>"
                                                                 data-toggle="tooltip" data-placement="top">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <span class="material-symbols-outlined">edit_square</span>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <div class="btn-group">
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('booking_edit')): ?>
                                                        <div data-bs-toggle="modal"
                                                             data-bs-target="#serviceLocationModal--<?php echo e($booking['id']); ?>"
                                                             data-toggle="tooltip" data-placement="top">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="material-symbols-outlined">edit_square</span>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>

                                    <div class="py-3 px-4">
                                        <?php if($booking->service_location == 'provider'): ?>
                                            <div class="bg-warning p-3 rounded">
                                                <h5><?php echo e(translate('Customer has to go to the Provider Location to receive the service')); ?></h5>
                                            </div>
                                            <div class="mt-3">
                                                <?php if($booking->provider_id != null): ?>
                                                    <?php if($booking->provider): ?>
                                                        <h5 class="mb-1"><?php echo e(translate('Service Location')); ?>:</h5>
                                                        <div class="d-flex justify-content-between">
                                                            <p><?php echo e(Str::limit($booking?->provider?->company_address ?? translate('not_available'), 100)); ?></p>
                                                            <span class="material-icons">map</span>
                                                        </div>
                                                    <?php else: ?>
                                                        <p><?php echo e(translate('Provider Unavailable')); ?></p>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <h5 class="mb-1"><?php echo e(translate('Service Location')); ?>:</h5>
                                                    <p><?php echo e(translate('The Service Location will be available after this booking accepts or assign to a provider')); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="bg-warning p-3 rounded">
                                                <h5><?php echo e(translate('Provider has to go to the Customer Location to provide the service')); ?></h5>
                                            </div>
                                            <div class="mt-3">
                                                <h5 class="mb-1"><?php echo e(translate('Service Location')); ?>:</h5>
                                                <div class="d-flex justify-content-between">
                                                    <p><?php echo e(Str::limit($booking?->service_address?->address ?? translate('not_available'), 100)); ?></p>
                                                    <span class="material-icons">map</span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="c1-light-bg radius-10">
                                    <div class="border-bottom d-flex align-items-center justify-content-between gap-2 py-3 px-4 mb-2">
                                        <h4 class="d-flex align-items-center gap-2">
                                            <span class="material-icons title-color">person</span>
                                            <?php echo e(translate('Customer_Information')); ?>

                                        </h4>

                                        <div class="btn-group">
                                            <?php if(in_array($booking->booking_status, ['completed', 'cancelled'])): ?>
                                                <?php if(!$booking?->is_guest): ?>
                                                    <div
                                                        class="d-flex align-items-center gap-2 cursor-pointer customer-chat">
                                                        <span class="material-symbols-outlined">chat</span>
                                                        <form action="<?php echo e(route('admin.chat.create-channel')); ?>"
                                                            method="post" id="chatForm-<?php echo e($booking->id); ?>">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="customer_id"
                                                                value="<?php echo e($booking?->customer?->id); ?>">
                                                            <input type="hidden" name="type" value="booking">
                                                            <input type="hidden" name="user_type" value="customer">
                                                        </form>
                                                    </div>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <div class="cursor-pointer" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <span class="material-symbols-outlined">more_vert</span>
                                                </div>
                                                <ul
                                                    class="dropdown-menu dropdown-menu__custom border-none dropdown-menu-end">
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('booking_edit')): ?>
                                                        <li data-bs-toggle="modal"
                                                            data-bs-target="#serviceAddressModal--<?php echo e($booking['id']); ?>"
                                                            data-toggle="tooltip" data-placement="top">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="material-symbols-outlined">edit_square</span>
                                                                <?php echo e(translate('Edit_Details')); ?>

                                                            </div>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if(!$booking?->is_guest): ?>
                                                        <li>
                                                            <div
                                                                class="d-flex align-items-center gap-2 cursor-pointer customer-chat">
                                                                <span class="material-symbols-outlined">chat</span>
                                                                <?php echo e(translate('chat_with_Customer')); ?>

                                                                <form action="<?php echo e(route('admin.chat.create-channel')); ?>"
                                                                    method="post" id="chatForm-<?php echo e($booking->id); ?>">
                                                                    <?php echo csrf_field(); ?>
                                                                    <input type="hidden" name="customer_id"
                                                                        value="<?php echo e($booking?->customer?->id); ?>">
                                                                    <input type="hidden" name="type" value="booking">
                                                                    <input type="hidden" name="user_type"
                                                                        value="customer">
                                                                </form>
                                                            </div>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="py-3 px-4">
                                        <?php ($customer_name = $booking?->service_address?->contact_person_name); ?>
                                        <?php ($customer_phone = $booking?->service_address?->contact_person_number); ?>

                                        <div class="media gap-2 flex-wrap">
                                            <?php if(!$booking?->is_guest && $booking?->customer): ?>
                                                <img width="58" height="58"
                                                    class="rounded-circle border border-white aspect-square object-fit-cover"
                                                    src="<?php echo e($booking?->customer?->profile_image_full_path); ?>"
                                                    alt="<?php echo e(translate('user_image')); ?>">
                                            <?php else: ?>
                                                <img width="58" height="58"
                                                    class="rounded-circle border border-white aspect-square object-fit-cover"
                                                    src="<?php echo e(asset('public/assets/provider-module/img/user2x.png')); ?>"
                                                    alt="<?php echo e(translate('user_image')); ?>">
                                            <?php endif; ?>

                                            <div class="media-body">
                                                <h5 class="c1 mb-3">
                                                    <?php if(!$booking?->is_guest && $booking?->customer): ?>
                                                        <a href="<?php echo e(route('admin.customer.detail', [$booking?->customer?->id, 'web_page' => 'overview'])); ?>"
                                                            class="c1"><?php echo e(Str::limit($customer_name, 30)); ?></a>
                                                    <?php else: ?>
                                                        <span><?php echo e(Str::limit($customer_name ?? '', 30)); ?></span>
                                                    <?php endif; ?>
                                                </h5>
                                                <ul class="list-info">
                                                    <?php if($customer_phone): ?>
                                                        <li>
                                                            <span class="material-icons">phone_iphone</span>
                                                            <a
                                                                href="tel:<?php echo e($customer_phone); ?>"><?php echo e($customer_phone); ?></a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if(!empty($booking?->service_address?->address)): ?>
                                                            <li>
                                                                <span class="material-icons">map</span>
                                                                <p><?php echo e(Str::limit($booking?->service_address?->address ?? translate('not_available'), 100)); ?>

                                                                </p>
                                                            </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="c1-light-bg radius-10 provider-information">
                                    <div
                                        class="border-bottom d-flex align-items-center justify-content-between gap-2 py-3 px-4 mb-2">
                                        <h4 class="d-flex align-items-center gap-2">
                                            <span class="material-icons title-color">person</span>
                                            <?php echo e(translate('Provider_Information')); ?>

                                        </h4>
                                        <?php if(isset($booking->provider)): ?>
                                            <div class="btn-group">
                                                <div class="cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span class="material-symbols-outlined">more_vert</span>
                                                </div>
                                                <ul class="dropdown-menu dropdown-menu__custom border-none dropdown-menu-end">
                                                    <li>
                                                        <div
                                                            class="d-flex align-items-center gap-2 cursor-pointer provider-chat">
                                                            <span class="material-symbols-outlined">chat</span>
                                                            <?php echo e(translate('chat_with_Provider')); ?>

                                                            <form action="<?php echo e(route('admin.chat.create-channel')); ?>"
                                                                method="post" id="chatForm-<?php echo e($booking->id); ?>">
                                                                <?php echo csrf_field(); ?>
                                                                <input type="hidden" name="provider_id"
                                                                    value="<?php echo e($booking?->provider?->owner?->id); ?>">
                                                                <input type="hidden" name="type" value="booking">
                                                                <input type="hidden" name="user_type"
                                                                    value="provider-admin">
                                                            </form>
                                                        </div>
                                                    </li>
                                                    <?php if(in_array($booking->booking_status, ['ongoing', 'accepted'])): ?>
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('booking_can_manage_status')): ?>
                                                            <li>
                                                                <div class="d-flex align-items-center gap-2"
                                                                    data-bs-target="#providerModal" data-bs-toggle="modal">
                                                                    <span
                                                                        class="material-symbols-outlined">manage_history</span>
                                                                    <?php echo e(translate('change_Provider')); ?>

                                                                </div>
                                                            </li>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    <li>
                                                        <a class="d-flex align-items-center gap-2 cursor-pointer p-0"
                                                            href="<?php echo e(route('admin.provider.details', [$booking?->provider?->id, 'web_page' => 'overview'])); ?>">
                                                            <span class="material-icons">person</span>
                                                            <?php echo e(translate('View_Details')); ?>

                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <?php if(isset($booking->provider)): ?>
                                        <div class="py-3 px-4">
                                            <div class="media gap-2 flex-wrap">
                                                <img width="58" height="58"
                                                    class="rounded-circle border border-white aspect-square object-fit-cover"
                                                    src="<?php echo e($booking?->provider?->logo_full_path); ?>"
                                                    alt="<?php echo e(translate('provider')); ?>">
                                                <div class="media-body">
                                                    <a
                                                        href="<?php echo e(route('admin.provider.details', [$booking?->provider?->id, 'web_page' => 'overview'])); ?>">
                                                        <h5 class="c1 mb-3">
                                                            <?php echo e(Str::limit($booking->provider->company_name ?? '', 30)); ?>

                                                        </h5>
                                                    </a>
                                                    <ul class="list-info">
                                                        <li>
                                                            <span class="material-icons">phone_iphone</span>
                                                            <a
                                                                href="tel:<?php echo e($booking->provider->contact_person_phone ?? ''); ?>"><?php echo e($booking->provider->contact_person_phone ?? ''); ?></a>
                                                        </li>
                                                        <li>
                                                            <span class="material-icons">map</span>
                                                            <p><?php echo e(Str::limit($booking->provider->company_address ?? '', 100)); ?>

                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="d-flex flex-column gap-2 mt-30 align-items-center">
                                            <span class="material-icons text-muted fs-2">account_circle</span>
                                            <p class="text-muted text-center fw-medium mb-3">
                                                <?php echo e(translate('No Provider Information')); ?></p>
                                        </div>
                                        <div class="text-center pb-4">
                                            <button class="btn btn--primary" data-bs-target="#providerModal" data-bs-toggle="modal"><?php echo e(translate('assign provider')); ?></button>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="c1-light-bg radius-10 serviceman-information">
                                    <div
                                        class="border-bottom d-flex align-items-center justify-content-between gap-2 py-3 px-4 mb-2">
                                        <h4 class="d-flex align-items-center gap-2">
                                            <span class="material-icons title-color">person</span>
                                            <?php echo e(translate('Serviceman_Information')); ?>

                                        </h4>
                                        <?php if(isset($booking->serviceman)): ?>
                                            <div class="btn-group">
                                                <div class="cursor-pointer" data-bs-toggle="dropdown"
                                                     aria-expanded="false">
                                                    <span class="material-symbols-outlined">more_vert</span>
                                                </div>
                                                <ul
                                                    class="dropdown-menu dropdown-menu__custom border-none dropdown-menu-end">
                                                    <?php if(in_array($booking->booking_status, ['ongoing', 'accepted'])): ?>
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('booking_can_manage_status')): ?>
                                                            <li>
                                                                <div class="d-flex align-items-center gap-2"
                                                                     data-bs-target="#servicemanModal" data-bs-toggle="modal">
                                                                    <span
                                                                        class="material-symbols-outlined">manage_history</span>
                                                                    <?php echo e(translate('change serviceman')); ?>

                                                                </div>
                                                            </li>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if(isset($booking->serviceman)): ?>
                                        <div class="py-3 px-4">
                                            <div class="media gap-2 flex-wrap">
                                                <img width="58" height="58"
                                                    class="rounded-circle border border-white aspect-square object-fit-cover"
                                                    src="<?php echo e($booking?->serviceman?->user?->profile_image_full_path); ?>"
                                                    alt="<?php echo e(translate('serviceman')); ?>">
                                                <div class="media-body">
                                                    <h5 class="c1 mb-3">
                                                        <?php echo e(Str::limit($booking->serviceman && $booking->serviceman->user ? $booking->serviceman->user->first_name . ' ' . $booking->serviceman->user->last_name : '', 30)); ?>

                                                    </h5>
                                                    <ul class="list-info">
                                                        <li>
                                                            <span class="material-icons">phone_iphone</span>
                                                            <a
                                                                href="tel:<?php echo e($booking->serviceman && $booking->serviceman->user ? $booking->serviceman->user->phone : ''); ?>">
                                                                <?php echo e($booking->serviceman && $booking->serviceman->user ? $booking->serviceman->user->phone : ''); ?>

                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="d-flex flex-column gap-2 mt-30 align-items-center">
                                            <span class="material-icons text-muted fs-2">account_circle</span>
                                            <p class="text-muted text-center fw-medium mb-3">
                                                <?php echo e(translate('No Serviceman Information')); ?></p>
                                        </div>

                                        <div class="text-center pb-4">
                                            <button
                                                class="btn btn--primary"
                                                data-bs-target="#servicemanModal"
                                                data-bs-toggle="modal"
                                                <?php if($booking['booking_status'] == 'completed' || $booking['booking_status'] == 'canceled' || !isset($booking->provider)): ?>
                                                    disabled
                                                <?php endif; ?>>
                                                <?php echo e(translate('assign Serviceman')); ?>

                                            </button>
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

    <?php echo $__env->make('bookingmodule::admin.booking.partials.details._update-customer-address-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('bookingmodule::admin.booking.partials.details._service-address-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('bookingmodule::admin.booking.partials.details._service-location-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <?php echo $__env->make('bookingmodule::admin.booking.partials.details._service-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="modal fade" id="providerModal" tabindex="-1" aria-labelledby="providerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-content-data" id="modal-data-info">
                <?php echo $__env->make('bookingmodule::admin.booking.partials.details.provider-info-modal-data', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>
    <div class="modal fade" id="servicemanModal" tabindex="-1" aria-labelledby="servicemanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-content-data1" id="modal-data-info1">
                <?php echo $__env->make('bookingmodule::admin.booking.partials.details.serviceman-info-modal-data', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deniedModal-<?php echo e($booking->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body pt-5 p-md-5">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="d-flex justify-content-center mb-4">
                        <img width="75" height="75" src="<?php echo e(asset('public/assets/admin-module/img/icons/info-round.svg')); ?>" class="rounded-circle" alt="">
                    </div>

                    <h3 class="text-start mb-1 fw-medium text-center"><?php echo e(translate('Are you sure you want to deny?')); ?></h3>
                    <p class="text-start fs-12 fw-medium text-muted text-center"><?php echo e(translate('Please insert the deny note for this payment request')); ?></p>
                    <form method="post" action="<?php echo e(route('admin.booking.offline-payment.verify',['booking_id' => $booking->id, 'payment_status' => 'denied'])); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="form-floating">
                            <textarea class="form-control h-69px" placeholder="<?php echo e(translate('Type here your note')); ?>" name="note" id="add-your-note" maxlength="255" required></textarea>
                            <label for="add-your-note" class="d-flex align-items-center gap-1"><?php echo e(translate('Deny Note')); ?></label>
                            <div class="d-flex justify-content-center mt-3 gap-3">
                                <button type="button" class="btn btn--secondary min-w-92px px-2" data-bs-dismiss="modal" aria-label="Close"><?php echo e(translate('Not Now')); ?></button>
                                <button type="submit" class="btn btn-primary min-w-92px"><?php echo e(translate('Submit')); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        "use strict";

        $('.switcher_input').on('click', function() {
            let paymentStatus = $(this).is(':checked') === true ? 1 : 0;
            payment_status_change(paymentStatus)
        })

        $('.reassign-provider').on('click', function() {
            let id = $(this).data('provider-reassign');
            updateProvider(id)
        })

        $('.reassign-serviceman').on('click', function() {
            let id = $(this).data('serviceman-reassign');
            updateServiceman(id)
        })

        $('.offline-payment').on('click', function() {
            let route = '<?php echo e(route('admin.booking.offline-payment.verify', ['booking_id' => $booking->id])); ?>'+ '&payment_status=' + 'approved';
            route_alert_reload(route, '<?php echo e(translate('Want to verify the payment')); ?>', true);
        })

        <?php if($booking->booking_status == 'pending'): ?>
            $(document).ready(function() {
                selectElementVisibility('serviceman_assign', false);
                selectElementVisibility('payment_status', false);
            });
        <?php endif; ?>

        $("#booking_status").change(function() {
            var booking_status = $("#booking_status option:selected").val();
            if (parseInt(booking_status) !== 0) {
                var route = '<?php echo e(route('admin.booking.status_update', [$booking->id])); ?>' + '?booking_status=' + booking_status;
                update_booking_details(route, '<?php echo e(translate('want_to_update_status')); ?>', 'booking_status',
                    booking_status);
            } else {
                toastr.error('<?php echo e(translate('choose_proper_status')); ?>');
            }
        });

        $(".change-booking-status").on('click', function() {
            var booking_status = 'canceled';
            var route = '<?php echo e(route('admin.booking.status_update', [$booking->id])); ?>' + '?booking_status=' + booking_status;
            update_booking_details(route, '<?php echo e(translate('want_to_cancel_booking_status')); ?>', 'booking_status', booking_status);
        });

        $("#serviceman_assign").change(function() {
            var serviceman_id = $("#serviceman_assign option:selected").val();
            if (serviceman_id !== 'no_serviceman') {
                var route = '<?php echo e(route('admin.booking.serviceman_update', [$booking->id])); ?>' + '?serviceman_id=' +
                    serviceman_id;

                update_booking_details(route, '<?php echo e(translate('want_to_assign_the_serviceman')); ?>?',
                    'serviceman_assign', serviceman_id);
            } else {
                toastr.error('<?php echo e(translate('choose_proper_serviceman')); ?>');
            }
        });

        function payment_status_change(payment_status) {
            var route = '<?php echo e(route('admin.booking.payment_update', [$booking->id])); ?>' + '?payment_status=' +
                payment_status;
            update_booking_details(route, '<?php echo e(translate('want_to_update_status')); ?>', 'payment_status', payment_status);
        }

        function service_schedule_update() {
            var service_schedule = $("#service_schedule").val();
            var route = '<?php echo e(route('admin.booking.schedule_update', [$booking->id])); ?>' + '?service_schedule=' +
                service_schedule;

            update_booking_details(route, '<?php echo e(translate('want_to_update_the_booking_schedule')); ?>', 'service_schedule',
                service_schedule);
        }

        $(".switch-to-cash-after-service").on('click', function() {
            var payment_method = 'cash_after_service';
            var route = '<?php echo e(route('admin.booking.switch-payment-method', [$booking->id])); ?>' + '?payment_method=' + payment_method;
            update_booking_details(route, '<?php echo e(translate('want_to_switch_payment_method_to_cash_after_service')); ?>', 'payment_method', payment_method);
        });

        function update_booking_details(route, message, componentId, updatedValue) {
            Swal.fire({
                title: "<?php echo e(translate('are_you_sure')); ?>?",
                text: message,
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'var(--c2)',
                confirmButtonColor: 'var(--c1)',
                cancelButtonText: '<?php echo e(translate('Cancel')); ?>',
                confirmButtonText: '<?php echo e(translate('Yes')); ?>',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.get({
                        url: route,
                        dataType: 'json',
                        data: {},
                        beforeSend: function() {},
                        success: function(data) {
                            update_component(componentId, updatedValue);
                            toastr.success(data.message, {
                                CloseButton: true,
                                ProgressBar: true
                            });

                            if (componentId === 'booking_status' || componentId === 'payment_status' ||
                                componentId === 'service_schedule' || componentId === 'serviceman_assign' || componentId === 'payment_method' ) {
                                location.reload();
                            }
                        },
                        complete: function() {},
                    });
                }
            })
        }

        function update_component(componentId, updatedValue) {

            if (componentId === 'booking_status') {
                $("#booking_status__span").html(updatedValue);

                selectElementVisibility('serviceman_assign', true);
                selectElementVisibility('payment_status', true);

            } else if (componentId === 'payment_status') {
                $("#payment_status__span").html(updatedValue);
                if (updatedValue === 'paid') {
                    $("#payment_status__span").addClass('text-success').removeClass('text-danger');
                } else if (updatedValue === 'unpaid') {
                    $("#payment_status__span").addClass('text-danger').removeClass('text-success');
                }

            }
        }

        function selectElementVisibility(componentId, visibility) {
            if (visibility === true) {
                $('#' + componentId).next(".select2-container").show();
            } else if (visibility === false) {
                $('#' + componentId).next(".select2-container").hide();
            } else {}
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#category_selector__select').select2({
                dropdownParent: "#serviceUpdateModal--<?php echo e($booking['id']); ?>"
            });
            $('#sub_category_selector__select').select2({
                dropdownParent: "#serviceUpdateModal--<?php echo e($booking['id']); ?>"
            });
            $('#service_selector__select').select2({
                dropdownParent: "#serviceUpdateModal--<?php echo e($booking['id']); ?>"
            });
            $('#service_variation_selector__select').select2({
                dropdownParent: "#serviceUpdateModal--<?php echo e($booking['id']); ?>"
            });
        });

        $("#service_selector__select").on('change', function() {
            $("#service_variation_selector__select").html(
                '<option value="" selected disabled><?php echo e(translate('Select Service Variant')); ?></option>');

            const serviceId = this.value;
            const route = '<?php echo e(route('admin.booking.service.ajax-get-variant')); ?>' + '?service_id=' + serviceId +
                '&zone_id=' + "<?php echo e($booking->zone_id); ?>";

            $.get({
                url: route,
                dataType: 'json',
                data: {},
                beforeSend: function() {
                    $('.preloader').show();
                },
                success: function(response) {
                    var selectString =
                        '<option value="" selected disabled><?php echo e(translate('Select Service Variant')); ?></option>';
                    response.content.forEach((item) => {
                        selectString +=
                            `<option value="${item.variant_key}">${item.variant}</option>`;
                    });
                    $("#service_variation_selector__select").html(selectString)
                },
                complete: function() {
                    $('.preloader').hide();
                },
                error: function() {
                    toastr.error('<?php echo e(translate('Failed to load')); ?>')
                }
            });
        })

        $("#serviceUpdateModal--<?php echo e($booking['id']); ?>").on('hidden.bs.modal', function() {
            $('#service_selector__select').prop('selectedIndex', 0);
            $("#service_variation_selector__select").html(
                '<option value="" selected disabled><?php echo e(translate('Select Service Variant')); ?></option>');
            $("#service_quantity").val('');
        });

        $("#add-service").on('click', function() {
            const service_id = $("[name='service_id']").val();
            const variant_key = $("[name='variant_key']").val();
            const quantity = parseInt($("[name='service_quantity']").val());
            const zone_id = '<?php echo e($booking->zone_id); ?>';


            if (service_id === '' || service_id === null) {
                toastr.error('<?php echo e(translate('Select a service')); ?>', {
                    CloseButton: true,
                    ProgressBar: true
                });
                return;
            } else if (variant_key === '' || variant_key === null) {
                toastr.error('<?php echo e(translate('Select a variation')); ?>', {
                    CloseButton: true,
                    ProgressBar: true
                });
                return;
            } else if (quantity < 1) {
                toastr.error('<?php echo e(translate('Quantity must not be empty')); ?>', {
                    CloseButton: true,
                    ProgressBar: true
                });
                return;
            }

            let variant_key_array = [];
            $('input[name="variant_keys[]"]').each(function() {
                variant_key_array.push($(this).val());
            });

            if (variant_key_array.includes(variant_key)) {
                const decimal_point = parseInt(
                    '<?php echo e(business_config('currency_decimal_point', 'business_information')->live_values ?? 2); ?>'
                );

                const old_qty = parseInt($(`#qty-${variant_key}`).val());
                const updated_qty = old_qty + quantity;

                const old_total_cost = parseFloat($(`#total-cost-${variant_key}`).text());
                const updated_total_cost = ((old_total_cost * updated_qty) / old_qty).toFixed(decimal_point);

                const old_discount_amount = parseFloat($(`#discount-amount-${variant_key}`).text());
                const updated_discount_amount = ((old_discount_amount * updated_qty) / old_qty).toFixed(
                    decimal_point);


                $(`#qty-${variant_key}`).val(updated_qty);
                $(`#total-cost-${variant_key}`).text(updated_total_cost);
                $(`#discount-amount-${variant_key}`).text(updated_discount_amount);

                toastr.success('<?php echo e(translate('Added successfully')); ?>', {
                    CloseButton: true,
                    ProgressBar: true
                });
                return;
            }

            let query_string = 'service_id=' + service_id + '&variant_key=' + variant_key + '&quantity=' +
                quantity + '&zone_id=' + zone_id;
            $.ajax({
                type: 'GET',
                url: "<?php echo e(route('admin.booking.service.ajax-get-service-info')); ?>" + '?' + query_string,
                data: {},
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('.preloader').show();
                },
                success: function(response) {
                    $("#service-edit-tbody").append(response.view);
                    toastr.success('<?php echo e(translate('Added successfully')); ?>', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                complete: function() {
                    $('.preloader').hide();
                },
            });
        })

        $(".remove-service-row").on('click', function() {
            let row = $(this).data('row');
            removeServiceRow(row)
        })

        function removeServiceRow(row) {
            const row_count = $('#service-edit-tbody tr').length;
            if (row_count <= 1) {
                toastr.error('<?php echo e(translate('Can not remove the only service')); ?>');
                return;
            }

            Swal.fire({
                title: "<?php echo e(translate('are_you_sure')); ?>?",
                text: '<?php echo e(translate('want to remove the service from the booking')); ?>',
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
                    $(`#${row}`).remove();
                }
            })
        }
    </script>


    <script
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(business_config('google_map', 'third_party')?->live_values['map_api_key_client']); ?>&libraries=places&v=3.45.8">
    </script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function() {
            readURL(this);
        });

        // for update customer location from service address modal
        $(document).ready(function() {
            function initAutocomplete() {
                let myLatLng = {
                    lat: <?php echo e($customerAddress->lat ?? 23.811842872190343); ?>,
                    lng: <?php echo e($customerAddress->lon ?? 90.356331); ?>

                };
                const map = new google.maps.Map(document.getElementById("location_map_canvas"), {
                    center: myLatLng,
                    zoom: 13,
                    mapTypeId: "roadmap",
                });

                let marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                });

                marker.setMap(map);
                var geocoder = geocoder = new google.maps.Geocoder();
                google.maps.event.addListener(map, 'click', function(mapsMouseEvent) {
                    var coordinates = JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2);
                    var coordinates = JSON.parse(coordinates);
                    var latlng = new google.maps.LatLng(coordinates['lat'], coordinates['lng']);
                    marker.setPosition(latlng);
                    map.panTo(latlng);

                    document.getElementById('latitude').value = coordinates['lat'];
                    document.getElementById('longitude').value = coordinates['lng'];


                    geocoder.geocode({
                        'latLng': latlng
                    }, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[1]) {
                                document.getElementById('address').value = results[1]
                                    .formatted_address;
                            }
                        }
                    });
                });

                const input = document.getElementById("pac-input");
                const searchBox = new google.maps.places.SearchBox(input);
                map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);

                map.addListener("bounds_changed", () => {
                    searchBox.setBounds(map.getBounds());
                });
                let markers = [];

                searchBox.addListener("places_changed", () => {
                    const places = searchBox.getPlaces();

                    if (places.length == 0) {
                        return;
                    }

                    markers.forEach((marker) => {
                        marker.setMap(null);
                    });
                    markers = [];

                    const bounds = new google.maps.LatLngBounds();
                    places.forEach((place) => {
                        if (!place.geometry || !place.geometry.location) {
                            console.log("Returned place contains no geometry");
                            return;
                        }
                        var mrkr = new google.maps.Marker({
                            map,
                            title: place.name,
                            position: place.geometry.location,
                        });
                        google.maps.event.addListener(mrkr, "click", function(event) {
                            document.getElementById('latitude').value = this.position.lat();
                            document.getElementById('longitude').value = this.position
                                .lng();
                        });

                        markers.push(mrkr);

                        if (place.geometry.viewport) {
                            bounds.union(place.geometry.viewport);
                        } else {
                            bounds.extend(place.geometry.location);
                        }
                    });
                    map.fitBounds(bounds);
                });
            };
            initAutocomplete();
        });

        // for update service location from update customer address modal
        $(document).ready(function() {
            function addressMap() {
                let myLatLng = {
                    lat: <?php echo e($booking->service_address?->lat ?? 23.811842872190343); ?>,
                    lng: <?php echo e($booking->service_address?->lon ?? 90.356331); ?>

                };
                const map = new google.maps.Map(document.getElementById("address_location_map_canvas"), {
                    center: myLatLng,
                    zoom: 13,
                    mapTypeId: "roadmap",
                });

                let marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                });

                marker.setMap(map);
                var geocoder = geocoder = new google.maps.Geocoder();
                google.maps.event.addListener(map, 'click', function(mapsMouseEvent) {
                    var coordinates = JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2);
                    var coordinates = JSON.parse(coordinates);
                    var latlng = new google.maps.LatLng(coordinates['lat'], coordinates['lng']);
                    marker.setPosition(latlng);
                    map.panTo(latlng);

                    document.getElementById('address_latitude').value = coordinates['lat'];
                    document.getElementById('address_longitude').value = coordinates['lng'];


                    geocoder.geocode({
                        'latLng': latlng
                    }, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[1]) {
                                document.getElementById('address_address').value = results[1].formatted_address;
                            }
                        }
                    });
                });

                const input = document.getElementById("address_pac-input");
                const searchBox = new google.maps.places.SearchBox(input);
                map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);

                map.addListener("bounds_changed", () => {
                    searchBox.setBounds(map.getBounds());
                });
                let markers = [];

                searchBox.addListener("places_changed", () => {
                    const places = searchBox.getPlaces();

                    if (places.length == 0) {
                        return;
                    }

                    markers.forEach((marker) => {
                        marker.setMap(null);
                    });
                    markers = [];

                    const bounds = new google.maps.LatLngBounds();
                    places.forEach((place) => {
                        if (!place.geometry || !place.geometry.location) {
                            console.log("Returned place contains no geometry");
                            return;
                        }
                        var mrkr = new google.maps.Marker({
                            map,
                            title: place.name,
                            position: place.geometry.location,
                        });
                        google.maps.event.addListener(mrkr, "click", function(event) {
                            document.getElementById('address_latitude').value = this.position.lat();
                            document.getElementById('address_longitude').value = this.position.lng();
                        });

                        markers.push(mrkr);

                        if (place.geometry.viewport) {
                            bounds.union(place.geometry.viewport);
                        } else {
                            bounds.extend(place.geometry.location);
                        }
                    });
                    map.fitBounds(bounds);
                });
            };
            addressMap();
        });


        $('.__right-eye').on('click', function() {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active')
                $(this).find('i').removeClass('tio-invisible')
                $(this).find('i').addClass('tio-hidden-outlined')
                $(this).siblings('input').attr('type', 'password')
            } else {
                $(this).addClass('active')
                $(this).siblings('input').attr('type', 'text')


                $(this).find('i').addClass('tio-invisible')
                $(this).find('i').removeClass('tio-hidden-outlined')
            }
        })
    </script>

    <script>
        $(document).ready(function() {

            $(document).on('click', '.sort-by-class', function() {
                console.log('hi')
                const route = '<?php echo e(url('admin/provider/available-provider')); ?>'
                var sortOption = document.querySelector('input[name="sort"]:checked').value;
                var bookingId = "<?php echo e($booking->id); ?>"

                $.get({
                    url: route,
                    dataType: 'json',
                    data: {
                        sort_by: sortOption,
                        booking_id: bookingId
                    },
                    beforeSend: function() {

                    },
                    success: function(response) {
                        $('.modal-content-data').html(response.view);
                    },
                    complete: function() {},
                    error: function() {
                        toastr.error('<?php echo e(translate('Failed to load')); ?>')
                    }
                });
            })
        });

        $(document).ready(function() {
            $(document).on('keyup', '.search-form-input', function() {
                const route = '<?php echo e(url('admin/provider/available-provider')); ?>';
                let sortOption = document.querySelector('input[name="sort"]:checked').value;
                let bookingId = "<?php echo e($booking->id); ?>";
                let searchTerm = $('.search-form-input').val();

                $.get({
                    url: route,
                    dataType: 'json',
                    data: {
                        sort_by: sortOption,
                        booking_id: bookingId,
                        search: searchTerm,
                    },
                    beforeSend: function() {},
                    success: function(response) {
                        $('.modal-content-data').html(response.view);


                        var cursorPosition = searchTerm.lastIndexOf(searchTerm.charAt(searchTerm
                            .length - 1)) + 1;
                        $('.search-form-input').focus().get(0).setSelectionRange(cursorPosition,
                            cursorPosition);
                    },
                    complete: function() {},
                    error: function() {
                        toastr.error('<?php echo e(translate('Failed to load')); ?>');
                    }
                });
            });
        });

        function updateProvider(providerId) {
            const bookingId = "<?php echo e($booking->id); ?>";
            const route = '<?php echo e(url('admin/provider/reassign-provider')); ?>' + '/' + bookingId;
            const sortOption = document.querySelector('input[name="sort"]:checked').value;
            const searchTerm = $('.search-form-input').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: route,
                type: 'PUT',
                dataType: 'json',
                data: {
                    sort_by: sortOption,
                    booking_id: bookingId,
                    search: searchTerm,
                    provider_id: providerId
                },
                beforeSend: function() {
                    toastr.info('<?php echo e(translate('Processing request...')); ?>');
                },
                success: function(response) {
                    $('.modal-content-data').html(response.view);
                    toastr.success('<?php echo e(translate('Successfully reassign provider')); ?>');
                    setTimeout(function() {
                        location.reload()
                    }, 600);
                },
                complete: function() {},
                error: function() {
                    toastr.error('<?php echo e(translate('Failed to load')); ?>');
                }
            });
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('keyup', '.search-form-input1', function() {
                const route = '<?php echo e(url('admin/booking/serviceman-update', $booking->id)); ?>';
                let searchTerm = $('.search-form-input1').val();

                $.ajax({
                    url: route,
                    type: 'PUT',
                    dataType: 'json',
                    data: {
                        booking_id: "<?php echo e($booking->id); ?>",
                        search: searchTerm,
                    },
                    beforeSend: function() {},
                    success: function(response) {
                        $('.modal-content-data1').html(response.view);
                    },
                    complete: function() {},
                    error: function(xhr) {
                        if (xhr.status === 419) {
                            toastr.error('<?php echo e(translate('Session expired, please refresh the page.')); ?>');
                        } else {
                            toastr.error('<?php echo e(translate('Failed to load')); ?>');
                        }
                    }
                });
            });
        });


        function updateServiceman(servicemanId) {
            const bookingId = "<?php echo e($booking->id); ?>";
            const route = '<?php echo e(url('admin/booking/serviceman-update')); ?>' + '/' + bookingId;
            const searchTerm = $('.search-form-input1').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: route,
                type: 'PUT',
                dataType: 'json',
                data: {
                    booking_id: bookingId,
                    search: searchTerm,
                    serviceman_id: servicemanId
                },
                beforeSend: function() {
                    toastr.info('<?php echo e(translate('Processing request...')); ?>');
                },
                success: function(response) {
                    $('.modal-content-data').html(response.view);
                    toastr.success('<?php echo e(translate('Successfully reassign provider')); ?>');
                    setTimeout(function() {
                        location.reload()
                    }, 600);
                },
                complete: function() {},
                error: function() {
                    toastr.error('<?php echo e(translate('Failed to load')); ?>');
                }
            });
        }

        $(document).ready(function() {
            $('.your-button-selector').on('click', function() {
                updateSearchResults();
            });

            $('.cancellation-note').hide();

            $('.deny-request').click(function() {
                $('.cancellation-note').show();
            });

            $('.approve-request').click(function() {
                $('.cancellation-note').hide();
            });
        });

        $('.customer-chat').on('click', function() {
            $(this).find('form').submit();
        });

        $('.provider-chat').on('click', function() {
            $(this).find('form').submit();
        });

        document.addEventListener('DOMContentLoaded', function() {
            const denyRequestRadio = document.querySelector('.deny-request');
            const cancellationNote = document.querySelector('.cancellation-note');

            denyRequestRadio.addEventListener('change', function() {
                if (this.checked) {
                    cancellationNote.style.display = 'block';
                    document.querySelector('textarea[name="booking_deny_note"]').required = true;
                } else {
                    cancellationNote.style.display = 'none';
                    document.querySelector('textarea[name="booking_deny_note"]').required = false;
                }
            });
        });

        // for update service location from update customer address modal
        $(document).ready(function() {
            function addressMap() {
                let myLatLng = {
                    lat: <?php echo e($booking->service_address?->lat ?? 23.811842872190343); ?>,
                    lng: <?php echo e($booking->service_address?->lon ?? 90.356331); ?>

                };
                const map = new google.maps.Map(document.getElementById("address_location_map_canvas"), {
                    center: myLatLng,
                    zoom: 13,
                    mapTypeId: "roadmap",
                });

                let marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                });

                marker.setMap(map);
                var geocoder = geocoder = new google.maps.Geocoder();
                google.maps.event.addListener(map, 'click', function(mapsMouseEvent) {
                    var coordinates = JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2);
                    var coordinates = JSON.parse(coordinates);
                    var latlng = new google.maps.LatLng(coordinates['lat'], coordinates['lng']);
                    marker.setPosition(latlng);
                    map.panTo(latlng);

                    document.getElementById('address_latitude').value = coordinates['lat'];
                    document.getElementById('address_longitude').value = coordinates['lng'];


                    geocoder.geocode({
                        'latLng': latlng
                    }, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[1]) {
                                document.getElementById('address_address').value = results[1].formatted_address;
                            }
                        }
                    });
                });

                const input = document.getElementById("address_pac-input");
                const searchBox = new google.maps.places.SearchBox(input);
                map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);

                map.addListener("bounds_changed", () => {
                    searchBox.setBounds(map.getBounds());
                });
                let markers = [];

                searchBox.addListener("places_changed", () => {
                    const places = searchBox.getPlaces();

                    if (places.length == 0) {
                        return;
                    }

                    markers.forEach((marker) => {
                        marker.setMap(null);
                    });
                    markers = [];

                    const bounds = new google.maps.LatLngBounds();
                    places.forEach((place) => {
                        if (!place.geometry || !place.geometry.location) {
                            console.log("Returned place contains no geometry");
                            return;
                        }
                        var mrkr = new google.maps.Marker({
                            map,
                            title: place.name,
                            position: place.geometry.location,
                        });
                        google.maps.event.addListener(mrkr, "click", function(event) {
                            document.getElementById('address_latitude').value = this.position.lat();
                            document.getElementById('address_longitude').value = this.position.lng();
                        });

                        markers.push(mrkr);

                        if (place.geometry.viewport) {
                            bounds.union(place.geometry.viewport);
                        } else {
                            bounds.extend(place.geometry.location);
                        }
                    });
                    map.fitBounds(bounds);
                });
            };
            addressMap();
        });

        $(document).ready(function() {
            // Get booking ID dynamically
            var bookingId = "<?php echo e($booking['id']); ?>";

            function toggleServiceLocation() {
                if ($('#customer_location').is(':checked')) {
                    $('.customer-details').show();
                    $('.provider-details').hide();
                } else {
                    $('.customer-details').hide();
                    $('.provider-details').show();
                }
            }

            // Run toggle function on radio button change
            $('input[name="service_location"]').on('change', function() {
                toggleServiceLocation();
            });

            // Run toggle function when the modal is opened
            $('#serviceLocationModal--' + bookingId).on('shown.bs.modal', function () {
                toggleServiceLocation();
            });

            // When the address modal opens, hide the first modal
            $('#customerAddressModal--' + bookingId).on('show.bs.modal', function () {
                $('#serviceLocationModal--' + bookingId).modal('hide'); // Hide the first modal
            });

            // When the address modal closes, reopen the service location modal and update the address
            $('#customerAddressModal--' + bookingId).on('hidden.bs.modal', function () {
                $('#serviceLocationModal--' + bookingId).modal('show'); // Show the first modal again
            });
        });

        $(document).ready(function () {
            $("#customerAddressModalSubmit").on("submit", function (e) {
                e.preventDefault(); // Prevent form submission

                var bookingId = "<?php echo e($booking['id']); ?>";

                let customerAddressModal = $("#customerAddressModal--" + bookingId);
                let serviceLocationModal = $("#serviceLocationModal--" + bookingId);

                // Copy updated data from customerAddressModal inputs
                let contactPersonName = customerAddressModal.find("input[name='contact_person_name']").val();
                let contactPersonNumber = customerAddressModal.find("input[name='contact_person_number_with_code']").val();
                let addressLabel = customerAddressModal.find("select[name='address_label']").val();
                let address = customerAddressModal.find("input[name='address']").val();
                let latitude = customerAddressModal.find("input[name='latitude']").val();
                let longitude = customerAddressModal.find("input[name='longitude']").val();
                let city = customerAddressModal.find("input[name='city']").val();
                let street = customerAddressModal.find("input[name='street']").val();
                let zipCode = customerAddressModal.find("input[name='zip_code']").val();
                let country = customerAddressModal.find("input[name='country']").val();

                // Update the corresponding hidden inputs in serviceLocationModal
                serviceLocationModal.find("input[name='contact_person_name']").val(contactPersonName);
                serviceLocationModal.find("input[name='contact_person_number']").val(contactPersonNumber);
                serviceLocationModal.find("input[name='address_label']").val(addressLabel);
                serviceLocationModal.find("input[name='address']").val(address);
                serviceLocationModal.find("input[name='latitude']").val(latitude);
                serviceLocationModal.find("input[name='longitude']").val(longitude);
                serviceLocationModal.find("input[name='city']").val(city);
                serviceLocationModal.find("input[name='street']").val(street);
                serviceLocationModal.find("input[name='zip_code']").val(zipCode);
                serviceLocationModal.find("input[name='country']").val(country);

                $('.updated_customer_name').text(contactPersonName); // Update the customer name
                $('#updated_customer_phone').text(contactPersonNumber); // Update the customer
                $('#customer_service_location').removeClass('text-danger'); // Update the customer service location
                $('#customer_service_location').text(address); // Update the customer service location
                $('.customer-address-update-btn').removeAttr('disabled'); // Update the customer service location update button

               // Close the customerAddressModal
                customerAddressModal.modal("hide");

                // Open the serviceLocationModal to show updated data
                serviceLocationModal.modal("show");
            });
        });

        $(".customer-address-reset-btn").on("click", function (e) {
            let name = "<?php echo e($customer_name); ?>";
            let phone = "<?php echo e($customer_phone); ?>";
            let customerAddress = "<?php echo e($booking?->service_address?->address); ?>";

            $('.updated_customer_name').text(name); // Update the customer name
            $('#updated_customer_phone').text(phone); // Update the customer

            if (customerAddress) {
                $('#customer_service_location').text(customerAddress); // Update the customer service location
                $('#customer_service_location').removeClass('text-danger');
                $('.customer-address-update-btn').removeAttr('disabled');
            } else {
                $('#customer_service_location').text("No address found");
                $('#customer_service_location').addClass('text-danger');
                $('.customer-address-update-btn').attr('disabled', true);
            }
        })

    </script>
    <script>
        $(document).ready(function() {
            $('.without-search').select2({
                minimumResultsForSearch: Infinity
            });
        });

        $(document).ready(function () {
            try {
                initializePhoneInput(
                    ".phone-input-with-country-picker7",
                    ".country-picker-phone-number7"
                );

            } catch (error) {
                console.log(error)
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/BookingModule/Resources/views/admin/booking/details.blade.php ENDPATH**/ ?>