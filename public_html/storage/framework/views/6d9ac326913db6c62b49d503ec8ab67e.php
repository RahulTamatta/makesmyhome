<?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <a href="#" class="dropdown-item-text media gap-3">
        <div class="avatar title-color hover-color-c2">
            <span class="material-icons">notifications</span>
        </div>
        <div class="media-body ">
            <img src="<?php echo e($notification->cover_image_full_path); ?>"
                 class="avatar rounded-circle" alt="<?php echo e(translate('image')); ?>">
            <h5 class="card-title"><?php echo e($notification->title); ?></h5>
            <p class="card-text fz-14 mb-2"><?php echo e($notification->description); ?></p>
            <?php
                $to_time = strtotime($notification->created_at);
                $from_time = strtotime(now());
                $diff = round(abs($to_time - $from_time) / 60,2);
                $time = $diff .' '.translate('min');
                if ($diff>60){
                    $diff = round($diff/60);
                    $time = $diff.' '.translate('hr');
                    if ($diff>24){
                        $diff = round($diff/24);
                        $time = $diff.' '.translate('day');
                         if ($diff>30){
                            $diff = round($diff/30);
                            $time = $diff.' '.translate('month');
                             if ($diff>12){
                                $diff = round($diff/12);
                                $time = $diff.' '.translate('year');
                            }
                        }
                    }
                }
            ?>
            <span class="card-text fz-12 text-opacity-75"><?php echo e($time); ?> <?php echo e(translate('ago')); ?></span>
        </div>
    </a>
    <div class="dropdown-divider"></div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/housecraft/public_html/Modules/ProviderManagement/Resources/views/provider/partials/_notifications.blade.php ENDPATH**/ ?>