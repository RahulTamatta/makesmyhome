


<?php $__env->startPush('css_or_js'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin-module')); ?>/plugins/select2/select2.min.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin-module')); ?>/plugins/dataTables/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin-module')); ?>/plugins/wysiwyg-editor/froala_editor.min.css"/>
    <style>
        .service-row {
            margin-bottom: 15px;
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            position: relative;
        }
        .remove-service {
            position: absolute;
            right: 10px;
            top: 10px;
            cursor: pointer;
            color: #ff0000;
        }
        #add-service-btn {
            margin-bottom: 20px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-wrap mb-3">
                    <h2 class="page-title">Edit Subscription Plan</h2>
                </div>

                <div class="card">
                    <div class="card-body p-30">
                        <form action="<?php echo e(route('admin.subscriptionmodule.update', $plan->id)); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-30">
                                        <div class="form-floating form-floating__icon">
                                            <input type="text" class="form-control" name="name" value="<?php echo e($plan->name); ?>" required>
                                            <label>Plan Name *</label>
                                            <span class="material-icons">title</span>
                                        </div>
                                    </div>
                                    <div class="mb-30">
                                        <div class="form-floating form-floating__icon">
                                            <input type="number" class="form-control" name="price" min="0" step="0.01" value="<?php echo e($plan->price); ?>" required>
                                            <label>Price *</label>
                                            <span class="material-icons">attach_money</span>
                                        </div>
                                    </div>

                                    <div class="mb-30">
                                        <div class="form">
                                            <label>Subscription Status *</label>
                                            <select class="form-select" name="status" required>
                                                <option value="active" <?php echo e($plan->status == 'active' ? 'selected' : ''); ?>>Active</option>
                                                <option value="inactive" <?php echo e($plan->status == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-30">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" name="duration" value="<?php echo e($plan->duration); ?>">
                                            <label>Duration *(days)</label>
                                        </div>
                                    </div>
                                     <div class="mb-30">
                                                <div class="form-floating">
                                                    <input type="file" class="form-control" name="image" 
                                                           placeholder="start_date">
                                                    <label>Picture *(</label>
                                                </div>
                                            </div>
                                </div>

                                <!-- Services Section -->
                                <div class="col-12">
                                    <h4 class="mb-3">Services</h4>
                                    <div id="services-container">
                                       
                                       
                                     
                                         
                                        <?php $__currentLoopData = $slectedservices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $serviceId): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       
                                            <div class="service-row">
                                                
                                                    <span class="remove-service material-icons" title="Remove service">close</span>
                                                
                                                <div class="form">
                                                    <label>Service *</label>
                                                    <select class="form-select" name="services[]" required>
                                                        <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($service->id); ?>" <?php echo e($service->id == $serviceId->service_id ? 'selected' : ''); ?>>
                                                                <?php echo e($service->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                             
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                    </div>
                                    <button type="button" id="add-service-btn" class="btn btn--primary">
                                        <i class="material-icons">add</i> Add Another Service
                                    </button>
                                </div>

                                <!-- Description Fields -->
                                <div class="col-12">
                                    <div class="form-floating mb-30">
                                        <textarea class="form-control" name="description" rows="5"><?php echo e($plan->description); ?></textarea>
                                        <label>Description</label>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-3 mt-4">
                                    <a href="<?php echo e(route('admin.subscriptionmodule.list')); ?>" class="btn btn--secondary">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn--primary">
                                        Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        const services = <?php echo json_encode($services); ?>;

        $('#add-service-btn').on('click', function () {
            let options = '';
            services.forEach(service => {
                options += `<option value="${service.id}">${service.name}</option>`;
            });

            const newRow = `
                <div class="service-row">
                    <span class="remove-service material-icons" title="Remove service">close</span>
                    <div class="form">
                        <label>Service *</label>
                        <select class="form-select" name="services[]" required>
                            ${options}
                        </select>
                    </div>
                </div>`;

            $('#services-container').append(newRow);
        });

        $(document).on('click', '.remove-service', function () {
            if ($('.service-row').length > 1) {
                $(this).closest('.service-row').remove();
            } else {
                toastr.error('At least one service is required');
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/SubscriptionModule/Resources/views/edit.blade.php ENDPATH**/ ?>