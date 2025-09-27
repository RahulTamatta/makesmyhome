<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo e(translate('invoice')); ?></title>
    <script src="<?php echo e(asset('public/assets/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/js/jquery.min.js')); ?>"></script>
    <style>
        body {
            background-color: #F9FCFF;
            font-size: 10px !important;
            line-height: 1.6;
            font-family: "Inter", sans-serif;
        }

        a {
            color: rgb(65, 83, 179) !important;
            text-decoration: none !important;
        }

        @media print {
            a {
                text-decoration: none !important;
                -webkit-print-color-adjust: exact;
            }
        }

        #invoice {
            padding: 30px;
        }

        .invoice {
            position: relative;
            min-height: 972px;
            max-width: 972px;
            margin-left: auto;
            margin-right: auto;

        }

        .white-box-content {
            background-color: #FFF;
            border: 1px solid #e5e5e5;
            padding: 15px
        }

        .invoice header {
            margin-bottom: 16px;
        }

        .invoice .contacts {
            margin-bottom: 16px
        }

        .invoice .company-details,
        .invoice .invoice-details {
            text-align: right
        }

        .invoice .thanks {
            margin-top: 60px;
            margin-bottom: 30px
        }

        .invoice .footer {
            background-color: rgba(4, 97, 165, 0.05);
        }

        @media print {
            .invoice .notices {
                background-color: #F7F7F7 !important;
                -webkit-print-color-adjust: exact;
            }
        }

        .invoice table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .invoice table td, .invoice table th {
            padding: 15px;
        }

        .invoice table th {
            white-space: nowrap;
            font-weight: 500;
            background-color: rgba(4, 97, 165, 0.05);
        }

        @media print {
            .invoice table th {
                background-color: rgba(4, 97, 165, 0.05) !important;
                -webkit-print-color-adjust: exact;
            }
        }

        .invoice table tfoot td {
            background: 0 0;
            border: none;
            white-space: nowrap;
            text-align: right;
            padding: 8px 14px;
        }

        .invoice table tfoot tr:first-child td {
            padding-top: 16px;
        }

        .fw-700 {
            font-weight: 700;
        }

        .fs-9 {
            font-size: 9px !important;
        }

        .fs-8 {
            font-size: 8px !important;
        }

        .lh-1 {
            line-height: 1;
        }

        .rounded-12 {
            border-radius: 12px;
        }

        .fz-12 {
            font-size: 12px;
        }
        .d-flex {
            display: flex;
        }
        .flex-column {
            flex-direction: column;
        }

.border-bottom {
    border-bottom: 1px solid #e5e5e5
}
.text-right {
    text-align: right;
}
.text-left {
    text-align: left;
}
.text-center {
    text-align:center
}
h1, h2,h3,h4, h5, h6 {
    margin: 0
}
.p-0 {
    padding: 0 !important
}
    </style>
