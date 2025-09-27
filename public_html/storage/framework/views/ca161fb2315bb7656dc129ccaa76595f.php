<?php $__env->startSection('title',translate('My_Subscriptions')); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap mb-3">
                        <h2 class="page-title"><?php echo e(translate('My_Subscriptions')); ?></h2>
                    </div>

                    <div
                        class="d-flex flex-wrap justify-content-between align-items-center border-bottom mx-lg-4 mb-10 gap-3">
                        <ul class="nav nav--tabs">
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($status == 'all' ? 'active' : ''); ?>"
                                   href="<?php echo e(url()->current()); ?>?status=all"><?php echo e(translate('All')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($status == 'subscribed' ? 'active' : ''); ?>"
                                   href="<?php echo e(url()->current()); ?>?status=subscribed"><?php echo e(translate('Subscribed_Sub_categories')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($status == 'unsubscribed' ? 'active' : ''); ?>"
                                   href="<?php echo e(url()->current()); ?>?status=unsubscribed"><?php echo e(translate('Unsubscribed_Sub_categories')); ?></a>
                            </li>
                        </ul>

                        <div class="d-flex gap-2 fw-medium">
                            <span class="opacity-75"><?php echo e(translate('Total_Sub_Categories')); ?>:</span>
                            <span class="title-color"><?php echo e($subscribedSubCategories->total()); ?></span>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example" class="table align-middle">
                                            <thead>
                                            <tr>
                                                <th><?php echo e(translate('SL')); ?></th>
                                                <th><?php echo e(translate('Sub_Category_Name')); ?></th>
                                                <th><?php echo e(translate('Category')); ?></th>
                                                <th><?php echo e(translate('Services')); ?></th>
                                                <th class="text-center"><?php echo e(translate('Action')); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $__currentLoopData = $subscribedSubCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$sub_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($subscribedSubCategories->firstitem()+$key); ?></td>
                                                    <td><?php echo e(Str::limit($sub_category->sub_category['name']??translate('Unavailable'), 30)); ?></td>
                                                    <td><?php echo e(Str::limit($sub_category->category['name']??translate('Unavailable'), 30)); ?></td>
                                                    <td>
                                                        <div
                                                            class="service-details-info-wrap d-inline-block position-relative cursor-pointer">
                                                            <div><?php echo e($sub_category->sub_category->services_count ?? 0); ?></div>

                                                            <?php if($sub_category->services): ?>
                                                            <div
                                                                class="service-details-info bg-dark p-2 rounded shadow">
                                                                <?php $__currentLoopData = $sub_category->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <div class="media gap-2 align-items-center">
                                                                        <img width="40" class="rounded" src="<?php echo e($service->thumbnail_full_path); ?>" alt="<?php echo e(translate('image')); ?>">

                                                                        <div class="media-body text-white">
                                                                            <h6 class="text-white"><?php echo e(\Illuminate\Support\Str::limit($service->name,15)); ?></h6>
                                                                            <div class="fs-10"><?php echo e(translate('Up to: ')); ?>

                                                                                    $<?php echo e($service->variations->first()->price); ?>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <form action="javascript:void(0)" method="post" class="hide-div"
                                                              id="form-<?php echo e($sub_category->id); ?>">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('put'); ?>
                                                            <input name="sub_category_id"
                                                                   value="<?php echo e($sub_category->sub_category_id); ?>">
                                                        </form>
                                                        <?php if($sub_category->is_subscribed == 1): ?>
                                                            <button type="button" class="btn btn--danger subscribe-btn"
                                                                    id="button-<?php echo e($sub_category->id); ?>"
                                                                    data-subcategory="<?php echo e($sub_category->id); ?>">
                                                                <?php echo e(translate('unsubscribe')); ?>

                                                            </button>
                                                        <?php else: ?>
                                                            <button type="button" class="btn btn--primary subscribe-btn"
                                                                    id="button-<?php echo e($sub_category->id); ?>"
                                                                    data-subcategory="<?php echo e($sub_category->id); ?>">
                                                                <?php echo e(translate('subscribe')); ?>

                                                            </button>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <?php echo $subscribedSubCategories->links(); ?>

                                    </div>
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
        "use strict";

        $('.subscribe-btn').on('click', function () {
            let id = $(this).data('subcategory');
            update_subscription(id)
        });

        function update_subscription(id) {

            var form = $('#form-' + id)[0];
            var formData = new FormData(form);

            Swal.fire({
                title: "<?php echo e(translate('are_you_sure')); ?>?",
                text: "<?php echo e(translate('want_to_update_subscription')); ?>",
                type: 'warning',
                showCloseButton: true,
                showCancelButton: true,
                cancelButtonColor: 'var(--c2)',
                confirmButtonColor: 'var(--c1)',
                cancelButtonText: '<?php echo e(translate('cancel')); ?>',
                confirmButtonText: '<?php echo e(translate('yes')); ?>',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    send_request(formData, id);
                }
            })
        }

        function update_view(id) {
            const subscribe_button = $('#button-' + id);
            if (subscribe_button.hasClass('btn--danger')) {
                subscribe_button.removeClass('btn--danger').addClass('btn--primary').text('<?php echo e(translate('subscribe')); ?>');
            } else {
                subscribe_button.removeClass('btn--primary').addClass('btn--danger').text('<?php echo e(translate('unsubscribe')); ?>');
            }
            subscribe_button.blur();
        }


        function send_request(formData, id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "<?php echo e(route('provider.service.update-subscription')); ?>",
                data: formData,
                processData: false,
                contentType: false,
                type: 'post',
                beforeSend: function () {
                    $('.preloader').show()
                },
                success: function (response) {
                    if (response.response_code === 'default_200') {
                        toastr.success('successfully data fetched');
                        update_view(id)

                    } else if(response.response_code === 'default_204'){
                        toastr.warning('<?php echo e(translate('this_category_is_not_available_in_your_zone')); ?>')

                    } else {
                        toastr.error('<?php echo e(translate('your_subscription_package_category_limit_has_ended')); ?>');
                    }
                    location.reload();
                },
                error: function (response) {
                    toastr.error('<?php echo e(translate('your_subscription_package_category_limit_has_ended')); ?>')
                },
                complete: function () {
                    $('.preloader').hide()
                }
            });
            return is_success;
        }
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('providermanagement::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/ProviderManagement/Resources/views/subscribedSubCategory.blade.php ENDPATH**/ ?>