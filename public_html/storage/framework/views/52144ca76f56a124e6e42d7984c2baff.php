<li class="nav-item">
    <a class="nav-link <?php echo e($webPage=='google_map'?'active':''); ?>"
       href="<?php echo e(url('admin/configuration/get-third-party-config')); ?>?web_page=google_map">
        <?php echo e(translate('Map Api')); ?>

    </a>
</li>
<li class="nav-item">
    <a
        class="nav-link <?php echo e($webPage=='push_notification'?'active':''); ?>"
        href="<?php echo e(url('admin/configuration/get-third-party-config')); ?>?web_page=push_notification">
        <?php echo e(translate('firebase_notification_setup')); ?>

    </a>
</li>
<li class="nav-item">
    <a class="nav-link <?php echo e($webPage=='recaptcha'?'active':''); ?>"
       href="<?php echo e(url('admin/configuration/get-third-party-config')); ?>?web_page=recaptcha">
        <?php echo e(translate('recaptcha')); ?>

    </a>
</li>
<li class="nav-item">
    <a class="nav-link <?php echo e($webPage=='apple_login'?'active':''); ?>"
       href="<?php echo e(url('admin/configuration/get-third-party-config')); ?>?web_page=apple_login">
        <?php echo e(translate('apple_login')); ?>

    </a>
</li>

<li class="nav-item">
    <a class="nav-link <?php echo e($webPage=='email_config' || $webPage == 'test_mail' ?'active':''); ?>"
       href="<?php echo e(url('admin/configuration/get-third-party-config')); ?>?web_page=email_config">
        <?php echo e(translate('email_config')); ?>

    </a>
</li>

<li class="nav-item">
    <a class="nav-link <?php echo e($webPage=='sms_config'?'active':''); ?>"
       href="<?php echo e(url('admin/configuration/get-third-party-config')); ?>?web_page=sms_config">
        <?php echo e(translate('Sms Config')); ?>

    </a>
</li>

<li class="nav-item">
    <a class="nav-link <?php echo e($webPage == 'payment_config' ? 'active' : ''); ?>" href="<?php echo e(request()->is('admin/configuration/offline-payment/*') ? url('admin/configuration/offline-payment/list?web_page=payment_config&type=offline_payment') : url('admin/configuration/get-third-party-config?web_page=payment_config&type=digital_payment')); ?>">
        <?php echo e(translate('Payment Config')); ?>

    </a>
</li>

<li class="nav-item">
    <a class="nav-link <?php echo e($webPage=='storage_connection'?'active':''); ?>"
       href="<?php echo e(url('admin/configuration/get-third-party-config')); ?>?web_page=storage_connection">
        <?php echo e(translate('Storage Connection')); ?>

    </a>
</li>

<li class="nav-item">
    <a class="nav-link <?php echo e($webPage=='app_settings'?'active':''); ?>"
       href="<?php echo e(url('admin/configuration/get-third-party-config')); ?>?web_page=app_settings">
        <?php echo e(translate('App Settings')); ?>

    </a>
</li>

<li class="nav-item">
    <a class="nav-link <?php echo e($webPage=='firebase_otp_verification'?'active':''); ?>"
       href="<?php echo e(url('admin/configuration/get-third-party-config')); ?>?web_page=firebase_otp_verification">
        <?php echo e(translate('firebase_auth_verification')); ?>

    </a>
</li>
<?php /**PATH /home/housecraft/public_html/Modules/BusinessSettingsModule/Resources/views/admin/partials/third-party-partial.blade.php ENDPATH**/ ?>