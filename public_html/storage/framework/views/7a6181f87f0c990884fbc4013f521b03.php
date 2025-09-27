<div class="accordion mb-30" id="accordionExample">
    <?php if($faqs->count() < 1): ?>
        <img src="<?php echo e(asset('public/assets/admin-module/img/icons/faq.png')); ?>" class="mb-4"
             alt="<?php echo e(translate('faq')); ?>">
        <h3 class="text-muted"><?php echo e(translate('no_faq_added_yet')); ?></h3>
    <?php endif; ?>
    <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <form action="<?php echo e(route('admin.faq.update',[$faq->id])); ?>" method="POST" class="mb-30 hide-div"
              id="edit-<?php echo e($faq->id); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="form-floating mb-30">
                <input type="text" class="form-control" placeholder="<?php echo e(translate('question')); ?>" name="question"
                       value="<?php echo e($faq->question); ?>"
                       required="">
                <label><?php echo e(translate('question')); ?></label>
            </div>
            <div class="form-floating mb-30">
                <textarea class="form-control" placeholder="<?php echo e(translate('answer')); ?>"
                          name="answer"><?php echo e($faq->answer); ?></textarea>
                <label><?php echo e(translate('answer')); ?></label>
            </div>
            <div class="d-flex justify-content-end ">
                <button type="button" class="btn btn--primary service-faq-update"
                        data-id="edit-<?php echo e($faq->id); ?>">
                    <?php echo e(translate('update_faq')); ?>

                </button>
            </div>
        </form>

        <div class="accordion-item">
            <div class="accordion-header d-flex flex-wrap flex-sm-nowrap gap-3"
                 id="headingOne">
                <button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#faq_<?php echo e($faq->id); ?>"
                        aria-expanded="false" aria-controls="<?php echo e($faq->id); ?>">
                    <?php echo e($faq->question); ?>

                </button>
                <div class="btn-group d-flex gap-3 align-items-center">
                    <div>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('service_manage_status')): ?>
                        <label class="switcher" data-bs-toggle="modal" data-bs-target="#deactivateAlertModal">
                            <input class="switcher_input service-ajax-status-update" type="checkbox" <?php echo e($faq->is_active?'checked':''); ?>

                            data-route="<?php echo e(route('admin.faq.status-update',[$faq->id])); ?>"
                                   data-id="faq-list">
                            <span class="switcher_control"></span>
                        </label>
                            <?php endif; ?>
                    </div>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('service_update')): ?>
                    <button type="button"
                            data-id="<?php echo e($faq->id); ?>"
                            class="accordion-edit-btn bg-transparent border-0 p-0 show-service-edit-section">
                        <span class="material-icons">border_color</span>
                    </button>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('service_delete')): ?>
                    <button type="button"
                            class="accordion-delete-btn bg-transparent border-0 p-0 faq-list-ajax-delete"
                            data-route="<?php echo e(route('admin.faq.delete',[$faq->id,$faq->service_id])); ?>">
                        <span class="material-icons">delete</span>
                    </button>
                        <?php endif; ?>
                </div>
            </div>
            <div id="faq_<?php echo e($faq->id); ?>" class="accordion-collapse collapse"
                 aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <?php echo e($faq->answer); ?>

                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php if (! $__env->hasRenderedOnce('4c007b86-4fdb-403b-a10e-a75c2b6f1416')): $__env->markAsRenderedOnce('4c007b86-4fdb-403b-a10e-a75c2b6f1416'); ?>
    <script>
        $(".faq-list-ajax-delete").on('click', function (){
            let route = $(this).data('route');
            ajax_delete(route)
        })

        $(".service-faq-update").on('click', function (){
            let id = $(this).data('id');
            ajax_post(id)
        })

        $(".show-service-edit-section").on('click', function (){
            let id = $(this).data('id');
            $(`#edit-${id}`).toggle();
        })
    </script>
<?php endif; ?>


<?php /**PATH /home/housecraft/public_html/Modules/ServiceManagement/Resources/views/admin/partials/_faq-list.blade.php ENDPATH**/ ?>