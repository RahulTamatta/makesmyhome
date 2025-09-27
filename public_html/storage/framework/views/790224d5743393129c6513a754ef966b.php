<?php $__env->startSection('title', translate('Booking_Status')); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-title-wrap mb-3">
                <h2 class="page-title"><?php echo e(translate('Booking_Details')); ?> </h2>
            </div>

            <div class="pb-3 d-flex justify-content-between align-items-center gap-3 flex-wrap">
                <div>
                    <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                        <h3 class="c1"><?php echo e(translate('Booking')); ?> # <?php echo e($booking['readable_id']); ?></h3>
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
                                                            <input
                                                                class="form-check-input approve-request check-approve-status"
                                                                checked type="radio" name="status" id="inlineRadio1"
                                                                value="approve">
                                                            <label class="form-check-label"
                                                                for="inlineRadio1"><?php echo e(translate('Approve the Request')); ?></label>
                                                        </div>
                                                        <div class="form-check-inline">
                                                            <input class="form-check-input deny-request check-deny-status"
                                                                type="radio" name="status" id="inlineRadio2"
                                                                value="deny">
                                                            <label class="form-check-label"
                                                                for="inlineRadio2"><?php echo e(translate('Deny the Request')); ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="mt-4 cancellation-note">
                                                        <textarea class="form-control h-69px" placeholder="<?php echo e(translate('Cancellation Note')); ?>" name="booking_deny_note"
                                                            id="add-your-note" required></textarea>
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
                        <?php if($booking['payment_method'] == 'cash_after_service' && $booking->is_verified == '2'): ?>
                            <span class="btn btn--primary change-booking-request" data-id="<?php echo e($booking->id); ?>"
                                data-bs-toggle="modal" data-bs-target="#exampleModal--<?php echo e($booking->id); ?>">
                                <span class="material-icons">done</span><?php echo e(translate('Change Request Status')); ?>

                            </span>

                            <div class="modal fade" id="exampleModal--<?php echo e($booking->id); ?>" tabindex="-1"
                                aria-labelledby="exampleModalLabel--<?php echo e($booking->id); ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body p-4 py-5">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                            <div class="text-center mb-4 pb-3">
                                                <img class="mb-4"
                                                    src="<?php echo e(asset('/public/assets/admin-module/img/booking-req-status.png')); ?>"
                                                    alt="">
                                                <h3><?php echo e(translate('Verify the booking request status?')); ?></h3>
                                                <p><?php echo e(translate('Need verification for max booking amount')); ?></p>
                                            </div>
                                            <form method="post"
                                                action="<?php echo e(route('admin.booking.verification-status', [$booking->id])); ?>">
                                                <?php echo csrf_field(); ?>
                                                <div class="c1-light-bg p-4 rounded">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input approve-request" checked
                                                            type="radio" name="status" id="inlineRadio1" value="approve">
                                                        <label class="form-check-label"
                                                            for="inlineRadio1"><?php echo e(translate('Approve the Request')); ?></label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input deny-request" type="radio"
                                                            name="status" id="inlineRadio2" value="cancel">
                                                        <label class="form-check-label"
                                                            for="inlineRadio2"><?php echo e(translate('Cancel Booking')); ?></label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer text-center justify-content-center border-0">
                                                    <button type="submit"
                                                        class="btn btn--primary"><?php echo e(translate('submit')); ?></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if(in_array($booking['booking_status'], ['pending', 'accepted', 'ongoing']) &&
                                $booking->booking_partial_payments->isEmpty() && $booking['payment_method'] == 'cash_after_service' && !$booking['is_paid'] && empty($booking->customizeBooking)): ?>
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

                <?php if(
                    $booking->is_verified == 2 &&
                        $booking->payment_method == 'cash_after_service' &&
                        $max_booking_amount <= $booking->total_booking_amount): ?>
                    <div class="border border-danger-light bg-soft-danger rounded py-3 px-3 text-dark">
                        <span class="text-danger"># <?php echo e(translate('Note: ')); ?></span>
                        <span><?php echo e($booking?->bookingDeniedNote?->value); ?></span>
                    </div>
                <?php endif; ?>

                <?php if(
                    $booking->is_verified == 0 &&
                        $booking->payment_method == 'cash_after_service' &&
                        $max_booking_amount <= $booking->total_booking_amount): ?>
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
                    <div class="card">
                        <div class="card-body">
                            <div class="border-bottom pb-3 mb-3">
                                <div
                                    class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center gap-3 flex-wrap">
                                    <div>
                                        <h4 class="mb-2"><?php echo e(translate('Payment Method')); ?></h4>
                                        <h5 class="c1 mb-2"><span
                                                class="text-capitalize"><?php echo e(str_replace(['_', '-'], ' ', $booking->payment_method)); ?>

                                                <?php if($booking->payment_method == 'offline_payment' && $booking?->booking_offline_payments?->first()?->method_name): ?>
                                                    (<?php echo e($booking?->booking_offline_payments?->first()?->method_name); ?>)
                                                <?php endif; ?>
                                            </span>
                                        </h5>
                                        <p>
                                            <span><?php echo e(translate('Amount')); ?> : </span>
                                            <?php echo e(with_currency_symbol($booking->total_booking_amount)); ?>

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

                                        <p class="mb-2">
                                            <span><?php echo e(translate('Payment_Status')); ?> : </span>
                                            <span class="text-<?php echo e($booking->is_paid ? 'success' : 'danger'); ?>"
                                                id="payment_status__span"><?php echo e($booking->is_paid ? translate('Paid') : translate('Unpaid')); ?></span>
                                            <?php if(!$booking->is_paid && $booking->booking_partial_payments->isNotEmpty()): ?>
                                                <span
                                                    class="small badge badge-info text-success p-1 fz-10"><?php echo e(translate('Partially paid')); ?></span>
                                            <?php endif; ?>
                                        </p>

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

                            <div class="timeline-wrapper mt-4 ps-xl-5">
                                <div class="timeline-steps m-0">
                                    <div class="timeline-step completed">
                                        <div class="timeline-number">
                                            <svg viewBox="0 0 512 512" width="100" title="check">
                                                <path
                                                    d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z" />
                                            </svg>
                                        </div>
                                        <div class="timeline-info">
                                            <p class="timeline-title text-capitalize"><?php echo e(translate('Booking_Placed')); ?>

                                            </p>
                                            <p class="timeline-text">
                                                <?php echo e(date('d-M-Y h:ia', strtotime($booking->created_at))); ?></p>
                                            <p class="timeline-text">By
                                                -
                                                <?php echo e(isset($booking->customer) ? Str::limit($booking->customer->first_name . ' ' . $booking->customer->last_name, 30) : translate('Not_Available')); ?>

                                            </p>
                                        </div>
                                    </div>
                                    <?php $__currentLoopData = $booking->status_histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status_history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="timeline-step completed">
                                            <div class="timeline-number">
                                                <svg viewBox="0 0 512 512" width="100" title="check">
                                                    <path
                                                        d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z" />
                                                </svg>
                                            </div>
                                            <div class="timeline-info">
                                                <p class="timeline-title text-capitalize">
                                                    <?php echo e($status_history->booking_status); ?></p>
                                                <p class="timeline-text">
                                                    <?php echo e(date('d-M-Y h:ia', strtotime($status_history->created_at))); ?></p>
                                                <p class="timeline-text"><?php echo e(translate('By')); ?>

                                                    <?php if(isset($status_history->user->provider)): ?>
                                                        -
                                                        <?php echo e(Str::limit($status_history?->user?->provider?->company_name, 30)); ?>

                                                    <?php else: ?>
                                                        -
                                                        <?php echo e(isset($status_history->user) ? Str::limit($status_history->user->first_name . ' ' . $status_history->user->last_name, 30) : ''); ?>

                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

                            <div class="py-3 d-flex flex-column gap-3 mb-2">

                                <?php if($booking->payment_method == 'offline_payment'): ?>
                                    <div class="border border-color-primary">
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

                                <div class="c1-light-bg radius-10">
                                    <div class="border-bottom d-flex align-items-center justify-content-between gap-2 py-3 px-4 mb-2">
                                        <h4 class="d-flex align-items-center gap-2">
                                            <span class="material-icons title-color">person</span>
                                            <?php echo e(translate('Customer_Information')); ?>

                                        </h4>

                                        <div class="btn-group">
                                            <div class="cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="material-symbols-outlined">more_vert</span>
                                            </div>
                                            <ul class="dropdown-menu dropdown-menu__custom border-none dropdown-menu-end">
                                                <?php if(
                                                    $booking['booking_status'] == 'pending' ||
                                                        $booking['booking_status'] == 'accepted' ||
                                                        $booking['booking_status'] == 'ongoing'): ?>
                                                    <li data-bs-toggle="modal"
                                                        data-bs-target="#serviceAddressModal--<?php echo e($booking['id']); ?>"
                                                        data-toggle="tooltip" data-placement="top">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span class="material-symbols-outlined">edit_square</span>
                                                            <?php echo e(translate('Edit_Details')); ?>

                                                        </div>
                                                    </li>
                                                <?php endif; ?>
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
                                                            <input type="hidden" name="user_type" value="customer">
                                                        </form>
                                                    </div>
                                                </li>
                                            </ul>
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
                                                            <a href="tel:<?php echo e($customer_phone); ?>"><?php echo e($customer_phone); ?></a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <li>
                                                        <span class="material-icons">map</span>
                                                        <p><?php echo e(Str::limit($booking?->service_address?->address ?? translate('not_available'), 100)); ?>

                                                        </p>
                                                    </li>
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
                                                <div class="cursor-pointer" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <span class="material-symbols-outlined">more_vert</span>
                                                </div>
                                                <ul
                                                    class="dropdown-menu dropdown-menu__custom border-none dropdown-menu-end">
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
                                                        <li>
                                                            <div class="d-flex align-items-center gap-2"
                                                                data-bs-target="#providerModal" data-bs-toggle="modal">
                                                                <span
                                                                    class="material-symbols-outlined">manage_history</span>
                                                                <?php echo e(translate('change_Provider')); ?>

                                                            </div>
                                                        </li>
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
                                    <?php endif; ?>
                                </div>

                                <div class="c1-light-bg radius-10 serviceman-information">
                                    <div
                                        class="border-bottom d-flex align-items-center justify-content-between gap-2 py-3 px-4 mb-2">
                                        <h4 class="d-flex align-items-center gap-2">
                                            <span class="material-icons title-color">person</span>
                                            <?php echo e(translate('Serviceman_Information')); ?>

                                        </h4>
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

    <?php echo $__env->make('bookingmodule::admin.booking.partials.details._service-address-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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

    <div class="modal fade" id="changeScheduleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="changeScheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="<?php echo e(route('admin.booking.schedule_update', [$booking->id])); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="modal-header">
                        <h5 class="modal-title" id="changeScheduleModalLabel"><?php echo e(translate('Change_Booking_Schedule')); ?>

                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="datetime-local" id="service_schedule" name="service_schedule" class="form-control"
                            value="<?php echo e($booking->service_schedule); ?>">
                    </div>
                    <div class="p-3 d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal"><?php echo e(translate('Close')); ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo e(translate('Submit')); ?></button>
                    </div>
                </form>
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
        'use strict'

        $(".change-booking-status").on('click', function() {
            var booking_status = 'canceled';
            var route = '<?php echo e(route('admin.booking.status_update', [$booking->id])); ?>' + '?booking_status=' + booking_status;
            update_booking_details(route, '<?php echo e(translate('want_to_cancel_booking_status')); ?>', 'booking_status', booking_status);
        });

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
                            toastr.success(data.message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                            location.reload();
                        },
                        complete: function() {},
                    });
                }
            })
        }


        $('.reassign-provider').on('click', function() {
            let id = $(this).data('provider-reassign');
            updateProvider(id)
        })

        $('.offline-payment').on('click', function() {
            let route = '<?php echo e(route('admin.booking.offline-payment.verify', ['booking_id' => $booking->id])); ?>'+ '&payment_status=' + 'approved';
            route_alert_reload(route, '<?php echo e(translate('Want to verify the payment')); ?>', true);
        })

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


        $(document).ready(function() {
            function initAutocomplete() {
                let myLatLng = {

                    lat: 23.811842872190343,
                    lng: 90.356331
                };
                const map = new google.maps.Map(document.getElementById("location_map_canvas"), {
                    center: {
                        lat: 23.811842872190343,
                        lng: 90.356331
                    },
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
                                document.getElementById('address').innerHtml = results[1]
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


        $(document).ready(function() {
            var check_aprove_model_status = $('.check-approve-status').val();
            if (check_aprove_model_status == "approve") {
                $('#add-your-note').removeAttr('required');
            }
            $('.check-approve-status').change(function() {
                check_aprove_model_status = $('.check-approve-status').val();
                if (check_aprove_model_status == "approve") {
                    $('#add-your-note').removeAttr('required');
                }
            });
            $('.check-deny-status').change(function() {
                $('#add-your-note').attr('required', true);
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/BookingModule/Resources/views/admin/booking/status.blade.php ENDPATH**/ ?>