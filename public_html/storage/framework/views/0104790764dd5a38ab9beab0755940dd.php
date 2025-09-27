

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
                        <h2 class="page-title">Add New Subscription Plan</h2>
                    </div>

                    <div class="card">
                        <div class="card-body p-30">
                            <div>
                                <?php ($language= Modules\BusinessSettingsModule\Entities\BusinessSettings::where('key_name','system_language')->first()); ?>
                                <?php ($default_lang = str_replace('_', '-', app()->getLocale())); ?>
                                
                                <?php if($language): ?>
                                    <ul class="nav nav--tabs border-color-primary mb-4">
                                        <li class="nav-item">
                                            <a class="nav-link lang_link active"
                                               href="#"
                                               id="default-link">Default</a>
                                        </li>
                                        <?php $__currentLoopData = $language?->live_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="nav-item">
                                                <a class="nav-link lang_link"
                                                   href="#"
                                                   id="<?php echo e($lang['code']); ?>-link"><?php echo e(get_language_name($lang['code'])); ?></a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php endif; ?>
                                
                                <form action="<?php echo e(route('admin.subscriptionmodule.store')); ?>" method="post" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-30">
                                                <div class="form-floating form-floating__icon">
                                                    <input type="text" class="form-control" name="name" required
                                                           placeholder="Plan Name *">
                                                    <label>Plan Name *</label>
                                                    <span class="material-icons">title</span>
                                                </div>
                                            </div>
                                            <div class="mb-30">
                                                <div class="form-floating form-floating__icon">
                                                    <input type="number" class="form-control" name="price" min="0"
                                                           step="0.01" required
                                                           placeholder="price *">
                                                    <label>Price *</label>
                                                    <span class="material-icons">attach_money</span>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-30">
                                                <div class="form">
                                                    <label>Subscription Status *</label>
                                                    <select class="form-select" name="status" required>
                                                        <option value="active">Active</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-30">
                                                <div class="form-floating">
                                                    <input type="number" class="form-control" name="duration" 
                                                           placeholder="start_date">
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
                                                <!-- First service row -->
                                                <div class="service-row">
                                                    <div class="form">
                                                        <label>Service *</label>
                                                        <select class="form-select" name="services[]" required>
                                                            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($service->id); ?>"><?php echo e($service->name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" id="add-service-btn" class="btn btn--primary">
    <i class="material-icons">add</i> Add Another Service
</button>
                                        </div>

                                        <!-- Description Fields -->
                                        <div class="col-12">
                                            <div class="form-floating mb-30">
                                                <textarea class="form-control" name="description" rows="5"
                                                          placeholder="Description"></textarea>
                                                <label>Description</label>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end gap-3 mt-4">
                                            <button type="reset" class="btn btn--secondary">
                                                Reset
                                            </button>
                                            <button type="submit" class="btn btn--primary">
                                                Submit
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
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>

    <script>
        
           
            // Initialize TinyMCE for description fields
          

    $(document).ready(function () {
        // Add service row
        $('#add-service-btn').on('click', function() {
            const services = <?php echo json_encode($services); ?>;

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

        // Remove service row
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
<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/SubscriptionModule/Resources/views/create.blade.php ENDPATH**/ ?>