</head>
<body>
<div id="invoice">
    <div class="invoice d-flex flex-column">
        <div>
            <table>
                <tbody>
                <tr>
                    <td>
                        <h3 class="text-uppercase fw-700"><?php echo e(translate("invoice")); ?></h3>
                        <div><?php echo e(translate('Booking')); ?> #<?php echo e($booking->readable_id); ?></div>
                        <div><?php echo e(translate('date')); ?>: <?php echo e(date('d-M-Y h:ia',strtotime($booking->created_at))); ?></div>
                    </td>
                    <td class="company-details">
                        <a target="_blank" href="#">
                            <?php ($logo = getBusinessSettingsImageFullPath(key: 'business_logo', settingType: 'business_information', path: 'business/', defaultPath: 'public/assets/placeholder.png')); ?>
                            <img width="84" height="17"
                                 src="<?php echo e($logo); ?>" alt="<?php echo e(translate('logo')); ?>"
                                 data-holder-rendered="true"/>
                        </a>
                        <?php ($business_email = business_config('business_email','business_information')); ?>
                        <?php ($business_phone = business_config('business_phone','business_information')); ?>
                        <?php ($business_address = business_config('business_address','business_information')); ?>
                        <div class="mt-2"><?php echo e($business_address->live_values); ?></div>
                        <div><?php echo e($business_phone->live_values); ?></div>
                        <div><?php echo e($business_email->live_values); ?></div>
                    </td>
                </tr>
                </tbody>
            </table>

            <?php ($customer_name = $booking->customer ? $booking?->customer?->first_name.' '.$booking?->customer?->last_name : $booking?->service_address?->contact_person_name); ?>
            <?php ($customer_phone = $booking->customer ? $booking?->customer?->phone : $booking?->service_address?->contact_person_number); ?>

            <div class="white-box-content border rounded-12 border">
                <table>
                    <tr>
                        <td class="border-bottom p-0">
                            <table>
                                <tr>
                                <td>
                                    <div class="fs-9"><?php echo e(translate('Customer')); ?></div>
                                    <div><?php echo e($customer_name); ?></div>
                                </td>
                                <td>
                                    <div class="fs-9"><?php echo e(translate('phone')); ?></div>
                                    <div><?php echo e($customer_phone); ?></div>
                                </td>
                                <td>
                                    <div class="fs-9"><?php echo e(translate('email')); ?></div>
                                    <div><?php echo e($booking?->customer?->email); ?></div>
                                </td>
                                </tr>
                            </table>
                        </td>
                        <td class="border-bottom">
                            <div class="text-right">
                                <div><?php echo e(translate('Invoice of')); ?> (<?php echo e(currency_code()); ?>)</div>
                                <h5 style="font-size:20px; font-weight: 700;margin:0;color:#007bff"><?php echo e(with_currency_symbol($booking->total_booking_amount)); ?></h5>
                            </div>
                        </td>
                    </tr>
                </table>

                <div class="p-3">
                    <table>
                        <tr class="row contacts">
                            <td>
                                <div>
                                    <div class="fs-9"><?php echo e(translate('Payment')); ?></div>
                                    <div class="mt-1"><?php echo e(str_replace(['_', '-'], ' ', $booking->payment_method)); ?></div>
                                </div>
                                <div class="mt-3">
                                    <div class="fs-9"><?php echo e(translate('Reference ID')); ?></div>
                                    <div class="mt-1"><?php echo e($booking->readable_id); ?></div>
                                </div>
                            </td>

                            <td class="border-left">
                                <h6 class="fz-12"><?php echo e(translate('Service Address')); ?></h6>
                                <div class="fs-9">
                                    <?php if($booking->service_location == 'provider'): ?>
                                        <?php if($booking->provider_id != null): ?>
                                            <?php if($booking->provider): ?>
                                                <?php echo e(translate('Provider address')); ?> : <?php echo e($booking->provider->company_address ?? ''); ?>

                                            <?php else: ?>
                                                <?php echo e(translate('Provider Unavailable')); ?>

                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php echo e(translate('Provider address')); ?> : <?php echo e(translate('The Service Location will be available after this booking accepts or assign to a provider')); ?>

                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php echo e(translate('Customer address')); ?> : <?php echo e($booking?->service_address?->address??translate('not_available')); ?>

                                    <?php endif; ?>
                                </div>

                                <div class="fs-9" style="margin-left: 10px">
                                    <?php if($booking->service_location == 'provider'): ?>
                                        #<?php echo e(translate('Note')); ?> : <?php echo e(translate('Customer have to go to Service location')); ?> <b>(<?php echo e(translate('Provider location')); ?>)</b> <?php echo e(translate('in order to receive this service')); ?>

                                    <?php else: ?>
                                        #<?php echo e(translate('Note')); ?> : <?php echo e(translate('Provider will be arrived at Service location')); ?> <b>(<?php echo e(translate('Customer location')); ?>)</b> <?php echo e(translate('to provide the selected services')); ?>

                                    <?php endif; ?>
                                </div>
                            </td>

                            <td class="border-left">
                                <h6 class="fz-12"><?php echo e(translate('Service Time')); ?></h6>
                                <div class="fs-9"><?php echo e(translate('Request Date')); ?>

                                    : <?php echo e(date('d-M-Y h:ia',strtotime($booking->created_at))); ?></div>
                                <div class="fs-9"><?php echo e(translate('Service Date')); ?>

                                    : <?php echo e(date('d-M-Y h:ia',strtotime($booking->service_schedule))); ?></div>
                            </td>
                        </tr>
                    </table>

                    <table cellspacing="0" cellpadding="0">
                        <thead>
                        <tr>
                            <th class="text-left"><?php echo e(translate('SL')); ?></th>
                            <th class="text-left text-uppercase"><?php echo e(translate('description')); ?></th>
                            <th class="text-center text-uppercase"><?php echo e(translate('qty')); ?></th>
                            <th class="text-right text-uppercase"><?php echo e(translate('cost')); ?></th>
                            <th class="text-right text-uppercase"><?php echo e(translate('total')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php ($sub_total=0); ?>
                        <?php $__currentLoopData = $booking->detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="border-bottom text-left"><?php echo e((strlen($index+1)<2?'0':'').$index+1); ?></td>
                                <td class="border-bottom text-left">
                                    <div><?php echo e($item->service->name??''); ?></div>
                                    <div><?php echo e($item->variant_key); ?></div>
                                </td>
                                <td class="border-bottom text-center"><?php echo e($item->quantity); ?></td>
                                <td class="border-bottom text-right"><?php echo e(with_currency_symbol($item->service_cost)); ?></td>
                                <td class="border-bottom text-right"><?php echo e(with_currency_symbol($item->total_cost)); ?></td>
                            </tr>
                            <?php ($sub_total+=$item->service_cost*$item->quantity); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="3"></td>
                            <td class=""><?php echo e(translate('subtotal')); ?></td>
                            <td><?php echo e(with_currency_symbol($sub_total)); ?></td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td><?php echo e(translate('Discount')); ?></td>
                            <td>- <?php echo e(with_currency_symbol($booking->total_discount_amount)); ?></td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td><?php echo e(translate('Campaign_Discount')); ?></td>
                            <td>- <?php echo e(with_currency_symbol($booking->total_campaign_discount_amount)); ?></td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td class=""><?php echo e(translate('Coupon_Discount')); ?> </td>
                            <td>- <?php echo e(with_currency_symbol($booking->total_coupon_discount_amount)); ?></td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td class=""><?php echo e(translate('Referral_Discount')); ?> </td>
                            <td>- <?php echo e(with_currency_symbol($booking->total_referral_discount_amount)); ?></td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td class=""><?php echo e(translate('Vat_/_Tax')); ?> (%)</td>
                            <td>+ <?php echo e(with_currency_symbol($booking->total_tax_amount)); ?></td>
                        </tr>
                        <?php if($booking->extra_fee > 0): ?>
                            <?php ($additional_charge_label_name = business_config('additional_charge_label_name', 'booking_setup')->live_values??'Fee'); ?>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2" class="text-uppercase"><?php echo e($additional_charge_label_name); ?></td>
                                <td>+ <?php echo e(with_currency_symbol($booking->extra_fee)); ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td colspan="3"></td>
                            <td class="fw-700 border-top"><?php echo e(translate('Total')); ?></td>
                            <td class="fw-700 border-top"><?php echo e(with_currency_symbol($booking->total_booking_amount)); ?></td>
                        </tr>
                        <?php if($booking->booking_partial_payments->isNotEmpty()): ?>
                            <?php $__currentLoopData = $booking->booking_partial_payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="fw-700"><?php echo e(translate('Paid_by')); ?> <?php echo e(str_replace('_', ' ',$partial->paid_with)); ?></td>
                                    <td class="fw-700 border-top"><?php echo e(with_currency_symbol($partial->paid_amount)); ?></td>
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
                                <td colspan="3"></td>
                                <td class="fw-700"><?php echo e(translate('Due_Amount')); ?></td>
                                <td class="fw-700"><?php echo e(with_currency_symbol($dueAmount)); ?></td>
                            </tr>
                        <?php endif; ?>

                        <?php if($booking->payment_method != 'cash_after_service' && $booking->additional_charge < 0): ?>
                            <tr>
                                <td colspan="3"></td>
                                <td class="fw-700"><?php echo e(translate('Refund')); ?></td>
                                <td class="fw-700"><?php echo e(with_currency_symbol(abs($booking->additional_charge))); ?></td>
                            </tr>
                        <?php endif; ?>
                        </tfoot>
                    </table>
                </div>

                <div class="mt-5 text-center mb-4"><?php echo e(translate('Thanks for using our service')); ?>.</div>
            </div>
        </div>

        <div style="padding:24px 0">
            <div class="fw-700"><?php echo e(translate('Terms & Conditions')); ?></div>
            <div><?php echo e(translate('Change of mind is not applicable as a reason for refund')); ?></div>
        </div>

        <table class="footer">
            <tr>
                <td>
                    <div class="text-left">
                        <?php echo e(Request()->getHttpHost()); ?>

                    </div>
                </td>
                <td>
                    <div class="text-center">
                        <?php echo e($business_phone->live_values); ?>

                    </div>
                </td>
                <td>
                    <div class="text-right">
                        <?php echo e($business_email->live_values); ?>

                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

<script>
    "use strict";

    function printContent(el) {
        var restorepage = $('body').html();
        var printcontent = $('#' + el).clone();
        $('body').empty().html(printcontent);
        window.print();
        $('body').html(restorepage);
    }

    printContent('invoice');
</script>
</body>
</html>
<?php /**PATH /home/housecraft/public_html/Modules/BookingModule/Resources/views/admin/booking/invoice.blade.php ENDPATH**/ ?>