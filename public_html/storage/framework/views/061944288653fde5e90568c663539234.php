<?php $__env->startPush('css_or_js'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/select.dataTables.min.css"/>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                     
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">subscription list</h3>
                            <div class="card-tools">
                                <a href="<?php echo e(route('admin.subscriptionmodule.create')); ?>" class="btn btn-primary">Add Subscription</a>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table id="subscriptionTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>image</th>
                                        <th>name</th>
                                        <th>price</th>
                                        <th>status</th>
                                        <th>Duration</th>
                                        <th>actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    
                                        <tr>
                                            <td><?php echo e($subscription->id); ?></td>
                                            <td><img src="<?php echo e($subscription->image); ?>" width="50"/></td>
                                            <td><?php echo e($subscription->name); ?></td>
                                            <td><?php echo e($subscription->price); ?></td>
                                            <td><?php echo e($subscription->status); ?></td>
                                            <td><?php echo e($subscription->duration); ?> days</td>
                                            
                                            <td>
                                                <a href="<?php echo e(route('admin.subscriptionmodule.edit', $subscription->id)); ?>" class="btn btn-warning">edit</a>
                                                <a href="<?php echo e(route('admin.subscriptionmodule.delete', $subscription->id)); ?>" class="btn btn-danger">delete</a>
                                                <a href="<?php echo e(route('admin.subscriptionmodule.view', $subscription->id)); ?>" class="btn btn-info">view</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/select2/select2.min.js"></script>
    <script>
        "use strict"

        $(document).ready(function () {
            $('.js-select').select2();
        });
    </script>
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/jquery.dataTables.min.js"></script>
    <script src="<?php echo e(asset('public/assets/admin-module')); ?>/plugins/dataTables/dataTables.select.min.js"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/SubscriptionModule/Resources/views/list.blade.php ENDPATH**/ ?>