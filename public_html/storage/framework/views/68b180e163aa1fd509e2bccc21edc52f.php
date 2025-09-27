<div class="settings-sidebar">
    <div class="settings-toggle-icon">
        <span class="material-icons">settings</span>
    </div>
    <div class="settings-content">
        <h4><?php echo e(translate('Settings')); ?></h4>
        <div class="switchers-wrap">
            <div class="switch-items">
                <div class="setting-box-wrap">
                    <div class="setting-box active light-mode">
                        <img src="<?php echo e(asset('public/assets/provider-module')); ?>/img/light-mode.png" width="36px" alt="<?php echo e(translate('provider-module')); ?>">
                    </div>
                    <h5><?php echo e(translate('Light_Mode')); ?></h5>
                </div>
                <div class="setting-box-wrap">
                    <div class="setting-box dark-mode">
                        <img src="<?php echo e(asset('public/assets/provider-module')); ?>/img/dark-mode.png" width="36px" alt="<?php echo e(translate('provider-module')); ?>">
                    </div>
                    <h5><?php echo e(translate('Dark_Mode')); ?></h5>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/housecraft/public_html/Modules/ProviderManagement/Resources/views/layouts/partials/_settings-sidebar.blade.php ENDPATH**/ ?>