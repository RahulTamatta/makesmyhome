<?php $__env->startSection('title',translate('provider_details')); ?>

<?php $__env->startPush('css_or_js'); ?>


<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-title-wrap mb-3">
                <h2 class="page-title"><?php echo e(translate('Provider_Details')); ?></h2>
            </div>

            <div class="mb-3">
                <ul class="nav nav--tabs nav--tabs__style2">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='overview'?'active':''); ?>"
                           href="<?php echo e(url()->current()); ?>?web_page=overview"><?php echo e(translate('Overview')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='subscribed_services'?'active':''); ?>"
                           href="<?php echo e(url()->current()); ?>?web_page=subscribed_services"><?php echo e(translate('Subscribed_Services')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='bookings'?'active':''); ?>"
                           href="<?php echo e(url()->current()); ?>?web_page=bookings"><?php echo e(translate('Bookings')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='serviceman_list'?'active':''); ?>"
                           href="<?php echo e(url()->current()); ?>?web_page=serviceman_list"><?php echo e(translate('Service_Man_List')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='settings'?'active':''); ?>"
                           href="<?php echo e(url()->current()); ?>?web_page=settings"><?php echo e(translate('Settings')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='bank_information'?'active':''); ?>"
                           href="<?php echo e(url()->current()); ?>?web_page=bank_information"><?php echo e(translate('Bank_Information')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='reviews'?'active':''); ?>"
                           href="<?php echo e(url()->current()); ?>?web_page=reviews"><?php echo e(translate('Reviews')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($webPage=='subscription'?'active':''); ?>"
                           href="<?php echo e(url()->current()); ?>?web_page=subscription&provider_id=<?php echo e(request()->id); ?>"><?php echo e(translate('Business Plan')); ?></a>
                    </li>
                </ul>
            </div>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="boookings-tab-pane">
                    <div class="d-flex justify-content-end border-bottom mb-10">
                        <div class="d-flex gap-2 fw-medium pe--4">
                            <span class="opacity-75"><?php echo e(translate('Total_Bookings')); ?>:</span>
                            <span class="title-color"><?php echo e($bookings->total()); ?></span>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between">
                                <form action="<?php echo e(url()->current()); ?>?web_page=bookings"
                                      class="search-form search-form_style-two"
                                      method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="input-group search-form__input_group">
                                            <span class="search-form__icon">
                                                <span class="material-icons">search</span>
                                            </span>
                                        <input type="search" class="theme-input-style search-form__input"
                                               value="<?php echo e($search??''); ?>" name="search"
                                               placeholder="<?php echo e(translate('search_here')); ?>">
                                    </div>
                                    <button type="submit" class="btn btn--primary">
                                        <?php echo e(translate('search')); ?>

                                    </button>
                                </form>
                            </div>

                            <div class="table-responsive">
                                <table id="example" class="table align-middle">
                                    <thead>
                                    <tr>
                                        <th><?php echo e(translate('Booking_ID')); ?></th>
                                        <th><?php echo e(translate('Customer_Info')); ?></th>
                                        <th><?php echo e(translate('Total_Amount')); ?></th>
                                        <th><?php echo e(translate('Payment_Status')); ?></th>
                                        <th><?php echo e(translate('Schedule_Date')); ?></th>
                                        <th><?php echo e(translate('Booking_Date')); ?></th>
                                        <th><?php echo e(translate('Action')); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <a href="<?php echo e(route('admin.booking.details', [$booking->id,'web_page'=>'details'])); ?>">
                                                    <?php echo e($booking->readable_id); ?></a>
                                            </td>
                                            <td>
                                                <?php if(isset($booking->customer)): ?>
                                                    <div>
                                                        <a href="<?php echo e(route('admin.customer.detail',[$booking->customer->id, 'web_page'=>'overview'])); ?>">
                                                            <?php echo e(Str::limit($booking->customer->first_name, 30)); ?>

                                                        </a>
                                                    </div>
                                                    <?php echo e($booking->customer->phone??""); ?>

                                                <?php else: ?>
                                                    <span class="opacity-50"><?php echo e(translate('Customer_not_available')); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($booking->total_booking_amount); ?></td>
                                            <td>
                                                <span class="badge badge badge-<?php echo e($booking->is_paid?'success':'danger'); ?> radius-50">
                                                    <span class="dot"></span>
                                                    <?php echo e($booking->is_paid?translate('paid'):translate('unpaid')); ?>

                                                </span>
                                            </td>
                                            <td><?php echo e(date('d-M-Y h:ia',strtotime($booking->service_schedule))); ?></td>
                                            <td><?php echo e(date('d-M-Y h:ia',strtotime($booking->created_at))); ?></td>
                                            <td>
                                                <div class="table-actions">
                                                    <a href="<?php echo e(route('admin.booking.details', [$booking->id,'web_page'=>'details'])); ?>"
                                                       type="button"
                                                       class="table-actions_view btn btn--light-primary fw-medium text-capitalize fz-14">
                                                        <span class="material-icons">visibility</span>
                                                        <?php echo e(translate('View_Details')); ?>

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
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/ProviderManagement/Resources/views/admin/provider/detail/bookings.blade.php ENDPATH**/ ?>